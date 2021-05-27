<?php


namespace Rizhou\Control;


use Illuminate\Support\ServiceProvider;
use Rizhou\Control\Routes\StoreNoticeRoute;

class ControlServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/control.php', 'control'
        );
        app(StoreNoticeRoute::class)->register();

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/config/control.php' => config_path('control.php'),
        ]);

    }
}
