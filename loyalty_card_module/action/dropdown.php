<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
require_once('../../config_file_path.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'searchUser') {
    $response = array();
    $query = "SELECT  REF_CODE, CUSTOMER_NAME, PARTY_ADDRESS, CUSTOMER_MOBILE_NO, REG_NO, ENG_NO, CHASSIS_NO  FROM LEASE_ALL_INFO_ERP WHERE REF_CODE LIKE '%" . trim($_GET['search']) . "%' FETCH FIRST 10 ROWS ONLY";
    $strSQL = oci_parse($objConnect, $query);
    @oci_execute($strSQL);
    while ($row = @oci_fetch_assoc($strSQL)) {
        $response[] = array("value" => $row['REF_CODE'], "label" => $row['REF_CODE'], 'id' => $row['REF_CODE'], 'data' => $row, 'concern' => $row['REF_CODE']);
    }
    if (empty($response)) {
        $response[] = array("value" => 'Sorry! No Data Found!', "label" => null, 'id' => null);
    }
    echo json_encode($response);
}
