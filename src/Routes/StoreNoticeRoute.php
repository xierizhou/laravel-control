<?php


namespace Rizhou\Control\Routes;

use Illuminate\Support\Facades\Route;
class StoreNoticeRoute extends RouteAbstract
{
    public function register(){
        $this->router->get('store-synchronizing','StoreController@synchronizing');

        $this->router->get('get-store-city','StoreController@getCity');
        $this->router->get('get-store-county','StoreController@getCounty');
        $this->router->get('get-store-road','StoreController@getRoad');
        $this->router->get('get-store-shop','StoreController@getShop');
    }
}
