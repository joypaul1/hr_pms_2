<?php
session_start();
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];
if (!checkPermission('concern-work-station')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body">
        <form id="Form1" action="" method="post"></form>
        <form id="Form2" action="" method="post"></form>
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <div class="form-group">
                    <input form="Form1" required="" placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' />
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <input form="Form1" class="form-control btn btn-sm btn-primary" name="submit_search" type="submit" value="Search Data">
                </div>
            </div>
        </div>
        </form>
    </div>
    </br>

    <?php


    if (isset($_POST['emp_id'])) {

        $v_emp_id = $_REQUEST['emp_id'];
        $strSQL  = oci_parse(
            $objConnect,
            "SELECT 
						    RML_ID,
							(select U.EMP_NAME from RML_HR_APPS_USER U where U.RML_ID=A.LINE_MANAGER_RML_ID) AS LINE_MANAGER_1,
							(select U.EMP_NAME from RML_HR_APPS_USER U where U.RML_ID=A.DEPT_HEAD_RML_ID) AS LINE_MANAGER_2,
							EMP_NAME,
							R_CONCERN,
							DEPT_NAME,
							DESIGNATION,
							BRANCH_NAME,
							EMP_GROUP,
							MOBILE_NO,
							MAIL,
							USER_CREATE_DATE
							FROM RML_HR_APPS_USER A WHERE IS_ACTIVE=1 AND RML_ID ='$v_emp_id'"
        );
        @oci_execute($strSQL);
        $number = 0;
        while ($row = @oci_fetch_assoc($strSQL)) {
    ?>
            <!-- Basic Layout & Basic with Icons -->
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">User Transfer Form</h5>
                            <small class="text-muted float-end">Transfer Entry</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="title">Name</label>
                                            <input type="text" class="form-control cust-control" id="basic-default-name" value="<?php echo $row['EMP_NAME']; ?>" readonly />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">RML-ID</label>
                                            <input type="text" class="form-control cust-control" form="Form2" name="emp_id" value="<?php echo $row['RML_ID']; ?>" readonly />
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <label for="title">Department</label>
                                            <input type="text" class="form-control cust-control" value="<?php echo $row['DEPT_NAME']; ?>" readonly />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Designation</label>
                                            <input type="text" class="form-control cust-control" value="<?php echo $row['DESIGNATION']; ?>" readonly />
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <label for="title">Branch</label>
                                            <input type="text" class="form-control cust-control" value="<?php echo $row['BRANCH_NAME']; ?>" readonly />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">User Created</label>
                                            <input type="text" class="form-control cust-control" value="<?php echo $row['USER_CREATE_DATE']; ?>" readonly />
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <label for="title">Concern</label>
                                            <input type="text" class="form-control cust-control" value="<?php echo $row['R_CONCERN']; ?>" readonly />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">EMP Grpup</label>
                                            <input type="text" class="form-control cust-control" value="<?php echo $row['EMP_GROUP']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <label for="title">Line Manager-1</label>
                                            <input type="text" class="form-control cust-control" value="<?php echo $row['LINE_MANAGER_1']; ?>" readonly />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Line Manager-2</label>
                                            <input type="text" class="form-control cust-control" value="<?php echo $row['LINE_MANAGER_2']; ?>" readonly />
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="title">Effect Date</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar">
                                                    </i>
                                                </div>
                                                <input required="" form="Form2" class="form-control cust-control" type='date' name='form_effect_date' value='<?php echo isset($_POST['form_effect_date']) ? $_POST['form_effect_date'] : ''; ?>' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <label for="title">Start Date</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input required="" form="Form2" class="form-control cust-control" type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">End Date</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar">
                                                    </i>
                                                </div>
                                                <input required="" form="Form2" class="form-control cust-control" type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Responsible-1 ID:</label>
                                                <input name="ref_id_1" form="Form2" class="form-control cust-control" type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Responsible-2 ID:</label>
                                                <input name="ref_id_2" form="Form2" class="form-control cust-control" type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <label for="title">Designation</label>
                                            <div class="input-group">
                                                <select required="" form="Form2" name="emp_designation" class="form-control cust-control">
                                                    <option selected value="">--</option>
                                                    <?php
                                                    $strSQL  = oci_parse(
                                                        $objConnect,
                                                        "SELECT distinct(DESIGNATION_NAME) AS DESIGNATION 
									        from RML_HR_DESIGNATION
												where IS_ACTIVE=1
												order by DESIGNATION_NAME"
                                                    );
                                                    oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                    ?>
                                                        <option value="<?php echo $row['DESIGNATION']; ?>"><?php echo $row['DESIGNATION']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Transfer Branch</label>
                                            <div class="input-group">
                                                <select required="" form="Form2" name="emp_branch" class="form-control cust-control">
                                                    <option selected value="">--</option>
                                                    <?php
                                                    $strSQL  = oci_parse(
                                                        $objConnect,
                                                        "SELECT BRANCH_NAME,ID FROM RML_HR_BRANCH ORDER BY BRANCH_NAME"
                                                    );
                                                    oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                    ?>
                                                        <option value="<?php echo $row['ID']; ?>"><?php echo $row['BRANCH_NAME']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <label for="title">Department</label>
                                            <div class="input-group">
                                                <select required="" form="Form2" name="emp_department" class="form-control cust-control">
                                                    <option selected value="">--</option>
                                                    <?php
                                                    $strSQL  = oci_parse(
                                                        $objConnect,
                                                        "SELECT distinct(DEPT_NAME) AS DEPT_NAME FROM RML_HR_DEPARTMENT
											where IS_ACTIVE=1
											order by DEPT_NAME"
                                                    );
                                                    oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                    ?>
                                                        <option value="<?php echo $row['DEPT_NAME']; ?>"><?php echo $row['DEPT_NAME']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <button form="Form2" type="submit" name="submit_leave" class="btn btn-sm btn-primary btn pull-right form-control">Create Transfer</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <?php

                        $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                        if (isset($_POST['submit_leave'])) {
                            if (isset($_POST['form_effect_date'])) {

                                $v_emp_id = $_REQUEST['emp_id'];
                                $v_emp_designation = $_REQUEST['emp_designation'];
                                $v_emp_branch_id = $_REQUEST['emp_branch'];
                                $v_emp_department = $_REQUEST['emp_department'];


                                $v_ref_id_1 = $_REQUEST['ref_id_1'];
                                $v_ref_id_2 = $_REQUEST['ref_id_2'];

                                $v_form_effect_date = date("d/m/Y", strtotime($_REQUEST['form_effect_date']));
                                $v_start_date       = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                $v_end_date         = date("d/m/Y", strtotime($_REQUEST['end_date']));


                                if ($transfer_effect_date == date("d/m/Y")) {
                                    $strSQL  = oci_parse($objConnect, "INSERT INTO RML_HR_EMP_TRANSFER (
																  RML_ID, 
																  RML_HR_BRANCH_ID, 
																  LINE_MANAGER_RML_ID, 
																  LINE_MANAGER_MOBILE, 
																  DEPT_HEAD_RML_ID, 
																  DEPT_HEAD_MOBILE_NO, 
																  EFFECT_DATE, 
																  CREATE_DATE, 
																  CREATED_BY,
                                                                  FIRED_DATE,																  
																  IS_FIRED,
																  DEPARTMENT,
																  DESIGNATION) 
															VALUES (
															 '$v_emp_id',
															 '$v_emp_branch_id',
															 '$v_ref_id_1',
															 '',
															 '$v_ref_id_2',
															 '',
															  TO_DATE('$v_form_effect_date','dd/mm/yyyy'),
															  SYSDATE,
															  '$emp_session_id',
															  SYSDATE,
															  1 ,
															  '$v_emp_department',
															  '$v_emp_designation')");
                                } else {
                                    $strSQL  = oci_parse($objConnect, "INSERT INTO RML_HR_EMP_TRANSFER (
																  RML_ID, 
																  RML_HR_BRANCH_ID, 
																  LINE_MANAGER_RML_ID, 
																  LINE_MANAGER_MOBILE, 
																  DEPT_HEAD_RML_ID, 
																  DEPT_HEAD_MOBILE_NO, 
																  EFFECT_DATE, 
																  CREATE_DATE, 
																  CREATED_BY,  
																  IS_FIRED,
																  DEPARTMENT,
																  DESIGNATION) 
															VALUES (
															 '$v_emp_id',
															 '$v_emp_branch_id',
															 '$v_ref_id_1',
															 '',
															 '$v_ref_id_2',
															 '',
															  TO_DATE('$v_form_effect_date','dd/mm/yyyy'),
															  SYSDATE,
															  '$emp_session_id',
															  0,
															  '$v_emp_department',
															  '$v_emp_designation')");
                                }

                                if (@oci_execute(@$strSQL)) {
                                    if ($transfer_effect_date == date("d/m/Y")) {
                                        $autoSQL  = oci_parse($objConnect, "update RML_HR_APPS_USER set 
												LINE_MANAGER_RML_ID='$v_ref_id_1',
												DEPT_HEAD_RML_ID='$v_ref_id_2',
												DEPT_NAME='$v_emp_department',
												DESIGNATION='$v_emp_designation',
												BRANCH_NAME=(SELECT BRANCH_NAME FROM RML_HR_BRANCH WHERE ID='$v_emp_branch_id' AND IS_ACTIVE=1),
												LAT=(SELECT LATITUDE FROM RML_HR_BRANCH WHERE ID='$v_emp_branch_id' AND IS_ACTIVE=1),
												LANG=(SELECT LONGITUDE FROM RML_HR_BRANCH WHERE ID='$v_emp_branch_id' AND IS_ACTIVE=1)
											where RML_ID='$form_rml_id'");
                                        oci_execute($autoSQL);
                                    }
                                    echo "Transfer entry created successfully.";
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

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>