<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
if (!checkPermission('hr-offboarding-approval')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$v_view_approval = 0;
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
        <div class="card card-body">
            <form id="Form1" action="" method="post"></form>
            <form id="Form2" action="" method="post"></form>
            <form id="Form3" action="" method="post"></form>
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                        <input required="" form="Form1" placeholder="Employee ID" name="emp_concern" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_concern']) ? $_POST['emp_concern'] : ''; ?>' />
                    </div>
                </div>
                <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <div class="form-group">
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Approval Data" form="Form1">
                    </div>
                </div>
            </div>

        </div>

        <div class="card  col-lg-12 mt-2">
            <h5 class="card-header"><b>Clearence Approval List</b></h5>
            <form id="Form2" action="" method="post " class="card-body">
                <div class="">
                    <div class="resume-item d-flex flex-column flex-md-row">
                        <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
                            <thead class="table-dark text-center">
                                <tr class="text-center">
                                    <th scope="col">Sl</th>
                                    <th scope="col">Emp Info</th>
                                </tr>
                            </thead>



                            <?php


                            if (isset($_POST['emp_concern'])) {
                                $emp_concern = $_REQUEST['emp_concern'];
                                $strSQL  = oci_parse($objConnect, "SELECT B.ID,
																	   C.EMP_NAME,
																	   C.RML_ID,
																	   C.R_CONCERN,
																	   C.DEPT_NAME,
																	   C.DESIGNATION,
																	   C.BRANCH_NAME,
																	   A.CREATED_DATE,
																	   A.CREATED_BY
																FROM EMP_CLEARENCE A,EMP_CLEARENCE_DTLS B,RML_HR_APPS_USER C
																WHERE A.ID=B.EMP_CLEARENCE_ID
																AND A.RML_HR_APPS_USER_ID=C.ID
																AND C.RML_ID='$emp_concern'
																AND B.CONCERN_NAME IN (
																				SELECT R_CONCERN from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
																				(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id')
																				 )
																AND B.DEPARTMENT_ID IN (
																				SELECT DEPARTMENT_ID from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
																				(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id')
																				)");

                                oci_execute($strSQL);
                                $number = 0;

                                while ($row = oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    $v_view_approval = 1;
                            ?>
                                    <tbody>
                                        <tr>
                                            <td><input form="Form2 type=" checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>">
                                                <?php echo $number; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['EMP_NAME'];
                                                echo ',<br>';
                                                echo $row['RML_ID'];
                                                echo ',<br>';
                                                echo $row['DEPT_NAME'];
                                                echo ',<br>';
                                                echo $row['DESIGNATION'];
                                                echo ',<br>';
                                                echo $row['BRANCH_NAME']; ?>
                                                <!-- <input class="btn btn-primary btn pull-right" type="submit" name="submit_approval_single" value="Approve" /> -->
                                            </td>
                                        </tr>
                                    <?php
                                }
                                if ($v_view_approval > 0) {
                                    ?>
                                        <tr>
                                            <td>
                                                <input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve" />
                                            </td>

                                            <td><input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Denied" /></td>
                                        </tr>

                                    <?php
                                }
                            } else {

                                $allDataSQL  = oci_parse($objConnect, "SELECT B.ID,
																	   C.EMP_NAME,
																	   C.RML_ID,
																	   C.R_CONCERN,
																	   C.DEPT_NAME,
																	   C.DESIGNATION,
																	   C.BRANCH_NAME,
																	   A.CREATED_DATE,
																	   A.CREATED_BY
																FROM EMP_CLEARENCE A,EMP_CLEARENCE_DTLS B,RML_HR_APPS_USER C
																WHERE A.ID=B.EMP_CLEARENCE_ID
																AND A.RML_HR_APPS_USER_ID=C.ID
																AND B.APPROVAL_STATUS IS NULL
																AND B.CONCERN_NAME IN (
																				SELECT R_CONCERN from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
																				(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id')
																				 )
																AND B.DEPARTMENT_ID IN (
																				SELECT RML_HR_DEPARTMENT_ID from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
																				(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id')
																				)");

                                @oci_execute($allDataSQL);
                                $number = 0;

                                while ($row = oci_fetch_assoc($allDataSQL)) {
                                    $number++;
                                    $v_view_approval = 1;
                                    ?>
                                        <tr>
                                            <td><input form="Form2" type="checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>">
                                                <?php echo $number; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['EMP_NAME'];
                                                echo ',<br>';
                                                echo $row['RML_ID'];
                                                echo ',<br>';
                                                echo $row['DEPT_NAME'];
                                                echo ',<br>';
                                                echo $row['DESIGNATION'];
                                                echo ',<br>';
                                                echo $row['BRANCH_NAME']; ?>
                                                <!-- <input class="btn btn-primary btn pull-right" type="submit" name="submit_approval_single" value="Approve" /> -->
                                            </td>
                                        </tr>
                                    <?php
                                }
                                if ($v_view_approval > 0) {
                                    ?>
                                        <tr>
                                            <td>
                                                <input form="Form2" class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve" />
                                            </td>
                                            <td>
                                                <input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Denied" />
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
            </form>
        </div>
        <?php

        if (isset($_POST['submit_approval_single'])) {
            if (!empty($_POST['check_list'])) {
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

                    $attnProcSQL  = oci_parse($objConnect, "UPDATE EMP_CLEARENCE_DTLS
								SET    APPROVAL_STATUS  = 1,
									   APPROVE_BY       = '$emp_session_id',
									   APPROVE_DATE     = SYSDATE
								WHERE  ID               = '$TT_ID_SELECTTED'");

                    if (oci_execute($attnProcSQL)) {
                        //$errorMsg = "Your Selected Leave Successfully Approved";
                        echo '<div class="alert alert-primary">';
                        echo 'Successfully Approved Clearence ID ' . $TT_ID_SELECTTED;
                        echo '<br>';
                        echo '</div>';
                    }
                }
                echo "<script>window.location = '$basePath/lm_leave_approval.php'</script>";
            } else {
                //$errorMsg = "Sorry! You have not select any ID Code.";

                echo '<div class="alert alert-danger">';
                echo 'Sorry! You have not select any ID Code.';
                echo '</div>';
            }
        }





        if (isset($_POST['submit_approval'])) { //to run PHP script on submit

            if (!empty($_POST['check_list'])) {
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

                    $attnProcSQL  = oci_parse($objConnect, "UPDATE EMP_CLEARENCE_DTLS
								SET    APPROVAL_STATUS  = 1,
									   APPROVE_BY       = '$emp_session_id',
									   APPROVE_DATE     = SYSDATE
								WHERE  ID               = $TT_ID_SELECTTED");

                    if (oci_execute($attnProcSQL)) {
                        //$errorMsg = "Your Selected Leave Successfully Approved";
                        echo '<div class="alert alert-primary">';
                        echo 'Successfully Approved Clearence ID ' . $TT_ID_SELECTTED;
                        echo '<br>';
                        echo '</div>';
                    }
                }
                echo "<script>window.location = '$basePath/clearence_module/view/lm_panel/approval.php'</script>";
            } else {
                //$errorMsg = "Sorry! You have not select any ID Code.";

                echo '<div class="alert alert-danger">';
                echo 'Sorry! You have not select any ID Code.';
                echo '</div>';
            }
        }

        // Denied option
        if (isset($_POST['submit_denied'])) { //to run PHP script on submit
            if (!empty($_POST['check_list'])) {
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
                    $strSQL = oci_parse(
                        $objConnect,
                        "update RML_HR_EMP_LEAVE 
										set LINE_MNGR_APVL_STS=0,
										LINE_MNGR_APVL_DATE=sysdate,
										LINE_MNGR_APVL_BY='$emp_session_id',
										IS_APPROVED=0
                                         where ID='$TT_ID_SELECTTED'"
                    );

                    oci_execute($strSQL);

                    echo 'Successfully Denied Outdoor Attendance ID ' . $TT_ID_SELECTTED . "</br>";
                }
                echo "<script>window.location = '$basePath/lm_leave_approval.php'</script>";
            } else {
                echo '<div class="alert alert-danger">';
                echo 'Sorry! You have not select any ID Code.';
                echo '</div>';
            }
        }


        ?>
    </div>

</div>

<!-- / Content -->


<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>