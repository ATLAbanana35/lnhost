<?php
include("../backend/config.php");
$url = trim(file_get_contents("../config/server_address.lnc"));
$data = ['action' => 'run_builtInCommand', 'command' => 'removeApp', 'appName' => $_GET["appName"], 'dbPassword' => $_GET["dbPassword"], 'APIkey' => trim(file_get_contents("../config/server_api.lnc"))];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

if ($result === false) {
    echo "offline";
}

$infoContent = json_decode($result, true)["content"];
echo json_encode($infoContent);

curl_close($ch);
?>