<?php


namespace App\Domain\Entities;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BaseModel extends Model
{

    /**
     * Indicates when model key is UUID.
     *
     * @var string
     */
    protected $uuidKey = true;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    protected $defaultSort = '-created_at';
    protected $allowedSorts = ['created_at', 'id'];
    protected $allowedIncludes = [];
    protected $allowedFilters = [];
    protected $allowedFields = [];
    protected $allowedAppends = [];
    protected $exactFilters = [];
    protected $partialFilters = [];
    protected array $allowedScopes = [];


    /**
     * EntityRepository constructor.
     */
    public function __construct()
    {
        $this->allowedFilters = !blank($this->allowedFields)
            ? $this->allowedFilters
            : $this->getMergedAllowedFilters();

        parent::__construct();
    }

    /**
     * @return array
     */
    private function getMergedAllowedFilters(): array
    {
        $exactFilters = array_map(function ($item) {
            return AllowedFilter::exact($item);
        }, $this->exactFilters);

        $partialFilters = array_map(function ($item) {
            return AllowedFilter::partial($item);
        }, $this->partialFilters);

        $scopeFilters = array_map(function ($item) {
            return AllowedFilter::scope($item);
        }, $this->allowedScopes);

        return array_merge($exactFilters, $partialFilters, $scopeFilters);
    }


    /**
     * @param int|null $perPage
     * @param int|null $pageNumber
     * @param array|null $columns
     * @return LengthAwarePaginator
     */
    public function paginate(?int $perPage, ?int $pageNumber, ?array $columns): LengthAwarePaginator
    {
        return $this->getQueryBuilder()->paginate($perPage ?? 25, $columns ?? ['*'], 'page', $pageNumber ?? 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function findWithQueryBuilder()
    {
        return $this->getQueryBuilder()->get();
    }

    /**
     * @return Model|object|QueryBuilder|null
     */
    public function findOneWithQueryBuilder()
    {
        return $this->getQueryBuilder()->first();
    }

    public function getQueryBuilder(): QueryBuilder
    {
        $queryBuilder = QueryBuilder::for(get_class($this))
            ->allowedFields($this->allowedFields)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedAppends($this->allowedAppends)
            ->allowedFilters($this->allowedFilters)
            ->allowedSorts($this->allowedSorts)
            ->defaultSort($this->defaultSort);

        $limit = request()->input('page.limit');
        $offset = request()->input('page.offset');

        if (!blank($limit)) {
            $queryBuilder = $queryBuilder->limit((int)$limit);
        }


        if (!blank($offset)) {
            $queryBuilder = $queryBuilder->skip((int)$offset);
        }

        return $queryBuilder;
    }

}
