<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('concern-offboarding-report')) {

    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

echo $emp_session_id ;

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
                            <th scope="col">HOD Status</th>
                            <th scope="col">Department Approval Status</th>
                            <th scope="col">Exit Interview Status</th>
                            <th scope="col">Accounts Clearnence Form</th>
                            <th scope="col">Created Info</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['emp_id'])) {

                            $v_emp_id = $_REQUEST['emp_id'];


                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT 
                                    A.ID,
                                    B.EMP_NAME,
                                    B.RML_ID,
                                    B.R_CONCERN,
                                    B.DEPT_NAME,
                                    B.DESIGNATION,
                                    A.APPROVAL_STATUS,
                                    A.HOD_STATUS,
                                    A.EXIT_INTERVIEW_STATUS,
                                    A.EXIT_INTERVIEW_DATE,
                                    A.EXIT_INTERVIEW_BY,
                                    A.CREATED_DATE,
                                    A.CREATED_BY,
                                    A.LAST_WORKING_DATE,
                                    A.RESIGNATION_DATE,
                                    A.REASON
                                FROM 
                                    EMP_CLEARENCE A
                                INNER JOIN 
                                    RML_HR_APPS_USER B ON A.RML_HR_APPS_USER_ID = B.ID
                                WHERE A.CREATED_BY='$emp_session_id' AND B.RML_ID='$v_emp_id' "
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {

                                $number++;
                        ?>
                                <tr style="text-align: center;">
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
                                    <td>
                                        <?php
                                        $singledataOFAccClear = oci_parse($objConnect, "SELECT * FROM ACCOUNTS_CLEARENCE_FORMS WHERE EMP_CLEARENCE_ID =" . $row['ID'] . " FETCH FIRST 1 ROWS ONLY");
                                        oci_execute($singledataOFAccClear);
                                        $clearenceFormFata = oci_fetch_assoc($singledataOFAccClear);


                                        if ($clearenceFormFata) {
                                            echo "Done";
                                        } else {
                                            echo "Pending";
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        echo 'Created:' . $row['CREATED_DATE'];
                                        echo '</br>';
                                        echo 'Created By' . $row['CREATED_BY'];
                                        ?>
                                    </td>
                                </tr>


                            <?php
                            }
                        } else {

                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT 
                                A.ID,
                                B.EMP_NAME,
                                B.RML_ID,
                                B.R_CONCERN,
                                B.DEPT_NAME,
                                B.DESIGNATION,
                                A.APPROVAL_STATUS,
                                A.HOD_STATUS,
                                A.EXIT_INTERVIEW_STATUS,
                                A.EXIT_INTERVIEW_DATE,
                                A.EXIT_INTERVIEW_BY,
                                A.CREATED_DATE,
                                A.CREATED_BY,
                                A.LAST_WORKING_DATE,
                                A.RESIGNATION_DATE,
                                A.REASON
                            FROM 
                                EMP_CLEARENCE A
                            
                             JOIN 
                                RML_HR_APPS_USER B ON A.RML_HR_APPS_USER_ID = B.ID Where A.CREATED_BY='$emp_session_id'"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;

                            ?>
                                <tr class="text-center">
                                    <td>
                                        <strong><?php echo $number; ?></strong>
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
                                        if ($row['HOD_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['HOD_STATUS'] == '0') {
                                            echo 'Denied';
                                        } else if ($row['HOD_STATUS'] == '') {
                                            echo 'Pending';
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($row['APPROVAL_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['APPROVAL_STATUS'] == '0') {
                                            echo 'Denied';
                                        } else if ($row['APPROVAL_STATUS'] == '') {
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
                                        </br>


                                    </td>
                                    <td>
                                        <?php
                                        $singledataOFAccClear = oci_parse($objConnect, "SELECT * FROM ACCOUNTS_CLEARENCE_FORMS WHERE EMP_CLEARENCE_ID =" . $row['ID'] . " FETCH FIRST 1 ROWS ONLY");
                                        oci_execute($singledataOFAccClear);
                                        $clearenceFormFata = oci_fetch_assoc($singledataOFAccClear);

                                        if ($clearenceFormFata) {
                                            echo "Done";
                                        } else {
                                            echo "Pending";
                                        }
                                        ?>
                                    </td>

                                    <td><?php
                                        echo 'Created: ' . $row['CREATED_DATE'];
                                        echo '</br>';
                                        echo 'Created By: ' . $row['CREATED_BY'];
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

    <!--statusModal Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"> APPROVAL STATUS VIEW :


                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row text-left ">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!--statusModal Modal -->

</div>


<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>