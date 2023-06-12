<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$emp_id = $_POST['rml_id'] ;
	$securityToken=$_POST['apikey'] ;
	$isDatabaseConnected=0;
    require_once('db_conn_oracle.php');
	
	
	

	$leave_array = array();
	$attn_array = array();
	$apps_array = array();
	$personal_array = array();
	$att_leave_tour_array = array();
	$approval_array = array();
	
	if($isDatabaseConnected==1){
    
	       // Yearly Leave Assign Taken Status
	        $LeaveSQL  = oci_parse($objConnect, 
	             "SELECT RML_ID,LEAVE_TYPE,
						  LEAVE_PERIOD,
						  LEAVE_ASSIGN,
						  LEAVE_TAKEN,
						  LATE_LEAVE 
					FROM LEAVE_DETAILS_INFORMATION
					WHERE RML_ID='$emp_id'
					and LEAVE_PERIOD='2023'
					AND LEAVE_TYPE in ('CL','EL','SL')");
	       if(@oci_execute($LeaveSQL))
	        {  
	           while($row=oci_fetch_assoc($LeaveSQL)){
				   //$is_found_leave=$row['LEAVE_TYPE'];
		            $leave_array[] = array(
						 "LEAVE_TYPE" =>$row['LEAVE_TYPE'].'-'.$row['LEAVE_PERIOD'],
                         "LEAVE_PERIOD" => $row['LEAVE_PERIOD'],
                         "LEAVE_ASSIGN" => $row['LEAVE_ASSIGN'],
                         "LEAVE_TAKEN" => $row['LEAVE_TAKEN'],
                         "LATE_LEAVE" => $row['LATE_LEAVE'] 
						 );
	            }		
	        }
           // Current Month Attendance	
	        $AttnSQL  = oci_parse($objConnect, 
	             "SELECT STATUS,COUNT(STATUS) TATAL_COUNT FROM
						(
						SELECT STATUS FROM RML_HR_ATTN_DAILY_PROC
						WHERE RML_ID='$emp_id'
						AND TRUNC(ATTN_DATE) BETWEEN 
						(TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'))
						 AND (TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'))
						)GROUP BY STATUS");					

	        if(@oci_execute($AttnSQL))
	        {
		        while($row=oci_fetch_assoc($AttnSQL)){
		            $attn_array[] = array(
						 "STATUS" => $row['STATUS'],
						 "TATAL_COUNT" => $row['TATAL_COUNT']
						 );
		        }
			}
        // App Access date
		 $AppsSQL  = oci_parse($objConnect, 
	             "SELECT APPS_NAME,ROLE_TYPE,STATUS,NAME_TITLE,IMG_URL,USE_ID FROM HR_EMP_APPS_ACCESS
                       WHERE STATUS=1
					   AND RML_HR_APPS_USER_ID =
                                      (SELECT ID from RML_HR_APPS_USER WHERE RML_ID='$emp_id')");					

	        if(@oci_execute($AppsSQL))
	        {
		        while($row=oci_fetch_assoc($AppsSQL)){
		            $apps_array[] = array(
						 "APPS_NAME" => $row['APPS_NAME'],
						 "ROLE_TYPE" => $row['ROLE_TYPE'],
						 "NAME_TITLE" => $row['NAME_TITLE'],
						 "IMG_URL" => $row['IMG_URL'],
						 "USE_ID" => $row['USE_ID']
						 );
		        }
			}
		 // Personal Information date
		 $PersonalInfoSQL  = oci_parse($objConnect, 
	             "SELECT EMP_NAME,R_CONCERN,DESIGNATION,DEPT_NAME,MAIL 
				         FROM RML_HR_APPS_USER WHERE RML_ID='$emp_id'");					

	        if(@oci_execute($PersonalInfoSQL))
	        {
		        while($row=oci_fetch_assoc($PersonalInfoSQL)){
		            $personal_array[] = array(
						 "EMP_NAME" => $row['EMP_NAME'],
						 "R_CONCERN" => $row['R_CONCERN'],
						 "DESIGNATION" => $row['DESIGNATION'],
						 "DEPT_NAME" => $row['DEPT_NAME'],
						 "MAIL" => 'http://202.40.181.98:9090/rHR/images/user_profile.png'
						 );
		        }
			}
		 // Attendance, Leave,Tour Create
		 $dataSQL  = oci_parse($objConnect, 
	             "select  1 ID, 'Sign In / Out' TITLE,'http://202.40.181.98:9090/rHR/images/in_out.png' IMG_URL from dual
        UNION ALL select  2 ID,'Leave Entry' TITLE,'http://202.40.181.98:9090/rHR/images/leave_entry.png' IMG_URL from dual
        UNION ALL select  3 ID,'Tour Entry' TITLE,'http://202.40.181.98:9090/rHR/images/tour_entry.png' IMG_URL from dual
        UNION ALL select  4 ID,'Contact Book' TITLE,'http://202.40.181.98:9090/rHR/images/call_mail.png' IMG_URL from dual
		UNION ALL select  5 ID,'PMS Information' TITLE,'http://202.40.181.98:9090/rHR/images/pms.png' IMG_URL from dual
				  ");					

	        if(@oci_execute($dataSQL))
	        {
		        while($row=oci_fetch_assoc($dataSQL)){
		            $att_leave_tour_array[] = array(
						 "ID" => $row['ID'],
						 "TITLE" => $row['TITLE'],
						 "IMG_URL" => $row['IMG_URL']
						 );
		        }
			}	
		 // Approval Attendance, Leave,Tour Information
		 $approvalSQL  = oci_parse($objConnect, 
	             "select 1 ID, 'In/Out Approval' TITLE,'http://202.40.181.98:9090/rHR/images/in_out.png' IMG_URL,0 PENDING_APPROVAL from dual
                  UNION ALL select  2 ID,'Leave Approval' TITLE,'http://202.40.181.98:9090/rHR/images/leave_approval.png' IMG_URL,0 PENDING_APPROVAL from dual
                  UNION ALL select  3 ID,'Tour Approval' TITLE,'http://202.40.181.98:9090/rHR/images/tour_approval.png' IMG_URL,0 PENDING_APPROVAL from dual");					

	        if(@oci_execute($approvalSQL))
	        {
		        while($row=oci_fetch_assoc($approvalSQL)){
		            $approval_array[] = array(
						 "ID" => $row['ID'],
						 "TITLE" => $row['TITLE'],
						 "IMG_URL" => $row['IMG_URL'],
						 "PENDING_APPROVAL" => $row['PENDING_APPROVAL'],
						 "SHOWING_STATUS" => "true"
						 );
		        }
			}	
		
		
		if(count(@$leave_array)>1){
			$json = array("status" => "true",
					  "message" => "Item info Found successfully.",
					  "data_leave" => $leave_array,
					  "data_attn" => $attn_array,
					  "data_apps" => $apps_array,
					  "data_personal" => $personal_array,
					  "att_leave_tour_array" => $att_leave_tour_array,
					  "approval_array" => $approval_array,
					  );
		}else{
		    $json =  array("status" => "false", 
					  "message" => "Sorry! No data found.",
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
