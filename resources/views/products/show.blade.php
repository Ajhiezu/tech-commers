@extends('layouts.marketplace')

@section('content')
<!-- Breadcrumb -->
<div class="bg-neu-bg border-b-3 border-neu-black py-3">
    <div class="container mx-auto px-4 flex flex-wrap items-center gap-2 text-xs font-bold uppercase tracking-wider">
        <a href="{{ route('home') }}" class="text-neu-black hover:text-neu-blue hover:underline">Beranda</a>
        <span class="text-gray-400">/</span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-neu-black hover:text-neu-blue hover:underline">{{ $product->category->name }}</a>
        <span class="text-gray-400">/</span>
        <span class="text-neu-blue truncate max-w-[200px] sm:max-w-md">{{ $product->name }}</span>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <!-- Top Section: Images + Actions -->
    <div class="card-neu p-0 mb-8 overflow-hidden bg-white">
        <div class="flex flex-col lg:flex-row">
            
            <!-- Product Images -->
            <div class="lg:w-2/5 p-5 border-b-3 lg:border-b-0 lg:border-r-3 border-neu-black bg-neu-bg" x-data="{ mainImage: '{{ $product->primary_image_url }}' }">
                <div class="aspect-square border-3 border-neu-black bg-white overflow-hidden mb-4 relative" style="box-shadow: 4px 4px 0 #0D0D0D">
                    <img :src="mainImage" class="w-full h-full object-cover">
                    @if($product->hasDiscount())
                        <div class="absolute top-0 right-0 bg-neu-yellow text-neu-black text-sm font-black px-3 py-1.5 border-l-3 border-b-3 border-neu-black">
                            -{{ $product->discount_percentage }}%
                        </div>
                    @endif
                </div>
                
                <div class="flex gap-3 overflow-x-auto pb-2 custom-scrollbar">
                    @foreach($product->images as $image)
                    <button @click="mainImage = '{{ $image->url }}'" 
                            class="w-20 h-20 shrink-0 border-3 border-neu-black bg-white hover:border-neu-blue focus:border-neu-blue transition-colors outline-none"
                            style="box-shadow: 2px 2px 0 #0D0D0D">
                        <img src="{{ $image->url }}" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div class="lg:w-3/5 p-6 md:p-8 flex flex-col bg-white">
                <div class="inline-block badge-yellow mb-3 w-max">{{ $product->category->name }}</div>
                
                <h1 class="text-2xl md:text-3xl font-black text-neu-black uppercase leading-tight mb-4 tracking-tight">
                    {{ $product->name }}
                </h1>
                
                <!-- Rating & Sold -->
                <div class="flex flex-wrap items-center gap-4 text-sm font-bold text-neu-black mb-6 border-y-3 border-neu-black py-3">
                    <div class="flex items-center gap-1">
                        <span class="text-neu-yellow text-lg">★</span>
                        <span class="text-xl underline decoration-3 decoration-neu-yellow">{{ $product->average_rating }}</span>
                    </div>
                    <div class="w-1.5 h-1.5 bg-neu-black rounded-full"></div>
                    <div>
                        <span class="text-lg">{{ $product->reviews()->count() }}</span>
                        <span class="text-gray-500 ml-1 uppercase text-xs">Penilaian</span>
                    </div>
                    <div class="w-1.5 h-1.5 bg-neu-black rounded-full"></div>
                    <div>
                        <span class="text-lg">{{ formatNumber($product->total_sold) }}</span>
                        <span class="text-gray-500 ml-1 uppercase text-xs">Terjual</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="bg-neu-yellow border-3 border-neu-black p-5 mb-8" style="box-shadow: 4px 4px 0 #0D0D0D">
                    @if($product->hasDiscount())
                    <div class="text-sm font-bold text-neu-black line-through mb-1 opacity-70">@rupiah($product->compare_price)</div>
                    @endif
                    <div class="flex items-end gap-3">
                        <span class="text-4xl md:text-5xl font-black text-neu-black tracking-tighter">@rupiah($product->price)</span>
                    </div>
                </div>

                <!-- Actions Form -->
                <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="flex flex-wrap items-center gap-6 mb-8">
                        <span class="text-sm font-black uppercase tracking-wider text-neu-black">Kuantitas</span>
                        
                        <div class="flex items-center gap-4" x-data="{ qty: 1, max: {{ $product->stock }} }">
                            <div class="flex items-center border-3 border-neu-black bg-white" style="box-shadow: 2px 2px 0 #0D0D0D">
                                <button type="button" @click="if(qty > 1) qty--" 
                                        class="w-10 h-10 flex items-center justify-center border-r-3 border-neu-black hover:bg-neu-yellow font-black text-xl transition-colors">
                                    -
                                </button>
                                <input type="number" name="quantity" x-model="qty" 
                                       class="w-16 h-10 text-center font-black text-lg border-none focus:ring-0 p-0 appearance-none bg-transparent" 
                                       min="1" :max="max">
                                <button type="button" @click="if(qty < max) qty++" 
                                        class="w-10 h-10 flex items-center justify-center border-l-3 border-neu-black hover:bg-neu-yellow font-black text-xl transition-colors">
                                    +
                                </button>
                            </div>
                            <span class="text-sm font-bold text-gray-500">
                                Sisa stok: <span class="text-neu-black">{{ $product->stock }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="button" onclick="addToCart()" 
                                class="btn-neu flex-1 bg-white hover:bg-neu-yellow py-4 text-base">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            MASUKKAN KERANJANG
                        </button>
                        <button type="button" onclick="buyNow()" 
                                class="btn-neu-primary flex-1 py-4 text-base">
                            BELI SEKARANG
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Details & Store -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Product Specs & Description -->
        <div class="lg:col-span-2 space-y-8">
            <div class="card-neu">
                <h3 class="font-black text-xl uppercase border-b-3 border-neu-black pb-4 mb-6 flex items-center gap-2">
                    <span class="bg-neu-yellow px-2 py-1 border-2 border-neu-black">📄</span>
                    Spesifikasi Produk
                </h3>
                
                <table class="w-full text-sm font-bold border-collapse">
                    <tbody>
                        <tr class="border-b-2 border-dashed border-gray-300">
                            <td class="py-3 text-gray-500 w-1/3">Kategori</td>
                            <td class="py-3 text-neu-blue hover:underline">
                                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                            </td>
                        </tr>
                        <tr class="border-b-2 border-dashed border-gray-300">
                            <td class="py-3 text-gray-500">Berat</td>
                            <td class="py-3 text-neu-black">{{ formatWeight($product->weight) }}</td>
                        </tr>
                        <tr class="border-b-2 border-dashed border-gray-300">
                            <td class="py-3 text-gray-500">Kondisi</td>
                            <td class="py-3 text-neu-black"><span class="badge-green">BARU</span></td>
                        </tr>
                        <tr>
                            <td class="py-3 text-gray-500">Dikirim Dari</td>
                            <td class="py-3 text-neu-black uppercase">{{ $product->store->city }}, {{ $product->store->province }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-neu">
                <h3 class="font-black text-xl uppercase border-b-3 border-neu-black pb-4 mb-6 flex items-center gap-2">
                    <span class="bg-neu-pink text-white px-2 py-1 border-2 border-neu-black">📝</span>
                    Deskripsi Produk
                </h3>
                
                <div class="prose prose-neu max-w-none text-sm font-medium text-neu-black whitespace-pre-line leading-relaxed">
                    {{ $product->description }}
                </div>
            </div>
            
            <!-- Reviews -->
            <div class="card-neu" id="reviews">
                <h3 class="font-black text-xl uppercase border-b-3 border-neu-black pb-4 mb-6 flex items-center gap-2">
                    <span class="bg-neu-blue text-white px-2 py-1 border-2 border-neu-black">⭐</span>
                    Penilaian Pembeli
                </h3>
                
                <div class="space-y-6">
                    @forelse($product->reviews as $review)
                    <div class="p-5 border-3 border-neu-black bg-neu-bg" style="box-shadow: 4px 4px 0 #0D0D0D">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                            <div class="flex items-center gap-3">
                                <img data-image-type="avatar" src="{{ $review->buyer->avatar_url }}" class="w-12 h-12 rounded-full border-2 border-neu-black bg-white">
                                <div>
                                    <div class="text-sm font-black">{{ $review->buyer->name }}</div>
                                    <div class="flex gap-0.5 mt-1 text-neu-yellow drop-shadow-[1px_1px_0_#0D0D0D]">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= $review->rating) ★ @else <span class="text-gray-300">★</span> @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs font-bold text-gray-500 bg-white px-2 py-1 border-2 border-neu-black">
                                {{ $review->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <p class="text-sm font-bold text-neu-black">{{ $review->comment }}</p>
                    </div>
                    @empty
                    <div class="text-center py-10 bg-neu-bg border-3 border-neu-black border-dashed">
                        <div class="text-4xl mb-3">💬</div>
                        <p class="font-black text-gray-500 uppercase">Belum ada penilaian</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Right: Store Info -->
        <div class="lg:col-span-1">
            <div class="card-neu sticky top-28 bg-white">
                <div class="flex items-center gap-4 mb-5 pb-5 border-b-3 border-neu-black">
                    <img data-image-type="store" src="{{ $product->store->logo_url }}" alt="{{ $product->store->name }}"
                         class="w-16 h-16 rounded-full border-3 border-neu-black bg-neu-bg shrink-0">
                    <div>
                        <h4 class="font-black text-lg uppercase line-clamp-2 leading-tight">{{ $product->store->name }}</h4>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-2 h-2 rounded-full bg-neu-green border border-neu-black"></span>
                            <span class="text-xs font-bold text-gray-500">Aktif {{ rand(1, 60) }} menit lalu</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <button class="btn-neu bg-white px-0 py-2 text-xs">
                        💬 CHAT
                    </button>
                    <a href="#" class="btn-neu bg-neu-black text-white px-0 py-2 text-xs hover:text-white">
                        🏪 TOKO
                    </a>
                </div>

                <div class="mt-6 pt-5 border-t-3 border-dashed border-gray-300 space-y-3 text-sm font-bold">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Lokasi</span>
                        <span class="uppercase text-right">{{ $product->store->city }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Bergabung</span>
                        <span>{{ rand(1, 5) }} Tahun Lalu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addToCart() {
    const form = document.getElementById('add-to-cart-form');
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                background: '#FAFAFA',
                color: '#0D0D0D'
            });
            document.getElementById('cart-badge').innerText = data.cart_count;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'GAGAL',
                text: data.message || 'Harap login terlebih dahulu',
                background: '#FAFAFA',
                color: '#0D0D0D'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'OOPS!',
            text: 'Terjadi kesalahan sistem',
            background: '#FAFAFA',
            color: '#0D0D0D'
        });
    });
}

function buyNow() {
    const form = document.getElementById('add-to-cart-form');
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "{{ route('checkout.index') }}";
        } else {
            Swal.fire({
                icon: 'error',
                title: 'GAGAL',
                text: data.message || 'Terjadi kesalahan',
                background: '#FAFAFA',
                color: '#0D0D0D'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'OOPS!',
            text: 'Terjadi kesalahan sistem',
            background: '#FAFAFA',
            color: '#0D0D0D'
        });
    });
}
</script>
@endpush
