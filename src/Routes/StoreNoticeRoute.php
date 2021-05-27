<?php


namespace Rizhou\Control\Routes;

use Illuminate\Support\Facades\Route;
class StoreNoticeRoute extends RouteAbstract
{
    public function register(){
        $this->router->get('store-synchronizing','StoreController@synchronizing');
    }
}
