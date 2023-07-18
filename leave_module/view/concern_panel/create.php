<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');

if (!checkPermission('concern-leave-create')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12">
        <form id="Form1" action="" method="post"></form>
        <form id="Form2" action="" method="post"></form>
        <div class="card-body row">
            <div class="col-2"></div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                    <input form="Form1" required="" placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' />
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                    <input form="Form1" class="form-control  btn  btn-sm  btn-primary" name="submit_search" type="submit" value="Search Data">
                </div>
            </div>
        </div>
        </form>
    </div>
    </br>

    <?php


    if (isset($_POST['emp_id'])) {

        $v_emp_id = $_REQUEST['emp_id'];
        $strSQL   = oci_parse(
            $objConnect,
            "SELECT RML_ID,
			        EMP_NAME,
					DEPT_NAME,
					DESIGNATION,
					BRANCH_NAME 
			FROM RML_HR_APPS_USER 
			WHERE IS_ACTIVE=1 
			AND R_CONCERN IN (SELECT R_CONCERN from RML_HR_APPS_USER WHERE IS_ACTIVE=1 AND RML_ID ='$emp_session_id') 
			AND RML_ID ='$v_emp_id'"
        );
        @oci_execute($strSQL);
        $number = 0;
        while ($row = @oci_fetch_assoc($strSQL)) {
    ?>
            <!-- Basic Layout & Basic with Icons -->
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0"> Leave Application Form <small></small> </h5>
                            <small class="text-muted float-end">Leave Entry <i class="menu-icon tf-icons bx bx-pencil" style="margin:0;"></i></small>
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

                                        $strSQL = oci_parse($objConnect, "select LEAVE_TITLE,SHORT_NAME from RML_HR_EMP_LEAVE_NAME ORDER BY LEAVE_TITLE");
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
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button form="Form2" type="submit" name="submit_leave" class="btn btn-primary">Create Leave</button>
                                </div>
                            </div>


                        </div>

                        <?php

                        $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                        if (isset($_POST['submit_leave'])) {
                            if (isset($_POST['leave_end_date'])) {
                                $v_emp_id           = $_REQUEST['emp_id'];
                                $leave_remarks      = $_REQUEST['remarks'];
                                $leave_type         = $_REQUEST['leave_type'];
                                $v_leave_start_date = date("d/m/Y", strtotime($_REQUEST['leave_start_date']));
                                $v_leave_end_date   = date("d/m/Y", strtotime($_REQUEST['leave_end_date']));

                                $strSQL = oci_parse(
                                    $objConnect,
                                    "begin RML_HR_LEAVE_CREATE('$v_emp_id','$v_leave_start_date','$v_leave_end_date','$leave_remarks','$leave_type','$emp_session_id');end;"
                                );

                                if (@oci_execute(@$strSQL)) {

                                    $leaveSQL = oci_parse($objConnect, "BEGIN RML_HR_ATTN_PROC('$v_emp_id',TO_DATE('$v_leave_start_date','dd/mm/yyyy'),TO_DATE('$v_leave_end_date','dd/mm/yyyy'));END;");

                                    // if (@oci_execute($leaveSQL)) {
                                    //     echo "Leave Create and Attendance Process Successfully Done.Please Check Attendance.";
                                    // } else {
                                    //     echo "Sorry! Contact with IT.";
                                    // }


                                    if (@oci_execute($leaveSQL)) {

                                        $message = [
                                            'text' => "Leave Create and Attendance Process Successfully Done.Please Check Attendance.",
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



                                    //echo "Leave Create and Attendance Process Successfully Done.Please Check Attendance.";
                                } else {
                                    @$lastError = error_get_last();
                                    @$error = $lastError ? "" . $lastError["message"] . "" : "";
                                    // echo preg_split("/\@@@@/", @$error)[1];

                                    $message = [
                                        'text' => (preg_split("/\@@@@/", @$error)[1]),
                                        'status' => 'false',
                                    ];
                                    $_SESSION['noti_message'] = $message;
                                }
                            }
                        }
                        ?>




                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header text-danger">
                            [NOTE : This Application will be automatically approved by your id. So becareful to create/apply this.]
                        </div>
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