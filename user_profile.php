<?php

session_start();
session_regenerate_id(TRUE);

if ($_SESSION['HR']['hr_role'] != 1 && $_SESSION['HR']['hr_role'] != 2 && $_SESSION['HR']['hr_role'] != 3 && $_SESSION['HR']['hr_role'] != 4) {
	header('location:index.php?lmsg_hr=true');
	exit;
}

if (!isset($_SESSION['HR']['id_hr'], $_SESSION['HR']['hr_role'])) {
	header('location:index.php?lmsg_hr=true');
	exit;
}
require_once('inc/config.php');
require_once('layouts/header.php');

$v_page = '';
$v_active_open = 'active open';
$v_active = 'active';


require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
require_once('inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];



$emp_id = htmlentities($_REQUEST['emp_id']);


?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
	<div class="card card-body col-lg-12">
		<form id="Form1" action="" method="post"></form>
		<form id="Form2" action="" method="post"></form>
		<?php
		$strSQL  = oci_parse(
			$objConnect,
			"select RML_ID,
							EMP_NAME,
							MOBILE_NO,
							DEPT_NAME,
							IEMI_NO,
							LINE_MANAGER_RML_ID,
							LINE_MANAGER_MOBILE,
							DEPT_HEAD_RML_ID,
							DEPT_HEAD_MOBILE_NO,
							BRANCH_NAME,
							DESIGNATION,
							BLOOD,
							MAIL,
							DOJ,
							DOC,
							GENDER,
							R_CONCERN,
							ATTN_RANGE_M,
							USER_CREATE_DATE,
							USER_ROLE,
							LAT,
							LANG,
							TRACE_LOCATION
					 from RML_HR_APPS_USER 
						  where RML_ID='$emp_id'"
		);

		oci_execute($strSQL);


		while ($row = oci_fetch_assoc($strSQL)) {
		?>
			<div class="  ">
				<div class="md-form ">
					<!-- <ol class="breadcrumb">
						<li class="breadcrumb-item">
							
						</li>
					</ol> -->
					<h5 class="card-header text-center text-danger">You will be responsible. if you update anything here? </h5>
					<div class="resume-item d-flex flex-column flex-md-row">


						<div class="container">

							<div class="row">
								<div class="col-lg-12">
									<div class="row">

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Emp ID:</label>
												<input type="text" class="form-control cust-control" id="title" form="Form2" name="form_rml_id" value="<?php echo $row['RML_ID']; ?>" readonly>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Name:</label>
												<input type="text" name="emp_form_name" class="form-control cust-control" id="title" value="<?php echo $row['EMP_NAME']; ?>" form="Form2">
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Mobile:</label>
												<input type="text" name="emp_mobile" class="form-control cust-control" id="title" value="<?php echo $row['MOBILE_NO']; ?>" form="Form2">
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Department:</label>
												<input type="text" name="emp_dept" class="form-control cust-control" id="title" value="<?php echo $row['DEPT_NAME']; ?>" form="Form2">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Responsible-1 ID:</label>
												<input type="text" class="form-control cust-control" id="title" name="form_res1_id" value="<?php echo $row['LINE_MANAGER_RML_ID']; ?>" form="Form2">
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Responsible-1 Mobile:</label>
												<input type="text" class="form-control cust-control" id="title" name="form_res1_mobile" value="<?php echo $row['LINE_MANAGER_MOBILE']; ?>" form="Form2">
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Responsible-2 ID:</label>
												<input type="text" class="form-control cust-control" id="title" name="form_res2_id" value="<?php echo $row['DEPT_HEAD_RML_ID']; ?>" form="Form2">
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Responsible-2 Mobile:</label>
												<input type="text" class="form-control cust-control" id="title" name="form_res2_mobile" value="<?php echo $row['DEPT_HEAD_MOBILE_NO']; ?>" form="Form2">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">IEMI_NO:</label>
												<input type="text" class="form-control cust-control" id="title" name="form_iemi_no" value="<?php echo $row['IEMI_NO']; ?>" form="Form2">
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Designation:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['DESIGNATION']; ?>" readonly>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Mail:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['MAIL']; ?>" readonly>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">DOJ:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['DOJ']; ?>" readonly>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">DOC:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['DOC']; ?>" readonly>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Brance Name:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['BRANCH_NAME']; ?>" readonly>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Gendar:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php
																											if ($row['GENDER'] === 'M') {
																												echo 'Male';
																											} else if ($row['GENDER'] === 'F') {
																												echo 'Female';
																											}
																											?>" readonly>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Joning Date:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['DOJ']; ?>" readonly>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Blood:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['BLOOD']; ?>" readonly>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Emp Concern:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['R_CONCERN']; ?>" readonly>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Apps Attn Range(Meter):</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['ATTN_RANGE_M'] ?>" readonly>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">User Created Date:</label>
												<input type="text" class="form-control cust-control" id="title" value="<?php echo $row['USER_CREATE_DATE']; ?>" readonly>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Employee Status:</label>
												<select name="emp_status" class="form-control cust-control" form="Form2">
													<option value="1">Active</option>
													<option value="0">In-Active</option>
												</select>

											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">User Role:</label>
												<select required="" name="emp_role" class="form-control cust-control" form="Form2">
													<?php

													if ($row['USER_ROLE'] == 'NU') {
													?>
														<option value="NU">Normal User</option>
														<option value="LM">Line Manager</option>

													<?php
													} else {
													?>
														<option value="LM">Line Manager</option>
														<option value="NU">Normal User</option>
													<?php
													}

													?>
												</select>

											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Lat:</label>
												<input type="text" class="form-control cust-control" name="lat" id="title" value="<?php echo $row['LAT']; ?>" form="Form2">
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Lang:</label>
												<input type="text" class="form-control cust-control" name="lang" id="title" value="<?php echo $row['LANG']; ?>" form="Form2">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="title">Location Traceable Status:</label>
												<select required="" name="traceable_status" class="form-control cust-control" form="Form2">
													<?php

													if ($row['TRACE_LOCATION'] == '1') {
													?>
														<option value="1">Active</option>
														<option value="0">In-Active</option>

													<?php
													} else {
													?>
														<option value="0">In-Active</option>
														<option value="1">Active</option>

													<?php
													}

													?>
												</select>

											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="d-block text-center mt-1">
												<button type="submit" name="submit" class="btn btn-sm btn-info" form="Form2">Submit Update</button>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>

					</div>

				</div>

			</div>
		<?php
		}
		?>




		<?php

		@$form_rml_id = $_REQUEST['form_rml_id'];
		@$emp_form_name = $_REQUEST['emp_form_name'];
		@$emp_mobile = $_REQUEST['emp_mobile'];
		@$emp_dept = $_REQUEST['emp_dept'];


		@$form_iemi_no = $_REQUEST['form_iemi_no'];
		@$form_res1_id = $_REQUEST['form_res1_id'];
		@$form_res1_mobile = $_REQUEST['form_res1_mobile'];
		@$form_res2_id = $_REQUEST['form_res2_id'];
		@$form_res2_mobile = $_REQUEST['form_res2_mobile'];

		@$emp_role = $_REQUEST['emp_role'];
		@$form_emp_status = $_REQUEST['emp_status'];
		@$form_emp_lat = $_REQUEST['lat'];
		@$form_emp_lang = $_REQUEST['lang'];

		@$traceable_status = $_REQUEST['traceable_status'];

		if (isset($_POST['form_iemi_no'])) {

			$strSQL  = oci_parse($objConnect, "update RML_HR_APPS_USER SET
							            EMP_NAME='$emp_form_name',
                                        MOBILE_NO='$emp_mobile',
										DEPT_NAME='$emp_dept',									
										IEMI_NO='$form_iemi_no',
										LINE_MANAGER_RML_ID='$form_res1_id',
										LINE_MANAGER_MOBILE='$form_res1_mobile',
										DEPT_HEAD_RML_ID='$form_res2_id',
										DEPT_HEAD_MOBILE_NO='$form_res2_mobile',
										IS_ACTIVE='$form_emp_status',
										USER_ROLE='$emp_role',
										LAT='$form_emp_lat',
										LANG='$form_emp_lang',
										TRACE_LOCATION='$traceable_status'
								where RML_ID='$form_rml_id'");

			if (oci_execute($strSQL)) {
		?>

				<div class="container-fluid">
					<div class="md-form mt-5">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								Information is updated successfully.
							</li>
						</ol>
					</div>
				</div>
		<?php
			}
		}
		?>
	</div>
</div>


</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>
<?php require_once('layouts/footer.php'); ?>