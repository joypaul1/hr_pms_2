<?php
ob_start();
require_once('json.php'); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  $rml_id=$_REQUEST['rml_id'];

  $conn=oci_connect("DEVELOPERS","Test1234","10.99.99.20:1525/ORCLPDB",'AL32UTF8');
  //$conn=oci_connect("DEVELOPERS2","Test1234","192.168.172.61:1521/xe",'AL32UTF8');
  $strSQL  = oci_parse($conn, 
              "select LEAVE_TYPE,
                      LEAVE_PERIOD,
					  LEAVE_ASSIGN,
					  LEAVE_TAKEN,
					  LATE_LEAVE 
				FROM LEAVE_DETAILS_INFORMATION
                WHERE RML_ID='RML-00955'
                AND LEAVE_TYPE in ('CL','EL','SL')
			  "); 

    $objQuery=oci_execute($strSQL);

	while($row=oci_fetch_assoc($strSQL)){
		 $named_array[] = array(
						     "LEAVE_TYPE" =>$row['LEAVE_TYPE'],
                             "LEAVE_PERIOD" => $row['LEAVE_PERIOD'],
                             "LEAVE_ASSIGN" => $row['LEAVE_ASSIGN'],
                             "LEAVE_TAKEN" => $row['LEAVE_TAKEN'],
                             "LATE_LEAVE" => $row['LATE_LEAVE']                            
                             );
	  } 
	
    $json = array("items" => $named_array
						 );		
	echo json_encode($json);

?>