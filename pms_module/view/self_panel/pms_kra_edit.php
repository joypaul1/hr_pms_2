<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
// if (!checkPermission('concern-offboarding-create')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$editId = $_REQUEST['id'];

$strSQL  = oci_parse($objConnect, "select KRA_NAME FROM HR_PMS_KRA_LIST WHERE ID=$editId");
oci_execute($strSQL);
$row = oci_fetch_assoc($strSQL)
?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
	<div class="">

		<div class="card">
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between" style="padding: 1.0% 1rem">
					<div href="#" style="font-size: 20px;font-weight:700">
						<i class="menu-icon tf-icons bx bx-edit" style="margin:0;font-size:30px"></i> KRA Edit
					</div>
					<a href="<?php echo $basePath ?>/pms_module/view/hr_panel/year_create.php" class="btn btn-sm btn-info">
						<i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;"></i>KRA List</a>
				</div>
			</div>
			<div class="card-body">
				<div class="">
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<!--<form action="" method="post">  -->
					<div class="row">
						<div class="col-sm-8">
							<label for="exampleInputEmail1">KRA Name:</label>
							<input required="" value="<?php echo $row['KRA_NAME']; ?>" style="padding:5px !important" form="Form1" name="kra_name" placeholder="Enter KRA Name" class="form-control cust-control" type='text' />
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



	</div>
</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>