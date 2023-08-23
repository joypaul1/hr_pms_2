<?php
session_start();
session_regenerate_id(TRUE);



require_once('inc/config.php');
require_once('layouts/header.php');

// $v_page = 'user_web';
// $v_active_open = 'active open';
// $v_active = 'active';


require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
require_once('inc/connoracle.php');


// $emp_session_id = $_SESSION['HR']['emp_id_hr'];


?>
<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
	<div class="row">
		<div class="col-lg-12">
			<form action="" method="post">
				<div class="row">
					<div class="col-sm-4">
						<label for="title">User ID</label>
						<input required="" type="text" class="form-control" id="title" placeholder="user ID" name="user_id">
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="title"> <br></label>
							<input class="form-control btn btn-primary" type="submit" value="Search Data">
						</div>
					</div>

			</form>
		</div>

		<div class="col-lg-12">
			<div class="md-form mt-5">
				<div class="resume-item d-flex flex-column flex-md-row">
					<table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
						<thead class="table-dark">
							<tr>
								<th scope="col">Sl</th>
								<th scope="col">User Info</th>
								<th scope="col">Password</th>
								<th style="text-align:center"">Action</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php




						if (isset($_POST['user_id'])) {

							$user_id = $_REQUEST['user_id'];
							$selectsql = "SELECT a.id,
											   a.first_name,
											   a.user_role_id,
											   b.user_role,
											   a.emp_id,
											   a.email,
											   a.password,a.real_pass
											FROM tbl_users a , tbl_user_role b 
											 WHERE a.user_role_id=b.id
											 AND a.emp_id='$user_id'
											   order by a.user_role_id 
											 ";
							$rs = mysqli_query($conn_hr, $selectsql);
							$number = 0;

							while ($row = $rs->fetch_assoc()) {
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
							<td align=" center">
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
						} else {
							$selectsql = "SELECT a.id,
											   a.first_name,
											   a.user_role_id,
											   b.user_role,
											   a.emp_id,
											   a.email,
											   a.password,a.real_pass
											FROM tbl_users a , tbl_user_role b 
											 WHERE a.user_role_id=b.id
											   order by a.user_role_id ";
							$rs = mysqli_query($conn_hr, $selectsql);
							$number = 0;

							while ($row = $rs->fetch_assoc()) {
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
						}
					?>
					</tbody>

					</table>
				</div>

			</div>
		</div>


	</div>
</div>

</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>
<?php require_once('layouts/footer.php'); ?>