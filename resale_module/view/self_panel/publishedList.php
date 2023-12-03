<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('resale-product-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form  method="GET">
            <div class="row justify-content-center">
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Engine No.</label>

                    <input placeholder="Engine Number" type="text" name="eng_no" class="form-control  cust-control" id="eng" value="<?php echo isset($_GET['eng_no']) ? $_GET['eng_no'] : null ?>">
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Chassis No.</label>

                    <input placeholder="Chassis Number" type="text" name="chs_no" class="form-control  cust-control" id="chs"value="<?php echo isset($_GET['chs_no']) ? $_GET['chs_no'] : null ?>">
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Model No.</label>

                    <input placeholder="Model Number" type="text" name="model" class="form-control  cust-control" id="mdl" value="<?php echo isset($_GET['model']) ? $_GET['model'] : null ?>">
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
                            <th scope="col">Action</th>
                            <th scope="col">QrCode Scane</th>
                            <th scope="col">Live Preview</th>
                            <th scope="col">Product Info</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php

                            $engNo = isset($_GET['eng_no']) ? $_GET['eng_no'] : null;
                            $chsNo = isset($_GET['chs_no']) ? $_GET['chs_no'] : null;
                            $model = isset($_GET['model']) ? $_GET['model'] : null;
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
                                    WHERE PUBLISHED_STATUS = 'Y' OR (MODEL=:model or CHS_NO = :chsNo OR ENG_NO = :engNo)");

                            oci_bind_by_name($productSQL, ':model', $model);
                            oci_bind_by_name($productSQL, ':engNo', $engNo);
                            oci_bind_by_name($productSQL, ':chsNo', $chsNo);
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
                                    <?php
                                    echo '<a href="' . $basePath . '/resale_module/view/self_panel/edit.php?id=' . $row['ID'] . '&amp;&amp;actionType=edit" disabled class="btn btn-sm btn-warning float-right"> <i class="bx bx-edit-alt me-1"></i></a>';
                                    ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#qrModal_<?php echo $row['ID'] ?>">
                                        <i class='bx bx-qr-scan'></i>
                                    </button>
                                    <!-- QR code modal -->
                                    <div class="modal fade" tabindex="-1" aria-labelledby="qrModal_<?php echo $row['ID'] ?>" aria-hidden="true"
                                        id="qrModal_<?php echo $row['ID'] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal content -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">QR Code</h4>
                                                    <button type="button" class="btn bt-sm btn-danger close " data-bs-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <!-- QR code image -->
                                                    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https://resale.rangsmotors.com/product/<?php echo $row['ID'] ?>/0&choe=UTF-8"
                                                        title="Link to resale" />
                                                    <br>
                                                    <strong>Chassis No. :
                                                        <?php echo $row['CHS_NO'] ?>
                                                    </strong>

                                                </div>
                                                <div class="modal-footer">
                                                    <!-- Print button -->
                                                    <button type="button" class="btn btn-success"
                                                        onclick="printQRCode('qrModal_<?php echo $row['ID'] ?>', '<?php echo $row['CHS_NO'] ?>')">Print</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php
                                    echo '<a target="_blank" href="https://resale.rangsmotors.com/product/' . $row['ID'] . '/0" disabled class="btn btn-sm btn-success float-right"> <i class="bx bx-webcam"></i></a>';
                                    ?>
                                </td>
                                <td>
                                    <strong>DISPLAY PRICE :</strong>
                                    <?php echo number_format($row['DISPLAY_PRICE'], 2); ?> TK </br>
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
                                    <strong> COLOR :</strong>
                                    <?php echo ($row['COLOR']); ?> </br>
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