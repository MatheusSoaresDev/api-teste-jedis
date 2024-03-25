<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Client;
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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::enablePasswordGrant();
        Passport::hashClientSecrets();
        Passport::tokensExpireIn(now()->addHour());
        Passport::refreshTokensExpireIn(now()->addHours(2));

        Passport::tokensCan([
            'admin' => 'Add, Edit, Delete Data Scope',
            'user' => 'Read Data Scope',
        ]);

        Passport::setDefaultScope(['user']);
    }
}
