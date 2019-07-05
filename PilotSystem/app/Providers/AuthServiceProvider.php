<?php

namespace App\Providers;

use App\Extensions\CBSUserProvider;
use App\Extensions\NewUserProvider;
use App\Models\NewUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('bbs', function ($app, array $config) {
           return new NewUserProvider();
        });

        Auth::provider('cbs', function ($app, array $config) {
            return new CBSUserProvider();
        });
    }
}
