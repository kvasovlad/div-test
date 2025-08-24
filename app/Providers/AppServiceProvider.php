<?php

namespace App\Providers;

use App\Interfaces\MailServiceInterface;
use App\Services\FileMailService;
use App\Services\NullMailService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MailServiceInterface::class, function ($app) {
            if (config('mail.default') === 'null') {
                return new NullMailService();
            }

            return new FileMailService();
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
