<?php 
session_start();
session_regenerate_id(TRUE);

include_once('../../../../layouts/header.php');
require_once('../../../../inc/config.php');
include_once('../../../../layouts/left_menu.php');
include_once('../../../../layouts/top_menu.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];