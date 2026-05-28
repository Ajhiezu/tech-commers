@extends('layouts.marketplace')

@section('content')
<div class="container mx-auto px-4 py-12 flex justify-center">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 w-full max-w-md p-8 text-center">
        <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Simulasi Pembayaran</h2>
        <p class="text-gray-500 mb-6 text-sm">Mode Developer (Dummy Payment Gateway)</p>
        
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
            <div class="flex justify-between mb-2">
                <span class="text-gray-500 text-sm">No. Pesanan</span>
                <span class="font-bold text-gray-800">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between border-t pt-2 mt-2">
                <span class="text-gray-500 text-sm">Total Bayar</span>
                <span class="font-bold text-primary text-xl">@rupiah($order->total)</span>
            </div>
        </div>
        
        <form action="{{ route('checkout.process-dummy', $order->order_number) }}" method="POST" class="space-y-3">
            @csrf
            <button type="submit" name="action" value="pay" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition">
                Simulasikan Berhasil (Sukses)
            </button>
            <button type="submit" name="action" value="fail" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-lg transition">
                Simulasikan Gagal (Batal)
            </button>
        </form>
    </div>
</div>
@endsection
