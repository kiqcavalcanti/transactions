<?php

namespace App\Domain\Entities;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use \Illuminate\Auth\Authenticatable;
use \Illuminate\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use HasApiTokens, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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

    public function setPasswordAttribute($value)
    {
        if (!blank($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
