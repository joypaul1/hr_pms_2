<?php
session_start();
require_once ('../../inc/config.php');
require_once ('../../inc/connloyaltyoracle.php');
require_once ('../../config_file_path.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath = $_SESSION['basePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'createCard') {

    // echo "<script> window.open( '{$basePath}/location_track_module/view/self_panel/create.php', '_blank').focus();</script>";
    echo "<script> window.location.href = '{$basePath}/location_track_module/view/self_panel/create.php'</script>";

    // Prepare the SQL statement
    // $strSQL = @oci_parse($objConnect, $query);
    // // Execute the query
    // if (@oci_execute($strSQL)) {
    //     $message                  = [
    //         'text'   => 'Data Saved successfully.',
    //         'status' => 'true',
    //     ];
    //     $_SESSION['noti_message'] = $message;
    //     echo "<script> window.location.href = '{$basePath}/loyalty_card_module/view/self_panel/cardDetails.php?chas_no={$CHS_NO}'</script>";
    // } else {
    //     $e                        = @oci_error($strSQL);
    //     $message                  = [
    //         'text'   => htmlentities($e['message'], ENT_QUOTES),
    //         'status' => 'false',
    //     ];
    //     $_SESSION['noti_message'] = $message;
    //     echo "<script> window.location.href = '{$basePath}/loyalty_card_module/view/self_panel/create.php'</script>";
    // }
}

