<?php
session_start();
require('../config/connect.php');
require('../require/common.php');
require('../require/authenticated.php');

$id = (int)$_GET['id'];
$auth_id = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
$date = date('Y-m-d H:i:s');

$sql = "UPDATE `user` SET 
    deleted_at = '$date',
    deleted_by = '$auth_id'
    WHERE id = '$id';"; // Added semicolon at the end

 $result = $mysqli->query($sql);
 if($result){
    $url =  $cp_base_url . "user_list.php?msg=delete";
    header("Refresh: 0; url=$url");
    exit();
 }else{
    $url =  $cp_base_url . "user_list.php?err=delete";
    header("Refresh: 0; url=$url");
    exit();
 }
?>
