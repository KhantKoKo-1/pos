<?php 
session_start();
require ('../require/common.php');
require ('../config/connect.php');
$error = false;
$error_message = '';
if(isset($_POST['form_sub']) && $_POST['form_sub'] == 1){
   $username = $mysqli ->real_escape_string($_POST['username']);
   $password = $_POST['password'];
   if($username == '' && $password == ''){
        $error = true;
        $error_message = 'Please Fill username and password !!!!';
   }

   if($error == false){
    $sql = "SELECT id, username, password FROM `user` WHERE username = '$username'
    AND role = '$casher_role' AND status = '$admin_enable_status'
    AND deleted_at IS NULL";
      $result = $mysqli -> query($sql);
      if($result){
        $num_row = $result->num_rows;
        if($num_row <= 0){
            $error = true;
            $error_message = 'Username does not exist !!!!';
        }else{
            $password_md5 = md5($SHA_KEY . md5($password));
            while ($rows = $result->fetch_assoc()) {
                $db_id       = (int)($rows['id']);
                $db_username = htmlspecialchars($rows['username']);
                $db_password = $rows['password'];
                if($password_md5 == $db_password){
                    $_SESSION['cid']       = $db_id;
                    $_SESSION['cusername'] = $db_username;
                    $url =  $f_base_url . "order";
                    header("Refresh: 0; url=$url");
                    exit();
                }else{
                    $error = true;
                    $error_message = 'Username does not exist !!!!'; 
                }   
            }
         
      }
    }
   }
   
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>asset/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>asset/bootstrap/css/bootstrap.css" />
    <link rel = "stylesheet" href = "<?php echo $base_url;?>asset/css/login1.css" />
    <script src="<?php echo $base_url;?>asset/bootstrap/js/jquery-2.2.4.min.js"></script>
    <script src="<?php echo $base_url;?>asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $base_url;?>asset/js/angular/angular.min.js"></script>
</head>
<body>
<section class="intro" ng-app="myApp" ng-controller="myCtrl">
    <div class="inner">
        <div class="content">
            <form class="login-form" method="POST" id='submit' action="login">
            <table style="margin:0 auto;width: 18vw;">
            <?php if($error){?>
                <tr style="">
                    <td colspan="3">
                        <div class="alert-danger">
                            <?php echo $error_message;?>
                        </div>
                    </td>
                </tr>
                <?php
            }?>
                <tr>
                    <td colspan="3">
                        <input type="text" placeholder="Enter Username" class="userInput" name = "username" ng-model = 'username' ng-focus="usernameFocus()"/>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"><input type="password" placeholder="Enter Password" class="userInput" name = "password" ng-model = 'password' ng-focus="passwordFocus()"></td>
                </tr>

                <tr>
                    <td><button type="button" class="number-btn fl-left num-btn" ng-click = "numberClick(0)">0</button></td>
                    <td><button type="button" class="number-btn num-btn" ng-click = "numberClick(1)">1</button></td>
                    <td><button type="button" class="number-btn fl-right num-btn" ng-click = "numberClick(2)">2</button></td>
                </tr>

                <tr>
                    <td><button type="button" class="number-btn fl-left num-btn" ng-click = "numberClick(3)">3</button></td>
                    <td><button type="button" class="number-btn num-btn" ng-click = "numberClick(4)">4</button></td>
                    <td><button type="button" class="number-btn fl-right num-btn" ng-click = "numberClick(5)">5</button></td>
                </tr>

                <tr>
                    <td><button type="button" class="number-btn fl-left num-btn" ng-click = "numberClick(6)">6</button></td>
                    <td><button type="button" class="number-btn num-btn" ng-click = "numberClick(7)">7</button></td>
                    <td><button type="button" class="number-btn fl-right num-btn" ng-click = "numberClick(8)">8</button></td>
                </tr>

                <tr>
                    <td><button type="button" class="number-btn fl-left num-btn" ng-click = "numberClick(9)">9</button></td>
                    <td><button type="button" class="number-btn clear-btn" ng-click = "delete()">X</button></td>
                    <td><button type="button" class="number-btn fl-right enter-btn" ng-click="Login()">Enter</button></td>
                </tr>
            </table>
            <input type="hidden" name ="form_sub" value = "1" /> 
            </form>
        </div>
    </div>
</section>
<script src="<?php echo $base_url;?>asset/js/page/login.js"></script>
<?php require ('../template/template_footer.php');?>