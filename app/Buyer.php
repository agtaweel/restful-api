<?php

namespace App;

use App\Scops\BuyerScope;
use App\Transformers\BuyerTransfomer;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    //

    public $transfomer = BuyerTransfomer::class;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope());
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
