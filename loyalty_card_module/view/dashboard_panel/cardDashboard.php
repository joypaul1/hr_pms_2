<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connloyaltyoracle.php');
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
<?PHP
$query = "SELECT
COUNT(ID) AS TOTAL_CARD,
COUNT(CASE WHEN CI.HANDOVER_STATUS = 1 THEN ID END) AS ACTIVE_CARD,
COUNT(CASE WHEN CI.HANDOVER_STATUS = 0 THEN ID END) AS DEACTIVE_CARD
FROM CARD_INFO CI";
$cardSQL = oci_parse($objConnect, $query);
oci_execute($cardSQL);
$rowData = oci_fetch_assoc($cardSQL)
?>
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
								<span class="avatar-initial rounded bg-label-info"><i class='bx bxs-message-alt-check'></i></span>
							</div>
							<h4 class="ms-1 mb-0"><?= $rowData['ACTIVE_CARD'] ?></h4>
						</div>
						<p class="mb-1 fw-bold">Active Card</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mb-4">
				<div class="card card-border-shadow-primary h-100">
					<div class="card-body">
						<div class="d-flex align-items-center mb-2 pb-1">
							<div class="avatar me-2">
								<span class="avatar-initial rounded bg-label-danger"><i class='bx bxs-hand'></i></span>
							</div>
							<h4 class="ms-1 mb-0"><?= $rowData['DEACTIVE_CARD'] ?></h4>
						</div>
						<p class="mb-1 fw-bold">Deactive Card</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mb-4">
				<div class="card card-border-shadow-primary h-100">
					<div class="card-body">
						<div class="d-flex align-items-center mb-2 pb-1">
							<div class="avatar me-2">
								<span class="avatar-initial rounded bg-label-warning"><i class='bx bx-qr-scan'></i></span>
							</div>
							<h4 class="ms-1 mb-0"><?= $rowData['TOTAL_CARD'] ?></h4>
						</div>
						<p class="mb-1 fw-bold">Total Card Processing</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>