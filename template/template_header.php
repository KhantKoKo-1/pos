<?php 
session_start();
require ('../config/connect.php');
require ('../require/common.php');
require ('../require/authenticated_cashier.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title><?php echo $title?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>asset/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>asset/css/uistyle2.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>asset/css/swiper.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>asset/bootstrap/css/fontawesomeall.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>asset/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>asset/css/sweetalert.css" >
    <script src="<?php echo $base_url;?>asset/bootstrap/js/jquery-2.2.4.min.js"></script>
    <script src="<?php echo $base_url;?>asset/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $base_url;?>asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $base_url;?>asset/bootstrap/js/heightLine.js"></script>
    <script src="<?php echo $base_url;?>asset/js/swiper.min.js"></script>
    <script src="<?php echo $base_url;?>asset/js/sweetalert-dev.js"></script>
    <script src="<?php echo $base_url;?>asset/js/angular/angular.min.js"></script>
    <script src="<?php echo $base_url;?>asset/js/sweetalert/sweetalert.all.min.js"></script>
    <style>
        .item-td {
            text-align:center !important;
        }
        .price-input {
            width: 100% !important;
            text-align:center;
        }
        .clediv {
            clear:both;
        }
    </style>
    <script>
        const base_url = "http://localhost/sg_pos/";
    </script>
</head>
<body>
    <div class="wrapper">