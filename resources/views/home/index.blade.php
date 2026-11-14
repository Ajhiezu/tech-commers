@extends('layouts.marketplace')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="bg-neu-yellow border-b-3 border-neu-black overflow-hidden">
    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">

            {{-- Main Banner --}}
            <div class="md:col-span-2 relative border-3 border-neu-black overflow-hidden"
                 style="box-shadow: 6px 6px 0 #0D0D0D; min-height: 320px;">
                <img data-image-type="banner" src="{{ asset('images/placeholders/banner.svg') }}"
                     alt="Banner Utama"
                     class="w-full h-full object-cover absolute inset-0">
                {{-- Overlay --}}
                <div class="absolute inset-0 bg-neu-black/60 flex flex-col justify-end p-6 md:p-10">
                    <div class="inline-block badge-yellow mb-3 text-sm">🔥 PROMO HARI INI</div>
                    <h2 class="text-white text-3xl md:text-5xl font-black uppercase leading-tight mb-4">
                        Diskon<br>Gila-Gilaan<br>
                        <span class="text-neu-yellow">Sampai 90%!</span>
                    </h2>
                    <a href="{{ route('products.index') }}"
                       class="btn-neu bg-neu-yellow text-neu-black w-max text-base">
                        BELANJA SEKARANG →
                    </a>
                </div>
            </div>

            {{-- Side Banners --}}
            <div class="hidden md:flex flex-col gap-4">
                <div class="relative border-3 border-neu-black overflow-hidden flex-1"
                     style="box-shadow: 4px 4px 0 #0D0D0D; min-height: 150px;">
                    <img data-image-type="banner" src="{{ asset('images/placeholders/banner.svg') }}"
                         class="w-full h-full object-cover absolute inset-0">
                    <div class="absolute inset-0 bg-neu-blue/70 flex items-end p-4">
                        <div class="font-black text-white text-lg uppercase">Gratis Ongkir<br>Min. 0 Rupiah</div>
                    </div>
                </div>
                <div class="relative border-3 border-neu-black overflow-hidden flex-1"
                     style="box-shadow: 4px 4px 0 #0D0D0D; min-height: 150px;">
                    <img data-image-type="banner" src="{{ asset('images/placeholders/banner.svg') }}"
                         class="w-full h-full object-cover absolute inset-0">
                    <div class="absolute inset-0 bg-neu-green/70 flex items-end p-4">
                        <div class="font-black text-neu-black text-lg uppercase">Cashback<br>Hingga 50%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CATEGORIES ===== --}}
<section class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-5">
        <div>
            <div class="inline-block badge-blue mb-1">JELAJAHI</div>
            <h2 class="text-2xl font-black uppercase text-neu-black">Kategori Pilihan</h2>
        </div>
    </div>
    <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-10 gap-3">
        @foreach($categories->take(10) as $cat)
        <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
           class="group flex flex-col items-center gap-2 p-3 border-3 border-neu-black bg-white transition-all hover:bg-neu-yellow"
           style="box-shadow: 3px 3px 0 #0D0D0D; transition: transform 0.1s, box-shadow 0.1s;"
           onmouseover="this.style.transform='translate(-2px,-2px)'; this.style.boxShadow='5px 5px 0 #0D0D0D'"
           onmouseout="this.style.transform=''; this.style.boxShadow='3px 3px 0 #0D0D0D'">
            <div class="w-10 h-10 bg-neu-bg border-2 border-neu-black flex items-center justify-center text-xl">
                📦
            </div>
            <span class="text-[10px] font-black text-neu-black uppercase text-center leading-tight">{{ $cat->name }}</span>
        </a>
        @endforeach
    </div>
</section>

{{-- ===== FLASH SALE ===== --}}
@if($flashSale && $flashSale->items->count() > 0)
<section class="container mx-auto px-4 pb-8">
    <div class="border-3 border-neu-black overflow-hidden" style="box-shadow: 5px 5px 0 #0D0D0D">

        {{-- Flash Sale Header --}}
        <div class="flex items-center justify-between px-5 py-4 bg-neu-red border-b-3 border-neu-black"
             x-data="{ countdown: '05:42:11' }">
            <div class="flex items-center gap-4">
                <h3 class="text-xl font-black text-white uppercase tracking-wider flex items-center gap-2">
                    ⚡ FLASH SALE
                </h3>
                <div class="bg-neu-black text-neu-yellow px-3 py-1.5 border-2 border-neu-yellow font-black text-sm tracking-widest">
                    {{ now()->addHours(5)->addMinutes(42)->addSeconds(11)->format('H:i:s') }}
                </div>
            </div>
            <a href="{{ route('products.index') }}"
               class="text-xs font-black uppercase text-white border-2 border-white px-3 py-1.5 hover:bg-white hover:text-neu-red transition-colors">
                LIHAT SEMUA →
            </a>
        </div>

        {{-- Flash Sale Items --}}
        <div class="p-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 bg-neu-bg">
            @foreach($flashSale->items->take(6) as $item)
            <a href="{{ route('products.show', $item->product->slug) }}"
               class="group product-card-neu block bg-white">
                <div class="relative aspect-square overflow-hidden border-b-3 border-neu-black">
                    <img src="{{ $item->product->primary_image_url }}"
                         alt="{{ $item->product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                    <div class="absolute top-0 left-0 bg-neu-red text-white text-xs font-black px-2 py-1 border-r-3 border-b-3 border-neu-black">
                        -{{ $item->discount_percentage }}%
                    </div>
                </div>
                <div class="p-3">
                    <h4 class="text-xs font-bold text-neu-black line-clamp-2 mb-2 leading-tight">{{ $item->product->name }}</h4>
                    <div class="text-primary font-black text-sm">@rupiah($item->getSalePrice())</div>
                    <div class="text-xs text-gray-400 line-through font-semibold">@rupiah($item->product->price)</div>
                    {{-- Progress bar --}}
                    <div class="mt-2 w-full bg-gray-200 border border-neu-black h-2">
                        @php $pct = $item->stock_limit > 0 ? min(($item->sold_count / $item->stock_limit) * 100, 100) : 0; @endphp
                        <div class="bg-neu-red h-full" style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="text-[10px] font-bold text-gray-500 mt-1">Terjual {{ $item->sold_count }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== PROMO BANNERS ===== --}}
<section class="container mx-auto px-4 pb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach([
            ['bg-neu-blue', 'text-white', '🚚', 'GRATIS ONGKIR', 'Ke seluruh Indonesia'],
            ['bg-neu-yellow', 'text-neu-black', '💳', 'CICILAN 0%', 'Semua metode pembayaran'],
            ['bg-neu-green', 'text-neu-black', '🔒', 'BELANJA AMAN', 'Garansi uang kembali'],
        ] as [$bg, $tc, $icon, $title, $desc])
        <div class="flex items-center gap-4 p-5 border-3 border-neu-black {{ $bg }} {{ $tc }}"
             style="box-shadow: 4px 4px 0 #0D0D0D">
            <div class="text-4xl">{{ $icon }}</div>
            <div>
                <div class="font-black uppercase text-sm">{{ $title }}</div>
                <div class="text-xs font-semibold opacity-80">{{ $desc }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== TRENDING PRODUCTS ===== --}}
<section class="container mx-auto px-4 pb-8">
    <div class="flex items-center justify-between mb-5">
        <div>
            <div class="inline-block badge-red mb-1">🔥 HOT</div>
            <h2 class="text-2xl font-black uppercase text-neu-black">Produk Terlaris</h2>
        </div>
        <a href="{{ route('products.index', ['sort' => 'popular']) }}"
           class="btn-neu btn-neu-sm bg-white">LIHAT SEMUA →</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
        @foreach($trendingProducts as $product)
        <a href="{{ route('products.show', $product->slug) }}"
           class="group product-card-neu block bg-white">
            <div class="aspect-square overflow-hidden border-b-3 border-neu-black">
                <img src="{{ $product->primary_image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
            </div>
            <div class="p-3">
                <h4 class="text-xs font-bold text-neu-black line-clamp-2 mb-1 leading-tight">{{ $product->name }}</h4>
                <div class="font-black text-primary text-sm">@rupiah($product->price)</div>
                <div class="flex items-center gap-1 mt-1">
                    <span class="text-[10px] font-bold text-neu-yellow">★ {{ $product->average_rating }}</span>
                    <span class="text-[10px] text-gray-400 font-semibold">· {{ formatNumber($product->total_sold) }} terjual</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- ===== NEW ARRIVALS ===== --}}
<section class="container mx-auto px-4 pb-16">
    <div class="flex items-center justify-between mb-5">
        <div>
            <div class="inline-block badge-green mb-1">✨ BARU</div>
            <h2 class="text-2xl font-black uppercase text-neu-black">Produk Terbaru</h2>
        </div>
        <a href="{{ route('products.index', ['sort' => 'newest']) }}"
           class="btn-neu btn-neu-sm bg-white">LIHAT SEMUA →</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
        @foreach($newProducts as $product)
        <a href="{{ route('products.show', $product->slug) }}"
           class="group product-card-neu block bg-white">
            <div class="aspect-square overflow-hidden border-b-3 border-neu-black">
                <img src="{{ $product->primary_image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
            </div>
            <div class="p-3">
                <h4 class="text-xs font-bold text-neu-black line-clamp-2 mb-1 leading-tight">{{ $product->name }}</h4>
                <div class="font-black text-primary text-sm">@rupiah($product->price)</div>
                <div class="text-[10px] text-gray-400 font-semibold mt-1">📍 {{ $product->store->city }}</div>
            </div>
        </a>
        @endforeach
    </div>
</section>

@endsection
