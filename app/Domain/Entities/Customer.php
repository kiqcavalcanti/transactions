<?php

namespace App\Domain\Entities;

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

    protected $fillable = [
        'primary_registry',
        'primary_registry_type_id',
        'name'
    ];

    protected $allowedIncludes = [];
    protected $allowedFilters = [];
    protected $allowedFields = [];
    protected $allowedAppends = [];
    protected $exactFilters = [];
    protected $partialFilters = [];
    protected array $allowedScopes = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
