<?php

namespace App\Providers;

use App\Facades\QrCode;
use App\Services\QrCodeService;
use Illuminate\Support\ServiceProvider;

class QrCodeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register the service
        $this->app->singleton(QrCodeService::class, function () {
            return new QrCodeService();
        });

        // Register alias
        $this->app->alias(QrCode::class, 'QrCode');
    }

    public function boot(): void
    {
        //
    }
}
