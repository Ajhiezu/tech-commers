<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'amount'       => 'decimal:2',
        'balance_after' => 'decimal:2',
        'created_at'   => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->created_at = now());
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function isCredit(): bool { return $this->type === 'credit'; }
    public function isDebit(): bool  { return $this->type === 'debit'; }
}
