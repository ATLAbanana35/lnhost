<?php
session_start();
if (empty($_SESSION[trim(file_get_contents("/home/".getenv("USER")."/apps/lnhost/config/server_api.lnc"))])) {
    header("Location: /lnhost/login.php");
    exit;
}
?>