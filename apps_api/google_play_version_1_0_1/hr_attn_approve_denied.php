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
    $attnEntrySQL  = oci_parse($objConnect, "update RML_HR_ATTN_DAILY set 
														LINE_MANAGER_APPROVAL='$approve_denied',
														IS_ALL_APPROVED='$approve_denied',
														LINE_MANAGER_APPROVAL_REMARKS='$approval_remarks',
														LINE_MANAGER_APPROVAL_DATE=SYSDATE
                                                       where ID='$entry_id'");

				
				if(oci_execute($attnEntrySQL))
				   {
							 $json = array("status" => "true",
									  "message" => "Attendance Approval/Denied Successfully Completed.",
									   "title_message"=>"Approval Messages",
									   "push_message"=>"Dear, your outdoor attendance entry is approved by your line manager."
									  );
						     $attnSQL  = oci_parse($objConnect, "declare V_ATTN_DATE VARCHAR2(100); V_RML_ID VARCHAR2(100); BEGIN SELECT TO_CHAR(ATTN_DATE,'dd/mm/yyyy'),RML_ID INTO V_ATTN_DATE,V_RML_ID FROM RML_HR_ATTN_DAILY  WHERE ID='$entry_id';RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_ATTN_DATE,'dd/mm/yyyy'),TO_DATE(V_ATTN_DATE,'dd/mm/yyyy'));END;");
			   
			         @oci_execute($attnSQL); 
				   }else{
							 $named_array = array();
		                     $json =  array("status" => "false", 
									  "message" => "Sorry! Something Error!.",
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
