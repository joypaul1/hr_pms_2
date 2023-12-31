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
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Chassis No. </label>

                    <input placeholder="Chassis Number" type="text" name="chs_no" class="form-control  cust-control" id="chs"
                        value="<?php echo isset($_GET['chs_no']) ? $_GET['chs_no'] : null ?>">
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Model No. </label>

                    <input placeholder="Model Number" type="text" name="model" class="form-control  cust-control" id="mdl"
                        value="<?php echo isset($_GET['model']) ? $_GET['model'] : null ?>">
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
        <!-- <h5 class="card-header "><b>Leave Taken List</b></h5> -->
        <!-- table header -->
        <?php
        $leftSideName = 'Published Product List';

        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table  table-bordered">
                    <thead style="background-color: #0e024efa;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Product Info</th>
                            <th scope="col"> Bid Info</th>
                            <th scope="col"> Bid Status</th>
                            <th scope="col">Bid History</th>
                            <!-- <th scope="col">Action</th> -->

                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        // $model = isset($_GET['model']) ? '%' . $_GET['model'] . '%' : null;
                        $model = isset($_REQUEST['model']) ? $_GET['model'] : null;
                        $chsNo = isset($_GET['chs_no']) ? $_GET['chs_no'] : null;
                        // echo  $model;
                        

                        if ($chsNo || $model) {
                            if (empty($model)) {
                                $model = 'NULL';

                            }
                            //  echo  $model;
                            if (empty($chsNo)) {
                                $chsNo = 'NULL';
                                // echo  $model;
                            }
                            
                            
                            $productSQL = oci_parse($objConnect, "SELECT 
                            BB.ID,
                            BB.CATEGORY,
                            BB.MODEL,
                            BB.REF_CODE,
                            BB.CHS_NO,
                            BB.ENG_NO,
                            BB.REG_NO,
                            BB.BOOK_VALUE,
                            -- BB.DISPLAY_PRICE,
                            BB.CREDIT_PRICE,
                            BB.CASH_PRICE,
                            BB.GRADE,
                            AA.MAX_BID_AMOUNT,
                            AA.TOTAL_BID,
                            BB.AUCTTION_START_DATE,
                            BB.AUCTION_END_DATE,
                            (BB.AUCTION_END_DATE-trunc(SYSDATE)) as BID_REMAINDER
                            FROM 
                                (SELECT A.PRODUCT_ID,
                                       COUNT(PRODUCT_ID) TOTAL_BID,
                                       MAX_BID_AMOUNT(A.PRODUCT_ID) MAX_BID_AMOUNT
                                FROM PRODUCT_BID A,PRODUCT B
                                WHERE A.PRODUCT_ID=B.ID
                                GROUP BY A.PRODUCT_ID) AA,PRODUCT BB
                            WHERE AA.PRODUCT_ID=BB.ID AND (('$model' IS NULL OR BB.MODEL LIKE '%$model%') OR
                             ('$chsNo' IS NULL OR BB.CHS_NO = '$chsNo'))");



                        }
                        else {
                            $productSQL = oci_parse($objConnect, "SELECT 
                            BB.ID,
                            BB.CATEGORY,
                            BB.MODEL,
                            BB.REF_CODE,
                            BB.CHS_NO,
                            BB.ENG_NO,
                            BB.REG_NO,
                            BB.BOOK_VALUE,
                            -- BB.DISPLAY_PRICE,
                            BB.CREDIT_PRICE,
                            BB.CASH_PRICE,
                            BB.GRADE,
                            AA.MAX_BID_AMOUNT,
                            AA.TOTAL_BID,
                            BB.AUCTTION_START_DATE,
                            BB.AUCTION_END_DATE,
                            (BB.AUCTION_END_DATE-trunc(SYSDATE)) as BID_REMAINDER
                            FROM 
                                (SELECT A.PRODUCT_ID,
                                       COUNT(PRODUCT_ID) TOTAL_BID,
                                       MAX_BID_AMOUNT(A.PRODUCT_ID) MAX_BID_AMOUNT
                                FROM PRODUCT_BID A,PRODUCT B
                                WHERE A.PRODUCT_ID=B.ID
                                GROUP BY A.PRODUCT_ID) AA,PRODUCT BB
                            WHERE AA.PRODUCT_ID=BB.ID");
                        }


                        oci_execute($productSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            // print_r($row['BID_REMAINDER'] );
                            // die();
                            ?>
                            <tr>
                                <td>
                                     <strong>
                                        <?php echo $number; ?>
                                    </strong>
                                </td>
                                <td>
                                    <strong>REFERENCE CODE :</strong>
                                    <?php echo ($row['REF_CODE']); ?> </br>
                                    <strong>ENGINE NO. :</strong>

                                    <?php echo ($row['ENG_NO']); ?> </br>
                                    <strong>CHASSIS NO. :</strong>
                                    <?php echo ($row['CHS_NO']); ?> </br>
                                    <strong>REGISTATION NO. :</strong>
                                    <?php echo ($row['REG_NO']); ?> </br>
                                    <strong> MODEL :</strong>
                                    <?php echo ($row['MODEL']); ?> </br>

                                </td>

                                <td class="text-right">
                                    <strong>BOOK VALUE :
                                        <?php echo number_format($row['BOOK_VALUE']) ?> TK
                                    </strong>
                                    </br>
                                    <strong>CASH PRICE :
                                        <?php echo number_format($row['CASH_PRICE']) ?> TK
                                    </strong>
                                    </br>
                                    <strong>CREDIT PRICE :
                                        <?php echo number_format($row['CREDIT_PRICE']) ?> TK
                                    </strong>
                                    </br>
                                    <strong>MAX BID :
                                        <?php echo number_format($row['MAX_BID_AMOUNT']) ?> TK
                                    </strong>
                                    </br>
                                    <strong>TOTAL BID :
                                        <span class="badge badge-center bg-danger">
                                            <?php echo $row['TOTAL_BID'] ?>
                                        </span>
                                    </strong>


                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($row['BID_REMAINDER'] > 0) {
                                        echo "<span class='badge badge-center bg-info'><i class='bx bx-check'></i></span></br>";
                                        echo "<strong>Remian Days : " . $row['BID_REMAINDER'] . "</strong>";
                                    }
                                    else {
                                        echo "<span class='badge badge-center bg-warning'><i class='bx bx-x'></i></span>";

                                    }
                                    ?>
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
    // Function to print QR code image
    function printQRCode(modalId, chassis) {
        var printWindow = window.open('', '_blank');
        printWindow.document.write(
            '<div style="display: flex; align-items: center; justify-content: center; height: 70vh;">' +
            '<div style="text-align: center;">' +
            '<img src="' + $('#' + modalId + ' img').attr('src') + '" style="max-width: 100%; height: auto;">' +
            '<p><strong>Chassis No. :' + chassis + '</strong></p>' +
            '</div>' +
            '</div>'
        );

        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    }
</script>