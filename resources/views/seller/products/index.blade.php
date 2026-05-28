@extends('layouts.seller')

@section('content')
<!-- Page Header -->
<div class="page-header-neu">
    <div>
        <div class="inline-block badge-blue mb-2">KATALOG</div>
        <h1 class="page-title-neu">Daftar Produk</h1>
        <p class="text-sm font-semibold text-gray-500 mt-1">Kelola semua produk toko Anda.</p>
    </div>
    <a href="{{ route('seller.products.create') }}" class="btn-neu-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
        </svg>
        TAMBAH PRODUK
    </a>
</div>

<!-- Table Card -->
<div class="card-neu p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-neu w-full">
            <thead>
                <tr>
                    <th class="w-1/2">Info Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="flex items-center gap-3 min-w-[280px]">
                        <img src="{{ $product->primary_image_url }}"
                             class="w-14 h-14 object-cover border-3 border-neu-black shrink-0">
                        <div>
                            <div class="font-bold text-neu-black max-w-[240px] truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </div>
                            <div class="text-xs font-semibold text-gray-500 mt-0.5">{{ $product->category->name }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="font-black text-neu-black">@rupiah($product->price)</div>
                        @if($product->hasDiscount())
                        <div class="text-xs text-gray-400 line-through font-semibold">@rupiah($product->compare_price)</div>
                        @endif
                    </td>
                    <td>
                        <span class="font-black text-lg {{ $product->stock <= 5 ? 'text-neu-red' : 'text-neu-black' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'active'   => 'badge-green',
                                'inactive' => 'badge-red',
                                'draft'    => 'badge-yellow',
                            ];
                            $sc = $statusMap[$product->status->value ?? ''] ?? 'badge-white';
                        @endphp
                        <span class="{{ $sc }}">{{ $product->status->label() }}</span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <!-- View -->
                            <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                               class="p-2 border-3 border-neu-black bg-white hover:bg-neu-yellow transition-colors"
                               style="box-shadow: 2px 2px 0 #0D0D0D"
                               title="Lihat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <!-- Edit -->
                            <a href="{{ route('seller.products.edit', $product) }}"
                               class="p-2 border-3 border-neu-black bg-neu-blue text-white hover:bg-neu-black transition-colors"
                               style="box-shadow: 2px 2px 0 #0D0D0D"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <!-- Delete -->
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('Hapus produk ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-2 border-3 border-neu-black bg-neu-red text-white hover:bg-neu-black transition-colors"
                                        style="box-shadow: 2px 2px 0 #0D0D0D"
                                        title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="text-5xl mb-4">🛍️</div>
                        <div class="font-black text-gray-400 uppercase text-sm mb-4">Belum ada produk</div>
                        <a href="{{ route('seller.products.create') }}" class="btn-neu-primary btn-neu-sm">
                            + Tambah Produk Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-5 py-4 border-t-3 border-neu-black bg-neu-bg">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
