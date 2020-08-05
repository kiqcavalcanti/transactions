<?php


namespace App\Domain\Tasks;


use App\Domain\Entities\BaseModel;

class BaseDelete
{
    /**
     * @param BaseModel $entity
     * @return BaseModel
     * @throws \Exception
     */
    public static function execute(BaseModel $entity)
    {
        $entity->delete();

        return $entity;
    }
}
