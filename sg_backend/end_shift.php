<?php
session_start();
require ('../require/common.php');
require ('../config/connect.php');

$date = date('Y-m-d H:i:s'); // Current date and time
$auth_id   = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
$updateSql = "UPDATE `shift` 
              SET 
                `end_date_time` = '$date',
                `updated_at`    = '$date',
                `updated_by`    = '$auth_id'
              WHERE `deleted_at` IS NULL";
$result = $mysqli->query($updateSql);

if($result){
    $url =  $cp_base_url . "shift.php?msg=end";
            header("Refresh: 0; url=$url");
            exit();
}else{
    $url =  $cp_base_url . "shift.php?msg=end";
    header("Refresh: 0; url=$url");
    exit();
}

?>