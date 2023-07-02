<?php
session_start();
session_regenerate_id(TRUE);

if ($_SESSION['HR']['hr_role'] != 5) {
	header('location:index.php?lmsg_hr=true');
	exit;
}


require_once('inc/config.php');
require_once('layouts/header.php');

$v_page = 'new_emp_create_rmwl';
$v_active_open = 'active open';
$v_active = 'active';


require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
require_once('inc/connoracle.php');



$emp_session_id = $_SESSION['HR']['emp_id_hr'];
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="">You will be respondible if you create any user. </a>
			</li>
		</ol>

		<div class="container-fluid">
			<form action="" method="post">
				<div class="row">

					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">

									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Write Emp ID:</label>
											<input type="text" class="form-control" id="title" name="form_rml_id" required="">
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Full Name:</label>
											<input type="text" class="form-control" id="title" name="emp_form_name" required="">
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Office Mobile No:</label>
											<input type="text" class="form-control" id="title" name="emp_mobile" required="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Mail:</label>
											<input type="text" class="form-control" id="title" name="emp_mail">
										</div>
									</div>

								</div>

								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Responsible-1 ID:</label>
											<input type="text" class="form-control" id="title" name="form_res1_id" required="">
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Responsible-1 Mobile:</label>
											<input type="text" class="form-control" id="title" name="form_res1_mobile" required="">
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Responsible-2 ID:</label>
											<input type="text" class="form-control" id="title" name="form_res2_id">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Responsible-2 Mobile:</label>
											<input type="text" class="form-control" id="title" name="form_res2_mobile">
										</div>
									</div>
								</div>

								<div class="row">


									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Designation:</label>
											<input type="text" class="form-control" id="title" name="emp_designation" required="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Department:</label>
											<input type="text" class="form-control" id="title" name="emp_dept" required="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Brance Name:</label>
											<input type="text" class="form-control" id="title" name="emp_branch" required="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Gender:</label>
											<select name="emp_gender" class="form-control" required="">
												<option selected value="">Select Gender</option>
												<option value="M">Male</option>
												<option value="F">Fe-Male</option>
											</select>
										</div>
									</div>

								</div>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Concern:</label>
											<select name="company_concern" class="form-control" required="">
												<option value="RMWL">RMWL</option>

											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Blood Group:</label>
											<select name="emp_blood" class="form-control">
												<option selected value="">Select Blood Group</option>
												<option value="A+">A+</option>
												<option value="A-">A-</option>
												<option value="AB+">AB+</option>
												<option value="B+">B+</option>
												<option value="B-">B-</option>
												<option value="O+">O+</option>
												<option value="O-">O-</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">User Type:</label>
											<select name="user_role" class="form-control" required="">
												<option selected value="">Select User Type</option>
												<option value="LM">Line Manager</option>
												<option value="NU">Normal User</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Joining Date:</label>
											<input required="" class="form-control" id="date" name="doj" type="date" />
										</div>
									</div>


								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="md-form mt-5">
											<button type="submit" name="submit" class="btn btn-info">Create & Save</button>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>



					<?php
					//   $emp_session_id=$_SESSION['emp_id'];
					$emp_session_id = $_SESSION['HR']['emp_id_hr'];
					@$form_rml_id = $_REQUEST['form_rml_id'];
					@$emp_form_name = $_REQUEST['emp_form_name'];
					@$emp_mobile = $_REQUEST['emp_mobile'];
					@$emp_mail = $_REQUEST['emp_mail'];

					@$form_res1_id = $_REQUEST['form_res1_id'];
					@$form_res1_mobile = $_REQUEST['form_res1_mobile'];
					@$form_res2_id = $_REQUEST['form_res2_id'];
					@$form_res2_mobile = $_REQUEST['form_res2_mobile'];

					@$emp_designation = $_REQUEST['emp_designation'];
					@$emp_dept = $_REQUEST['emp_dept'];
					@$emp_branch = $_REQUEST['emp_branch'];
					@$emp_gender = $_REQUEST['emp_gender'];

					@$company_concern = $_REQUEST['company_concern'];
					@$emp_blood = $_REQUEST['emp_blood'];
					@$user_role = $_REQUEST['user_role'];
					@$doj = date("d/m/Y", strtotime($_REQUEST['doj']));


					if (isset($_POST['form_rml_id']) && isset($_POST['emp_form_name']) && isset($_POST['user_role'])) {
						require_once('inc/connoracle.php');
						$strSQL  = oci_parse($objConnect, "INSERT INTO RML_HR_APPS_USER (
                                                                   RML_ID, 
                                                                   EMP_NAME,
																   MOBILE_NO,
                                                                   MAIL, 
                                                                   LINE_MANAGER_RML_ID,
                                                                   LINE_MANAGER_MOBILE, 
                                                                   DEPT_HEAD_RML_ID, 
                                                                   DEPT_HEAD_MOBILE_NO,	
																   DESIGNATION,	
                                                                   DEPT_NAME,
                                                                   BRANCH_NAME,
                                                                   GENDER,																   
                                                                   R_CONCERN, 
                                                                   BLOOD, 
                                                                   USER_ROLE, 
                                                                   DOJ,
																   IS_ACTIVE,
																   IS_ACTIVE_LAT_LANG, 
                                                                   ATTN_RANGE_M,
																   USER_CREATE_DATE,
																   USER_APPROVED_BY,
                                                                   LAT, 
                                                                   LANG,
																   PASS_MD5
                                                                   ) 
												VALUES (
												 '$form_rml_id',
												 '$emp_form_name',
												 '$emp_mobile',
												 '$emp_mail',
												 '$form_res1_id',
												 '$form_res1_mobile',
												 '$form_res2_id',
												 '$form_res2_mobile',
												 '$emp_designation',
												 '$emp_dept',
												 '$emp_branch',
												 '$emp_gender',
												 '$company_concern',
												 '$emp_blood',
												 '$user_role',
												 TO_DATE('$doj','dd/mm/yyyy'),
												 1,
												 1,
												 30,
												 SYSDATE,
												 '$emp_session_id',
												 0,
												 0,
                                                 '202CB962AC59075B964B07152D234B70')");

						if (oci_execute($strSQL)) {
					?>

							<div class="container-fluid">
								<div class="md-form mt-5">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											User is Created successfully.
										</li>
									</ol>
								</div>
							</div>
					<?php
						}
					}
					?>
				</div>
				</from>
		</div>
		<div style="height: 1000px;"></div>
	</div>
	<!-- /.container-fluid-->


	<?php require_once('layouts/footer.php'); ?>