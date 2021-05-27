<?php


namespace Rizhou\Control\Routes;



use Illuminate\Support\Facades\Route;

abstract class RouteAbstract
{
    protected $router;

    public function __construct()
    {
        $this->router = app('router');

        $this->router->prefix('control')
            ->namespace("Rizhou\Control\Controllers")
            ->group(function(){
                $this->register();
            });
    }

    abstract public function register();



}
