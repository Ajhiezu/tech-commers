@extends('layouts.marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="md:col-span-1">
            <div class="bg-neu-black border-3 border-neu-black p-5 sticky top-28" style="box-shadow: 5px 5px 0 #FFE600">
                <div class="flex items-center gap-3 mb-5 pb-5 border-b-3 border-gray-700">
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-14 h-14 border-3 border-neu-yellow shrink-0">
                    <div class="min-w-0">
                        <h3 class="font-black text-white truncate">{{ auth()->user()->name }}</h3>
                        <div class="text-xs font-bold text-neu-yellow uppercase mt-0.5">Member</div>
                    </div>
                </div>
                
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('buyer.dashboard') }}" class="sidebar-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('buyer.orders.index') }}" class="sidebar-link {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Pesanan Saya
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="md:col-span-3 space-y-6">
            <div class="card-neu p-0 overflow-hidden bg-white">
                <div class="p-5 border-b-3 border-neu-black bg-neu-bg">
                    <h3 class="font-black text-neu-black text-xl uppercase tracking-wider">Pesanan Saya</h3>
                </div>
                
                <!-- Status Filter -->
                <div class="flex gap-2 p-5 border-b-3 border-neu-black bg-white overflow-x-auto pb-4 custom-scrollbar">
                    <a href="{{ route('buyer.orders.index') }}" class="px-4 py-2 border-3 border-neu-black font-black text-xs uppercase tracking-wider whitespace-nowrap transition-colors {{ !request('status') ? 'bg-neu-black text-neu-yellow' : 'bg-white text-neu-black hover:bg-neu-yellow' }}" style="{{ !request('status') ? 'box-shadow: 3px 3px 0 #FFE600' : 'box-shadow: 3px 3px 0 #0D0D0D' }}">
                        Semua
                    </a>
                    @foreach($statuses as $status)
                    <a href="{{ route('buyer.orders.index', ['status' => $status->value]) }}" class="px-4 py-2 border-3 border-neu-black font-black text-xs uppercase tracking-wider whitespace-nowrap transition-colors {{ request('status') === $status->value ? 'bg-neu-black text-neu-yellow' : 'bg-white text-neu-black hover:bg-neu-yellow' }}" style="{{ request('status') === $status->value ? 'box-shadow: 3px 3px 0 #FFE600' : 'box-shadow: 3px 3px 0 #0D0D0D' }}">
                        {{ $status->label() }}
                    </a>
                    @endforeach
                </div>
                
                <div class="divide-y-3 divide-neu-black">
                    @forelse($orders as $order)
                    <div class="p-5 bg-white hover:bg-neu-bg transition-colors">
                        <div class="flex flex-wrap justify-between items-center mb-4 pb-4 border-b-3 border-dashed border-gray-300 gap-3">
                            <div class="flex flex-wrap gap-3 text-sm text-gray-500 items-center">
                                <span class="font-bold text-neu-black">{{ $order->created_at->format('d M Y') }}</span>
                                @php
                                    $sc = ['pending'=>'badge-yellow','paid'=>'badge-blue','processing'=>'badge-pink','shipped'=>'badge-pink','delivered'=>'badge-green','completed'=>'badge-green','cancelled'=>'badge-red'][$order->status->value ?? ''] ?? 'badge-white';
                                @endphp
                                <span class="{{ $sc }}">{{ $order->status->label() }}</span>
                                <code class="bg-neu-black text-neu-yellow px-2 py-0.5 text-xs font-black">{{ $order->order_number }}</code>
                            </div>
                            <div class="text-sm font-black uppercase text-neu-black">{{ $order->store->name }}</div>
                        </div>
                        
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex gap-4 items-center">
                                <img src="{{ $order->items->first()->product->primary_image_url }}" class="w-20 h-20 border-3 border-neu-black object-cover bg-white">
                                <div>
                                    <h4 class="font-black text-neu-black uppercase">{{ $order->items->first()->product_name_snapshot }}</h4>
                                    <div class="text-sm font-bold text-gray-500 mt-1">{{ $order->items->first()->quantity }} barang x @rupiah($order->items->first()->price_snapshot)</div>
                                    @if($order->items->count() > 1)
                                    <div class="text-xs font-black text-neu-blue mt-1 bg-neu-blue/10 px-2 py-0.5 border border-neu-blue inline-block">+{{ $order->items->count() - 1 }} produk lainnya</div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right border-l-3 border-neu-black pl-5">
                                <div class="text-xs font-black uppercase text-gray-400 mb-1">Total Belanja</div>
                                <div class="font-black text-xl text-primary">@rupiah($order->total)</div>
                            </div>
                        </div>
                        
                        <div class="mt-5 flex justify-end gap-3 pt-4 border-t-3 border-dashed border-gray-300">
                            <a href="{{ route('buyer.orders.show', $order) }}" class="btn-neu-sm bg-white border-3 border-neu-black font-bold uppercase text-xs hover:bg-neu-yellow transition-colors" style="box-shadow: 2px 2px 0 #0D0D0D">Lihat Detail</a>
                            @if($order->status === \App\Enums\OrderStatus::Pending)
                            <a href="{{ route('checkout.dummy-payment', $order->order_number) }}" class="btn-neu-sm bg-neu-black text-neu-yellow border-3 border-neu-black font-bold uppercase text-xs hover:bg-neu-blue hover:text-white transition-colors" style="box-shadow: 2px 2px 0 #FFE600">Bayar Sekarang</a>
                            @endif
                            @if($order->status === \App\Enums\OrderStatus::Delivered)
                            <form action="{{ route('buyer.orders.complete', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-neu-sm bg-neu-green text-neu-black border-3 border-neu-black font-bold uppercase text-xs hover:bg-neu-black hover:text-neu-green transition-colors" style="box-shadow: 2px 2px 0 #0D0D0D">✅ Selesaikan Pesanan</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16 bg-white">
                        <div class="text-6xl mb-4">📦</div>
                        <div class="font-black text-gray-400 uppercase text-lg mb-4">Belum Ada Pesanan</div>
                        <a href="{{ route('home') }}" class="btn-neu-primary px-6 py-3">MULAI BELANJA</a>
                    </div>
                    @endforelse
                </div>
                
                @if($orders->hasPages())
                <div class="p-5 border-t-3 border-neu-black bg-neu-bg">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
