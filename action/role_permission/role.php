<?php 
require_once('../../inc/config.php');

$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$basePath =  $baseUrl.'/rHR';

session_start();



// Handle Create request
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  trim($_POST["formType"]) == 'create'  ) {

    $name = trim($_POST["name"]);

    if(empty($name)){
        $message = [
            'text' => 'Please input Role Name',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        print_r($_SESSION['noti_message']['status']);
        header("location:" .$basePath."/role_permission/role/create.php");
        exit;
    }

}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request
    echo "This is a GET request";
}
