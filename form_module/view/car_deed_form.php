<?php

// $dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
// $dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('car-deed-form')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

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
                        <input required="" placeholder="Sell invoice  ID" name="invoice_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['invoice_id']) ? $_POST['invoice_id'] : ''; ?>' />
                    </div>
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
        <form action="<?php echo $basePath . '/form_module/view/car_deed_print_form.php' ?>" method="POST" >
        <input type="hidden" name="invoice_number" value="<?php echo isset($_POST["invoice_id"]) ? trim($_POST["invoice_id"]) : ' ' ?>">
        <input type="hidden" name="actionType" value="car_deed">
        <div class="card-body row">
                <div class="col-md-7 ">
                    <div style="
                    border: 1px solid #eee5e5;
                    padding: 1%;
                    margin: 1%;
                ">
                        <h5 class="text-center"> <i class="menu-icon tf-icons bx bx-right-arrow m-0 text-info"></i>Invoice Number :
                            <?php echo isset($_POST["invoice_id"]) ? trim($_POST["invoice_id"]) : ' ' ?> </h5>
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
                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"])  == 'searchData') {
                                    $invoice_id = trim($_POST["invoice_id"]);

                                    $deedSQL = oci_parse($objConnect, "SELECT *  FROM LEASE_ALL_INFO_ERP WHERE PAMTMODE ='CRT' and DOCNUMBR = :invoice_id");
                                    oci_bind_by_name($deedSQL, ":invoice_id", $invoice_id);
                                    oci_execute($deedSQL);
                                    // REF_CODE != '' AND 
                                    // print_r(oci_fetch_assoc($deedSQL));
                                    
                                    if ($row = oci_fetch_assoc($deedSQL)) {
                                        do {
                                            echo '<tr>
                                        <td><input type="checkbox" class="form-check-input ref_code" value="' . $row['REF_CODE'] . '" name="reference_id[]" id="' . $row['REF_CODE'] . '" data-code-no="'. $row['PRODUCT_CODE_NAME'] .'" " data-chassis-no="'. $row['CHASSIS_NO'] .'" data-eng-no="'. $row['ENG_NO'] .'" data-brand-name="'. $row['BRAND'] .'">
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '"> ' . $row['ENG_NO'] . '</label></td>
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
                                    } else {
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
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"])  == 'searchData') {
                    $invoice_id = trim($_POST["invoice_id"]);

                    $deedSQL = oci_parse($objConnect, "SELECT  * FROM LEASE_ALL_INFO_ERP WHERE PAMTMODE ='CRT' and DOCNUMBR = :invoice_id");
                    oci_bind_by_name($deedSQL, ":invoice_id", $invoice_id);
                    oci_execute($deedSQL);
                    $singleProduct = oci_fetch_assoc($deedSQL);
                    // print_r($singleProduct);
                }
                ?>
                <div class="col-md-5">
                    <div style="border: 1px solid #eee5e5;padding: 2%; margin: 1%">
                        <div class="form-group">
                            <label for="unit_no"> Unit No.</label>
                            <input type="text" class="form-control" name="unit_no" value="0" id="unit_no" readonly placeholder="0/1/2">
                        </div>
                        <div class="form-group">
                            <label for="customer_name"> Customer Name</label>
                            <input type="text" class="form-control" name="customer_name"value="<?php echo isset($singleProduct["CUSTOMER_NAME"]) ? $singleProduct["CUSTOMER_NAME"]: ' ' ?>" id="customer_name" placeholder="EX:5,00,000.00">
                        </div>
                        <div class="form-group">
                            <label for="customer_address"> Customer Address</label>
                            <input type="text" class="form-control" name="customer_address"value="<?php echo isset($singleProduct["PARTY_ADDRESS"]) ? $singleProduct["PARTY_ADDRESS"]: ' ' ?>" id="customer_address" placeholder="EX:5,00,000.00">
                        </div>
                        <div class="form-group">
                            <label for="cheque_number"> Cheque Number</label>
                            <input type="text" class="form-control" name="cheque_number" id="cheque_number" placeholder="Cheque Number">
                        </div>
                        <div class="form-group">
                            <label for="cheque_number"> Invoice Date</label>
                            <input type="date" class="form-control" name="date" id="date">
                        </div>
                        <div class="form-group">
                            <label for="c_f_name">Customer Father's Name</label>
                            <input type="text" class="form-control" name="c_f_name" id="c_f_name" placeholder="Customer father's Name">
                        </div>
                        <div class="form-group">
                            <label for="g_name_1"> Guarantor/Dealer Name (1)</label>
                            <input type="text" class="form-control" name="g_name_1" id="g_name_1" placeholder="Guarantor/Dealer Name">
                        </div>
                        <div class="form-group">
                            <label for="g_f_name_1"> Guarantor Father's Name (1)</label>
                            <input type="text" class="form-control" name="g_f_name_1" id="g_f_name_1" placeholder="Guarantor/Dealer Father's Name">
                        </div>
                        <div class="form-group">
                            <label for="g_add_1"> Guarantor Address (1)</label>
                            <input type="text" class="form-control" name="g_add_1" id="g_add_1" placeholder="Guarantor/Dealer Address">
                        </div>
                        <div class="form-group">
                            <label for="g_name_2"> Guarantor/Dealer Name (2)</label>
                            <input type="text" class="form-control" name="g_name_2" id="g_name_2" placeholder="Guarantor/Dealer Name">
                        </div>
                        <div class="form-group">
                            <label for="g_f_name_2"> Guarantor/Dealer Father's Name (2)</label>
                            <input type="text" class="form-control" name="g_f_name_2" id="g_f_name_2" placeholder="Guarantor/Dealer Father's Name">
                        </div>
                        <div class="form-group">
                            <label for="g_add_2"> Guarantor/Dealer Address (2)</label>
                            <input type="text" class="form-control" name="g_add_2" id="g_add_2" placeholder="Guarantor/Dealer Address">
                        </div>
                        <div id='dynamicOption' style="width:100%;"></div>
                        
                        <div class="form-group">
                            <label for="sales_amount"> Sales Amount</label>
                            <input type="text" class="form-control" name="sales_amount" value="<?php echo isset($singleProduct["SALES_AMOUNT"]) ?number_format( $singleProduct["SALES_AMOUNT"], 2): ' ' ?>" id="sales_amount" placeholder="EX:10,00,000.00">
                        </div>
                        <div class="form-group">
                            <label for="down_payment"> Down Payment</label>
                            <input type="text" class="form-control" name="down_payment"value="<?php echo isset($singleProduct["DP"]) ?number_format( $singleProduct["DP"], 2): ' ' ?>" id="down_payment" placeholder="EX:5,00,000.00">
                        </div>
                        <div class="form-group">
                            <label for="lease_amount"> Lease Amount</label>
                            <input type="text" class="form-control" name="lease_amount"value="<?php echo isset($singleProduct["LEASE_AMOUNT"]) ?number_format( $singleProduct["LEASE_AMOUNT"], 2): ' ' ?>" id="down_payment" placeholder="EX:5,00,000.00">
                        </div>
                        <div class="form-group">
                            <label for="grace_period"> Grace Period</label>
                            <input type="text" class="form-control" name="grace_period" value="" id="grace_period" placeholder="EX:1/2/3">
                        </div>
                        <div class="form-group">
                            <label for="installment_amount"> Installment Amount</label>
                            <input type="text" class="form-control" name="installment_amount" value="" id="installment_amount" placeholder="EX:5,00,000.00">
                        </div>
                        <div class="form-group">
                            <label for="emi_number"> EMI Number(Count of EMI)</label>
                            <input type="text" class="form-control" name="emi_number" id="emi_number" placeholder="EX:3/4/5">
                        </div>
                        <div class="form-group">
                            <label for="emi_start_date"> EMI Start Date </label>
                            <input type="date" class="form-control" name="emi_start_date" id="emi_start_date" placeholder="emi_start_date">
                        </div>
                        <!-- <div class="form-group">
                            <label for="emi_end_date"> EMI End Date</label>
                            <input type="date" class="form-control" name="emi_end_date" id="emi_end_date" placeholder="emi_end_date">
                        </div> -->



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

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>

<script>
    $(document).ready(function () { 
        $(document).on('click','.ref_code',function(){
            var ref_code =$(this).val();
            if($(this).is(':checked')){
                let codeno =  $(this).attr('data-code-no');
                let engno =  $(this).attr('data-eng-no');
                let brandName =  $(this).attr('data-brand-name');
                let chassisno =  $(this).attr('data-chassis-no');
                var ref_length =$('.ref_code').filter(':checked').length;
                let html = `<span id="${ref_code}" style="width:100%">
                            
                            <input type="hidden"  class="form-control" name="product_brand" value="${brandName}" id="product_brand" placeholder="product brand(EX:EICHER)">
                            <input type="hidden"  class="form-control" name="product_model" value="${codeno}" id="product_model" placeholder="product brand(EX:AB-000)">
                            <div class="form-group">
                                <label for="product_chassis_no"> Product Chassis No.</label>
                                <input type="text" class="form-control" name="product_chassis_no[]" value="${chassisno}" id="product_chassis_no" placeholder="Prouduct chassis no..">
                            </div>
                            <div class="form-group">
                                <label for="product_engine_no"> Product Engine No.</label>
                                <input type="text" class="form-control" name="product_engine_no[]" value="${engno}" id="product_engine_no" placeholder="Prouduct Engine no..">
                            </div></span>`;
                $('#dynamicOption').after(html);
            }else{
                var escaped_ref_code = $.escapeSelector(ref_code);
                $('span#' + escaped_ref_code).remove();
            }
            
            $('#unit_no').val(ref_length);
        });
    });
</script>