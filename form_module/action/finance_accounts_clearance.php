
<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$baseUrl        = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$basePath       = $baseUrl . '/rHRT';


// Check if the form is submitted create clearence 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'qweqwe';
    die();
}