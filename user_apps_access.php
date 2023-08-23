<?php
session_start();
session_regenerate_id(TRUE);

// if ($_SESSION['HR']['hr_role'] != 1) {
// 	header('location:index.php?lmsg_hr=true');
// 	exit;
// }

// if (!isset($_SESSION['HR']['id_hr'], $_SESSION['HR']['hr_role'])) {
// 	header('location:index.php?lmsg_hr=true');
// 	exit;
// }

require_once('inc/config.php');
require_once('layouts/header.php');

// $v_page = 'user_apps_access';
// $v_active_open = 'active open';
// $v_active = 'active';


require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
require_once('inc/connoracle.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>
<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

	<div class="col-lg-12">
		<form action="" method="post">
			<div class="row">
				<div class="col-sm-9"></div>
				<div class="col-sm-3">
					<label for="title">RML-ID</label>
					<input type="text" class="form-control" id="title" placeholder="EMP-ID" name="emp_rml_id">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-9"></div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="title"> <br></label>
						<input class="form-control btn btn-primary" type="submit" value="Search Data">
					</div>
				</div>

			</div>
		</form>
	</div>
	</br>





	<!-- Bordered Table -->
	<div class="card">
		<h5 class="card-header"><b>Apps Access List</b></h5>
		<div class="card-body">
			<div class="table-responsive text-nowrap">
				<table class="table table-bordered">
					<thead class="table-dark">
						<tr>
							<th>SL</th>
							<th>User Name</th>
							<th>Access Apps Key</th>
							<th>Name Title</th>
							<th>Access To</th>
							<th>Status</th>
							<th>Remarks</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>

						<?php
						if (isset($_POST['emp_rml_id'])) {
							$v_emp_id = $_REQUEST['emp_rml_id'];
							$strSQL  = oci_parse($objConnect, "SELECT ID,
						   (Select EMP_NAME ||' ('|| RML_ID ||')' from RML_HR_APPS_USER where id=RML_HR_APPS_USER_ID) EMP_NAME,
						   APPS_NAME,
						   USE_ID,
						   STATUS,
						   NAME_TITLE,
						   REMARKS
					FROM HR_EMP_APPS_ACCESS
					where RML_HR_APPS_USER_ID=(Select ID from RML_HR_APPS_USER where RML_ID='$v_emp_id')");
							oci_execute($strSQL);
							$number = 0;
							while ($row = oci_fetch_assoc($strSQL)) {
								$number++;
						?>
								<tr>
									<td>
										<i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?>
										</strong>
									</td>
									<td><?php echo $row['EMP_NAME']; ?></td>

									<td><?php echo $row['APPS_NAME']; ?></td>
									<td><?php echo $row['NAME_TITLE']; ?></td>
									<td><?php echo $row['USE_ID']; ?></td>
									<td><?php echo $row['STATUS']; ?></td>
									<td><?php echo $row['REMARKS']; ?></td>
									<td>
										<div class="dropdown">
											<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
												<i class="bx bx-dots-vertical-rounded"></i>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="user_profile.php?emp_id=<?php echo $encrypted_rml_id; ?>">
													<i class="bx bx-edit-alt me-1"></i>
													Edit
												</a>

											</div>
										</div>
									</td>
								</tr>


							<?php
							}
						} else {


							$emp_session_id = $_SESSION['HR']['emp_id_hr'];
							$allDataSQL  = oci_parse(
								$objConnect,
								"SELECT ID,
						   (Select EMP_NAME ||' ('|| RML_ID ||')' from RML_HR_APPS_USER where id=RML_HR_APPS_USER_ID) EMP_NAME,
						   APPS_NAME,
						   USE_ID,
						   STATUS,
						   NAME_TITLE,
						   REMARKS
					FROM HR_EMP_APPS_ACCESS"
							);

							oci_execute($allDataSQL);
							$number = 0;
							while ($row = oci_fetch_assoc($allDataSQL)) {
								$number++;
							?>


								<tr>
									<td>
										<i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?>
										</strong>
									</td>
									<td><?php echo $row['EMP_NAME']; ?></td>

									<td><?php echo $row['APPS_NAME']; ?></td>
									<td><?php echo $row['NAME_TITLE']; ?></td>
									<td><?php echo $row['USE_ID']; ?></td>
									<td><?php echo $row['STATUS']; ?></td>
									<td><?php echo $row['REMARKS']; ?></td>
									<td>
										<div class="dropdown">
											<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
												<i class="bx bx-dots-vertical-rounded"></i>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="user_profile.php?emp_id=<?php echo $encrypted_rml_id; ?>">
													<i class="bx bx-edit-alt me-1"></i>
													Edit
												</a>

											</div>
										</div>
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

<?php require_once('layouts/footer_info.php'); ?>
<?php require_once('layouts/footer.php'); ?>