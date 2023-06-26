<?php


require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');


$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$strSQL         = oci_parse(
	$objConnect,
	"select RML_ID,
                                   EMPLOYEE_NAME EMP_NAME,
                                   COMPANY_NAME R_CONCERN,
                                   DEPARTMENT DEPT_NAME,
                                   WORKSTATION BRANCH_NAME,
                                   DESIGNATION,
                                   BRAND EMP_GROUP,
                                   COLL_HR_EMP_NAME((SELECT aa.LINE_MANAGER_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)) LINE_MANAGER_1_NAME,
                                   COLL_HR_EMP_NAME((SELECT aa.DEPT_HEAD_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)) LINE_MANAGER_2_NAME
                            from empinfo_view_api@ERP_PAYROLL bb where RML_ID='$emp_session_id'"
);

oci_execute($strSQL);

?>


<div class="container-xxl flex-grow-1 container-p-y">
	<div class="container-fluids">

		<div class=" card">
			<div class="row card-body">
				<div class="col-lg-12">
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>

					<?php
					while ($row = oci_fetch_assoc($strSQL)) {
					?>

						<div class="row">
							<div class="col-sm-3">
								<label for="exampleInputEmail1">Employee ID:</label>
								<input name="emp_id" readonly form="Form1" placeholder="EMP-ID" class="form-control cust-control" type='text' value='<?php echo $row['RML_ID']; ?>' />
							</div>
							<div class="col-sm-3">
								<label for="exampleInputEmail1">Employee Name:</label>
								<input required="" name="emp_name" readonly placeholder="EMP Name" class="form-control cust-control" type='text' value='<?php echo $row['EMP_NAME']; ?>' />
							</div>
							<div class="col-sm-3">
								<label for="exampleInputEmail1">Employee Designation:</label>
								<input required="" name="emp_name" readonly placeholder="EMP Name" class="form-control cust-control" type='text' value='<?php echo $row['DESIGNATION']; ?>' />
							</div>
							<div class="col-sm-3">
								<label for="exampleInputEmail1">Employee Department:</label>
								<input required="" name="emp_name" readonly placeholder="EMP Name" class="form-control cust-control" type='text' value='<?php echo $row['DEPT_NAME']; ?>' />
							</div>
						</div>

						<div class="row mt-3">
							<div class="col-sm-3">
								<label for="exampleInputEmail1">PMS Line Manager-1:</label>
								<input class="form-control cust-control" required="" readonly type='text' value='<?php echo $row['LINE_MANAGER_1_NAME']; ?>' />
							</div>
							<div class="col-sm-3">
								<label for="exampleInputEmail1">PMS Line Manager-2:</label>
								<input required="" required="" class="form-control cust-control" readonly type='text' value='<?php echo $row['LINE_MANAGER_2_NAME']; ?>' />
							</div>
							<div class="col-sm-3">
								<label for="exampleInputEmail1">Employee Group:</label>
								<input required="" readonly placeholder="EMP Name" class="form-control cust-control" type='text' value='<?php echo $row['EMP_GROUP']; ?>' />
							</div>
							<div class="col-sm-3">
								<label for="exampleInputEmail1">Employee Branch:</label>
								<input required="" readonly placeholder="EMP Name" class="form-control cust-control" type='text' value='<?php echo $row['BRANCH_NAME']; ?>' />
							</div>
						</div>

						<div class="row mt-3">
							<div class="col-sm-3">
								<label for="exampleInputEmail1">Select PMS Title:</label>
								<select required="" name="pms_title_id" form="Form1" class="form-control cust-control">
									<option selected value="">--</option>
									<?php

									$strSQL = oci_parse($objConnect, "select ID,PMS_NAME from HR_PMS_LIST where is_active=1");
									oci_execute($strSQL);
									while ($row = oci_fetch_assoc($strSQL)) {
									?>

										<option value="<?php echo $row['ID']; ?>"><?php echo $row['PMS_NAME']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-6"></div>
							<div class="col-sm-3">
								<div class="md-form mt-3">
									<input class="form-control  btn  btn-sm  btn-primary" type="submit" form="Form1" value="Create PMS Profile">
								</div>
							</div>

						</div>

					<?php
					}
					?>


				</div>



				<?php


				if (isset($_POST['emp_id'])) {

					$emp_id         = $_REQUEST['emp_id'];
					$v_pms_title_id = $_REQUEST['pms_title_id'];

					$strSQL = oci_parse(
						$objConnect,
						"BEGIN 
						RML_PMS_PROFILE_CREATE('$emp_id',$v_pms_title_id,'$emp_session_id'); 
						END;"
					);

					if (@oci_execute($strSQL)) {

						echo '<div class="alert alert-primary">';
						echo "PMS Profile is created successfully.";
						echo '</div>';
					} else {
						$lastError                       = error_get_last();
						$error                           = @$lastError ? "" . @$lastError["message"] . "" : "";
						list($oci, $message, $mainerror) = explode(":", $error);
						list($databaseEror)              = explode("ORA", $mainerror);


						if (strpos($error, 'HR_PMS_EMP_CONSTRAIN_DUPLICATE') !== false) {
							echo '<div class="alert alert-danger">';
							echo $databaseEror;
							echo '</div>';
						}
					}
				}



				?>

			</div>
		</div>

		<div class="card mt-5">
			<div class="row card-body">


				<div class="col-lg-12">
					<div class="table-responsive">
						<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
							<thead style="background: beige;">
								<tr>
									<th class="text-center">Sl</th>
									<th scope="col">PM Title</th>
									<th scope="col">Self Information</th>
									<th scope="col">Self Status</th>
									<th scope="col">Line Manager-1 Status</th>
									<th scope="col">Line Manager-2 Status</th>
									<th scope="col">HR Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>

							<tbody>

								<?php
								$strSQL = oci_parse(
									$objConnect,
									"SELECT 
                                        ID, 
										EMP_NAME, 
										EMP_ID, 
                                        EMP_DEPT, 
										EMP_DESIGNATION, 
										EMP_WORK_STATION, 
                                        GROUP_NAME, 
										GROUP_CONCERN, 
										SELF_SUBMITTED_STATUS, 
                                        SELF_SUBMITTED_DATE, 
										LINE_MANAGER_1_ID,
                                        (SELECT BB.EMP_NAME FROM RML_HR_APPS_USER BB WHERE BB.RML_ID=PMS.LINE_MANAGER_1_ID)AS  LINE_MANAGER_1_NAME,										
										LINE_MANAGER_1_STATUS, 
                                        LINE_MANAGER_1_UPDATED, 
										LINE_MANAGER_2_ID,
                                       (SELECT BB.EMP_NAME FROM RML_HR_APPS_USER BB WHERE BB.RML_ID=PMS.LINE_MANAGER_2_ID)AS  LINE_MANAGER_2_NAME,													
										LINE_MANAGER_2_STATUS, 
                                        LINE_MANAGER_2_UPDATED, 
										HR_PMS_LIST_ID,
										PMS_WEIGHTAGE(EMP_ID,HR_PMS_LIST_ID) AS  PMS_WEIGHTAGE_STATUS,
                                       (SELECT AA.PMS_NAME FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS PMS_TITLE,									
										HR_ID, 
                                        HR_STATUS, 
										HR_STATUS_DATE, 
										CREATED_BY, 
                                        CREATED_DATE, 
										IS_ACTIVE,
										LINE_MANAGE_1_REMARKS
                                    FROM HR_PMS_EMP PMS
									WHERE EMP_ID='$emp_session_id'"
								);

								oci_execute($strSQL);
								$number = 0;


								while ($row = oci_fetch_assoc($strSQL)) {
									$number++;
								?>
									<tr>
										<td class="text-center">
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $row['PMS_TITLE']; ?>
											<input form="Form2" name="table_id" class="form-control" type='text' value='<?php echo $row['ID']; ?>' style="display:none" />
											<br>


											<a class="btn btn-warning btn-sm" href="pms_kpi_dtls.php?key=<?php echo $row['HR_PMS_LIST_ID']; ?>">Add / View
												KPI</a>

										</td>
										<td>
											<?php
											echo '<i style="color:red;"><b>' . $row['EMP_NAME'] . '</b></i> ';
											echo ',<br>';
											echo $row['EMP_DEPT'];
											echo ',<br>';
											echo $row['EMP_DESIGNATION'];
											echo ',<br>';
											echo $row['EMP_WORK_STATION'];
											echo ',<br>';
											echo $row['GROUP_CONCERN'];
											?>
										</td>
										<td>
											<?php
											if ($row['SELF_SUBMITTED_STATUS'] == 1)
												echo 'Submitted';
											else
												echo 'Not-Submitted';

											echo '<br>';
											echo $row['SELF_SUBMITTED_DATE'];
											?>
										</td>
										<td>
											<?php

											echo '<i style="color:red;"><b>' . $row['LINE_MANAGER_1_NAME'] . '</b></i> ';
											echo '<br>';
											echo $row['LINE_MANAGER_1_ID'];
											echo '<br>';
											if ($row['LINE_MANAGER_1_STATUS'] == 1)
												echo 'Status: Approved';
											else if ($row['LINE_MANAGER_1_STATUS'] == '')
												echo '';
											else if ($row['LINE_MANAGER_1_STATUS'] == 0)
												echo '<i style="color:red;"><b>Status: Decline</b></i> ';
											echo '<br>';
											echo 'Remarks: ' . $row['LINE_MANAGE_1_REMARKS'];
											echo '<br>';
											echo $row['LINE_MANAGER_1_UPDATED'];
											?>
										</td>
										<td>
											<?php
											echo '<i style="color:red;"><b>' . $row['LINE_MANAGER_2_NAME'] . '</b></i> ';
											echo '<br>';
											echo $row['LINE_MANAGER_2_ID'];
											echo '<br>';
											echo $row['LINE_MANAGER_2_UPDATED'];
											echo '<br>';

											if ($row['LINE_MANAGER_2_STATUS'] == 1)
												echo 'Status: Approved';
											else if ($row['LINE_MANAGER_2_STATUS'] == '')
												echo '';
											else if ($row['LINE_MANAGER_2_STATUS'] == 0)
												echo 'Status: Decline';

											?>
										</td>
										<td>
											<?php
											if ($row['HR_STATUS'] == 1)
												echo 'Closed';


											echo '<br>';
											echo $row['HR_STATUS_DATE'];
											?>
										</td>
										<td align="center">
											<?php
											if (($row['SELF_SUBMITTED_STATUS'] == 0 && $row['PMS_WEIGHTAGE_STATUS'] >= 100) || $row['LINE_MANAGER_1_STATUS'] == 0) {
											?>
												<input class="btn btn-warning btn-sm" form="Form2" type="submit" name="submit_approval" value="Submit" />
											<?php
											}
											?>
										</td>
									</tr>
								<?php

								}
								?>
							</tbody>

						</table>
					</div>

				</div>
				<?php
				if (isset($_POST['submit_approval'])) {
					$table_id = $_REQUEST['table_id'];

					$updateSQL = oci_parse(
						$objConnect,
						"UPDATE HR_PMS_EMP SET 
									SELF_SUBMITTED_STATUS=1,
									SELF_SUBMITTED_DATE=SYSDATE ,
									LINE_MANAGER_1_STATUS=null
									WHERE ID='$table_id'"
					);

					if (oci_execute($updateSQL)) {
						echo "<script>window.location = 'http://202.40.181.98:9090/rHR/pms_list_self.php'</script>";

						//echo "Request is submitted successfully.";
					}
				}

				?>


			</div>
		</div>

	</div>

</div>


<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>