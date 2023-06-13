<?php 
    session_start();
	session_regenerate_id(TRUE);

	// if($_SESSION['HR']['hr_role']!= 5)
	// {
	// 	header('location:index.php?lmsg_hr=true');
	// 	exit;
	// } 

	// if(!isset($_SESSION['HR']['id_hr'],$_SESSION['HR']['hr_role']))
	// {
	// 	header('location:index.php?lmsg_hr=true');
	// 	exit;
	// }		
    require_once('../../inc/config.php');
	require_once('../../layouts/header.php'); 
	
	$v_page='role';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('../../layouts/left_menu.php'); 
	require_once('../../layouts/top_menu.php'); 
	require_once('../../layouts/footer.php'); 
	
	
	
	
 $emp_session_id=$_SESSION['HR']['emp_id_hr'];
?>