<?php
session_start();


class Imageupload
{
    public $basePath =  $_SESSION['basePath'];
    public  $defaulPath = '../uploads/';
    public $extenstion = null;
    public $width = null;
    public $height = null;
    public $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");

    function folderPath($path)
    {
        $this->defaulPath = $path;
        if (!file_exists($this->defaulPath)) {
            mkdir($this->defaulPath, 0777, true);
        }
    }
    function imageWidth($size)
    {
        $this->width = $size;
    }
    function imageHeight($size)
    {
        $this->height = $size;
    }

    public function getExtension($str)
    {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        } 
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        $this->extenstion = $ext ;
    }

    public function compressImage($uploadedfile, $actual_image_name)
    {
        if ($this->extenstion == "jpg" || $this->extenstion == "jpeg") {
            $src = imagecreatefromjpeg($uploadedfile);
        } else if ($this->extenstion == "png") {
            $src = imagecreatefrompng($uploadedfile);
        } else if ($this->extenstion == "gif") {
            $src = imagecreatefromgif($uploadedfile);
        } else {
            $src = imagecreatefrombmp($uploadedfile);
        }

        list($width, $height) = getimagesize($uploadedfile);
        $newheight = ($height / $width) * $newwidth;
        $tmp = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        $filename = $this->defaulPath . time() . '_' . $actual_image_name; //PixelSize_TimeStamp.jpg
        imagejpeg($tmp, $filename, 100);
        imagedestroy($tmp);
        return str_replace('../', '', $filename);
    }



    public function save()
    {
        // pathExitOrCreate();
        $imagename = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        if (strlen($imagename)) {
            $ext = strtolower(getExtension($imagename));
            if (in_array($ext, $this->valid_formats)) {
                if ($size < (2048 * 2048)) // Image size max 2 MB
                {
                    $actual_image_name = time() . "." . $ext;
                    $uploadedfile = $_FILES['file']['tmp_name'];

                    //Re-sizing image. 
                    // include '../action/compressImage.php';
                    $width = 50; //You can change dimension here.
                    $filename = $this->compressImage($uploadedfile,$actual_image_name);
                    $insert = false; //
                    // if ($filename) {
                    //     // delet previous image
                    //     $sql = "select * from tbl_users where emp_id='$emp_sesssion_id'";
                    //     $query = mysqli_query($conn_hr, $sql);
                    //     $data = mysqli_fetch_assoc($query);

                    //     if ($data['image_url']) {
                    //         $file = $folderPath . $data['image_url'];
                    //         if (file_exists($file)) {
                    //             unlink($file); // delete image if exist
                    //         }
                    //     }  // end delet previous image
                    //     // update image 
                    //     $sql = "update tbl_users set image_url='$filename' where emp_id = '$emp_sesssion_id' ";
                    //     $insert = mysqli_query($conn_hr, $sql);
                    //     if ($insert) {
                    //         $_SESSION['HR']['emp_image_hr'] = $filename;
                    //         $imageStatus = "The file has been uploaded successfully.";
                    //         session_start();
                    //         $_SESSION['imageStatus'] = $imageStatus;
                    //         header("location:" . $this->basePath  . "/imageChange.php");
                    //         exit();
                    //     } else {
                    //         $imageStatus = "Data Not Updated!";
                    //         session_start();
                    //         $_SESSION['imageStatus'] = $imageStatus;
                    //         header("location:" . $this->basePath  . "/imageChange.php");
                    //         exit();
                    //     }
                    // } else {
                    //     $imageStatus = "Something went wrong uploading!";
                    //     session_start();
                    //     $_SESSION['imageStatus'] = $imageStatus;
                    //     header("location:" . $this->basePath  . "/imageChange.php");
                    //     exit();
                    // }
                } else {
                    $imageStatus = "Image file size max 2 MB";
                    session_start();
                    $_SESSION['imageStatus'] = $imageStatus;
                    header("location:" . $this->basePath  . "/imageChange.php");
                    exit();
                }
            } else {
                $imageStatus = 'Sorry, only JPG, JPEG, PNG, BMP,GIF, & PDF files are allowed to upload!';
                session_start();
                $_SESSION['imageStatus'] = $imageStatus;
                header("location:" . $this->basePath  . "/imageChange.php");
                exit();
            }
        } else {
            $imageStatus = "Please select image..!";
            session_start();
            $_SESSION['imageStatus'] = $imageStatus;
            header("location:" . $this->basePath  . "/imageChange.php");
            exit();
        }
    }
}
