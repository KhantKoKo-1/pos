<?php 
  $title = 'Admin Panel! User List';
	require ('../require/common.php');
	require ('../template/cp_template_header.php');
	require ('../template/cp_template_sidebar.php');
	require ('../template/cp_template_top_nav.php');
  $sql = "SELECT id, username , password, status FROM `user` WHERE role = '2' AND deleted_at IS NULL ORDER BY id DESC";
  $success = false;
  $error = false;
  $result = $mysqli -> query($sql);
 
  if (isset($_GET['msg'])) {
    $success = true;
    switch ($_GET['msg']) {
        case 'create':
            $success_message = 'User create is success'; 
            break;
        case 'edit':
            $success_message = 'User update is success'; 
            break;
        case 'delete':
            $success_message = 'User delete is success'; 
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
          $error_message = 'User create is fail'; 
          break;
      case 'edit':
          $error_message = 'User update is fail'; 
          break;
      case 'delete':
          $error_message = 'User delete is fail'; 
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
                    <h2>Category List </h2>
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
                            <th class="column-title">Password </th>
                            <th class="column-title">Status </th>
                            <!-- <th class="column-title">Image </th> -->
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php 
                            while ($user_rows = $result->fetch_assoc()) {
                              $id     = (int)($user_rows['id']);
                              $user_name = htmlspecialchars($user_rows['username']);
                              $password = htmlspecialchars($user_rows['password']);
                              $status        = (int)($user_rows['status']);
                              $edit_url      = $cp_base_url . "user_edit.php?id=" . $id;
                              $delete_url    = $cp_base_url . "user_delete.php?id=" . $id;
                              $change_pwd_url = $cp_base_url . "user_edit.php?id=" . $id . "&type=change";
                              ?>
                              <tr class="even pointer">
                              <td class="a-center ">
                                <input type="checkbox" class="flat" name="table_records">
                              </td>
                              <td class=" "><?php echo $user_name?></td>
                              <td class=" "><?php echo $password?></td>
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
                              <a href="<?php echo $change_pwd_url?>" class="btn btn-primary btn-xs"><i class="fa fa-arrows"></i>Change Password</a>
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
        // If confirmed, redirect to the specified delete URL
        window.location.href = deleteUrl;
      }
    });
  }
</script>

</html>