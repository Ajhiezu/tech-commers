<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::published()->with(['store', 'primaryImage']);

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhereHas('store', fn($q) => $q->where('name', 'like', '%' . $request->q . '%'));
        }

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                // simple search
                $query->where('category_id', $category->id);
            }
        }

        if ($request->has('sort')) {
            match($request->sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest' => $query->latest(),
                'popular' => $query->orderByDesc('total_sold'),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }

        $products = $query->paginate(24);
        $categories = Category::roots()->with('children')->ordered()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::published()
            ->with(['store', 'images', 'category', 'reviews.buyer'])
            ->where('slug', $slug)
            ->firstOrFail();

        $product->incrementViews();

        $relatedProducts = Product::published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(6)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
