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

$strSQL = oci_parse(
    $objConnect,
    "select RML_ID,
EMPLOYEE_NAME EMP_NAME,
COMPANY_NAME R_CONCERN,
DEPARTMENT DEPT_NAME,
WORKSTATION BRANCH_NAME,
DESIGNATION,
BRAND EMP_GROUP,
COLL_HR_EMP_NAME((SELECT aa.LINE_MANAGER_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)) LINE_MANAGER_1_NAME,
COLL_HR_EMP_NAME((SELECT aa.DEPT_HEAD_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)) LINE_MANAGER_2_NAME
from empinfo_view_api@ERP_PAYROLL bb where BB.RML_ID='$v_emp_id'"
);
oci_execute($strSQL);

$HR_STATUS = '';
$strSQLsss             = oci_parse(
    $objConnect,
    "select HR_STATUS from HR_PMS_EMP where ID=$v_emp_table_id "
);

oci_execute($strSQLsss);
while ($rowrr = oci_fetch_assoc($strSQLsss)) {
    $v_line_manager_status = $rowrr['HR_STATUS'];
}

?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="card">
        <div class="row card-body">
            <form action="<?php echo $basePath.'/pms_module/action/hr_panel.php'?>" method="post">
            <input type="hidden" name="actionType" value="pms_approved_denied">
            <input type="hidden" name="hr_pms_pms_emp_table_id" value="<?php echo $v_emp_table_id?>">
                <div class="">
                    <?php
                    while ($row = oci_fetch_assoc($strSQL)) {
                        ?>

                        <div class="row">
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Employee ID:</label>
                                <input name="emp_id" readonly  placeholder="EMP-ID" class="form-control cust-control" type='text'
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
                                <input required="" name="emp_dep" readonly placeholder="EMP dep" class="form-control cust-control" type='text'
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

                        <?php
                        if ($v_line_manager_status == "") {
                            ?>
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="basic-default-fullname">Remarks</label>
                                    <input required="" name="remarks"  placeholder="Approval Or Denied Remarks" class="form-control cust-control"
                                        type="text">
                                </div>
                                <div class="col-sm-3">

                                    <label class="form-label" for="basic-default-fullname">Select Type</label>
                                    <select name="app_status" class="form-control cust-control"  required="">
                                        <option selected="" value="">---</option>
                                        <option value="1">Approve</option>
                                        <option value="0">Denied</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <div class="md-form">
                                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                                        <input class="form-control btn btn-primary cust-control" type="submit"  value="Submit">
                                    </div>
                                </div>

                            </div>

                            <?php
                        }
                    }
                    ?>


                </div>

            </form>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>
                <?php echo $_GET['emp_id'] ?> For PMS Details
            </b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered" border="1" cellspacing="0" cellpadding="0">
                    <thead style="background: beige;">
                        <tr class="text-center">
                            <th class="">Sl <br>No</th>
                            <th scope="col">KRA(Key Result Areas)<br>KRA</th>
                            <th scope="col">KPI (Key Performance indicators)<br>KPI</th>
                            <th scope="col">Weightage (%) <br>(Range of 5-30)</th>
                            <th scope="col">Target</th>
                            <th scope="col">Remarks</th>
                        </tr>
                    </thead>


                    <tbody>
                        <tr>
                            <?php
                            $strSQL = oci_parse(
                                $objConnect,
                                "select KRA_NAME,ID
							        FROM HR_PMS_KRA_LIST WHERE CREATED_BY='$v_emp_id' AND HR_PMS_LIST_ID='$v_key' ORDER BY ID"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $table_ID = $row['ID'];
                                $number++;
                                ?>

                                <td class="align-middle">
                                    <?php echo $number; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['KRA_NAME']; ?>
                                </td>
                                <td class="align-middle">
                                    <table width="100%">
                                        <?php

                                        $slNumber    = 0;
                                        $strSQLInner = oci_parse($objConnect, "select KPI_NAME from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $slNumber++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $slNumber . '. ' . $rowIN['KPI_NAME']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td class="align-middle">
                                    <table width="100%">
                                        <?php

                                        $strSQLInner = oci_parse($objConnect, "select WEIGHTAGE from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <?php echo $rowIN['WEIGHTAGE']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td class="align-middle">
                                    <table width="100%">
                                        <?php
                                        $strSQLInner = oci_parse($objConnect, "select TARGET from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            ?>
                                            <tr>

                                                <td class="align-middle">
                                                    <?php echo $rowIN['TARGET']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td class="align-middle">
                                    <table width="100%">
                                        <?php
                                        $slNumberR   = 0;
                                        $strSQLInner = oci_parse($objConnect, "select REMARKS from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID ORDER BY ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $slNumberR++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $slNumberR . '. ' . $rowIN['REMARKS']; ?>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
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