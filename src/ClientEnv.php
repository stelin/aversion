<?php

namespace aversion;

/**
 * 客户端环境信息
 *
 * @uses      ClientEnv
 * @version   2017年04月17日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2017 swoft software
 * @license   PHP Version 5.x {@link http://www.php.net/license/3_0.txt}
 */
class ClientEnv
{
    /**
     * @var string app client name
     */
    public $appName = "";

    /**
     * @var string app client version
     */
    public $appVersion = "";

    /**
     * @var string app phone system version
     */
    public $systemVersion = "";

    /**
     * @var string app category,android Or ios
     */
    public $platform = "";

    /**
     * @var string app device ID
     */
    public $deviceId = "";

    /**
     * @var string app deliver channel
     */
    public $channel = "";

    /**
     * @var string push msg to app by cid
     */
    public $cid = "";

    /**
     * @var int app userid, default is 0
     */
    public $userId = 0;

    /**
     * @var float use longitude, defalut is 0
     */
    public $longitude = 0;

    /**
     * @var float use latitude, defalut is 0
     */
    public $latitude = 0;
}