<?php

namespace App;

use App\Scops\SellerScope;
use App\Transformers\SellerTransfomer;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    //

    public $transfomer = SellerTransfomer::class;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SellerScope());
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
