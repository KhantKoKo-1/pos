<?php 
$dash = "";

function parent_category($mysqli, $admin_enable_status, $dash, $parent_id, $item = false, $item_check = false)
{
    global $count;
    $count = 1;
    $category_sql = "SELECT * FROM `category` WHERE parent_id = 0 AND status = '$admin_enable_status' AND deleted_at IS NULL";
    $category_result = $mysqli->query($category_sql);

    while ($category_rows = $category_result->fetch_assoc()) {
        $category_id = (int) $category_rows['id'];
        $category_name = htmlspecialchars($category_rows['name']);
        $enabled = '';

        if ($item) {
            $child_count = check_child_category($mysqli,$admin_enable_status, $category_id);
            if ($child_count > 0) {
                $enabled = 'disabled';
            }
        }
        
        if ($item_check) {
            $item_count=check_items_for_category($mysqli, $category_id);
            if ($item_count > 0) {
                $enabled = 'disabled';
            }
        }

        $selectedAttribute = ($category_id == $parent_id) ? 'selected' : '';
        echo "<option value='$category_id' $selectedAttribute $enabled> $category_name</option>";
        child_category($mysqli,$admin_enable_status, $category_id, $parent_id, $dash, $count, $item, $item_check); // Move inside the while loop
    }
}

function child_category($mysqli,$admin_enable_status, $parent_id, $child_parent_id, $dash, $count, $item, $item_check)
{
    $count++;
    $child_category_sql = "SELECT * FROM `category` WHERE parent_id = $parent_id AND status = '$admin_enable_status' AND deleted_at IS NULL";
    $child_category_result = $mysqli->query($child_category_sql);

    if ($count > 1){
        $dash .= '--';
    }

    while ($child_category_rows = $child_category_result->fetch_assoc()) {
        $child_category_id = (int)$child_category_rows['id'];
        $child_category_name = htmlspecialchars($child_category_rows['name']);
        $enabled = '';
        
        if ($item) {
            $child_count = check_child_category($mysqli,$admin_enable_status, $child_category_id);
            if ($child_count > 0) {
                $enabled = 'disabled';
            }
        }
        
        if ($item_check) {
            $item_count=check_items_for_category($mysqli, $child_category_id);
            if ($item_count > 0) {
                $enabled = 'disabled';
            }
        }
        $selectedAttribute = ($child_category_id == $child_parent_id) ? 'selected' : '';
        echo "<option value='$child_category_id' $selectedAttribute $enabled> $dash $child_category_name</option>";
        child_category($mysqli,$admin_enable_status, $child_category_id, $child_parent_id, $dash, $count, $item, $item_check);
    }
}

function check_child_category($mysqli,$admin_enable_status, $parent_id)
{
    $check_category_sql = "SELECT COUNT(*) AS total FROM `category` WHERE parent_id = '$parent_id' AND status = '$admin_enable_status' AND deleted_at IS NULL";
    $result = $mysqli->query($check_category_sql);
    
    while ($rows = $result->fetch_assoc()) {
        $total = $rows['total'];
        return $total;
    }
}

function check_items_for_category($mysqli, $category_id)
{
    $check_items_sql = "SELECT COUNT(*) AS total FROM `item` WHERE category_id = '$category_id'";
    $result = $mysqli->query($check_items_sql);

    while ($rows = $result->fetch_assoc()) {
        $total = $rows['total'];
        return $total;
    }
}
?>
