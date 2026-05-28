@extends('layouts.marketplace')

@section('content')
<!-- Page Header -->
<div class="bg-neu-yellow border-b-3 border-neu-black py-8">
    <div class="container mx-auto px-4">
        <div class="inline-block badge-blue mb-2">KATALOG</div>
        <h1 class="text-3xl md:text-5xl font-black uppercase text-neu-black tracking-tight">Semua Produk</h1>
        <p class="text-sm font-bold text-neu-black/70 mt-2">Temukan ribuan produk menarik dengan harga terbaik.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar Filter -->
        <div class="w-full md:w-64 shrink-0">
            <div class="card-neu sticky top-24">
                <h3 class="font-black text-neu-black uppercase tracking-wider border-b-3 border-neu-black pb-3 mb-4">
                    Kategori
                </h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('products.index') }}" 
                           class="block px-3 py-2 font-bold text-sm border-2 transition-colors {{ !request('category') ? 'border-neu-black bg-neu-black text-white' : 'border-transparent text-neu-black hover:border-neu-black hover:bg-neu-yellow' }}">
                            Semua Kategori
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" 
                               class="block px-3 py-2 font-bold text-sm border-2 transition-colors {{ request('category') === $cat->slug ? 'border-neu-black bg-neu-black text-white' : 'border-transparent text-neu-black hover:border-neu-black hover:bg-neu-yellow' }}">
                                {{ $cat->name }}
                            </a>
                            @if($cat->children->count() > 0 && request('category') === $cat->slug)
                                <ul class="ml-4 mt-2 space-y-1 border-l-3 border-neu-black pl-2">
                                    @foreach($cat->children as $child)
                                        <li>
                                            <a href="{{ route('products.index', ['category' => $child->slug]) }}" 
                                               class="block px-3 py-1 font-semibold text-xs border-2 transition-colors {{ request('category') === $child->slug ? 'border-neu-black bg-neu-black text-white' : 'border-transparent text-gray-600 hover:border-neu-black hover:bg-neu-yellow hover:text-neu-black' }}">
                                                → {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Product List -->
        <div class="flex-1">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 border-3 border-neu-black bg-white mb-6" style="box-shadow: 4px 4px 0 #0D0D0D">
                <div class="text-sm font-bold text-neu-black">
                    Menampilkan <span class="badge-yellow mx-1">{{ $products->total() }}</span> produk
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-black uppercase text-neu-black">Urutkan:</span>
                    <form action="{{ route('products.index') }}" method="GET" class="m-0">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                        
                        <div class="relative">
                            <select name="sort" onchange="this.form.submit()" 
                                    class="appearance-none input-neu py-2 pl-4 pr-10 text-sm font-bold cursor-pointer hover:bg-neu-bg bg-white w-48 m-0 border-3 border-neu-black" style="box-shadow: 2px 2px 0 #0D0D0D; min-height: 0;">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terlaris</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Terendah</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neu-black">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" 
                   class="group product-card-neu block flex flex-col h-full bg-white">
                    <div class="aspect-square overflow-hidden border-b-3 border-neu-black relative shrink-0">
                        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @if($product->hasDiscount())
                        <div class="absolute top-0 right-0 bg-neu-yellow text-neu-black text-xs font-black px-2 py-1 border-l-3 border-b-3 border-neu-black">
                            -{{ $product->discount_percentage }}%
                        </div>
                        @endif
                    </div>
                    <div class="p-3 flex flex-col flex-1">
                        <h4 class="text-xs font-bold text-neu-black line-clamp-2 mb-2 leading-tight group-hover:text-neu-blue transition-colors">{{ $product->name }}</h4>
                        <div class="mt-auto">
                            <div class="flex flex-col mb-1">
                                <span class="font-black text-primary text-sm">@rupiah($product->price)</span>
                                @if($product->hasDiscount())
                                <span class="text-[10px] text-gray-500 line-through font-bold">@rupiah($product->compare_price)</span>
                                @endif
                            </div>
                            <div class="flex items-center text-[10px] gap-2 mt-2">
                                <span class="font-black text-neu-yellow bg-neu-black px-1.5 py-0.5 border border-neu-black">★ {{ $product->average_rating }}</span>
                                <span class="font-bold text-gray-500">{{ formatNumber($product->total_sold) }} terjual</span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full card-neu text-center py-16 bg-white">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-black text-neu-black uppercase mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-sm font-semibold text-gray-500 mb-6">Coba ubah filter atau gunakan kata kunci lain.</p>
                    <a href="{{ route('products.index') }}" class="btn-neu-primary inline-flex">
                        Hapus Filter
                    </a>
                </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
