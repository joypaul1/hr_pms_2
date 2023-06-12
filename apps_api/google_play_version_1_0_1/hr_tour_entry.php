<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$emp_id = $_POST['emp_id'] ;
	$tour_start_date = $_POST['tour_start_date'] ;
	$tour_end_date = $_POST['tour_end_date'] ;
	$tour_remarks = $_POST['tour_remarks'] ;
	$entry_by = $_POST['entry_by'] ;
	
	
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	 require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
       $strSQL  = oci_parse($objConnect, "begin RML_HR_TOUR_CREATE('$emp_id','$tour_start_date','$tour_end_date','$tour_remarks','$entry_by');end;");                
				if(@oci_execute($strSQL))
				{
		                $json = array("status" => "true",
									  "message" => "Your office tour successfully saved. It must be approved by your responsible line manager. Do you want to view your Last 10 Tour Status?"
									  );
					  
				}else{
					   @$lastError = error_get_last();
				       @$error=$lastError ? "".$lastError["message"]."":"";
					   $str_arr_error = preg_split ("/\,/", $error); 
					   $named_array = array();
		               $json =  array("status" => "false", 
									  "message" => preg_split ("/\@@@@/", $error)[1]
									  );
				}

                oci_close($objConnect);
	}else{
				$named_array = array();
		        $json =  array("status" => "false", 
									  "message" => "Sorry! You are not Valid User. Its a security issuses. Dont try to again & again without Rangs Group Permission"
									  );
				}												

}else{
	$json = array("status" => 0, "message" => "Request method not accepted");
}
  //  header('Content-type: application/json');
	echo json_encode($json);
	
?>
