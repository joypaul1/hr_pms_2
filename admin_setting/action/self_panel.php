<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connloyaltyoracle.php');
require_once('../../config_file_path.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath = $_SESSION['basePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'handOverCard') {

    $emp_id = htmlentities($_GET['emp_id']);
    @$form_rml_id = $_POST['form_rml_id'];
    @$emp_form_name = $_POST['emp_form_name'];
    @$emp_mobile = $_POST['emp_mobile'];
    @$emp_dept = $_POST['emp_dept'];
    @$form_res1_id = $_POST['form_res1_id'];
    @$form_res1_mobile = $_POST['form_res1_mobile'];
    @$form_res2_id = $_POST['form_res2_id'];
    @$form_res2_mobile = $_POST['form_res2_mobile'];

    @$emp_role = $_POST['emp_role'];
    @$emp_doc = date("d/m/Y", strtotime($_POST['emp_doc']));
    @$form_emp_status = $_POST['emp_status'];
    @$traceable_status = $_POST['traceable_status'];
    @$form_emp_lat = $_POST['lat'];
    @$form_emp_lang = $_POST['lang'];
    @$v_emp_primary_lat_2 = $_POST['lat_2'];
    @$v_emp_primary_lang_2 = $_POST['lang_2'];
    @$v_emp_primary_lat_3 = $_POST['lat_3'];
    @$v_emp_primary_lang_3 = $_POST['lang_3'];
    @$v_emp_primary_lat_4 = $_POST['lat_4'];
    @$v_emp_primary_lang_4 = $_POST['lang_4'];
    @$v_emp_primary_lat_5 = $_POST['lat_5'];
    @$v_emp_primary_lang_5 = $_POST['lang_5'];
    @$v_emp_primary_lat_6 = $_POST['lat_6'];
    @$v_emp_primary_lang_6 = $_POST['lang_6'];
    $UPDATED_BY = $emp_session_id;

    $query = "UPDATE CARD_INFO
            SET HANDOVER_DATE =   TO_DATE('$HANDOVER_DATE','DD/MM/YYYY'),
            HANDOVER_TO_NAME = '$HANDOVER_TO_NAME',
            HANDOVER_MOBILE_NUMBER = '$HANDOVER_MOBILE_NUMBER',
            HANDOVER_STATUS = '$HANDOVER_STATUS',
            UPDATED_BY = '$UPDATED_BY',
            UPDATED_DATE=SYSDATE
            WHERE ID = '$cardID'";
            $strSQL = oci_parse($objConnect, "UPDATE RML_HR_APPS_USER SET
            EMP_NAME='$emp_form_name',
            MOBILE_NO='$emp_mobile',
            DEPT_NAME='$emp_dept',
            DOC='$emp_doc',
            LINE_MANAGER_RML_ID='$form_res1_id',
            LINE_MANAGER_MOBILE='$form_res1_mobile',
            DEPT_HEAD_RML_ID='$form_res2_id',
            DEPT_HEAD_MOBILE_NO='$form_res2_mobile',
            IS_ACTIVE='$form_emp_status',
            USER_ROLE='$emp_role',
            LAT='$form_emp_lat',
            LAT_2='$v_emp_primary_lat_2',
            LAT_3='$v_emp_primary_lat_3',
            LAT_4='$v_emp_primary_lat_4',
            LAT_5='$v_emp_primary_lat_5',
            LAT_6='$v_emp_primary_lat_6',
            LANG='$form_emp_lang',
            LANG_2='$v_emp_primary_lang_2',
            LANG_3='$v_emp_primary_lang_3',
            LANG_4='$v_emp_primary_lang_4',
            LANG_5='$v_emp_primary_lang_5',
            LANG_6='$v_emp_primary_lang_6',
            TRACE_LOCATION='$traceable_status'
            where RML_ID='$form_rml_id'");

    // Prepare the SQL statement
    $strSQL = @oci_parse($objConnect, $query);
    // Execute the query
    if (@oci_execute($strSQL)) {
        $message = [
            'text' => 'Data Updated successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/loyalty_card_module/view/self_panel/printing_on_process.php'</script>";
    } else {
        $e = @oci_error($strSQL);
        $message = [
            'text' => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/loyalty_card_module/view/self_panel/printing_on_process.php?id={$cardID}'</script>";
    }
}