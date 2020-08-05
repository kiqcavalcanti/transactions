<?php

namespace App\Domain\Tasks;

use App\Domain\Entities\BaseModel;

class BaseCreate
{
    public static function execute(BaseModel $entity, array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $entity[$key] = $value;
        }

        $entity->save();

        return $entity;
    }
}
