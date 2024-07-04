<?php
session_start();
if (!isset($_SESSION['HR_APPS'])) {
	echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
require_once('./config_file_path.php');
require_once('inc/connoracle.php');
require_once('inc/config.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$emp_id = htmlentities($_GET['emp_id']);

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<title>Rangs Mobile Apps Admin Panel</title>

	<meta name="description" content="">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />

	<!-- Favicon -->
	<!-- <link rel="icon" type="image/x-icon" href="<?php echo $basePath ?>/assets/img/favicon/favicon.ico" > -->
	<link rel="icon" type="image/x-icon" href="<?php echo $basePath ?>/images/app_icon_hr.png">

	<!-- Fonts -->

	<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

	<!-- Icons. Uncomment required icon fonts -->
	<link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/fonts/boxicons.css">

	<!-- Core CSS -->
	<link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/css/core.css" class="template-customizer-core-css">
	<link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css">
	<link rel="stylesheet" href="<?php echo $basePath ?>/assets/css/demo.css">

	<!-- Vendors CSS -->
	<link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">

	<link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/libs/apex-charts/apex-charts.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css" integrity="sha512-y4S4cBeErz9ykN3iwUC4kmP/Ca+zd8n8FDzlVbq5Nr73gn1VBXZhpriQ7avR+8fQLpyq4izWm0b8s6q4Vedb9w==" crossorigin="anonymous" referrerpolicy="no-referrer">
	<!-- Page CSS -->

	<!-- Helpers -->
	<script src="<?php echo $basePath ?>/assets/vendor/js/helpers.js"></script>

	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="<?php echo $basePath ?>/assets/js/config.js"></script>
	<!-- // Echo the value of $dynamic_link_css to verify its content -->

	<?php
	// if (isset($dynamic_link_css) && count($dynamic_link_css) > 0) {
	// 	foreach ($dynamic_link_css as $key => $linkCss) {
	// 		echo "<link rel='stylesheet' type='text/css' href='$linkCss'>";
	// 	}
	// }
	?>


</head>

<body>
	<!-- Layout wrapper -->
	<div class="layout-wrapper layout-content-navbar">
		<div class="layout-container">
			<?php
			require_once('layouts/left_menu.php');
			require_once('layouts/top_menu.php');
			?>

			<!-- / Content -->

			<div class="container-xxl flex-grow-1 container-p-y">
				<div class="card card-body col-lg-12">
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<?php
					$strSQL = oci_parse(
						$objConnect,
						"SELECT RML_ID,
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
							TRACE_LOCATION,
							IS_ACTIVE
					 		FROM RML_HR_APPS_USER
						  where RML_ID='$emp_id'"
					);

					oci_execute($strSQL);
					while ($row = oci_fetch_assoc($strSQL)) {
					?>
						<div class="  ">
							<div class="md-form ">
								<h5 class="card-header text-center text-danger">You will be responsible. if you update anything here? </h5>
								<div class=" d-flex flex-column flex-md-row">
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
																<option value="1" <?php echo $row['IS_ACTIVE'] == 1 ? 'selected' : ''; ?>>Active</option>
																<option value="0" <?php echo $row['IS_ACTIVE'] == 0 ? 'selected' : ''; ?>>In-Active</option>
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
												<?php if (getUserWiseRoleName('super-admin') || getUserWiseRoleName('hr')) { ?>
													<div class="row">
														<div class="col-lg-12">
															<div class="d-block text-center mt-1">
																<button type="submit" name="submit" class="btn btn-sm btn-info" form="Form2">Submit Update</button>
															</div>
														</div>
													</div>
												<?php } ?>
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

						$strSQL = oci_parse($objConnect, "UPDATE RML_HR_APPS_USER SET
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