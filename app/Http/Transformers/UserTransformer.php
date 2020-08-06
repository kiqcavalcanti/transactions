<?php


namespace App\Http\Transformers;

use App\Domain\Entities\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'active' => true,
            'created_at' => $user->created_at,
            'customer_id' => $user->customer_id,
            'email' => $user->email,
        ];
    }
}
