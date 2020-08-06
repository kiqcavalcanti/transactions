<?php


namespace App\Domain\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class Customer extends BaseModel
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


    public function applyRequiredCondition($qb)
    {
        return $qb->where('id', Auth::user()->customer_id);
    }

}
