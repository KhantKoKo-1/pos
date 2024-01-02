<?php

$authenticated = false;
$user_id = '';
if (isset($_SESSION['cid']) || isset($_SESSION['cusername'])) {
    $user_id = $_SESSION['cid'];
}
$auth_sql = "SELECT COUNT(id) AS total FROM `user` WHERE id = '$user_id' AND role = '$casher_role' AND deleted_at IS NULL AND deleted_by IS NULL";
$auth_result = $mysqli->query($auth_sql);
while ($auth_row = $auth_result->fetch_assoc()) {
    if ($auth_row['total'] > 0) {
        $authenticated = true;
    }
}

if ($authenticated == false) {
    $url =  $f_base_url . "login.php";
    header("Refresh: 0; url=$url");
    exit();
}
