		<?php 
			$title = 'Promotion Form!';
			$process_error  = false;
			$error  = false;
			$cash_error = false;
			$check_error_item = false;
			$error_item = '';
			$error_message  = '';
			$promotion_name = '';
			$discount_type  = '';
			$item  = [];	
			$status  = '';
			$amount         = '';
			$start_date     = '';
			$end_date       = '';
			$description    = '';
			require ('../require/common.php');
			require ('../include/include_function.php');
			require ('../template/cp_template_header.php');
			require ('../template/cp_template_sidebar.php');
			require ('../template/cp_template_top_nav.php');
			
			$sql = "SELECT id, name, category_id
			FROM item
			WHERE deleted_at IS NULL AND status = '$admin_enable_status'
			ORDER BY id ASC, category_id ASC
			";	
			$item_result = $mysqli->query($sql);
			if (isset($_POST['form_sub']) && $_POST['form_sub'] ==  '1') {
				$promotion_name =  $mysqli->real_escape_string($_POST['name']);
				$discount_type =  $mysqli->real_escape_string($_POST['discount_type']);
				$amount =  (int)($_POST['amount']);
				$status =  (int)($_POST['status']);
				$item = isset($_POST['item']) ? $_POST['item'] : [];
				$start_date =  $mysqli->real_escape_string($_POST['start_date']);
				$end_date =  $mysqli->real_escape_string($_POST['end_date']);
				$start_date_format = convertDateFormatYmd($start_date);
				$end_date_format = convertDateFormatYmd($end_date);
				$description =  $mysqli->real_escape_string($_POST['description']);

				if ($promotion_name == ''){
					$process_error  = true;
					$error  = true;
					$error_message  .= 'Please Fill Promotion Name .\n';
				}
				if ($amount == ''){
					$process_error  = true;
					$error  = true;
					$error_message  .= 'Please Fill Any amount .\n';
				}
				if ($start_date == ''){
					$process_error  = true;
					$error  = true;
					$error_message  .= 'Please Choice Start Date .\n';
				}
				if ($end_date == ''){
					$process_error  = true;
					$error  = true;
					$error_message .= "Please Choice End Date .";

				}
				if ($item == []){
					$process_error  = true;
					$error  = true;
					$error_message  .= 'Please Choice At least One Item .\n';
				}else{
					foreach($item as $item_ids){
					$check_item_sql = "	SELECT item.name FROM discount_item TO1 
										JOIN discount_promotion TO2 ON TO1.discount_id = TO2.id
										JOIN item ON TO1.item_id = item.id
										WHERE TO1.item_id = $item_ids
										AND '$start_date_format' <= TO2.end_date
										AND '$end_date_format' >= TO2.start_date
										AND TO1.deleted_at IS NULL AND TO2.deleted_at IS NULL";
					$check_result = $mysqli->query($check_item_sql);
					if ($check_result){
						$num_rows = $check_result->num_rows;
						if ($num_rows >= 0) {
							while ($row = $check_result->fetch_assoc()) {
								$check_error_item = true;
								$error_item .= $row['name'] . ',';
							}
					}}}
				if($check_error_item){
                    $process_error  = true;
					$error  = true;
					$error_message  .= "('" . rtrim($error_item, ',') . "')'s date range is already exists promotion Date.";
					$error_item = '';
				}	
				if ($discount_type == 'percentage'){
					if($amount > 100){
                        $process_error  = true;
						$error  = true;
						$error_message  .= 'pecentage is over 100 % .\n';
					}
				}else{
					$item_ids = implode(',', array_map('intval', $item));
					$sql_amount_check = "SELECT name,price FROM `item` WHERE id IN ($item_ids)";
                    $amount_result = $mysqli->query($sql_amount_check);
					while ($amount_row = $amount_result->fetch_assoc()) {
						if($amount > $amount_row['price']){
							$cash_error = true;
							$error_item .= $amount_row['name'] . ',';
						}
				}
				}
			}
			if ($cash_error){
                $process_error  = true;
				$error  = true;
				$error_message .= "Discount cash Amount is more than ('" . rtrim($error_item, ',') . "') price.";
			}
			if ($process_error == false){
				$sql = "SELECT count(id) As total FROM `discount_promotion` WHERE name = '$promotion_name' AND deleted_at IS NULL";
				$row = $mysqli->query($sql)->fetch_assoc();
			if ($row['total'] > 0) {
				$error = TRUE;
				$error_message .= "promotion_name is already exists<br />";
			}else {
				$id   = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_COOKIE['id']) ? $_COOKIE['id'] : null);
				$date = date('Y-m-d H.i.s');
				if ($discount_type == 'cash') {
					$sql = "INSERT INTO `discount_promotion` (name, amount, start_date, end_date,description, status, created_at, created_by)
							VALUES ('$promotion_name', '$amount', '$start_date_format', '$end_date_format', '$description', '$status', '$date', '$id')";
				} else {
					$sql = "INSERT INTO `discount_promotion` (name, percentage, start_date, end_date, description, status, created_at, created_by)
							VALUES ('$promotion_name', '$amount', '$start_date_format', '$end_date_format', '$description', '$status', '$date', '$id')";
				}
				$result = $mysqli->query($sql);		
				if(!$result){
					$error = TRUE;
					$error_message .= "Oop! something wrong. please contact administrator<br />";
					$url =  $cp_base_url . "discount_list?err=create";
					echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
					exit();
				}else{
					$lastInsertedId = $mysqli->insert_id;
					foreach ($item as $item_id) {
						$sql = "INSERT INTO `discount_item` (item_id, discount_id,created_at,created_by)
								VALUES ('$item_id', '$lastInsertedId' , '$date' , '$id')";
						$mysqli->query($sql);
					}
					$url =  $cp_base_url . "discount_list?msg=create";
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
										<h2>Promotion Create</h2>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<form class="" action="" method="POST" enctype="multipart/form-data" novalidate>
											<span class="section"> Promotion Info</span>
											<div class="field item form-group">
												<label for="name" class="col-form-label col-md-3 col-sm-3  label-align">Promotion Name<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6">
													<input id="name" class="form-control" name="name" value="<?php echo $promotion_name?>" />
												</div>
											</div>
											<div class="field item form-group">
											<label for="discount_type" class="col-form-label col-md-3 col-sm-3  label-align">Discount Type<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6">
													<div style="margin-top:9px;">
                          								<input type="radio" id="percentage" name="discount_type" <?php if($discount_type == 'percentage'){echo 'checked';} ?> value="percentage" checked/>
														<label for="percentage">Percentage</label>
                          								<input type="radio" id="cash" name="discount_type" <?php if($discount_type == 'cash'){echo 'checked';} ?>  value="cash" />
														<label for="cash">Cash</label>
													</div>	 
												</div>
												</div>
												<div class="field item form-group">
												<label for="amount" class="col-form-label col-md-3 col-sm-3  label-align"><span class = "discount_amount">Discount Percentage Amount</span><span class="required">*</span></label>
													<div class="col-md-6 col-sm-6">
														<input type="number" class="form-control" id="amount" name="amount" value="<?php echo $amount;?>" />
													</div>
												</div>	
												<div class="field item form-group">
											<label for="Status" class="col-form-label col-md-3 col-sm-3  label-align">Status<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6">
												<select id="Status" name = "status" class="select2_group form-control">
														<option value="" disabled>SELECT ONE</option>
														<option value="0" <?php if($status){ echo 'selected';} ?>>Enable</option>
														<option value="1" <?php if($status){ echo 'selected';} ?>>Disable</option>
												</select>
												</div>
												</div>
											<div class="field item form-group">
												<label for="start_date" class="col-form-label col-md-3 col-sm-3  label-align">Start Date<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6">
													<input type="text" class="form-control has-feedback-left" name="start_date" id="start_date" value="<?php echo $start_date;?>" aria-describedby="inputSuccess2Status">
													<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
													<span id="inputSuccess2Status" class="sr-only">(success)</span>
												</div>
											</div>
											<div class="field item form-group">
												<label for="end_date" class="col-form-label col-md-3 col-sm-3  label-align">End Date<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6">
													<input type="text" class="form-control has-feedback-left" name="end_date" id="end_date" value="<?php echo $end_date;?>" aria-describedby="inputSuccess2Status2">
													<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
													<span id="inputSuccess2Status2" class="sr-only">(success)</span>
												</div>
											</div>
											<div class="field item form-group">
												 <label for="Parent" class="col-form-label col-md-3 col-sm-3  label-align">Item<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6">
											<?php	
												while ($item_row = $item_result->fetch_assoc()) {
													$id        = (int)($item_row['id']);
													$item_name = htmlspecialchars($item_row['name']);
													?>
													<!-- <div class = "row"> -->
													<div class="col-md-5">
														<input type="checkbox" class="flat" id="<?php echo $item_name?>" name ="item[]" <?php if(in_array($id , $item)){ echo 'checked';}?> value = "<?php echo $id ?>"/>
														<label for="<?php echo $item_name?>"><?php echo $item_name?></label>
													</div>
													<!-- </div> -->
													<?php
												}?>					
												</div>
											</div>
											<div class="field item form-group">
											<label for="single_cal2" class="col-form-label col-md-3 col-sm-3  label-align">Description<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6">
												<textarea id="description" required="required" class="form-control" name="description" value="<?php echo $description;?>" ></textarea>
											</div>
											</div>
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
   		$(document).ready(function() {
			$('input[name="discount_type"]').change(function() {
				const selectedValue = $('input[name="discount_type"]:checked').val();
				if (selectedValue == 'cash') {
					$('.discount_amount').text('Discount Cash Amount');
				} else {
					$('.discount_amount').text('Discount Percentage Amount');
				}
			});
    });
	<?php
	if ($error == true) {
		?>
			
			Swal.fire({
					title: "Error!",
					text: "<?php echo $error_message?>",
					icon: "error",
				});
			;
		<?php
		}
	?>
		</script>
		</html>