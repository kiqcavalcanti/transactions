<?php


namespace App\Domain\Tasks;

use App\Domain\Entities\BaseModel;

class BaseRestore
{
    /**
     * @param BaseModel $entity
     * @return BaseModel
     */
    public static function execute(BaseModel $entity)
    {
        $entity->active = true;

        return $entity;
    }
}
