<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
if (!checkPermission('concern-offboarding-create')) {

    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

$EMP_NAME = '';
$EMP_MOBILE = '';
$LINE_MANAGER_NAME = '';
$strSQL  = oci_parse(
    $objConnect,
    "SELECT A.RML_ID,A.EMP_NAME,A.DEPT_NAME,A.DESIGNATION,A.BRANCH_NAME,MOBILE_NO
                       FROM RML_HR_APPS_USER A WHERE A.IS_ACTIVE=1 AND A.RML_ID ='$emp_session_id'"
);
@oci_execute($strSQL);
$number = 0;
while ($row = @oci_fetch_assoc($strSQL)) {
    $EMP_NAME = $row['EMP_NAME'];
    $EMP_MOBILE = $row['MOBILE_NO'];

?>

    <!-- / Content -->

    <div class="container-xxl flex-grow-1 container-p-y">


        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                   

                    <?php
                    $leftSideName  = 'Leave Create';
                    if (checkPermission('self-leave-list')) {
                        $rightSideName = 'Leave Report';
                        $routePath     = 'leave_module/view/self_panel/index.php';
                    }

                    include('../../../layouts/_tableHeader.php');

                    ?>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control " id="basic-default-name" value="<?php echo $row['EMP_NAME']; ?>" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">RML-ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-company" form="Form2" name="emp_id" value="<?php echo $row['RML_ID']; ?>" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Department</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-company" value="<?php echo $row['DEPT_NAME']; ?>" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Department</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-company" value="<?php echo $row['DESIGNATION']; ?>" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-company" value="<?php echo $row['BRANCH_NAME']; ?>" readonly />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Select Start Date</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar">
                                        </i>
                                    </div>
                                    <input required="" form="Form2" class="form-control" type='date' name='leave_start_date' value='<?php echo isset($_POST['leave_start_date']) ? $_POST['leave_start_date'] : ''; ?>' />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Select End Date</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar">
                                        </i>
                                    </div>
                                    <input required="" form="Form2" class="form-control" type='date' name='leave_end_date' value='<?php echo isset($_POST['leave_end_date']) ? $_POST['leave_end_date'] : ''; ?>' />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Select Leave</label>
                            <div class="col-sm-10">
                                <select required="" form="Form2" name="leave_type" class="form-control">
                                    <option selected value="">--</option>
                                    <?php

                                    $strSQL  = oci_parse($objConnect, "select LEAVE_TITLE,SHORT_NAME from RML_HR_EMP_LEAVE_NAME ORDER BY LEAVE_TITLE");
                                    oci_execute($strSQL);
                                    while ($row = oci_fetch_assoc($strSQL)) {
                                    ?>

                                        <option value="<?php echo $row['SHORT_NAME']; ?>"><?php echo $row['LEAVE_TITLE']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-message">Remarks</label>
                            <div class="col-sm-10">
                                <textarea id="basic-default-message" class="form-control" form="Form2" name="remarks" placeholder="Hi, Do you have any Remarks?" required="" aria-describedby="basic-icon-default-message2"></textarea>
                            </div>
                        </div>

                        <div class="text-right">
                            <button form="Form2" type="submit" name="submit_leave" class="btn btn-primary">Create Leave</button>
                        </div>



                    </div>

                    <?php


                    if (isset($_POST['submit_leave'])) {
                        if (isset($_POST['leave_end_date'])) {
                            $v_emp_id = $_REQUEST['emp_id'];
                            $leave_remarks = $_REQUEST['remarks'];
                            $leave_type = $_REQUEST['leave_type'];
                            $v_leave_start_date = date("d/m/Y", strtotime($_REQUEST['leave_start_date']));
                            $v_leave_end_date = date("d/m/Y", strtotime($_REQUEST['leave_end_date']));

                            $strSQL  = oci_parse(
                                $objConnect,
                                "begin RML_HR_LEAVE_CREATE('$v_emp_id','$v_leave_start_date','$v_leave_end_date','$leave_remarks','$leave_type','$emp_session_id');end;"
                            );

                            if (@oci_execute(@$strSQL)) {

                                if ($v_emp_id == 'RML-00955') {
                                    if (strlen($EMP_MOBILE) == 11) {
                                        $MESSAGE_HEADER = "Dear Concern,";
                                        $MESSAGE_BODY = "This is to inform you that " . $EMP_NAME . " " . $v_emp_id . " has applied for leave from " . $v_leave_start_date . " to " . $v_leave_end_date . " for " . substr($leave_remarks, 0, 25);
                                        $MESSAGE_FOOTER = "Please review and approve the leave request accordingly.";
                                        $FULL_MESSAGE = $MESSAGE_HEADER . "\n\n" . $MESSAGE_BODY . "\n\n" . $MESSAGE_FOOTER . "\n\n" . "Thank you,\nHR Team";
                                        $EMP_MOBILE = "+88" . $EMP_MOBILE;

                                        $message = rawurlencode($FULL_MESSAGE);
                                        $url = file_get_contents("https://api.smsq.global/api/v2/SendSMS?ApiKey=MjVOYgi/vMC3nAucChiFRCT7qAZQlXOG+O0tpeS3DQ4=&ClientId=a0218de4-7d34-495b-a752-6303b3522f7e&SenderId=8809617601212&Message=$message&MobileNumbers=$EMP_MOBILE&Is_Unicode=8&Is_Flash=longsms");
                                        $ch = curl_init();
                                        // set URL and other appropriate options
                                        curl_setopt($ch, CURLOPT_URL, $url);
                                        curl_setopt($ch, CURLOPT_HEADER, 0);

                                        // grab URL and pass it to the browser
                                        curl_exec($ch);

                                        // close cURL resource, and free up system resources
                                        curl_close($ch);
                                    }
                                }


                                $leaveSQL  = oci_parse($objConnect, "BEGIN RML_HR_ATTN_PROC('$v_emp_id',TO_DATE('$v_leave_start_date','dd/mm/yyyy'),TO_DATE('$v_leave_end_date','dd/mm/yyyy'));END;");
                                if (@oci_execute($leaveSQL)) {
                                    echo '<div class="alert alert-primary">';
                                    echo 'Leave Create Successfully Done and this are need to approve by your HOD.';
                                    echo '</div>';
                                } else {
                                    echo '<div class="alert alert-danger">';
                                    echo 'Sorry! Contact with IT.';
                                    echo '</div>';
                                }

                                //echo "Leave Create and Attendance Process Successfully Done.Please Check Attendance.";
                            } else {
                                @$lastError = error_get_last();
                                @$error = $lastError ? "" . $lastError["message"] . "" : "";
                                echo '<div class="alert alert-danger">';
                                echo preg_split("/\@@@@/", @$error)[1];
                                echo '</div>';
                            }
                        }
                    }
                    ?>




                </div>
            </div>

        </div>



    <?php
}

    ?>


    </div>

    <!-- / Content -->

    <?php require_once('../../../layouts/footer_info.php'); ?>
    <?php require_once('../../../layouts/footer.php'); ?>