<?php
return [

    /*
    |--------------------------------------------------------------------------
    | 访问验证key
    |--------------------------------------------------------------------------
    |
    */
    'access_key'=>env('CONTROL_ACCESS_KEY','4d04dce696f3f34684ec11fcee91f3e7'),

    /*
    |--------------------------------------------------------------------------
    | api同步地址
    |--------------------------------------------------------------------------
    |
    */
    'host'=>'https://control.xenical-official.com',

    /*
    |--------------------------------------------------------------------------
    | 周  时
    | 1,4 09  表示每周一和周四的9点之后允许热更新
    | 周1-6表示周一到周六 0是周日
    |--------------------------------------------------------------------------
    */
    'renew'=>'09 1,4',

    /*
    |--------------------------------------------------------------------------
    | 同步的数据存储区
    |--------------------------------------------------------------------------
    */
    'store'=>[
        '711'=>[
            'store_synchronizing_url'=>'/api/seven_eleven/generate',
            'store_json_path'=>storage_path('app/public'),
        ],

        'ezship'=>[
            'store_synchronizing_url'=>'/api/ezship/generate',
            'store_json_path'=>storage_path('app/public'),
        ],

        'ezship-family'=>[
            'store_synchronizing_url'=>'/api/ezship/generate-family',
            'store_json_path'=>storage_path('app/public'),
        ],

        'ezship-ok'=>[
            'store_synchronizing_url'=>'/api/ezship/generate-ok',
            'store_json_path'=>storage_path('app/public'),
        ],

        'ezship-hilife'=>[
            'store_synchronizing_url'=>'/api/ezship/generate-hilife',
            'store_json_path'=>storage_path('app/public'),
        ],
    ],

];
