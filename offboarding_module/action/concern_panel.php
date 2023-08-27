<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];



if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'searchUser') {

    $response = array();

    $strSQL = oci_parse(
        $objConnect,
        "SELECT ID,EMP_NAME,MOBILE_NO,RML_ID,R_CONCERN,DEPT_NAME,DESIGNATION  FROM RML_HR_APPS_USER WHERE R_CONCERN IN (SELECT R_CONCERN from RML_HR_APPS_USER WHERE IS_ACTIVE=1 AND RML_ID ='$emp_session_id') AND RML_ID LIKE '%" . trim($_POST['search']) . "%' FETCH FIRST 10 ROWS ONLY"
    );
    @oci_execute($strSQL); 
    while ($row = @oci_fetch_assoc($strSQL)) {
        $response[] = array("value" => $row['RML_ID'], "label" => $row['RML_ID'], 'id' => $row['ID'], 'data' => $row, 'concern' => $row['R_CONCERN']);
    }
    if (empty($response)) {
        $response[] = array("value" => 'Sorry! No Data Found!', "label" => null, 'id' => null);
    }
    echo json_encode($response);
}

// Check if the form is submitted create clearence 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'createClearence') {

    // Validate emp_id field
    if (!isset($_POST['emp_id']) || empty($_POST['emp_id'])) {
        $errors[] = 'Employee ID is required.';
    }

    if (!isset($_POST['emp_rml_id']) || empty($_POST['emp_rml_id'])) {
        $errors[] = 'Employee Concern ID is required.';
    }

    // Validate concern_id field
    if (!isset($_POST['concern_name']) || empty($_POST['concern_name'])) {
        $errors[] = 'Concern is required.';
    }

    $emp_id                     = ($_POST['emp_id']);
    $concern_name               = ($_POST['concern_name']);
    $department_id              = ($_POST['department_id']);
    $empConcernID               = ($_POST['emp_rml_id']);
    $emp_session_id             = $_SESSION['HR']['emp_id_hr'];
    // new variable
    $last_working_day = date("d/m/Y", strtotime($_REQUEST['last_working_day']));
    $resignation_date = date("d/m/Y", strtotime($_REQUEST['resignation_date']));
    //$last_working_day           = ($_POST['last_working_day']);
    //$resignation_date           = ($_POST['resignation_date']);
    $reason_of_resignation      = ($_POST['reason_of_resignation']);
    // new variable

    //$remarks                    = ($_POST['remarks']); // old variable rename to reason_of_resignation

    // If there are no errors, proceed with further processing
    if (empty($errors)) {
        if (count($department_id) > 0) {
            $allDepartmentID = implode(" ,", $department_id);
        } else {
            $allDepartmentID = 0;
        }

        //<---- EMP_CLEARENCE query with values from the database table  ---->
        $strSQL = oci_parse(
            $objConnect,
            "BEGIN EMP_CLEARENCE_CREATE( $emp_id,'$reason_of_resignation','$allDepartmentID','$emp_session_id','$concern_name','$last_working_day','$resignation_date','$reason_of_resignation');
			END;"
        );


        if (@oci_execute($strSQL)) {
            $message = [
                'text'   => 'Offboarding Created Successfully.',
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/offboarding_module/view/concern_panel/index.php");
            exit();
        } else {

            @$lastError = error_get_last();
            @$error = $lastError ? "" . $lastError["message"] . "" : "";
            $e = oci_error($strSQL);
            $message = [
                'text'   =>  preg_split("/\@@@@/", @$error)[1],
                'status' => 'false',
            ];

            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/offboarding_module/view/concern_panel/create.php");
            exit();
        }
    }
    $message                  = [
        'text'   => implode(' ', $errors),
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/offboarding_module/view/concern_panel/create.php");
    exit();
}


// Check if the form is submitted create clearence 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'idAssign') {
    // Validate emp_id field
    if (!isset($_POST['emp_id']) || empty($_POST['emp_id'])) {
        $errors[] = 'Employee ID is required.';
    }

    // Validate concern_id field
    if (!isset($_POST['concern_id']) || empty($_POST['concern_id'])) {
        $errors[] = 'Concern selection is required.';
    }
    if (!isset($_POST['department_id']) || empty($_POST['department_id'])) {
        $errors[] = 'Department selection is required.';
    }
    $emp_id        = ($_POST['emp_id']);
    $concern_id    = ($_POST['concern_id']);
    $department_id = ($_POST['department_id']);

    // If there are no errors, proceed with further processing
    if (empty($errors)) {

        foreach ($concern_id as $key => $concernName) {
            foreach ($department_id as $key => $depID) {
                $strSQL = oci_parse(
                    $objConnect,

                    "INSERT INTO HR_DEPT_CLEARENCE_CONCERN (
				         RML_HR_APPS_USER_ID,
						 R_CONCERN, 
						 RML_HR_DEPARTMENT_ID,
						 CREATED_BY,
						 CREATED_DATE)
                    VALUES (
				        $emp_id,
				        '$concernName',
						'$depID',
						'$emp_session_id',
						SYSDATE
						)"
                );
                $result = oci_execute($strSQL);

                if (!$result) {
                    $e = oci_error($strSQL);

                    $message = [
                        'text'   => htmlentities($e['message'], ENT_QUOTES),
                        'status' => 'false',
                    ];

                    $_SESSION['noti_message'] = $message;
                    header("location:" . $basePath . "/offboarding_module/view/concern_panel/id_assign.php");
                    exit();
                }
            }
        }


        $message                  = [
            'text'   => 'Offboarding ID Assign Created Successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/offboarding_module/view/concern_panel/id_assign_list.php");
        exit();
    }
    $message                  = [
        'text'   => implode(' ', $errors),
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/offboarding_module/view/concern_panel/id_assign.php");
    exit();
}



// Check if the form is submitted create clearence 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'approvalStatus') {
    // Validate emp_id field
    if (!isset($_GET['rml_emp_id']) || empty($_GET['rml_emp_id'])) {
        $errors[] = 'Employee ID is required.';
    }

    $emp_id        = ($_GET['rml_emp_id']);
    // If there are no errors, proceed with further processing
    if (empty($errors)) {

        $statusDataSQL = oci_parse(
            $objConnect,
            "SELECT 
                    d.ID, d.EMP_CLEARENCE_ID, d.CONCERN_NAME, 
                    d.DEPARTMENT_ID, d.APPROVAL_STATUS, d.APPROVE_BY, 
                    d.APPROVE_DATE, h.DEPT_NAME
                    FROM EMP_CLEARENCE_DTLS d
                    JOIN RML_HR_DEPARTMENT h ON d.DEPARTMENT_ID = h.ID 
                    WHERE  d.EMP_CLEARENCE_ID = {$emp_id}"
        );
        $result = oci_execute($statusDataSQL);
        $html = '';
        if ($result) {
            while ($statusRow = oci_fetch_array($statusDataSQL)) {

                $checked = $statusRow['APPROVAL_STATUS'] == 1 ? 'checked' : '';
                $html .=  '<div class="form-check-inline col-5">
                    <input disabled type="checkbox" class="form-check-input" ' . $checked . '  id="check_1">
                    <label style="opacity:1" class="form-check-label" for="check_1">' . $statusRow['DEPT_NAME'] . ' </label>
                </div><div class=" col-5">
                <input  type="text" id="emailBasic" class="form-control cust-control" 
                value="' . $statusRow['APPROVE_DATE'] . '" disabled placeholder="APPROVE DATE">
                </div>';
            }
        }
        if (empty($html)) {
            $html  = "<p class='text-info text-center'> No Department Selected!</p>";
        }
        echo  $html;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'offboarding_approval') {

    $check_list_id  = ($_POST['check_list_id']);
    $remarks        = ($_POST['remarks']);
   
    $strSQL  = oci_parse(
        $objConnect,
        "BEGIN
        CLEARENCE_APPROVAL(1,'$emp_session_id',$check_list_id,'$remarks');
        END;"
    );

    /*$strSQL  = oci_parse($objConnect, 
	"UPDATE EMP_CLEARENCE_DTLS SET  APPROVAL_STATUS  = 1,
        APPROVE_BY       = '$emp_session_id',
        APPROVE_DATE     = SYSDATE,
        REMARKS           = '$remarks'
        WHERE  ID       = '$check_list_id'");
		*/
    $result = oci_execute($strSQL);

    if (!$result) {
        $e = oci_error($strSQL);
        // echo htmlentities($e['message'], ENT_QUOTES);

        $message = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];

        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/offboarding_module/view/concern_panel/approval.php");
        exit();
    }

    $message = [
        'text'   => 'Successfully Approved Offboarding ID.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/offboarding_module/view/concern_panel/approval.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'offboarding_denine') {
    $check_list_id  = ($_GET['id']);
    $remarks        = ($_GET['remarks']);
    print_r(213123);
    die();


    $strSQL  = oci_parse($objConnect, "UPDATE EMP_CLEARENCE_DTLS SET  APPROVAL_STATUS  = 1,
        APPROVE_BY       = '$emp_session_id',
        APPROVE_DATE     = SYSDATE,
        REMARKS           = '$remarks'
        WHERE  ID       = '$check_list_id'");
    $result = oci_execute($strSQL);

    if (!$result) {
        $e = oci_error($strSQL);
        echo htmlentities($e['message'], ENT_QUOTES);
        die();
        $message = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];

        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/offboarding_module/view/concern_panel/approval.php");
        exit();
    }

    $message = [
        'text'   => 'Successfully Deine Offboarding ID.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/offboarding_module/view/concern_panel/approval.php");
    exit();
}
