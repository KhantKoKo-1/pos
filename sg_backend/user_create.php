<?php 
    $title = 'User Form!';
	$process_error  = false;
	$error  = false;
	$error_message  = '';
	$user_name = '';
	$status = '';
	require ('../require/common.php');
	require ('../template/cp_template_header.php');
	require ('../template/cp_template_sidebar.php');
	require ('../template/cp_template_top_nav.php');
	if (isset($_POST['form_sub']) && $_POST['form_sub'] ==  '1') {
		$user_name =  $mysqli->real_escape_string($_POST['name']);
		$password =  $mysqli->real_escape_string($_POST['password']);
		$comfirm_password =  $mysqli->real_escape_string($_POST['comfirm_password']);
        if ($user_name == ''){
			$process_error  = true;
			$error  = true;
			$error_message  .= 'Please Fill User Name';
		}
		if ($password == ''){
			$process_error  = true;
			$error  = true;
			$error_message  .= 'Please Fill Password';
		}
		if($comfirm_password == ''){
			$process_error  = true;
			$error  = true;
			$error_message  .= 'Please Fill Comfirm Password';
		}
		if($password != $comfirm_password){
			$process_error  = true;
			$error  = true;
			$error_message  .= 'Password And Comfirm Password does not match';
		}

		if ($process_error == false){
			$sql = "SELECT count(id) As total FROM `user` WHERE username = '$user_name' AND deleted_at IS NULL";
			$row = $mysqli->query($sql)->fetch_assoc();
			if ($row['total'] > 0) {
			$error = TRUE;
			$error_message .= "user_name is already exists<br />";
		}else {
			$password_md5 = md5($SHA_KEY . md5($password));
			$id   = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
			$date = date('Y-m-d H.i.s');
			$sql = "INSERT INTO `user` (username, password, role, created_at, created_by, updated_at, updated_by) VALUES ('$user_name', '$password_md5', '2', '$date', '$id', '$date', '$id')";

			$result = $mysqli->query($sql);
			if(!$result){
				$error = TRUE;
				$error_message .= "Oop! something wrong. please contact administrator<br />";
				$url =  $cp_base_url . "user_list.php?err=create";
				echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
				exit();
			}else{
				$url =  $cp_base_url . "user_list.php?msg=create";
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
								<h2> User Create </h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<form class="" action="" method="POST" novalidate>
									<span class="section"> User Info</span>
									<div class="field item form-group">
										<label for="name" class="col-form-label col-md-3 col-sm-3  label-align">UserName<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<input type="number" id="name" class="form-control" name="name" value="<?php echo $user_name?>" />
										</div>
									</div>						
									<div class="field item form-group">
										<label for="password" class="col-form-label col-md-3 col-sm-3  label-align">Password<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<input type="password" id="password" class="form-control" name="password" value="" />
										</div>
									</div>						
									<div class="field item form-group">
										<label for="comfirm_password" class="col-form-label col-md-3 col-sm-3  label-align">Comfirm Password<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6">
											<input type="password" id="comfirm_password" class="form-control" name="comfirm_password" value="" />
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
<script>
$(document).ready(function() {
    $('#password,#comfirm_password').on('keypress', function(event) {
        var charCode = event.which;
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 8) {
            event.preventDefault();
        }
    });
});
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