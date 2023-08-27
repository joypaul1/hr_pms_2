<?php
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    // $basePath =  $baseUrl . '/rml_apps'; // --> live server
    $basePath =  $baseUrl . '/rHRT'; //--> test server 
   

?>