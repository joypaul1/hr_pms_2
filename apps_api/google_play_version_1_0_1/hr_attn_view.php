<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$v_rml_id = $_POST['rml_id'] ;
	$attn_start_date = $_POST['attn_start_date'] ;
	$attn_end_date = $_POST['attn_end_date'] ;
	
	
	$securityToken=$_POST['apikey'] ;
	//$securityToken='DD019D2558F6E70837033950DBFE587A' ;
	$isDatabaseConnected=0;
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
            $attnSQL  = oci_parse($objConnect, "declare start_date VARCHAR2(100):=to_char(sysdate,'dd/mm/yyyy');begin RML_HR_ATTN_PROC('$v_rml_id',TO_DATE(start_date,'dd/mm/yyyy') ,TO_DATE(start_date,'dd/mm/yyyy') );end;");
			   
			oci_execute($attnSQL);
			if($attn_start_date==''){
			    $strSQL  = oci_parse($objConnect, "select ATTN_DATE,IN_TIME,OUT_TIME,STATUS ATTN_STATUS,DAY_NAME from RML_HR_ATTN_DAILY_PROC
													where RML_ID='$v_rml_id'
													 and ATTN_DATE between to_date((SELECT TO_CHAR(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1),'dd/mm/yyyy') FROM dual),'dd/mm/yyyy') and sysdate
													order by ATTN_DATE desc");
			  }else{
				  $strSQL  = oci_parse($objConnect, "select ATTN_DATE,IN_TIME,OUT_TIME,STATUS ATTN_STATUS,DAY_NAME from RML_HR_ATTN_DAILY_PROC
                                                    where RML_ID='$v_rml_id'
                                                     and trunc(ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
                                                    order by ATTN_DATE desc"); 
			       }
				   if(oci_execute($strSQL))
				   {
					  $is_found=0; 
					  while($row=oci_fetch_assoc($strSQL)){
						  $is_found=1;
						  $named_array[] = array(
						     "ATTN_DATE" =>$row['ATTN_DATE'],
                             "IN_TIME" => $row['IN_TIME'],
                             "OUT_TIME" => $row['OUT_TIME'],
                             "ATTN_STATUS" => $row['ATTN_STATUS'],
                             "DAY_NAME" => $row['DAY_NAME']                            
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
