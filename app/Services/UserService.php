<?php

namespace App\Services;

use App\Domain\Entities\BaseModel;
use App\Domain\Entities\User;

class UserService extends BaseService
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**+
     * @param BaseModel $model
     * @param array $attributes
     * @return BaseModel|User
     */
    public function update(BaseModel $model, array $attributes = []): BaseModel
    {
        return parent::update($model, $attributes);
    }
}
