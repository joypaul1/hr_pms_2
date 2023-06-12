<?php 
	define("HOST","localhost");
	define("DB_USER","root");
	define("DB_PASS","");
	define("DB_NAME","rangs_hr_rml");
	
	$conn_hr = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
	
	if(!$conn_hr)
	{
		die(mysqli_error());
	}
	

	function getUserAccessRoleByID($id)
	{
		global $conn_hr;
		
		$query = "select user_role from tbl_user_role where  id = ".$id;
	
		$rs = mysqli_query($conn_hr,$query);
		$row = mysqli_fetch_assoc($rs);
		
		return $row['user_role'];
	}


?>