<?php
declare(strict_types=1);

namespace warna720\Bokio;

use Illuminate\Support\ServiceProvider;

class BokioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/main.php' => config_path('bokio.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Bokio::class, function ($app) {
            return new Bokio();
        });
    }
}
