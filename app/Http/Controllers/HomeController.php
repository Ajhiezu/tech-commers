<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\FlashSale;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::roots()->with('children')->ordered()->get();
        
        $flashSale = FlashSale::active()->with(['items.product'])->first();
        
        $featuredStores = Store::featured()->take(6)->get();
        
        $trendingProducts = Product::published()
            ->with(['store', 'primaryImage'])
            ->trending()
            ->take(12)
            ->get();
            
        $newProducts = Product::published()
            ->with(['store', 'primaryImage'])
            ->latest()
            ->take(12)
            ->get();

        return view('home.index', compact(
            'categories', 
            'flashSale', 
            'featuredStores', 
            'trendingProducts', 
            'newProducts'
        ));
    }
}
