<?php

$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('accounts-clearance-form')) {
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
                                    <th>Cus. Name</th>
                                    <th>Cus. Mobile</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"])  == 'searchData') {
                                    $invoice_id = trim($_POST["invoice_id"]);

                                    $deedSQL = oci_parse($objConnect, "SELECT REF_CODE,CUSTOMER_NAME,CUSTOMER_MOBILE_NO  FROM LEASE_ALL_INFO_ERP WHERE DOCNUMBR = :invoice_id");
                                    oci_bind_by_name($deedSQL, ":invoice_id", $invoice_id);
                                    oci_execute($deedSQL);
                                    // REF_CODE != '' AND 
                                    if ($row = oci_fetch_assoc($deedSQL)) {
                                        do {
                                            echo '<tr>
                                        <td><input type="checkbox" class="form-check-input" value="' . $row['REF_CODE'] . '" name="reference_id[]" id="' . $row['REF_CODE'] . '">
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '">' . $row['REF_CODE'] . '</label></td>
                                        <td>
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '"> ' . $row['CUSTOMER_NAME'] . '</label>
                                        </td>
                                        <td>
                                        <label class="form-check-label" for="' . $row['REF_CODE'] . '"> ' . $row['CUSTOMER_MOBILE_NO'] . '</label>
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

                <div class="col-md-5">
                    <div style="border: 1px solid #eee5e5;padding: 2%; margin: 1%">
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
                        <div class="form-group">
                            <label for="product_model"> Product Model</label>
                            <input type="text" class="form-control" name="product_model" id="product_model" placeholder="product model(EX:AB-000)">
                        </div>
                        <div class="form-group">
                            <label for="sales_amount"> Sales Amount</label>
                            <input type="text" class="form-control" name="sales_amount" id="sales_amount" placeholder="EX:10,00,000.00">
                        </div>
                        <div class="form-group">
                            <label for="down_payment"> Down Payment</label>
                            <input type="text" class="form-control" name="down_payment" id="down_payment" placeholder="EX:5,00,000.00">
                        </div>
                        <div class="form-group">
                            <label for="emi_number"> EMI(instalments) Number</label>
                            <input type="text" class="form-control" name="emi_number" id="emi_number" placeholder="EX:3/4/5">
                        </div>
                        <div class="form-group">
                            <label for="emi_start_date"> EMI Start Date</label>
                            <input type="date" class="form-control" name="emi_start_date" id="emi_start_date" placeholder="emi_start_date">
                        </div>
                        <div class="form-group">
                            <label for="emi_end_date"> EMI End Date</label>
                            <input type="date" class="form-control" name="emi_end_date" id="emi_end_date" placeholder="emi_end_date">
                        </div>



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
    function seeStatus(id) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "<?php echo $basePath . "/offboarding_module/action/hr_panel.php"; ?>",
            data: {
                rml_emp_id: id,
                'actionType': 'approvalStatus'
            },
            success: function(data) {
                $('#statusModal').modal('show');
                $('.modal-body').empty('');
                $('.modal-body').append(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>