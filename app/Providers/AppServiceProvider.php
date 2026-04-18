<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use App\Http\Middleware\AdminMiddleware;
use App\Services\PDFService;
use App\Services\QRCodeService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(QRCodeService::class);
        $this->app->singleton(PDFService::class);
    }

    public function boot(): void
    {
        // Use custom pagination view for admin
        Paginator::defaultView('admin.pagination');
    }
}
