<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];
if (empty($emp_session_id)) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'hod_approval') {

    $check_list_id  = ($_POST['check_list_id']);
    $remark_1        = ($_POST['remark_1']);
    $remark_2        = ($_POST['remark_2']);
    $remark_3        = ($_POST['remark_3']);

    $strSQL  = oci_parse(
        $objConnect,
        "UPDATE HOD_CLEARENCE_DTLS SET  APPROVAL_STATUS  = 1,
            APPROVE_BY                  = '$emp_session_id',
            APPROVE_DATE                = SYSDATE,
            ALL_DOCUMENTS_REMARKS       = '$remark_1',
            ANY_PAYMENT_DUE             = '$remark_2',
            OTHERS_REMARKS              = '$remark_3'
            WHERE  ID                   = $check_list_id"
    );
    $result = oci_execute($strSQL);

    $strhodApp = oci_parse(
        $objConnect,
        "UPDATE EMP_CLEARENCE SET HOD_STATUS =1 WHERE  ID= (SELECT EMP_CLEARENCE_ID FROM HOD_CLEARENCE_DTLS WHERE ID=$check_list_id)"
    );
    $result = oci_execute($strhodApp);




    if (!$result) {
        $e = oci_error($strSQL);
        $message = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];

        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/offboarding_module/view/lm_panel/hod_approval.php");
        exit();
    }

    $message = [
        'text'   => 'Successfully Approved Offboarding ID.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/offboarding_module/view/lm_panel/hod_approval.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'offboarding_approval') {

    $check_list_id  = ($_POST['check_list_id']);
    $remarks        = ($_POST['remarks']);
    $strSQL  = oci_parse($objConnect, "begin CLEARENCE_APPROVAL(1,'$emp_session_id',$check_list_id,'$remarks'); end;");

    $result = oci_execute($strSQL);

    if (!$result) {
        $e = oci_error($strSQL);
        $message = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];

        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/offboarding_module/view/lm_panel/approval.php");
        exit();
    }

    $message = [
        'text'   => 'Successfully Approved Offboarding ID.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/offboarding_module/view/lm_panel/approval.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'offboarding_denine') {
    $check_list_id  = ($_GET['id']);
    $remarks        = ($_GET['remarks']);

    $strSQL  = oci_parse($objConnect, "UPDATE EMP_CLEARENCE_DTLS SET  APPROVAL_STATUS  = 0,
        APPROVE_BY       = '$emp_session_id',
        APPROVE_DATE     = SYSDATE,
        REMARKS           = '$remarks'
        WHERE  ID       = '$check_list_id'");
    $result = oci_execute($strSQL);

    if (!$result) {
        $e = oci_error($strSQL);
        $message = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];

        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/offboarding_module/view/lm_panel/approval.php");
        exit();
    }

    $message = [
        'text'   => 'Successfully Deine Offboarding ID.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/offboarding_module/view/lm_panel/approval.php");
    exit();
}
