<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$employee_id = $_POST['emp_id'] ;
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
		    $strSQL  = oci_parse($objConnect, "SELECT RML_USER_ID,
			                                          LATITUDE,
													  LONGITUDE,
													  TO_CHAR(ENTY_DATE,'dd/mm/yyyy') ENTY_DATE,
													  TO_CHAR(ENTY_DATE,'HH:MI:SS AM') ENTY_TIME 
												FROM
													(select RML_USER_ID,LATITUDE,LONGITUDE,ENTY_DATE from RML_EMP_TRACE
													where RML_USER_ID='RML-00955'
													order by ENTY_DATE desc)
												WHERE ROWNUM<=5"); 
	
				if(oci_execute($strSQL))
				{
					 while($row=oci_fetch_assoc($strSQL)){
						  $is_found=1;
						  $named_array[] = array(
                             "RML_USER_ID" => $row['RML_USER_ID'],
                             "LATITUDE" =>$row['LATITUDE'],
                             "LONGITUDE" => $row['LONGITUDE'],
                             "ENTY_DATE" => $row['ENTY_DATE'],
                             "ENTY_TIME" => $row['ENTY_TIME']
                             );
						}
					
					if($is_found==1){
							 $json = array("status" => "true",
									  "data" => $named_array
									  );
						    }else{
		                     $json =  array("status" => "false", 
									  "data" => $named_array 
									  );		  
						  }
				}
				oci_close($objConnect);
	    }else{
		        $json =  array("status" => "false", 
							   "message" => "Sorry! You are not Valid User. Its a security issuses. Dont try again & again without Rangs Group Permission"
							);
				}
}
else{
	$json = array("status" => 0, "message" => "Request method not accepted");
}
	echo json_encode($json);
	
?>
