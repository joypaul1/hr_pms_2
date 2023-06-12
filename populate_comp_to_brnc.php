<?php
require_once('inc/connoracle.php');
if (!empty($_GET['company_name'])) {

    $company_name=$_GET['company_name'];

    $strSQL  = oci_parse($objConnect, "select DISTINCT(BRANCH_NAME) AS BRANCH_NAME from RML_HR_APPS_USER
where R_CONCERN='$company_name'
order by BRANCH_NAME");
	oci_execute($strSQL);
	//echo '<select name="department_id" class="form-control" onchange="onChangeDepartment(this.value,'.$folder_id.')">';
	echo '<select name="branch_name" id="branch_name" class="form-control" form="Form1"">';
	echo '<option selected value="--">--</option>';
 	while($row=oci_fetch_assoc($strSQL)){	
		echo "<option value='".$row['BRANCH_NAME']."'>".$row['BRANCH_NAME']."</option>";
		
       }							  
    echo "</select>";
}else{
	echo '<select name="branch_name" id="branch_name" class="form-control" form="Form1"">';
	echo '<option selected value="--">--</option>';
	echo "</select>";
}
?>
