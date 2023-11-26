<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connresaleoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'pro_edit') {
    $editId           = $_POST['editId'];
    $DISPLAY_PRICE    = $_POST['DISPLAY_PRICE'];
    $BODY_SIT         = $_POST['BODY_SIT'];
    $COLOR            = $_POST['COLOR'];
    $FUEL_TYPE        = $_POST['FUEL_TYPE'];
    $DESCRIPTION      = $_POST['DESCRIPTION'];
    $HISTORY          = $_POST['HISTORY'];
    $PUBLISHED_STATUS = $_POST['PUBLISHED_STATUS'];

    // Prepare the SQL statement
    $strSQL = oci_parse($objConnect, "
        UPDATE PRODUCT 
        SET 
            DISPLAY_PRICE = :display_price,
            BODY_SIT = :body_sit,
            COLOR = :color,
            FUEL_TYPE = :fuel_type,
            DESCRIPTION = :description,
            HISTORY = :history,
            PUBLISHED_STATUS = :published_status
        WHERE ID = :edit_id
    ");

    // Bind parameters
    oci_bind_by_name($strSQL, ':display_price', $DISPLAY_PRICE);
    oci_bind_by_name($strSQL, ':body_sit', $BODY_SIT);
    oci_bind_by_name($strSQL, ':color', $COLOR);
    oci_bind_by_name($strSQL, ':fuel_type', $FUEL_TYPE);
    oci_bind_by_name($strSQL, ':description', $DESCRIPTION);
    oci_bind_by_name($strSQL, ':history', $HISTORY);
    oci_bind_by_name($strSQL, ':published_status', $PUBLISHED_STATUS);
    oci_bind_by_name($strSQL, ':edit_id', $editId);

    // Execute the query
    if (oci_execute($strSQL)) {
        $message                  = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
    }
    else {
        $e                        = oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
    }

}