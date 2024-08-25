<?php
session_start();
require_once ('../../inc/config.php');
require_once ('../../inc/connoracle.php');
require_once ('../../config_file_path.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'searchUser') {
    $response = array();
    $query = "SELECT RML_ID, EMP_NAME, MOBILE_NO
        FROM RML_HR_APPS_USER
        WHERE LOWER(RML_ID) LIKE LOWER('%" . trim($_GET['search']) . "%')
        OR LOWER(EMP_NAME) LIKE LOWER('%" . trim($_GET['search']) . "%')
        AND ROWNUM <= 10
        AND IS_ACTIVE = 1
        ORDER BY RML_ID";
    $strSQL = oci_parse($objConnect, $query);
    @oci_execute($strSQL);
    while ($row = @oci_fetch_assoc($strSQL)) {
        $response[] = array("value" => $row['RML_ID'], "label" => $row['RML_ID'] . ' / NAME: ' . $row['EMP_NAME'] . ' / Mobile: ' . $row['MOBILE_NO'], 'id' => $row['RML_ID'], 'searchData' => trim($_GET['search']));
    }
    if (empty($response)) {
        $response[] = array("value" => 'Sorry! No Data Found!', "label" => null, 'id' => null);
    }
    echo json_encode($response);
}
