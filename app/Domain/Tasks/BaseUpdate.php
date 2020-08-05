<?php


namespace App\Domain\Tasks;


use App\Domain\Entities\BaseModel;

class BaseUpdate
{
    /**
     * @param BaseModel $entity
     * @param $attributes
     * @return BaseModel
     */
    public static function execute(BaseModel $entity, $attributes)
    {
        foreach ($attributes as $key => $value) {
            $entity[$key] = $value;
        }

        $entity->save();

        return $entity;
    }
}
