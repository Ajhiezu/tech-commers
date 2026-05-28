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
            <div class="inline-block badge-green mb-1">PRODUK BARU</div>
            <h1 class="page-title-neu">Tambah Produk</h1>
        </div>
    </div>
</div>

<form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
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
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="input-neu w-full" placeholder="Masukkan nama produk...">
                        @error('name')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                            Kategori <span class="text-neu-red">*</span>
                        </label>
                        <select name="category_id" required class="input-neu w-full">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <textarea name="description" rows="6" required
                                  class="input-neu w-full resize-y"
                                  placeholder="Deskripsikan produk Anda secara detail...">{{ old('description') }}</textarea>
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
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                            Harga (Rp) <span class="text-neu-red">*</span>
                        </label>
                        <input type="number" name="price" value="{{ old('price') }}" min="0" required
                               class="input-neu w-full" placeholder="0">
                        @error('price')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                            Harga Coret (Rp)
                        </label>
                        <input type="number" name="compare_price" value="{{ old('compare_price') }}" min="0"
                               class="input-neu w-full" placeholder="Kosongkan jika tidak diskon">
                        @error('compare_price')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                            Stok <span class="text-neu-red">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required
                               class="input-neu w-full">
                        @error('stock')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                               class="input-neu w-full uppercase" placeholder="Otomatis jika kosong">
                        @error('sku')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
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
                    <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                        Berat Produk (Gram) <span class="text-neu-red">*</span>
                    </label>
                    <input type="number" name="weight" value="{{ old('weight', 1000) }}" min="1" required
                           class="input-neu w-full">
                    @error('weight')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Photos -->
            <div class="card-neu">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b-3 border-neu-black">
                    <div class="w-8 h-8 bg-neu-pink text-white flex items-center justify-center border-2 border-neu-black font-black text-sm">4</div>
                    <h3 class="font-black text-neu-black uppercase tracking-wide">Foto Produk</h3>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                        Upload Foto <span class="text-neu-red">*</span>
                    </label>
                    <div class="border-3 border-dashed border-neu-black p-6 text-center bg-neu-bg cursor-pointer hover:bg-neu-yellow/30 transition-colors">
                        <input type="file" name="images[]" multiple accept="image/*" id="photo-input"
                               class="hidden" onchange="previewImages(this)">
                        <label for="photo-input" class="cursor-pointer">
                            <div class="text-3xl mb-2">📷</div>
                            <div class="font-black text-xs uppercase text-gray-500 tracking-wider">Klik untuk Upload</div>
                            <div class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP · Max 2MB per foto</div>
                        </label>
                    </div>
                    <div id="image-preview" class="mt-3 grid grid-cols-3 gap-2"></div>
                    <p class="text-xs text-gray-500 font-semibold mt-2">Foto pertama = foto utama produk.</p>
                    @error('images')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
                    @error('images.*')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
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
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>✅ Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>⏸️ Nonaktif</option>
                    </select>
                </div>

                <button type="submit" class="btn-neu-primary w-full py-4 text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    SIMPAN PRODUK
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'border-3 border-neu-black overflow-hidden aspect-square';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
@endsection
