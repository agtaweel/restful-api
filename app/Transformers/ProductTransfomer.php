<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransfomer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier'=>(int)$product->id,
            'title'=>(string)$product->name,
            'details'=>(string)$product->description,
            'stock'=>(int)$product->quantity,
            'situation'=>(string)$product->status,
            'picture'=>url("img/{$product->status}"),
            'creationDate'=>$product->created_at,
            'lastChange'=>$product->updated_at,
            'deletedDate'=>isset($product->deleted_at)?(string)$product->deleted_at : null,
        ];
    }
}
