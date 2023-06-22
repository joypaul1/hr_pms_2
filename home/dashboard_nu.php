<?php
$v_page        = 'role';
$v_active_open = 'active open';
$v_active      = 'active';
require_once('../helper/com_conn.php');
require_once('../inc/connoracle.php');
$strSQL  = oci_parse($objConnect, "select A.id,
											  A.PMS_NAME,
											  A.IS_ACTIVE,
											  A.BG_COLOR    
									from HR_PMS_LIST a, HR_PMS_EMP b
									where a.id=B.HR_PMS_LIST_ID
									and B.EMP_ID='$emp_session_id'");
oci_execute($strSQL);
?>
<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">
	<div class="row">
		<div class="col-lg-8 mb-4 order-0">
			<div class="card">
				<div class="d-flex align-items-end row">
					<div class="col-sm-7">
						<div class="card-body">
							<h5 class="card-title text-primary">Congratulations <?php echo $_SESSION['HR']['first_name_hr']; ?>! 🎉</h5>
							<p class="mb-4">
								Access Are Predefine according to <span class="fw-bold">Rangs Motors HR Policy.</span>
								If you need more access please contact with HR.
							</p>

							<a href="" class="btn btn-sm btn btn-primary">Universal Notification</a>
						</div>
					</div>
					<div class="col-sm-5 text-center text-sm-left">
						<div class="card-body pb-0 px-0 px-md-4">
							<img src="<?php echo $basePath ?>/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		$userStatusSQL  = oci_parse(
			$objConnect,
			"SELECT DOJ,DOC
									FROM RML_HR_APPS_USER 
									WHERE RML_ID='$emp_session_id'"
		);
		oci_execute($userStatusSQL);
		while ($row = oci_fetch_assoc($userStatusSQL)) {
		?>



			<div class="col-lg-4 mb-4 order-0">
				<div class="row">
					<div class="col-lg-6 col-md-12 col-6 mb-4">
						<div class="card">
							<div class="card-body">
								<div class="card-title d-flex align-items-start justify-content-between">
									<div class="avatar flex-shrink-0">
										<img src="<?php echo $basePath ?>/assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
									</div>

								</div>
								<span class="fw-semibold d-block mb-1">Joining Date</span>
								<h3 class="card-title mb-2"><?php echo $row['DOJ']; ?></h3>
								<small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i></small>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-6 mb-4">
						<div class="card">
							<div class="card-body">
								<div class="card-title d-flex align-items-start justify-content-between">
									<div class="avatar flex-shrink-0">
										<img src="<?php echo $basePath ?>/assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
									</div>

								</div>
								<span class="fw-semibold d-block mb-1">Confirmation Date</span>
								<h3 class="card-title mb-2"><?php echo $row['DOC']; ?></h3>
								<small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i></small>
							</div>
						</div>
					</div>

				</div>
			</div>
		<?php
		}
		?>
	</div>





	<div class="row">
		<?php
		while ($row = oci_fetch_assoc($strSQL)) {
		?>
			<div class="col-xl-3 col-md-6">
				<div class="<?php echo $row['BG_COLOR']; ?>">
					<div class="card-body font-weight-bold">
						<?php
						if ($row['IS_ACTIVE'] == '1')
							echo $row['PMS_NAME'];
						else
							echo $row['PMS_NAME'] . '[Closed]';
						?></div>
					<div class="card-footer d-flex align-items-center justify-content-between">
						<a class="small text-white stretched-link" href="pms_kpi_dtls.php?key=<?php echo $row['ID']; ?>">View Details</a>
						<div class="small text-white"><i class="fa fa-angle-right"></i></div>
					</div>
				</div>
			</div>
		<?php
		}
		?>

	</div>
</div>
<!-- / Content -->

<?php require_once('../layouts/footer_info.php'); ?>
<?php require_once('../layouts/footer.php'); ?>