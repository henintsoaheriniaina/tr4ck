<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletStatus extends Model
{
    protected $fillable = [
        "label",
        "value",
    ];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}
