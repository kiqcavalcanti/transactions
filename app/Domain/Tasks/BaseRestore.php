<?php


namespace App\Domain\Tasks;

use App\Domain\Entities\BaseModel;

class BaseRestore
{
    /**
     * @param string $entityClassName
     * @param $id
     * @return BaseModel
     */
    public static function execute(string $entityClassName, $id)
    {
        /**
         * @var BaseModel $entity
         */
        $entity = $entityClassName::find($id);

        $entity->restore();

        return $entity;
    }
}
