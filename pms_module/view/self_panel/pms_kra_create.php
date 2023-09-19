<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');


$basePath =  $_SESSION['basePath'];
// if (!checkPermission('concern-offboarding-create')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
	<div class="">

		<div class="card">
			<div class="card-body">
				<div class="">
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<!--<form action="" method="post">  -->
					<div class="row">
						<div class="col-sm-8">
							<label for="exampleInputEmail1">KRA Name:</label>
							<input required="" style="padding:5px !important" form="Form1" name="kra_name" placeholder="Enter KRA Name" class="form-control cust-control" type='text' />
						</div>
						<div class="col-sm-4">
							<label for="exampleInputEmail1">Select PMS Title:</label>
							<select required="" name="pms_title_id" class="form-control cust-control" form="Form1">
								<option selected value="">--</option>
								<?php

								$strSQL  = oci_parse($objConnect, "select ID,PMS_NAME from HR_PMS_LIST where is_active=1");
								oci_execute($strSQL);
								while ($row = oci_fetch_assoc($strSQL)) {
								?>

									<option value="<?php echo $row['ID']; ?>"><?php echo $row['PMS_NAME']; ?></option>
								<?php
								}
								?>
							</select>
						</div>


					</div>

					<div class="row">
						<div class="col-sm-8"></div>
						<div class="col-sm-4">
							<div class="md-form mt-3">
								<input class="form-control  btn  btn-sm  btn-primary" form="Form1" type="submit" value="Submit to Create">
							</div>
						</div>
					</div>
					</form>

				</div>



				<?php


				if (isset($_POST['kra_name'])) {

					$self_submitted_status = 0;

					$v_kra_name = $_REQUEST['kra_name'];
					$v_pms_title_id = $_REQUEST['pms_title_id'];
					$strStatus  = oci_parse(
						$objConnect,
						"SELECT SELF_SUBMITTED_STATUS FROM HR_PMS_EMP 
								       WHERE EMP_ID='$emp_session_id'
								       AND HR_PMS_LIST_ID='$v_pms_title_id'"
					);

					if (oci_execute($strStatus)) {
						while ($row = oci_fetch_assoc($strStatus)) {
							$self_submitted_status = $row['SELF_SUBMITTED_STATUS'];
						}
					}

					if ($self_submitted_status == 0) {
						$strSQL  = oci_parse(
							$objConnect,
							"INSERT INTO HR_PMS_KRA_LIST (
                                             KRA_NAME,
											 HR_PMS_LIST_ID,											 
											 CREATED_BY, 
                                             CREATED_DATE, 
											 IS_ACTIVE) 
                                        VALUES ( 
                                             '$v_kra_name',
											 '$v_pms_title_id',
											 '$emp_session_id',
											 sysdate,
											 1)"
						);
						if (@oci_execute($strSQL)) {

							echo '<div class="alert alert-primary">';
							echo "KRA is created successfully.";
							echo '</div>';
						} else {
							$lastError = error_get_last();
							$error = $lastError ? "" . $lastError["message"] . "" : "";
							if (strpos($error, 'HR_KRA_LIST_UNIQUE') !== false) {
								echo '<div class="alert alert-danger">';
								echo $error;
								echo '</div>';
							}
						}
					} else {
						echo '<div class="alert alert-danger">';
						echo "You can not create new KRA  cause of this PMS data are already submitted.";
						echo '</div>';
					}
				}
				?>

			</div>
		</div>

		<div class="card mt-2">
			<div class="row card-body ">


				<div class="col-lg-12">
					<div class="md-form mt-2">
						<div class="resume-item d-flex flex-column flex-md-row">
							<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
								<thead style="background: beige;">
									<tr class="text-center">
										<th class="text-center">Sl</th>
										<th class="text-center">Key Result Areas</th>
										<th class="text-center">PMS Title</th>
										<th class="text-center">Updated Date</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>

								<tbody>

									<?php
									$strSQL  = oci_parse(
										$objConnect,
										"select BB.ID,
											BB.KRA_NAME,
											(select  PMS_NAME  FROM HR_PMS_LIST where id=BB.HR_PMS_LIST_ID) PMS_NAME,
											(SELECT A.SELF_SUBMITTED_STATUS FROM HR_PMS_EMP A 
													WHERE A.HR_PMS_LIST_ID=BB.HR_PMS_LIST_ID 
													AND A.EMP_ID='$emp_session_id'
											)SUBMITTED_STATUS,
											CREATED_BY,
											CREATED_DATE,UPDATED_DATE,
											IS_ACTIVE 
										FROM HR_PMS_KRA_LIST BB
										WHERE BB.CREATED_BY='$emp_session_id'"
									);

									oci_execute($strSQL);
									$number = 0;


									while ($row = oci_fetch_assoc($strSQL)) {
										$number++;
									?>
										<tr>
											<td class="text-center"><?php echo $number; ?></td>
											<td><?php echo $row['KRA_NAME']; ?></td>
											<td><?php echo $row['PMS_NAME']; ?></td>
											<td><?php echo $row['UPDATED_DATE']; ?></td>
											<td>
												<?php
												if ($row['IS_ACTIVE'] == '1')
													echo 'Active';
												else
													echo 'In-Active';
												?>
											</td>
											<td>
												<?php
												if ($row['SUBMITTED_STATUS'] != '1') {
												?>
													<input form="Form2" name="table_id" class="form-control" type='text' value='<?php echo $row['ID']; ?>' style="display:none" />
													<a class="btn btn-warning btn-sm" href="pms_kra_list_update.php?key=<?php echo $row['ID']; ?>">Update</a>
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
						$kra_name = $_REQUEST['kra_name'];

						$updateSQL  = oci_parse(
							$objConnect,
							"UPDATE HR_PMS_KRA_LIST SET KRA_NAME='$kra_name',UPDATED_DATE=SYSDATE WHERE ID='$table_id'"
						);

						if (oci_execute($updateSQL)) {
							echo "<script>window.location = 'http://202.40.181.98:9090/rHR/pms_kra_create.php'</script>";
						}
					}

					?>




				</div>
			</div>
		</div>

	</div>

</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>