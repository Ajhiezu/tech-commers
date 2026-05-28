@extends('layouts.marketplace')

@php
    /** @var \App\Models\Order $order */
    /** @var \App\Models\OrderItem $item */
@endphp

@section('content')
<div class="bg-neu-yellow border-b-3 border-neu-black py-8 mb-8">
    <div class="container mx-auto px-4">
        <a href="{{ route('buyer.orders.show', $order) }}" class="text-neu-black hover:text-white text-xs font-black uppercase tracking-widest mb-3 inline-block transition-colors bg-white px-2 py-1 border-2 border-neu-black" style="box-shadow: 2px 2px 0 #0D0D0D">
            &larr; KEMBALI
        </a>
        <h1 class="text-3xl md:text-4xl font-black text-neu-black uppercase tracking-tight">Beri Ulasan Produk</h1>
        <p class="text-sm font-bold text-neu-black/70 mt-1 uppercase tracking-widest">Bagikan pengalaman Anda</p>
    </div>
</div>

<div class="container mx-auto px-4 pb-12">
    <div class="max-w-3xl mx-auto">
        <!-- Product Summary -->
        <div class="card-neu bg-white p-5 flex flex-wrap md:flex-nowrap items-center gap-5 mb-8">
            <img src="{{ $item->product->primary_image_url }}" class="w-24 h-24 object-cover border-3 border-neu-black shrink-0 bg-neu-bg">
            <div class="flex-1 min-w-0">
                <h3 class="font-black text-neu-black uppercase line-clamp-2 leading-tight mb-2">{{ $item->product_name_snapshot }}</h3>
                <div class="text-xs font-bold text-gray-500 bg-gray-100 inline-block px-2 py-1 border border-neu-black uppercase">
                    Toko: {{ $order->store->name }}
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('reviews.store', ['order' => $order, 'item' => $item]) }}" method="POST" enctype="multipart/form-data" class="card-neu bg-white">
            @csrf
            
            <div class="mb-8 text-center pb-8 border-b-3 border-dashed border-gray-300">
                <label class="block text-sm font-black uppercase tracking-widest text-neu-black mb-4">Penilaian Produk</label>
                <div class="flex items-center justify-center gap-2 flex-row-reverse mx-auto w-max" x-data="{ rating: 5, hoverRating: 0 }">
                    <template x-for="i in 5">
                        <label class="cursor-pointer">
                            <input type="radio" name="rating" :value="6-i" x-model="rating" class="hidden">
                            <svg class="w-12 h-12 transition-colors" 
                                 :class="((hoverRating >= 6-i && hoverRating !== 0) || (rating >= 6-i && hoverRating === 0)) ? 'text-neu-yellow fill-current drop-shadow-[2px_2px_0_#0D0D0D]' : 'text-gray-300 stroke-current'" 
                                 @mouseenter="hoverRating = 6-i" @mouseleave="hoverRating = 0"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </label>
                    </template>
                </div>
                @error('rating')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Tulis Pengalaman Anda</label>
                <textarea name="comment" rows="5" required minlength="10" 
                          class="input-neu w-full resize-y font-medium text-sm" 
                          placeholder="Ceritakan kualitas produk, kecepatan pengiriman, dll...">{{ old('comment') }}</textarea>
                <div class="text-[10px] font-bold text-gray-500 mt-2 uppercase text-right">Minimal 10 karakter</div>
                @error('comment')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
            </div>

            <div class="mb-8">
                <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Foto Produk (Opsional)</label>
                <div class="border-3 border-dashed border-neu-black p-6 text-center bg-neu-bg hover:bg-neu-yellow/30 transition-colors">
                    <input type="file" name="images[]" multiple accept="image/*" id="photo-input" class="hidden" onchange="previewImages(this)">
                    <label for="photo-input" class="cursor-pointer block">
                        <div class="text-3xl mb-2">📸</div>
                        <div class="font-black text-xs uppercase text-neu-black tracking-wider border-b-2 border-neu-black inline-block">Pilih Foto</div>
                        <div class="text-[10px] font-bold text-gray-500 mt-2 uppercase">Maks 2MB per foto</div>
                    </label>
                </div>
                <div id="image-preview" class="mt-4 grid grid-cols-4 sm:grid-cols-5 gap-3"></div>
                @error('images.*')<p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-neu-primary w-full py-4 text-base">
                KIRIM ULASAN SEKARANG
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'border-3 border-neu-black overflow-hidden aspect-square bg-white shadow-[2px_2px_0_#0D0D0D]';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
