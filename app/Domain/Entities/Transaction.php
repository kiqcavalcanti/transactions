<?php


namespace App\Domain\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class Transaction extends BaseModel
{

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $allowedIncludes = [];
    protected $allowedFilters = [];
    protected $allowedFields = [];
    protected $allowedAppends = [];
    protected $exactFilters = [];
    protected $partialFilters = [];
    protected array $allowedScopes = [];


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function findWithQueryBuilder()
    {
        $qb = $this->getQueryBuilder();

        return $this->applyRequiredCondition($qb)
            ->get();
    }

    /**
     * @return Model|object|QueryBuilder|null
     */
    public function findOneWithQueryBuilder()
    {
        $qb = $this->getQueryBuilder();

        return $this->applyRequiredCondition($qb)
            ->first();
    }

    public function applyRequiredCondition($qb)
    {
        return $qb->where(function ($q) {
            $q
                ->orWhere('payee_customer_id', Auth::user()->customer_id)
                ->orWhere('payer_customer_id', Auth::user()->customer_id);
        });
    }

}
