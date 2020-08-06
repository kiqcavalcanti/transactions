<?php


namespace App\Services;

use App\Domain\Entities\BaseModel;
use App\Domain\Tasks\BaseCreate;
use App\Domain\Tasks\BaseDelete;
use App\Domain\Tasks\BaseRestore;
use App\Domain\Tasks\BaseUpdate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BaseService
{

    protected $entity;

    protected $transformer;

    /**
     * BaseService constructor.
     * @param BaseModel $entity
     */
    public function __construct(BaseModel $entity)
    {
        $this->entity = $entity;
    }

    public function getEntityClassName()
    {
        return class_basename($this->entity);
    }

    public function getEntityClass()
    {
        return get_class($this->entity);
    }

    public function find($id)
    {
        return $this->entity->query()->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function findWithQueryBuilder()
    {
        return $this->entity->findWithQueryBuilder();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|object|\Spatie\QueryBuilder\QueryBuilder|null
     */
    public function findOneWithQueryBuilder()
    {
        return $this->entity->findOneWithQueryBuilder();
    }

    /**
     * @param int|null $perPage
     * @param int|null $pageNumber
     * @param array|null $columns
     * @return LengthAwarePaginator
     */
    public function paginate(?int $perPage, ?int $pageNumber, ?array $columns): LengthAwarePaginator
    {
        return $this->entity->paginate($perPage, $pageNumber, $columns);
    }

    public function create(array $attributes)
    {
        return BaseCreate::execute($this->entity, $attributes);
    }

    public function update(BaseModel $model, array $attributes = [])
    {
        return BaseUpdate::execute($model, $attributes);
    }

    /**
     * @param BaseModel $model
     * @return BaseModel
     * @throws \Exception
     */
    public function delete(BaseModel $model)
    {
        return BaseDelete::execute($model);
    }

    /**
     * @param $model
     * @return BaseModel
     */
    public function restore($model)
    {
        return BaseRestore::execute($model);
    }


}
