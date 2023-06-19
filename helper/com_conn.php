<?php 
session_start();
session_regenerate_id(TRUE);

require_once('../../inc/config.php');
require_once('../../layouts/header.php');
require_once('../../layouts/left_menu.php');
require_once('../../layouts/top_menu.php');


$emp_session_id = $_SESSION['HR']['emp_id_hr'];


// print_r($emp_session_id); die();

