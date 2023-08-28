<?php
session_start();
require_once('../inc/config.php');
$basePath =  $_SESSION['basePath'];
$emp_sesssion_id = $_SESSION['HR']['emp_id_hr'];
$folderPath = "../uploads/";

$imageStatus = '';
$session_id = '1'; // User session id


$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {

    include_once '../action/getExtension.php';
    pathExitOrCreate();
    $imagename = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    if (strlen($imagename)) {
        $ext = strtolower(getExtension($imagename));
        if (in_array($ext, $valid_formats)) {
            if ($size < (2048 * 2048)) // Image size max 2 MB
            {
                $actual_image_name = time() . "." . $ext;
                $uploadedfile = $_FILES['file']['tmp_name'];

                //Re-sizing image. 
                include '../action/compressImage.php';
                $width = 50; //You can change dimension here.
                $filename = compressImage($ext, $uploadedfile, $folderPath, $actual_image_name, $width);
                $insert = false; //
                if ($filename) {
                    // delet previous image
                    $sql = "select * from tbl_users where emp_id='$emp_sesssion_id'";
                    $query = mysqli_query($conn_hr, $sql);
                    $data = mysqli_fetch_assoc($query);

                    if ($data['image_url']) {
                        $file = $folderPath. $data['image_url'];
                        if (file_exists($file)) {
                            unlink($file); // delete image if exist
                        }
                    }  // end delet previous image
                    // update image 
                    $sql = "update tbl_users set image_url='$filename' where emp_id = '$emp_sesssion_id' ";
                    $insert = mysqli_query($conn_hr, $sql);
                    if ($insert) {
                        $_SESSION['HR']['emp_image_hr'] = $filename;
                        $imageStatus = "The file has been uploaded successfully.";
                        session_start();
                        $_SESSION['imageStatus'] = $imageStatus;
                        header("location:" . $basePath . "/imageChange.php");
                        exit();
                    } else {
                        $imageStatus = "Data Not Updated!";
                        session_start();
                        $_SESSION['imageStatus'] = $imageStatus;
                        header("location:" . $basePath . "/imageChange.php");
                        exit();
                    }
                } else {
                    $imageStatus = "Something went wrong uploading!";
                    session_start();
                    $_SESSION['imageStatus'] = $imageStatus;
                    header("location:" . $basePath . "/imageChange.php");
                    exit();
                }
            } else {
                $imageStatus = "Image file size max 2 MB";
                session_start();
                $_SESSION['imageStatus'] = $imageStatus;
                header("location:" . $basePath . "/imageChange.php");
                exit();
            }
        } else {
            $imageStatus = 'Sorry, only JPG, JPEG, PNG, BMP,GIF, & PDF files are allowed to upload!';
            session_start();
            $_SESSION['imageStatus'] = $imageStatus;
            header("location:" . $basePath . "/imageChange.php");
            exit();
        }
    } else {
        $imageStatus = "Please select image..!";
        session_start();
        $_SESSION['imageStatus'] = $imageStatus;
        header("location:" . $basePath . "/imageChange.php");
        exit();
    }
} else {
    $imageStatus = 'Please select a file to upload!';
    // Display status message
    session_start();
    $_SESSION['imageStatus'] = $imageStatus;
    header("location:" . $basePath . "/imageChange.php");

    exit();
}


function pathExitOrCreate()
{
    // $basePath =  $_SESSION['basePath'];
    $folderPath = "../uploads/";
    // $folderPath = $basePath.'/uploads';

    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }
}
