<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([TransactionObserver::class])]
class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['wallet_id', 'description', 'amount', 'type', 'happened_at'];

    protected $casts = ['happened_at' => 'datetime'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
