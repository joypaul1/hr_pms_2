<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');

$basePath = $_SESSION['basePath'];

?>
<div class="container-xxl flex-grow-1 container-p-y">
	<div class="row">
		<div class="col-lg-12 ">
			<div class=" card card-title p-2">
				<marquee>Welcome to our new Rangs Group HR appps Web portal. If you face any problem please, inform us [IT & ERP Dept.]</marquee>
			</div>
		</div>
		<div class="col-lg-6 mb-2 order-0">

			<div class="card mt-1">
				<div class="card-body">
					<h5 class="card-title text-primary">Approval Pending List</h5>
					<div class="table-responsive text-nowrap">
						<div class="table-responsive text-nowrap">
						<table class="table  table-bordered">
							<thead class="table-dark">
								<tr>
									<th scope="col" align="center"><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>SL</strong></th>
									<th scope="col" align="center"><strong>Approval Type</strong></th>
									<th scope="col" align="center"><strong>Count</strong></th>
								</tr>
							</thead>
							<tbody>
								<?php

								$number = 0;
								while ($row = oci_fetch_assoc($allDataSQL)) {
									$number++;
								?>
									<tr>
										<td align="center"><i class="fab fa-angular fa-lg text-danger me-3 "></i>
											<strong><?php echo $number; ?></strong>
										</td>
										<td><?php echo $row['APPROVAL_TYPE']; ?></td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['APPROVAL_LINK']; ?>>
												<span class="badge badge-center rounded-pill bg-info"><?php echo $row['NUMBER_TOTAL']; ?></span>
											</a>
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
			</div>
		</div>
		<div class="col-lg-6 mb-2 order-0">

			<div class="card mt-1">
				<div class="card-body">
					<h5 class="card-title text-primary">Approval Pending List</h5>
					<div class="table-responsive text-nowrap">

					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-2 order-0">

			<div class="card mt-1">
				<div class="card-body">
					<h5 class="card-title text-primary">Approval Pending List</h5>
					<div class="table-responsive text-nowrap">

					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-2 order-0">

			<div class="card mt-1">
				<div class="card-body">
					<h5 class="card-title text-primary">Approval Pending List</h5>
					<div class="table-responsive text-nowrap">

					</div>
				</div>
			</div>
		</div>



	</div>
</div>
<!-- / Content -->



<?php require_once('../../../layouts/footer_info.php'); ?>

<?php require_once('../../../layouts/footer.php'); ?>