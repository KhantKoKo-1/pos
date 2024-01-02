<?php 
    $title = 'Item Form!';
	$process_error  = false;
	$error  = false;
	$error_message  = '';
	$item_name = '';
	$category_id = '';
	$price = '';
	$quantity = '';
	require ('../require/common.php');
	require ('../template/cp_template_header.php');
	require ('../template/cp_template_sidebar.php');
	require ('../template/cp_template_top_nav.php');
	if (isset($_POST['form_sub']) && $_POST['form_sub'] ==  '1') {
		$item_name =  $mysqli->real_escape_string($_POST['name']);
		$code_id =  $mysqli->real_escape_string($_POST['id']);
		$category_id =  (int)($_POST['category_id']);
		$price =  (int)($_POST['price']);
		$quantity =  (int)($_POST['quantity']);
		$image = $_FILES['upload_photo'];
		// print_r($image['error']);
		// echo $image['error'];
        if ($item_name == ''){
			$process_error  = true;
			$error  = true;
			$error_message  .= 'Please Fill Category Name';
		}
		if ($category_id == ''){
			$process_error  = true;
			$error  = true;
			$error_message  .= 'Please Fill parent Category';
		}
		if ($image['error'] > 0){
			$process_error  = true;
			$error  = true;
			$error_message  .= 'Please upload photo';
		}else{
			$allow_file_type = ['jpg','jpeg','svg','png','gif'];
			$explode   = explode('.',$image['name']);
			$img_without_ext_name = $explode[0];
			$extension = end($explode);
			if(!in_array($extension,$allow_file_type)){
				$error = TRUE;
				$error_message .= "Pleace import valid photo type['jpg','jpeg','svg','png','gif']<br />";
		}else{
			$unique_name = $img_without_ext_name . "_" . strftime('%H%M%S') . "_" . uniqid() . "." . $extension;
			$upload_path = "../asset/upload/item/";
		}
		}
		if ($process_error == false){
			$sql = "SELECT count(id) As total FROM `item` WHERE name = '$item_name' AND deleted_at IS NULL";
			$row = $mysqli->query($sql)->fetch_assoc();
			if ($row['total'] > 0) {
			$error = TRUE;
			$error_message .= "item_name is already exists<br />";
		}else {
            $id   = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
			$date = date('Y-m-d H.i.s');
			$sql  = "INSERT INTO `item` (name, category_id, price, quantity, image , created_at , created_by)
            VALUES ('$item_name', '$category_id', '$price', '$quantity', '$unique_name', '$date' , '$id')";
			$result = $mysqli->query($sql);
			if(!$result){
				$error = TRUE;
				$error_message .= "Oop! something wrong. please contact administrator<br />";
				$url =  $cp_base_url . "category_list.php?err=create";
				header("Refresh: 0; url=$url");
			}else{
				$insterted_id = $mysqli -> insert_id;
				for ($i = 0; $i <= 3; $i++) {
					$code_key .= chr(rand(65, 90));
				}
				$code_no = $category_id . $insterted_id . '-' .$code_key;
				$sqlUpdate = "UPDATE `item` SET 
                code_no = '$code_no', 
                updated_at = '$date',
				updated_by = '$auth_id'
                WHERE id = '$insterted_id'";
			    $mysqli->query($sqlUpdate);
				$full_path_dir = $upload_path . $insterted_id;
                $full_path_img = $full_path_dir . "/" . $unique_name;
				if(!file_exists($full_path_dir)){
					mkdir($full_path_dir,0777,true);
				}
				move_uploaded_file($image["tmp_name"],$full_path_img);
				require('../lib/crop_and_resize.php');
				$url =  $cp_base_url . "item_list.php?msg=create";
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
								<h2>Item Create</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<form class="" action="" method="POST" enctype="multipart/form-data" novalidate>
									<span class="section"> Item Info</span>
									<div class="field item form-group">
										<label for="name" class="col-form-label col-md-3 col-sm-3  label-align">Item Name<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<input id="name" class="form-control" name="name" value="<?php echo $item_name?>" />
										</div>
									</div>
									<div class="field item form-group">
										<label for="Parent" class="col-form-label col-md-3 col-sm-3  label-align">Parent-Category<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
										<select id="Parent" name = "category_id" class="select2_group form-control">
											<!-- <optgroup label="Pacific Time Zone"> -->
												<option value="" disabled>SELECT ONE</option>
												<!-- <option value="0" <?php if ($category_id ==  '0') { echo "selected"; }?> >parent_name</option> -->
												<?php
												 require ('../include/include_category.php');
												 parent_category($mysqli,$admin_enable_status, $dash, $parent_id, true);
												?>
											<!-- </optgroup> -->
										</select>
										</div>
									</div>
									<div class="field item form-group">
										<label for="price" class="col-form-label col-md-3 col-sm-3  label-align">Price<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<input id="price" class="form-control" name="price" value="<?php echo $price?>" />
										</div>
									</div>
									<div class="field item form-group">
										<label for="quantity" class="col-form-label col-md-3 col-sm-3  label-align">Quantity<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<input id="quantity" class="form-control" name="quantity" value="<?php echo $quantity?>" />
										</div>
									</div>
									<div class="field item form-group">
										<label for= "image" class="col-form-label col-md-3 col-sm-3  label-align">item Image<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<div id="previous_wrapper" >
												<label class="chooseFile" for="upload" onclick = "fileInput()">Choose Photo</label>
											</div>
											<div id="previous_wrapper-img" style="display: none;" >
												<div class="vertical-center">
													<img src="" id="image" alt="" style="width:100%;">
												</div>
										  </div>
                                        </div>	
										</div>
									</div>
									<input class="hide" type="file" id="fileInput" name="upload_photo" onchange = 'previewImage(this)'>
									<div class="ln_solid">
										<div class="form-group">
											<div class="col-md-6 offset-md-3">
												<button type='submit' class="btn btn-primary">Submit</button>
												<button type='reset' class="btn btn-success">Reset</button>
												<input type="hidden" name="form_sub" value = "1"/>
											</div>
										</div>
									</div>
								</form>
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
	<link rel="stylesheet" href="<?php echo $base_url;?>asset/css/sweetalert/sweetalert.min.css">
	<script src="<?php echo $base_url;?>asset/js/sweetalert/sweetalert.all.min.js"></script>
    <script src="<?php echo $base_url;?>asset/js/jquery1.9/jquery.min.js"></script>
    <script src="<?php echo $base_url;?>asset/js/validator/multifield.js"></script>
    <!-- <script src="<?php echo $base_url;?>asset/js/validator/validator.js"></script> -->

    <script>
        // var validator = new FormValidator({
        //     "events": ['blur', 'input', 'change']
        // }, document.forms[0]);
        // document.forms[0].onsubmit = function(e) {
        //     var submit = true,
        //         validatorResult = validator.checkAll(this);
        //     return !!validatorResult.valid;
        // };
        // document.forms[0].onreset = function(e) {
        //     validator.reset();
        // };
        // $('.toggleValidationTooltips').change(function() {
        //     validator.settings.alerts = !this.checked;
        //     if (this.checked)
        //         $('form .alert').remove();
        // }).prop('checked', false);
<?php 
		require ('../template/cp_footer_end.php');
?>
<!-- jquery is here -->
<script>
	function fileInput() {
		$('#fileInput').click();
	} 

	function previewImage(input) {
        const file = input.files[0];
		let fileExtension = file.name.split('.').pop();
		let allow_file_type = ['jpg','jpeg','svg','png','gif'];
		if (fileExtension && allow_file_type.includes(fileExtension.toLowerCase())) {
            let reader = new FileReader();
            reader.onload = function(e) { 
                $('#image').attr('src', e.target.result);
            };
			$('#previous_wrapper').hide();
			$('#previous_wrapper-img').show();
        reader.readAsDataURL(file);
        }else{
			console.log('File extension is invalid:', fileExtension);
		}
	}	
</script>
<?php
  if ($error == true) {
    ?>
        <script>
           Swal.fire({
                title: "Error!",
                text: "<?php echo $error_message?>",
                icon: "error",
            });
        </script>;
    <?php
    }
  ?>
</html>