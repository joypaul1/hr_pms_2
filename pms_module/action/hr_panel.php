<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'year_create') {


    // Validation
    if (!isset($_POST['pms_name']) || empty($_POST['pms_name'])) {
        $errors[] = 'PMS Title  is required.';
    }
    if (!isset($_POST['pms_name']) || empty($_POST['pms_name'])) {
        $errors[] = 'PMS Title  is required.';
    }

    // Validate concern_id field
    if (!isset($_POST['start_date']) || empty($_POST['start_date'])) {
        $errors[] = 'Start Date is required.';
    }
    if (!isset($_POST['end_date']) || empty($_POST['end_date'])) {
        $errors[] = 'End Date is required.';
    }
    if (!isset($_POST['setp_status']) || empty($_POST['setp_status'])) {
        $errors[] = 'Setp Status is required.';
    }
    if (!isset($_POST['status']) || empty($_POST['setp_status'])) {
        $errors[] = 'Status is required.';
    }
    // Validation

    // If there are no errors, proceed with further processing
    if (!empty($errors)) {

        $START_DATE     = date('d-M-y', strtotime($_POST['start_date']));
        $END_DATE       = date('d-M-y', strtotime($_POST['end_date']));
        $v_pms_name     = $_POST['pms_name'];
        $status         = $_POST['status'];
        // $step_1_status  = ($_POST['step_status'] == 1) ? $_POST['step_status'] : 0;
        // $step_2_status  = ($_POST['step_status'] == 2) ? $_POST['step_status'] : 0;
        // $step_3_status  = ($_POST['step_status'] == 3) ? $_POST['step_status'] : 0;
        if ($status) {
            $query = "UPDATE HR_PMS_LIST SET IS_ACTIVE = 0 ";
            $strSQL = @oci_parse($objConnect, $query);
            $result = @oci_execute($strSQL);
        }

        $query = "INSERT INTO HR_PMS_LIST (PMS_NAME, CREATED_BY, CREATED_DATE, IS_ACTIVE, START_DATE, END_DATE) 
                VALUES ( 
                    '$v_pms_name',
                    '$emp_session_id',
                    SYSDATE,
                    $status, 
                    '$START_DATE',
                    '$END_DATE'
                    )";
        $strSQL = @oci_parse($objConnect, $query);
        $result = @oci_execute($strSQL);

        if (!$result) {
            $e = @oci_error($strSQL);
            $message = [
                'text'   => htmlentities($e['message'], ENT_QUOTES),
                'status' => 'false',
            ];

            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/pms_module/view/hr_panel/year.php");
            exit();
        }
        $message  = [
            'text'   => 'Year Created Successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/pms_module/view/hr_panel/year.php");
        exit();
    }

    $_SESSION['noti_message'] = $errors;
    header("location:" . $basePath . "/pms_module/view/hr_panel/year.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'year_edit') {


    // Validation
    if (!isset($_POST['editId']) || empty($_POST['editId'])) {
        $errors[] = 'Data Edit ID  is required.';
    }
    if (!isset($_POST['pms_name']) || empty($_POST['pms_name'])) {
        $errors[] = 'PMS Title  is required.';
    }

    // Validate concern_id field
    if (!isset($_POST['start_date']) || empty($_POST['start_date'])) {
        $errors[] = 'Start Date is required.';
    }
    if (!isset($_POST['end_date']) || empty($_POST['end_date'])) {
        $errors[] = 'End Date is required.';
    }
    if (!isset($_POST['setp_status']) || empty($_POST['setp_status'])) {
        $errors[] = 'Setp Status is required.';
    }
    if (!isset($_POST['status']) || empty($_POST['setp_status'])) {
        $errors[] = 'Status is required.';
    }
    // Validation

    // If there are no errors, proceed with further processing
    if (!empty($errors)) {
        $editId         = $_POST['editId'];
        $START_DATE     = date('d-M-y', strtotime($_POST['start_date']));
        $END_DATE       = date('d-M-y', strtotime($_POST['end_date']));
        $v_pms_name     = $_POST['pms_name'];
        $status         = $_POST['status'];
        $step_status_1  = isset($_POST['step_status_1']) ? $_POST['step_status_1'] : "";
        $step_status_2  = isset($_POST['step_status_2']) ? $_POST['step_status_2'] :"";
        $step_status_3  = isset($_POST['step_status_3']) ? $_POST['step_status_3'] : "";

        if ($status) {
            $query = "UPDATE HR_PMS_LIST SET IS_ACTIVE = 0 ";
            $strSQL = @oci_parse($objConnect, $query);
            $result = @oci_execute($strSQL);
        }

        $query = "UPDATE HR_PMS_LIST
            SET PMS_NAME = '$v_pms_name',
                CREATED_BY = '$emp_session_id',
                IS_ACTIVE = $status,
                START_DATE = '$START_DATE',
                END_DATE = '$END_DATE',
                STEP_1_STATUS = '$step_status_1',
                STEP_2_STATUS = '$step_status_2',
                STEP_3_STATUS = '$step_status_3'
            WHERE ID = $editId";
        // print_r($query);
        // die();
        $strSQL = @oci_parse($objConnect, $query);
        $result = @oci_execute($strSQL);


        if (!$result) {
            $e = @oci_error($strSQL);
            $message = [
                'text'   => htmlentities($e['message'], ENT_QUOTES),
                'status' => 'false',
            ];

            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/pms_module/view/hr_panel/year.php");
            exit();
        }
        $message  = [
            'text'   => 'Year Edited Successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/pms_module/view/hr_panel/year.php");
        exit();
    }

    $_SESSION['noti_message'] = $errors;
    header("location:" . $basePath . "/pms_module/view/hr_panel/year.php");
    exit();
}
