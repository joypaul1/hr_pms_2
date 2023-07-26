<?php
$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');

if (!checkPermission('self-leave-create')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>

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
                <div class="card-body row">
                    <div class="card">
                        <div class="card-body row">

                            <div class="col-sm-4">
                                <label for="emp_id"> <strong>Select Employee By Search ID <span class="text-danger">*</span></strong> </label>
                                <input required class="form-control cust-control" id="autocomplete" name="emp_rml_id" type="text" />
                                <div class="text-info" id="message"></div>
                                <input required class="form-control " id="emp_id" name="emp_id" type="hidden" hidden />
                                <!-- <input required class="form-control " id="concern_name" name="concern_name" type="hidden" hidden /> -->

                            </div>
                            <div class="col-sm-8">
                                <span class="w-100" id="userInfo"></span>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="card-body  showDepartment" style="display:none;">

                    <div class="row">
                        <strong class="text-center">[Please Fill-Up Bellow Form Data]</strong>
                        <hr>
                        <div class="col-4 mb-2">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card card-title d-flex align-items-center justify-content-center p-1">
                                        <b class="text-uppercase"> IOU</b>
                                        <input type="hidden" name="data_type" value="iou">
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Avail date (DV date)</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="iou_avail_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Resign date</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="iou_resign_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Month in service (3-4)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_month_in_service" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Min. months req. for full for ownership</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_min_months_req" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Eligible for ownership (Y=5>6),(N=5<6)< /label>
                                                <input type="text" class="form-control" id="basic-default-company" name="iou_eligible_for_ownership" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Amount (invl int. if any)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_amount_include" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Company Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_company_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Employee Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_employee_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Company</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_paid_by_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_paid_by_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_due_from_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From emp(Company + Employee)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="iou_due_from_employee_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Note/Remarks</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="remarks" value="" />
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-4 mb-2">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card card-title d-flex align-items-center justify-content-center p-1">
                                        <b class="text-uppercase"> Salary Loan</b>
                                        <input type="hidden" name="data_type" value="salary_loan">
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Avail date (DV date)</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="salary_loan_avail_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Resign date</label>
                                        <input type="date" class="form-control" id="basic-d</label>efault-company" name="salary_loan_resign_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Month in service (3-4)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_month_in_service" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Min. months req. for full for ownership</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_min_months_req" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Eligible for ownership (Y=5>6),(N=5<6)< /label>
                                                <input type="text" class="form-control" id="basic-default-company" name="salary_loan_eligible_for_ownership" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Amount (invl int. if any)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_amount_include" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Company Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_company_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Employee Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_employee_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Company</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_paid_by_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_paid_by_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_due_from_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From emp(Company + Employee)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="salary_loan_due_from_employee_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Note/Remarks</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="remarks" value="" />
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-4 mb-2">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card card-title d-flex align-items-center justify-content-center p-1">
                                        <b class="text-uppercase"> Mobile</b>
                                        <input type="hidden" name="data_type" value="mobile">
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Avail date (DV date)</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="mobile_avail_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Resign date</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="mobile_resign_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Month in service (3-4)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_month_in_service" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Min. months req. for full for ownership</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_min_months_req" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Eligible for ownership (Y=5>6),(N=5<6)< /label>
                                                <input type="text" class="form-control" id="basic-default-company" name="mobile_eligible_for_ownership" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Amount (invl int. if any)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_amount_include" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Company Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_company_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Employee Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_employee_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Company</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_paid_by_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_paid_by_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_due_from_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From emp(Company + Employee)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="mobile_due_from_employee_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Note/Remarks</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="remarks" value="" />
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-4 mb-2">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card card-title d-flex align-items-center justify-content-center p-1">
                                        <b class="text-uppercase"> Bike</b>
                                        <input type="hidden" name="data_type" value="bike">
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Avail date (DV date)</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="bike_avail_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Resign date</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="bike_resign_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Month in service (3-4)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_month_in_service" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Min. months req. for full for ownership</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_min_months_req" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Eligible for ownership (Y=5>6),(N=5<6)< /label>
                                                <input type="text" class="form-control" id="basic-default-company" name="bike_eligible_for_ownership" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Amount (invl int. if any)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_amount_include" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Company Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_company_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Employee Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_employee_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Company</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_paid_by_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_paid_by_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_due_from_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From emp(Company + Employee)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="bike_due_from_employee_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Note/Remarks</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="remarks" value="" />
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="col-4 mb-2">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card card-title d-flex align-items-center justify-content-center p-1">
                                        <b class="text-uppercase"> Laptop</b>
                                        <input type="hidden" name="data_type" value="laptop">
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Avail date (DV date)</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="laptop_avail_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Resign date</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="laptop_resign_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Month in service (3-4)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_month_in_service" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Min. months req. for full for ownership</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_min_months_req" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Eligible for ownership (Y=5>6),(N=5<6) </label>
                                                <input type="text" class="form-control" id="basic-default-company" name="laptop_eligible_for_ownership" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Amount (invl int. if any)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_amount_include" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Company Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_company_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Employee Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_employee_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Company</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_paid_by_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_paid_by_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_due_from_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From emp(Company + Employee)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="laptop_due_from_employee_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Note/Remarks</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="remarks" value="" />
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-4 mb-2">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card card-title d-flex align-items-center justify-content-center p-1">
                                        <b class="text-uppercase"> Car</b>
                                        <input type="hidden" name="data_type" value="car">
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Avail date (DV date)</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="car_avail_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Resign date</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="car_resign_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Month in service (3-4)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_month_in_service" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Min. months req. for full for ownership</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_min_months_req" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Eligible for ownership (Y=5>6),(N=5<6) </label>
                                                <input type="text" class="form-control" id="basic-default-company" name="car_eligible_for_ownership" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Amount (invl int. if any)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_amount_include" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Company Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_company_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Employee Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_employee_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Company</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_paid_by_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_paid_by_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_due_from_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From emp(Company + Employee)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="car_due_from_employee_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Note/Remarks</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="remarks" value="" />
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-4 mb-2">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card card-title d-flex align-items-center justify-content-center p-1">
                                        <b class="text-uppercase"> petty Cash</b>
                                        <input type="hidden" name="data_type" value="car">
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Avail date (DV date)</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="petty_cash_avail_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Resign date</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="petty_cash_resign_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Month in service (3-4)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_month_in_service" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Min. months req. for full for ownership</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_min_months_req" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Eligible for ownership (Y=5>6),(N=5<6) </label>
                                                <input type="text" class="form-control" id="basic-default-company" name="petty_cash_eligible_for_ownership" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Amount (invl int. if any)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_amount_include" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Company Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_company_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Employee Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_employee_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Company</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_paid_by_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_paid_by_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_due_from_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From emp(Company + Employee)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="petty_cash_due_from_employee_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Note/Remarks</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="remarks" value="" />
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-4 mb-2">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card card-title d-flex align-items-center justify-content-center p-1">
                                        <b class="text-uppercase"> Others</b>
                                        <input type="hidden" name="data_type" value="car">
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Avail date (DV date)</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="others_avail_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Resign date</label>
                                        <input type="date" class="form-control" id="basic-default-company" name="others_resign_date" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Month in service (3-4)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_month_in_service" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Min. months req. for full for ownership</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_min_months_req" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Eligible for ownership (Y=5>6),(N=5<6) </label>
                                                <input type="text" class="form-control" id="basic-default-company" name="others_eligible_for_ownership" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Amount (invl int. if any)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_amount_include" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Company Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_company_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Employee Portion</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_employee_portion" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Company</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_paid_by_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Paid By Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_paid_by_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From Employee</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_due_from_employee" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Due From emp(Company + Employee)</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="others_due_from_employee_company" value="" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="col-form-label" for="basic-default-company">Note/Remarks</label>
                                        <input type="text" class="form-control" id="basic-default-company" name="remarks" value="" />
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="mt-2 w-25 mx-auto">
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
                showDepartment();
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

            let basePath = "/rHRT";
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