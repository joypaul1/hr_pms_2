<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connresaleoracle.php');
require_once('../../config_file_path.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];
$folderPath     = $rs_img_path;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'pro_edit') {


    $valid_formats = array( "jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP" );

    $editId           = $_POST['editId'];
    $DISPLAY_PRICE    = $_POST['DISPLAY_PRICE'];
    $BODY_SIT         = $_POST['BODY_SIT'];
    $COLOR            = $_POST['COLOR'];
    $FUEL_TYPE        = $_POST['FUEL_TYPE'];
    $DESCRIPTION      = $_POST['DESCRIPTION'];
    $HISTORY          = $_POST['HISTORY'];
    $PUBLISHED_STATUS = $_POST['PUBLISHED_STATUS'];

    // product thamline image 
    if (!empty($_FILES["PIC_URL"]["name"])) {
        // print_r($_FILES['PIC_URL']['name']);
        // die();
        $imgStorePath = $folderPath . 'product_image/';
        pathExitOrCreate($imgStorePath);
        $imagename = $_FILES['PIC_URL']['name'];
        $size      = $_FILES['PIC_URL']['size'];


        if (strlen($imagename)) {
            $ext = strtolower(getExtension($imagename));
            if (in_array($ext, $valid_formats)) {
                // if ($size < (2048 * 2048)) // Image size max 2 MB
                // {
                $actual_image_name = time() . "." . $ext;
                $uploadedfile      = $_FILES['PIC_URL']['tmp_name'];

                //Re-sizing image. 
                $width    = $size; //You can change dimension here.
                $filename = compressImage($ext, $uploadedfile, $imgStorePath, $actual_image_name, $width);

                if ($filename) {
                    $picurlSQL = @oci_parse($objConnect, "UPDATE PRODUCT SET PIC_URL = :pic_url WHERE ID = :edit_id");
                    // Bind parameters
                    @oci_bind_by_name($picurlSQL, ':pic_url', $filename);
                    @oci_bind_by_name($picurlSQL, ':edit_id', $editId);
                    if (@oci_execute($picurlSQL)) {
                        $message                  = [
                            'text'   => 'Data Saved successfully.',
                            'status' => 'true',
                        ];
                        $_SESSION['noti_message'] = $message;
                        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                    }
                    else {
                        $e                        = @oci_error($strSQL);
                        $message                  = [
                            'text'   => htmlentities($e['message'], ENT_QUOTES),
                            'status' => 'false',
                        ];
                        $_SESSION['noti_message'] = $message;
                        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                    }
                }
                else {

                    $imageStatus             = "Something went wrong file uploading!";
                    $_SESSION['imageStatus'] = $imageStatus;
                    echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                    exit();

                }
            }
            else {
                $imageStatus             = 'Sorry, only  jpg, png, gif,bmp & pdf files are allowed to upload!';
                $_SESSION['imageStatus'] = $imageStatus;
                echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                exit();

            }
        }
        else {
            $imageStatus             = "Please select valid image..!";
            $_SESSION['imageStatus'] = $imageStatus;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            exit();

        }
    }
    // Prepare the SQL statement
    $strSQL = @oci_parse($objConnect, "
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
    @oci_bind_by_name($strSQL, ':display_price', $DISPLAY_PRICE);
    @oci_bind_by_name($strSQL, ':body_sit', $BODY_SIT);
    @oci_bind_by_name($strSQL, ':color', $COLOR);
    @oci_bind_by_name($strSQL, ':fuel_type', $FUEL_TYPE);
    @oci_bind_by_name($strSQL, ':description', $DESCRIPTION);
    @oci_bind_by_name($strSQL, ':history', $HISTORY);
    @oci_bind_by_name($strSQL, ':published_status', $PUBLISHED_STATUS);
    @oci_bind_by_name($strSQL, ':edit_id', $editId);
    
    // Execute the query
    if (@oci_execute($strSQL)) {
        $message                  = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
    }
    else {

        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
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

function compressImage($ext, $uploadedfile, $path, $actual_image_name, $newwidth)
{
    if ($ext == "jpg" || $ext == "jpeg") {
        $src = imagecreatefromjpeg($uploadedfile);
    }
    else if ($ext == "png") {
        $src = imagecreatefrompng($uploadedfile);
    }
    else if ($ext == "gif") {
        $src = imagecreatefromgif($uploadedfile);
    }
    else {
        $src = imagecreatefrombmp($uploadedfile);
    }
    list( $width, $height ) = getimagesize($uploadedfile);
    $newheight              = ($height / $width) * $newwidth;
    $tmp                    = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    $filename = $path . $newwidth . '_' . $actual_image_name; //PixelSize_TimeStamp.jpg
    imagejpeg($tmp, $filename, 100);
    imagedestroy($tmp);
    return str_replace('../', '', $filename);
}
