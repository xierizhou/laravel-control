<?php
return [

    /*
    |--------------------------------------------------------------------------
    | 访问验证key
    |--------------------------------------------------------------------------
    |
    */
    'access_key'=>env('CONTROL_ACCESS_KEY','4d04dce696f3f34684ec11fcee91f3e7'),

    'store'=>[
        '711'=>[
            'store_synchronizing_url'=>'https://control.1511tool.xyz/api/seven_eleven/generate',
            'store_json_path'=>storage_path('app/public'),
        ],

        'ezship'=>[
            'store_synchronizing_url'=>'https://control.1511tool.xyz/api/ezship/generate',
            'store_json_path'=>storage_path('app/public'),
        ],

        'ezship-family'=>[
            'store_synchronizing_url'=>'https://control.1511tool.xyz/api/ezship/generate-family',
            'store_json_path'=>storage_path('app/public'),
        ],

        'ezship-ok'=>[
            'store_synchronizing_url'=>'https://control.1511tool.xyz/api/ezship/generate-ok',
            'store_json_path'=>storage_path('app/public'),
        ],

        'ezship-hilife'=>[
            'store_synchronizing_url'=>'https://control.1511tool.xyz/api/ezship/generate-hilife',
            'store_json_path'=>storage_path('app/public'),
        ],
    ],

];
