<?php

session_start();
require_once('../../inc/config.php');
require_once('../../inc/connresaleoracle.php');
require_once('../../config_file_path.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];
$baseUrl        = $_SESSION['baseUrl'];
$folderPath     = $rs_img_path;


ini_set('memory_limit', '2560M');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'create') {
    $NAME     = $_POST['NAME'];
    $TYPE     = $_POST['TYPE'];
    $COMMENTS = $_POST['COMMENTS'];
    $PIC_URL  = '';
    $STATUS   = $_POST['STATUS'];

    if (!empty($_FILES["image"]["name"])) {

        $image       = $_FILES['image'];
        $fileName    = $image["name"];
        $fileTmpName = $image["tmp_name"];
        $fileSize    = $image["size"];
        $fileType    = $image["type"];
        $fileError   = $image["error"];
        //Check if the file is an actual image
        $validExtensions = array( "jpg", "jpeg", "png", "gif" );
        $fileExtension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $validExtensions)) {
            // $imageStatus             = '';
            // $_SESSION['imageStatus'] = $imageStatus;
            $message                  = [
                'text'   => 'Invalid file_' . $key . 'format. Allowed formats: JPG, JPEG, PNG, GIF',
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/create.php'</script>";
            exit();
        }

        $imgStorePath = $folderPath . 'client_image/';
        pathExitOrCreate($imgStorePath); // check if folder exists or create

        // Define a custom file name
        $customFileName = 'client_' . random_strings(4) . '_' . time() . "." . $fileExtension;

        // Define the target path with the custom file name
        $targetPath_fullImgName = $imgStorePath . $customFileName;
        // image store folder path name is relative to  the image store
        if (move_uploaded_file($fileTmpName, $targetPath_fullImgName)) {
            // image final name for database store name
            $imageFinalName = str_replace('../', '', $targetPath_fullImgName);
            $PIC_URL        = $imageFinalName;
        }
        else {
            $message                  = [
                'text'   => "Something went wrong file uploading!",
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/create.php'</script>";
            exit();
        }

    }
    // Prepare the SQL statement
    $strSQL = @oci_parse($objConnect, "INSERT INTO CLIENT_COMMENTS (
         PIC_URL, NAME, TYPE, COMMENTS, STATUS) 
            VALUES (
            '$PIC_URL',
            '$NAME',
            '$TYPE',
            '$COMMENTS',
            '$STATUS'
            )");

    // Execute the query
    if (@oci_execute($strSQL)) {
        $message                  = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/create.php'</script>";
    }
    else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/create.php'</script>";
    }



}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'edit') {
    $editId   = $_POST['editId'];
    $NAME     = $_POST['NAME'];
    $TYPE     = $_POST['TYPE'];
    $COMMENTS = $_POST['COMMENTS'];
    $STATUS   = $_POST['STATUS'];

    if (!empty($_FILES["image"]["name"])) {

        $image       = $_FILES['image'];
        $fileName    = $image["name"];
        $fileTmpName = $image["tmp_name"];
        $fileSize    = $image["size"];
        $fileType    = $image["type"];
        $fileError   = $image["error"];
        //Check if the file is an actual image
        $validExtensions = array( "jpg", "jpeg", "png", "gif" );
        $fileExtension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $validExtensions)) {
            $message                  = [
                'text'   => 'Invalid file_' . $key . 'format. Allowed formats: JPG, JPEG, PNG, GIF',
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            exit();
        }

        $imgStorePath = $folderPath . 'client_image/';
        pathExitOrCreate($imgStorePath); // check if folder exists or create

        // Define a custom file name
        $customFileName = 'client_' . random_strings(4) . '_' . time() . "." . $fileExtension;

        // Define the target path with the custom file name
        $targetPath_fullImgName = $imgStorePath . $customFileName;
        // image store folder path name is relative to  the image store
        if (move_uploaded_file($fileTmpName, $targetPath_fullImgName)) {
            // image final name for database store name
            $imageFinalName = str_replace('../', '', $targetPath_fullImgName);
            $PIC_URL        = $imageFinalName;
            $strSQL         = @oci_parse($objConnect, "UPDATE CLIENT_COMMENTS 
                                SET PIC_URL = '$PIC_URL'
                                WHERE ID = $editId");

            // Execute the query
            if (@oci_execute($strSQL)) {
                // $message                  = [
                //     'text'   => 'Data Updated successfully.',
                //     'status' => 'true',
                // ];
                // $_SESSION['noti_message'] = $message;
                // echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/edit.php?id=25&&actionType=edit'</script>";
            }
            else {
                $e                        = @oci_error($strSQL);
                $message                  = [
                    'text'   => htmlentities($e['message'], ENT_QUOTES),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/edit.php?id=" . $editId . "&&actionType=edit'</script>";
            }
        }
        else {
            $message                  = [
                'text'   => "Something went wrong file uploading!",
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/edit.php?id=" . $editId . "&&actionType=edit'</script>";
            exit();
        }

    }
    $strSQL = @oci_parse($objConnect, "UPDATE CLIENT_COMMENTS 
        SET
            NAME = '$NAME',
            TYPE = '$TYPE',
            COMMENTS = '$COMMENTS',
            STATUS = '$STATUS'
        WHERE ID = $editId");

    // Execute the query
    if (@oci_execute($strSQL)) {
        $message                  = [
            'text'   => 'Data Updated successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/edit.php?id=" . $editId . "&&actionType=edit'</script>";
        exit();
    }
    else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/edit.php?id=" . $editId . "&&actionType=edit'</script>";
        exit();
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'createSaleConcern') {

    $TITLE_NAME      = $_POST['TITLE_NAME'];
    $DESIGNATION     = $_POST['DESIGNATION'];
    $MOBILE          = $_POST['MOBILE'];
    $MAIL            = $_POST['MAIL'];
    $WORK_STATION_ID = $_POST['WORK_STATION_ID'];
    $STATUS          = $_POST['STATUS'];
    $RML_ID          = $_POST['RML_ID'];
    $PIC_URL         = '';

    if (!empty($_FILES["PIC_URL"]["name"])) {

        $image       = $_FILES['image'];
        $fileName    = $image["name"];
        $fileTmpName = $image["tmp_name"];
        $fileSize    = $image["size"];
        $fileType    = $image["type"];
        $fileError   = $image["error"];
        //Check if the file is an actual image
        $validExtensions = array( "jpg", "jpeg", "png", "gif" );
        $fileExtension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $validExtensions)) {
            $imageStatus             = 'Invalid file_' . $key . 'format. Allowed formats: JPG, JPEG, PNG, GIF';
            $_SESSION['imageStatus'] = $imageStatus;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            exit();
        }

        $imgStorePath = $folderPath . 'sale_concern/';
        pathExitOrCreate($imgStorePath); // check if folder exists or create

        // Define a custom file name
        $customFileName = 'client_' . random_strings(4) . '_' . time() . "." . $fileExtension;

        // Define the target path with the custom file name
        $targetPath_fullImgName = $imgStorePath . $customFileName;
        // image store folder path name is relative to  the image store
        if (move_uploaded_file($fileTmpName, $targetPath_fullImgName)) {
            // image final name for database store name
            $imageFinalName = str_replace('../', '', $targetPath_fullImgName);
            $PIC_URL        = $imageFinalName;
        }
        else {
            $message                  = [
                'text'   => "Something went wrong file uploading!",
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/create.php'</script>";
            exit();
        }

    }

    // Prepare the SQL statement
    $strSQL = @oci_parse($objConnect, "INSERT INTO  RESALE_TEAM 
    (RML_ID, TITLE_NAME,DESIGNATION, MOBILE, WORK_STATION_ID,MAIL, STATUS, ENTRY_DATE,ENTRY_BY, PIC_URL) 
            VALUES ( 
            '$RML_ID',
            '$TITLE_NAME',
            '$DESIGNATION',
            '$MOBILE',
            '$WORK_STATION_ID' ,
            '$MAIL',
            '$STATUS',
            SYSDATE,
            '$emp_session_id',
            '$PIC_URL')");

    // Execute the query
    if (@oci_execute($strSQL)) {
        $message                  = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/create.php'</script>";
    }
    else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/customer_review/create.php'</script>";
    }



}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'editSaleConcern') {

    $editId          = $_POST['editId'];
    $TITLE_NAME      = $_POST['TITLE_NAME'];
    $DESIGNATION     = $_POST['DESIGNATION'];
    $MOBILE          = $_POST['MOBILE'];
    $MAIL            = $_POST['MAIL'];
    $WORK_STATION_ID = $_POST['WORK_STATION_ID'];
    $STATUS          = $_POST['STATUS'];
    $RML_ID          = $_POST['RML_ID'];
    $PIC_URL         = '';

    if (!empty($_FILES["PIC_URL"]["name"])) {

        $image       = $_FILES['PIC_URL'];
        $fileName    = $image["name"];
        $fileTmpName = $image["tmp_name"];
        $fileSize    = $image["size"];
        $fileType    = $image["type"];
        $fileError   = $image["error"];
        //Check if the file is an actual image
        $validExtensions = array( "jpg", "jpeg", "png", "gif" );
        $fileExtension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $validExtensions)) {
            $imageStatus             = 'Invalid file_' . $key . 'format. Allowed formats: JPG, JPEG, PNG, GIF';
            $_SESSION['imageStatus'] = $imageStatus;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            exit();
        }

        $imgStorePath = $folderPath . 'sale_concern/';
        pathExitOrCreate($imgStorePath); // check if folder exists or create

        // Define a custom file name
        $customFileName = 'concern_' . random_strings(4) . '_' . time() . "." . $fileExtension;

        // Define the target path with the custom file name
        $targetPath_fullImgName = $imgStorePath . $customFileName;
        // image store folder path name is relative to  the image store
        if (move_uploaded_file($fileTmpName, $targetPath_fullImgName)) {
            // image final name for database store name
            $imageFinalName = str_replace('../', '', $targetPath_fullImgName);
            $PIC_URL        = $imageFinalName;
            //check if old image exists & delete it
            $imgSQL = oci_parse($objConnect, "SELECT PIC_URL from RESALE_TEAM  WHERE ID = $editId");
            @oci_execute($imgSQL);
            $image = oci_fetch_assoc($imgSQL); 
            if ($image) {
                if (file_exists($baseUrl . '/' . $image['PIC_URL'])) {
                    unlink($baseUrl . '/' . $image['PIC_URL']);
                }
            }
        }
        else {
            $message                  = [
                'text'   => "Something went wrong file uploading!",
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/sale_concern/edit.php?id=" . $editId . "&&actionType=edit'</script>";
            exit();
        }

    }

    // Prepare the SQL statement
    $strSQL = oci_parse($objConnect, "UPDATE RESALE_TEAM 
        SET RML_ID = '$RML_ID',
            TITLE_NAME = '$TITLE_NAME',
            DESIGNATION = '$DESIGNATION',
            MOBILE = '$MOBILE',
            WORK_STATION_ID = '$WORK_STATION_ID',
            MAIL = '$MAIL',
            STATUS = '$STATUS',
            ENTRY_DATE = SYSDATE,
            ENTRY_BY = '$emp_session_id',
            PIC_URL = '$PIC_URL'
        WHERE ID = $editId");

    // Execute the query
    if (@oci_execute($strSQL)) {
        $message                  = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/sale_concern/edit.php?id=" . $editId . "&&actionType=edit'</script>";
        exit();

    }
    else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/form_panel/sale_concern/edit.php?id=" . $editId . "&&actionType=edit'</script>";
        exit();

    }



}
function pathExitOrCreate($folderPath)
{
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }
}
function getExtension($str)
{
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l   = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}
function random_strings($length_of_string)
{
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    // Shuffle the $str_result and returns substring
    // of specified length
    return substr(
        str_shuffle($str_result),
        0,
        $length_of_string
    );
}
