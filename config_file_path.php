<?php
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    $basePath =  $baseUrl . '/rHRT';
    // if (!isset($_SESSION['HR'])) {
    //   header("location:" . $basePath."/index.php");
    //   exit();
    // }

?>