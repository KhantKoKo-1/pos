<?php 
  $title = 'Admin Panel! Shift List';
	require ('../require/common.php');
	require ('../template/cp_template_header.php');
	require ('../template/cp_template_sidebar.php');
	require ('../template/cp_template_top_nav.php');
  $sql = "SELECT id,start_date_time,end_date_time
  FROM `shift`
  WHERE deleted_at IS NULL ORDER BY `id` DESC";
  $result = $mysqli -> query($sql);
  $success = false;
  $error = false;
  if (isset($_GET['msg'])) {
    $success = true;
    switch ($_GET['msg']) {
        case 'start':
            $success_message = 'OPEN !!!!!!!'; 
            break;
        case 'end':
            $success_message = 'CLOSE !!!!!!'; 
            break;
    }
}

if (isset($_GET['err'])) {
  $error = true;
  switch ($_GET['err']) {
      case 'start':
          $error_message = 'Shift is already Open !!!!'; 
          break;
      case 'end':
          $error_message = 'Shift is already Close !!!!'; 
          break;
  }
}
$start_url = $cp_base_url . "start_shift.php";
$end_url = $cp_base_url . "end_shift.php";
?>

		<!-- page content -->
		<div class="right_col" role="main">
          <div class="">
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Shift List </h2>
                    <div class="clearfix"></div>
                  </div>
                  <?php require ('../require/shift_validation.php');?>
                  <div>
                  <button type="button" class="btn btn-primary btn-lg" onclick="openTime('<?php echo $start_url; ?>')" 
                    style="<?php echo $opened ? 'display: none;' : 'display: inline;'; ?>">
                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                    <span class="glyphicon-class">Open-Time</span>
                  </button>
                  <button type="button" class="btn btn-secondary btn-lg" onclick="closeTime('<?php echo $end_url; ?>')" 
                  style="<?php echo !$opened ? 'display: none;' : 'display: inline;'; ?>">
                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                    <span class="glyphicon-class">Close-Time</span>
                  </button>
                  </div>
                  <div class="x_content">
                  <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title">Start Date Time </th>
                            <th class="column-title">End Date Time </th>
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
                            $start_time = $rows['start_date_time'];
                            $end_time = $rows['end_date_time'];
                            ?>
                             <tr class="even pointer">
                              <td class="a-center ">
                                <input type="checkbox" class="flat" name="table_records">
                              </td>
                              <td class=" "><?php echo $start_time?></td>
                              <td class=" "><?php echo $end_time?></td>
                              <td class="last">
                              <a href="javascript:void(0)" class="btn btn-info btn-xs" style="width:50%;"><i class="fa fa-pencil"></i> View Order List </a>
                              <!-- <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="confirmDelete('<?php echo $delete_url; ?>')">
                                  <i class="fa fa-trash-o"></i> Delete
                              </a>
                              <a href="javascript:void(0)" class="btn btn-primary btn-xs"><i class="fa fa-arrows"></i>Move</a> -->

                              <!-- </td> -->
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
  
    function openTime(startUrl) {
      Swal.fire({
        title: 'Open Time Confirmation',
        text: 'Are you sure you want to Open?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, open time!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire('Opened!', 'Open time has been confirmed.', 'success');
          window.location.href = startUrl;
        }
      });
    }

    function closeTime(endUrl) {
      Swal.fire({
        title: 'Close Time Confirmation',
        text: 'Are you sure you want to Close?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, close time!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire('Closed!', 'Close time has been confirmed.', 'success');
          window.location.href = endUrl;
        }
      });
    }
  </script>
</script>
</html>