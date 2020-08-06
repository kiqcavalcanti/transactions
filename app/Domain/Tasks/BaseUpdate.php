<?php

namespace App\Domain\Tasks;

use App\Domain\Entities\BaseModel;
use Illuminate\Support\Arr;

class BaseUpdate
{
    /**
     * @param BaseModel $entity
     * @param $attributes
     * @return BaseModel
     */
    public static function execute(BaseModel $entity, array $attributes = [])
    {
        $attributes = Arr::only($attributes, $entity->getFillable());

        foreach ($attributes as $key => $value) {
            $entity->$key = $value;
        }

        $entity->save();

        return $entity;
    }
}
