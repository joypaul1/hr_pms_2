<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$rml_id = $_POST['rml_id'] ;
    $securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	
	require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
		
    $strSQL  = oci_parse($objConnect, 
		        "select LEAVE_TYPE,
                      LEAVE_PERIOD,
					  LEAVE_ASSIGN,
					  LEAVE_TAKEN,
					  LATE_LEAVE 
				FROM LEAVE_DETAILS_INFORMATION
                WHERE RML_ID='$rml_id'
				and LEAVE_PERIOD='2023'
                AND LEAVE_TYPE in ('CL','EL','SL')
			  ");
	if(oci_execute($strSQL))
		{
		$is_found=0; 
		while($row=oci_fetch_assoc($strSQL)){
			 $is_found=1; 
			 $named_array[] = array(
						     "LEAVE_TYPE" =>$row['LEAVE_TYPE'].'-'.$row['LEAVE_PERIOD'],
                             "LEAVE_PERIOD" => $row['LEAVE_PERIOD'],
                             "LEAVE_ASSIGN" => $row['LEAVE_ASSIGN'],
                             "LEAVE_TAKEN" => $row['LEAVE_TAKEN'],
                             "LATE_LEAVE" => $row['LATE_LEAVE']                            
             );
		}
							 
		    if($is_found==1){
			 $json = array("status" => "true",
					  "data" => $named_array
					  );
			}else{
			 $named_array = array();
			 $json =  array("status" => "false", 
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
	echo json_encode($json);	
?>
