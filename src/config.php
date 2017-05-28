<?php
/**
 * 版本管理配置
 *
 * 目前支持的操作符,所有都是英文符号
 * "=": 等于(int)
 * "!=": 不等于(int)
 * ">=": 大于等于(int/float)
 * "<=": 小于等于(int/float)
 * ">": 大于(int/float)
 * "<": 小于(int/float)
 * "==": 等于(string)
 * "!==": 不等于(string)
 * "v>=": 版本号大于等于
 * "v<=": 版本号小于等于
 * "v=": 版本号等于
 * "v>": 版本号大于
 * "v<": 版本号小于
 * "<=%": deviceId <=% 100:10  表示设备id经过运算后的对100取模小于等于10为真
 * ">=%": deviceId >=% 100:10  表示设备id经过运算后的对100取模大于等于10为真
 * ">%":  deviceId >% 100:10  表示设备id经过运算后的对100取模大于10为真
 * "<%":  deviceId <% 100:10  表示设备id经过运算后的对100取模小于10为真
 *
 * @version   2017年04月17日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2017 swoft software
 * @license   PHP Version 5.x {@link http://www.php.net/license/3_0.txt}
 */
return [
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