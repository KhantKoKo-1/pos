<?php

$opened = false;
$sql_shift_check = "SELECT COUNT(id) AS total FROM `shift` WHERE `start_date_time` IS NOT NULL 
                   AND `end_date_time` IS NULL 
                   AND `deleted_at` IS NULL";

$shift_result = $mysqli->query($sql_shift_check);

if ($shift_result) {
    $shift_rows = $shift_result->fetch_assoc();
    if ($shift_rows['total'] <= 0) {
        $opened = false;
    } else {
        $opened = true;
    }
}
