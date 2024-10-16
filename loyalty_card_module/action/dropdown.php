<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
require_once('../../config_file_path.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'searchUser') {
    $response = array();
    $query = "SELECT CUSTOMER_NAME, CUSTOMER_MOBILE_NO, PARTY_ADDRESS, REG_NO, ENG_NO,REF_CODE, CHASSIS_NO,PAMTMODE,PRODUCT_CODE_NAME FROM LEASE_ALL_INFO_ERP WHERE REF_CODE LIKE '%" . trim($_GET['search']) . "%' OR CHASSIS_NO LIKE '%" . trim($_GET['search']) . "%' FETCH FIRST 10 ROWS ONLY";

    $strSQL = oci_parse($objConnect, $query);
    @oci_execute($strSQL);
    while ($row = @oci_fetch_assoc($strSQL)) {
        $response[] = array("value" => $row['CHASSIS_NO'], "label" => $row['CUSTOMER_NAME'].' / Chassis No.:' .$row['CHASSIS_NO']. ' / Reg. No.:'. $row['REG_NO']. ' / Ref. Code:' . $row['REF_CODE'], 'id' => $row['CHASSIS_NO'], 'data' => $row, 'searchData'=>trim($_GET['search']) );
    }
    if (empty($response)) {
        $response[] = array("value" => 'Sorry! No Data Found!', "label" => null, 'id' => null);
    }
    echo json_encode($response);
}
