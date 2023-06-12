<?php
require_once('../inc/config.php');
session_start();
$emp_sesssion_id = $_SESSION['HR']['emp_id_hr'];

$imageStatus = '';

$targetDir = "../uploads/"; // File upload path
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

$new_image_name = 'image_' . date('Y_m_d_H_i_s').'.'.$fileType;

if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetDir.$new_image_name)) {
            // delet previous image
            $sql = "select * from tbl_users where emp_id='$emp_sesssion_id'";
            $query = mysqli_query($conn_hr, $sql);
            $data= mysqli_fetch_assoc($query);
          
            if($data['image_url']){
                $file = "../uploads/".$data['image_url'];
                if (file_exists($file)) {
                    unlink($file ); // delete image if exist
                } 
            }  // end delet previous image
         
           // update image 
            $sql = "update tbl_users set image_url='$new_image_name'  where emp_id = '$emp_sesssion_id' ";
			$insert = mysqli_query($conn_hr, $sql);
            
            // $insert = true;
            if ($insert) {
                $imageStatus = "The file has been uploaded successfully.";
            } else {
                $imageStatus = "File upload failed, please try again!";
            }
        } else {
            $imageStatus = "Sorry, there was an error uploading your file!";
        }
    } else {
        $imageStatus = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload!';
    }
} else {
    $imageStatus = 'Please select a file to upload!';
}

// Display status message
session_start();
$_SESSION['imageStatus'] = $imageStatus;
header("location: /rHR/imageChange.php");

exit;
