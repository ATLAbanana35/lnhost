<?php
include("../backend/config.php");
$url = trim(file_get_contents("../config/server_address.lnc"));
$api_key = trim(file_get_contents("../config/server_api.lnc"));

$data = [
    'action' => 'run_builtInCommand',
    'command' => 'getStatus',
    'APIkey' => $api_key,
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

$result = curl_exec($ch);

if ($result === false) {
    echo "<span class=\"offline\">Offline ".curl_error($ch)."</span>";
} else {
    $decodedResult = json_decode($result, true);
    if ($decodedResult !== null) {
        echo "<span class=\"online\">" . $decodedResult["content"] . "</span>";
    } else {
        echo "<span class=\"offline\">Invalid JSON Response</span>";
    }
}

curl_close($ch);
?>