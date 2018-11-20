<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    public function store(Request $request,Product $product,User $buyer)
    {
        $rules = ['quantity'=>'integer|min:1'];

        $this->validate($request,$rules);

        if($buyer->id == $product->seller_id)
        {
            return $this->errorResponse('Buyer must be different from seller.');
        }
        if(!$buyer->isVerified())
        {
            return $this->errorResponse('Buyer must be verified.');
        }

        if(!$product->seller->isVerified())
        {
            return $this->errorResponse('Seller must be verified.');
        }
        if(!$product->isAvailable())
        {
            return $this->errorResponse('Product is not available.');
        }
        if($product->quantity<$request->quantity)
        {
            return $this->errorResponse('This quantity is not available now.');
        }
        return DB::transaction(function ()use ($request,$product,$buyer)
        {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity'=>$request->quantity,
                'product_id'=>$product->id,
                'buyer_id'=>$buyer->id
            ]);

            return $this->showOne($transaction);
        });
    }


}
