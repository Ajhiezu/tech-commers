<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Initiate a payment — returns payment data including redirect/token.
     * In dev: returns dummy payment data.
     * In prod: integrate Midtrans Snap.
     */
    public function initiate(Order $order): array
    {
        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_number' => 'PAY-' . strtoupper(Str::random(10)),
                'method'         => 'bank_transfer',
                'gateway'        => 'dummy',
                'amount'         => $order->total,
                'status'         => PaymentStatus::Pending,
                'expired_at'     => now()->addDay(),
            ]
        );

        // Dummy mode — always use this in dev
        if (config('services.midtrans.enabled', false) === false) {
            return [
                'type'           => 'dummy',
                'payment_number' => $payment->payment_number,
                'amount'         => $order->total,
                'expired_at'     => $payment->expired_at,
                'payment_url'    => route('checkout.dummy-payment', $order->order_number),
            ];
        }

        // TODO: Real Midtrans Snap integration
        return ['type' => 'midtrans', 'snap_token' => null];
    }

    /**
     * Process dummy payment (for development/testing).
     */
    public function processDummy(Order $order, bool $success = true): bool
    {
        $payment = $order->payment;
        if (!$payment) return false;

        if ($success) {
            $payment->update([
                'status'  => PaymentStatus::Success,
                'paid_at' => now(),
                'gateway_response' => ['dummy' => true, 'approved_at' => now()->toIso8601String()],
            ]);

            $order->update([
                'status'  => OrderStatus::Paid,
                'paid_at' => now(),
            ]);

            return true;
        }

        $payment->update(['status' => PaymentStatus::Failed]);
        return false;
    }

    /**
     * Handle Midtrans webhook notification.
     */
    public function handleWebhook(array $payload): bool
    {
        $orderId    = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;

        if (!$orderId) return false;

        // Find order by payment number
        $payment = Payment::where('payment_number', $orderId)->first();
        if (!$payment) return false;

        $transactionStatus = $payload['transaction_status'] ?? 'pending';
        $fraudStatus       = $payload['fraud_status'] ?? 'accept';

        if (($transactionStatus === 'capture' && $fraudStatus === 'accept') ||
            $transactionStatus === 'settlement') {

            $payment->update([
                'status'                 => PaymentStatus::Success,
                'paid_at'                => now(),
                'gateway_transaction_id' => $payload['transaction_id'] ?? null,
                'gateway_response'       => $payload,
            ]);

            $payment->order->update([
                'status'  => OrderStatus::Paid,
                'paid_at' => now(),
            ]);

        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $payment->update([
                'status'           => PaymentStatus::Failed,
                'gateway_response' => $payload,
            ]);
        }

        return true;
    }
}
