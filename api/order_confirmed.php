    <?php
    session_start();
    require ('../require/common.php');
    require ('../config/connect.php');
    require ('../require/authenticated_cashier.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $check_error = false;
        $order_datas = json_decode(file_get_contents('php://input'), true);
        $id   = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
        $lastArray = end($order_datas);
        $total_amount = $lastArray['sub_total'];
        $date = date("Y-m-d H:i:s");
        $order_sql = "INSERT INTO `order` (total_amount,created_at,created_by,updated_at,updated_by) VALUES ('$total_amount','$date','$id','$date','$id')";
        $mysqli -> query($order_sql);
        $order_id = $mysqli->insert_id;
        foreach($order_datas as $order_data){
            $item_id = (int)($order_data['id']);
            $quantity = (int)($order_data['quantity']);
            $original_amount = (int)($order_data['original_amount']);   
            $discount_amount = (int)($order_data['discount_amount']);
            $sub_total_amount = (int)($order_data['total_amount']);
            $order_detail_sql = "INSERT INTO `order_detail` (quantity, original_amount, discount_amount, 
                                sub_total,order_id,item_id,created_at,created_by,updated_at,updated_by) 
                                VALUES ('$quantity','$original_amount','$discount_amount',
                                '$sub_total_amount','$order_id','$item_id','$date','$id','$date','$id')";
            $result = $mysqli -> query($order_detail_sql);
            if(!$result){
                $check_error = true;
            }               
        }
        if($check_error == false){
            $data = 'success';
        }
        echo json_encode($data);
    }
    ?>