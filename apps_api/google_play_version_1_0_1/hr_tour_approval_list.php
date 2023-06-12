<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$emp_id = $_POST['emp_id'] ;
	
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
    $tourSQL  = oci_parse($objConnect, "select a.ID,b.EMP_NAME,
                                              (b.EMP_NAME ||'('||a.RML_ID||')') RML_ID,
                                              a.ENTRY_DATE,
                                              a.START_DATE,
                                              a.END_DATE,
                                              a.REMARKS,
                                              a.ENTRY_BY,
                                              a.LINE_MANAGER_ID,
                                              a.LINE_MANAGER_APPROVAL_STATUS,
                                              a.APPROVAL_DATE,
                                              a.APPROVAL_REMARKS
                                              FROM RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
                                            WHERE A.RML_ID=B.RML_ID
                                            and a.LINE_MANAGER_ID='$emp_id'
                                            AND rownum<=10
                                            AND a.LINE_MANAGER_APPROVAL_STATUS IS NULL
                                            order by START_DATE");

				
				if(oci_execute($tourSQL))
				   {
					  $is_found=0; 
					  while($row=oci_fetch_assoc($tourSQL)){
						  $is_found=1;
						  $named_array[] = array(
                             "ID" => $row['ID'],
                             "RML_ID" => $row['RML_ID'],
                             "ENTRY_DATE" =>$row['ENTRY_DATE'],
                             "START_DATE" => $row['START_DATE'],
                             "END_DATE" => $row['END_DATE'],
                             "REMARKS" => $row['REMARKS'],
                             "ENTRY_BY" => $row['ENTRY_BY'],
                             "LINE_MANAGER_ID" => $row['LINE_MANAGER_ID'],
                             "LINE_MANAGER_APPROVAL_STATUS" => $row['LINE_MANAGER_APPROVAL_STATUS'],
                             "APPROVAL_DATE" =>  $row['APPROVAL_DATE'],
                             "APPROVAL_REMARKS" =>  $row['APPROVAL_REMARKS']
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
