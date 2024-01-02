<?php 
  $title = 'Admin Panel! Discount List';
	require ('../require/common.php');
	require ('../template/cp_template_header.php');
	require ('../template/cp_template_sidebar.php');
	require ('../template/cp_template_top_nav.php');
  $sql =  "SELECT id,name,
            CASE 
              WHEN 
                percentage IS NULL THEN CONCAT(amount, ' kyats') 
              ELSE 
                CONCAT(percentage, ' %') 
            END AS discount_value,start_date,end_date,status FROM discount_promotion WHERE deleted_at IS NULL
            ORDER BY id DESC";
  $success = false;
  $error = false;
  $result = $mysqli -> query($sql);
  $items = '';
  if (isset($_GET['msg'])) {
    $success = true;
    switch ($_GET['msg']) {
        case 'create':
            $success_message = 'Item create is success'; 
            break;
        case 'edit':
            $success_message = 'Item update is success'; 
            break;
        case 'delete':
            $success_message = 'Item delete is success'; 
            break;
        default:
            // Default case or additional handling
            break;
    }
}

if (isset($_GET['err'])) {
  $error = true;
  switch ($_GET['err']) {
      case 'create':
          $error_message = 'Item create is fail'; 
          break;
      case 'edit':
          $error_message = 'Item update is fail'; 
          break;
      case 'delete':
          $error_message = 'Item delete is fail'; 
          break;
      default:
          // Default case or additional handling
          break;
  }
}

?>
		<!-- page content -->
		<div class="right_col" role="main">
          <div class="">
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Item List </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title">Name </th>
                            <th class="column-title">Discount</th>
                            <th class="column-title">Start_date </th>
                            <th class="column-title">End_date </th>
                            <th class="column-title">Items </th>
                            <th class="column-title">Status </th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php 
                            while ($rows = $result->fetch_assoc()) {
                              $id            = (int)($rows['id']);
                              $discount_name = htmlspecialchars($rows['name']);
                              $discount_amount    = htmlspecialchars($rows['discount_value']);
                              $start_date    = htmlspecialchars($rows['start_date']);
                              $end_date      = htmlspecialchars($rows['end_date']);
                              $status        = (int)($rows['status']);
                              $edit_url      = $cp_base_url . "discount_edit.php?id=" . $id;
                              $delete_url    = $cp_base_url . "discount_delete.php?id=" . $id;
                              
                              $item_sql = "SELECT item.name 
                              FROM `discount_item` AS di 
                              LEFT JOIN `item` ON item.id = di.item_id 
                              WHERE di.deleted_at IS NULL 
                              AND di.discount_id = '$id'";
                              $items = '';
                              $item_result = $mysqli -> query($item_sql);
                              while ($result_rows = $item_result->fetch_assoc()) {
                                $items .= $result_rows['name'] . ',';
                              }
                              ?>
                              <tr class="even pointer" >
                              <td class="a-center ">
                                <input type="checkbox" class="flat" name="table_records">
                              </td>
                              <td class=" "><?php echo $discount_name?></td>
                              <td class=" "><?php echo $discount_amount; ?></td>
                              <td class=" "><?php echo $start_date; ?></td>
                              <td class=" "><?php echo $end_date; ?></td>
                              <td class=" "><?php echo rtrim($items, ',')?></td>
                              <td class=" ">
                              <?php
                              if($status == 0){
                                echo '<span class="badge badge-primary">Enable</span>';
                              }else{
                                echo '<span class="badge badge-secondary">Disable</span>';
                              } 
                              ?>
                              </td>
                              <td class="last">
                              <a href="<?php echo $edit_url?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                              <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="confirmDelete('<?php echo $delete_url; ?>')">
                                  <i class="fa fa-trash-o"></i> Delete
                              </a>
                              </td>
                            </tr>
                        <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<!-- /page content -->

		<!-- footer content -->
		<?php 
		require ('../template/cp_footer_start.php');	 
		?>
		<!-- /footer content -->
	</div>
</div>

<?php
		require ('../template/cp_footer_end.php');
?>
<!-- jquery is here -->

<script>
  $(document).ready(function() {
    <?php if($success == true): ?>
      new PNotify({
        title: 'Regular Success',
        text: '<?php echo $success_message; ?>',
        type: 'success',
        styling: 'bootstrap3'
      });
    <?php endif; ?>

    <?php if($error == true): ?>
      new PNotify({
        title: 'Oh No!',
        text: '<?php echo $error_message; ?>',
        type: 'error',
        styling: 'bootstrap3'
      });
    <?php endif; ?>
  });

  function confirmDelete(deleteUrl) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = deleteUrl;
      }
    });
  }
</script>

</html>