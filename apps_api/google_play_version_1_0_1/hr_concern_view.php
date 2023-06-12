<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$rml_id = $_POST['rml_id'] ;

	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
		if($rml_id=='RG001'){
			$strSQL  = oci_parse($objConnect, "SELECT RML_ID,(EMP_NAME || chr(10) ||BRANCH_NAME) AS EMP_NAME,MOBILE_NO,MAIL,DESIGNATION,BRANCH_NAME,
                                                     EMP_TRACE_LAST_LATLONG(RML_ID) LATLANG 		
		                                           FROM RML_HR_APPS_USER
													WHERE IS_ACTIVE=1
													and TRACE_LOCATION=1");
		}else if($rml_id=='RML-00955'){
			$strSQL  = oci_parse($objConnect, "SELECT RML_ID,(EMP_NAME|| chr(10) ||BRANCH_NAME) AS EMP_NAME,MOBILE_NO,MAIL,DESIGNATION,BRANCH_NAME,
                                                     EMP_TRACE_LAST_LATLONG(RML_ID) LATLANG 		
		                                           FROM RML_HR_APPS_USER
													WHERE IS_ACTIVE=1
													and TRACE_LOCATION=1
													 and RML_ID in ('RML-00149','RML-00171','RML-00178')");
		}else{
			$strSQL  = oci_parse($objConnect, "SELECT RML_ID,(EMP_NAME|| chr(10) ||BRANCH_NAME) AS EMP_NAME,MOBILE_NO,MAIL,DESIGNATION,BRANCH_NAME,
                                                     EMP_TRACE_LAST_LATLONG(RML_ID) LATLANG 		
		                                           FROM RML_HR_APPS_USER
													WHERE IS_ACTIVE=1
													and TRACE_LOCATION=1
													AND (LINE_MANAGER_RML_ID='$rml_id' OR DEPT_HEAD_RML_ID='$rml_id')");
		}
        
			  
				   if(oci_execute($strSQL))
				   {
					  $is_found=0; 
					  while($row=oci_fetch_assoc($strSQL)){
						  $is_found=1;
						  $named_array[] = array(
						     "RML_ID" =>$row['RML_ID'],
                             "EMP_NAME" => $row['EMP_NAME'],
                             "MOBILE_NO" => $row['MOBILE_NO'],
                             "MAIL" => $row['MAIL'],
                             "DESIGNATION" => $row['DESIGNATION'],
                             "BRANCH_NAME" => $row['BRANCH_NAME'] ,                           
                             "LATLANG" => $row['LATLANG']                         
                             );
							 }
							 
						if($is_found==1){
							 $json = array("status" => "true",
									  "message" => "Item info Found successfully.",
									  "data" => $named_array
									  );
						    }else{
							 $named_array = array();
		                     $json =  array("status" => "false", 
									  "message" => "Sorry! No data found.",
									  "data" => $named_array 
									  );		  
						  }
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
