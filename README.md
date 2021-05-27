# packages-control

### 介绍
用于公司内部系统数据同步

#### 安裝教程

    composer require rizhou/laravel-control

#### 使用方法

    StoreSynchronizing::make()->synchro(); //与采集中心同步数据
    
    StoreSynchronizing::make()->getCity(); //获取市县
    
    StoreSynchronizing::make()->getCounty('台北市'); //根据市县名称获取地区
    
    StoreSynchronizing::make()->getRoad('台北市','大安區'); //获取路段
    
    StoreSynchronizing::make()->getShop('台北市','大安區','忠孝東路四段'); //获取门市


