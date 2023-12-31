<?php
$dynamic_link_css[] = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js[] = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('hr-offboarding-id-assign-list')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card col-lg-12">
        <form action="" method="post">
            <div class="card-body row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                        <input required="" placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' >
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card col-lg-12 mt-2">
        <?php
        $leftSideName  = 'ID Assign List';
        if (checkPermission('hr-offboarding-id-assign-create')) {
            $rightSideName = 'ID Assign Create';
            $routePath     = 'offboarding_module/view/hr_panel/id_assign.php';
        }

        include('../../../layouts/_tableHeader.php');
        ?>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">EMP Info</th>
                            <th scope="col">Respondible Information</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['emp_id'])) {

                            $v_emp_id = $_REQUEST['emp_id'];

                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT B.EMP_NAME,
								       b.RML_ID,
									   B.DEPT_NAME,
									   B.DESIGNATION,
									   B.R_CONCERN EMP_CONCERN,
									   A.R_CONCERN RESPONSIBLE_CONCERN,
									   (SELECT DEPT_NAME FROM RML_HR_DEPARTMENT WHERE ID=A.RML_HR_DEPARTMENT_ID) RESPONSIBLE_DEPT
								FROM HR_DEPT_CLEARENCE_CONCERN A,RML_HR_APPS_USER B
								WHERE A.RML_HR_APPS_USER_ID=B.ID
								AND b.RML_ID='$v_emp_id'"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                               <tr>
                                    <td>
                                         <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php
                                        echo $row['RML_ID'];
                                        echo '</br>';
                                        echo $row['EMP_NAME'];
                                        echo '</br>';
                                        echo $row['DEPT_NAME'] . '=>' . $row['EMP_CONCERN'];
                                        echo '</br>';
                                        echo $row['DESIGNATION'];
                                        ?>
                                    </td>
                                    <td><?php
                                        echo $row['RESPONSIBLE_CONCERN'];
                                        echo '</br>';
                                        echo $row['RESPONSIBLE_DEPT'];
                                        ?>
                                    </td>
                                </tr>


                            <?php
                            }
                        } else {


                            $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT B.EMP_NAME,
								       b.RML_ID,
									   B.DEPT_NAME,
									   B.DESIGNATION,
									   B.R_CONCERN EMP_CONCERN,
									   A.R_CONCERN RESPONSIBLE_CONCERN,
									   (SELECT DEPT_NAME FROM RML_HR_DEPARTMENT WHERE ID=A.RML_HR_DEPARTMENT_ID) RESPONSIBLE_DEPT
								FROM HR_DEPT_CLEARENCE_CONCERN A,RML_HR_APPS_USER B
								WHERE A.RML_HR_APPS_USER_ID=B.ID"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                            ?>
                                <tr>
                                    <td>
                                         <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php
                                        echo $row['RML_ID'];
                                        echo '</br>';
                                        echo $row['EMP_NAME'];
                                        echo '</br>';
                                        echo $row['DEPT_NAME'] . '=>' . $row['EMP_CONCERN'];
                                        echo '</br>';
                                        echo $row['DESIGNATION'];
                                        ?>
                                    </td>
                                    <td><?php
                                        echo $row['RESPONSIBLE_CONCERN'];
                                        echo '</br>';
                                        echo $row['RESPONSIBLE_DEPT'];
                                        ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
