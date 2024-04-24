<?php
session_start();
require_once('../../inc/connoracle.php');
require_once('../../helper/Image.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];



class upload {
    use imageTrait;

    function storeFile()  {
        
        // if($request->image){
            $data['image'] =  (new Image)->dirName('banner')->file($request->image)
            ->resizeImage(360, 155)
            ->save();
        // }
    }
}