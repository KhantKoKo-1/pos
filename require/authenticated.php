<?php

$authenticated = false;
$user_id = '';
if (isset($_SESSION['id']) || isset($_SESSION['username'])) {
    $user_id = $_SESSION['id'];
} elseif (isset($_COOKIE['id']) || isset($_COOKIE['username'])) {
    $user_id = $_COOKIE['id'];
}
$auth_sql = "SELECT COUNT(id) AS total FROM `user` WHERE id = '$user_id' AND deleted_at IS NULL AND deleted_by IS NULL";
$auth_result = $mysqli->query($auth_sql);
while ($auth_row = $auth_result->fetch_assoc()) {
    if ($auth_row['total'] > 0) {
        $authenticated = true;
    }
}

if ($authenticated == false) {
    $url =  $cp_base_url . "login.php";
    header("Refresh: 0; url=$url");
    exit();
}
