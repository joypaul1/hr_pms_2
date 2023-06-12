<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$emp_id = $_POST['emp_id'] ;
	
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
    $tourSQL  = oci_parse($objConnect, "select a.ID AS ID, 
	                                       (b.EMP_NAME ||'('||a.RML_ID||')') RML_ID,
                                           START_DATE,
										   END_DATE,
										  ((END_DATE-START_DATE)+1) LEAVE_DAYS,
										   REMARKS,
										   LEAVE_TYPE
                                        from RML_HR_EMP_LEAVE a,RML_HR_APPS_USER b
                                               where A.RML_ID=B.RML_ID
											         and trunc(START_DATE)> TO_DATE('01/01/2022','DD/MM/YYYY') 
                                                     and  b.LINE_MANAGER_RML_ID='$emp_id'
                                                     and A.IS_APPROVED IS NULL");

				if(oci_execute($tourSQL))
				   {
					  $is_found=0; 
					  while($row=oci_fetch_assoc($tourSQL)){
						  $is_found=1;
						  $named_array[] = array(
                             "ID" => $row['ID'],
                             "RML_ID" => $row['RML_ID'],
                             "START_DATE" => $row['START_DATE'],
                             "END_DATE" => $row['END_DATE'],
                             "REMARKS" => $row['REMARKS'],
                             "LEAVE_DAYS" => $row['LEAVE_DAYS'],
                             "LEAVE_TYPE" => $row['LEAVE_TYPE']
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
