<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Enums\WithdrawalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerWalletController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $wallet = $store->wallet;
        $transactions = $wallet->transactions()->latest()->paginate(15);
        $withdrawals = $store->withdrawals()->latest()->take(5)->get();
        
        return view('seller.wallet.index', compact('wallet', 'transactions', 'withdrawals'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);

        $store = Auth::user()->store;
        $wallet = $store->wallet;

        if ($request->amount > $wallet->balance) {
            return back()->with('error', 'Saldo tidak mencukupi');
        }

        try {
            DB::transaction(function () use ($store, $wallet, $request) {
                $withdrawal = $store->withdrawals()->create([
                    'amount' => $request->amount,
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_name' => $request->account_name,
                    'status' => WithdrawalStatus::Pending,
                ]);

                $wallet->debit(
                    $request->amount,
                    "Penarikan dana #" . $withdrawal->id,
                    $withdrawal->id,
                    Withdrawal::class
                );
            });

            return back()->with('success', 'Permintaan penarikan berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
