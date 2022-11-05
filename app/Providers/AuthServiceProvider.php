<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addMinutes(30));
        Passport::refreshTokensExpireIn(now()->addDays(15));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        Passport::tokensCan([
            'purchase-product' => 'Can create a Transaction',
            'managed-prodcut' => "Create, Read, Update and Delete Product (Product CRUD)",
            'managed-account' => "Read your account data such as id, name, email, is verified and is admin (cannot read password), modify your account details (email adn password only). CANNOT DELETE ACCOUNT!",
            'read-general' => "Read general information like purchasing categories, purchased products, selling products, selling categories, your transactions (purchases and sales)",
        ]);
    }
}
