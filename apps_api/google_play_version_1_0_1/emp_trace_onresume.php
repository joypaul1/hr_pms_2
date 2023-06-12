<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$employee_id = $_POST['emp_id'] ;
	$latitude_data = $_POST['latitude'] ;
	$longitude_data = $_POST['longitude'] ;
	$possition_data = $_POST['possition_data'] ;
	$battery_level = $_POST['battery_level'] ;
	$android_version = $_POST['android_version'] ;
	$app_version = $_POST['apps_version'] ;

    
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
		    $strSQL  = oci_parse($objConnect, "INSERT INTO RML_EMP_TRACE ( 
													   RML_USER_ID, 
													   LATITUDE, 
													   LONGITUDE, 
													   ENTY_DATE,
													   POSSITION,
													   BATTERY_LEVEL,
													   ANDROID_VERSION,
													   APP_VERSION) 
													VALUES ('$employee_id',
													         '$latitude_data',
													         '$longitude_data',
													          SYSDATE,
															  '$possition_data',
															  '$battery_level',
															  '$android_version',
															  '$app_version')"); 
	
				if(oci_execute($strSQL))
				{
					$json = array("status" => "true");
				}
				oci_close($objConnect);
	    }else{
		        $json =  array("status" => "false");
				}
}
else{
	$json = array("status" => 0, "message" => "Request method not accepted");
}
	echo json_encode($json);
	
?>
