<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransfomer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $tarnsaction)
    {
        return [
            'identifier'=>(int)$tarnsaction->id,
            'quantity'=>(string)$tarnsaction->quantity,
            'buyer'=>(string)$tarnsaction->buyer_id,
            'product'=>(int)$tarnsaction->product_id,
            'creationDate'=>$tarnsaction->created_at,
            'lastChange'=>$tarnsaction->updated_at,
            'deletedDate'=>isset($tarnsaction->deleted_at)?(string)$tarnsaction->deleted_at : null,
        ];
    }
}
