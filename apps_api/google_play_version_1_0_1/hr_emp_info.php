<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$rml_id = $_POST['rml_id'] ;
	
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
    $strSQL  = oci_parse($objConnect, "select RML_ID,
											  EMP_NAME,
											  DEPT_NAME,
											  DESIGNATION,
											  BLOOD,
											  MAIL,
											  MOBILE_NO,
											  GENDER,
											  BRANCH_NAME,
											  LAT,
											  LANG,
											  USER_ROLE,
											  ATTN_RANGE_M
										from RML_HR_APPS_USER
											where RML_ID='$rml_id'");

                if(oci_execute($strSQL)){
					$objResultFound = oci_fetch_assoc($strSQL);
		if($objResultFound)
				{
					$named_array = array(
							 "RML_ID" => $objResultFound["RML_ID"],
							 "EMP_NAME" => $objResultFound["EMP_NAME"],
                             "DEPT_NAME" =>$objResultFound["DEPT_NAME"],
                             "DESIGNATION" =>$objResultFound["DESIGNATION"],
                             "BLOOD" => $objResultFound["BLOOD"],
                             "MAIL" => $objResultFound["MAIL"],
                             "MOBILE_NO" => $objResultFound["MOBILE_NO"],
                             "GENDER" => $objResultFound["GENDER"],
                             "BRANCH_NAME" => $objResultFound["BRANCH_NAME"],
                             "LAT" => $objResultFound["LAT"],
                             "LANG" => $objResultFound["LANG"],
                             "USER_ROLE" => $objResultFound["USER_ROLE"],
                             "ATTN_RANGE_M" => $objResultFound["ATTN_RANGE_M"]
                             ); 
							  $json = array("status" => "true",
									  "message" => "Item info Found successfully.",
									  "data" => $named_array
									  );
				}
				}else{
					   $named_array = array();
		               $json =  array("status" => "false", 
									  "message" => "Sorry! You are not Valid User. Please Contact With your HR.",
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
