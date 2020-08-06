<?php

namespace App\Providers;

use App\Domain\Entities\User;
use App\Domain\Entities\Customer;
use App\Domain\Entities\Transaction;
use App\Domain\Policies\UserPolicy;
use App\Domain\Policies\TransactionPolicy;
use App\Domain\Policies\CustomerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Customer::class => CustomerPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        //
    }
}
