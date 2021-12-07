<?php


namespace Rizhou\Control\Supply;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class StoreSynchronizing
{
    private $guard = '711';

    private $store = [];

    private $is_synchro = false;

    private static $instance;

    private function __construct($guard)
    {

        $this->guard = $guard;
        if(file_exists($this->getJsonPath())){
            $store = file_get_contents($this->getJsonPath());
            if($store && trim($store) && !$this->isRenew()){
                $this->store = json_decode($store,true);
            }else{
                try {
                    $this->synchro();
                }catch (\Exception $exception){

                    $this->store = json_decode($store,true);
                }
            }
        }else{
            $this->synchro();
        }
    }

    /**
     * 本类禁止克隆
     */
    private function __clone(){}

    /**
     * 获取JSON文件保存路径
     */
    private function getJsonPath(){


        $path = rtrim(Arr::get($this->getConfigStore(),'store_json_path'),'/');
        return $path.'/store-'.$this->guard.'.json';
        //return config('control.store_json_path');
    }

    /**
     * 获取配置
     * @return array|\ArrayAccess|mixed
     * @throws \Exception
     */
    private function getConfigStore(){
        $configStore = Arr::get(config('control.store'),$this->guard);
        if(!$configStore){
            throw new \Exception('Not Config Store!');
        }
        return $configStore;
    }

    /**
     * 实例化本类
     * @param string $guard
     * @return StoreSynchronizing
     */
    public static function make($guard = '711'){
        if(!self::$instance instanceof self){
            self::$instance = new self($guard);
        }
        return self::$instance;
    }


    /**
     * 获取原始数据
     */
    public function getStoreOrigin(){
        return $this->store;
    }

    /**
     * 同步数据
     */
    public function synchro(){

        if($this->is_synchro){
            return true;
        }
        $client = new Client();
        $store_synchronizing_url = Arr::get($this->getConfigStore(),'store_synchronizing_url');
        $host = config('control.host');
        $parse = parse_url($host);
        $res = $client->get($host.$store_synchronizing_url,[
            'headers'=>[
                'Host'=>$parse['host'],
                'Content-Type' => 'application/json',
                'Authorization'=>config('control.access_key'),
            ],
        ]);
        $this->is_synchro = true;
        if($res->getStatusCode() == 200){
            $this->renewRecord();
            $store = $res->getBody()->getContents();
            file_put_contents($this->getJsonPath(),$store);
            $this->store = json_decode($store,true);
        }else{
            throw new \Exception("No Access");
        }

    }

    /**
     * 記錄更新時間，記錄在tmp
     */
    public function renewRecord(){
        $temp_dir = sys_get_temp_dir();
        if (is_writable($temp_dir)){
            $file_path = $temp_dir.'/_store_renew';
            try{
                file_put_contents($file_path,date('Ymd').PHP_EOL,FILE_APPEND);
            }catch (\Exception $e){
            }

        }
    }

    /**
     * 获取更新记录
     */
    public function getRenewRecord(){
        $temp_dir = sys_get_temp_dir();
        if (is_readable($temp_dir)){
            $file_path = $temp_dir.'/_store_renew';
            if(is_file($file_path)){
                $content = file_get_contents($file_path);
                if($content){
                    return array_filter(explode(PHP_EOL,$content));
                }
            }

        }
        return [];
    }

    /**
     * 判断是否需要更新
     */
    public function isRenew(){
        try {
            $renew = config('control.renew');
            $time = explode(" ",$renew);
            $weeks = explode(',',Arr::get($time,1));
            $h = Arr::get($time,0);
            $day_week = date("w");
            if(in_array($day_week,$weeks)){
                $day_h = date("Y-m-d H:i:s");
                if($day_h>=$h){
                    $record = $this->getRenewRecord();
                    if(!in_array(date('Ymd'),$record)){

                        return true;
                    }

                }
            }
            return false;
        }catch (\Exception $exception){
            return false;
        }

    }

    /**
     * 获取市
     * @param bool $is_view_son
     * @return array
     */
    public function getCity($is_view_son=false){
        if($is_view_son == false){
            return $this->removeArrayKey($this->store);
        }else{
            return $this->store;
        }
    }

    /**
     * 根据市县名称 获取镇的数据
     * @param $city_name
     * @param bool $is_view_son
     * @return array
     */
    public function getCounty($city_name,$is_view_son=false){

        $county = [];
        $city = $this->arrayFilterFieldValue($this->store,'name',trim($city_name));
        if(isset($city['son'])){
            $county = $city['son'];
        }
        if($is_view_son == false){
            return $this->removeArrayKey($county);
        }else{
            return $county;
        }

    }

    /**
     * 根据市 、镇 获取路段信息
     * @param $city_name
     * @param $county_name
     * @param bool $is_view_son
     * @return array
     */
    public function getRoad($city_name,$county_name,$is_view_son=false){

        $county = $this->getCounty($city_name,true);

        $roads = [];
        $county_name = trim($county_name);
        $data = $this->arrayFilterFieldValue($county,'name',$county_name);
        if(isset($data['son'])){
            $roads = $data['son'];
        }
        if($is_view_son == false){
            return $this->removeArrayKey($roads,'street_shop');
        }else{
            return $roads;
        }

    }



    /**
     * 根据市 、镇、路段 获取门市信息
     *
     * @param $city_name
     * @param $county_name
     * @param $road_name
     * @return array $shop
     */
    public function getShop($city_name,$county_name,$road_name){
        $roads = $this->getRoad($city_name,$county_name,true);
        $shop = [];
        $road_name = trim($road_name);
        $data = $this->arrayFilterFieldValue($roads,'name',$road_name);
        if(isset($data['street_shop'])){
            $shop = $data['street_shop'];
        }
        return $shop;

    }


    /**
     * 剔除son
     * @param array $arr
     * @param string $key
     * @return array
     */
    private function removeArrayKey($arr,$key='son'){
        return array_map(function($item)use($key){
            unset($item[$key]);
            return  $item;
        },$arr);
    }


    /**
     * 根据指定key和value获取指定数据
     * @param array $data
     * @param string $field
     * @param $value
     * @return array
     */
    public function arrayFilterFieldValue(array $data,  $field, $value)
    {
        $filter = [];

        //循环法
        /*foreach($data as $item){
            if(isset($item[$field]) && $item[$field] == $value){
                $filter = $item;
                break;
            }
        }*/

        //内置函数法
        array_filter($data, function ($row) use ($field, $value,&$filter) {
            if (isset($row[$field]) && $row[$field] == $value) {
                $filter = $row;
                return true;
            }
        });
        return $filter;

    }
}
