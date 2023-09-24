<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
// if (!checkPermission('concern-offboarding-create')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$editId = $_REQUEST['id'];

$strSQL  = oci_parse($objConnect, "SELECT KRA_NAME FROM HR_PMS_KRA_LIST WHERE ID=$editId");
oci_execute($strSQL);
$row = oci_fetch_assoc($strSQL);


if (isset($_POST['kra_name'])) {

	$v_kra_name = $_REQUEST['kra_name'];
	$query = "UPDATE  HR_PMS_KRA_LIST SET KRA_NAME = '$v_kra_name' WHERE ID='$editId'";
	$strSQL  = oci_parse($objConnect, $query);

	if (oci_execute($strSQL)) {
		$message = [
			'text'   => 'KRA is Edited successfully.',
			'status' => 'true',
		];

		$_SESSION['noti_message'] = $message;
		echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kra_edit.php?id=$editId'</script>";
	} else {

		$e = oci_error($strSQL);
		$message = [
			'text'   => htmlentities($e['message'], ENT_QUOTES),
			'status' => 'false',
		];
		$_SESSION['noti_message'] = $message;
		echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_kra_edit.php?id=$editId'</script>";
	}
}
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
					<a href="<?php echo $basePath ?>/pms_module/view/self_panel/pms_kra_create.php" class="btn btn-sm btn-info">
						<i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;"></i>KRA List</a>
				</div>
			</div>
			<div class="card-body">
				<div class="">
					<form action="" method="post">
						<div class="row">
							<div class="col-sm-8">
								<label for="exampleInputEmail1">KRA Name:</label>
								<input required="" value="<?php echo $row['KRA_NAME']; ?>" style="padding:5px !important" name="kra_name" placeholder="Enter KRA Name" class="form-control cust-control" type='text' />
							</div>

							<div class="col-sm-2">
								<div class="mt-4">
									<button class="form-control  btn  btn-sm  btn-primary" type="submit">Submit Data</button>
								</div>
							</div>

						</div>


					</form>

				</div>



				<?php







				?>

			</div>
		</div>



	</div>
</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>