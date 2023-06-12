<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$emp_id = $_POST['emp_id'] ;
	
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
    $tourSQL  = oci_parse($objConnect, "select RML_ID,START_DATE,END_DATE,((END_DATE-START_DATE)+1) LEAVE_DAYS,REMARKS,LEAVE_TYPE,IS_APPROVED from RML_HR_EMP_LEAVE
											where RML_ID='$emp_id'
											   AND trunc(START_DATE) between to_date('01/12/2022','dd/mm/yyyy') and to_date('31/12/2023','dd/mm/yyyy')
											order by START_DATE desc");

				
				if(oci_execute($tourSQL))
				   {
					  $is_found=0; 
					  while($row=oci_fetch_assoc($tourSQL)){
						  $is_found=1;
						  $named_array[] = array(
                             "RML_ID" => $row['RML_ID'],
                             "START_DATE" => $row['START_DATE'],
                             "END_DATE" => $row['END_DATE'],
                             "REMARKS" => $row['REMARKS'],
                             "LEAVE_TYPE" => $row['LEAVE_TYPE'],
                             "IS_APPROVED" => $row['IS_APPROVED'],
                             "LEAVE_DAYS" => $row['LEAVE_DAYS']
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
