<?php

$dynamic_link_css[] = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js[]  = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once ('../../../helper/3step_com_conn.php');
require_once ('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('deed-create')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12">
        <form action="" method="post">
            <input type="hidden" name="actionType" value="searchData">
            <div class="card-body row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">Sell invoice ID</label>
                        <input required="" placeholder="Sell invoice  ID" name="invoice_id" class="form-control cust-control" type='text'
                            value='<?php echo isset($_POST['invoice_id']) ? $_POST['invoice_id'] : ''; ?>'>
                    </div>
                    <small class="text-danger">*** Invoice Number Case Sensitive</small>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-info" type="submit" value="Search Data">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bordered Table -->
    <div class="card  mt-1">
        <form action="<?php echo $basePath . '/deed_module/view/form_panel/car_deed_print_preview.php' ?>" id="card_deed_form" method="POST">
            <input type="hidden" name="invoice_number" value="<?php echo isset($_POST["invoice_id"]) ? trim($_POST["invoice_id"]) : ' ' ?>">
            <input type="hidden" name="actionType" value="car_deed">
            <div class="card-body row">
                <div class="col-md-7 ">
                    <div style="border: 1px solid #eee5e5;
                    padding: 1%;
                    margin: 1%;
                ">
                        <h5 class="text-center"> <i class="menu-icon tf-icons bx bx-right-arrow m-0 text-info"></i>Invoice Number :
                            <?php echo isset($_POST["invoice_id"]) ? trim($_POST["invoice_id"]) : ' ' ?>
                        </h5>
                        <p class="text-center"> <i class=" m-0 text-info"></i><u>Car Reference List</u> </p>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>REF. CODE</th>
                                    <th>INFORMATION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'searchData') {
                                    $invoice_id = trim($_POST["invoice_id"]);

                                    $deedSQL = oci_parse($objConnect, "SELECT
                                    A.CUSTOMER_NAME,
                                    A.CUSTOMER_MOBILE_NO,
                                    A.REF_CODE,
                                    A.PRODUCT_CODE_NAME,
                                    A.CHASSIS_NO,
                                    A.ENG_NO,
                                    A.BRAND,
                                    CASE
                                        WHEN EXISTS (SELECT 1 FROM DEED_INFO D WHERE D.REF_NUMBER = A.REF_CODE) THEN 'true'
                                        ELSE 'false'
                                    END AS deed_status
                                FROM
                                    LEASE_ALL_INFO_ERP A
                                WHERE
                                    A.PAMTMODE = 'CRT' AND
                                    A.DOCNUMBR = '$invoice_id'");
                                    oci_execute($deedSQL);
                                    // print_r(oci_fetch_assoc($deedSQL));
                                    if ($row = oci_fetch_assoc($deedSQL)) {
                                        do {
                                            echo '<tr>
                                                    <td>';
                                            echo ($row['DEED_STATUS'] == 'true') ?
                                                '<p class="text-danger">All Ready Done</p>' :
                                                '<input
                                                        type="checkbox"
                                                        class="form-check-input ref_code"
                                                        value="' . $row['REF_CODE'] . '"
                                                        name="reference_id[]"
                                                        id="' . $row['REF_CODE'] . '"
                                                        data-invoice-id="' . $invoice_id . '"
                                                        data-code-no="' . $row['PRODUCT_CODE_NAME'] . '"
                                                        data-chassis-no="' . $row['CHASSIS_NO'] . '"
                                                        data-eng-no="' . $row['ENG_NO'] . '"
                                                        data-brand-name="' . $row['BRAND'] . '">' .
                                                '<label
                                                        class="form-check-label"
                                                        for="' . $row['REF_CODE'] . '"> ' . $row['REF_CODE'] .
                                                '</label>';

                                            echo '</td>
                                        <td>
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '">NAME : ' . $row['CUSTOMER_NAME'] . '</label>
                                        </br>
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '">MOBILE : ' . $row['CUSTOMER_MOBILE_NO'] . '</label>
                                        </br>
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '">BRAND : ' . $row['BRAND'] . '</label>
                                        </br>
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '">PRODUCT CODE : ' . $row['PRODUCT_CODE_NAME'] . '</label>
                                        </br>
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '">CHASSIS NO. : ' . $row['CHASSIS_NO'] . '</label>
                                        </br>
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '">ENGINE NO. : ' . $row['ENG_NO'] . '</label>
                                        </td>
                                        
                                    </tr>';
                                        } while ($row = oci_fetch_assoc($deedSQL));
                                    }
                                    else {
                                        echo '<strong class="text-danger">Sorry! No data found.</strong>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>



                    </div>
                </div>

                <?php
                $singleProduct = [];
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'searchData') {
                    $invoice_id = trim($_POST["invoice_id"]);
                    $deedSQL    = oci_parse($objConnect, "SELECT CUSTOMER_NAME,DELIVERY_DATE,PARTY_ADDRESS,SALES_AMOUNT,DP,LEASE_AMOUNT,INSTALLMENT_AMOUNT FROM LEASE_ALL_INFO_ERP WHERE PAMTMODE ='CRT' and DOCNUMBR = '$invoice_id'");
                    oci_execute($deedSQL);
                    $singleProduct = oci_fetch_assoc($deedSQL);
                    // print_r($singleProduct);
                    $buyerSQL = oci_parse($objConnect, "SELECT  INVOICE_DATE,FATHERS_NAME, FIRST_GUARANTOR, FIRST_GUARANTOR_FATHER,FIRST_GUARANTOR_ADDRESS,SECOND_GUARANTOR,SECOND_GUARANTOR_SO_DO, SECOND_GUARANTOR_ADDRESS,GETGRASEPERIOD('$invoice_id',POSIBLE_INST_START_DATE) GRACE_PERIOD ,NO_OF_INSTALLMENT,POSIBLE_INST_START_DATE FROM buyers_all_info_data WHERE INVOICE_NO = '$invoice_id'");
                    oci_execute($buyerSQL);
                    $buyerSQL = oci_fetch_assoc($buyerSQL);
                }
                ?>
                <div class="col-md-5">
                    <div style="border: 1px solid #eee5e5;padding: 2%; margin: 1%">
                        <div class="form-group">
                            <label for="unit_no">Unit No.</label>
                            <input type="text" class="form-control" name="unit_no" id="unit_no" required placeholder="0/1/2"
                                onkeypress="return false;" style="background-color: #d9dee3;" autocomplete="off">
                        </div>
                        <div id="dynamicOption" style="width:100%;"></div>
                        <div id="deedinfo"></div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-3">
                        <button type="submit" class="form-control btn btn-sm btn-primary">Submit </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ Bordered Table -->



</div>


<!-- / Content -->

<?php require_once ('../../../layouts/footer_info.php'); ?>
<?php require_once ('../../../layouts/footer.php'); ?>

<script>
    $(document).ready(function () {

        $('#date').datepicker({
            dateFormat: 'dd-mm-yy'
        }).val();
        $('#emi_start_date').datepicker({
            dateFormat: 'dd-mm-yy'
        }).val();
        $(document).on('click', '.ref_code', async function () {
            var ref_code = $(this).val();
            $('#deedhtml').remove();
            if ($(this).is(':checked')) {
                let codeno = $(this).attr('data-code-no');
                let invoice_number = $(this).attr('data-invoice-id');
                let engno = $(this).attr('data-eng-no');
                let brandName = $(this).attr('data-brand-name');
                let chassisno = $(this).attr('data-chassis-no');

                try {
                    const data = await fetchData(ref_code, invoice_number);
                    $('#deedinfo').after(JSON.parse(data));

                    let html = `<span id="${ref_code}" style="width:100%">
                            <input type="hidden" class="form-control" name="product_brand" value="${brandName}" id="product_brand" placeholder="product brand(EX:EICHER)">
                            <input type="hidden" class="form-control" name="product_model" value="${codeno}" id="product_model" placeholder="product brand(EX:AB-000)">
                            <div class="form-group">
                                <label for="product_chassis_no"> Product Chassis No.</label>
                                <input type="text" class="form-control" name="product_chassis_no[]" value="${chassisno}" id="product_chassis_no" placeholder="Prouduct chassis no..">
                            </div>
                            <div class="form-group">
                                <label for="product_engine_no"> Product Engine No.</label>
                                <input type="text" class="form-control" name="product_engine_no[]" value="${engno}" id="product_engine_no" placeholder="Prouduct Engine no..">
                            </div></span>`;
                    $('#dynamicOption').after(html);
                } catch (error) {
                    alert('Error getting data from ajax');
                    console.error(error);
                }

            } else {
                var escaped_ref_code = $.escapeSelector(ref_code);
                $('span#' + escaped_ref_code).remove();
            }
            let ref_length = $('.ref_code').filter(':checked').length;
            $('#unit_no').val(ref_length);
        });

        function fetchData(ref_code, invoice_number) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    type: "GET",
                    url: "<?php echo $basePath . "/deed_module/action/upload.php"; ?>",
                    data: {
                        ref_code: ref_code,
                        invoice_number: invoice_number
                    },
                    success: function (data) {
                        resolve(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        reject(errorThrown);
                    }
                });
            });
        }
    });
</script>