<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connloyaltyoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('loyalty-card-all-module')) {
	echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>
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