<?php

namespace aversion;

/**
 * 客户端适配器
 *
 * @uses      ClientAdapter
 * @version   2017年04月17日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2017 swoft software
 * @license   PHP Version 5.x {@link http://www.php.net/license/3_0.txt}
 */
class ClientAdapter
{
    /**
     * 检查是否是当前分支功能
     *
     * @param array     $filters   feature configs
     * @param ClientEnv $clientEnv current client env
     *
     * @return bool
     */
    public static function check(array $filters, ClientEnv $clientEnv)
    {
        if (!is_array($filters[0])) {
            $filters = [$filters];
        }

        $ret = false;
        foreach ($filters as $filter) {
            $current = true;
            foreach ($filter as $field) {
                $fieldItems = explode(" ", $field);
                if (count($fieldItems) != 3) {
                    $current = false;
                    continue;
                }
                list($envName, $operator, $arg) = $fieldItems;
                $envValue = $clientEnv->$envName;
                switch ($operator) {
                    case '=': # int/float
                        if (floatval($envValue) != floatval($arg)) {
                            $current = false;
                        }
                        break;
                    case '!=': # int/float
                        if (floatval($envValue) == floatval($arg)) {
                            $current = false;
                        }
                        break;
                    case '>=': # int/float
                        if (floatval($envValue) < floatval($arg)) {
                            $current = false;
                        }
                        break;
                    case '<=': # int/float
                        if (floatval($envValue) > floatval($arg)) {
                            $current = false;
                        }
                        break;
                    case '<': # int/float
                        if (floatval($envValue) >= floatval($arg)) {
                            $current = false;
                        }
                        break;
                    case '>':  # int/float
                        if (floatval($envValue) <= floatval($arg)) {
                            $current = false;
                        }
                        break;
                    case '==': # string
                        if (strval($envValue) != trim($arg)) {
                            $current = false;
                        }
                        break;
                    case '!==': # string
                        if (strval($envValue) == trim($arg)) {
                            $current = false;
                        }
                        break;
                    case 'v>=': // version string
                        if (version_compare($envValue, $arg) < 0) {
                            $current = false;
                        }
                        break;
                    case 'v<=': // version string
                        if (version_compare($envValue, $arg) > 0) {
                            $current = false;
                        }
                        break;
                    case 'v=': // version string
                        if (version_compare($envValue, $arg) !== 0) {
                            $current = false;
                        }
                        break;
                    case 'v>': // version string
                        if (version_compare($envValue, $arg) <= 0) {
                            $current = false;
                        }
                        break;
                    case 'v<': // version string
                        if (version_compare($envValue, $arg) >= 0) {
                            $current = false;
                        }
                        break;
                    case '<=%': #deviceId <=% 100:10  表示设备id经过运算后的对100取模小于等于10为真
                    case '>=%': #deviceId >=% 100:10  表示设备id经过运算后的对100取模小于等于10为真
                    case '>%': #deviceId >% 100:10  表示设备id经过运算后的对100取模小于等于10为真
                    case '<%': #deviceId <% 100:10  表示设备id经过运算后的对100取模小于等于10为真
                        if (!self::judgeDuration($envValue, $operator, $arg)) {
                            $current = false;
                        }
                        break;

                    case '[]':#in操作, 后面的数据以英文逗号分开: 切记中文逗号不算分隔符号
                        $arg = !empty($arg) ? trim($arg) : '';
                        $elems = explode(",", $arg);
                        $elems = array_filter(array_map('trim', $elems));
                        if (empty($envValue) || !in_array(trim(strval($envValue)), $elems, true)) {
                            $current = false;
                        }
                        break;
                    case '![]':#in操作, 后面的数据以英文逗号分开: 切记中文逗号不算分隔符号
                        $arg = !empty($arg) ? trim($arg) : '';
                        $elems = explode(",", $arg);
                        $elems = array_filter(array_map('trim', $elems));
                        if (in_array(trim(strval($envValue)), $elems, true)) {
                            $current = false;
                        }
                        break;

                    default:
                        break;
                }
                if ($current == false) {
                    break;
                }
            }
            if ($current) {
                return true;
            }
        }

        return $ret;
    }

    /**
     * 部分用户功能开放
     *
     * @param mixed  $envValue
     * @param string $operator
     * @param string $arg
     *
     * @return bool
     */
    private static function judgeDuration($envValue, $operator, $arg)
    {
        $ret = true;
        if (empty($envValue)) {
            return false;
        }

        list($total, $limit) = explode(':', $arg);
        $total = intval($total);
        $limit = intval($limit);
        $res = 0;
        if (is_numeric($envValue)) {
            $res = intval($envValue);
        } else {
            $res = crc32($envValue);
        }
        if (!$res) {
            return false;
        }
        $tmpRes = $res % $total;
        if ($operator == '>=%' && $tmpRes < $limit) {
            return false;
        }
        if ($operator == '<=%' && $tmpRes > $limit) {
            return false;
        }
        if ($operator == '<%' && $tmpRes >= $limit) {
            return false;
        }
        if ($operator == '>%' && $tmpRes <= $limit) {
            return false;
        }
        return $ret;
    }
}

