<?php
/**
 * Date: 11/11/2016
 * Time: 15:16
 *
 * 說明：當前手稿會佔用 1 thread 同 1 question。
 */
include './rdbinfo_conf.php';

function di_mysql_stat($host, $user, $password, $dbName)
{
    $stat = null;

    $link = new mysqli($host, $user, $password, $dbName);
    if (mysqli_connect_errno()) {
        return array(mysqli_connect_error());
    } else {
        $result = explode('  ', $link->stat());
        foreach ($result as $k => $v) {
            list($subK, $subV) = explode(': ', $v);
            $stat[$subK] = $subV;
        }

        return [
            'status' => $stat,
            'server info' => $link->server_info,
            'protocol version' => $link->protocol_version,
            'server version' => $link->server_version,
        ];
    }
}

// main process
if (@$_GET['token'] == RDBINFO_TOKEN) {
    echo json_encode(di_mysql_stat(DB_HOST, DB_USER, DB_USERPASSWD, DB_NAME));
} else {
    exit(1);
}
