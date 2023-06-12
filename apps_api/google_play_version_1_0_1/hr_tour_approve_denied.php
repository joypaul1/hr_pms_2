<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$entry_id = $_POST['entry_id'] ;
	$rml_id = $_POST['rml_id'] ;
	$approve_denied = $_POST['approve_denied'] ;
	$approval_remarks = $_POST['approval_remarks'] ;
	
	
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	
	
	
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
    $tourSQL  = oci_parse($objConnect, "update RML_HR_EMP_TOUR set 
											LINE_MANAGER_APPROVAL_STATUS='$approve_denied',
											APPROVAL_REMARKS='$approval_remarks',
											APPROVAL_DATE=SYSDATE
										   where ID='$entry_id'");

				
				if(oci_execute($tourSQL))
				   {
							 $json = array("status" => "true",
									  "message" => "Tour Approval/Denied Successfully Completed.",
									   "title_message"=>"Approval Messages",
									   "push_message"=>"Dear, your tour entry is approved by your line manager."
									  );
	$attnSQL  = oci_parse($objConnect, "declare V_START_DATE VARCHAR2(100);V_END_DATE VARCHAR2(100);V_RML_ID VARCHAR2(100);begin SELECT TO_CHAR(START_DATE,'dd/mm/yyyy'), TO_CHAR(END_DATE,'dd/mm/yyyy'), RML_ID  INTO V_START_DATE,V_END_DATE,V_RML_ID FROM RML_HR_EMP_TOUR  WHERE ID='$entry_id';RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_START_DATE,'dd/mm/yyyy'),TO_DATE(V_END_DATE,'dd/mm/yyyy'));end;");
			   
			         @oci_execute($attnSQL); 
				   }else{
							 $named_array = array();
		                     $json =  array("status" => "false", 
									  "message" => "Sorry! No data found.",
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
}else{
	$json = array("status" => 0, "message" => "Request method not accepted");
}
  //  header('Content-type: application/json');
	echo json_encode($json);
	
?>
