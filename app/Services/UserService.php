<?php


namespace App\Services;

use App\Domain\Entities\User;

class UserService extends BaseService
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
