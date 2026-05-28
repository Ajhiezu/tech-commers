@extends('layouts.marketplace')

@section('content')
<div class="bg-neu-black border-b-3 border-neu-black py-6 mb-6">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('buyer.orders.index') }}" class="text-neu-yellow hover:text-white text-xs font-black uppercase tracking-widest mb-2 inline-block transition-colors">
                &larr; KEMBALI KE DAFTAR
            </a>
            <h1 class="text-2xl md:text-3xl font-black text-white uppercase tracking-tight">Detail Pesanan <span class="text-neu-yellow">#{{ $order->order_number }}</span></h1>
        </div>
        <div class="shrink-0">
            @php
                $sc = ['pending'=>'badge-yellow','paid'=>'badge-blue','processing'=>'badge-pink','shipped'=>'badge-pink','delivered'=>'badge-green','completed'=>'badge-green','cancelled'=>'badge-red'][$order->status->value ?? ''] ?? 'badge-white';
            @endphp
            <span class="{{ $sc }} text-sm px-4 py-2">{{ $order->status->label() }}</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 pb-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Products -->
            <div class="card-neu p-0 overflow-hidden">
                <div class="flex items-center gap-3 p-5 pb-4 border-b-3 border-neu-black bg-neu-bg">
                    <div class="w-10 h-10 bg-neu-yellow text-neu-black flex items-center justify-center border-2 border-neu-black" style="box-shadow: 2px 2px 0 #0D0D0D">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="font-black text-xl uppercase tracking-wider text-neu-black">Daftar Produk</h3>
                    <div class="ml-auto flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Toko:</span>
                        <span class="font-black text-neu-black uppercase bg-white border-2 border-neu-black px-2 py-0.5">{{ $order->store->name }}</span>
                    </div>
                </div>

                <div class="divide-y-3 divide-neu-black">
                    @foreach($order->items as $item)
                    <div class="flex flex-wrap md:flex-nowrap gap-4 p-5 bg-white">
                        <img src="{{ $item->product->primary_image_url }}" class="w-20 h-20 object-cover border-3 border-neu-black shrink-0 bg-neu-bg">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('products.show', $item->product->slug) }}" class="font-black text-neu-black uppercase hover:text-neu-blue transition-colors line-clamp-2 mb-2">{{ $item->product_name_snapshot }}</a>
                            <div class="text-xs font-bold text-gray-500 bg-gray-100 inline-block px-2 py-1 border border-neu-black uppercase">
                                {{ $item->quantity }} Pcs x @rupiah($item->price_snapshot)
                            </div>
                        </div>
                        <div class="text-right flex flex-col justify-between shrink-0">
                            <div class="font-black text-primary text-lg">@rupiah($item->subtotal)</div>
                            @if($order->status === \App\Enums\OrderStatus::Completed)
                                @if(!$item->review)
                                <a href="{{ route('buyer.reviews.create', ['order' => $order, 'item' => $item]) }}" class="btn-neu-sm bg-neu-blue text-white border-3 border-neu-black uppercase font-bold text-xs mt-2 text-center" style="box-shadow: 2px 2px 0 #0D0D0D">Beri Ulasan</a>
                                @else
                                <span class="text-[10px] font-black text-neu-green bg-neu-black border-2 border-neu-green px-2 py-1 uppercase mt-2 text-center">Sudah Diulas</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card-neu bg-white">
                <h3 class="font-black text-xl text-neu-black uppercase tracking-wider border-b-3 border-neu-black pb-4 mb-6">Riwayat Pesanan</h3>

                <div class="space-y-0 relative before:absolute before:inset-0 before:ml-[11px] before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-1.5 before:bg-neu-black">
                    @foreach($order->statusHistories as $history)
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active mb-8 last:mb-0">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full border-3 border-neu-black {{ $loop->first ? 'bg-neu-blue' : 'bg-white' }} shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-[2px_2px_0_#0D0D0D] z-10"></div>
                        <div class="w-[calc(100%-3rem)] md:w-[calc(50%-2rem)] p-4 border-3 border-neu-black bg-white shadow-[4px_4px_0_#0D0D0D] {{ $loop->first ? 'border-neu-blue shadow-[4px_4px_0_#0047FF]' : '' }}">
                            <div class="flex items-center justify-between mb-1">
                                <div class="font-black text-sm uppercase {{ $loop->first ? 'text-neu-blue' : 'text-neu-black' }}">{{ $history->status->label() }}</div>
                                <div class="text-[10px] font-bold text-gray-500 bg-gray-100 px-1 py-0.5 border border-neu-black">{{ $history->created_at->format('d M H:i') }}</div>
                            </div>
                            <div class="text-xs font-semibold text-gray-600 leading-relaxed">{{ $history->note }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Payment Summary -->
            <div class="card-neu bg-white" style="box-shadow: 6px 6px 0 #0D0D0D">
                <h3 class="font-black text-lg text-neu-black uppercase mb-4 border-b-3 border-neu-black pb-3">Rincian Pembayaran</h3>
                <div class="space-y-3 text-sm font-bold text-gray-500 mb-5 pb-5 border-b-3 border-dashed border-gray-300">
                    <div class="flex justify-between items-center">
                        <span>Harga ({{ $order->items->sum('quantity') }} brg)</span>
                        <span class="text-neu-black">@rupiah($order->subtotal)</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Ongkos Kirim</span>
                        <span class="text-neu-black">@rupiah($order->shipping_cost)</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="flex justify-between items-center text-neu-red">
                        <span>Diskon</span>
                        <span>- @rupiah($order->discount)</span>
                    </div>
                    @endif
                </div>
                <div class="flex justify-between items-end mb-6">
                    <span class="font-black text-neu-black uppercase text-sm">Total Belanja</span>
                    <span class="font-black text-primary text-2xl tracking-tighter">@rupiah($order->total)</span>
                </div>
                
                @if($order->status === \App\Enums\OrderStatus::Pending)
                <a href="{{ route('checkout.dummy-payment', $order->order_number) }}" class="btn-neu-primary w-full py-3 text-center text-sm">
                    💳 BAYAR SEKARANG
                </a>
                @elseif($order->status === \App\Enums\OrderStatus::Delivered)
                <form action="{{ route('buyer.orders.complete', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-neu bg-neu-green text-neu-black w-full py-3 text-center text-sm">
                        ✅ PESANAN SELESAI
                    </button>
                </form>
                @endif
            </div>

            <!-- Delivery Info -->
            <div class="card-neu bg-white">
                <h3 class="font-black text-lg text-neu-black uppercase mb-4 border-b-3 border-neu-black pb-3">Info Pengiriman</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <div class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Kurir</div>
                        <div class="font-black text-neu-black uppercase border-2 border-neu-black inline-block px-2 py-1 bg-neu-yellow">{{ $order->shipment->courier ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">No. Resi</div>
                        <div class="font-bold text-neu-black bg-gray-100 p-2 border-2 border-neu-black break-all font-mono">
                            {{ $order->shipment->tracking_number ?? 'Belum ada resi' }}
                        </div>
                    </div>
                    <div>
                        <div class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Alamat Pengiriman</div>
                        <div class="text-xs font-semibold text-neu-black bg-gray-100 p-3 border-2 border-neu-black leading-relaxed">
                            <span class="font-black uppercase block mb-1 text-sm">{{ $order->shipping_address['recipient_name'] ?? '-' }}</span>
                            <span class="font-mono block mb-2">{{ $order->shipping_address['phone'] ?? '-' }}</span>
                            {{ $order->shipping_address['full_address'] ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
