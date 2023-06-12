<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$rml_id = $_POST['rml_id'];
	$user_password = $_POST['user_password'] ;
	$iemiNumber = $_POST['iemiNumber'] ;
	
	$firebaseKey=$_POST['fkey'] ;
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
	
    require_once('db_conn_oracle.php');
	if($isDatabaseConnected==1){
	    $strSQL  = oci_parse($objConnect, "SELECT RML_ID,R_CONCERN,IEMI_NO,DESIGNATION,FIRE_BASE_ID,
															RML_HR_FKEY(RML_ID,'LINE_MANAGER') LINE_MANAGER_FKEY,
															RML_HR_FKEY(RML_ID,'DEPT_HEAD') DEPT_MANAGER_FKEY,
														  USER_ROLE,APPS_UPDATE_VERSION,
														  LAT,LANG,
														  LAT_2,LANG_2,
														  LAT_3,LANG_3,
														  LAT_4,LANG_4,
														  LAT_5,LANG_5,
														  LAT_6,LANG_6,
														  ATTN_RANGE_M,IS_ACTIVE_LAT_LANG,EMP_NAME,
														  LINE_MANAGER_RML_ID,LINE_MANAGER_MOBILE,DEPT_HEAD_RML_ID,DEPT_HEAD_MOBILE_NO,PUNCH_DATA_SYN,
														  (RML_HR_ATTN_STATUS_COUNT(
														      RML_ID,
                                                              TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              'P'
                                                          )) PRESENT_TOTAL,
														  (RML_HR_ATTN_STATUS_COUNT(
														      RML_ID,
                                                              TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              'L'
                                                          )) LATE_TOTAL,
														  (RML_HR_ATTN_STATUS_COUNT(
														      RML_ID,
                                                              TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              'A'
                                                          )) ABSENT_TOTAL,
														  (RML_HR_ATTN_STATUS_COUNT(
														      RML_ID,
                                                              TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              'H'
                                                          )) HOLIDAY_TOTAL,
														  (RML_HR_ATTN_STATUS_COUNT(
														      RML_ID,
                                                              TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              'W'
                                                          )) WEEKEND_TOTAL,
														  (RML_HR_ATTN_STATUS_COUNT(
                                                              RML_ID,
                                                              TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              'T'
                                                          )) TOUR_TOTAL,
                                                           (RML_HR_ATTN_STATUS_COUNT(
                                                              RML_ID,
                                                              TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
                                                              'LV'
                                                          )) LEAVE_TOTAL,
														  (SELECT MESSAGE FROM RML_HR_NOTIFICATION WHERE IS_ACTIVE=1 AND CONCERN=R_CONCERN AND KEY_WORD='WELCOME_MESSAGE')USER_NOTIFICATION,
														  TRACE_LOCATION
														  FROM RML_HR_APPS_USER
															WHERE RML_ID='$rml_id'
															      AND PASS_MD5='$user_password'
															AND IS_ACTIVE=1");
															
							@oci_execute($strSQL);
				            $objResultFound = oci_fetch_assoc($strSQL);
				            $isFound=0;		
                if($objResultFound)
				   {
					$DatabaseiemiNo=$objResultFound["IEMI_NO"];  
					$Fdatabasekey=$objResultFound["FIRE_BASE_ID"];  
					
                 					
					if($DatabaseiemiNo!=$iemiNumber){
						$strSQLFkeyUpdate  = oci_parse($objConnect, "update RML_HR_APPS_USER set IEMI_NO='$iemiNumber' where RML_ID='$rml_id'");
						oci_execute($strSQLFkeyUpdate);	
					}
                				
			        
					// Fkey update
					if(strlen($firebaseKey)>0 && $firebaseKey!=$Fdatabasekey)
					{
						$strSQLFkeyUpdate  = oci_parse($objConnect, "update RML_HR_APPS_USER set FIRE_BASE_ID='$firebaseKey',FKEY_UPDATED_DATE=SYSDATE where RML_ID='$rml_id'");
						oci_execute($strSQLFkeyUpdate);	
					}
					
					
					
					
					// Session data get on database
					$SESSTION_SQL  = oci_parse($objConnect, "BEGIN HR_APPS_USER_SESSION_CREATE('$rml_id'); END;");
					@oci_execute($SESSTION_SQL);
					
					
					
					
					
					
					if($rml_id=='RG001'){
						 $named_array = array(
                             "RML_ID" => $objResultFound["RML_ID"],
							 "EMP_NAME" => $objResultFound["EMP_NAME"],
							 "DESIGNATION" => $objResultFound["DESIGNATION"],
                             "USER_ROLE" =>$objResultFound["USER_ROLE"],
                             "R_CONCERN" =>$objResultFound["R_CONCERN"],
                             "LAT" => $objResultFound["LAT"],
                             "LANG" => $objResultFound["LANG"],
							 "LAT_2" => $objResultFound["LAT_2"],
                             "LANG_2" => $objResultFound["LANG_2"],
							 
                             "LAT_3" => $objResultFound["LAT_3"],
                             "LANG_3" => $objResultFound["LANG_3"],
							 
                             "LAT_4" => $objResultFound["LAT_4"],
                             "LANG_4" => $objResultFound["LANG_4"],
							 
                             "LAT_5" => $objResultFound["LAT_5"],
                             "LANG_5" => $objResultFound["LANG_5"],
							 
                             "LAT_6" => $objResultFound["LAT_6"],
                             "LANG_6" => $objResultFound["LANG_6"],
                             "ATTN_RANGE_M" => $objResultFound["ATTN_RANGE_M"],
                             "IS_ACTIVE_LAT_LANG" => $objResultFound["IS_ACTIVE_LAT_LANG"],
							 
							 
                             "LINE_MANAGER_FKEY" => $objResultFound["LINE_MANAGER_FKEY"],
                             "DEPT_MANAGER_FKEY" => $objResultFound["DEPT_MANAGER_FKEY"],
							 
                             "LINE_MANAGER_RML_ID" => $objResultFound["LINE_MANAGER_RML_ID"],
                             "LINE_MANAGER_MOBILE" => $objResultFound["LINE_MANAGER_MOBILE"],
                             "DEPT_HEAD_RML_ID" => $objResultFound["DEPT_HEAD_RML_ID"],
                             "DEPT_HEAD_MOBILE_NO" => $objResultFound["DEPT_HEAD_MOBILE_NO"],
							 
                             "PUNCH_DATA_SYN" => $objResultFound["PUNCH_DATA_SYN"],
							 
                             "PRESENT_TOTAL" => $objResultFound["PRESENT_TOTAL"],
                             "LATE_TOTAL" => $objResultFound["LATE_TOTAL"],
                             "ABSENT_TOTAL" => $objResultFound["ABSENT_TOTAL"],
                             "TOUR_TOTAL" => $objResultFound["TOUR_TOTAL"],
                             "LEAVE_TOTAL" => $objResultFound["LEAVE_TOTAL"],
                             "HOLIDAY_TOTAL" => $objResultFound["HOLIDAY_TOTAL"],
                             "WEEKEND_TOTAL" => $objResultFound["WEEKEND_TOTAL"],
							 
							 
                             "USER_NOTIFICATION" => $objResultFound["USER_NOTIFICATION"],
                             "APPS_UPDATE_VERSION" => $objResultFound["TRACE_LOCATION"]
                             ); 
							 $json = array("status" => "true",
									  "message" => "Item info Found successfully.",
									  "data" => $named_array
									  );
					}else{
				    if($iemiNumber==$DatabaseiemiNo){  
					      $named_array = array(
                             "RML_ID" => $objResultFound["RML_ID"],
							 "EMP_NAME" => $objResultFound["EMP_NAME"],
							 "DESIGNATION" => $objResultFound["DESIGNATION"],
                             "USER_ROLE" =>$objResultFound["USER_ROLE"],
                             "R_CONCERN" =>$objResultFound["R_CONCERN"],
                             "LAT" => $objResultFound["LAT"],
                             "LANG" => $objResultFound["LANG"],
							 
                             "LAT_2" => $objResultFound["LAT_2"],
                             "LANG_2" => $objResultFound["LANG_2"],
							 
                             "LAT_3" => $objResultFound["LAT_3"],
                             "LANG_3" => $objResultFound["LANG_3"],
							 
                             "LAT_4" => $objResultFound["LAT_4"],
                             "LANG_4" => $objResultFound["LANG_4"],
							 
                             "LAT_5" => $objResultFound["LAT_5"],
                             "LANG_5" => $objResultFound["LANG_5"],
							 
                             "LAT_6" => $objResultFound["LAT_6"],
                             "LANG_6" => $objResultFound["LANG_6"],
							 
                             "ATTN_RANGE_M" => $objResultFound["ATTN_RANGE_M"],
                             "IS_ACTIVE_LAT_LANG" => $objResultFound["IS_ACTIVE_LAT_LANG"],
							 
							 
                             "LINE_MANAGER_FKEY" => $objResultFound["LINE_MANAGER_FKEY"],
                             "DEPT_MANAGER_FKEY" => $objResultFound["DEPT_MANAGER_FKEY"],
                             
							 
                             "LINE_MANAGER_RML_ID" => $objResultFound["LINE_MANAGER_RML_ID"],
                             "LINE_MANAGER_MOBILE" => $objResultFound["LINE_MANAGER_MOBILE"],
                             "DEPT_HEAD_RML_ID" => $objResultFound["DEPT_HEAD_RML_ID"],
                             "DEPT_HEAD_MOBILE_NO" => $objResultFound["DEPT_HEAD_MOBILE_NO"],
							 
                             "PUNCH_DATA_SYN" => $objResultFound["PUNCH_DATA_SYN"],
							 
                             "PRESENT_TOTAL" => $objResultFound["PRESENT_TOTAL"],
                             "LATE_TOTAL" => $objResultFound["LATE_TOTAL"],
                             "ABSENT_TOTAL" => $objResultFound["ABSENT_TOTAL"],
                             "TOUR_TOTAL" => $objResultFound["TOUR_TOTAL"],
                             "LEAVE_TOTAL" => $objResultFound["LEAVE_TOTAL"],
                             "HOLIDAY_TOTAL" => $objResultFound["HOLIDAY_TOTAL"],
                             "WEEKEND_TOTAL" => $objResultFound["WEEKEND_TOTAL"],
							 
							 
                             "USER_NOTIFICATION" => $objResultFound["USER_NOTIFICATION"],
                             "APPS_UPDATE_VERSION" => $objResultFound["TRACE_LOCATION"]
                             ); 
							 $json = array("status" => "true",
									  "message" => "Item info Found successfully.",
									  "data" => $named_array
									  );
					      }else{
							/*$json = array("status" => "false", 
										  "message" =>"Your IMEI No: ".$iemiNumber. "\nPlease Contact With your HR."
										  );
							*/
							  $json = array("status" => "false", 
							  "message" =>"Your IMEI/Device Number: ".$iemiNumber. "\nPlease Try Again."
							  );
						  } 
					}
				   }
              oci_close($objConnect);				   
	        }else{
				
		        $json =  array("status" => "false", 
									  "message" => "Sorry! You are not Valid User. Its a security issuses. Dont try to again & again without Rangs Group Permission"
									  );
				}

               
															

}else{
	$json = array("status" => 0, "message" => "Request method not accepted");
}
	echo json_encode($json);
	
?>
