<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('resale-report-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form method="GET">
            <div class="row justify-content-center">
                <!-- <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Chassis No. </label>

                    <input placeholder="Chassis Number" type="text" name="chs_no" class="form-control  cust-control" id="chs" value="<?php echo isset($_GET['chs_no']) ? $_GET['chs_no'] : null ?>">
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Model No. </label>

                    <input placeholder="Model Number" type="text" name="model" class="form-control  cust-control" id="mdl"
                        value="<?php echo isset($_GET['model']) ? $_GET['model'] : null ?>">
                </div> -->
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Start Date <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" value="<?php echo date('Y-m-d'); ?>" class="form-control" type="date" name="start_date">
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">End Date <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" value="<?php echo date('Y-m-d'); ?>" class="form-control" type="date" name="end_date">
                    </div>
                </div>


                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control  btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>


            </div>

        </form>
    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">
        <!-- table header -->
        <?php
        $v_start_date = isset($_GET['start_date']) ? date('d/m/Y', strtotime($_GET['start_date']))  : date('d/m/Y');
        $v_end_date   = isset($_GET['end_date']) ? date('d/m/Y', strtotime($_GET['end_date'])) : date('d/m/Y');
        $leftSideName = 'BID Report List';
        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="text-end">
                <a class="btn btn-sm btn-info text-white" id="" onclick="exportF(this)" style="margin-bottom:2px;"> <i class='bx bx-cloud-download'></i> Export To Excel </a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered" id="downloadData">
                    <thead style="background-color: #02c102;">
                        <tr class="text-center">
                            <th colspan="5">Start Date : <?= $v_start_date ?> - End Date : <?= $v_end_date ?></th>
                        </tr>
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Product Info</th>
                            <th scope="col"> Bid Info</th>
                            <th scope="col"> MAX BID</th>
                            <th scope="col">Bid History</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        // ENTRY_DATE
                        $model      = isset($_REQUEST['model']) ? $_GET['model'] : null;
                        $chsNo      = isset($_GET['chs_no']) ? $_GET['chs_no'] : null;

                        $productSQL = @oci_parse($objConnect, "SELECT
                            BB.ID,
                            BB.CATEGORY,
                            BB.MODEL,
                            BB.REF_CODE,
                            BB.CHS_NO,
                            BB.ENG_NO,
                            BB.REG_NO,
                            BB.BOOK_VALUE,
                            BB.CREDIT_PRICE,
                            BB.CASH_PRICE,
                            BB.GRADE,
                            AA.MAX_BID_AMOUNT,
                            AA.TOTAL_BID,
                            BB.AUCTTION_START_DATE,
                            BB.AUCTION_END_DATE,
                            (BB.AUCTION_END_DATE-TRUNC(SYSDATE)) as BID_REMAINDER
                            FROM
                                (SELECT PB.PRODUCT_ID,
                                COUNT(PRODUCT_ID) TOTAL_BID,
                                MAX(PB.BID_AMOUNT) AS MAX_BID_AMOUNT
                                FROM PRODUCT_BID PB,PRODUCT PR
                                WHERE PB.PRODUCT_ID=PR.ID
                                AND TRUNC (PB.ENTRY_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
                                GROUP BY PB.PRODUCT_ID) AA,PRODUCT BB
                            WHERE AA.PRODUCT_ID=BB.ID");

                        oci_execute($productSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                        ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?php echo $number; ?>
                                    </strong>
                                </td>
                                <td>
                                    <strong> MODEL :</strong>
                                    <?php echo ($row['MODEL']); ?> </br>
                                    <strong>REFERENCE CODE :</strong>
                                    <?php echo ($row['REF_CODE']); ?> </br>
                                    <strong>ENGINE NO. :</strong>

                                    <?php echo ($row['ENG_NO']); ?> </br>
                                    <strong>CHASSIS NO. :</strong>
                                    <?php echo ($row['CHS_NO']); ?> </br>
                                    <strong>REGISTATION NO. :</strong>
                                    <?php echo ($row['REG_NO']); ?> </br>


                                </td>

                                <td class="text-right">


                                    <strong>TOTAL BID :
                                        <span class="badge badge-center bg-danger">
                                            <?php echo $row['TOTAL_BID'] ?>
                                        </span>
                                    </strong>


                                </td>
                                <td class="text-center">
                                    <strong>
                                        <?php echo number_format($row['MAX_BID_AMOUNT'], 2) ?>
                                    </strong>
                                    </br>
                                </td>


                                <td class="text-center">
                                    <?php
                                    echo '<a target="_blank" href="' . $basePath . '/resale_module/view/bidreport_panel/bidHistory.php?id=' . $row['ID'] . '&amp;&amp;actionType=edit"" disabled class="btn btn-sm btn-success float-right"> <i class="bx bx-time"></i></a>';
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

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
    function exportF(elem) {
        var table = document.getElementById("downloadData");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "bid_report.xls"); // Choose the file name
        return false;
    }
</script>