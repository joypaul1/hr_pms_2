<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connloyaltyoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('loyalty-card-all-module')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
if (isset($_GET['chas_no']) && $_GET['chas_no']) {
    $dataChasNo  = $_GET['chas_no'];
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
FROM CARD_INFO WHERE CHS_NO='$dataChasNo'";

// Checking and adding the BRAND_ID condition if applicable

$cardSQL = oci_parse($objConnect, $query);
oci_execute($cardSQL);
$cardRow = oci_fetch_assoc($cardSQL);
?>
<!-- CSS for printing -->
<style media="print">
    @page {
        size: A4;
        margin: 0;
    }

    body {
        margin: 0;
        padding: 0;
    }

    .container-xxl {
        width: 100%;
        padding: 10mm;
        box-sizing: border-box;
    }

    .container-p-y {
        padding-top: 10mm;
        padding-bottom: 10mm;
    }

    .d-print-flex {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card  col-lg-12 ">

        <?php
        $leftSideName  = 'Loyalty Card Details';
        $rightSideName = 'Loyalty Card List';
        $routePath     = 'loyalty_card_module/view/self_panel/list.php';
        include('../../../layouts/_tableHeader.php');
        ?>

        <div class="card-body" id="printarea">
            <div class="card text-white" style="background-color: #9ec9bdbf   !important;">
                <div class="card-body d-flex justify-content-between">
                    <table class="table table-bordered" >
                        <tr>
                            <td> NAME </td>
                            <td><?= $cardRow['CUSTOMER_NAME'] ?></td>
                        </tr>
                        <tr>
                            <td>MOBILE </td>
                            <td><?= $cardRow['CUSTOMER_NAME'] ?></td>
                        </tr>
                        <tr>
                            <td>REF. CODE </td>
                            <td><?= $cardRow['REF_NO'] ?></td>
                        </tr>
                        <tr>
                            <td>ENG. NO. </td>
                            <td><?= $cardRow['ENG_NO'] ?></td>
                        </tr>
                        <tr>
                            <td>CHS. NO.</td>
                            <td><?= $cardRow['CHS_NO'] ?></td>
                        </tr>
                        <tr>
                            <td>VALID FROM</td>
                            <td><?= $cardRow['VALID_START_DATE'] ?></td>
                        </tr>
                        <tr>
                            <td>VALID THRU</td>
                            <td><?= $cardRow['VALID_END_DATE'] ?></td>
                        </tr>
                        <tr>

                            <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= $basePath ?>/loyalty_card_module/view/self_panel/cardDetails.php?chas_no=<?= $cardRow['CHS_NO']; ?>&amp;size=300x100" alt="" title="Card QRCOde" />

                        </tr>
                    </table>

                </div>
            </div>
        </div>
        <!-- Add a button for printing -->
        <div class="card-footer text-end">
            <button onclick="printCard()" class="btn btn-primary">Print <i class='bx bxs-printer'></i></button>
        </div>
    </div>
</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>

<script>
    function printCard() {
        var printContents = document.getElementById("printarea").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>