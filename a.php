<?php
$link = mysqli_connect('172.24.58.222:54968', 'root', 'password');
if (!$link) {
die('Could not connect: ' . mysqli_error());
}
echo 'Connected successfully';
mysqli_close($link);
?>
