<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreWallet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'balance'          => 'decimal:2',
        'pending_balance'  => 'decimal:2',
        'total_earned'     => 'decimal:2',
        'total_withdrawn'  => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class, 'store_id', 'store_id');
    }

    public function getFormattedBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }

    public function getFormattedPendingBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->pending_balance, 0, ',', '.');
    }

    public function credit(float $amount, string $description, string $refId = null, string $refType = null): void
    {
        $this->increment('balance', $amount);
        $this->increment('total_earned', $amount);
        $this->createTransaction('credit', $amount, $description, $refId, $refType);
    }

    public function debit(float $amount, string $description, string $refId = null, string $refType = null): void
    {
        $this->decrement('balance', $amount);
        $this->increment('total_withdrawn', $amount);
        $this->createTransaction('debit', $amount, $description, $refId, $refType);
    }

    public function addPending(float $amount): void
    {
        $this->increment('pending_balance', $amount);
    }

    public function releasePending(float $amount): void
    {
        $this->decrement('pending_balance', $amount);
        $this->increment('balance', $amount);
        $this->increment('total_earned', $amount);
    }

    private function createTransaction(string $type, float $amount, string $description, $refId, $refType): void
    {
        WalletTransaction::create([
            'store_id'       => $this->store_id,
            'type'           => $type,
            'amount'         => $amount,
            'description'    => $description,
            'reference_id'   => $refId,
            'reference_type' => $refType,
            'balance_after'  => $this->fresh()->balance,
        ]);
    }
}
