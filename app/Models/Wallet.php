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
}
