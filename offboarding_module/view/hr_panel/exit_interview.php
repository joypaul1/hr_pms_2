<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
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
            <!-- <h5 class="card-header"><b>Offboarding Approval List</b></h5> -->
            <?php
            $leftSideName  = 'Offboarding  Exit Interview List';
            include('../../../layouts/_tableHeader.php');
            ?>
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
                                $strSQL  = oci_parse($objConnect, "SELECT A.ID,
																	   C.EMP_NAME,
																	   C.RML_ID,
																	   C.R_CONCERN,
																	   C.DEPT_NAME,
																	   C.DESIGNATION,
																	   C.BRANCH_NAME,
																	   A.CREATED_DATE,
																	   A.CREATED_BY
																FROM EMP_CLEARENCE A,RML_HR_APPS_USER C
																WHERE A.RML_HR_APPS_USER_ID=C.ID
																AND A.APPROVAL_STATUS=1
																AND EXIT_INTERVIEW_STATUS IS NULL
																AND C.RML_ID='$emp_concern'");

                                oci_execute($strSQL);
                                $number = 0;

                                while ($row = oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    $v_view_approval = 1;
                            ?>
                                    <tbody>
                                        <tr>
                                            <td><input form="Form2" type="checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>">
                                                <?php echo $number; ?>
                                                <a href="<?php echo $basePath . "/document/exit_interview.php?id=" . $row['ID'] . '&rml_id=' . $row['RML_ID'] ?>" target="_blank">
                                                    <button type="button" class="btn btn-sm btn-outline-info">
                                                        Exit Interview Form <i class="menu-icon tf-icons bx bx-right-arrow"></i>
                                                    </button>

                                                </a>
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

                                $allDataSQL  = oci_parse($objConnect, "SELECT A.ID,
																	   C.EMP_NAME,
																	   C.RML_ID,
																	   C.R_CONCERN,
																	   C.DEPT_NAME,
																	   C.DESIGNATION,
																	   C.BRANCH_NAME,
																	   A.CREATED_DATE,
																	   A.CREATED_BY
																FROM EMP_CLEARENCE A,RML_HR_APPS_USER C
																WHERE A.RML_HR_APPS_USER_ID=C.ID
																AND A.APPROVAL_STATUS=1
																AND EXIT_INTERVIEW_STATUS IS NULL");

                                @oci_execute($allDataSQL);
                                $number = 0;

                                while ($row = oci_fetch_assoc($allDataSQL)) {
                                    $number++;
                                    $v_view_approval = 1;
                                    ?>
                                        <tr>
                                            <td>
                                                <input form="Form2" type="checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>">
                                                <?php echo $number; ?>
                                                <a href="<?php echo $basePath . "/document/exit_interview.php?id=" . $row['ID'] . '&rml_id=' . $row['RML_ID']  ?>" target="_blank">
                                                    <button type="button" class="btn btn-sm btn-outline-info">
                                                        Exit Interview Form <i class="menu-icon tf-icons bx bx-right-arrow"></i>
                                                    </button>

                                                </a>
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





        if (isset($_POST['submit_approval'])) { //to run PHP script on submit

            if (!empty($_POST['check_list'])) {
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

                    $attnProcSQL  = oci_parse($objConnect, "UPDATE EMP_CLEARENCE
								SET    EXIT_INTERVIEW_STATUS  = 1,
									   EXIT_INTERVIEW_BY       = '$emp_session_id',
									   EXIT_INTERVIEW_DATE     = SYSDATE
								WHERE  ID               = $TT_ID_SELECTTED");

                    if (oci_execute($attnProcSQL)) {
                        //$errorMsg = "Your Selected Leave Successfully Approved";
                        echo '<div class="alert alert-primary">';
                        echo 'Successfully Approved Offboarding ID ' . $TT_ID_SELECTTED;
                        echo '<br>';
                        echo '</div>';
                    }
                }
                echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/exit_interview.php'</script>";
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
                        "UPDATE EMP_CLEARENCE
								SET    EXIT_INTERVIEW_STATUS  = 0,
									   EXIT_INTERVIEW_BY       = '$emp_session_id',
									   EXIT_INTERVIEW_DATE     = SYSDATE
								WHERE  ID               = $TT_ID_SELECTTED"
                    );

                    oci_execute($strSQL);

                    echo 'Successfully Denied Outdoor Attendance ID ' . $TT_ID_SELECTTED . "</br>";
                }
                echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/exit_interview.php'</script>";
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