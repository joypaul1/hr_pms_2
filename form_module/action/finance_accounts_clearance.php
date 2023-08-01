
<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
// $baseUrl        = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
// $basePath       = $baseUrl . '/rHRT';

$basePath =  $_SESSION['basePath'];

// Check if the form is submitted create clearence 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $clearanceSQL  = oci_parse($objConnect, "SELECT A.ID, A.RML_HR_APPS_USER_ID FROM  EMP_CLEARENCE A");
    oci_execute($clearanceSQL);
    $checkEmpClearnence = false;

    $EMP_CLEARENCE_ID = null;
    while ($clearanceEmpData = oci_fetch_assoc($clearanceSQL)) {
        if ($clearanceEmpData['RML_HR_APPS_USER_ID'] == $_REQUEST['emp_id']) {
            $checkEmpClearnence = true;
            $EMP_CLEARENCE_ID = $clearanceEmpData['ID'];
        }
    }


    $checkAccClearnenceForm = false;
    $accountsSQL  = oci_parse($objConnect, "SELECT A.EMP_CLEARENCE_ID  FROM  ACCOUNTS_CLEARENCE_FORMS A");
    // print "<pre>";

    oci_execute($accountsSQL);

    while ($clearanceEmpData = oci_fetch_assoc($accountsSQL)) {
        if ($EMP_CLEARENCE_ID == $clearanceEmpData['EMP_CLEARENCE_ID']) {
            $checkAccClearnenceForm = true;
        }
    }

    if ($checkAccClearnenceForm) {
        $message = [
            'text' => "Sorry!Already Created this form.",
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/form_module/view/finance_accounts_clearance_list.php");
        exit();
    }


    if ($checkEmpClearnence) {

        foreach ($_REQUEST['data_type'] as $key => $data_type) {

            try {
                $TITLE_DETAILS = $data_type;
                $OWNERSHIP_REMARKS = $_REQUEST[$data_type . '_min_months_req'] ? $_REQUEST[$data_type . '_min_months_req'] : " ";
                $COMPANY_PORTION = $_REQUEST[$data_type . '_company_portion'] ? $_REQUEST[$data_type . '_company_portion'] : 0;
                $EMP_PORTION = $_REQUEST[$data_type . '_employee_portion'] ? $_REQUEST[$data_type . '_employee_portion'] : 0;
                $PAID_BY_COMPANY = $_REQUEST[$data_type . '_paid_by_company'] ? $_REQUEST[$data_type . '_paid_by_company'] : 0;
                $PAID_BY_EMP = $_REQUEST[$data_type . '_paid_by_employee'] ? $_REQUEST[$data_type . '_paid_by_employee'] : 0;
                $DUE_FROM_EMP = $_REQUEST[$data_type . '_due_from_employee'] ?  $_REQUEST[$data_type . '_due_from_employee'] : 0;
                $REMARKS = $_REQUEST['remarks'][$key] ? $_REQUEST['remarks'][$key] : " ";

                $accountsClearanceSQL  = oci_parse(
                    $objConnect,
                    "INSERT INTO ACCOUNTS_CLEARENCE_FORMS (
                        TITLE_DETAILS, EMP_CLEARENCE_ID, 
                        OWNERSHIP_REMARKS, COMPANY_PORTION, EMP_PORTION, 
                        PAID_BY_EMP, PAID_BY_COMPANY, DUE_FROM_EMP, 
                        REMARKS, CREATED_DATE, CREATED_BY) 
                    VALUES ('$TITLE_DETAILS',
                        $EMP_CLEARENCE_ID,
                        '$OWNERSHIP_REMARKS',
                        $COMPANY_PORTION,
                        $EMP_PORTION,
                        $PAID_BY_EMP,
                        $PAID_BY_COMPANY,
                        $DUE_FROM_EMP,
                        '$REMARKS',
                        SYSDATE,'$emp_session_id')"
                );

               

                $result =  oci_execute($accountsClearanceSQL);

                if (!$result) {
                    $lastError = error_get_last();
                    $error = $lastError ? "" . $lastError["message"] . "" : "";
                    preg_split("/\@@@@/", @$error)[1];
                    $message = [
                        'text' =>  $error,
                        'status' => 'false',
                    ];
                    $_SESSION['noti_message'] = $message;
                    header("location:" . $basePath . "/form_module/view/finance_accounts_clearance_list.php");
                    exit();
                }
            } catch (\Exception $ex) {

                $message = [
                    'text' => $ex->getMessage(),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" . $basePath . "/form_module/view/finance_accounts_clearance_list.php");
                exit();
            }
        }
    } else {

        $message = [
            'text' => "Sorry! This employee does not have clearnence information.",
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/form_module/view/finance_accounts_clearance_list.php");
        exit();
    }
    $message = [
        'text' =>"Successfully Created Form.",
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/form_module/view/finance_accounts_clearance_list.php");
    // header("location:" . $basePath . "/document/accounts_form.php?accountclearenceId=" . $EMP_CLEARENCE_ID);
    exit();
}
