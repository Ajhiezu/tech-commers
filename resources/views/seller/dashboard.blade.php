@extends('layouts.seller')

@section('content')
<!-- Page Header -->
<div class="page-header-neu">
    <div>
        <div class="inline-block badge-yellow mb-2">OVERVIEW</div>
        <h1 class="page-title-neu">Dashboard Toko</h1>
        <p class="text-sm font-semibold text-gray-500 mt-1">Ringkasan performa toko Anda hari ini.</p>
    </div>
    <a href="{{ route('seller.products.create') }}" class="btn-neu-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
        </svg>
        TAMBAH PRODUK
    </a>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Stat 1 -->
    <div class="card-neu border-l-[6px] border-l-neu-yellow">
        <div class="stat-label">Perlu Dikirim</div>
        <div class="stat-value text-4xl mt-1">{{ $stats['pending_orders'] }}</div>
        <a href="{{ route('seller.orders.index', ['status' => 'paid']) }}"
           class="inline-flex items-center gap-1 mt-3 text-xs font-black uppercase tracking-wider text-neu-blue hover:underline">
            Lihat Pesanan →
        </a>
    </div>

    <!-- Stat 2 -->
    <div class="card-neu border-l-[6px] border-l-neu-blue">
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-value text-4xl mt-1">{{ $stats['total_orders'] }}</div>
        <div class="mt-3 text-xs font-bold text-gray-400 uppercase">Semua Status</div>
    </div>

    <!-- Stat 3 -->
    <div class="card-neu border-l-[6px] border-l-neu-green">
        <div class="stat-label">Produk Aktif</div>
        <div class="stat-value text-4xl mt-1">
            {{ $stats['active_products'] }}
            <span class="text-xl text-gray-400 font-bold">/ {{ $stats['total_products'] }}</span>
        </div>
        <div class="mt-3 text-xs font-bold text-gray-400 uppercase">Total Produk</div>
    </div>

    <!-- Stat 4 — Balance -->
    <div class="card-neu bg-neu-black text-white">
        <div class="text-xs font-black uppercase tracking-widest text-neu-yellow mb-1">Saldo Tersedia</div>
        <div class="text-2xl font-extrabold text-neu-yellow mt-1">@rupiah($stats['balance'])</div>
        <a href="{{ route('seller.wallet.index') }}"
           class="inline-block mt-3 px-3 py-1.5 border-2 border-neu-yellow text-neu-yellow text-xs font-black uppercase hover:bg-neu-yellow hover:text-neu-black transition-colors">
            TARIK DANA
        </a>
    </div>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Recent Orders Table -->
    <div class="lg:col-span-2">
        <div class="card-neu p-0 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b-3 border-neu-black bg-neu-bg">
                <h3 class="font-black text-neu-black uppercase tracking-wide text-sm">Pesanan Terbaru</h3>
                <a href="{{ route('seller.orders.index') }}"
                   class="text-xs font-black uppercase text-neu-blue hover:underline tracking-wider">
                    Lihat Semua →
                </a>
            </div>

            <table class="table-neu w-full">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="flex items-center gap-3 min-w-[220px]">
                            <img src="{{ $order->items->first()->product->primary_image_url }}"
                                 class="w-12 h-12 object-cover border-3 border-neu-black shrink-0">
                            <div>
                                <div class="font-bold text-neu-black max-w-[180px] truncate">
                                    {{ $order->items->first()->product_name_snapshot }}
                                </div>
                                <div class="text-xs text-gray-500 font-semibold mt-0.5">
                                    #{{ $order->order_number }} · {{ $order->buyer->name }}
                                </div>
                            </div>
                        </td>
                        <td class="font-black text-neu-black">@rupiah($order->total)</td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending'   => 'badge-yellow',
                                    'paid'      => 'badge-blue',
                                    'shipped'   => 'badge-pink',
                                    'delivered' => 'badge-green',
                                    'completed' => 'badge-green',
                                    'cancelled' => 'badge-red',
                                ];
                                $sc = $statusColors[$order->status->value ?? ''] ?? 'badge-white';
                            @endphp
                            <span class="{{ $sc }}">{{ $order->status->label() }}</span>
                        </td>
                        <td>
                            <a href="{{ route('seller.orders.show', $order) }}"
                               class="btn-neu btn-neu-sm bg-white">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center">
                            <div class="text-4xl mb-3">📦</div>
                            <div class="font-black text-gray-400 uppercase text-sm">Belum ada pesanan</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Help Center -->
    <div class="lg:col-span-1 space-y-4">
        <div class="card-neu">
            <h3 class="font-black text-neu-black uppercase text-sm mb-4 border-b-3 border-neu-black pb-3">
                Pusat Bantuan
            </h3>
            <div class="space-y-3">
                <a href="#" class="block border-3 border-neu-black p-4 hover:bg-neu-yellow transition-colors group"
                   style="box-shadow: 3px 3px 0 #0D0D0D">
                    <div class="font-black text-neu-black text-sm uppercase group-hover:text-neu-black mb-1">
                        📈 Panduan Berjualan
                    </div>
                    <div class="text-xs font-semibold text-gray-500">Pelajari cara meningkatkan penjualan.</div>
                </a>
                <a href="#" class="block border-3 border-neu-black p-4 hover:bg-neu-yellow transition-colors group"
                   style="box-shadow: 3px 3px 0 #0D0D0D">
                    <div class="font-black text-neu-black text-sm uppercase group-hover:text-neu-black mb-1">
                        📋 Kebijakan Seller
                    </div>
                    <div class="text-xs font-semibold text-gray-500">Peraturan yang harus ditaati saat berjualan.</div>
                </a>
                <a href="#" class="block border-3 border-neu-black p-4 hover:bg-neu-yellow transition-colors group"
                   style="box-shadow: 3px 3px 0 #0D0D0D">
                    <div class="font-black text-neu-black text-sm uppercase group-hover:text-neu-black mb-1">
                        💬 Hubungi Support
                    </div>
                    <div class="text-xs font-semibold text-gray-500">Tim kami siap membantu 24/7.</div>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
