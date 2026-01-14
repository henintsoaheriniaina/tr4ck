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
        "balance",
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    protected static function booted()
    {
        static::deleted(function ($wallet) {
            $wallet->transactions()->delete();
        });

        static::restoring(function ($wallet) {
            $wallet->transactions()->restore();
        });
    }
}
