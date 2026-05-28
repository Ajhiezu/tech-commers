@extends('layouts.seller')

@section('content')
<!-- Page Header -->
<div class="page-header-neu">
    <div class="flex items-center gap-4">
        <a href="{{ route('seller.products.index') }}"
           class="p-2 border-3 border-neu-black bg-white hover:bg-neu-yellow transition-colors"
           style="box-shadow: 3px 3px 0 #0D0D0D">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <div class="inline-block badge-blue mb-1">EDIT PRODUK</div>
            <h1 class="page-title-neu">{{ Str::limit($product->name, 40) }}</h1>
        </div>
    </div>
</div>

<form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Basic Info -->
            <div class="card-neu">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b-3 border-neu-black">
                    <div class="w-8 h-8 bg-neu-blue text-white flex items-center justify-center border-2 border-neu-black font-black text-sm">1</div>
                    <h3 class="font-black text-neu-black uppercase tracking-wide">Informasi Dasar</h3>
                </div>
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                            Nama Produk <span class="text-neu-red">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                               class="input-neu w-full">
                        @error('name')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                            Kategori <span class="text-neu-red">*</span>
                        </label>
                        <select name="category_id" required class="input-neu w-full">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->parent->name ?? '' }} › {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                            Deskripsi <span class="text-neu-red">*</span>
                        </label>
                        <textarea name="description" rows="6" required class="input-neu w-full resize-y">{{ old('description', $product->description) }}</textarea>
                        @error('description')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="card-neu">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b-3 border-neu-black">
                    <div class="w-8 h-8 bg-neu-yellow text-neu-black flex items-center justify-center border-2 border-neu-black font-black text-sm">2</div>
                    <h3 class="font-black text-neu-black uppercase tracking-wide">Harga & Inventaris</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Harga (Rp) <span class="text-neu-red">*</span></label>
                        <input type="number" name="price" value="{{ old('price', (int)$product->price) }}" min="0" required class="input-neu w-full">
                        @error('price')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Harga Coret (Rp)</label>
                        <input type="number" name="compare_price" value="{{ old('compare_price', (int)$product->compare_price) }}" min="0" class="input-neu w-full" placeholder="Kosongkan jika tidak diskon">
                        @error('compare_price')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Stok <span class="text-neu-red">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required class="input-neu w-full">
                        @error('stock')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="input-neu w-full uppercase bg-gray-50 cursor-not-allowed" readonly>
                        <p class="text-xs text-gray-500 font-semibold mt-1">SKU tidak dapat diubah.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Shipping -->
            <div class="card-neu">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b-3 border-neu-black">
                    <div class="w-8 h-8 bg-primary text-white flex items-center justify-center border-2 border-neu-black font-black text-sm">3</div>
                    <h3 class="font-black text-neu-black uppercase tracking-wide">Pengiriman</h3>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Berat Produk (Gram) <span class="text-neu-red">*</span></label>
                    <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" min="1" required class="input-neu w-full">
                    @error('weight')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Existing Photos -->
            <div class="card-neu">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b-3 border-neu-black">
                    <div class="w-8 h-8 bg-neu-pink text-white flex items-center justify-center border-2 border-neu-black font-black text-sm">4</div>
                    <h3 class="font-black text-neu-black uppercase tracking-wide">Foto Produk</h3>
                </div>

                <!-- Current Images -->
                @if($product->images->count() > 0)
                <div class="grid grid-cols-3 gap-2 mb-4">
                    @foreach($product->images as $image)
                    <div class="aspect-square border-3 border-neu-black overflow-hidden relative">
                        <img src="{{ $image->url }}" class="w-full h-full object-cover">
                        @if($loop->first)
                        <div class="absolute top-1 left-1 bg-neu-yellow border-2 border-neu-black px-1 text-xs font-black uppercase">Utama</div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="p-3 bg-neu-yellow/20 border-3 border-dashed border-neu-black text-xs font-bold text-gray-600 uppercase tracking-wider text-center">
                    🔒 Edit foto dinonaktifkan sementara
                </div>
            </div>

            <!-- Status & Submit -->
            <div class="card-neu">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b-3 border-neu-black">
                    <div class="w-8 h-8 bg-neu-green text-neu-black flex items-center justify-center border-2 border-neu-black font-black text-sm">5</div>
                    <h3 class="font-black text-neu-black uppercase tracking-wide">Status</h3>
                </div>
                <div class="mb-5">
                    <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Status Produk</label>
                    <select name="status" class="input-neu w-full">
                        <option value="active" {{ old('status', $product->status->value) == 'active' ? 'selected' : '' }}>✅ Aktif</option>
                        <option value="inactive" {{ old('status', $product->status->value) == 'inactive' ? 'selected' : '' }}>⏸️ Nonaktif</option>
                        <option value="out_of_stock" {{ old('status', $product->status->value) == 'out_of_stock' ? 'selected' : '' }} disabled>⛔ Habis</option>
                    </select>
                </div>

                <button type="submit" class="btn-neu-primary w-full py-4 text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
