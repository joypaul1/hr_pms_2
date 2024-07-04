<?php
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];
if (!checkPermission('user-create')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
        <form action="" method="post">
            <div class="">

                <div class="card ">
                    <div class="card-body">
                        <div class="">
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Write Emp ID:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            id="title" name="form_rml_id" required="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Full Name:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            id="title" name="emp_form_name" required="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Office Mobile No:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            id="title" name="emp_mobile" required="">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Mail:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            id="title" name="emp_mail">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Responsible-1 ID:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            id="title" name="form_res1_id" required="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Responsible-1 Mobile:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            id="title" name="form_res1_mobile" required="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Responsible-2 ID:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            id="title" name="form_res2_id">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Responsible-2 Mobile:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            id="title" name="form_res2_mobile">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <?php if ($_SESSION['HR_APPS']['user_concern'] == 'RMWL') { ?>
                                <div class="col-sm-3">
                                    <label for="title">Select Concern</label>
                                    <select required="" name="company_concern" class="form-control cust-control"
                                        autocomplete="off">
                                        <option value="">--</option>
                                        <option value="RMWL" selected>RMWL</option>
                                    </select>
                                </div>
                                <?php } else { ?>
                                <div class="col-sm-3">
                                    <label for="title">Select Concern</label>
                                    <select required="" name="company_concern" class="form-control cust-control"
                                        autocomplete="off">
                                        <option selected value="">--</option>
                                        <?php
                                            $strSQL  = oci_parse($objConnect, "SELECT distinct(R_CONCERN) R_CONCERN from RML_HR_APPS_USER 
                                                                            where R_CONCERN is not null  and is_active=1 
                                                                            order by R_CONCERN");
                                            oci_execute($strSQL);
                                            while ($row = oci_fetch_assoc($strSQL)) {
                                            ?>
                                        <option value="<?php echo $row['R_CONCERN']; ?>"
                                            <?php echo (isset($_POST['company_concern']) && $_POST['company_concern'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>>
                                            <?php echo $row['R_CONCERN']; ?></option>
                                        <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                                <?php } ?>

                                <div class="col-sm-3">
                                    <label for="title">Select Department</label>
                                    <select required="" name="emp_dept" class="form-control cust-control"
                                        autocomplete="off">

                                        <option selected value="">--</option>
                                        <?php
                                        $strSQL  = oci_parse($objConnect, "SELECT distinct(DEPT_NAME) DEPT_NAME from RML_HR_DEPARTMENT 
										where DEPT_NAME is not null and is_active=1  order by DEPT_NAME");
                                        oci_execute($strSQL);
                                        while ($row = oci_fetch_assoc($strSQL)) {
                                        ?>
                                        <option value="<?php echo $row['DEPT_NAME']; ?>"
                                            <?php echo (isset($_POST['emp_dept']) && $_POST['emp_dept'] == $row['DEPT_NAME']) ? 'selected="selected"' : ''; ?>>
                                            <?php echo $row['DEPT_NAME']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Select Brance</label>
                                    <select required="" name="emp_branch" class="form-control cust-control"
                                        autocomplete="off">

                                        <option selected value="">--</option>
                                        <?php
                                        $strSQL  = oci_parse($objConnect, "SELECT DISTINCT(BRANCH_NAME) AS BRANCH_NAME from RML_HR_APPS_USER WHERE IS_ACTIVE=1 ORDER BY BRANCH_NAME");
                                        oci_execute($strSQL);
                                        while ($row = oci_fetch_assoc($strSQL)) {
                                        ?>
                                        <option value="<?php echo $row['BRANCH_NAME']; ?>"
                                            <?php echo (isset($_POST['emp_branch']) && $_POST['emp_branch'] == $row['BRANCH_NAME']) ? 'selected="selected"' : ''; ?>>
                                            <?php echo $row['BRANCH_NAME']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Joining Date:</label>
                                        <input required="" class="form-control cust-control" autocomplete="off"
                                            id="date" name="doj" type="date">
                                    </div>
                                </div>


                            </div>
                            <?php  ?>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="title">Select Designation</label>
                                    <select required="" name="emp_designation" class="form-control cust-control"
                                        autocomplete="off">

                                        <option selected value="">--</option>
                                        <?php
                                        $strSQL  = oci_parse($objConnect, "SELECT distinct(DESIGNATION_NAME) DESIGNATION_NAME from RML_HR_DESIGNATION 
																								where DESIGNATION_NAME is not null and is_active=1 
																								order by DESIGNATION_NAME");
                                        oci_execute($strSQL);
                                        while ($row = oci_fetch_assoc($strSQL)) {
                                        ?>
                                        <option value="<?php echo $row['DESIGNATION_NAME']; ?>"
                                            <?php echo (isset($_POST['emp_dept']) && $_POST['emp_dept'] == $row['DESIGNATION_NAME']) ? 'selected="selected"' : ''; ?>>
                                            <?php echo $row['DESIGNATION_NAME']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Blood Group:</label>
                                        <select name="emp_blood" class="form-control cust-control" autocomplete="off">
                                            <option selected value="">--</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">User Type:</label>
                                        <select name="user_role" class="form-control cust-control" autocomplete="off"
                                            required="">
                                            <option selected value="">--</option>
                                            <option value="LM">Line Manager</option>
                                            <option value="NU">Normal User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Gender:</label>
                                        <select name="emp_gender" class="form-control cust-control" autocomplete="off"
                                            required="">
                                            <option selected value="">--</option>
                                            <option value="M">Male</option>
                                            <option value="F">Fe-Male</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lat" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lang" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-2:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lat_2" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-2:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lang_2" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-3:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lat_3" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-3:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lang_3" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-4:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lat_4" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-4:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lang_4" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-5:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lat_5" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-5:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lang_5" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lat-6:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lat_6" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Lang-6:</label>
                                        <input type="text" class="form-control cust-control" autocomplete="off"
                                            name="lang_6" id="title">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12  text-right">
                                    <div class="mt-5">
                                        <button type="submit" name="submit" class="btn btn-sm btn-info">Submit &
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <?php
                $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
                @$form_rml_id = $_REQUEST['form_rml_id'];
                @$emp_form_name = $_REQUEST['emp_form_name'];
                @$emp_mobile = $_REQUEST['emp_mobile'];
                @$emp_mail = $_REQUEST['emp_mail'];

                @$form_res1_id = $_REQUEST['form_res1_id'];
                @$form_res1_mobile = $_REQUEST['form_res1_mobile'];
                @$form_res2_id = $_REQUEST['form_res2_id'];
                @$form_res2_mobile = $_REQUEST['form_res2_mobile'];

                @$emp_designation = $_REQUEST['emp_designation'];
                @$emp_dept = $_REQUEST['emp_dept'];
                @$emp_branch = $_REQUEST['emp_branch'];
                @$emp_gender = $_REQUEST['emp_gender'];

                @$company_concern = $_REQUEST['company_concern'];
                @$emp_blood = $_REQUEST['emp_blood'];
                @$user_role = $_REQUEST['user_role'];
                @$doj = date("d/m/Y", strtotime($_REQUEST['doj']));
                
                @$form_emp_lat = $_REQUEST['lat'];
                @$form_emp_lang = $_REQUEST['lang'];
                @$v_emp_primary_lat_2 = $_REQUEST['lat_2'];
                @$v_emp_primary_lang_2 = $_REQUEST['lang_2'];
                @$v_emp_primary_lat_3 = $_REQUEST['lat_3'];
                @$v_emp_primary_lang_3 = $_REQUEST['lang_3']; 
                @$v_emp_primary_lat_4 = $_REQUEST['lat_4'];
                @$v_emp_primary_lang_4 = $_REQUEST['lang_4'];
                @$v_emp_primary_lat_5 = $_REQUEST['lat_5'];
                @$v_emp_primary_lang_5 = $_REQUEST['lang_5'];
                @$v_emp_primary_lat_6 = $_REQUEST['lat_6'];
                @$v_emp_primary_lang_6 = $_REQUEST['lang_6'];


                if (isset($_POST['form_rml_id']) && isset($_POST['emp_form_name']) && isset($_POST['user_role'])) {
                    $strSQL  = oci_parse($objConnect, "INSERT INTO  RML_HR_APPS_USER (
                                                                    RML_ID, 
                                                                    EMP_NAME,
                                                                    MOBILE_NO,
                                                                    MAIL, 
                                                                    LINE_MANAGER_RML_ID,
                                                                    LINE_MANAGER_MOBILE, 
                                                                    DEPT_HEAD_RML_ID, 
                                                                    DEPT_HEAD_MOBILE_NO,	
                                                                    DESIGNATION,	
                                                                    DEPT_NAME,
                                                                    BRANCH_NAME,
                                                                    GENDER,																   
                                                                    R_CONCERN, 
                                                                    BLOOD, 
                                                                    USER_ROLE, 
                                                                    DOJ,
                                                                    IS_ACTIVE,
                                                                    IS_ACTIVE_LAT_LANG, 
                                                                    ATTN_RANGE_M,
                                                                    USER_CREATE_DATE,
                                                                    USER_APPROVED_BY,
                                                                    LAT, 
                                                                    LANG,
                                                                    PASS_MD5,
                                                                    LAT_2
                                                                    LAT_3,
                                                                    LAT_4,
                                                                    LAT_5,
                                                                    LAT_6,
                                                                    LANG_2,
                                                                    LANG_3,
                                                                    LANG_4,
                                                                    LANG_5,
                                                                    LANG_6
                                                                   ) 
												VALUES (
												'$form_rml_id',
												'$emp_form_name',
												'$emp_mobile',
												'$emp_mail',
												'$form_res1_id',
												'$form_res1_mobile',
												'$form_res2_id',
												'$form_res2_mobile',
												'$emp_designation',
												'$emp_dept',
												'$emp_branch',
												'$emp_gender',
												'$company_concern',
												'$emp_blood',
												'$user_role',
												TO_DATE('$doj','dd/mm/yyyy'),
												1,
												1,
												30,
												SYSDATE,
												'$emp_session_id',
												'$form_emp_lat',
												'$form_emp_lang',
                                                '202CB962AC59075B964B07152D234B70'
                                                '$v_emp_primary_lat_2',
                                                '$v_emp_primary_lat_3',
                                                '$v_emp_primary_lat_4',
                                                '$v_emp_primary_lat_5',
                                                '$v_emp_primary_lat_6',
                                                '$v_emp_primary_lang_2',
                                                '$v_emp_primary_lang_3',
                                                '$v_emp_primary_lang_4',
                                                '$v_emp_primary_lang_5',
                                                '$v_emp_primary_lang_6',
                                                 )");

                    if (oci_execute($strSQL)) {
                        $message = [
                            'text' => ' User is Created successfully.',
                            'status' => 'true',
                        ];
                        $_SESSION['noti_message'] = $message;
                        // header("location:" . $basePath . "/admin_setting/view/user_create.php");
                    }
                }
                ?>
            </div>
            </from>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>