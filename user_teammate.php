<?php
session_start();
session_regenerate_id(TRUE);


require_once('inc/config.php');
require_once('layouts/header.php');



require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
require_once('inc/connoracle.php');

$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];

?>
<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
	<!-- Bordered Table -->
	<div class="card">
		<h5 class="card-header"><b>Your Department or Teammate List</b></h5>
		<div class="card-body">
			<div class="table-responsive text-nowrap">
				<table class="table table-bordered text-center">
					<thead class="table-dark">
						<tr>
							<th>SL</th>
							<th>RML ID </th>
							<th>User Name</th>
							<th>MOBILE NO.</th>
							<th>Branch Name</th>
							<th>L.M. ID</th>
							<th>L.M NAME </th>
							<th>L.M. MOBILE</th>
						</tr>
					</thead>
					<tbody>

						<?php
							$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
							$allDataSQL = oci_parse(
								$objConnect,
								"SELECT RML_USER.RML_ID,
													RML_USER.EMP_NAME,
													RML_USER.LINE_MANAGER_RML_ID AS LM_ID,
													RML_USER.LINE_MANAGER_MOBILE AS LM_MOBILE,
													RML_USER.MOBILE_NO,
													BRANCH_NAME,
													(SELECT LMU.EMP_NAME FROM RML_HR_APPS_USER LMU WHERE LMU.RML_ID = RML_USER.LINE_MANAGER_RML_ID) AS LM_NAME
												FROM RML_HR_APPS_USER RML_USER WHERE 
												IS_ACTIVE = 1
												AND DEPT_NAME = (Select DEPT_NAME FROM RML_HR_APPS_USER WHERE RML_ID ='$emp_session_id')  "
											);

							oci_execute($allDataSQL);
							$number = 0;
							while ($row = oci_fetch_assoc($allDataSQL)) {
								$number++;
								?>


								<tr>
									<td>
										<strong><?php echo $number; ?>
										</strong>
									</td>
									<td><?php echo $row['RML_ID']; ?></td>
									<td><?php echo $row['EMP_NAME']; ?></td>
									<td><?php echo $row['MOBILE_NO']; ?></td>
									<td><?php echo $row['BRANCH_NAME']; ?></td>
									<td><?php echo $row['LM_ID']; ?></td>
									<td><?php echo $row['LM_NAME']; ?></td>
									<td><?php echo $row['LM_MOBILE']; ?></td>
								</tr>
								<?php
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