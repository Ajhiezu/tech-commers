<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreDocument extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }
}
