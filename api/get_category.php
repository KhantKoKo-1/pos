<?php
session_start();
require ('../require/common.php');
require ('../config/connect.php');
require ('../require/authenticated_cashier.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = json_decode(file_get_contents('php://input'), true);
    $parent_id  = (int)($post_data['parent_id']);
    $sql = "SELECT id,name,image FROM `category` WHERE parent_id = '$parent_id' AND status = '$admin_enable_status' AND deleted_at IS NULL";
    $result = $mysqli -> query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $id = (int) $row['id'];
        $name = htmlspecialchars($row['name']);
        $image = htmlspecialchars($row['image']);
        $item = array(
            'id' => $id,
            'name' => $name,
            'image' => $image
        );
        array_push($data, $item);
    }
    echo json_encode($data);
}
?>