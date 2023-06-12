<?php
require_once('inc/connoracle.php');
if (!empty($_GET['company_name'])) {

    $company_name=$_GET['company_name'];

    $strSQL  = oci_parse($objConnect, "select DISTINCT(DEPT_NAME) AS DEPT_NAME from RML_HR_APPS_USER
where R_CONCERN='$company_name'
order by DEPT_NAME");
	oci_execute($strSQL);
	echo '<select name="department_name" id="department_name" class="form-control" form="Form1"">';
	echo '<option selected value="--">--</option>';
 	while($row=oci_fetch_assoc($strSQL)){	
		echo "<option value='".$row['DEPT_NAME']."'>".$row['DEPT_NAME']."</option>";
		
       }							  
    echo "</select>";
}else{
	echo '<select name="department_name" id="department_name" class="form-control" form="Form1"">';
	echo '<option selected value="--">--</option>';
	echo "</select>";
}
?>
