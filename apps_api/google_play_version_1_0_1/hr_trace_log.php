<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$emp_id = $_POST['emp_id'] ;
	$system_date = $_POST['current_date'] ;
	$from_time = $_POST['trace_s_time'] ;
	$to_time = $_POST['trace_e_time'] ;
	

	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	 require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
       $strSQL  = oci_parse($objConnect, "select a.id,a.RML_USER_ID,
            (a.LATITUDE||','||a.LONGITUDE) LATLONG,
            TO_CHAR(a.ENTY_DATE,'HH:MI:SS AM') ENTY_TIME
                from RML_EMP_TRACE a
                       where  a.RML_USER_ID='$emp_id'
                       and a.ENTY_DATE BETWEEN TO_DATE('$system_date $from_time','DD/MM/YYYY HH24:MI:SS')  AND TO_DATE('$system_date $to_time','DD/MM/YYYY HH24:MI:SS') 
                       and (ID=(
                       select MAX(a.id)
                from RML_EMP_TRACE a
                       where  a.RML_USER_ID='$emp_id'
                       and a.ENTY_DATE BETWEEN TO_DATE('$system_date $from_time','DD/MM/YYYY HH24:MI:SS')  AND TO_DATE('$system_date $to_time','DD/MM/YYYY HH24:MI:SS') 
                       ) OR ID=(
                       select MIN(a.id)
                from RML_EMP_TRACE a
                       where  a.RML_USER_ID='$emp_id'
                       and a.ENTY_DATE BETWEEN TO_DATE('$system_date $from_time','DD/MM/YYYY HH24:MI:SS')  AND TO_DATE('$system_date $to_time','DD/MM/YYYY HH24:MI:SS') 
                       ))
");                
				if(@oci_execute($strSQL))
				{
					 $is_found=0; 
					  while($row=oci_fetch_assoc($strSQL)){
						  $is_found=1;
						  $named_array[] = array(
                             "RML_ID" => $row['RML_USER_ID'],
                             "LATLONG" =>$row['LATLONG'],
                             "ENT_TIME" => $row['ENTY_TIME']
                             );
							 }
					
					
		               if($is_found==1){
							 $json = array("status" => "true",
									  "data" => $named_array
									  );
						    }else{
		                     $json =  array("status" => "false", 
									  "message" => "Sorry! No data found."
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
