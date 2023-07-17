<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
if (!checkPermission('lm-tour-approval')) {
	echo "<script>
		window.location.href = '$basePath/index.php?logout=true';
	</script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$v_view_approval = 0;
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
	<div class="card mb-3">
		<div class=" card-body">
			<form id="Form1" action="" method="post"></form>
			<form id="Form2" action="" method="post"></form>
			<form id="Form3" action="" method="post"></form>
			<div class="row justify-content-center align-items-center">
				<div class="col-sm-3">
					<label>Select Your Concern:</label>
					<select name="emp_concern" class="form-control cust-control" form="Form1">
						<option selected value="">---</option>
						<?php


						$strSQL  = oci_parse($objConnect, "select RML_ID,EMP_NAME from RML_HR_APPS_USER 
																		where LINE_MANAGER_RML_ID ='$emp_session_id'
																		and is_active=1 
																		order by EMP_NAME");
						oci_execute($strSQL);
						while ($row = oci_fetch_assoc($strSQL)) {
						?>

							<option value="<?php echo $row['RML_ID']; ?>"><?php echo $row['EMP_NAME']; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="col-sm-3">
					<label>From Date:</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar">
							</i>
						</div>
						<input required="" class="form-control cust-control" form="Form1" name="start_date" type="date" />
					</div>
				</div>
				<div class="col-sm-3">
					<label>To Date:</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar">
							</i>
						</div>
						<input required="" class="form-control cust-control" form="Form1" id="date" name="end_date" type="date" />
					</div>
				</div>
				<div class="col-sm-2">
					<label class="form-label" for="basic-default-fullname">&nbsp;</label>
					<input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data" form="Form1">
				</div>
			</div>



		</div>
	</div>
	<div class="rows card">
		<h5 class="card-header"><b>Concern Tour Approval List</b></h5>
		<div class="card-body">
			<div class="col-lg-12">
				<form id="Form1" action="" method="post">
					<div class="md-form">
						<div class="resume-item d-flex flex-column flex-md-row">
							<table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
								<thead class="table-dark text-center">
									<tr class="text-center">
										<th scope="col">Sl</th>
										<th scope="col">Emp Info</th>
										<th scope="col">Entry Info</th>
									</tr>
								</thead>



								<?php
								@$emp_concern = $_REQUEST['emp_concern'];
								@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
								@$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

								if (isset($_POST['start_date'])) {

									$strSQL  = oci_parse($objConnect, "select a.ID,b.EMP_NAME,a.RML_ID,a.ENTRY_DATE,a.START_DATE,a.END_DATE,a.REMARKS,a.ENTRY_BY,b.DEPT_NAME,b.BRANCH_NAME,b.DESIGNATION
														from RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
														where a.RML_ID=b.RML_ID
														and a.LINE_MANAGER_ID='$emp_session_id'
														 and ('$emp_concern' is null OR A.RML_ID='$emp_concern')
														 and (trunc(START_DATE) BETWEEN TO_DATE('$attn_start_date','dd/mm/yyyy') AND TO_DATE('$attn_end_date','dd/mm/yyyy') OR
                                                              trunc(END_DATE) BETWEEN TO_DATE('$attn_start_date','dd/mm/yyyy') AND TO_DATE('$attn_end_date','dd/mm/yyyy'))
														and a.LINE_MANAGER_APPROVAL_STATUS IS NULL
														order by START_DATE desc");

									oci_execute($strSQL);
									$number = 0;

									while ($row = oci_fetch_assoc($strSQL)) {
										$number++;
										$v_view_approval = 1;
								?>
										<tbody>
											<tr>
												<td><input type="checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>">
													<?php echo $number; ?>
												</td>
												<td>
													<?php echo $row['EMP_NAME'];
													echo ',<br>';
													echo $row['RML_ID'];
													echo ',<br>';
													echo $row['DEPT_NAME'];
													echo ',<br>';
													echo $row['DESIGNATION'];
													echo ',<br>';
													echo $row['BRANCH_NAME']; ?>
												</td>
												<td>
													<?php echo $row['START_DATE'] . '-to-' . $row['END_DATE'];
													echo ',<br>';
													$v_leave_day = abs($row['END_DATE'] - $row['START_DATE']) + 1;
													echo $v_leave_day;
													if ($v_leave_day > 1)
														echo '-Days';
													else
														echo '-Day';
													echo ',<br>';
													echo 'Remarks:-' . $row['REMARKS'];
													?>
												</td>
											</tr>
										<?php
									}
									if ($v_view_approval > 0) {
										?>
											<tr>
												<td></td>
												<td>
													<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve" />
												</td>

												<td><input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Denied" /></td>
											</tr>

										<?php
									}
								} else {

									$allDataSQL  = oci_parse($objConnect, "select a.ID,b.EMP_NAME,a.RML_ID,a.ENTRY_DATE,a.START_DATE,a.END_DATE,
																	a.REMARKS,
																	a.ENTRY_BY,
																	b.DEPT_NAME,
																	b.BRANCH_NAME,
																	b.DESIGNATION
														from RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
														where a.RML_ID=b.RML_ID
														and a.LINE_MANAGER_ID='$emp_session_id'
														and trunc (a.START_DATE)>TO_DATE('31/12/2022','DD/MM/YYYY')
														and a.LINE_MANAGER_APPROVAL_STATUS IS NULL
														order by START_DATE desc");

									@oci_execute($allDataSQL);
									$number = 0;

									while ($row = oci_fetch_assoc($allDataSQL)) {
										$number++;
										$v_view_approval = 1;
										?>
											<tr>
												<td><input type="checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>">
													<?php echo $number; ?>
												</td>
												<td>
													<?php echo $row['EMP_NAME'];
													echo ',<br>';
													echo $row['RML_ID'];
													echo ',<br>';
													echo $row['DEPT_NAME'];
													echo ',<br>';
													echo $row['DESIGNATION'];
													echo ',<br>';
													echo $row['BRANCH_NAME']; ?>
													<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval_single" value="Approve" />
												</td>
												<td>
													<?php echo $row['START_DATE'] . '-to-' . $row['END_DATE'];
													echo ',<br>';
													$v_leave_day = abs($row['END_DATE'] - $row['START_DATE']) + 1;
													echo $v_leave_day;
													if ($v_leave_day > 1)
														echo '-Days';
													else
														echo '-Day';
													echo ',<br>';
													echo 'Remarks:-' . $row['REMARKS'];
													?>
												</td>


											</tr>
										<?php
									}
									if ($v_view_approval > 0) {
										?>
											<tr>
												<td></td>
												<td>
													<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve" />
												</td>
												<td>
													<input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Denied" />
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
			</form>
			<?php

			if (isset($_POST['submit_approval_single'])) {
				if (!empty($_POST['check_list'])) {
					foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
						$strSQL = oci_parse(
							$objConnect,
							"update RML_HR_EMP_LEAVE 
										set LINE_MNGR_APVL_STS=1,
										LINE_MNGR_APVL_DATE=sysdate,
										LINE_MNGR_APVL_BY='$emp_session_id',
										IS_APPROVED=1
                                         where ID='$TT_ID_SELECTTED'"
						);

						oci_execute($strSQL);
						$attnProcSQL  = oci_parse($objConnect, "declare V_START_DATE VARCHAR2(100);
						                                                 V_END_DATE VARCHAR2(100);
																		 V_RML_ID VARCHAR2(100);
									  begin SELECT TO_CHAR(START_DATE,'dd/mm/yyyy'),TO_CHAR(END_DATE,'dd/mm/yyyy'),RML_ID  INTO V_START_DATE,V_END_DATE,V_RML_ID  FROM RML_HR_EMP_LEAVE WHERE ID=$TT_ID_SELECTTED; RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_START_DATE,'dd/mm/yyyy'),TO_DATE(V_END_DATE,'dd/mm/yyyy'));end;");

						if (oci_execute($attnProcSQL)) {
							//$errorMsg = "Your Selected Leave Successfully Approved";
							echo '<div class="alert alert-primary">';
							echo 'Successfully Approved Outdoor Attendance ID ' . $TT_ID_SELECTTED;
							echo '<br>';
							echo '</div>';
						}
					}
					echo "<script>window.location = 'http://202.40.181.98:9090/rHR/lm_leave_approval.php'</script>";
				} else {
					//$errorMsg = "Sorry! You have not select any ID Code.";

					echo '<div class="alert alert-danger">';
					echo 'Sorry! You have not select any ID Code.';
					echo '</div>';
				}
			}





			if (isset($_POST['submit_approval'])) { //to run PHP script on submit
				if (!empty($_POST['check_list'])) {
					// Loop to store and display values of individual checked checkbox.
					foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
						$strSQL = oci_parse(
							$objConnect,
							"update RML_HR_EMP_LEAVE 
										set LINE_MNGR_APVL_STS=1,
										LINE_MNGR_APVL_DATE=sysdate,
										LINE_MNGR_APVL_BY='$emp_session_id',
										IS_APPROVED=1
                                         where ID='$TT_ID_SELECTTED'"
						);

						oci_execute($strSQL);
						$attnProcSQL  = oci_parse($objConnect, "declare V_START_DATE VARCHAR2(100); V_END_DATE VARCHAR2(100); V_RML_ID VARCHAR2(100);begin  SELECT TO_CHAR(START_DATE,'dd/mm/yyyy'),TO_CHAR(END_DATE,'dd/mm/yyyy'),RML_ID INTO V_START_DATE,V_END_DATE,V_RML_ID  FROM RML_HR_EMP_LEAVE WHERE ID=$TT_ID_SELECTTED; RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_START_DATE,'dd/mm/yyyy'),TO_DATE(V_END_DATE,'dd/mm/yyyy'));end;");

						if (oci_execute($attnProcSQL)) {
							//$errorMsg = "Your Selected Leave Successfully Approved";
							echo '<div class="alert alert-primary">';
							echo 'Successfully Approved Outdoor Attendance ID ' . $TT_ID_SELECTTED;
							echo '<br>';
							echo '</div>';
						}
					}
					echo "<script>window.location = 'http://202.40.181.98:9090/rHR/lm_leave_approval.php'</script>";
				} else {
					//$errorMsg = "Sorry! You have not select any ID Code.";

					echo '<div class="alert alert-danger">';
					echo 'Sorry! You have not select any ID Code.';
					echo '</div>';
				}
			}

			// Denied option
			if (isset($_POST['submit_denied'])) { //to run PHP script on submit
				if (!empty($_POST['check_list'])) {
					// Loop to store and display values of individual checked checkbox.
					foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
						$strSQL = oci_parse(
							$objConnect,
							"update RML_HR_EMP_LEAVE 
										set LINE_MNGR_APVL_STS=0,
										LINE_MNGR_APVL_DATE=sysdate,
										LINE_MNGR_APVL_BY='$emp_session_id',
										IS_APPROVED=0
                                         where ID='$TT_ID_SELECTTED'"
						);

						oci_execute($strSQL);

						echo 'Successfully Denied Outdoor Attendance ID ' . $TT_ID_SELECTTED . "</br>";
					}
					echo "<script>window.location = 'http://202.40.181.98:9090/rHR/lm_leave_approval.php'</script>";
				} else {
					echo '<div class="alert alert-danger">';
					echo 'Sorry! You have not select any ID Code.';
					echo '</div>';
				}
			}


			?>
		</div>
	</div>

</div>

<!-- / Content -->


<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>