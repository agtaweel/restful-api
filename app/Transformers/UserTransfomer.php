<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransfomer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier'=>(int)$user->id,
            'name'=>(string)$user->name,
            'email'=>(string)$user->mail,
            'isVerified'=>(int)$user->verified,
            'isAdmin'=>($user->admin=='true'),
            'creationDate'=>$user->created_at,
            'lastChange'=>$user->updated_at,
            'deletedDate'=>isset($user->deleted_at)?(string)$user->deleted_at : null,
        ];
    }
}
