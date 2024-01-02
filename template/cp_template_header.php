<?php 
session_start();
require ('../config/connect.php');
require ('../require/common.php');
require ('../require/authenticated.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>
    <link href="<?php echo $base_url;?>asset/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $base_url;?>asset/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo $base_url;?>asset/css/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo $base_url;?>asset/css/custom/custom.min.css" rel="stylesheet">
    <link href="<?php echo $base_url;?>asset/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="<?php echo $base_url;?>asset/css/style.css?v=2023062" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@X.X.X/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo $base_url;?>asset/pnotify/dist/pnotify.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url;?>asset/css/sweetalert/sweetalert.min.css">
    <!-- bootstrap-datetimepicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="<?php echo $base_url;?>asset/css/date-time/daterangepicker.css" rel="stylesheet"> 
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">