<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"])  == 'searchData') { 
    // echo 'Searching';
    // die();
    $deedSQL  = oci_parse($objConnect, "select * from LEASE_ALL_INFO_ERP
    where DOCNUMBR='XTA00030'");
    oci_execute($deedSQL);
    $deedSQLData = oci_fetch_assoc($deedSQL);
    print('<pre>');
    print_r($deedSQLData);
    print('</pre>');

}