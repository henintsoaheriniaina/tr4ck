<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Wallet extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "user_id",
        "name",
        "slug",
        "balance",
        "wallet_status_id",
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($wallet) {
            $wallet->slug = Str::slug($wallet->name);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(WalletStatus::class, 'wallet_status_id');
    }
}
