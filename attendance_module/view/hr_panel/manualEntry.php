<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('hr-attendance-manual-entry')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body col-lg-12">
        <form id="Form1" action="" method="post"></form>
        <form id="Form2" action="" method="post"></form>
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                    <input form="Form1" required="" placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' />
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                    <input form="Form1" class="form-control  btn  btn-sm btn-primary" name="submit_search" type="submit" value="Search Data">
                </div>
            </div>
        </div>
        </form>
    </div>



    <?php


    if (isset($_POST['emp_id'])) {

        $v_emp_id = $_REQUEST['emp_id'];
        $strSQL  = oci_parse(
            $objConnect,
            "SELECT RML_ID,EMP_NAME,DEPT_NAME,DESIGNATION,BRANCH_NAME FROM RML_HR_APPS_USER WHERE IS_ACTIVE=1 AND RML_ID ='$v_emp_id'"
        );
        @oci_execute($strSQL);
        $number = 0;






        while ($row = @oci_fetch_assoc($strSQL)) {
    ?>
            <!-- Basic Layout & Basic with Icons -->
            <div class="row mt-2">
                <!-- Basic Layout -->
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Manual Attendance Form</h5>
                            <small class="text-muted float-end">Manual Entry</small>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-name" value="<?php echo $row['EMP_NAME']; ?>" readonly />
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
                                <label class="col-sm-2 col-form-label" style="color:red;" for="basic-default-company">Select Start Date**</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar">
                                            </i>
                                        </div>
                                        <input required="" form="Form2" class="form-control" type='date' name='attn_start_date' value='<?php echo isset($_POST['attn_start_date']) ? $_POST['attn_start_date'] : ''; ?>' />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" style="color:red;" for="basic-default-company">Select End Date**</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar">
                                            </i>
                                        </div>
                                        <input required="" form="Form2" class="form-control" type='date' name='attn_end_date' value='<?php echo isset($_POST['attn_end_date']) ? $_POST['attn_end_date'] : ''; ?>' />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" style="color:red;" for="basic-default-company">Time at Hour**</label>
                                <div class="col-sm-10">
                                    <select required="" form="Form2" name="attn_hour" class="form-control">
                                        <option value="">---</option>
                                        <option value="7">7 AM</option>
                                        <option value="8">8 AM</option>
                                        <option value="9">9 AM</option>
                                        <option value="10">10 AM</option>
                                        <option value="11">11 AM</option>
                                        <option value="12">12 PM</option>
                                        <option value="13">1 PM</option>
                                        <option value="14">2 PM</option>
                                        <option value="15">3 PM</option>
                                        <option value="16">4 PM</option>
                                        <option value="17">5 PM</option>
                                        <option value="18">6 PM</option>
                                        <option value="19">7 PM</option>
                                        <option value="20">8 PM</option>
                                        <option value="21">9 PM</option>
                                        <option value="22">10 PM</option>
                                        <option value="23">11 PM</option>
                                    </select>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" style="color:red;" for="basic-default-company">Time at Minute**</label>
                                <div class="col-sm-10">
                                    <select required="" form="Form2" name="attn_minute" class="form-control">
                                        <option value="">---</option>
                                        <option value="0">00</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-message">Remarks</label>
                                <div class="col-sm-10">
                                    <textarea id="basic-default-message" class="form-control" form="Form2" name="remarks" placeholder="Hi, Do you have any Remarks?" required="" aria-describedby="basic-icon-default-message2"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right ">
                                    <button form="Form2" type="submit" name="submit_attendance" class="btn btn-sm btn-primary">Create Attendance</button>
                                </div>
                            </div>


                        </div>

                        <?php

                        $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                        if (isset($_POST['submit_attendance'])) {
                            if (isset($_POST['attn_start_date'])) {
                                $v_emp_id = $_REQUEST['emp_id'];
                                $v_remarks = str_replace("'", "", $_REQUEST['remarks']);
                                $v_attn_hour = $_REQUEST['attn_hour'];
                                $v_attn_minute = $_REQUEST['attn_minute'];
                                $v_attn_start_date = date("d/m/Y", strtotime($_REQUEST['attn_start_date']));
                                $v_attn_end_date = date("d/m/Y", strtotime($_REQUEST['attn_end_date']));

                                $diff = abs($v_attn_start_date - $v_attn_end_date);
                                for ($i = 0; $i <= $diff; $i++) {
                                    $attn_entry_date = date("d/m/Y", strtotime($_REQUEST['attn_start_date'] . ' +' . $i . ' day'));
                                    $strSQL  = oci_parse(
                                        $objConnect,
                                        "INSERT INTO RML_HR_ATTN_DAILY (
											    RML_ID, 
											    ATTN_DATE, 
											    LAT,
											    LANG,
											    INSIDE_OR_OUTSIDE, 
											    OUTSIDE_REMARKS,
											    IS_ALL_APPROVED,
											    ENTRY_DATE,
											    ENTRY_BY) 
											VALUES (
											    '$v_emp_id',
												TO_DATE('$attn_entry_date ' || '$v_attn_hour' || ':' || '$v_attn_minute' || ':00','dd/mm/yyyy HH24:MI:SS'),
												0,
											    0,
												'HR ATTN',
												'$v_remarks',
												1,
												sysdate,
												'$emp_session_id')"
                                    );

                                    if (@oci_execute(@$strSQL)) {
                                        $attnSQL  = oci_parse(
                                            $objConnect,
                                            "BEGIN RML_HR_ATTN_PROC('$v_emp_id',TO_DATE('$v_attn_start_date','dd/mm/yyyy'),TO_DATE('$v_attn_end_date','dd/mm/yyyy'));END;"
                                        );
                                        if (@oci_execute($attnSQL)) {
                                            // $errorMsg = "Attendance Process Successfully Done.Please Check Attendance.";
                                            // echo '<div class="alert alert-primary">';
                                            // echo $errorMsg;
                                            // echo '</div>';
                                            $message = [
                                                'text' => "Attendance Process Successfully Done.Please Check Attendance.",
                                                'status' => 'true',
                                            ];
                                            $_SESSION['noti_message'] = $message;
                                        } else {
                                            // echo '<div class="alert alert-danger">';
                                            // echo 'Sorry! Contact with IT.';
                                            // echo '</div>';
                                            $message = [
                                                'text' => "Sorry! Contact with IT.",
                                                'status' => 'false',
                                            ];
                                            $_SESSION['noti_message'] = $message;
                                        }
                                    } else {
                                        @$lastError = error_get_last();
                                        @$error = $lastError ? "" . $lastError["message"] . "" : "";
                                        // $errorMsg = preg_split("/\@@@@/", @$error)[1];
                                        // echo '<div class="alert alert-danger">';
                                        // echo $errorMsg;
                                        // echo '</div>';
                                        $message = [
                                            'text' => (preg_split("/\@@@@/", @$error)[1]),
                                            'status' => 'false',
                                        ];
                                        $_SESSION['noti_message'] = $message;
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>


</div>

<!-- / Content -->


<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>