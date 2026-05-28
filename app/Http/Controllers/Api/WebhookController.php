<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handlePayment(Request $request, PaymentService $paymentService)
    {
        Log::info('Payment Webhook received', $request->all());

        // Basic verification (in production, verify signature here)
        
        try {
            $handled = $paymentService->handleWebhook($request->all());
            
            if ($handled) {
                return response()->json(['status' => 'success', 'message' => 'Webhook handled successfully']);
            }
            
            return response()->json(['status' => 'ignored', 'message' => 'Webhook ignored or order not found'], 200);
        } catch (\Exception $e) {
            Log::error('Payment webhook error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function handleShipping(Request $request)
    {
        Log::info('Shipping Webhook received', $request->all());
        // Handle courier status updates here
        return response()->json(['status' => 'success']);
    }
}
