<?php

namespace aversion;

/**
 * 功能分支检查
 *
 * @uses      Features
 * @version   2017年04月17日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2017 swoft software
 * @license   PHP Version 5.x {@link http://www.php.net/license/3_0.txt}
 */
class Features
{
    /**
     * @var array client feature version
     */
    private static $config = null;

    /**
     * @var ClientEnv client current env information
     */
    private static $clientEnv = null;

    public static function init($clientEnv)
    {
        self::$config = require_once 'config.php';
        self::$clientEnv = $clientEnv;
    }

    /**
     * 检查是否是某一个分支版本
     *
     * @param string $featureName
     * @return boolean
     */
    public static function isEnable($featureName)
    {
        $noExist = !isset(self::$config[$featureName]);
        $noArray = !is_array(self::$config[$featureName]);
        $emptyAry = empty(self::$config[$featureName]);

        // 默认返回false
        if($noExist || $noArray || $emptyAry){
            return false;
        }

        $filters = self::$config[$featureName];
        return ClientAdapter::check($filters, self::$clientEnv);
    }
}