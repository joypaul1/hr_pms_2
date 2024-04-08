<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('loyalty-card-all-module')) {
	echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>
<style>
	.card>.card-border-shadow-info::after {
		border-bottom-color: #9ae7f7;
	}

	.card>.card-border-shadow-warning::after {
		border-bottom-color: #fd9;
	}

	.card>.card-border-shadow-danger::after {
		border-bottom-color: #ffb2a5;
	}

	.card>.card-border-shadow-primary::after {
		border-bottom-color: #c3c4ff
	}

	.card>.card-border-shadow-primary:hover::after {
		border-bottom-color: #696cff
	}

	.card>.card-border-shadow-secondary::after {
		border-bottom-color: #ced3da
	}

	.card>.card-border-shadow-secondary:hover::after {
		border-bottom-color: #8592a3
	}

	.card>.card-hover-border-secondary:hover,
	.card>.card-hover-border-secondary:hover {
		border-color: #d1d6dc
	}

	.card>.card-border-shadow-success::after {
		border-bottom-color: #c6f1af
	}

	.card>.card-border-shadow-success:hover::after {
		border-bottom-color: #71dd37
	}

	.card>.card-hover-border-success:hover,
	.card>.card-hover-border-success:hover {
		border-color: #c9f2b3
	}

	.card>.card-border-shadow-info::after {
		border-bottom-color: #9ae7f7
	}

	.card>.card-border-shadow-info:hover::after {
		border-bottom-color: #03c3ec
	}

	.card>.card-hover-border-info:hover,
	.card>.card-hover-border-info:hover {
		border-color: #9fe8f8
	}

	.card>.card-border-shadow-warning::after {
		border-bottom-color: #fd9
	}

	.card>.card-border-shadow-warning:hover::after {
		border-bottom-color: #ffab00
	}

	.card>.card-hover-border-warning:hover,
	.card>.card-hover-border-warning:hover {
		border-color: #ffdf9e
	}

	.card>.card-border-shadow-danger::after {
		border-bottom-color: #ffb2a5
	}

	.card>.card-border-shadow-danger:hover::after {
		border-bottom-color: #ff3e1d
	}

	.card>.card-hover-border-danger:hover,
	.card>.card-hover-border-danger:hover {
		border-color: #ffb6a9
	}

	.card>.card-border-shadow-light::after {
		border-bottom-color: #fefefe
	}

	.card>.card-border-shadow-light:hover::after {
		border-bottom-color: #fcfdfd
	}

	.card>.card-hover-border-light:hover,
	.card>.card-hover-border-light:hover {
		border-color: #fefefe
	}

	.card>.card-border-shadow-dark::after {
		border-bottom-color: #a7aeb5
	}

	.card>.card-border-shadow-dark:hover::after {
		border-bottom-color: #233446
	}

	.card>.card-hover-border-dark:hover,
	.card>.card-hover-border-dark:hover {
		border-color: #abb2b9
	}

	.card>.card-border-shadow-gray::after {
		border-bottom-color: rgba(249, 249, 250, .64)
	}

	.card>.card-border-shadow-gray:hover::after {
		border-bottom-color: rgba(67, 89, 113, .1)
	}

	.card>.card-hover-border-gray:hover,
	.card>.card-hover-border-gray:hover {
		border-color: rgba(249, 250, 251, .658)
	}

	.card>.card-hover-border-primary:hover,
	.card>.card-hover-border-primary:hover {
		border-color: #c6c7ff
	}

	.card[class*=card-border-shadow-]:hover {
		box-shadow: 0 .25rem 1rem rgba(161, 172, 184, .45)
	}

	.card[class*=card-border-shadow-]:hover::after {
		border-bottom-width: 3px
	}

	.card[class*=card-hover-border-] {
		border-width: 1px
	}
</style>
<div class="container-xxl flex-grow-1 container-p-y">
	<div class="row">
		<div class="col-lg-12 ">
			<div class=" card card-title p-2">
				<marquee>Welcome to our Loyalty Card Module Dashboard. If you face any problem please, inform us [IT & ERP Dept.]</marquee>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-lg-3 mb-4">
				<div class="card card-border-shadow-primary h-100">
					<div class="card-body">
						<div class="d-flex align-items-center mb-2 pb-1">
							<div class="avatar me-2">
								<span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-truck"></i></span>
							</div>
							<h4 class="ms-1 mb-0">42</h4>
						</div>
						<p class="mb-1">On route vehicles</p>
						<p class="mb-0">
							<span class="fw-medium me-1">+18.2%</span>
							<small class="text-muted">than last week</small>
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mb-4">
				<div class="card card-border-shadow-warning h-100">
					<div class="card-body">
						<div class="d-flex align-items-center mb-2 pb-1">
							<div class="avatar me-2">
								<span class="avatar-initial rounded bg-label-warning"><i class="bx bx-error"></i></span>
							</div>
							<h4 class="ms-1 mb-0">8</h4>
						</div>
						<p class="mb-1">Vehicles with errors</p>
						<p class="mb-0">
							<span class="fw-medium me-1">-8.7%</span>
							<small class="text-muted">than last week</small>
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mb-4">
				<div class="card card-border-shadow-danger h-100">
					<div class="card-body">
						<div class="d-flex align-items-center mb-2 pb-1">
							<div class="avatar me-2">
								<span class="avatar-initial rounded bg-label-danger"><i class="bx bx-git-repo-forked"></i></span>
							</div>
							<h4 class="ms-1 mb-0">27</h4>
						</div>
						<p class="mb-1">Deviated from route</p>
						<p class="mb-0">
							<span class="fw-medium me-1">+4.3%</span>
							<small class="text-muted">than last week</small>
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mb-4">
				<div class="card card-border-shadow-info h-100">
					<div class="card-body">
						<div class="d-flex align-items-center mb-2 pb-1">
							<div class="avatar me-2">
								<span class="avatar-initial rounded bg-label-info"><i class="bx bx-time-five"></i></span>
							</div>
							<h4 class="ms-1 mb-0">13</h4>
						</div>
						<p class="mb-1">Late vehicles</p>
						<p class="mb-0">
							<span class="fw-medium me-1">-2.5%</span>
							<small class="text-muted">than last week</small>
						</p>
					</div>
				</div>
			</div>
		</div>






	</div>
</div>
<!-- / Content -->



<?php require_once('../../../layouts/footer_info.php'); ?>

<?php require_once('../../../layouts/footer.php'); ?>