<?php
$title = 'Category Form!';
$process_error  = false;
$get_user_error  = false;
$uploaded = false;
$error  = false;
$error_message  = '';
$category_name = '';
$parent_id = '';

require('../require/common.php');
require('../template/cp_template_header.php');
require('../template/cp_template_sidebar.php');
require('../template/cp_template_top_nav.php');
require ('../require/shift_validation.php');
if($opened){
    $url =  $cp_base_url . "category_list?err=shift_open_edit";
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
    exit();
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM `category` WHERE id = '$id' AND deleted_at IS NULL";
$result = $mysqli->query($sql);
if ($result->num_rows <= 0) {
    $get_user_error = true;
    $error = true;
    $error_message .= "category does not exists<br />";
} else {
    $row = $result->fetch_assoc();
    $category_name = htmlspecialchars($row['name']);
    $parent_id =  htmlspecialchars($row['parent_id']);
    $status =  htmlspecialchars($row['status']);
    $image = htmlspecialchars($row['image']);
    $upload_path = "../asset/upload/category/";
    $img_path = $upload_path . "/" . $id . "/" . $image;
}
if (isset($_POST['form_sub']) && $_POST['form_sub'] ==  '1') {
    $category_name =  $mysqli->real_escape_string($_POST['name']);
    $parent_id =  (int)($_POST['parent_id']);
    $id =  (int)($_POST['id']);
    $status =  (int)($_POST['status']);
    $image = $_FILES['upload_photo'];
    if ($category_name == '') {
        $process_error  = true;
        $error  = true;
        $error_message  .= 'Please Fill Category Name';
    }
    if ($parent_id == '') {
        $process_error  = true;
        $error  = true;
        $error_message  .= 'Please Fill parent Category';
    }
    if ($image['error'] == 0) {
        $uploaded = true;
        $allow_file_type = ['jpg','jpeg','svg','png','gif'];
        $explode   = explode('.', $image['name']);
        $img_without_ext_name = $explode[0];
        $extension = end($explode);
        if (!in_array($extension, $allow_file_type)) {
            $process_error  = true;
            $error = true;
            $error_message .= "Pleace import valid photo type['jpg','jpeg','svg','png','gif']<br />";
        } else {
            $unique_name = $img_without_ext_name . "_" . strftime('%H%M%S') . "_" . uniqid() . "." . $extension;
        }
    }
    if ($process_error == false) {
        $sql = "SELECT count(id) As total FROM `category` WHERE name = '$category_name' AND id != '$id' AND deleted_at IS NULL";
        $row = $mysqli->query($sql)->fetch_assoc();
        if ($row['total'] > 0) {
            $error = true;
            $error_message .= "category_name is already exists<br />";
        } else {
            $auth_id   = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
            $date = date('Y-m-d H.i.s');
            if ($uploaded == true) {
                $sqlUpdate = "UPDATE `category` SET 
                name = '$category_name', 
                parent_id = '$parent_id', 
                status = '$status', 
                image = '$unique_name', 
                updated_at = '$date',
				updated_by = '$auth_id'
                WHERE id = '$id'";
            } else {
                $sqlUpdate = "UPDATE `category` SET 
                name = '$category_name', 
                parent_id = '$parent_id',
				status = '$status', 
                updated_at = '$date',
				updated_by = '$auth_id'
                WHERE id = '$id'";
            }
            $image_query = "SELECT image FROM `category` WHERE id = '$id'";
            $old_img_name = $mysqli->query($image_query)->fetch_assoc();
            $update_result = $mysqli->query($sqlUpdate);
            if (!$result) {
                $error = true;
                $error_message .= "Oop! something wrong. please contact administrator<br />";
                $url =  $cp_base_url . "login?err=edit";
                header("Refresh: 0; url=$url");
                exit();
            } else {
                if ($uploaded == true) {
                    $full_path_dir = $upload_path . $id;
                    $full_path_img = $full_path_dir . "/" . $unique_name;
                    if (!file_exists($full_path_dir)) {
                        mkdir($full_path_dir, 0777, true);
                    }
                    if (move_uploaded_file($image["tmp_name"], $full_path_img)) {
                        $old_img_path = $full_path_dir . "/"  .$old_img_name['image'];
                        if (file_exists($old_img_path)) {
                            unlink($old_img_path);
                        }
                        require('../lib/crop_and_resize.php');
                    }
                }
                $url =  $cp_base_url . "category_list?msg=edit";
                echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                exit();
            }
        }
    }
}
?>
<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Category Edit </h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<?php 
                                    if (!$get_user_error) {
                                ?>
								<form class="" action="" method="POST" enctype="multipart/form-data" novalidate>
									<span class="section"> Category Info</span>
									<div class="field item form-group">
										<label for="name" class="col-form-label col-md-3 col-sm-3  label-align">Category Name<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<input id="name" class="form-control" name="name" value="<?php echo $category_name?>" />
										</div>
									</div>
									<div class="field item form-group">
										<label for="Parent" class="col-form-label col-md-3 col-sm-3  label-align">Parent-Category<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
										<select id="Parent" name = "parent_id" class="select2_group form-control">
											<!-- <optgroup label="Pacific Time Zone"> -->
												<option value="">SELECT ONE</option>
												<option value="0" <?php if ($parent_id ==  '0') {
												    echo "selected";
												}?> >parent_name</option>
												<?php
												require('../include/include_category.php');
												parent_category($mysqli,$admin_enable_status, $dash, $parent_id,false, true);
												?>
											<!-- </optgroup> -->
										</select>
										</div>
									</div>
									<div class="field item form-group">
									<label for="Status" class="col-form-label col-md-3 col-sm-3  label-align">Status<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
										<select id="Status" name = "status" class="select2_group form-control">
												<option value="">SELECT ONE</option>
												<option value="0" <?php if ($status == 0) {
												    echo "selected";
												} ?>>Enable</option>
												<option value="1" <?php if ($status == 1) {
												    echo "selected";
												} ?>>Disable</option>
												<?php
												//  require ('../include/include_category.php');
								                 ?>
										</select>
										</div>
									</div>
									<div class="field item form-group">
										<label for= "image" class="col-form-label col-md-3 col-sm-3  label-align">Category Image<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<div id="previous_wrapper-img" >
												<div class="vertical-center">
												<img src="<?php echo $img_path; ?>" id="image" alt="" style="width:100%;">
												</div>
												<label class="chooseFile" for="upload" onclick = "fileInput()">Choose Photo</label>
										  </div>
                                        </div>	
										</div>
									</div>	
									
									<input class="hide" type="file" id="fileInput" name="upload_photo" onchange = 'previewImage(this)'/>
									<div class="ln_solid">
										<div class="form-group">
											<div class="col-md-6 offset-md-3">
												<button type='submit' class="btn btn-primary">Submit</button>
												<button type='reset' class="btn btn-success">Reset</button>
												<input type="hidden" name="form_sub" value = "1"/>
												<input type="hidden" name="id" value = "<?php echo $id?>"/>
											</div>
										</div>
									</div>
								</form>
								<?php
								}
								if ($get_user_error){
										?>
										<a href="<?php $cp_base_url ?>category_list.php" class="btn btn-primary" ><i class="bi bi-reply-fill"></i>Back</a>
									<?php
								}?>
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
	<link rel="stylesheet" href="<?php echo $base_url;?>asset/css/sweetalert/sweetalert.min.css">
	<script src="<?php echo $base_url;?>asset/js/sweetalert/sweetalert.all.min.js"></script>
    <script src="<?php echo $base_url;?>asset/js/jquery1.9/jquery.min.js"></script>
    <script src="<?php echo $base_url;?>asset/js/validator/multifield.js"></script>

    <script>
<?php
require('../template/cp_footer_end.php');
?>
<!-- jquery is here -->
<script>
    function fileInput() {
        $('#fileInput').click();
    }

    function previewImage(input) {
        const file = input.files[0];
        let fileExtension = file.name.split('.').pop();
        let allow_file_type = ['jpg', 'jpeg', 'svg', 'png', 'gif'];
        if (fileExtension && allow_file_type.includes(fileExtension.toLowerCase())) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            };
            $('#previous_wrapper-img').show();
            reader.readAsDataURL(file);
        } else {
            console.log('File extension is invalid:', fileExtension);
        }
    }

    <?php if ($error == true): ?>
        Swal.fire({
            title: "Error!",
            text: "<?php echo $error_message; ?>",
            icon: "error",
        });
    <?php endif; ?>
</script>

</html>