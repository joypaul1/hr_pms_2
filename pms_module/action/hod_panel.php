<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'pms_approved_denied') {

    $v_remarks               = $_POST['remarks'];
    $v_app_status            = $_POST['app_status'];
    $hr_pms_pms_emp_table_id = $_POST['hr_pms_pms_emp_table_id'];
   
    if ($v_app_status == 1) {
        $strSQL = oci_parse(
            $objConnect,
            "update HR_PMS_EMP SET 
            LINE_MANAGE_2_REMARKS='$v_remarks',LINE_MANAGER_2_STATUS=$v_app_status,LINE_MANAGER_2_UPDATED=SYSDATE
                      WHERE ID=$hr_pms_pms_emp_table_id"
        );
    }
    else if ($v_app_status == 0) {
        $strSQL = oci_parse(
            $objConnect,
            "update HR_PMS_EMP SET 
                      LINE_MANAGE_2_REMARKS='$v_remarks',
                      LINE_MANAGER_2_STATUS=$v_app_status,
                      LINE_MANAGER_2_UPDATED=SYSDATE,
                      LINE_MANAGER_1_REMARKS='',
                      LINE_MANAGER_1_STATUS='',
                      LINE_MANAGER_1_UPDATED='',
                      SELF_SUBMITTED_STATUS=''
                      WHERE ID=$hr_pms_pms_emp_table_id"
        );
    }

    if (oci_execute($strSQL)) {
      
        if ($v_app_status == 1) {
            $message                  = [
                'text'   => 'PMS Approved successfully.',
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href ='$basePath/pms_module/view/hod_panel/approval.php'</script>";
        }
        else {
            $message                  = [
                'text'   => 'PMS Denied successfully.',
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href ='$basePath/pms_module/view/hod_panel/approval.php'</script>";
        }

    }
    else {

        $e                        = oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '$basePath/pms_module/view/hod_panel/approval.php'</script>";
    }

}