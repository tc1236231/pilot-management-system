<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Overtrue\EasySms\EasySms;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('easySms', function () {
            $config = config('easysms');
            return new EasySms($config);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
