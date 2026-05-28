@extends('layouts.marketplace')

@section('content')
<div class="bg-neu-yellow border-b-3 border-neu-black py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-5xl font-black uppercase text-neu-black tracking-tight">Keranjang Belanja</h1>
        <p class="text-sm font-bold text-neu-black/70 mt-2">Cek kembali barang bawaan Anda sebelum checkout.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    @if($cart->items->isEmpty())
        <div class="card-neu text-center py-16 bg-white max-w-2xl mx-auto">
            <div class="text-6xl mb-6">🛒</div>
            <h3 class="text-2xl font-black text-neu-black uppercase mb-3">Keranjang Anda Kosong</h3>
            <p class="font-bold text-gray-500 mb-8">Yuk, temukan produk menarik dan masukkan ke keranjang!</p>
            <a href="{{ route('home') }}" class="btn-neu-primary px-8 py-4 text-base inline-flex">
                MULAI BELANJA SEKARANG
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Items -->
            <div class="lg:col-span-2 space-y-4">
                <div class="card-neu py-3 px-5 mb-4 flex items-center justify-between bg-neu-black text-white">
                    <span class="font-black uppercase tracking-widest text-sm">PRODUK DI KERANJANG</span>
                    <span class="badge-yellow">{{ $cart->item_count }} BARANG</span>
                </div>

                @foreach($cart->items as $item)
                <div class="card-neu p-0 overflow-hidden flex flex-col sm:flex-row bg-white transition-shadow hover:shadow-[6px_6px_0_#0D0D0D]">
                    <div class="sm:w-40 h-40 shrink-0 border-b-3 sm:border-b-0 sm:border-r-3 border-neu-black bg-neu-bg p-2">
                        <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" 
                             class="w-full h-full object-cover border-2 border-neu-black bg-white">
                    </div>
                    <div class="p-4 sm:p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start gap-4 mb-2">
                            <h4 class="font-black text-neu-black uppercase line-clamp-2 leading-tight">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-neu-blue transition-colors">
                                    {{ $item->product->name }}
                                </a>
                            </h4>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="shrink-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center border-2 border-neu-black bg-white hover:bg-neu-red hover:text-white transition-colors" style="box-shadow: 2px 2px 0 #0D0D0D" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        </div>
                        
                        <div class="text-xl font-black text-primary mb-4">@rupiah($item->price_snapshot)</div>
                        
                        <div class="mt-auto flex items-center justify-between">
                            <div class="text-xs font-bold text-gray-500">Toko: <span class="text-neu-black uppercase">{{ $item->product->store->name }}</span></div>
                            
                            <!-- Qty Control -->
                            <div class="flex items-center border-2 border-neu-black bg-white h-9" style="box-shadow: 2px 2px 0 #0D0D0D" x-data="{ qty: {{ $item->quantity }}, max: {{ $item->product->stock }} }">
                                <button type="button" @click="if(qty > 1) { qty--; updateQty('{{ $item->id }}', qty) }" 
                                        class="w-8 h-full flex items-center justify-center border-r-2 border-neu-black hover:bg-neu-yellow font-black transition-colors">
                                    -
                                </button>
                                <input type="number" x-model="qty" readonly 
                                       class="w-12 h-full text-center font-black text-sm border-none focus:ring-0 p-0 bg-transparent">
                                <button type="button" @click="if(qty < max) { qty++; updateQty('{{ $item->id }}', qty) }" 
                                        class="w-8 h-full flex items-center justify-center border-l-2 border-neu-black hover:bg-neu-yellow font-black transition-colors">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="lg:col-span-1">
                <div class="card-neu sticky top-24 bg-white p-6" style="box-shadow: 6px 6px 0 #0D0D0D">
                    <h3 class="font-black text-xl text-neu-black uppercase border-b-3 border-neu-black pb-4 mb-6">
                        Ringkasan
                    </h3>
                    
                    <div class="flex justify-between mb-4 text-sm font-bold">
                        <span class="text-gray-500 uppercase">Total Harga ({{ $cart->item_count }} Barang)</span>
                        <span class="text-neu-black">@rupiah($cart->total)</span>
                    </div>
                    
                    <div class="border-t-3 border-dashed border-gray-300 pt-4 mb-6 flex justify-between items-center">
                        <span class="font-black text-neu-black uppercase">Total Tagihan</span>
                        <span class="font-black text-primary text-2xl tracking-tighter">@rupiah($cart->total)</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" 
                       class="btn-neu-primary w-full py-4 text-base block text-center">
                        LANJUTKAN CHECKOUT →
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function updateQty(itemId, newQty) {
    // Show loading visually (optional enhancement)
    Swal.fire({
        title: 'Updating...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => { Swal.showLoading(); },
        background: '#FAFAFA',
        color: '#0D0D0D'
    });

    fetch(`/cart/${itemId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: newQty })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Terjadi kesalahan.',
                background: '#FAFAFA',
                color: '#0D0D0D'
            });
        }
    })
    .catch(() => {
        window.location.reload(); // fallback
    });
}
</script>
@endpush
