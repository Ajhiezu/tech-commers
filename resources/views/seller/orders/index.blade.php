@extends('layouts.seller')

@section('content')
<!-- Page Header -->
<div class="page-header-neu">
    <div>
        <div class="inline-block badge-orange mb-2">PESANAN</div>
        <h1 class="page-title-neu">Manajemen Pesanan</h1>
        <p class="text-sm font-semibold text-gray-500 mt-1">Kelola semua pesanan masuk ke toko Anda.</p>
    </div>
</div>

<!-- Status Filter Tabs -->
<div class="flex gap-2 mb-6 overflow-x-auto pb-1">
    <a href="{{ route('seller.orders.index') }}"
       class="px-4 py-2 border-3 border-neu-black font-black text-xs uppercase tracking-wider whitespace-nowrap transition-colors
              {{ !request('status') ? 'bg-neu-black text-neu-yellow' : 'bg-white text-neu-black hover:bg-neu-yellow' }}"
       style="{{ !request('status') ? 'box-shadow: 3px 3px 0 #FFE600' : 'box-shadow: 3px 3px 0 #0D0D0D' }}">
        Semua
    </a>
    @foreach($statuses as $status)
    <a href="{{ route('seller.orders.index', ['status' => $status->value]) }}"
       class="px-4 py-2 border-3 border-neu-black font-black text-xs uppercase tracking-wider whitespace-nowrap transition-colors
              {{ request('status') === $status->value ? 'bg-neu-black text-neu-yellow' : 'bg-white text-neu-black hover:bg-neu-yellow' }}"
       style="{{ request('status') === $status->value ? 'box-shadow: 3px 3px 0 #FFE600' : 'box-shadow: 3px 3px 0 #0D0D0D' }}">
        {{ $status->label() }}
    </a>
    @endforeach
</div>

<!-- Orders List -->
<div class="space-y-4">
    @forelse($orders as $order)
    <div class="card-neu p-0 overflow-hidden">
        <!-- Order Header -->
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 bg-neu-bg border-b-3 border-neu-black">
            <div class="flex flex-wrap items-center gap-3 text-xs font-bold">
                <span class="font-black text-neu-black">{{ $order->buyer->name }}</span>
                <span class="text-gray-400">·</span>
                <span class="text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                <span class="text-gray-400">·</span>
                <code class="bg-neu-black text-neu-yellow px-2 py-0.5 text-xs font-black">{{ $order->order_number }}</code>
            </div>
            @php
                $statusColors = [
                    'pending'    => 'badge-yellow',
                    'paid'       => 'badge-blue',
                    'processing' => 'badge-pink',
                    'shipped'    => 'badge-pink',
                    'delivered'  => 'badge-green',
                    'completed'  => 'badge-green',
                    'cancelled'  => 'badge-red',
                ];
                $sc = $statusColors[$order->status->value ?? ''] ?? 'badge-white';
            @endphp
            <span class="{{ $sc }}">{{ $order->status->label() }}</span>
        </div>

        <!-- Order Body -->
        <div class="flex flex-wrap items-center justify-between gap-4 p-5">
            <div class="flex items-center gap-4 flex-1 min-w-0">
                <img src="{{ $order->items->first()->product->primary_image_url }}"
                     class="w-16 h-16 object-cover border-3 border-neu-black shrink-0">
                <div class="min-w-0">
                    <h4 class="font-black text-neu-black truncate">{{ $order->items->first()->product_name_snapshot }}</h4>
                    <div class="text-sm font-semibold text-gray-500 mt-0.5">
                        {{ $order->items->first()->quantity }} barang × @rupiah($order->items->first()->price_snapshot)
                    </div>
                    @if($order->items->count() > 1)
                    <div class="text-xs font-bold text-neu-blue mt-1">+{{ $order->items->count() - 1 }} produk lainnya</div>
                    @endif
                </div>
            </div>

            <div class="text-right border-l-3 border-neu-black pl-5">
                <div class="text-xs font-black uppercase text-gray-400 mb-1">Total Pesanan</div>
                <div class="text-xl font-extrabold text-neu-black">@rupiah($order->total)</div>
                <div class="text-xs text-gray-500 font-semibold mt-1">
                    Kurir: <span class="font-black uppercase">{{ $order->shipment->courier ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Order Footer -->
        <div class="flex items-center justify-end gap-3 px-5 py-3 bg-neu-bg border-t-3 border-neu-black">
            <a href="{{ route('seller.orders.show', $order) }}" class="btn-neu btn-neu-sm bg-white">
                Tinjau Pesanan
            </a>
            @if($order->status === \App\Enums\OrderStatus::Paid)
            <form action="{{ route('seller.orders.status.update', $order) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ \App\Enums\OrderStatus::Processing->value }}">
                <button type="submit" class="btn-neu-primary btn-neu-sm">
                    ✅ Terima Pesanan
                </button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="card-neu text-center py-16">
        <div class="text-5xl mb-4">📭</div>
        <div class="font-black text-gray-400 uppercase text-sm">Belum ada pesanan yang sesuai.</div>
    </div>
    @endforelse
</div>

@if($orders->hasPages())
<div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection
