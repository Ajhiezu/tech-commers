@extends('layouts.seller')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b-3 border-neu-black pb-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('seller.orders.index') }}" class="btn-neu-sm bg-white border-3 border-neu-black" style="box-shadow: 2px 2px 0 #0D0D0D">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-black text-neu-black uppercase tracking-tight">Pesanan <span class="bg-neu-black text-neu-yellow px-2 py-0.5">#{{ $order->order_number }}</span></h1>
    </div>
    <div class="{!! str_replace('badge-', 'badge-', $order->status->color()) !!} px-4 py-2 border-3 border-neu-black text-sm" style="box-shadow: 3px 3px 0 #0D0D0D">
        {{ $order->status->label() }}
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Products -->
        <div class="card-neu p-0 overflow-hidden bg-white">
            <div class="p-4 border-b-3 border-neu-black bg-neu-bg">
                <h3 class="font-black text-lg text-neu-black uppercase tracking-wider">Produk yang Dipesan</h3>
            </div>
            <div class="divide-y-3 divide-neu-black">
                @foreach($order->items as $item)
                <div class="flex flex-wrap md:flex-nowrap justify-between items-center gap-4 p-5 bg-white">
                    <div class="flex gap-4 items-center">
                        <img src="{{ $item->product->primary_image_url }}" class="w-16 h-16 border-3 border-neu-black object-cover bg-neu-bg shrink-0">
                        <div>
                            <div class="font-black uppercase text-neu-black line-clamp-2 leading-tight mb-1">{{ $item->product_name_snapshot }}</div>
                            <div class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 border border-neu-black inline-block uppercase">{{ $item->quantity }} Pcs x @rupiah($item->price_snapshot)</div>
                        </div>
                    </div>
                    <div class="font-black text-primary text-lg">@rupiah($item->subtotal)</div>
                </div>
                @endforeach
            </div>
            
            <div class="border-t-3 border-neu-black p-5 bg-neu-yellow/10 space-y-3 text-sm font-bold text-gray-600">
                <div class="flex justify-between items-center"><span>Total Harga Produk</span> <span class="text-neu-black">@rupiah($order->subtotal)</span></div>
                <div class="flex justify-between items-center"><span>Ongkos Kirim</span> <span class="text-neu-black">@rupiah($order->shipping_cost)</span></div>
                @if($order->discount > 0)
                <div class="flex justify-between items-center text-neu-red"><span>Diskon</span> <span>- @rupiah($order->discount)</span></div>
                @endif
                <div class="flex justify-between items-center font-black text-xl text-primary pt-3 border-t-3 border-dashed border-neu-black mt-3">
                    <span class="uppercase text-neu-black">Estimasi Pendapatan</span>
                    <span>@rupiah($order->subtotal - $order->commission)</span>
                </div>
                <div class="text-[10px] font-black uppercase text-gray-400 text-right">Potongan Komisi Sistem: @rupiah($order->commission)</div>
            </div>
        </div>

        <!-- Action Panel -->
        @if(in_array($order->status, [\App\Enums\OrderStatus::Paid, \App\Enums\OrderStatus::Processing]))
        <div class="card-neu bg-neu-blue text-white" style="box-shadow: 6px 6px 0 #0D0D0D">
            <h3 class="font-black text-xl uppercase mb-4 border-b-3 border-neu-black pb-4 flex items-center gap-2">
                <span class="bg-white text-neu-black px-2 py-1 border-2 border-neu-black">⚙️</span>
                Proses Pesanan
            </h3>
            
            @if($order->status === \App\Enums\OrderStatus::Paid)
            <form action="{{ route('seller.orders.status.update', $order) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ \App\Enums\OrderStatus::Processing->value }}">
                <p class="font-bold text-sm mb-6 bg-neu-black/20 p-3 border-2 border-neu-black">Terima pesanan ini untuk memberitahu pembeli bahwa barang sedang Anda siapkan.</p>
                <div class="flex gap-4">
                    <button type="submit" class="btn-neu bg-neu-yellow text-neu-black border-neu-black hover:bg-white w-full py-4 text-sm" style="box-shadow: 4px 4px 0 #0D0D0D">
                        ✅ TERIMA & PROSES PESANAN
                    </button>
                </div>
            </form>
            @elseif($order->status === \App\Enums\OrderStatus::Processing)
            <form action="{{ route('seller.orders.status.update', $order) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ \App\Enums\OrderStatus::Shipped->value }}">
                <p class="font-bold text-sm mb-6 bg-neu-black/20 p-3 border-2 border-neu-black">Masukkan nomor resi untuk mengonfirmasi bahwa barang telah dikirim ke kurir.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest mb-2">Kurir</label>
                        <select name="courier" class="input-neu text-sm font-bold uppercase cursor-pointer">
                            <option value="jne">JNE Express</option>
                            <option value="jnt">J&T Express</option>
                            <option value="sicepat">SiCepat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest mb-2">Nomor Resi</label>
                        <input type="text" name="tracking_number" required placeholder="Contoh: JP1234567890" class="input-neu text-sm font-bold font-mono">
                    </div>
                </div>
                <button type="submit" class="btn-neu bg-neu-green text-neu-black border-neu-black hover:bg-white w-full py-4 text-sm" style="box-shadow: 4px 4px 0 #0D0D0D">
                    🚀 KONFIRMASI PENGIRIMAN
                </button>
            </form>
            @endif
        </div>
        @endif
    </div>

    <!-- Right Column -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Customer Info -->
        <div class="card-neu bg-white">
            <h3 class="font-black text-lg text-neu-black uppercase mb-4 border-b-3 border-neu-black pb-3">Info Pembeli</h3>
            <div class="flex items-center gap-3 mb-5 pb-5 border-b-3 border-dashed border-gray-300">
                <img src="{{ $order->buyer->avatar_url }}" class="w-12 h-12 rounded-full border-3 border-neu-black shrink-0">
                <div class="min-w-0">
                    <div class="font-black uppercase text-neu-black truncate">{{ $order->buyer->name }}</div>
                    <div class="text-xs font-bold text-gray-500 truncate">{{ $order->buyer->email }}</div>
                </div>
            </div>
            
            <div>
                <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Alamat Pengiriman</h4>
                <div class="text-xs font-semibold text-neu-black bg-neu-bg p-3 border-2 border-neu-black leading-relaxed">
                    <span class="font-black uppercase block mb-1 text-sm">{{ $order->shipping_address['recipient_name'] ?? '-' }}</span>
                    <span class="font-mono block mb-2">{{ $order->shipping_address['phone'] ?? '-' }}</span>
                    {{ $order->shipping_address['full_address'] ?? '-' }}
                </div>
            </div>

            @if($order->notes)
            <div class="mt-4">
                <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Catatan Pembeli</h4>
                <div class="text-xs font-bold text-neu-black bg-neu-yellow p-3 border-2 border-neu-black leading-relaxed">
                    "{{ $order->notes }}"
                </div>
            </div>
            @endif
        </div>

        <!-- History -->
        <div class="card-neu bg-white">
            <h3 class="font-black text-lg text-neu-black uppercase mb-5 border-b-3 border-neu-black pb-3">Riwayat Status</h3>
            <div class="space-y-0 relative before:absolute before:inset-0 before:ml-[9px] before:h-full before:w-1 before:bg-neu-black">
                @foreach($order->statusHistories as $history)
                <div class="relative flex items-start gap-4 mb-6 last:mb-0">
                    <div class="w-5 h-5 rounded-full border-3 border-neu-black {{ $loop->first ? 'bg-neu-blue' : 'bg-white' }} shrink-0 mt-0.5 z-10" style="box-shadow: 1px 1px 0 #0D0D0D"></div>
                    <div class="flex-1 min-w-0 {{ $loop->first ? 'bg-neu-blue/10 p-2 border-2 border-neu-blue -mt-2' : '' }}">
                        <div class="font-black text-xs uppercase {{ $loop->first ? 'text-neu-blue' : 'text-neu-black' }}">{{ $history->status->label() }}</div>
                        <div class="text-[10px] font-bold text-gray-500 mb-0.5">{{ $history->created_at->format('d M Y H:i') }}</div>
                        <div class="text-xs font-semibold text-gray-600 leading-tight">{{ $history->note }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
