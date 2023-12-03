<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('resale-product-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y"        


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
                            <th scope="col">Total Bid </th>
                            <th scope="col">highest Bid </th>
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
                            ID, 
                            REF_CODE, 
                            ENG_NO, 
                            CHS_NO, 
                            REG_NO, 
                            BOOK_VALUE, 
                            DISPLAY_PRICE, 
                            GRADE, 
                            DEPO_LOCATION, 
                            BRAND_ID, 
                            CATEGORY, 
                            MODEL, 
                            INVOICE_STATUS, 
                            BOOKED_STATUS, 
                            PRODUCT_BID_ID, 
                            BODY_SIT, 
                            COLOR, 
                            FUEL_TYPE,
                            PIC_URL 
                            FROM PRODUCT
                            WHERE     PUBLISHED_STATUS = 'Y'
                            AND (('$model' IS NULL OR MODEL LIKE '%$model%') OR
                            ('$chsNo' IS NULL OR CHS_NO = '$chsNo'))");



                        }
                        else {
                            $productSQL = oci_parse($objConnect, "SELECT 
                            ID, 
                            REF_CODE, 
                            ENG_NO, 
                            CHS_NO, 
                            REG_NO, 
                            BOOK_VALUE, 
                            DISPLAY_PRICE, 
                            GRADE, 
                            DEPO_LOCATION, 
                            BRAND_ID, 
                            CATEGORY, 
                            MODEL, 
                            INVOICE_STATUS, 
                            BOOKED_STATUS, 
                            PRODUCT_BID_ID, 
                            BODY_SIT, 
                            COLOR, 
                            FUEL_TYPE,
                            PIC_URL 
                        FROM PRODUCT
                        WHERE PUBLISHED_STATUS = 'Y' 
                        AND ROWNUM <= 15 
                        ORDER BY ID DESC");
                        }


                        oci_execute($productSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
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

                                    <strong>BOOK VALUE :</strong>
                                    <?php echo number_format($row['BOOK_VALUE'], 2); ?> TK </br>
                                    <strong>DISPLAY PRICE :</strong>
                                    <?php echo number_format($row['DISPLAY_PRICE'], 2); ?> TK </br>
                                    <strong> MODEL :</strong>
                                    <?php echo ($row['MODEL']); ?> </br>
                                  
                                </td>
                                <td class="text-center"><span class="flex-shrink-0 badge badge-center rounded-pill bg-info w-px-20 h-px-20">4</span></td>
                                <td class="text-roght"><?php echo number_format(10000000, 2)?></td>

                                
                                <td class="text-center">
                                    <?php
                                    echo '<a target="_blank" href="https://resale.rangsmotors.com/product/' . $row['ID'] . '/0" disabled class="btn btn-sm btn-success float-right"> <i class="bx bx-time"></i></a>';
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
        console.log(chassis);
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