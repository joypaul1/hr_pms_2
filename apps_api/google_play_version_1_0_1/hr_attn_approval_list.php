<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$emp_id = $_POST['emp_id'] ;
	
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
    $tourSQL  = oci_parse($objConnect, "select attn.ID,attn.RML_ID,attn.ATTN_DATE,attn.LAT,attn.LANG,attn.OUTSIDE_REMARKS,RML_HR_FKEY(attn.RML_ID,'NU') NU_FKEY,
												 (select a.EMP_NAME from RML_HR_APPS_USER a where a.RML_ID=attn.RML_ID)EMP_NAME
												  from RML_HR_ATTN_DAILY attn
												where attn.LINE_MANAGER_ID='$emp_id'
													and attn.INSIDE_OR_OUTSIDE='Outside Office'
													AND trunc(ATTN.ATTN_DATE) BETWEEN  trunc(SYSDATE)-( select KEY_VALUE from HR_GLOBAL_CONFIGARATION
                                                    where KEY_TYPE='ATTN_OUTDOOR_APPROVAL') AND  trunc(SYSDATE)
													AND attn.LINE_MANAGER_APPROVAL IS NULL
													and attn.IS_ALL_APPROVED=0
													order by ATTN_DATE desc");

				
				if(oci_execute($tourSQL))
				   {
					  $is_found=0; 
					  while($row=oci_fetch_assoc($tourSQL)){
						  $is_found=1;
						  $named_array[] = array(
                             "ID" => $row['ID'],
                             "RML_ID" => $row['RML_ID'],
                             "EMP_NAME" => $row['EMP_NAME'],
                             "ATTN_DATE" =>$row['ATTN_DATE'],
                             "LAT" => $row['LAT'],
                             "LANG" => $row['LANG'],
                             "OUTSIDE_REMARKS" => $row['OUTSIDE_REMARKS'],
                             "NU_FKEY" => $row['NU_FKEY']
							 
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
