<?php

namespace App\Providers;

use App\Contracts\Service;
use App\Http\Controllers\Controller;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(Service::class, function () {
            $appMessage = config('app.app_message');
            $service = config('app.app_message_service.' . $appMessage);
            return app()->make($service);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        
    }
}
