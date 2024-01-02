<?php
$title = 'Admin Panel! Catagory List';
require('../require/common.php');
require('../template/cp_template_header.php');
require('../template/cp_template_sidebar.php');
require('../template/cp_template_top_nav.php');
$sql = "SELECT c.id, c.name, c.parent_id, c.status, c.image, COALESCE(p.name, 'None') AS parent_name
        FROM category c
        LEFT JOIN category p ON c.parent_id = p.id
        WHERE c.deleted_at IS NULL
        ORDER BY c.id DESC";

$success = false;
$error   = false;
$result  = $mysqli -> query($sql);

if (isset($_GET['msg'])) {
    $success = true;
    switch ($_GET['msg']) {
        case 'create':
            $success_message = 'Category create is success';
            break;
        case 'edit':
            $success_message = 'Category update is success';
            break;
        case 'delete':
            $success_message = 'Category delete is success';
            break;
        default:
            break;
    }
}

if (isset($_GET['err'])) {
    $error = true;
    switch ($_GET['err']) {
        case 'create':
          $error_message = 'Category create is fail';
          break;
        case 'edit':
          $error_message = 'Category update is fail';
          break;
        case 'delete':
          $error_message = 'Category delete is fail';
          break;
        case 'shift_open_edit':
          $error_message = "Shift is Opened!!! Can't Update Category";
          break;
        case 'shift_open_delete':
          $error_message = "Shift is Opened!!! Can't Delete Category";
          break;
        default:
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
                            <th class="column-title">Parent Category </th>
                            <th class="column-title">Status </th>
                            <th class="column-title">Image </th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions 
                              ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                            while ($category_rows = $result->fetch_assoc()) {
                                $id     = (int)($category_rows['id']);
                                $category_name = htmlspecialchars($category_rows['name']);
                                $parent_name   = htmlspecialchars($category_rows['parent_name']);
                                $status        = (int)($category_rows['status']);
                                $image         = htmlspecialchars($category_rows['image']);
                                $full_path_img = $base_url . "asset/upload/category/" . $id . "/" . $image;
                                $edit_url      = $cp_base_url . "category_edit?id=" . $id;
                                $delete_url    = $cp_base_url . "category_delete?id=" . $id;
                                ?>
                              <tr class="even pointer">
                              <td class="a-center ">
                                <input type="checkbox" class="flat" name="table_records">
                              </td>
                              <td class=" "><?php echo $category_name?></td>
                              <td class=" "><?php echo $parent_name; ?>  </td>
                              <td class=" ">
                              <?php
                                if($status == 0) {
                                    echo '<span class="badge badge-primary">Enable</span>';
                                } else {
                                    echo '<span class="badge badge-secondary">Disable</span>';
                                }
                                ?>
                              </td>
                              <td class=" "><img src="<?php echo $full_path_img;?>" alt="" style="width: 100px; height: auto;" /></td>
                              <td class="last">
                              <a href="<?php echo $edit_url?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                              <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="confirmDelete('<?php echo $delete_url; ?>')">
                                  <i class="fa fa-trash-o"></i> Delete
                              </a>
                              <a href="javascript:void(0)" class="btn btn-primary btn-xs"><i class="fa fa-arrows"></i>Move</a>
                              </td>
                            </tr>
                        <?php
                            }?>
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
        require('../template/cp_footer_start.php');
?>
		<!-- /footer content -->
	</div>
</div>

<?php
require('../template/cp_footer_end.php');
?>
<!-- jquery is here -->

<script>
  $(document).ready(function() {
    <?php if($success == true){?>
      new PNotify({
        title: "Regular Success",
        text: "<?php echo $success_message; ?>",
        type: "success",
        styling: "bootstrap3"
      });
    <?php } ?>

    <?php if($error == true){?>
      new PNotify({
        title: "Oh No!",
        text: "<?php echo $error_message; ?>",
        type: "error",
        styling: "bootstrap3"
      });
    <?php }?>
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