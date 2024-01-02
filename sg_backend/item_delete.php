<?php
session_start();
require('../config/connect.php');
require('../require/common.php');
require('../require/authenticated.php');
require ('../require/shift_validation.php');
if($opened){
    $url =  $cp_base_url . "item_list?err=shift_open_delete";
    header("Refresh: 0; url=$url");
    exit();
}

$get_id = (int)$_GET['id'];
$id = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
$date = date('Y-m-d H:i:s');

$sql = "UPDATE `item` SET 
    deleted_at = '$date',
    deleted_by = '$id'
    WHERE id = '$get_id'"; // Added semicolon at the end

 $result = $mysqli->query($sql);
 if($result){
    $url =  $cp_base_url . "item_list?msg=delete";
    header("Refresh: 0; url=$url");
    exit();
 }else{
    $url =  $cp_base_url . "item_list?err=delete";
    header("Refresh: 0; url=$url");
    exit();
 }
?>
