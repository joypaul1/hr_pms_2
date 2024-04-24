<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('hr-leave-assign')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$v_excel_download = 0;

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between" style="padding: 1.0% 1rem">
            <div href="#" style="font-size: 18px;font-weight:700">
                <i class="menu-icon tf-icons bx bx-edit" style="margin:0;font-size:30px"></i>Yearly Leave Assign Create
            </div>
            <div><a href="<?php echo ($basePath . '/leave_module/view/hr_panel/assign.php'); ?>" class="btn btn-sm btn-info"><i class="menu-icon tf-icons bx bx-message-alt-add" style="margin:0;"></i>Yearly Leave Assign Report</a>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row justify-content-center">

                    <div class="col-sm-3">
                        <label class="form-label" for="title">Select Company</label>
                        <select name="r_concern" class="form-control text-center cust-control">
                            <option selected value="">-- &nbsp; --</option>
                            <?php
                            $strSQL  = oci_parse($objConnect, "SELECT UNIQUE(R_CONCERN) AS R_CONCERN FROM RML_HR_APPS_USER ORDER BY R_CONCERN");
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {
                            ?>
                                <option value="<?php echo $row['R_CONCERN']; ?>" <?php echo (isset($_POST['r_concern']) && $_POST['r_concern'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>><?php echo $row['R_CONCERN']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="title">Select Leave Year</label>
                        <select required="" name="leave_year" class="form-control text-center cust-control">
                            <?php
                            $strSQL  = oci_parse($objConnect, "select YEAR from RML_HR_EMP_LEAVE_PERIOD WHERE IS_ACTIVE=1");
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {
                            ?>
                                <option value="<?php echo $row['YEAR']; ?>"><?php echo $row['YEAR']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="title">Select Employee Type</label>
                        <select name="v_doj" class="form-control text-center cust-control">
                            <option value="">-- &nbsp; --</option>
                            <option <?php echo (isset($_POST['v_doj']) && $_POST['v_doj'] == 'Permanent') ? 'selected="selected"' : ''; ?> value="Permanent">Permanent</option>
                            <option <?php echo (isset($_POST['v_doj']) && $_POST['v_doj'] == 'Probetional') ? 'selected="selected"' : ''; ?> value="Probetional">Probetional</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                            <input class="form-control btn btn-sm btn-primary" type="submit" value="Data Process">
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>

    <?php
    if (isset($_POST['leave_year'])) {
        $user_id    = $_SESSION['HR_APPS']['emp_id_hr'];
        $r_concern  = $_REQUEST['r_concern'];
        $leave_year = $_REQUEST['leave_year'];
        $v_doj      = $_REQUEST['v_doj'];
        if ($v_doj == 'Permanent') {
            $processSQL  = oci_parse(
                $objConnect,
                "BEGIN FOR X IN (SELECT RML_ID FROM  RML_HR_APPS_USER WHERE DOJ IS NOT NULL AND DOC IS NOT NULL AND IS_ACTIVE = 1 AND R_CONCERN ='$r_concern')
                LOOP
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','EL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','SL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','STL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','CL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','BL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','PGL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','PML','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','MTL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','PTL','$user_id','');
                END LOOP;
                END;"
            );
        } else {
            $processSQL  = oci_parse(
                $objConnect,
                "BEGIN FOR X IN (SELECT RML_ID FROM  RML_HR_APPS_USER WHERE DOC IS NULL AND DOJ IS NOT NULL AND IS_ACTIVE = 1 AND R_CONCERN ='$r_concern')
                LOOP
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','SL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','STL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','CL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','BL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','PGL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','PML','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','MTL','$user_id','');
                    RML_HR_LEAVE_ALLOCATION(X.RML_ID,'$leave_year','PTL','$user_id','');
                END LOOP;
                END;"
            );
        }


        ini_set('max_execution_time', 0);
        set_time_limit(40000);
        ini_set('memory_limit', '-1');
        if (oci_execute($processSQL)) {
            $message = [
                'text' =>  "Apps Data Process Successfully.",
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
            // echo 'Apps Data Process Done.';
        } else {
            @$lastError = error_get_last();
            @$error = $lastError ? "" . $lastError["message"] . "" : "";
            $message = [
                'text' => (preg_split("/\@@@@/", @$error)[1]),
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
        }
    }
    ?>
</div>
<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>