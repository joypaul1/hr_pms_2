<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$basePath =  $baseUrl . '/rHRT';

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  trim($_POST["actionType"]) == 'searchUser') {

    $response = array();
    
    $strSQL  = oci_parse(
        $objConnect,
        "SELECT ID,EMP_NAME,MOBILE_NO,RML_ID,R_CONCERN,DEPT_NAME,DESIGNATION  FROM RML_HR_APPS_USER WHERE RML_ID LIKE '%" . trim($_POST['search']) . "%' FETCH FIRST 10 ROWS ONLY"
    );
    @oci_execute($strSQL);
    while ($row = @oci_fetch_assoc($strSQL)) {
        $response[] = array("value" => $row['RML_ID'], "label" => $row['RML_ID'], 'id' => $row['ID'], 'data' => $row);
    }
    if (empty($response)) {
        $response[] = array("value" => 'Sorry! No Data Found!', "label" => null, 'id' => null);
    }
    echo json_encode($response);
}


// Check if the form is submitted create clearence 
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  trim($_POST["actionType"]) == 'create') {
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
    $emp_id = trim($_POST['emp_id']);
    $concern_id = trim($_POST['concern_id']);
    $department_id = ($_POST['department_id']);

    // If there are no errors, proceed with further processing
    if (empty($errors)) {
        foreach ($department_id as $key => $depID) {
            $strSQL  = oci_parse(
                $objConnect,
                "INSERT INTO HR_DEPT_CLEARENCE_CONCERN (RML_HR_APPS_USER_ID,R_CONCERN, RML_HR_DEPARTMENT_ID,CREATED_BY,CREATED_DATE)
                VALUES (1,$concern_id,$depID,$emp_session_id,SYSDATE)"
            );
            $result = oci_execute($strSQL);

            if (!$result) {
                $e = oci_error($strSQL);
                // trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                $message = [
                    'text' =>  htmlentities($e['message']),
                    'status' => 'false',
                ];

                $_SESSION['noti_message'] = $message;
                header("location:" . $basePath . "/clearence_module/view/hr_panel/create.php");
                exit();
            }
        }

        $message = [
            'text' => 'Clearence Created Successfully.',
            'status' => 'True',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/clearence_module/view/hr_panel/create.php");
        exit();
    }
    $message = [
        'text' => implode(' ', $errors),
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/clearence_module/view/hr_panel/create.php");
    exit();
}
