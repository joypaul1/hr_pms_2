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
    $start_date = $_POST['start_date'];
    $RMLID = $_POST['RML_ID'];
    echo "<script> window.location.href = '{$basePath}/location_track_module/view/self_panel/create.php?rml_id=$RMLID&date=$start_date'</script>";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'getCurentLocation') {
    // $start_date = $_POST['start_date'];
     $RMLID = $_POST['RML_ID'];
     echo $RMLID;
    // echo "<script> window.location.href = '{$basePath}/location_track_module/view/self_panel/create.php?rml_id=$RMLID&date=$start_date'</script>";
}

