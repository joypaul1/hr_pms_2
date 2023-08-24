<?php
session_start();
session_regenerate_id(TRUE);

// if (
// 	$_SESSION['HR']['hr_role'] != 2 &&
// 	$_SESSION['HR']['hr_role'] != 3 &&
// 	$_SESSION['HR']['hr_role'] != 4
// ) {
// 	header('location:index.php?lmsg_hr=true');
// 	exit;
// }

// if (!isset($_SESSION['HR']['id_hr'], $_SESSION['HR']['hr_role'])) {
// 	header('location:index.php?lmsg_hr=true');
// 	exit;
// }
require_once('inc/config.php');
require_once('layouts/header.php');

// $v_active_open = '';
// $v_active = '';
require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
$emp_sesssion_id = $_SESSION['HR']['emp_id_hr'];

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

	<div class="col-lg-12">
		<form action="" method="post">
			<div class="row">
				<div class="col-sm-4">
					<input required="" type="text" class="form-control" id="title" placeholder="Enter New Password" name="new_password" minlength="3" maxlength="10" size="10">
				</div>
				<div class="col-sm-4">
					<input required="" type="text" class="form-control" id="title" placeholder="Enter New Password Again" name="new_password_again" minlength="6" maxlength="10" size="10">
				</div>
				<div class="col-sm-4">
					<input required="" type="text" class="form-control" id="title" placeholder="Enter Old Password" name="old_password">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8">
				</div>
				<div class="col-sm-4">
					<div class="md-form mt-3">
						<input class="btn btn-primary btn pull-right" type="submit" value="Change Password">
					</div>
				</div>
			</div>
		</form>
	</div>
	</br>
	<?php
	if (isset($_POST['new_password'])) {
		$new_password = $_REQUEST['new_password'];
		$new_password_again = $_REQUEST['new_password_again'];
		$old_password = $_REQUEST['old_password'];
		if ($new_password == $new_password_again) {
			$md5NewPassword = md5($new_password);
			$md5OldPassword = md5($old_password);

			$sqlPass = "select password from tbl_users where emp_id = '$emp_sesssion_id' and password='$md5OldPassword'";
			$rsPass = mysqli_query($conn_hr, $sqlPass);
			$getNumRowsPass = mysqli_num_rows($rsPass);

			if ($getNumRowsPass == 1) {
				$sql = "update tbl_users set password='$md5NewPassword'  where emp_id = '$emp_sesssion_id' and password='$md5OldPassword'";
				$rs = mysqli_query($conn_hr, $sql);
				if ($rs) {
					$auditsql = "INSERT INTO tbl_password_history (changed_date, changed_by) VALUES (CURDATE(), '$emp_sesssion_id')";
					mysqli_query($conn_hr, $auditsql);

					echo '<div class="alert alert-danger">';
					echo 'You have successfully changed your password.';
					echo '</div>';
				} else {
					echo '<div class="alert alert-danger">';
					echo 'Fail to change your password. Please contact to IT Department.';
					echo '</div>';
				}
			} else {
				echo '<div class="alert alert-danger">';
				echo 'Old Password Mismatched!. Please Try again';
				echo '</div>';
			}
		} else {
			echo '<div class="alert alert-danger">';
			echo 'New Password Mismatched!. Please Try again';
			echo '</div>';
		}
	}
	?>









	<!-- Bordered Table -->
	<div class="card">
		<h5 class="card-header"><b>Password Change History:</b></h5>
		<div class="card-body">
			<div class="table-responsive text-nowrap">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">Sl</th>
							<th scope="col">Changed Date</th>
							<th scope="col">Changed By</th>
						</tr>
					</thead>
					<tbody>

						<?php


						$selectsql = "SELECT 
							changed_date,
							changed_by
						 FROM tbl_password_history
							 WHERE changed_by='$emp_sesssion_id'";

						$rs = mysqli_query($conn_hr, $selectsql);
						$number = 0;
						while ($row = @$rs->fetch_assoc()) {
							$number++;
						?>
							<tr>
								<td>
									<i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
								</td>
								<td><?php echo $row['changed_date']; ?></td>
								<td><?php echo $row['changed_by']; ?></td>


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