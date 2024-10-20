<?php
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
// $basePath =  $_SESSION['basePath'];
// if (!checkPermission('user-list')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }

if (isset($_POST['form_iemi_no'])) {
    if (oci_execute($strSQL)) {
        $message = [
            'text' => ' User Updated Successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
    }
}
$emp_id = $_GET['emp_id'];
?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card card-body col-lg-12">
        <form id="Form2" action="" method="post"></form>
        <?php
        $strSQL = oci_parse(
            $objConnect,
            "SELECT RML_ID,
            EMP_NAME,
            MOBILE_NO,
            DEPT_NAME,
            IEMI_NO,
            LINE_MANAGER_RML_ID,
            LINE_MANAGER_MOBILE,
            DEPT_HEAD_RML_ID,
            DEPT_HEAD_MOBILE_NO,
            BRANCH_NAME,
            DESIGNATION,
            BLOOD,
            MAIL,
            DOJ,
            DOC,
            GENDER,
            R_CONCERN,
            ATTN_RANGE_M,
            USER_CREATE_DATE,
            USER_ROLE,
            LAT,LAT_2,LAT_3,LAT_4,LAT_5,LAT_6,
            LANG,LANG_2,LANG_3,LANG_4,LANG_5,LANG_6,
            TRACE_LOCATION,
            IS_ACTIVE
            FROM RML_HR_APPS_USER
            where RML_ID='$emp_id'"
        );

        oci_execute($strSQL);
        while ($row = oci_fetch_assoc($strSQL)) {
            ?>
            <div class="  ">
                <div class="">
                    <h5 class="card-header text-center text-danger">You will be responsible. if you update anything here?
                    </h5>
                    <form action="<?php echo $basePath . '/admin_setting/action/self_panel.php' ?>" method="POST">
                        <input type="hidden" name="actionType" value="updateProfie">
                        <input type="hidden" name="emp_id" value="<?php echo $emp_id ?>">
                        <div class="container">
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Emp ID:</label>
                                        <input type="text" class="form-control cust-control" id="title" name="form_rml_id"
                                            value="<?php echo $row['RML_ID']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Name:</label>
                                        <input type="text" name="emp_form_name" class="form-control cust-control" id="title"
                                            value="<?php echo $row['EMP_NAME']; ?>">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Mobile:</label>
                                        <input type="text" name="emp_mobile" class="form-control cust-control" id="title"
                                            value="<?php echo $row['MOBILE_NO']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Department:</label>
                                        <input type="text" name="emp_dept" class="form-control cust-control" id="title"
                                            value="<?php echo $row['DEPT_NAME']; ?>">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Responsible-1 ID:</label>
                                        <input type="text" class="form-control cust-control" id="title" name="form_res1_id"
                                            value="<?php echo $row['LINE_MANAGER_RML_ID']; ?>">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Responsible-1 Mobile:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            name="form_res1_mobile" value="<?php echo $row['LINE_MANAGER_MOBILE']; ?>">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Responsible-2 ID:</label>
                                        <input type="text" class="form-control cust-control" id="title" name="form_res2_id"
                                            value="<?php echo $row['DEPT_HEAD_RML_ID']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Responsible-2 Mobile:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            name="form_res2_mobile" value="<?php echo $row['DEPT_HEAD_MOBILE_NO']; ?>">
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Designation:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            value="<?php echo $row['DESIGNATION']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Mail:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            value="<?php echo $row['MAIL']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">DOJ:</label>
                                        <input type="date" class="form-control cust-control" id="title"
                                            value="<?php echo date("Y-m-d", strtotime($row['DOJ'])); ?>" name="emp_doj">
                                        <!-- <input type="date" class="form-control cust-control" id="title"
                                            value="<?php echo date("d/m/Y", strtotime($row['DOJ'])) ?>" readonly> -->
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">DOC:</label>
                                        <input type="date" class="form-control cust-control" id="title"
                                            value="<?php echo date("Y-m-d", strtotime($row['DOC'])); ?>" name="emp_doc">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Brance Name:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            value="<?php echo $row['BRANCH_NAME']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Gendar:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                        value="<?php echo ($row['GENDER'] === 'M') ? 'Male' : (($row['GENDER'] === 'F') ? 'Female' : ''); ?>" 
                                        readonly>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Joning Date:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            value="<?php echo $row['DOJ']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Blood:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            value="<?php echo $row['BLOOD']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Emp Concern:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            value="<?php echo $row['R_CONCERN']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Apps Attn Range(Meter):</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            value="<?php echo $row['ATTN_RANGE_M'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">User Created Date:</label>
                                        <input type="text" class="form-control cust-control" id="title"
                                            value="<?php echo $row['USER_CREATE_DATE']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Employee Status:</label>
                                        <select name="emp_status" class="form-control cust-control">
                                            <option value="1" <?php echo $row['IS_ACTIVE'] == 1 ? 'selected' : ''; ?>>Active
                                            </option>
                                            <option value="0" <?php echo $row['IS_ACTIVE'] == 0 ? 'selected' : ''; ?>>
                                                In-Active</option>
                                        </select>


                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">User Role:</label>
                                        <select required="" name="emp_role" class="form-control cust-control">
                                            <?php

                                            if ($row['USER_ROLE'] == 'NU') {
                                                ?>
                                                <option value="NU">Normal User</option>
                                                <option value="LM">Line Manager</option>

                                                <?php
                                            } else {
                                                ?>
                                                <option value="LM">Line Manager</option>
                                                <option value="NU">Normal User</option>
                                                <?php
                                            }

                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Location Traceable Status:</label>
                                        <select required="" name="traceable_status" class="form-control cust-control">
                                            <?php

                                            if ($row['TRACE_LOCATION'] == '1') {
                                                ?>
                                                <option value="1">Active</option>
                                                <option value="0">In-Active</option>

                                                <?php
                                            } else {
                                                ?>
                                                <option value="0">In-Active</option>
                                                <option value="1">Active</option>

                                                <?php
                                            }

                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat:</label>
                                        <input type="text" class="form-control cust-control" name="lat" id="title"
                                            value="<?php echo $row['LAT']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang:</label>
                                        <input type="text" class="form-control cust-control" name="lang" id="title"
                                            value="<?php echo $row['LANG']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-2:</label>
                                        <input type="text" class="form-control cust-control" name="lat_2" id="title"
                                            value="<?php echo $row['LAT_2']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-2:</label>
                                        <input type="text" class="form-control cust-control" name="lang_2" id="title"
                                            value="<?php echo $row['LANG_2']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-3:</label>
                                        <input type="text" class="form-control cust-control" name="lat_3" id="title"
                                            value="<?php echo $row['LAT_3']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-3:</label>
                                        <input type="text" class="form-control cust-control" name="lang_3" id="title"
                                            value="<?php echo $row['LANG_3']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-4:</label>
                                        <input type="text" class="form-control cust-control" name="lat_4" id="title"
                                            value="<?php echo $row['LAT_4']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-4:</label>
                                        <input type="text" class="form-control cust-control" name="lang_4" id="title"
                                            value="<?php echo $row['LANG_4']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-5:</label>
                                        <input type="text" class="form-control cust-control" name="lat_5" id="title"
                                            value="<?php echo $row['LAT_5']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-5:</label>
                                        <input type="text" class="form-control cust-control" name="lang_5" id="title"
                                            value="<?php echo $row['LANG_5']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-6:</label>
                                        <input type="text" class="form-control cust-control" name="lat_6" id="title"
                                            value="<?php echo $row['LAT_6']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-6:</label>
                                        <input type="text" class="form-control cust-control" name="lang_6" id="title"
                                            value="<?php echo $row['LANG_6']; ?>">
                                    </div>
                                </div>

                                <?php if (getUserWiseRoleName('super-admin') || getUserWiseRoleName('hr')) { ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="d-block text-center mt-2">
                                                <button type="submit" name="submit" class="btn btn-sm btn-info">Submit
                                                    Update</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>

                    </form>

                </div>

            </div>
            <?php
        }
        ?>




        <?php


        ?>
    </div>
</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>