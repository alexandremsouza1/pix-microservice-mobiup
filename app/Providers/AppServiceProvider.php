<?php

namespace App\Providers;

use App\Adapters\Interfaces\PixAdapterInterface;
use App\Adapters\PixItauAdapter;
use App\Adapters\PixGetNetAdapter;
use App\Models\Pix;
use App\Repositories\PixRepository;
use App\Services\PixService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $classAdapted = null;

        switch (env('GATEWAY_CHOOSED')) {
            case 'GETNET':
                $classAdapted = PixGetNetAdapter::class;
                break;
            case 'ITAU':
                $classAdapted = PixItauAdapter::class;
                break;
            default:
                $classAdapted = PixItauAdapter::class;
                break;
        }

        $this->app->singleton(PixAdapterInterface::class, $classAdapted);
    
        $this->app->singleton(PixRepository::class, function ($app) {
            return new PixRepository($app->make(Pix::class));
        });
        
        $this->app->singleton(PixService::class, function ($app) {
            return new PixService(
                $app->make(PixRepository::class),
                $app->make(PixAdapterInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
