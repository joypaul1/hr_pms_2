<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$emp_id = $_POST['emp_id'] ;
	
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
        $attnArchiveSQL  = oci_parse($objConnect, "SELECT ATTN_YEAR,MONTH_NAME,TO_CHAR(START_DATE,'dd/mm/yyyy') START_DATE,TO_CHAR(END_DATE,'dd/mm/yyyy') END_DATE FROM
											(SELECT DISTINCT(EXTRACT(YEAR FROM ATTN_DATE)) ATTN_YEAR,
											(SELECT TO_CHAR(TO_DATE(TO_CHAR(to_date(ATTN_DATE,'dd-mon-yy'),'mm'), 'MM'), 'MONTH') AS monthname FROM DUAL) MONTH_NAME,
											(TO_DATE(TO_DATE((TO_CHAR(to_date(ATTN_DATE,'dd-mon-yy'),'mm')), 'MM'), 'dd/mm/RRRR') ) START_DATE,
											(TO_DATE(TO_DATE((TO_CHAR(to_date(ATTN_DATE,'dd-mon-yy'),'mm')), 'MM'), 'dd/mm/RRRR')-1 +EXTRACT(DAY FROM LAST_DAY(TO_DATE(TO_DATE((TO_CHAR(to_date(ATTN_DATE,'dd-mon-yy'),'mm')), 'MM'), 'dd/mm/RRRR')))) END_DATE
											 FROM RML_COLL_ATTN_CALENDAR)
											  WHERE  TO_DATE(START_DATE,'dd/mm/yyyy')<=TO_DATE(SYSDATE,'dd/mm/yyyy')
											     and ATTN_YEAR='2023'
											ORDER BY ATTN_YEAR DESC,START_DATE DESC");

				
				if(oci_execute($attnArchiveSQL))
				   {
					  $is_found=0; 
					  while($row=oci_fetch_assoc($attnArchiveSQL)){
						  $is_found=1;
						  $named_array[] = array(
                             "ATTN_YEAR" => $row['ATTN_YEAR'],
                             "MONTH_NAME" => $row['MONTH_NAME'],
                             "START_DATE" => $row['START_DATE'],
                             "END_DATE" =>$row['END_DATE']                        
                             );
							 }
							 
						if($is_found==1){
							 $json = array("status" => "true",
									  "message" => "Data Found successfully.",
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
