<?php
session_start();
session_regenerate_id(TRUE);

require_once('inc/config.php');
require_once('layouts/header.php');


require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
require_once('inc/connoracle.php');




?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<form action="" method="post">
					<div class="row">
						<div class="col-sm-4">
							<label for="title">SELECT Company:</label>
							<SELECT required="" name="SELECT_company" id="SELECT_company" class="form-control">
								<option SELECTed value="">--</option>
								<option value="SASH">Amishe Attendance Machine</option>
								<option value="ALL">HO & Center Attendance Machine</option>
							</SELECT>
						</div>
						<div class="col-sm-4">
							<label for="title">SELECT Date:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar">
									</i>
								</div>
								<input required="" class="form-control" type='date' name='start_date'
									value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>'>
							</div>
						</div>

					</div>
					<div class="row md-form mt-3">
						<div class="col-sm-4">
						</div>
						<div class="col-sm-4">
							<div class="md-form mt">
								<input class="form-control btn btn-primary" type="submit"
									value="Data Syn Machine To Apps Server">
							</div>
						</div>
					</div>

					<hr>
				</form>
			</div>

			<div class="col-lg-12">
				<div class="md-form mt-5">
					<div class=" d-flex flex-column flex-md-row">
						<table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
							<thead class="table-dark">
								<tr>
									<th scope="col">Sl</th>
									<th scope="col">Emp ID</th>
									<th scope="col">Emp Name</th>
									<th scope="col">Department</th>
									<th scope="col">Date</th>
									<th scope="col">IN Time</th>
									<th scope="col">OUT Time</th>
									<th scope="col">Status</th>
								</tr>
							</thead>

							<tbody>

								<?php

								if (isset($_POST['start_date'])) {
									$company = $_REQUEST['SELECT_company'];
									$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));


									if ($company == 'SASH') {
										$synSQL = oci_parse(
											$objConnect,
											"SELECT to_number(regexp_replace(RML_ID, '[^0-9]', '')) AS ATTNMACHINE_ID,RML_ID,EMP_NAME,DEPT_NAME
											from RML_HR_APPS_USER
											where USER_ROLE IS NOT NULL
											AND IS_ACTIVE=1
											AND R_CONCERN='$company'"
										);
									} else {
										$synSQL = oci_parse(
											$objConnect,
											"SELECT  to_number(regexp_replace(RML_ID, '[^0-9]', '')) AS ATTNMACHINE_ID,RML_ID,EMP_NAME,DEPT_NAME
											from RML_HR_APPS_USER
											where USER_ROLE IS NOT NULL
											AND IS_ACTIVE=1
											AND BRANCH_NAME IN ('Head Office','Rangs Center')"
										);
									}

									if (oci_execute($synSQL)) {

										if ($company == 'SASH') {
											$serverName = "202.40.191.76";
											$connectionInfo = array("Database" => "Attendence Amishee", "UID" => "sa", "PWD" => "R@ngs*it");
											$dbConnect = sqlsrv_connect($serverName, $connectionInfo);
										} else {
											$serverName = "192.168.172.17";
											$connectionInfo = array("Database" => "attdb", "UID" => "sa", "PWD" => "R@ngs*it");
											$dbConnect = sqlsrv_connect($serverName, $connectionInfo);
										}

										$number = 0;

										while ($row = oci_fetch_assoc($synSQL)) {

											$ATTNMACHINE_ID = $row['ATTNMACHINE_ID'];
											$v_rml_id = $row['RML_ID'];
											$rml_name = $row['EMP_NAME'];
											$rml_dept = $row['DEPT_NAME'];



											if ($company == 'SASH') {
												$strPunchSQL = "SELECT convert(varchar(30), MIN(dteTime), 108) IN_TIME,
												convert(varchar(30), MAX(dteTime), 108) OUT_TIME,
												convert(varchar, dteDate, 103) AS ATTN_DATE 
												FROM (
												SELECT CHECKTIME dteTime,convert(varchar, '$attn_start_date', 103)dteDate
												FROM [Attendence Amishee].[dbo].[CHECKINOUT] a
												where  USERID=(SELECT USERID from [Attendence Amishee].[dbo].[USERINFO] where BADGENUMBER='$ATTNMACHINE_ID')
												and convert(varchar, CHECKTIME, 103)=convert(varchar, '$attn_start_date' , 103)
												) bb
											group by dteDate";
											} else {
												$strPunchSQL = "SELECT convert(varchar(30), MIN(dteTime), 108) IN_TIME,
												convert(varchar(30), MAX(dteTime), 108) OUT_TIME,
												convert(varchar, dteDate, 103) AS ATTN_DATE 
												FROM (
												SELECT CHECKTIME dteTime,convert(varchar, '$attn_start_date', 103)dteDate
												FROM [attdb].[dbo].[CHECKINOUT] a
												where  USERID=(SELECT USERID from [attdb].[dbo].[USERINFO] where BADGENUMBER='$ATTNMACHINE_ID')
												and convert(varchar, CHECKTIME, 103)=convert(varchar, '$attn_start_date' , 103)
												) bb
												group by dteDate";
											}



											try {
												$stmt = sqlsrv_query($dbConnect, $strPunchSQL);
											} catch (Exception $e) {
												echo $e;
											}
											$isFound = 0;
											while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
												$isFound = 1;
												$ATTN_DATE = $row['ATTN_DATE'];
												$IN_TIME = $row['IN_TIME'];
												$OUT_TIME = $row['OUT_TIME'];


												if ($isFound == 1) {
													$number++;
													$processSQL = oci_parse($objConnect, "BEGIN RML_HR_ATTN_DATA_SYN('$v_rml_id','$ATTN_DATE','$IN_TIME','$OUT_TIME');END;");


													ini_set('max_execution_time', 0);
													set_time_limit(1800);
													ini_set('memory_limit', '-1');
													if (oci_execute($processSQL)) {
														?>
														<tr>
															<td><?php echo $number; ?></td>
															<td><?php echo $v_rml_id; ?></td>
															<td><?php echo $rml_name; ?></td>
															<td><?php echo $rml_dept; ?></td>
															<td><?php echo $ATTN_DATE; ?></td>
															<td><?php echo $IN_TIME; ?></td>
															<td><?php echo $OUT_TIME; ?></td>
															<td><?php echo "BEGIN RML_HR_ATTN_DATA_SYN('$v_rml_id','$ATTN_DATE','$IN_TIME','$OUT_TIME');END;"; ?>
															</td>
														</tr>
														<?php
													} else {
														?>
														<tr>
															<td><?php echo $number; ?></td>
															<td><?php echo $v_rml_id; ?></td>
															<td><?php echo $rml_name; ?></td>
															<td><?php echo $rml_dept; ?></td>
															<td><?php echo $ATTN_DATE; ?></td>
															<td><?php echo $IN_TIME; ?></td>
															<td><?php echo $OUT_TIME; ?></td>
															<td><?php echo 'Fail'; ?></td>
														</tr>

														<?php
													}
												}
											}
										}
									}
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

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>
<?php require_once('layouts/footer.php'); ?>