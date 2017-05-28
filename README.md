<p align="center" style="color: black;font-size: 40px;">
     aversion
</p>

------------
背景
------------

通常IOS或android上线一个迭代版本，服务端会根据版本号以及其它条件，判断是否是某一个迭代版本，如果成立，做相应逻辑处理。但是随着版本的迭代，越来越多的新功能开发，如果没有一个统一的地方维护
会导致代码异常难维护。aversion可以使服务端识别App版本迭代，根据客户端参数识别当前迭代分支版本库。

------------
例子
------------

### 1. 配置版本迭代信息

配置文件/src/config.php
```
return [
    // 多个数组并列，数组之间or，每隔数组and关系
    'feature-comment' =>[
        array(
            'platform == ios',
            'appVersion v>= 2.0.1',
        ),
        array(
            'platform == android',
            'appVersion v<= 2.0.1',
        ),
    ],
    'feature-dolike' =>[
        'appVersion v<= 3.0',
    ],
];
```

### 2. 使用


```
require_once __DIR__. '/../vendor/autoload.php';

$featureName = "feature-comment";
$env = new \aversion\ClientEnv();
$env->platform = "android";
$env->appVersion = "2.0.1";

\aversion\Features::init($env);
$result = \aversion\Features::isEnable($featureName);

var_dump($result);
```

------------
操作符列表
------------

目前支持的操作符,所有都是英文符号

| 操作符 | 介绍 |
| --- | --- |
|"="| 等于(int)|
| "!="| 不等于(int)|
 | ">="| 大于等于(int/float)|
 | "<="| 小于等于(int/float)|
 | ">"|大于(int/float)|
 | "<"| 小于(int/float)|
 | "=="| 等于(string)|
 | "!=="| 不等于(string)|
 | "v>="| 版本号大于等于|
 | "v<="| 版本号小于等于|
 | "v="|版本号等于|
 | "v>"| 版本号大于|
 | "v<"| 版本号小于|
 | "<=%"| deviceId <=% 100:10  表示设备id经过运算后的对100取模小于等于10为真|
 | ">=%"| deviceId >=% 100:10  表示设备id经过运算后的对100取模大于等于10为真|
 | ">%"| deviceId >% 100:10  表示设备id经过运算后的对100取模大于10为真|
 | "<%"|  deviceId <% 100:10  表示设备id经过运算后的对100取模小于10为真|


