<?php
include("../backend/config.php");
$url = trim(file_get_contents("../config/server_address.lnc"));

function getName($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}
$tmp_api_key = getName(2048);
file_put_contents("../config/tmp_api.verify", $tmp_api_key);
echo json_encode([$tmp_api_key, "http://".$url]);