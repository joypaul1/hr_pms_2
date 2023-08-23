<?php

session_start();
session_regenerate_id(TRUE);
// if($_SESSION['HR']['hr_role']!= 1)
// {
// 	header('location:index.php?lmsg_hr=true');
// 	exit;
// } 

// if(!isset($_SESSION['HR']['id_hr'],$_SESSION['HR']['hr_role']))
// {
// 	header('location:index.php?lmsg_hr=true');
// 	exit;
// }		
require_once('inc/config.php');
require_once('layouts/header.php');


$v_page = 'user_web_create';
$v_active_open = 'active open';
$v_active = 'active';

require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');



$emp_sesssion_id = $_SESSION['HR']['emp_id_hr'];

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

	<div class="col-lg-12">
		<form action="" method="post">
			<div class="row">
				<div class="col-sm-3">
					<label for="title">Enter Employee Vaild ID</label>
					<input required="" type="text" class="form-control" id="title" placeholder="Emp ID" name="emp_id">
				</div>
				<div class="col-sm-3">
					<label for="title">Enter Employee Name</label>
					<input required="" type="text" class="form-control" id="title" placeholder="Emp Name" name="emp_name">
				</div>
				<div class="col-sm-3">
					<label for="title">Enter Password</label>
					<input required="" type="text" class="form-control" id="title" placeholder="Password" name="emp_pass">
				</div>
				<div class="col-sm-3">
					<label for="title">Select EMP Role</label>
					<select name="user_role" class="form-control">
						<option selected value="4">NU</option>
						<option value="3">LM</option>
						<option value="2">HR</option>

					</select>
				</div>
			</div>
	</div>

	<div class="row">
		<div class="col-sm-9">
		</div>
		<div class="col-sm-3">
			<div class="md-form mt-3">
				<input class="form-control btn btn-primary" type="submit" value="Change Password">
			</div>
		</div>
	</div>
	</form>
</div>
</br>
<?php
if (isset($_POST['emp_id'])) {
	$v_emp_id = $_REQUEST['emp_id'];
	$v_emp_name = $_REQUEST['emp_name'];
	$v_emp_pass = $_REQUEST['emp_pass'];
	$v_user_role = $_REQUEST['user_role'];

	$v_emp_pass_md5 = md5($v_emp_pass);

	$sql = "SELECT id FROM tbl_users WHERE emp_id='$v_emp_id'";
	$rs = mysqli_query($conn_hr, $sql);
	@$getNumRowsPass = mysqli_num_rows($rs);

	if ($getNumRowsPass == 0) {
		$auditsql = "INSERT INTO tbl_users(
			                 user_role_id, 
			                 first_name, 
							 emp_id, 
							 concern, 
							 email, 
							 password, 
							 real_pass) 
						VALUES ('$v_user_role','$v_emp_name','$v_emp_id','RML','webuser@mail.com','$v_emp_pass_md5','$v_emp_pass')";
		mysqli_query($conn_hr, $auditsql);

		echo '<div class="alert alert-danger">';
		echo 'User is created successfully.';
		echo '</div>';
	} else {
		echo '<div class="alert alert-danger">';
		echo 'This [' . $v_emp_id . '] user is already created.';
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


					$selectsql = "SELECT a.id,
							   a.first_name,
							   a.user_role_id,
							   b.user_role,
							   a.emp_id,
							   a.email,
							   a.password,a.real_pass
							FROM tbl_users a , tbl_user_role b 
							 WHERE a.user_role_id=b.id
							   order by a.id desc";

					$rs = mysqli_query($conn_hr, $selectsql);
					$number = 0;
					while ($row = @$rs->fetch_assoc()) {
						$number++;
					?>
						<tr>
							<td><?php echo $number; ?></td>
							<td>
								<?php
								echo 'User Name: <b>' . $row['first_name'] . '</b>';
								echo '<br>';
								echo 'User ID: <b>' . $row['emp_id'] . '</b>';
								echo '<br>';
								echo 'Role: <b>' . $row['user_role'] . '</b>';
								echo '<br>';
								echo 'Email:- <b>' . $row['email'] . '</b>';
								?>
							</td>
							<td><?php if ($row['emp_id'] != 'RML-00955' || $row['emp_id'] != 'RML-01120') {
									echo $row['password'];
									echo '<br>';
									echo $row['real_pass'];
								}
								?>
							</td>
							<td align="center">
								<?php if ($row['emp_id'] != 'RML-00955') {
								?>
									<a target="_blank" href="user_edit.php?emp_id=<?php echo $row['id'] ?>"><?php
																											echo '<button class="btn btn-primary">update</button>';
																											?>
									</a>
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
</div>
<!--/ Bordered Table -->



</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>
<?php require_once('layouts/footer.php'); ?>