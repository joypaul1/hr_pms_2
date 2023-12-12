<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connresaleoracle.php');
require_once('../../config_file_path.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

// echo gettype($_GET["actionType"]);
// echo $_GET["brand_id"];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'brand_wise_category') {

    $brandID = $_GET["brand_id"];
    // Prepare the SQL statement
    $QEURY_SQL = oci_parse($objConnect, "SELECT UNIQUE CATEGORY  from PRODUCT WHERE BRAND_ID=$brandID");

    if (@oci_execute($QEURY_SQL)) {
        while ($row = oci_fetch_assoc($QEURY_SQL)) {
            $brand_wise_cat_data[] = array(
                "value" => $row['CATEGORY'],
            );
        }
        $response = array( "status" => "true", "data" => $brand_wise_cat_data );
        print_r(json_encode($response));
    }
    else {
        $response = array( "status" => "false", "message" => "Error executing SQL query" );
        print_r(json_encode($response));
    }
    // End CATEGORY Information====================================================

    oci_close($objConnect);

}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'category_wise_model') {

    $category = $_GET["categoryData"];
    // Prepare the SQL statement
    $QEURY_SQL = oci_parse($objConnect, "SELECT UNIQUE MODEL  from PRODUCT WHERE CATEGORY='$category'");

    if (@oci_execute($QEURY_SQL)) {
        while ($row = oci_fetch_assoc($QEURY_SQL)) {
            $brand_wise_cat_data[] = array(
                "value" => $row['MODEL'],
            );
        }
        $response = array( "status" => "true", "data" => $brand_wise_cat_data );
        print_r(json_encode($response));
    }
    else {
        $response = array( "status" => "false", "message" => "Error executing SQL query" );
        print_r(json_encode($response));
    }
    // End CATEGORY Information====================================================

    oci_close($objConnect);


}  
