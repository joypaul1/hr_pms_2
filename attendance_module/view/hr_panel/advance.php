<?php
require_once ('../../../helper/3step_com_conn.php');
require_once ('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('hr-attendance-advance-report')) {
	echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$emp_session_id          = $_SESSION['HR_APPS']['emp_id_hr'];
$is_exel_download_eanble = 0;

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
	<div class="">
		<!-- Breadcrumbs-->
		<div class="">
			<div class="">
				<div class="card card-body">

					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
						<div class="row">
							<div class="col-sm-3">
								<label class="form-label" for="basic-default-fullname">Select Start Date <span
										class="text-danger fw-bold">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input required="" class="form-control cust-control" type='date' name='start_date'
										value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>'>
								</div>
							</div>
							<div class="col-sm-3">
								<label class="form-label" for="basic-default-fullname">Select End Date <span
										class="text-danger fw-bold">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar">
										</i>
									</div>
									<input required="" class="form-control cust-control" type='date' name='end_date'
										value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>'>
								</div>
							</div>
							<div class="col-sm-3">
								<label class="form-label" for="basic-default-fullname"> Concern / Company Name </label>
								<select name="company_name" class="form-control  cust-control">
									<option selected value="">All</option>
									<?php

									$strSQL  = oci_parse($objConnect, "SELECT UNIQUE(R_CONCERN) AS R_CONCERN FROM RML_HR_APPS_USER ORDER BY R_CONCERN");
									oci_execute($strSQL);
									while ($row = oci_fetch_assoc($strSQL)) {
									?>
										<option value="<?php echo $row['R_CONCERN']; ?>" <?php echo (isset($_POST['company_name']) && $_POST['company_name'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>><?php echo $row['R_CONCERN']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label class="form-label" for="basic-default-fullname"> Department Name </label>
								<select name="emp_dept" class="form-control cust-control">
									<option selected value=""><-- Select Department --></option>
									<?php
									// Connect to the database
									$strSQL = @oci_parse($objConnect, "SELECT DISTINCT DEPT_NAME AS DEPT_NAME FROM RML_HR_APPS_USER WHERE DEPT_NAME IS NOT NULL AND IS_ACTIVE=1 ORDER BY DEPT_NAME");
									if (!$strSQL) {
										$error = @oci_error($objConnect);
										echo "SQL parsing error: " . $error['message'];
									}
									$result = @oci_execute($strSQL);
									while ($row = @oci_fetch_assoc($strSQL)) {
										?>
										<option <?php if (isset($_POST['emp_dept']) && $_POST['emp_dept'] === $row['DEPT_NAME']) {
											echo 'selected';
										} ?>
											value="<?php echo $row['DEPT_NAME']; ?>"><?php echo $row['DEPT_NAME']; ?></option>
										<?php
									}
									?>
								</select>

							</div>
							<div class="col-sm-3">
								<label class="form-label" for="basic-default-fullname"> Branch Name </label>
								<select name="emp_branch" class="form-control cust-control">
									<option selected value=""><-- Select Branch --></option>
									<?php
									$strSQL = oci_parse($objConnect, "SELECT distinct(BRANCH_NAME) AS BRANCH_NAME from RML_HR_APPS_USER where BRANCH_NAME is not null  and is_active=1
									order by BRANCH_NAME");
									oci_execute($strSQL);
									while ($row = oci_fetch_assoc($strSQL)) {
										?>
										<!-- <option value="<?php echo $row['BRANCH_NAME']; ?>"><?php echo $row['BRANCH_NAME']; ?></option> -->
										<option <?php if (isset($_POST['emp_branch']) && $_POST['emp_branch'] === $row['BRANCH_NAME']) {
											echo 'selected';
										} ?> value="<?php echo $row['BRANCH_NAME']; ?>"><?php echo $row['BRANCH_NAME']; ?>
										</option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label class="form-label" for="basic-default-fullname">Select Attendance Status</label>
								<select name="attn_status" class="form-control cust-control">
									<option selected value=""><-- Select Status --></option>
									<option value="P">Present</option>
									<option value="L">Late</option>
									<option value="A">Absent</option>
									<option value="RP">Roster Present</option>
									<option value="SL">Sick Leave</option>
									<option value="CL">Casual Leave</option>
									<option value="EL">Earned/Annual Leave</option>
									<option value="ML">Maternity Leave</option>
									<option value="PL">Paternity Leave</option>
								</select>
							</div>

							<div class="col-sm-3">
								<label class="form-label" for="basic-default-fullname">REMARKS</label>
								<select name="remarks_status" class="form-control cust-control">
									<option selected value="<?= null ?>">Without Remarks</option>
									<option value="with">With Remarks</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label class="form-label" for="basic-default-fullname"></label>
								<button class="form-control btn btn-sm btn-primary" type="submit">
									Search Attendance
								</button>
							</div>
						</div>
						<!-- <hr> -->
					</form>
				</div>
				<?php

				@$emp_id = $_REQUEST['emp_id'];
				@$attn_status = $_REQUEST['attn_status'];
				@$emp_branch = $_REQUEST['emp_branch'];
				@$v_emp_dept = $_REQUEST['emp_dept'];
				@$v_company_name = $_REQUEST['company_name'];
				@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
				@$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
				?>

				<div class="card mt-2" id="table">

					<div class="card-body">
						<div class="d-block text-uppercase text-center">
							<div>
								<h3><b>RANGS MOTORS LIMITED</b></h3>
							</div>
							<div>
								<h6>117/A,Lavel-04,Old Airport Road,Bijoy Sharani,</h6>
							</div>
							<div>
								<h6>Tejgoan,Dhaka-1215</h6>
							</div>
							<div>
								<h6>
									Date :- <?php if (isset($_POST['attn_status'])) {
										echo $attn_start_date . ' -To- ' . $attn_end_date;
									} ?>
								<h6>
							</div>
						</div>
					</div>

					<!-- style for table-->
					<style>
						.table> :not(caption)>*>* {
							padding: 0;
						}
						.subbtn {
							color: #fff !important;
							background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
						}
					</style>
					<!-- style for table-->

					<div class="card-body">
						<div class="table-responsive text-nowrap">
							<table class="table table-bordered table-responsive" style="width:100%">
								<thead class="table-dark text-center">
									<tr class="text-center">
										<th scope="col">Sl</th>
										<th scope="col">Emp ID</th>
										<th scope="col">User Name</th>
										<th scope="col">Date</th>
										<th scope="col">IN Time</th>
										<th scope="col">OUT Time</th>
										<th scope="col">Late Time(Minutes)</th>
										<th scope="col">Status</th>
										<th scope="col">Branch Name</th>
										<th scope="col">Dept. Name</th>
										<th scope="col">ATTN Lock Status</th>
										<?php
										if (isset($_POST['remarks_status'])) {
											echo '<th scope="col">HR Entry REMARKS</th>';
										}
										?>
									</tr>
								</thead>

								<tbody>

									<?php

									if (isset($_POST['attn_status'])) {

										if (isset($_POST['remarks_status']) && $_POST['remarks_status'] == 'with') {
											$query = "SELECT a.RML_ID,
											a.ATTN_DATE,
											a.RML_NAME,
											a.IN_TIME,
											a.OUT_TIME,
											a.STATUS,
											a.DEPT_NAME,
											a.IN_LAT,
											a.IN_LANG,
											a.DAY_NAME,
											a.BRANCH_NAME,
											a.LOCK_STATUS,
											a.LOCAK_DATE,
											a.LATE_TIME,
											(select ATTN.OUTSIDE_REMARKS
											from RML_HR_ATTN_DAILY ATTN
											where ATTN.INSIDE_OR_OUTSIDE='HR ATTN'
											and ATTN.RML_ID=a.RML_ID
											and trunc(ATTN.ATTN_DATE) = trunc(a.ATTN_DATE)
											AND ROWNUM=1) HR_REMARKS
											from RML_HR_ATTN_DAILY_PROC a ,RML_HR_APPS_USER b
											where a.RML_ID = b.RML_ID
											and b.IS_ACTIVE = 1
											and trunc(a.ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
											and ('$attn_status' is null OR a.STATUS='$attn_status')
											and ('$v_emp_dept' is null or a.DEPT_NAME='$v_emp_dept')
											and ('$emp_branch' is null or a.BRANCH_NAME='$emp_branch')
											and ('$v_company_name' is null or a.R_CONCERN='$v_company_name')
											order by a.ATTN_DATE";
										}
										else {
											$query = "SELECT a.RML_ID,
											a.ATTN_DATE,
											a.RML_NAME,
											a.IN_TIME,
											a.OUT_TIME,
											a.STATUS,
											a.DEPT_NAME,
											a.IN_LAT,
											a.IN_LANG,
											a.DAY_NAME,
											a.BRANCH_NAME,
											a.LOCK_STATUS,
											a.LOCAK_DATE,
											a.LATE_TIME
											from RML_HR_ATTN_DAILY_PROC a ,RML_HR_APPS_USER b
											where a.RML_ID = b.RML_ID
											and b.IS_ACTIVE = 1
											and trunc(a.ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
											and ('$attn_status' is null OR a.STATUS='$attn_status')
											and ('$v_emp_dept' is null or a.DEPT_NAME='$v_emp_dept')
											and ('$emp_branch' is null or a.BRANCH_NAME='$emp_branch')
											and ('$v_company_name' is null or a.R_CONCERN='$v_company_name')
											order by a.ATTN_DATE";
										}
										$strSQL = oci_parse($objConnect, $query);

										oci_execute($strSQL);
										$number           = 0;
										$lateCount        = 0;
										$presentCount     = 0;
										$absentCount      = 0;
										$tourCount        = 0;
										$leaveCount       = 0;
										$weekendCount     = 0;
										$holidayCount     = 0;
										$lateMinutesCount = 0;

										while ($row = oci_fetch_assoc($strSQL)) {
											$number++;
											$is_exel_download_eanble = 1;
											?>
											<tr>
												<td><?php echo $number; ?></td>
												<td><?php echo $row['RML_ID']; ?></td>
												<td><?php echo $row['RML_NAME']; ?></td>
												<td><?php echo $row['ATTN_DATE']; ?></td>
												<td><?php echo $row['IN_TIME']; ?></td>
												<td><?php echo $row['OUT_TIME']; ?></td>
												<td align="center"><?php echo $row['LATE_TIME'];
												$lateMinutesCount += $row['LATE_TIME']; ?></td>
												<td align="center">
													<?php
													if ($row['STATUS'] == 'L') {
														echo '<span style="color:red;text-align:center;">Late</span>';
														$lateCount++;
													}
													elseif ($row['STATUS'] == 'A') {
														echo '<span style="color:red;text-align:center;">Absent</span>';
														$absentCount++;
													}
													elseif ($row['STATUS'] == 'T') {
														echo '<span style="color:green;text-align:center;">Tour</span>';
														$tourCount++;
													}
													elseif ($row['STATUS'] == 'W') {
														echo 'Weekend';
														$weekendCount++;
													}
													elseif ($row['STATUS'] == 'H') {
														echo 'Holiday';
														$holidayCount++;
													}
													elseif ($row['STATUS'] == 'P') {
														echo 'Present';
														$presentCount++;
													}
													elseif (
														$row['STATUS'] == 'SL' ||
														$row['STATUS'] == 'CL' ||
														$row['STATUS'] == 'EL' ||
														$row['STATUS'] == 'PL' ||
														$row['STATUS'] == 'ML'
													) {
														echo $row['STATUS'];
														$leaveCount++;
													}
													else {
														echo $row['STATUS'];
														$presentCount++;
													}

													?>
												</td>
												<td><?php echo $row['BRANCH_NAME']; ?></td>
												<td><?php echo $row['DEPT_NAME']; ?></td>
												<td><?php
												if ($row['LOCK_STATUS'] == 1)
													echo 'Locked-' . $row['LOCAK_DATE'];
												?>

												</td>
												<?php if (isset($_POST['remarks_status']) && $_POST['remarks_status'] == 'with') { ?>
													<td><?= $row['HR_REMARKS'] ?> </td>
												<?php } ?>

											</tr>
											<?php
										}
									}

									?>
								</tbody>

							</table>

						</div>

						<?php
						if ($is_exel_download_eanble != 0) {
							?>
							<div class="d-block text-right mt-1">
								<a class="btn btn-sm btn-info subbtn" id="downloadLink" onclick="exportF(this)">
									Export To Excel <i class="menu-icon tf-icons bx bx-download"></i></a>
							</div>
							<?php
						}
						?>

					</div>
				</div>
			</div>
		</div>


		<div style="height: 1000px;"></div>
	</div>
</div>
<!-- / Content -->

<script>
	function exportF(elem) {
		var table = document.getElementById("table");
		var html = table.outerHTML;
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);
		elem.setAttribute("download", "EMP_ATTN.xls"); // Choose the file name
		return false;
	}
</script>



<?php require_once ('../../../layouts/footer_info.php'); ?>
<?php require_once ('../../../layouts/footer.php'); ?>