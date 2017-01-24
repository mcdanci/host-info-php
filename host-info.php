<?php
/**
 * Date: 9/11/2016
 * Time: 15:38
 */
// configuration
const DEBUG = true;

// section main process
include './host-info-common.php';

$data['constants'] = get_defined_constants();
$data['GLOBALS'] = $GLOBALS;

// 作業系統相關
$data['OS']['is Windows'] = DI_OS_IS_WIN;
if (!DI_OS_IS_WIN) {
    $data['OS']['load average'] = sys_getloadavg();
    if ($_GET['find']) { // todo: be careful
        $path2find = ($_GET['find'] == 2) ? '/' : '.';
        $data['OS']['find'] = di_nl2array(shell_exec('find ' . $path2find));
    }
}

// section output
if (PHP_VERSION_ID < 50500) {
    if (DEBUG) {
        $ret = json_encode($data);
    } else { // production
        $ret = @json_encode($data);
    }
} else {
    $ret = json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);
}

echo $ret;
