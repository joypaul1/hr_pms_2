<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
if (!checkPermission('hr-offboarding-report')) {
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
                        <input required="" placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' />
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


    <!-- Bordered Table -->
    <div class="card mt-2">

        <?php
        $leftSideName  = 'Offboarding List';
        if (checkPermission('hr-offboarding-create')) {
            $rightSideName = 'Offboarding Create';
            $routePath     = 'offboarding_module/view/hr_panel/create.php';
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
                            <th scope="col">Approval Status</th>
                            <th scope="col">Exit Interview Status</th>
                            <th scope="col">Created Info</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['emp_id'])) {

                            $v_emp_id = $_REQUEST['emp_id'];

                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT A.ID,
									   B.EMP_NAME,
									   B.RML_ID,
									   B.R_CONCERN,
									   B.DEPT_NAME,
									   B.DESIGNATION,
									   RML_HR_APPS_USER_ID,
									   APPROVAL_STATUS,
									   EXIT_INTERVIEW_STATUS,
									   EXIT_INTERVIEW_DATE,
									   EXIT_INTERVIEW_BY,
									   CREATED_DATE,
									   CREATED_BY
								  FROM EMP_CLEARENCE A,RML_HR_APPS_USER B
								  WHERE A.RML_HR_APPS_USER_ID=B.ID
								  AND B.RML_ID='$v_emp_id'"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php
                                        echo $row['RML_ID'];
                                        echo '</br>';
                                        echo $row['EMP_NAME'];
                                        echo '</br>';
                                        echo $row['DEPT_NAME'] . '=>' . $row['R_CONCERN'];
                                        echo '</br>';
                                        echo $row['DESIGNATION'];
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($row['APPROVAL_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['APPROVAL_STATUS'] == '0') {
                                            echo 'Denied';
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($row['EXIT_INTERVIEW_STATUS'] == '1') {
                                            echo 'Approved';
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_DATE'];
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_BY'];
                                        } else if ($row['EXIT_INTERVIEW_STATUS'] == '0') {
                                            echo 'Denied';
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_DATE'];
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_BY'];
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        echo $row['CREATED_DATE'];
                                        echo '</br>';
                                        echo $row['CREATED_BY'];
                                        ?>
                                    </td>
                                </tr>


                            <?php
                            }
                        } else {


                            $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT A.ID,
										   B.EMP_NAME,
										   B.RML_ID,
										   B.R_CONCERN,
										   B.DEPT_NAME,
										   B.DESIGNATION,
										   RML_HR_APPS_USER_ID,
										   APPROVAL_STATUS,
										   EXIT_INTERVIEW_STATUS,
										   EXIT_INTERVIEW_DATE,
										   EXIT_INTERVIEW_BY,
										   CREATED_DATE,
										   CREATED_BY
									  FROM EMP_CLEARENCE A,RML_HR_APPS_USER B
									  WHERE A.RML_HR_APPS_USER_ID=B.ID"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                            ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php
                                        echo $row['RML_ID'];
                                        echo '</br>';
                                        echo $row['EMP_NAME'];
                                        echo '</br>';
                                        echo $row['DEPT_NAME'] . '=>' . $row['R_CONCERN'];
                                        echo '</br>';
                                        echo $row['DESIGNATION'];
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($row['APPROVAL_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['APPROVAL_STATUS'] == '0') {
                                            echo 'Denied';
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($row['EXIT_INTERVIEW_STATUS'] == '1') {
                                            echo 'Approved';
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_DATE'];
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_BY'];
                                        } else if ($row['EXIT_INTERVIEW_STATUS'] == '0') {
                                            echo 'Denied';
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_DATE'];
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_BY'];
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        echo $row['CREATED_DATE'];
                                        echo '</br>';
                                        echo $row['CREATED_BY'];
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
    <!--/ Bordered Table -->



</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>