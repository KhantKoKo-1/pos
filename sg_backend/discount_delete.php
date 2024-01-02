<?php
session_start();
require('../config/connect.php');
require('../require/common.php');
require('../require/authenticated.php');

$error = true;
$id = (int)$_GET['id'];
$auth_id = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
$date = date('Y-m-d H:i:s');

$promotion_sql = "UPDATE `discount_promotion` SET 
    deleted_at = '$date',
    deleted_by = '$auth_id'
    WHERE id = '$id'";

 $result = $mysqli->query($promotion_sql);
 if($result){
   $item_sql = "UPDATE `discount_item` SET 
    deleted_at = '$date',
    deleted_by = '$auth_id'
    WHERE discount_id = '$id'";
    $item_result = $mysqli->query($item_sql);
    if($item_result){
      $error = false;
      $url =  $cp_base_url . "discount_list.php?msg=delete";
      header("Refresh: 0; url=$url");
      exit();
    }
 }
 if($error){
    $url =  $cp_base_url . "discount_list.php?err=delete";
    header("Refresh: 0; url=$url");
    exit();
 }
?>
