<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];



if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'kpi_achivement') {
    $ACHIVEMENT          = $_POST['achivement'];
    $ACHIVEMENT_COMMENTS = $_POST['ACHIVEMENT_COMMENTS'];
    $key                 = $_POST['key'];
    $emp_id              = $_POST['emp_id'];
    $tab_id              = $_POST['tab_id'];
    $RATING_POINT        = $_POST['RATING_POINT'];
    $SCORE_POINT         = $_POST['SCORE_POINT'];
    $GRADE               = $_POST['GRADE'];
    print_r($_POST['ACHIVEMENT']);
    die();
    // Start a database transaction
    oci_parse($objConnect, 'BEGIN');
   

    if (isset($_POST['submit_draft'])) {
        if (count($ACHIVEMENT) > 0) {
            foreach ($ACHIVEMENT as $Idkey => $achValue) {
                $strSQL = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET ACHIVEMENT='$achValue', ACHIVEMENT_COMMENTS='$ACHIVEMENT_COMMENTS[$Idkey]' WHERE ID='$Idkey'");
                if (oci_execute($strSQL)) {
                    // Update successful
                } else {
                    // Update failed, rollback the transaction
                    oci_rollback($objConnect);
                    oci_rollback($strSQL);                  

                    $e                        = oci_error($strSQL);
                    $message                  = [
                        'text'   => htmlentities($e['message'], ENT_QUOTES),
                        'status' => 'false',
                    ];
                    $_SESSION['noti_message'] = $message;
                    echo "<script> window.location.href = '$basePath/pms_module/view/hod_panel/rating_form.php?key=$key&emp_id=$emp_id&tab_id=$tab_id'</script>";
                    exit;
                }
            }
            // If all updates were successful, commit the transaction
            oci_commit($objConnect);
        }
    } elseif (isset($_POST['submit_confirm'])) {
        if (count($ACHIVEMENT) > 0) {
            foreach ($ACHIVEMENT as $Idkey => $achValue) {
                $strSQL = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET ACHIVEMENT='$achValue', ACHIVEMENT_COMMENTS='$ACHIVEMENT_COMMENTS[$Idkey]', ACHIEVEMENT_LOCK_STATUS=1 WHERE ID='$Idkey'");
                if (oci_execute($strSQL)) {
                    // Update successful
                } else {
                    // Update failed, rollback the transaction
                    oci_rollback($objConnect);
                    oci_rollback($strSQL);
                    $e                        = oci_error($strSQL);
                    $message                  = [
                        'text'   => htmlentities($e['message'], ENT_QUOTES),
                        'status' => 'false',
                    ];
                    $_SESSION['noti_message'] = $message;
                    echo "<script> window.location.href = '$basePath/pms_module/view/hod_panel/rating_form.php?key=$key&emp_id=$emp_id&tab_id=$tab_id'</script>";
                    exit;
                }
            }
            // If all updates were successful, commit the transaction
            oci_commit($objConnect);

            $gradeSQL = oci_parse($objConnect, "UPDATE HR_PMS_EMP
                SET RATING_POINT='$RATING_POINT',
                SCORE_POINT='$SCORE_POINT',
                GRADE='$GRADE',
                GRADE_CONFIRM_DATE_HOD=SYSDATE
                WHERE ID='$tab_id");
            if (oci_execute($gradeSQL)) {
                // Update successful
            } else {
                // Update failed, rollback the transaction
                oci_rollback($objConnect);
                oci_rollback($gradeSQL);

                $e                        = oci_error($gradeSQL);
                $message                  = [
                    'text'   => htmlentities($e['message'], ENT_QUOTES),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '$basePath/pms_module/view/hod_panel/rating_form.php?key=$key&emp_id=$emp_id&tab_id=$tab_id'</script>";
                exit;
            }
            // If all updates were successful, commit the transaction
            oci_commit($objConnect);
        }
    }

    // Commit the outermost transaction
    oci_commit($objConnect);

    $message                  = [
        'text'   => 'KPI Achievement Saved successfully.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    echo "<script> window.location.href = '$basePath/pms_module/view/hod_panel/rating_form.php?key=$key&emp_id=$emp_id&tab_id=$tab_id'</script>";
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'pms_approved_denied') {

    $v_remarks               = $_POST['remarks'];
    $v_app_status            = $_POST['app_status'];
    $hr_pms_pms_emp_table_id = $_POST['hr_pms_pms_emp_table_id'];

    if ($v_app_status == 1) {
        $strSQL = oci_parse(
            $objConnect,
            "UPDATE HR_PMS_EMP SET 
            LINE_MANAGE_2_REMARKS='$v_remarks',LINE_MANAGER_2_STATUS=$v_app_status,LINE_MANAGER_2_UPDATED=SYSDATE
                      WHERE ID=$hr_pms_pms_emp_table_id"
        );
    }
    else if ($v_app_status == 0) {
        $strSQL = oci_parse(
            $objConnect,
            "UPDATE HR_PMS_EMP SET 
                      LINE_MANAGE_2_REMARKS='$v_remarks',
                      LINE_MANAGER_2_STATUS=$v_app_status,
                      LINE_MANAGER_2_UPDATED=SYSDATE,
                      LINE_MANAGE_1_REMARKS='',
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



if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'rating_form') {

    //eheck data exit or not exist
    $exitSql = oci_parse(
        $objConnect,
        "SELECT * FROM PMS_RATTING_CRITERIA_HOD WHERE HR_PMS_EMP_ID =" . $_POST['tab_id'] . " AND HR_PMS_LIST_ID = " . $_POST['key']
    );

    $exitData = array();

    if (oci_execute($exitSql)) {
        $exitData = oci_fetch_assoc($exitSql);
    }

    $JOB_KNOWLEDGE           = $_REQUEST['JOB_KNOWLEDGE'];
    $TRANSPERANCY            = $_REQUEST['TRANSPERANCY'];
    $OWNERSHIP_CAN_DO        = $_REQUEST['OWNERSHIP_CAN_DO'];
    $COMMUNICATION_SKILL     = $_REQUEST['COMMUNICATION_SKILL'];
    $TEAM_WORK               = $_REQUEST['TEAM_WORK'];
    $CREATIVITY_MAKER        = $_REQUEST['CREATIVITY_MAKER'];
    $LEADERSHIP              = $_REQUEST['LEADERSHIP'];
    $CUSTOMER_RESPONSIBILITY = $_REQUEST['CUSTOMER_RESPONSIBILITY'];
    $PROBLEM_SOLVING         = $_REQUEST['PROBLEM_SOLVING'];
    $WORK_ETHICS             = $_REQUEST['WORK_ETHICS'];
    $HR_PMS_EMP_ID           = $_POST['tab_id'];
    $HR_PMS_LIST_ID          = $_POST['key'];
    $EMP_ID                  = $_POST['emp_id'];


    if (isset($_POST['submit_draft']) && empty($exitData)) {

        $strSQL = oci_parse(
            $objConnect,
            "INSERT INTO PMS_RATTING_CRITERIA_HOD (
            JOB_KNOWLEDGE, TRANSPERANCY, 
            OWNERSHIP_CAN_DO, COMMUNICATION_SKILL, TEAM_WORK, 
            CREATIVITY_MAKER, LEADERSHIP, CUSTOMER_RESPONSIBILITY, 
            PROBLEM_SOLVING, WORK_ETHICS, HR_PMS_EMP_ID, 
            HR_PMS_LIST_ID, HOD_SUBMITTED) 
         VALUES (
            '$JOB_KNOWLEDGE','$TRANSPERANCY','$OWNERSHIP_CAN_DO','$COMMUNICATION_SKILL','$TEAM_WORK','$CREATIVITY_MAKER','$LEADERSHIP','$CUSTOMER_RESPONSIBILITY','$PROBLEM_SOLVING','$WORK_ETHICS','$HR_PMS_EMP_ID','$HR_PMS_LIST_ID',
            SYSDATE)"
        );


        if (oci_execute($strSQL)) {


            $message                  = [
                'text'   => "Successfully Draft Saved.",
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/pms_module/view/hod_panel/rating_form.php?key=$HR_PMS_LIST_ID&emp_id=$EMP_ID&tab_id=$HR_PMS_EMP_ID");

            exit();

        }
        else {
            @$lastError = error_get_last();
            @$error = $lastError ? "" . $lastError["message"] . "" : "";
            $message                  = [
                'text'   => (preg_split("/\@@@@/", @$error)[1]),
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/pms_module/view/hod_panel/rating_form.php?key=$HR_PMS_LIST_ID&emp_id=$EMP_ID&tab_id=$HR_PMS_EMP_ID");

            exit();
        }
    }

    if (isset($_POST['submit_confirm']) && empty($exitData)) {

        $strSQL = oci_parse(
            $objConnect,
            "INSERT INTO PMS_RATTING_CRITERIA_HOD (
            JOB_KNOWLEDGE, TRANSPERANCY, 
            OWNERSHIP_CAN_DO, COMMUNICATION_SKILL, TEAM_WORK, 
            CREATIVITY_MAKER, LEADERSHIP, CUSTOMER_RESPONSIBILITY, 
            PROBLEM_SOLVING, WORK_ETHICS, HR_PMS_EMP_ID, HOD_STATUS,
            HR_PMS_LIST_ID, HOD_SUBMITTED) 
            VALUES (
            '$JOB_KNOWLEDGE','$TRANSPERANCY','$OWNERSHIP_CAN_DO','$COMMUNICATION_SKILL','$TEAM_WORK','$CREATIVITY_MAKER','$LEADERSHIP','$CUSTOMER_RESPONSIBILITY','$PROBLEM_SOLVING','$WORK_ETHICS','$HR_PMS_EMP_ID', 1 ,'$HR_PMS_LIST_ID',
            SYSDATE)"
        );


        if (oci_execute($strSQL)) {

            $message                  = [
                'text'   => "Successfully Draft Saved.",
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/pms_module/view/hod_panel/rating_form.php?key=$HR_PMS_LIST_ID&emp_id=$EMP_ID&tab_id=$HR_PMS_EMP_ID");

            exit();

        }
        else {
            @$lastError = error_get_last();
            @$error = $lastError ? "" . $lastError["message"] . "" : "";
            $message                  = [
                'text'   => (preg_split("/\@@@@/", @$error)[1]),
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/pms_module/view/hod_panel/rating_form.php?key=$HR_PMS_LIST_ID&emp_id=$EMP_ID&tab_id=$HR_PMS_EMP_ID");

            exit();
        }
    }


    if ($exitData && isset($_POST['submit_draft']) || isset($_POST['submit_confirm'])) {

        if (isset($_POST['submit_draft'])) {

            $strSQL = oci_parse(
                $objConnect,
                "UPDATE PMS_RATTING_CRITERIA_HOD 
                SET JOB_KNOWLEDGE = '$JOB_KNOWLEDGE',TRANSPERANCY = '$TRANSPERANCY', OWNERSHIP_CAN_DO = '$OWNERSHIP_CAN_DO', COMMUNICATION_SKILL = '$COMMUNICATION_SKILL',TEAM_WORK = '$TEAM_WORK', CREATIVITY_MAKER = '$CREATIVITY_MAKER', LEADERSHIP = '$LEADERSHIP',CUSTOMER_RESPONSIBILITY = '$CUSTOMER_RESPONSIBILITY',PROBLEM_SOLVING = '$PROBLEM_SOLVING', WORK_ETHICS = '$WORK_ETHICS' WHERE  HR_PMS_EMP_ID =" . $_POST['tab_id'] . " AND HR_PMS_LIST_ID = " . $_POST['key']
            );
            if (oci_execute($strSQL)) {
                $message                  = [
                    'text'   => "Successfully Draft Saved.",
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" . $basePath . "/pms_module/view/hod_panel/rating_form.php?key=$HR_PMS_LIST_ID&emp_id=$EMP_ID&tab_id=$HR_PMS_EMP_ID");

                exit();
            }
            else {
                @$lastError = error_get_last();
                @$error = $lastError ? "" . $lastError["message"] . "" : "";
                $message                  = [
                    'text'   => (preg_split("/\@@@@/", @$error)[1]),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" . $basePath . "/pms_module/view/hod_panel/rating_form.php?key=$HR_PMS_LIST_ID&emp_id=$EMP_ID&tab_id=$HR_PMS_EMP_ID");

                exit();
            }

        }
        else if (isset($_POST['submit_confirm'])) {

            $strSQL = oci_parse(
                $objConnect,
                "UPDATE PMS_RATTING_CRITERIA_HOD 
                SET JOB_KNOWLEDGE = '$JOB_KNOWLEDGE',TRANSPERANCY = '$TRANSPERANCY', OWNERSHIP_CAN_DO = '$OWNERSHIP_CAN_DO', COMMUNICATION_SKILL = '$COMMUNICATION_SKILL',TEAM_WORK = '$TEAM_WORK', CREATIVITY_MAKER = '$CREATIVITY_MAKER', LEADERSHIP = '$LEADERSHIP',CUSTOMER_RESPONSIBILITY = '$CUSTOMER_RESPONSIBILITY',PROBLEM_SOLVING = '$PROBLEM_SOLVING', WORK_ETHICS = '$WORK_ETHICS', HOD_STATUS = 1 WHERE  HR_PMS_EMP_ID =" . $_POST['tab_id'] . " AND HR_PMS_LIST_ID = " . $_POST['key']
            );
            if (oci_execute($strSQL)) {
                $message                  = [
                    'text'   => "Successfully Draft Saved.",
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" . $basePath . "/pms_module/view/hod_panel/rating_form.php?key=$HR_PMS_LIST_ID&emp_id=$EMP_ID&tab_id=$HR_PMS_EMP_ID");

                exit();
            }
            else {
                @$lastError = error_get_last();
                @$error = $lastError ? "" . $lastError["message"] . "" : "";
                $message                  = [
                    'text'   => (preg_split("/\@@@@/", @$error)[1]),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" . $basePath . "/pms_module/view/hod_panel/rating_form.php?key=$HR_PMS_LIST_ID&emp_id=$EMP_ID&tab_id=$HR_PMS_EMP_ID");

                exit();
            }
        }
    }
}