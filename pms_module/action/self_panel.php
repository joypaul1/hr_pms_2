<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'kra_edit') {

    $editId = $_POST['editId'];
    $v_kra_name = $_POST['kra_name'];
    $HR_PMS_LIST_ID = $_POST['pms_title_id'];
    // print_r($HR_PMS_LIST_ID);
    $query = "UPDATE  HR_PMS_KRA_LIST SET KRA_NAME = '$v_kra_name', HR_PMS_LIST_ID = '$HR_PMS_LIST_ID' WHERE ID='$editId'";
    $strSQL  = oci_parse($objConnect, $query);

    if (oci_execute($strSQL)) {
        $message = [
            'text'   => 'KRA is Edited successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kra_edit.php?id=$editId'</script>";
    } else {

        $e = oci_error($strSQL);
        $message = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_kra_edit.php?id=$editId'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'kpi_edit') {

    $editId = $_POST['editId'];
    $v_kpi_name         = $_POST['kpi_name'];
    $v_kra_id           = $_POST['kra_id'];
    $v_weightage        = $_POST['weightage'];
    $v_target           = $_POST['target'];
    $v_eli_factor       = $_POST['eli_factor'];
    $v_ramarks          = $_POST['ramarks'];
    $v_ramarks          = $_POST['ramarks'];
    $v_achivement       = isset($_POST['achivement']) ? $_POST['achivement'] : '';
    $v_ACHIEVEMENT_LOCK_STATUS       = isset($_POST['v_ACHIEVEMENT_LOCK_STATUS']) ? $_POST['v_ACHIEVEMENT_LOCK_STATUS'] : '';
    if ($v_ACHIEVEMENT_LOCK_STATUS == 1) {
        $strSQL  = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET ACHIVEMENT='$v_achivement' WHERE ID='$editId'");
    } else {
        $strSQL  = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET 
                                           KPI_NAME='$v_kpi_name',
                                           HR_KRA_LIST_ID='$v_kra_id',
                                           WEIGHTAGE='$v_weightage',
                                           TARGET='$v_target',
                                           REMARKS='$v_ramarks',
                                           ELIGIBILITY_FACTOR='$v_eli_factor',
                                           UPDATED_DATE=SYSDATE 
                                           WHERE ID='$editId'");
    }


    if (oci_execute($strSQL)) {
        $message = [
            'text'   => 'KPI is Edited successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_list_edit.php?id=$editId'</script>";
    } else {

        $e = oci_error($strSQL);
        $message = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_list_edit.php?id=$editId'</script>";
    }
}
