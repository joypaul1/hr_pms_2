<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
// if (!checkPermission('concern-offboarding-create')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$v_key          = $_REQUEST['key'];
$v_emp_id       = $_REQUEST['emp_id'];
$v_emp_table_id = $_REQUEST['tab_id'];
$strSQL         = oci_parse(
    $objConnect,
    "select RML_ID,
								EMPLOYEE_NAME EMP_NAME,
								COMPANY_NAME R_CONCERN,
								DEPARTMENT DEPT_NAME,
								WORKSTATION BRANCH_NAME,
								DESIGNATION,
								BRAND EMP_GROUP,
								COLL_HR_EMP_NAME((SELECT aa.LINE_MANAGER_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)LINE_MANAGER_1_NAME,
								COLL_HR_EMP_NAME((SELECT aa.DEPT_HEAD_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)LINE_MANAGER_2_NAME
	from empinfo_view_api@ERP_PAYROLL bb where RML_ID='$v_emp_id'"
);

oci_execute($strSQL);
$row = oci_fetch_assoc($strSQL);
print_r($row);
die();
// approval status
$LINE_MANAGER_1_STATUS = '';
$strSQLsss             = oci_parse(
    $objConnect,
    "select LINE_MANAGER_1_STATUS from HR_PMS_EMP where ID=$v_emp_table_id "
);

oci_execute($strSQLsss);
while ($rowrr = oci_fetch_assoc($strSQLsss)) {
    $v_line_manager_status = $rowrr['LINE_MANAGER_1_STATUS'];
}

?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- form store request  -->
    <form id="Form1" action="" method="post"></form>
    <form id="Form2" action="" method="post"></form>
    <form id="Form3" action="" method="post"></form>
    <!-- form store request  -->


    <div class="card">
        <div class="row card-body">
            <div class="col-lg-12">
                <form id="Form1" action="" method="post"></form>
                <form id="Form2" action="" method="post"></form>

                <?php
                while ($row = oci_fetch_assoc($strSQL)) {
                    ?>

                    <div class="row">
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">Employee ID:</label>
                            <input name="emp_id" readonly form="Form1" placeholder="EMP-ID" class="form-control cust-control" type='text'
                                value='<?php echo $row['RML_ID']; ?>' />
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">Employee Name:</label>
                            <input required="" name="emp_name" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                value='<?php echo $row['EMP_NAME']; ?>' />
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">Employee Designation:</label>
                            <input required="" name="emp_name" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                value='<?php echo $row['DESIGNATION']; ?>' />
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">Employee Department:</label>
                            <input required="" name="emp_name" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                value='<?php echo $row['DEPT_NAME']; ?>' />
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">PMS Line Manager-1:</label>
                            <input class="form-control cust-control" required="" readonly type='text'
                                value='<?php echo $row['LINE_MANAGER_1_NAME']; ?>' />
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">PMS Line Manager-2:</label>
                            <input required="" required="" class="form-control cust-control" readonly type='text'
                                value='<?php echo $row['LINE_MANAGER_2_NAME']; ?>' />
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">Employee Group:</label>
                            <input required="" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                value='<?php echo $row['EMP_GROUP']; ?>' />
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">Employee Branch:</label>
                            <input required="" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                value='<?php echo $row['BRANCH_NAME']; ?>' />
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-3">
                            <label for="exampleInputEmail1">Select PMS Title:</label>
                            <select required="" name="pms_title_id" form="Form1" class="form-control cust-control">
                                <option selected value="">--</option>
                                <?php

                                $strSQL = oci_parse($objConnect, "select ID,PMS_NAME from HR_PMS_LIST where is_active=1");
                                oci_execute($strSQL);
                                while ($row = oci_fetch_assoc($strSQL)) {
                                    ?>

                                    <option value="<?php echo $row['ID']; ?>">
                                        <?php echo $row['PMS_NAME']; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6"></div>
                        <div class="col-sm-3">
                            <div class="md-form mt-3">
                                <input class="form-control  btn  btn-sm  btn-primary" type="submit" form="Form1" value="Create PMS Profile">
                            </div>
                        </div>

                    </div>

                    <?php
                }
                ?>


            </div>


        </div>
    </div>


    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>Waiting For Approval</b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">PMS Title Info.</th>
                            <th scope="col">Employe Info.</th>
                            <th scope="col">Submitted Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                   

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