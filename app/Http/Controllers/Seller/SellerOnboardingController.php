<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreDocument;
use Illuminate\Http\Request;

class SellerOnboardingController extends Controller
{
    public function index()
    {
        $store = request()->user()->store;
        
        if ($store) {
            if ($store->status === 'pending') return redirect()->route('seller.onboarding.pending');
            if ($store->status === 'rejected') return redirect()->route('seller.onboarding.rejected');
            return redirect()->route('seller.dashboard');
        }
        
        return view('seller.onboarding.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:stores',
            'address' => 'required|string',
            'doc_ktp' => 'required|image|max:2048',
            'doc_npwp' => 'nullable|image|max:2048',
        ]);

        $store = Store::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'slug' => $request->slug,
            'address' => $request->address,
            'status' => 'pending',
        ]);

        if ($request->hasFile('doc_ktp')) {
            $path = $request->file('doc_ktp')->store('documents', 'public');
            StoreDocument::create([
                'store_id' => $store->id,
                'type' => 'ktp',
                'file_path' => $path,
            ]);
        }

        if ($request->hasFile('doc_npwp')) {
            $path = $request->file('doc_npwp')->store('documents', 'public');
            StoreDocument::create([
                'store_id' => $store->id,
                'type' => 'npwp',
                'file_path' => $path,
            ]);
        }

        return redirect()->route('seller.onboarding.pending');
    }

    public function pending()
    {
        return view('seller.onboarding.pending');
    }

    public function rejected()
    {
        return view('seller.onboarding.rejected');
    }
}
