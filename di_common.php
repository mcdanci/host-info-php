<?php
/**
 * Date: 10/11/2016
 * Time: 11:41
 */
// PHP_VERSION_ID 處理
if (!defined('PHP_VERSION_ID')) {
    $DI_PHP_VERSION = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', $DI_PHP_VERSION[0] * 10000 + $DI_PHP_VERSION[1] * 100 + $DI_PHP_VERSION[2]);
}

/**
 * @return bool
 */
function di_OS_isWin() {
    if (PHP_VERSION_ID >= 40300) {
        return (PHP_SHLIB_SUFFIX == 'dll') ? true : false;
    } else {
        //return (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? true : false;
        return !function_exists('sys_getloadavg');
    }
}

/**
 * @param string $library
 * @return bool|null 已載入則爲 null。
 */
function di_dl($library)
{
    if (!extension_loaded($library)) {
        if (PHP_VERSION_ID >= 40300) {
            $prefix = (PHP_SHLIB_SUFFIX == 'dll') ? 'php_' : '';
            return dl($prefix . $library . '.' . PHP_SHLIB_SUFFIX);
        } else {
            if (DI_OS_IS_WIN) {
                return dl('php_' . $library . '.dll');
            } else {
                return dl($library . '.so');
            }
        }
    } else {
        return null;
    }
}

function di_nl2array($string)
{
    return explode('<br>' . "\n", nl2br(trim($string), false));
}

define('DI_OS_IS_WIN', di_OS_isWin());
