@extends('layouts.marketplace')

@section('content')
<!-- Header -->
<div class="bg-neu-black border-b-3 border-neu-black py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-5xl font-black uppercase text-neu-yellow tracking-tight">Checkout</h1>
        <p class="text-sm font-bold text-gray-300 mt-2 uppercase tracking-widest">Langkah terakhir menuju pesanan Anda.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <!-- Stepper UI -->
    <div class="flex items-center justify-center max-w-3xl mx-auto mb-10">
        <div class="flex items-center w-full">
            <div class="flex-1 text-center relative">
                <div class="w-10 h-10 mx-auto bg-neu-green border-3 border-neu-black flex items-center justify-center font-black text-neu-black rounded-full z-10 relative" style="box-shadow: 2px 2px 0 #0D0D0D">✓</div>
                <div class="text-xs font-black uppercase mt-2 text-neu-black">Keranjang</div>
                <div class="absolute top-5 left-[50%] w-full h-1.5 bg-neu-green border-y-2 border-neu-black z-0"></div>
            </div>
            <div class="flex-1 text-center relative">
                <div class="w-10 h-10 mx-auto bg-neu-yellow border-3 border-neu-black flex items-center justify-center font-black text-neu-black rounded-full z-10 relative" style="box-shadow: 2px 2px 0 #0D0D0D">2</div>
                <div class="text-xs font-black uppercase mt-2 text-neu-black">Checkout</div>
                <div class="absolute top-5 left-[50%] w-full h-1.5 bg-white border-y-2 border-neu-black z-0"></div>
            </div>
            <div class="flex-1 text-center relative">
                <div class="w-10 h-10 mx-auto bg-white border-3 border-neu-black flex items-center justify-center font-black text-gray-400 rounded-full z-10 relative" style="box-shadow: 2px 2px 0 #0D0D0D">3</div>
                <div class="text-xs font-black uppercase mt-2 text-gray-400">Selesai</div>
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Alamat -->
                <div class="card-neu bg-white">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b-3 border-neu-black">
                        <div class="w-10 h-10 bg-neu-blue text-white flex items-center justify-center border-2 border-neu-black" style="box-shadow: 2px 2px 0 #0D0D0D">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h2 class="font-black text-xl uppercase tracking-wider text-neu-black">Alamat Pengiriman</h2>
                    </div>
                    
                    @if($addresses->isEmpty())
                        <div class="p-4 bg-neu-bg border-3 border-dashed border-neu-black mb-4">
                            <div class="text-sm font-bold text-gray-500 mb-2 uppercase">Belum Ada Alamat Tersimpan</div>
                            <p class="text-sm font-semibold text-neu-black">Karena Anda belum punya alamat, pesanan ini akan menggunakan alamat dummy untuk keperluan demo.</p>
                        </div>
                        <input type="hidden" name="address_id" value="0">
                    @else
                        <div class="space-y-3">
                        @foreach($addresses as $address)
                            <label class="flex items-start gap-4 p-4 border-3 border-neu-black cursor-pointer bg-white hover:bg-neu-yellow transition-colors relative group"
                                   x-data="{ checked: {{ $loop->first ? 'true' : 'false' }} }"
                                   @click="$dispatch('address-changed')"
                                   :class="checked ? 'bg-neu-yellow' : ''"
                                   style="box-shadow: 3px 3px 0 #0D0D0D">
                                <div class="pt-1">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" 
                                           {{ $loop->first ? 'checked' : '' }} 
                                           x-model="checked"
                                           class="w-5 h-5 border-2 border-neu-black text-neu-black focus:ring-neu-black cursor-pointer">
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-black uppercase text-neu-black">{{ $address->recipient_name }}</span>
                                        <span class="badge-blue text-[10px]">{{ $address->label }}</span>
                                    </div>
                                    <div class="text-xs font-bold text-gray-600 mb-1 font-mono">{{ $address->phone }}</div>
                                    <div class="text-sm font-semibold text-neu-black leading-relaxed">{{ $address->full_address }}</div>
                                </div>
                            </label>
                        @endforeach
                        </div>
                    @endif
                </div>

                <!-- Produk -->
                <div class="card-neu bg-white p-0 overflow-hidden">
                    <div class="flex items-center gap-3 p-5 pb-4 border-b-3 border-neu-black bg-neu-bg">
                        <div class="w-10 h-10 bg-neu-pink text-white flex items-center justify-center border-2 border-neu-black" style="box-shadow: 2px 2px 0 #0D0D0D">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h2 class="font-black text-xl uppercase tracking-wider text-neu-black">Pesanan Anda</h2>
                    </div>
                    
                    <div class="divide-y-3 divide-neu-black">
                        @foreach($cart->items as $item)
                        <div class="flex gap-4 p-5">
                            <img src="{{ $item->product->primary_image_url }}" 
                                 class="w-20 h-20 object-cover border-3 border-neu-black shrink-0 bg-neu-bg">
                            <div class="flex-1 min-w-0">
                                <div class="font-black uppercase text-neu-black line-clamp-2 leading-tight mb-2">{{ $item->product->name }}</div>
                                <div class="text-xs font-bold text-gray-500 bg-gray-100 inline-block px-2 py-1 border border-neu-black uppercase">
                                    {{ $item->quantity }} Pcs x @rupiah($item->price_snapshot)
                                </div>
                            </div>
                            <div class="font-black text-primary text-lg shrink-0">
                                @rupiah($item->subtotal)
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="p-5 bg-neu-bg border-t-3 border-neu-black">
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Pesan untuk Penjual (Opsional)</label>
                        <input type="text" name="notes" placeholder="Silakan tinggalkan pesan..." 
                               class="input-neu w-full text-sm">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1">
                <div class="card-neu sticky top-24 bg-white" style="box-shadow: 8px 8px 0 #0D0D0D">
                    
                    <!-- Pengiriman -->
                    <div class="mb-6 pb-6 border-b-3 border-dashed border-gray-300">
                        <h3 class="font-black text-neu-black uppercase mb-3">Pilih Pengiriman</h3>
                        <select name="courier" class="input-neu w-full text-sm mb-3 py-2 cursor-pointer font-bold">
                            <option value="jne">JNE Express</option>
                            <option value="jnt">J&T Express</option>
                            <option value="sicepat">SiCepat</option>
                        </select>
                        <select name="service" class="input-neu w-full text-sm py-2 cursor-pointer font-bold">
                            <option value="REG">Reguler (2-3 hari) - Rp 15.000</option>
                            <option value="YES">Yakin Esok Sampai (1 hari) - Rp 25.000</option>
                        </select>
                        <input type="hidden" name="shipping_cost" value="15000" id="shipping_cost_input">
                    </div>

                    <!-- Voucher -->
                    <div class="mb-6 pb-6 border-b-3 border-dashed border-gray-300">
                        <h3 class="font-black text-neu-black uppercase mb-3 flex items-center gap-2">
                            <span class="text-neu-red">🎫</span> Kode Voucher
                        </h3>
                        <div class="flex gap-2">
                            <input type="text" name="voucher_code" placeholder="KODE PROMO" 
                                   class="input-neu flex-1 text-sm uppercase py-2">
                            <button type="button" class="btn-neu-primary px-4 py-2">
                                PAKAI
                            </button>
                        </div>
                    </div>
                    
                    <h3 class="font-black text-neu-black uppercase mb-4">Ringkasan Belanja</h3>
                    
                    <div class="space-y-3 text-sm font-bold text-gray-500 mb-6">
                        <div class="flex justify-between items-center">
                            <span>Subtotal Produk</span>
                            <span class="text-neu-black">@rupiah($cart->total)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Total Ongkos Kirim</span>
                            <span class="text-neu-black">Rp 15.000</span>
                        </div>
                        <div class="flex justify-between items-center text-neu-green">
                            <span>Diskon Voucher</span>
                            <span>- Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="border-t-3 border-neu-black pt-5 mb-8 flex justify-between items-end">
                        <span class="font-black text-neu-black uppercase text-lg">Total Tagihan</span>
                        <span class="font-black text-primary text-3xl tracking-tighter">@rupiah($cart->total + 15000)</span>
                    </div>
                    
                    <button type="submit" class="btn-neu bg-primary text-white w-full py-4 text-lg border-neu-black hover:bg-orange-600" style="box-shadow: 4px 4px 0 #0D0D0D">
                        BUAT PESANAN SEKARANG
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
