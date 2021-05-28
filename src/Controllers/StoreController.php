<?php


namespace Rizhou\Control\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Rizhou\Control\Supply\StoreSynchronizing;

class StoreController extends Controller
{
    public function synchronizing(){
        StoreSynchronizing::make()->synchro();
    }

    public function getCity(){
        $city = StoreSynchronizing::make()->getCity();
        return response()->json(json_encode($city,JSON_UNESCAPED_UNICODE));
    }

    public function getCounty($city_name){
        $data = StoreSynchronizing::make()->getCounty($city_name);
        return response()->json(json_encode($data,JSON_UNESCAPED_UNICODE));
    }

    public function getRoad($city_name,$county_name){
        $data = StoreSynchronizing::make()->getRoad($city_name,$county_name);
        return response()->json(json_encode($data,JSON_UNESCAPED_UNICODE));
    }

    public function getShop($city_name,$county_name,$road_name){
        $data = StoreSynchronizing::make()->getShop($city_name,$county_name,$road_name);
        return response()->json(json_encode($data,JSON_UNESCAPED_UNICODE));
    }

}
