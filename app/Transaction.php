<?php

namespace App;

use App\Transformers\TransactionTransfomer;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    public $transfomer = TransactionTransfomer::class;

    protected $fillable =
        [
            'quantity',
            'buyer_id',
            'product_id'
        ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
