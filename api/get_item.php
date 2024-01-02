<?php
session_start();
require ('../require/common.php');
require ('../config/connect.php');
require ('../require/authenticated_cashier.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = json_decode(file_get_contents('php://input'), true);
    $item_id   = (int)($post_data['item_id']);
    $date = date("Y-m-d");
    $sql = "SELECT TO1.id, TO1.name, TO1.price, TO1.code_no, TO1.image,
            CASE 
                WHEN TO3.percentage IS NULL THEN TO3.amount
                ELSE TO3.percentage / 100 * TO1.price
            END AS discount_amount
            FROM `item` TO1
            LEFT JOIN `discount_item` TO2 ON TO1.id = TO2.item_id
            LEFT JOIN `discount_promotion` TO3 ON TO2.discount_id = TO3.id
            WHERE TO1.id = '$item_id' AND '$date' BETWEEN TO3.start_date AND TO3.end_date 
            AND TO1.status = '$admin_enable_status' AND TO2.status = '$admin_enable_status' AND TO3.status = '$admin_enable_status'
            AND TO1.deleted_at IS NULL AND TO2.deleted_at IS NULL AND TO3.deleted_at IS NULL";               
    $discount_item_res = $mysqli -> query($sql);
    $num_rows = $discount_item_res->num_rows;
    if($num_rows <= 0){
        $sql = "SELECT id,name,price,code_no,image FROM `item` WHERE id = '$item_id' AND status = '$admin_enable_status' AND deleted_at IS NULL";
        $result = $mysqli -> query($sql);
        $row = $result->fetch_assoc();
    }else{
        $row = $discount_item_res->fetch_assoc();
    }
    $data = []; 
    $id = (int) ($row['id']);
    $name = htmlspecialchars($row['name']);
    $price = (int) ($row['price']);
    $code_no = htmlspecialchars($row['code_no']);
    $image = htmlspecialchars($row['image']);
    $discount_amount = isset($row['discount_amount']) ? (int)($row['discount_amount']) : 0;
    $total_amount = $price - $discount_amount;
    $item = array(
        'id' => $id,
        'price' => $price,
        'code_no' => $code_no,
        'name' => $name,
        'image' => $image,
        'discount_amount' => $discount_amount,
        'original_amount' => $total_amount,
        'total_amount' => $total_amount,
        'quantity'         => 1
    );
    array_push($data, $item);
    echo json_encode($data);
}
?>