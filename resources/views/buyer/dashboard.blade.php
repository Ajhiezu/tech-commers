@extends('layouts.marketplace')

@section('content')

{{-- Buyer Sidebar + Content layout --}}
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- ===== SIDEBAR ===== --}}
        <div class="md:col-span-1">
            <div class="bg-neu-black border-3 border-neu-black p-5 sticky top-28"
                 style="box-shadow: 5px 5px 0 #FFE600">
                {{-- User Info --}}
                <div class="flex items-center gap-3 mb-5 pb-5 border-b-3 border-gray-700">
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                         class="w-14 h-14 border-3 border-neu-yellow shrink-0">
                    <div class="min-w-0">
                        <h3 class="font-black text-white truncate">{{ auth()->user()->name }}</h3>
                        <div class="text-xs font-bold text-neu-yellow uppercase mt-0.5">Member</div>
                    </div>
                </div>

                {{-- Nav --}}
                <nav class="space-y-1">
                    <a href="{{ route('buyer.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('buyer.orders.index') }}"
                       class="sidebar-link {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Pesanan Saya
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Pengaturan
                    </a>
                </nav>
            </div>
        </div>

        {{-- ===== CONTENT ===== --}}
        <div class="md:col-span-3 space-y-6">

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="card-neu border-l-[6px] border-l-neu-yellow">
                    <div class="stat-label">Menunggu Diproses</div>
                    <div class="stat-value mt-1">{{ $stats['pending_orders'] }}</div>
                </div>
                <div class="card-neu border-l-[6px] border-l-neu-green">
                    <div class="stat-label">Pesanan Selesai</div>
                    <div class="stat-value mt-1">{{ $stats['completed_orders'] }}</div>
                </div>
                <div class="card-neu border-l-[6px] border-l-neu-pink">
                    <div class="stat-label">Wishlist</div>
                    <div class="stat-value mt-1">{{ $stats['wishlist_count'] }}</div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="card-neu p-0 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b-3 border-neu-black bg-neu-bg">
                    <h3 class="font-black text-neu-black uppercase tracking-wide text-sm">Pesanan Terbaru</h3>
                    <a href="{{ route('buyer.orders.index') }}"
                       class="text-xs font-black uppercase text-neu-blue hover:underline tracking-wider">
                        Lihat Semua →
                    </a>
                </div>

                <div class="divide-y-3 divide-neu-black">
                    @forelse($recentOrders as $order)
                    <div class="p-5">
                        {{-- Order meta --}}
                        <div class="flex flex-wrap items-center gap-3 mb-4 pb-3 border-b-3 border-dashed border-gray-200">
                            <code class="bg-neu-black text-neu-yellow px-2 py-0.5 text-xs font-black">{{ $order->order_number }}</code>
                            <span class="text-xs font-semibold text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                            @php
                                $sc = ['pending'=>'badge-yellow','paid'=>'badge-blue','processing'=>'badge-pink','shipped'=>'badge-pink','delivered'=>'badge-green','completed'=>'badge-green','cancelled'=>'badge-red'][$order->status->value ?? ''] ?? 'badge-white';
                            @endphp
                            <span class="{{ $sc }}">{{ $order->status->label() }}</span>
                            <span class="ml-auto text-xs font-bold text-gray-600">{{ $order->store->name }}</span>
                        </div>

                        {{-- Product + total --}}
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                <img src="{{ $order->items->first()->product->primary_image_url }}"
                                     class="w-16 h-16 object-cover border-3 border-neu-black shrink-0">
                                <div class="min-w-0">
                                    <h4 class="font-black text-neu-black truncate">{{ $order->items->first()->product_name_snapshot }}</h4>
                                    <div class="text-sm font-semibold text-gray-500">
                                        {{ $order->items->first()->quantity }} × @rupiah($order->items->first()->price_snapshot)
                                    </div>
                                    @if($order->items->count() > 1)
                                    <div class="text-xs font-bold text-neu-blue">+{{ $order->items->count() - 1 }} produk lainnya</div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-xs font-black uppercase text-gray-400">Total</div>
                                <div class="text-lg font-extrabold text-neu-black">@rupiah($order->total)</div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ route('buyer.orders.show', $order) }}" class="btn-neu btn-neu-sm bg-white">
                                Lihat Detail
                            </a>
                            @if($order->status === \App\Enums\OrderStatus::Pending)
                            <a href="{{ route('checkout.dummy-payment', $order->order_number) }}" class="btn-neu-orange btn-neu-sm">
                                💳 Bayar Sekarang
                            </a>
                            @endif
                            @if($order->status === \App\Enums\OrderStatus::Delivered)
                            <form action="{{ route('buyer.orders.complete', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-neu-success btn-neu-sm">✅ Selesaikan</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="py-16 text-center">
                        <div class="text-5xl mb-4">📦</div>
                        <div class="font-black text-gray-400 uppercase text-sm">Belum ada pesanan</div>
                        <a href="{{ route('home') }}" class="btn-neu-primary btn-neu-sm mt-4 inline-flex">Mulai Belanja</a>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Recently Viewed --}}
            @if($recentlyViewed->count() > 0)
            <div class="card-neu">
                <h3 class="font-black text-neu-black uppercase text-sm mb-5 border-b-3 border-neu-black pb-3">
                    Terakhir Dilihat
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                    @foreach($recentlyViewed as $view)
                    <a href="{{ route('products.show', $view->product->slug) }}" class="group block product-card-neu">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $view->product->primary_image_url }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                        </div>
                        <div class="p-2 border-t-3 border-neu-black">
                            <div class="text-xs font-bold text-neu-black line-clamp-2">{{ $view->product->name }}</div>
                            <div class="text-xs font-black text-primary mt-1">@rupiah($view->product->price)</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
