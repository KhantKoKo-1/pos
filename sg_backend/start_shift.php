<?php
session_start();
require ('../require/common.php');
require ('../config/connect.php');

$date = date('Y-m-d H:i:s'); // Current date and time
$auth_id   = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
$sql = "INSERT INTO `shift` 
(`start_date_time`, `created_at`, `created_by`, `updated_at`, `updated_by`)
VALUES ('$date', '$date', '$auth_id', '$date', '$auth_id')";
$result = $mysqli->query($sql);
if($result){
    $url =  $cp_base_url . "shift.php?msg=start";
            header("Refresh: 0; url=$url");
            exit();
}else{
    $url =  $cp_base_url . "shift.php?err=start";
            header("Refresh: 0; url=$url");
            exit();
}
?>