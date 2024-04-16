<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connloyaltyoracle.php');
require_once('../../config_file_path.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];
$folderPath     = $rs_img_path;
ini_set('memory_limit', '2560M');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'createCard') {

    $REF_NO                 = $_POST['REF_CODE'];
    $CUSTOMER_NAME          = $_POST['CUSTOMER_NAME'];
    $CUSTOMER_MOBILE        = $_POST['CUSTOMER_MOBILE_NO'];
    $REG_NO                 = $_POST['REG_NO'];
    $ENG_NO                 = $_POST['ENG_NO'];
    $CHS_NO                 = $_POST['CHASSIS_NO'];
    $PARTY_ADDRESS          = $_POST['PARTY_ADDRESS'];
    $VALID_START_DATE       = date("d/m/Y", strtotime($_REQUEST['start_date']));
    $VALID_END_DATE         = date("d/m/Y", strtotime($_REQUEST['end_date']));
    $CARD_TYPE_ID           = $_POST['card_type'];
    $CREATED_BY              = $emp_session_id;
    $UPDATED_BY              = $emp_session_id;
    // $CREATED_DATE              = SYSDATE;

    $query = "INSERT INTO CARD_INFO (
    CUSTOMER_NAME, CUSTOMER_MOBILE, REF_NO, ENG_NO, REG_NO, CHS_NO, VALID_START_DATE, VALID_END_DATE,CARD_TYPE_ID,HANDOVER_STATUS, CREATED_DATE, CREATED_BY, UPDATED_DATE,UPDATED_BY)
    VALUES (
    '$CUSTOMER_NAME',
    '$CUSTOMER_MOBILE',
    '$REF_NO',
    '$ENG_NO',
    '$REG_NO',
    '$CHS_NO',
    TO_DATE('$VALID_START_DATE','DD/MM/YYYY'),
    TO_DATE('$VALID_END_DATE','DD/MM/YYYY'),
    '$CARD_TYPE_ID',
    0,
    SYSDATE,
    '$CREATED_BY',
    SYSDATE,
    '$UPDATED_BY')";

    // Prepare the SQL statement
    $strSQL = @oci_parse($objConnect, $query);
    // Execute the query
    if (@oci_execute($strSQL)) {
        $message                  = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/loyalty_card_module/view/self_panel/create.php'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/loyalty_card_module/view/self_panel/create.php'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'handOverCard') {

    $cardID                         = $_POST['cardID'];
    $HANDOVER_DATE                  = date("d/m/Y", strtotime($_REQUEST['HANDOVER_DATE']));
    $HANDOVER_TO_NAME               = $_POST['HANDOVER_TO_NAME'];
    $HANDOVER_MOBILE_NUMBER         = $_POST['HANDOVER_MOBILE_NUMBER'];
    $HANDOVER_STATUS                = 1;
    $UPDATED_BY                     = $emp_session_id;

    $query = "UPDATE CARD_INFO
    SET HANDOVER_DATE =   TO_DATE('$HANDOVER_DATE','DD/MM/YYYY'),
    HANDOVER_TO_NAME = '$HANDOVER_TO_NAME',
    HANDOVER_MOBILE_NUMBER = '$HANDOVER_MOBILE_NUMBER',
    HANDOVER_STATUS = '$HANDOVER_STATUS',
    UPDATED_BY = '$UPDATED_BY',
    UPDATED_DATE=SYSDATE
    WHERE ID = '$cardID'";

    // Prepare the SQL statement
    $strSQL = @oci_parse($objConnect, $query);
    // Execute the query
    if (@oci_execute($strSQL)) {
        $message                  = [
            'text'   => 'Data Updated successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/loyalty_card_module/view/self_panel/list.php'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/loyalty_card_module/view/self_panel/hand_over_card.php?id={$cardID}'</script>";
    }
}
