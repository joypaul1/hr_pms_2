<?php
require_once ('../../../helper/3step_com_conn.php');
require_once ('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('lm-tour-approval')) {
	echo "<script>
		window.location.href = '$basePath/index.php?logout=true';
	</script>";
}
$emp_session_id  = $_SESSION['HR_APPS']['emp_id_hr'];
$v_view_approval = 0;
if (isset($_POST['submit_approval_single'])) {

	if (!empty($_POST['check_list'])) {
		foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
			$query = "UPDATE RML_HR_EMP_TOUR SET LINE_MANAGER_APPROVAL_STATUS=1, APPROVAL_DATE=SYSDATE where ID='$TT_ID_SELECTTED'";

			$strSQL = oci_parse(
				$objConnect,
				$query
			);

			if (oci_execute($strSQL)) {
				$message                  = [
					'text'   => 'Successfully Approved Tour. ' . $TT_ID_SELECTTED,
					'status' => 'true',
				];
				$_SESSION['noti_message'] = $message;
			}
		}
		echo "<script>window.location = " . $basePath . "'/leave_module/view/lm_panel/approval.php'</script>";
	}
	else {
		$message                  = [
			'text'   => "Sorry! You have not select any ID Code.",
			'status' => 'false',
		];
		$_SESSION['noti_message'] = $message;
	}
}





if (isset($_POST['submit_approval'])) {

	if (!empty($_POST['check_list'])) {
		// Loop to store and display values of individual checked checkbox.
		foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
			$strSQL = oci_parse(
				$objConnect,
				"UPDATE RML_HR_EMP_TOUR 
							set LINE_MANAGER_APPROVAL_STATUS=1,
							APPROVAL_DATE=SYSDATE
							 where ID='$TT_ID_SELECTTED'"
			);

			oci_execute($strSQL);


			if (oci_execute($strSQL)) {
				$message                  = [
					'text'   => 'Successfully Approved Tour. ' . $TT_ID_SELECTTED,
					'status' => 'true',
				];
				$_SESSION['noti_message'] = $message;
			}
		}
		echo "<script>window.location = " . $basePath . "'/leave_module/view/lm_panel/approval.php'</script>";
	}
	else {
		$message                  = [
			'text'   => "Sorry! You have not select any ID Code.",
			'status' => 'false',
		];
		$_SESSION['noti_message'] = $message;
	}
}

// Denied option
if (isset($_POST['submit_denied'])) {

	if (!empty($_POST['check_list'])) {
		// Loop to store and display values of individual checked checkbox.
		foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
			$strSQL = oci_parse(
				$objConnect,
				"UPDATE RML_HR_EMP_TOUR 
				set LINE_MANAGER_APPROVAL_STATUS=0,
				APPROVAL_DATE=sysdate
				 where ID='$TT_ID_SELECTTED'"
			);

			if (oci_execute($strSQL)) {
				$message                  = [
					'text'   => 'Successfully Denied Tour. ' . $TT_ID_SELECTTED,
					'status' => 'true',
				];
				$_SESSION['noti_message'] = $message;
			}
		}
		echo "<script>window.location = " . $basePath . "'/leave_module/view/lm_panel/approval.php'</script>";
	}
	else {
		$message                  = [
			'text'   => "Sorry! You have not select any ID Code.",
			'status' => 'false',
		];
		$_SESSION['noti_message'] = $message;
	}
}

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


						$strSQL = oci_parse($objConnect, "SELECT RML_ID,EMP_NAME from RML_HR_APPS_USER 
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
						<input required="" class="form-control cust-control" form="Form1" name="start_date" type="date">
					</div>
				</div>
				<div class="col-sm-3">
					<label>To Date:</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar">
							</i>
						</div>
						<input required="" class="form-control cust-control" form="Form1" id="date" name="end_date" type="date">
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
		<h5 class="card-header"><b>Line Manager Tour Approval List</b></h5>
		<div class="card-body">
			<div class="col-lg-12">
				<form id="Form2" action="" method="post">
					<div class="md-form">
						<div class=" d-flex flex-column flex-md-row">
							<table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
								<thead class="table-dark text-center">
									<tr class="text-center">
										<th scope="col">Sl</th>
										<th scope="col">Emp Info</th>
										<th scope="col">Entry Info</th>
									</tr>
								</thead>



								<?php


								if (isset($_POST['start_date'])) {
									$emp_concern     = $_REQUEST['emp_concern'];
									$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
									$attn_end_date   = date("d/m/Y", strtotime($_REQUEST['end_date']));





									$strSQL = oci_parse($objConnect, "SELECT a.ID,b.EMP_NAME,a.RML_ID,a.ENTRY_DATE,a.START_DATE,a.END_DATE,a.REMARKS,a.ENTRY_BY,b.DEPT_NAME,b.BRANCH_NAME,b.DESIGNATION
														from RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
														where a.RML_ID=b.RML_ID
														and b.LINE_MANAGER_RML_ID='$emp_session_id'
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
												<td><input type="checkbox" name="check_list[]" form="Form2" value="<?php echo $row['ID']; ?>">
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
													$v_leave_day = abs(round(strtotime($row['END_DATE']) - strtotime($row['START_DATE'])) / 86400) + 1;
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
													<input class="btn btn-primary btn pull-right" form="Form2" type="submit" name="submit_approval"
														value="Approve">
												</td>

												<td><input class="btn btn-primary btn pull-right" type="submit" form="Form2" name="submit_denied"
														value="Denied"></td>
											</tr>

											<?php
									}
								}
								else {
									$allDataSQL = oci_parse($objConnect, "SELECT a.ID,b.EMP_NAME,a.RML_ID,a.ENTRY_DATE,a.START_DATE,a.END_DATE,
																	a.REMARKS,
																	a.ENTRY_BY,
																	b.DEPT_NAME,
																	b.BRANCH_NAME,
																	b.DESIGNATION
														from RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
														where a.RML_ID=b.RML_ID
														and b.LINE_MANAGER_RML_ID='$emp_session_id'
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
												<td><input type="checkbox" name="check_list[]" form="Form2" value="<?php echo $row['ID']; ?>">
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
													<input class="btn btn-primary btn pull-right" type="submit" form="Form2" name="submit_approval_single"
														value="Approve">
												</td>
												<td>
													<?php echo $row['START_DATE'] . '-to-' . $row['END_DATE'];
													echo ',<br>';
													$v_leave_day = abs(round(strtotime($row['END_DATE']) - strtotime($row['START_DATE'])) / 86400) + 1;
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
													<input class="btn btn-primary btn pull-right" type="submit" form="Form2" name="submit_approval"
														value="Approve">
												</td>
												<td>
													<input class="btn btn-primary btn pull-right" type="submit" form="Form2" name="submit_denied"
														value="Denied">
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



			?>
		</div>
	</div>

</div>

<!-- / Content -->


<?php require_once ('../../../layouts/footer_info.php'); ?>
<?php require_once ('../../../layouts/footer.php'); ?>