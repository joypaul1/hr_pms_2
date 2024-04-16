<?php
$dynamic_link_css[] = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js[] = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connloyaltyoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('loyalty-card-all-module')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
if (isset($_GET['id']) && $_GET['id']) {
    $cardID = $_GET['id'];
}
$query = "SELECT ID,
CUSTOMER_NAME,
CUSTOMER_MOBILE,
REF_NO,
ENG_NO,
REG_NO,
CHS_NO,
VALID_START_DATE,
VALID_END_DATE,
CARD_TYPE_ID,
HANDOVER_DATE,
HANDOVER_TO_NAME,
HANDOVER_MOBILE_NUMBER,
VARIFICATION_PIN,
HANDOVER_STATUS,
(SELECT CP.TITLE FROM CARD_TYPE CP WHERE CP.ID = CARD_TYPE_ID) AS CARD_TYPE_NAME
FROM CARD_INFO WHERE ID='$cardID'";

// Checking and adding the BRAND_ID condition if applicable

$cardSQL = oci_parse($objConnect, $query);
oci_execute($cardSQL);
$cardRow = oci_fetch_assoc($cardSQL)
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card  col-lg-12 ">

        <?php
        $leftSideName  = 'Loyalty Card Hand Over Process';
        $rightSideName = 'Loyalty Card List';
        $routePath     = 'loyalty_card_module/view/self_panel/list.php';
        include('../../../layouts/_tableHeader.php');
        ?>

        <div class="card-body">
            <div class="card text-white" style="background-color: #1d1a82bf !important;">
                <div class="card-body d-flex justify-content-between">
                    <span class="">
                        <h4 class="card-text text-white"><?= $cardRow['CUSTOMER_NAME'] ?></h4>
                        <p class="card-text"><?= $cardRow['CUSTOMER_MOBILE'] ?></p>
                        <p class="card-text">REF. NO. : <?= $cardRow['REF_NO'] ?></p>
                        <p class="card-text">ENG. NO. : <?= $cardRow['ENG_NO'] ?></p>
                        <p class="card-text">CHS. NO. : <?= $cardRow['CHS_NO'] ?></p>
                        <p class="card-text">VALID START DATE : <?= $cardRow['VALID_START_DATE'] ?></p>
                        <p class="card-text">VALID END DATE : <?= $cardRow['VALID_END_DATE'] ?></p>
                    </span>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= $cardRow['REF_NO']; ?>&amp;size=300x100" alt="" title="Card QRCOde" />

                </div>
            </div>

            <form action="<?php echo ($basePath . '/loyalty_card_module/action/self_panel.php'); ?>" method="post">
                <input type='hidden' hidden name='actionType' value='handOverCard'>
                <input type='hidden' hidden name='cardID' value='<?= $cardRow['ID'] ?>'>
                <div class="row mt-3 ">
                    <div class="col-sm-6">
                        <label for="HANDOVER_DATE">HANDOVER DATE <span class="text-danger"> *</span></label>
                        <input class="form-control" value="<?= date('Y-m-d'); ?>" id="HANDOVER_DATE" name="HANDOVER_DATE" required type="date">
                    </div>
                    <div class="col-sm-6">
                        <label for="HANDOVER_TO_NAME">HANDOVER PERSON NAME <span class="text-danger"> *</span></label>
                        <input value="<?= $cardRow['CUSTOMER_NAME'] ?>" class="form-control" id="HANDOVER_TO_NAME" name="HANDOVER_TO_NAME" required type="text">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label for="HANDOVER_MOBILE_NUMBER">HANDOVER MOBILE NUMBER <span class="text-danger"> *</span></label>
                        <input class="form-control" value="<?= $cardRow['CUSTOMER_MOBILE'] ?>" minlength="11" id="HANDOVER_MOBILE_NUMBER" name="HANDOVER_MOBILE_NUMBER" required type="text">
                    </div>
                </div>
                <div class="mt-2 w-25 mx-auto">
                    <button class="form-control btn btn-sm btn-primary" type="submit">Submit to Create</button>
                </div>

            </form>
        </div>

    </div>



</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>