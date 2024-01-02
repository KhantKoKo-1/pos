<?php
session_start();
require ('../require/common.php');
require ('../config/connect.php');
require ('../require/authenticated_cashier.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = json_decode(file_get_contents('php://input'), true);
    $category_id  = (int)($post_data['category_id']);
    $sql = "SELECT id,name,price,code_no,image FROM `item` WHERE category_id = '$category_id' AND status = '$admin_enable_status' AND deleted_at IS NULL";
    $result = $mysqli -> query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $id = (int) ($row['id']);
        $name = htmlspecialchars($row['name']);
        $price = (int) ($row['price']);
        $code_no = htmlspecialchars($row['code_no']);
        $image = htmlspecialchars($row['image']);
        $item = array(
            'id' => $id,
            'price' => $price,
            'code_no' => $code_no,
            'name' => $name,
            'image' => $image
        );
        array_push($data, $item);
    }
    echo json_encode($data);
}
?>