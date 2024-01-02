<?php 
session_start();
require ('../require/common.php');
require ('../config/connect.php');
$error = false;
$error_message = '';
$username = '';
$remember = '';
if(isset($_POST['form_sub']) && $_POST['form_sub'] == "Submit") {
  $username = $mysqli->real_escape_string($_POST['username']);
  $password = $_POST['password'];
  if (isset($_POST['remember'])){
    $remember = $_POST['remember'];
  }
  if ($username == '') {
    $error = true;
    $error_message .= "UserName is required!";
  }
  if ($password == '') {
    $error = true;
    $error_message .= "password is required!";
  }
  if($error == false){
    $password_md5 = md5($SHA_KEY . md5($password));
    $sql = "SELECT id,username,status FROM `user` WHERE username = '$username' AND password = '$password_md5' AND deleted_at IS NULL AND deleted_by IS NULL";
    $result = $mysqli->query($sql);
    $row_res = $result -> num_rows;
    if($row_res > 0){
      while ($row = $result->fetch_assoc()) {
      if($row['status'] == $admin_enable_status){
        $id = (int)($row['id']);
        if ($remember == '1') {
          setcookie("id", $row['id'], time() + (86400 * 30), "/");
          setcookie("username", $row['username'], time() + (86400 * 30), "/");
        }else{
          $_SESSION['id']       = $row['id'];
          $_SESSION['username'] = $row['username'];
        }
        $url =  $cp_base_url . "table_list.php";
        header("Refresh: 0; url=$url");
        exit();
      }else{
        $error = true;
        $error_message = "You have not admin pemission!!";
      }
      }
      }else{
        $error = true;
        $error_message = "username or password is invalid";
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form! </title>
    <!-- Bootstrap -->
    <link href="<?php echo $base_url;?>asset/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $base_url;?>asset/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo $base_url;?>asset/css/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo $base_url;?>asset/css/custom/custom.min.css" rel="stylesheet">
    <!-- Include SweetAlert CSS and JS from CDN -->
    <link rel="stylesheet" href="<?php echo $base_url;?>asset/css/sweetalert/sweetalert.min.css">
    <script src="<?php echo $base_url;?>asset/js/sweetalert/sweetalert.all.min.js"></script>
  </head>

  <body class="login">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action = "<?php echo $cp_base_url;?>login.php" method = "POST">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" name = "username" value="<?php echo htmlspecialchars($username) ?>" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name = "password"  />
              </div>
              <div>
                  <input type="checkbox" name="remember" id="remember" value="1" <?php if($remember == '1'){echo "checked";} ?> />
                  <label for="remember"> Remember me </label>
                  <button type="submit" class="btn btn-default submit" >Log in</button>
                  <input type="hidden" name="form_sub" value="Submit" />
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <div>
                    <p>©2016 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
  <?php
  if ($error == true) {
    ?>
        <script>
           Swal.fire({
                title: "Error!",
                text: "<?php echo $error_message?>",
                icon: "error",
            });
        </script>;
    <?php
    }
  ?>
</html>
