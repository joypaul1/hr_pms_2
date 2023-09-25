<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$editId = $_REQUEST['id'];

$strSQL  = oci_parse($objConnect, "SELECT KRA_NAME, HR_PMS_LIST_ID FROM HR_PMS_KRA_LIST WHERE ID=$editId");
oci_execute($strSQL);
$data = oci_fetch_assoc($strSQL);
// print_r($row);


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
					<form action="<?php echo $basePath . "/pms_module/action/self_panel.php"   ?>" method="post">
						<input type="hidden" name="actionType" value='kra_edit'>
						<input type="hidden" name="editId" value='<?php echo $editId ?>'>
						<div class="row">
							<div class="col-sm-6">
								<label for="exampleInputEmail1">KRA Name:</label>
								<input required="" value="<?php echo $data['KRA_NAME']; ?>" style="padding:5px !important" name="kra_name" placeholder="Enter KRA Name" class="form-control cust-control" type='text' />
							</div>
							<div class="col-sm-4">
								<label for="exampleInputEmail1">Select PMS Title:</label>
								<select required="" name="pms_title_id" class="form-control cust-control">
									<option value=""><-Select PMS -></option>
									<?php

									$strSQL  = oci_parse($objConnect, "SELECT ID,PMS_NAME from HR_PMS_LIST where is_active=1");
									oci_execute($strSQL);
									while ($row = oci_fetch_assoc($strSQL)) {
									?>
										<option value="<?php echo $row['ID']; ?>" <?php echo $data['HR_PMS_LIST_ID'] == $row['ID'] ? 'selected' : ' ' ?>><?php echo $row['PMS_NAME']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="mt-4">
									<button class="form-control  btn  btn-sm  btn-primary" type="submit">Submit Data</button>
								</div>
							</div>

						</div>


					</form>

				</div>




			</div>
		</div>



	</div>
</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>