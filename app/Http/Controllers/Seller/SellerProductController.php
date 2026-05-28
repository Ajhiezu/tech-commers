<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Enums\ProductStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SellerProductController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $products = Auth::user()->store->products()
            ->with('category')
            ->latest()
            ->paginate(15);
            
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::whereNotNull('parent_id')->get();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:1',
            'status' => 'required|string|in:active,inactive',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $product = Auth::user()->store->products()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'sku' => $request->sku ?? strtoupper(Str::random(8)),
            'status' => ProductStatus::from($request->status),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = \App\Models\Category::whereNotNull('parent_id')->get();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:1',
            'status' => 'required|string|in:active,inactive',
        ]);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'status' => ProductStatus::from($request->status),
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus');
    }
}
