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
