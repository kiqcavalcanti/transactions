<?php

namespace App\Domain\Tasks;

use App\Domain\Entities\BaseModel;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class BaseCreate
{
    public static function execute(BaseModel $entity, array $attributes)
    {
        $attributes = Arr::only($attributes, $entity->getFillable());

        foreach ($attributes as $key => $value) {
            $entity->$key = $value;
        }

        $entity->active = true;
        $entity->id = Uuid::uuid4()->toString();

        $entity->save();

        return $entity;
    }
}
