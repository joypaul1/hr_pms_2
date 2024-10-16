<?php
require_once ('../../../helper/3step_com_conn.php');
require_once ('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('self-tour-report')) {
	echo "<script>
		window.location.href = '$basePath/index.php?logout=true';
	</script>";
}
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
// echo $emp_session_id;

?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

	<div class="card col-lg-12 mb-2">
		<div class="card-body">
			<form action="" method="post">
				<div class="row justify-content-center">
					<input readonly name="emp_id" class="form-control cust-control" type='hidden' value='<?php echo $emp_session_id; ?>'>
					<div class="col-sm-2">
						<label class="form-label" for="basic-default-fullname">Start Date <span class="text-danger">*</span></label>
						<div class="input-group">

							<input required="" type="date" name="start_date" class="form-control cust-control" id="title"
								value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>'>
						</div>
					</div>
					<div class="col-sm-2">
						<label class="form-label" for="basic-default-fullname">End Date <span class="text-danger">*</span></label>
						<div class="input-group">

							<input required="" type="date" name="end_date" class="form-control cust-control" id="title"
								value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>'>
						</div>
					</div>
					<div class="col-sm-2">
						<label class="form-label" for="basic-default-fullname">Approval Status</label>
						<select name="approval_status" class="form-control cust-control">
							<option hidden value=""><-- Select Status --></option>
							<option value="1">Approved</option>
							<option value="0">Pending</option>

						</select>
					</div>
					<div class="col-sm-2">
						<label class="form-label" for="basic-default-fullname">&nbsp;</label>
						<input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data ">
					</div>

				</div>

			</form>
		</div>
	</div>



	<!-- Bordered Table -->
	<div class="card">
		<h5 class="card-header"><b>Tour List</b></h5>
		<div class="card-body">
			<div class="table-responsive text-nowrap">
				<table class="table table-bordered">
					<thead style="background-color: #b8860b;">
						<tr class="text-center">
							<th>SL</th>
							<th scope="col">Start Date</th>
							<th scope="col">End Date</th>
							<th scope="col">Entry Date</th>
							<th scope="col">Approval Status</th>
							<th scope="col">Line Manager</th>
							<th scope="col">Approved/Denied Date</th>
						</tr>
					</thead>
					<tbody>

						<?php
						if (isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])) {
							$v_emp_id          = $_REQUEST['emp_id'];
							$v_approval_status = $_REQUEST['approval_status'];
							$v_start_date      = date("d/m/Y", strtotime($_REQUEST['start_date']));
							$v_end_date        = date("d/m/Y", strtotime($_REQUEST['end_date']));

							$strSQL = oci_parse(
								$objConnect,
								"SELECT  
									B.RML_ID,
									B.EMP_NAME,
									B.R_CONCERN,
									B.DEPT_NAME,B.BRANCH_NAME,B.DESIGNATION,
									A.START_DATE, 
									A.END_DATE, 
									A.REMARKS, 
									A.ENTRY_DATE, 
									A.ENTRY_BY, 
									A.LINE_MANAGER_ID, 
									A.LINE_MANAGER_APPROVAL_STATUS, 
									A.APPROVAL_DATE, 
									A.APPROVAL_REMARKS
								FROM RML_HR_EMP_TOUR A,RML_HR_APPS_USER B
								WHERE A.RML_ID=B.RML_ID
								AND (A.START_DATE BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY') or
			                         A.END_DATE BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY'))
								AND B.RML_ID='$emp_session_id'
								AND ('$v_approval_status' is null or A.LINE_MANAGER_APPROVAL_STATUS='$v_approval_status')
								"
							);
							oci_execute($strSQL);
							$number = 0;
							while ($row = oci_fetch_assoc($strSQL)) {
								$number++;
								?>
								<tr>
									<td>
										<strong>
											<?php echo $number; ?>
										</strong>
									</td>
									<td>
										<?php echo $row['START_DATE']; ?>
									</td>
									<td>
										<?php echo $row['END_DATE']; ?>
									</td>
									<td>
										<?php echo $row['ENTRY_DATE']; ?>
									</td>
									<td>
										<?php
										if ($row['LINE_MANAGER_APPROVAL_STATUS'] == '1') {
											echo 'Approved';
										}
										else if ($row['LINE_MANAGER_APPROVAL_STATUS'] == '0') {
											echo 'Denied';
										}
										else {
											echo 'Pending';
										}

										?>
									</td>
									<td>
										<?php echo $row['LINE_MANAGER_ID']; ?>
									</td>
									<td>
										<?php echo $row['APPROVAL_DATE']; ?>
									</td>

								</tr>


								<?php
							}
						}
						else {
							$allDataSQL = oci_parse(
								$objConnect,
								"SELECT  
								B.RML_ID,
                                B.EMP_NAME,
                                B.R_CONCERN,
                                B.DEPT_NAME,B.BRANCH_NAME,B.DESIGNATION,								
								A.START_DATE, 
								A.END_DATE, 
								A.REMARKS, 
								A.ENTRY_DATE, 
								A.ENTRY_BY, 
								A.LINE_MANAGER_ID, 
								A.LINE_MANAGER_APPROVAL_STATUS, 
								A.APPROVAL_DATE, 
								A.APPROVAL_REMARKS
								FROM RML_HR_EMP_TOUR A,RML_HR_APPS_USER B
								WHERE A.RML_ID=B.RML_ID
								AND A.RML_ID='$emp_session_id'"
							);


							oci_execute($allDataSQL);
							$number = 0;
							while ($row = oci_fetch_assoc($allDataSQL)) {
								$number++;
								?>
								<tr>
									<td>
										<strong>
											<?php echo $number; ?>
										</strong>
									</td>
									<td>
										<?php echo $row['START_DATE']; ?>
									</td>
									<td>
										<?php echo $row['END_DATE']; ?>
									</td>
									<td>
										<?php echo $row['ENTRY_DATE']; ?>
									</td>

									<td>
										<?php
										if ($row['LINE_MANAGER_APPROVAL_STATUS'] == '1') {
											echo 'Approved';
										}
										else if ($row['LINE_MANAGER_APPROVAL_STATUS'] == '0') {
											echo 'Denied';
										}
										else {
											echo 'Pending';
										}
										?>
									</td>
									<td>
										<?php echo $row['LINE_MANAGER_ID']; ?>
									</td>
									<td>
										<?php echo $row['APPROVAL_DATE']; ?>
									</td>

								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!--/ Bordered Table -->

</div>

<!-- / Content -->



<?php require_once ('../../../layouts/footer_info.php'); ?>
<?php require_once ('../../../layouts/footer.php'); ?>