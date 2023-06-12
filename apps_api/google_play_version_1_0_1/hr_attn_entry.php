<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$v_emp_id = $_POST['emp_id'] ;
	$latitude = $_POST['latitude'] ;
	$longitude = $_POST['longitude'] ;
	$inside_or_outside = $_POST['inside_or_outside'] ;
	$outside_remarks = $_POST['outside_remarks'] ;
	$emp_distance = $_POST['emp_distance'] ;
	$entry_by = $_POST['entry_by'] ;

    
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
		    $strSQL  = oci_parse($objConnect, "begin RML_HR_ATTN_CREATE('$v_emp_id','$latitude','$longitude','$inside_or_outside','$outside_remarks','$emp_distance','$entry_by'); end;"); 
	           
				if(oci_execute($strSQL))
				{
					    if($inside_or_outside=='Inside Office')
		                {
							$json = array("status" => "true",
									  "message" => "Your office attendance successfully saved. Do you want to view your current month attendance?",
									   "title_message"=>"",
									   "push_message"=>""
									  );
						}else{
							$json = array("status" => "true",
									  "message" => "Your office attendance successfully saved. It must be approved by your responsible line manager. \nDo you want to view your current month attendance?",
									  "title_message"=>"This is Title Message",
									  "push_message"=>"Your concern $v_emp_id ,have given outside acctendance. You should approved this attendance.Your concern $v_emp_id ,have given outside acctendance. You should approved this attendance.Your concern $v_emp_id ,have given outside acctendance. You should approved this attendance."
									  
									 );
						}
					  
				}else{
					   @$lastError = error_get_last();
				       @$error=$lastError ? "".$lastError["message"]."":"";
					   $str_arr_error = preg_split ("/\,/", $error); 
					   $named_array = array();
					    $json =  array("status" => "false", 
									  "message" => 'something wrong',
									  "title_message"=>"",
									  "push_message"=>""
									  );
		            
				}
				oci_close($objConnect);
	    }else{
				$named_array = array();
		        $json =  array("status" => "false", 
									  "message" => "Sorry! You are not Valid User. Its a security issuses. Dont try to again & again without Rangs Group Permission"
									  );
				}
               


                
				 
    									

}
else{
	$json = array("status" => 0, "message" => "Request method not accepted");
}
  //  header('Content-type: application/json');
	echo json_encode($json);
	
?>
