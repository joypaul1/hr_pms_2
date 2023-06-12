<?php 
    session_start();
	session_regenerate_id(TRUE);
	if($_SESSION['HR']['hr_role']!= 2)
	{
		header('location:index.php?lmsg_hr=true');
		exit;
	}
	if(!isset($_SESSION['HR']['id_hr'],$_SESSION['HR']['hr_role']))
	{
		header('location:index.php?lmsg_hr=true');
		exit;
	}
   
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	
	$v_active_open='';
	$v_active='';
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');

?>
<!-- / Content -->
<?php require_once('hr_home.php'); ?>  
<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  