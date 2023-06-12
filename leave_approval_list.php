<?php 
    session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 2)
	{
		header('location:index.php?lmsg_hr=true');
		exit;
	} 

	if(!isset($_SESSION['HR']['id_hr'],$_SESSION['HR']['hr_role']))
	{
		header('location:index.php?lmsg_hr=true');
		exit;
	}		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	
	$v_page='leave_approval_list';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<form id="Form3" action="" method="post"></form>
						<div class="row">
						    <div class="col-sm-3">
								<div class="form-group">
								  <label for="title">EMP ID:</label>
								  <input type="text" form="Form1" name="form_rml_id" class="form-control" id="form_rml_id" value='<?php echo isset($_POST['form_rml_id']) ? $_POST['form_rml_id'] : ''; ?>' />
								</div>
							</div>
						</div>
						
						<script>
						  function onChangeCompany(company_name)
						  {
							  if(window.XMLHttpRequest){
								  xmlhttp = new XMLHttpRequest();
							  }else{
								  xmlhttp = new ActiveXObject("Migrosoft.XMLHTTP");
							  }
							xmlhttp.onreadystatechange = function()
							{
							  if (this.readyState == 4 && this.status == 200) 
							  {
								document.getElementById('branch_name').innerHTML = this.responseText;  
							  }
							};
							xmlhttp.open("GET","populate_comp_to_brnc.php?company_name="+company_name,true);
							xmlhttp.send();
						  }
					   </script>
						
						
						<div class="row">
						    <div class="col-sm-3">
							    <label for="title">Select Company:</label>
								<select name="r_concern" class="form-control" onchange="onChangeCompany(this.value)" form="Form1">
									 <option selected value="">--</option>
										   <?php
											$strSQL  = oci_parse($objConnect, "select distinct(R_CONCERN) R_CONCERN from RML_HR_APPS_USER 
																				where R_CONCERN is not null  and is_active=1 
																				order by R_CONCERN"); 
											oci_execute($strSQL);
										   while($row=oci_fetch_assoc($strSQL)){	
										  ?>
		                                  <option value="<?php echo $row['R_CONCERN'];?>" <?php echo (isset($_POST['r_concern']) && $_POST['r_concern'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>><?php echo $row['R_CONCERN'];?></option>
										  <?php
										   }
										  ?>
								</select>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label for="title">Select Branch:</label>
								  <div id="branch_name">
								    <select name="branch_name" required="" class="form-control" id="branch_name" form="Form1">
								      <option selected value="--">--</option>  
								    </select>
								  </div>
								</div>
							</div>
							<div class="col-sm-3">
							<label>From Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input required="" type="date" form="Form1" name="start_date" class="form-control" id="title" value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							<div class="col-sm-3">
							<label>To Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input required="" form="Form1" type="date" name="end_date" class="form-control" id="title" value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
							   </div>
							</div>
							
						</div>	
						<div class="row mt-3">		
                              <div class="col-sm-9">
							  </div>
                             <div class="col-sm-3">
							    <input class="form-control btn btn-primary" type="submit" value="Search Approval Data" form="Form1">
							  </div>							  	
						</div>
						
					</form>
				</div>
				
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="table-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Select ID</center></th>
								  <th scope="col"><center>User Name</center></th>
								  <th scope="col"><center> Company</center></th>
								  <th scope="col"><center>From Date</center></th>
								  <th scope="col"><center>To Date</center></th>
								  <th scope="col"><center>Total Day's</center></th>
								  <th scope="col"><center>Tour Remarks</center></th>
								  <th scope="col"><center>Department</center></th>
								  <th scope="col"><center>Branch</center></th>
								  <th scope="col"><center>Designation</center></th>
								</tr>
					   </thead>
					   
					  

						<?php
						$emp_session_id=$_SESSION['HR']['emp_id_hr'];
						

						if(isset($_POST['start_date'])){
							
						   $form_rml_id = $_REQUEST['form_rml_id'];
						   $attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                           $attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						   $r_compnay = $_REQUEST['r_concern'];
						   $branch_title = $_REQUEST['branch_name'];
						   if($r_compnay=='--'){
							  $r_compnay=NULL;
							}
						   if($branch_title=='--'){
							  $branch_title=NULL;
							}
						  
						  $strSQL  = oci_parse($objConnect, "select a.ID,
						                                            b.EMP_NAME,
																	a.RML_ID,
																	b.R_CONCERN,
																	a.ENTRY_DATE,
																	a.START_DATE,
																	a.END_DATE,
																	a.REMARKS,
																	a.ENTRY_BY,
																	b.DEPT_NAME,
																	b.BRANCH_NAME,
																	b.DESIGNATION
														from RML_HR_EMP_LEAVE a,RML_HR_APPS_USER b
														where a.RML_ID=b.RML_ID
														 and ('$form_rml_id' is null OR A.RML_ID='$form_rml_id')
														 and (trunc(START_DATE) BETWEEN TO_DATE('$attn_start_date','dd/mm/yyyy') AND TO_DATE('$attn_end_date','dd/mm/yyyy') OR
                                                              trunc(END_DATE) BETWEEN TO_DATE('$attn_start_date','dd/mm/yyyy') AND TO_DATE('$attn_end_date','dd/mm/yyyy'))
														and a.LINE_MNGR_APVL_STS IS NULL
														and a.IS_APPROVED IS NULL
														and ('$r_compnay' IS NULL OR b.R_CONCERN='$r_compnay')
														and ('$branch_title' IS NULL OR b.BRANCH_NAME='$branch_title')
														
														order by START_DATE desc"); 
							
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tbody>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td align="center">
								  <input type="checkbox" name="check_list[]" value="<?php echo $row['ID'];?>" 
								  style="text-align: center; vertical-align: middle;horiz-align: middle;">
							  </td>
							  <td><?php echo $row['EMP_NAME'].'('.$row['RML_ID'].')';?></td>
							  <td><?php echo $row['R_CONCERN'];?></td>
							  <td><?php echo $row['START_DATE'];?></td>
							  <td><?php echo $row['END_DATE'];?></td>
							  <td align="center">
							     <?php 
								    echo abs($row['END_DATE']-$row['START_DATE'])+1;
								 ?>
							  </td>
							  <td><?php echo $row['REMARKS'];?></td>
							  <td><?php echo $row['DEPT_NAME'];?></td>
							  <td><?php echo $row['BRANCH_NAME'];?></td>
							  <td><?php echo $row['DESIGNATION'];?></td>
						 </tr>
						 <?php
						  } 
						  if($number>0){
						  ?>
						   <tr>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Save & Approve"/>	
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Save & Denied"/>	
							</td>
						   </tr>
						  <?php
						  }
						  }
						  ?>
					</tbody>	
				 
		              </table>
					</div>
					
				  </div>
				</div>
			  </form>
				<?php
				    
					if(isset($_POST['submit_approval'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "update RML_HR_EMP_LEAVE 
										set LINE_MNGR_APVL_STS=1,
										IS_APPROVED=1,
										LINE_MNGR_APVL_BY='$emp_session_id',
										LINE_MNGR_APVL_DATE=sysdate
                                         where ID='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						 $attnProcSQL  = oci_parse($objConnect, "declare V_START_DATE VARCHAR2(100); V_END_DATE VARCHAR2(100);  V_RML_ID VARCHAR2(100);
									  begin SELECT TO_CHAR(START_DATE,'dd/mm/yyyy'),TO_CHAR(END_DATE,'dd/mm/yyyy'),RML_ID INTO V_START_DATE,V_END_DATE,V_RML_ID FROM RML_HR_EMP_LEAVE WHERE ID='$TT_ID_SELECTTED'; RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_START_DATE,'dd/mm/yyyy'),TO_DATE(V_END_DATE,'dd/mm/yyyy'));end;");
			   
			            oci_execute($attnProcSQL);
						  
					echo 'Successfully Approved Leave, Syestem ID '.$TT_ID_SELECTTED."</br>";
					}
					}else{
						echo 'Sorry! You have not select any ID Code.';
					}
					}
					
					// Denied option
					if(isset($_POST['submit_denied'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "update RML_HR_EMP_LEAVE 
										set LINE_MNGR_APVL_STS=0,
										IS_APPROVED=0,
										LINE_MNGR_APVL_BY='$emp_session_id',
										LINE_MNGR_APVL_DATE=sysdate
                                         where ID='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						  
					echo 'Successfully Denied Leave. System ID '.$TT_ID_SELECTTED."</br>";
					}
					}else{
						echo 'Sorry! You have not select any ID Code.';
					}
					}
					
					
				 ?>
			</div>
		</div>
	  
  	
				
		


  

</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  