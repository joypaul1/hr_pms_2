<?php

$dynamic_link_css[] = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js[] = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('accounts-clearance-form')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>
<script>
    function isNumberKey(txt, evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 46) {
                //Check if the text already contains the . character
                if (txt.value.indexOf('.') === -1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (charCode > 31 &&
                    (charCode < 48 || charCode > 57))
                    return false;
            }
            return true;
        }
</script>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <form id="Form2" action="" method="post"></form>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="card ">


            <?php
            $leftSideName  = 'Finance & Accounts Clearence Form';


            include('../../layouts/_tableHeader.php');

            ?>
            <form class="form-horizontal" method="post" action="<?php echo ($basePath . '/form_module/action/finance_accounts_clearance.php') ?>">
                <!-- <div class="card-body row">
                    <div class="card">
                        <div class="card-body row">

                            <div class="col-sm-4">
                                <label for="emp_id"> <strong>Select Employee By Search ID <span class="text-danger">*</span></strong> </label>
                                <input required class="form-control cust-control" id="autocomplete" name="emp_rml_id" type="text" />
                                  <input required class="form-control " id="emp_id" name="emp_id" type="hidden" hidden />
                                <div class="text-info" id="message"></div>
                              

                            </div>
                            <div class="col-sm-8">
                                <span class="w-100" id="userInfo"></span>
                            </div>
                        </div>
                    </div>


                </div> -->
                <input required  value="<?php echo $_GET['rml_hr_apps_user_id'] ?>"  name="emp_id" type="hidden" hidden />

                <strong class="d-block text-center">[Please Fill-Up Bellow Form Data]</strong>
                <hr>
                <div class=" showDepartment" style="display:nones;">

                    <div class="d-flex flex-column ">

                        <div class="" style="overflow-x: auto;overflow-y: auto;">
                            <div class="card">
                                <div class="d-flex flex-row align-items-center text-center  font-weight-bold ">
                                    <div class="col-2   align-items-center">
                                        <!-- <b class="text-uppercase"> IOU</b>
                                        <input type="hidden" name="data_type[]" value="iou"> -->
                                    </div>

                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" for="basic-default-company">Min. months req. for full for ownership</label>

                                    </div>

                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" for="basic-default-company">Company Portion</label>

                                    </div>
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" for="basic-default-company">Employee Portion</label>

                                    </div>
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" for="basic-default-company">Paid By Company</label>

                                    </div>
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" for="basic-default-company">Paid By Employee</label>

                                    </div>
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" for="basic-default-company">Due From Employee</label>

                                    </div>
                                    <!-- <div class="col-3">
                                        <label class="col-form-label font-weight-bold" for="basic-default-company">Due From emp(Company + Employee)</label>

                                    </div> -->
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" for="basic-default-company">Note/Remarks</label>

                                    </div>

                                </div>
                                <div class="d-flex flex-row align-items-center mt-2 mb-3">
                                    <div class="col-2  text-center align-items-center">
                                        <b class="text-uppercase"> IOU</b>
                                        <input type="hidden" name="data_type[]" value="iou">
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="iou_min_months_req" value="NA" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="iou_company_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="iou_employee_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="iou_paid_by_company" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="iou_paid_by_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="iou_due_from_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <!-- <div class="col-3">
                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="iou_due_from_employee_company"  value="" />
                                    </div> -->
                                    <div class="col-3">
                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="remarks[]" value="" />
                                    </div>

                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="col-2  align-items-center">
                                        <b class="text-uppercase"> Salary Loan</b>
                                        <input type="hidden" name="data_type[]" value="salary_loan">
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="salary_loan_min_months_req" value="NA" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="salary_loan_company_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="salary_loan_employee_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="salary_loan_paid_by_company" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="salary_loan_paid_by_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="salary_loan_due_from_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="remarks[]" value="" />
                                    </div>

                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="col-2 text-center mt-4  align-items-center">
                                        <b class="text-uppercase"> Mobile</b>
                                        <input type="hidden" name="data_type[]" value="mobile">
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="mobile_min_months_req" value="06 months" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="mobile_company_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="mobile_employee_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="mobile_paid_by_company" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="mobile_paid_by_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="mobile_due_from_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <!-- <div class="col-3">
                                       
                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="mobile_due_from_employee_company"  onkeypress="return isNumberKey(this, event);" value="" />
                                    </div> -->
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="remarks[]" value="" />
                                    </div>

                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="col-2 text-center mt-4 align-items-center">
                                        <b class="text-uppercase"> Bike</b>
                                        <input type="hidden" name="data_type[]" value="bike">
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="bike_min_months_req" value="36 months" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="bike_company_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="bike_employee_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="bike_paid_by_company" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="bike_paid_by_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="bike_due_from_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <!-- <div class="col-3">
                                       
                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="bike_due_from_employee_company" value="" />
                                    </div> -->
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="remarks[]" value="" />
                                    </div>

                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="col-2 text-center mt-4  align-items-center">
                                        <b class="text-uppercase"> Laptop</b>
                                        <input type="hidden" name="data_type[]" value="laptop">
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="laptop_min_months_req" value="24 months" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="laptop_company_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="laptop_employee_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="laptop_paid_by_company" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="laptop_paid_by_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="laptop_due_from_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <!-- <div class="col-3">
                                       
                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="laptop_due_from_employee_company" value="" />
                                    </div> -->
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="remarks[]" value="" />
                                    </div>

                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="col-2 text-center mt-4 align-items-center">
                                        <b class="text-uppercase"> Car</b>
                                        <input type="hidden" name="data_type[]" value="car">
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="car_min_months_req" value="60 months" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="car_company_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="car_employee_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="car_paid_by_company" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="car_paid_by_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="car_due_from_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <!-- <div class="col-3">
                                       
                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="car_due_from_employee_company" value="" />
                                    </div> -->
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="remarks[]" value="" />
                                    </div>

                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="col-2 text-center mt-4  align-items-center">
                                        <b class="text-uppercase"> Petty Cash</b>
                                        <input type="hidden" name="data_type[]" value="petty_cash">
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="petty_cash_min_months_req" value="NA" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="petty_cash_company_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="petty_cash_employee_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="petty_cash_paid_by_company" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="petty_cash_paid_by_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="petty_cash_due_from_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <!-- <div class="col-3">
                                       
                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="petty_cash_due_from_employee_company" value="" />
                                    </div> -->
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="remarks[]" value="" />
                                    </div>

                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="col-2 text-center mt-4 align-items-center">
                                        <b class="text-uppercase"> Others</b>
                                        <input type="hidden" name="data_type[]" value="others">
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="others_min_months_req" value="" />
                                    </div>

                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="others_company_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="others_employee_portion" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="others_paid_by_company" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="others_paid_by_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="others_due_from_employee" onkeypress="return isNumberKey(this, event);" value="" />
                                    </div>
                                    <!-- <div class="col-3">
                                       
                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="others_due_from_employee_company" value="" />
                                    </div> -->
                                    <div class="col-3">

                                        <input type="text" class="form-control cust-control" id="basic-default-company" name="remarks[]" value="" />
                                    </div>

                                </div>


                            </div>

                        </div>





                    </div>
                    <div class="mt-3 mb-5 w-25 mx-auto">
                        <button class="form-control btn btn-sm btn-primary" type="submit">Submit </button>
                    </div>


                </div>
            </form>




        </div>


    </div>





</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>
<script>
    $(function() {
        function isNumberKey(txt, evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 46) {
                //Check if the text already contains the . character
                if (txt.value.indexOf('.') === -1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (charCode > 31 &&
                    (charCode < 48 || charCode > 57))
                    return false;
            }
            return true;
        }

        $("#autocomplete").autocomplete({

            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo ($basePath . '/offboarding_module/action/hr_panel.php'); ?>",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        actionType: 'searchUser',
                        search: request.term
                    },
                    beforeSend: function() {
                        $("#userInfo").empty();
                        $("#emp_id").val(null);
                        // showDepartment();
                        showPleaseWaitMessage();

                    },
                    success: function(data) {
                        hidePleaseWaitMessage();
                        // Process the response data here
                        response($.map(data, function(item) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,
                                concern: item.concern,
                                empData: item
                            };
                        }));
                    },
                    error: function(data) {
                        console.log(data)
                        hidePleaseWaitMessage();
                    }
                });
            },
            select: function(event, ui) {

                // Set selection
                $('#autocomplete').val(ui.item.label); // display the selected text
                $('#emp_id').val(ui.item.id); // save selected id to input
                // $('#concern_name').val(ui.item.concern); // save selected id to input
                userInfo(ui.item.empData.data);
                // showDepartment();
                // buttonValidation();
                return false;
            },
            focus: function(event, ui) {
                // $("#autocomplete").val(ui.item.label);
                // $("#emp_id").val(ui.item.id);
                // $("#concern_name").val(ui.item.concern);
                // buttonValidation();
                // showDepartment();
                return false;
            },
        });

        // Function to display the "Please wait" message
        function showDepartment() {
            if ($('#emp_id').val()) {
                $('.showDepartment').css('display', 'block');
            } else {
                $('.showDepartment').css('display', 'none')

            }

        }

        // Function to display the "Please wait" message
        function showPleaseWaitMessage() {
            $('#message').text('Please wait for searching...');
        }

        // Function to hide the "Please wait" message
        function hidePleaseWaitMessage() {
            $('#message').empty();
        }

        function userInfo(info) {

            // let basePath = "/rHRT";
            let html = `<div class="justify-content-center">
            <div class="card p-3">
                <div class="d-flex  text-center">
                    <div class="w-100">
                      
                        <div class="p-2  bg-primary d-flex justify-content-between rounded text-white stats">
                            <div class="d-flex flex-column">
                                <span class="articles">Name </span>
                                <span class="number1">${info.EMP_NAME}</span>

                            </div>
                            <div class="d-flex flex-column">
                                <span class="articles">ID</span>
                                <span class="number1">${info.RML_ID}</span>

                            </div>
                            <div class="d-flex flex-column">
                                <span class="followers">Concern</span>
                                <span class="number2">${info.R_CONCERN}</span>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="rating">Department</span>
                                <span class="number3">${info.DEPT_NAME}</span>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="rating">Designation</span>
                                <span class="number3">${info.DESIGNATION}</span>
                            </div>
                           
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>`;

            $("#userInfo").append(html);
        }


        $(document).on('change', '#autocomplete', function() {
            showDepartment();
            // buttonValidation();
        });

        // $(document).on('change', '#last_working_day', function() {

        //     buttonValidation();
        // });
        // $(document).on('change', '#resignation_date', function() {

        //     buttonValidation();
        // });
        // $(document).on('input', '#reason_of_resignation', function() {

        //     buttonValidation();
        // });

        // function buttonValidation() {

        //     if ($("#emp_id").val() && $("#last_working_day").val() && $("#resignation_date").val() && $("#reason_of_resignation").val()) {
        //         $("button[type='submit']").prop('disabled', false);

        //     } else {
        //         $("button[type='submit']").prop('disabled', true);
        //     }
        // }





    });
</script>