<?php


namespace App\Http\Transformers;

use App\Domain\Entities\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id
        ];
    }
}
