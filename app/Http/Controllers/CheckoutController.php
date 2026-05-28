<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
        private PaymentService $paymentService,
        private ShippingService $shippingService
    ) {
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong');
        }

        $addresses = Auth::user()->addresses;
        
        // Auto-create dummy address for development if none exists
        if ($addresses->isEmpty()) {
            $dummyAddress = Auth::user()->addresses()->create([
                'label' => 'Rumah',
                'recipient_name' => Auth::user()->name,
                'phone' => '081234567890',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'district' => 'Coblong',
                'postal_code' => '40132',
                'address_detail' => 'Jl. Ir. H. Juanda No. 100, Dago',
                'is_primary' => true
            ]);
            $addresses->push($dummyAddress);
        }

        $provinces = $this->shippingService->getProvinces();

        return view('checkout.index', compact('cart', 'addresses', 'provinces'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'courier' => 'required|string',
            'service' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $cart = $this->cartService->getCart();
        $address = Auth::user()->addresses()->findOrFail($request->address_id);
        
        try {
            $order = $this->orderService->createFromCart(
                $cart->items->pluck('id')->toArray(),
                $address->toShippingArray(),
                $request->courier,
                $request->service,
                $request->shipping_cost,
                $request->voucher_code ?? null,
                $request->notes ?? ''
            );

            $paymentData = $this->paymentService->initiate($order);

            if ($paymentData['type'] === 'dummy') {
                return redirect($paymentData['payment_url']);
            }

            // Real midtrans snap redirect logic here
            return redirect()->route('buyer.orders.show', $order)->with('success', 'Pesanan dibuat. Silakan bayar.');
            
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function dummyPayment($orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)->firstOrFail();
        return view('checkout.dummy-payment', compact('order'));
    }

    public function processDummyPayment(Request $request, $orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)->firstOrFail();
        
        if ($request->action === 'pay') {
            $this->paymentService->processDummy($order, true);
            return redirect()->route('buyer.orders.show', $order)->with('success', 'Pembayaran berhasil!');
        }
        
        $this->paymentService->processDummy($order, false);
        return redirect()->route('buyer.orders.show', $order)->with('error', 'Pembayaran dibatalkan!');
    }
}
