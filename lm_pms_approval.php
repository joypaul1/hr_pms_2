<?php 
    session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 3)
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
	
	$v_page='lm_pms_approval';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	$emp_session_id=$_SESSION['HR']['emp_id_hr'];
    $v_view_approval=0;
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
<div class="row">
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<form id="Form3" action="" method="post"></form>
						<div class="row">
						    <div class="col-sm-8"></div>
						    <div class="col-sm-4">
							<label>Select Your Concern:</label>
								<select name="emp_concern" class="form-control" form="Form1" > 
								 <option selected value="">Select Concern</option>
								      <?php
						                $strSQL  = oci_parse($objConnect, "select RML_ID,EMP_NAME from RML_HR_APPS_USER 
																		where LINE_MANAGER_RML_ID ='$emp_session_id'
																		and is_active=1 
																		order by EMP_NAME"); 
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
	
									  <option value="<?php echo $row['RML_ID'];?>"><?php echo $row['EMP_NAME'];?></option>
									  <?php
									   }
									  ?>
							</select>
							</div>
							
							
							
						</div>	
						<div class="row mt-3">		
                              <div class="col-sm-4">
							  </div>
							 <div class="col-sm-4">
							  </div>
                             <div class="col-sm-4">
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
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">PMS Info</th>
								  <th scope="col"> Remarks</th>
								</tr>
					   </thead>
					   
					  

						<?php
						if(isset($_POST['emp_concern'])){
                          $emp_concern = $_REQUEST['emp_concern'];
						  $strSQL  = oci_parse($objConnect, "SELECT A.ID,
													   A.EMP_ID,
													   A.EMP_NAME,
													   A.EMP_DEPT,
													   A.EMP_WORK_STATION,
													   A.EMP_DESIGNATION,
													   A.GROUP_NAME,
													   A.GROUP_CONCERN,
													   A.CREATED_DATE,
													   A.CREATED_BY,
													   A.LINE_MANAGE_1_REMARKS,HR_PMS_LIST_ID,
													  (SELECT AA.PMS_NAME FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS PMS_TITLE
													FROM HR_PMS_EMP A
													WHERE SELF_SUBMITTED_STATUS=1
													AND LINE_MANAGER_1_ID='$emp_session_id'
													AND A.EMP_ID='$emp_concern'"); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
						   $v_view_approval=1;
                           ?>
						   <tbody>
						   <tr>
							    <td>
								 <input type="checkbox" name="check_list[]" value="<?php echo $row['HR_PMS_LIST_ID'];?>">
								 <?php echo $number;?>
								</td>
							    <td>
								<a href="pms_kpi_dtls_lm.php?key=<?php echo $row['HR_PMS_LIST_ID'].'&emp_id='.$row['EMP_ID'];?>"><?php echo $row['PMS_TITLE'];?>
								
								</a>
							     <?php echo ',<br>';
								       echo $row['EMP_NAME'];
							           echo ',<br>';
									   echo $row['EMP_ID'];
									   echo ',<br>';
									   echo $row['EMP_DEPT'];
									   echo ',<br>';
									   echo $row['EMP_DESIGNATION'];
									   echo ',<br>';
									   echo $row['EMP_WORK_STATION'];?>
									   
									   <input class="btn btn-primary btn pull-right" type="submit" name="submit_approval_single" value="Approve"/>
								</td>
								<td>
							     <?php echo 'Created Date: '.$row['CREATED_BY'];
								       echo ',<br>';
								       echo 'Created By: '.$row['CREATED_DATE'];
							           echo ',<br>';
									   echo 'Remarks: '.$row['LINE_MANAGE_1_REMARKS'];
									 ?>
									  <input  class="form-control" placeholder="Denied Remarks" type='text'/>
									  <input class="btn btn-primary btn pull-right" type="submit" name="submit_denied_single" value="Denied"/>
								</td>
						 </tr>
						 <?php
						  } if($v_view_approval>0){ ?>
						   <tr>
							<td></td>
							<td>
							<!--<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve"/> -->
							</td>
							<td>
							<!--<input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Denied"/>	-->
							</td>
						   </tr>
						  <?php
						  }
						  }else{
						     $allDataSQL  = oci_parse($objConnect, 
							   "SELECT A.ID,
							           A.EMP_ID,
							           A.EMP_NAME,
									   A.EMP_DEPT,
									   A.EMP_WORK_STATION,
									   A.EMP_DESIGNATION,
									   A.GROUP_NAME,
									   A.GROUP_CONCERN,
									   A.CREATED_DATE,
									   A.CREATED_BY,
									   A.LINE_MANAGE_1_REMARKS,HR_PMS_LIST_ID,
                                      (SELECT AA.PMS_NAME FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS PMS_TITLE
									FROM HR_PMS_EMP A
									WHERE SELF_SUBMITTED_STATUS=1
								    AND LINE_MANAGER_1_STATUS IS NULL
									AND LINE_MANAGER_1_ID='$emp_session_id'"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
						   $v_view_approval=1;
                           ?>
						   <tr>
							    <td>
								 <input type="checkbox" name="check_list[]" value="<?php echo $row['HR_PMS_LIST_ID'];?>">
								 <?php echo $number;?>
								</td>
							    <td>
								<a href="pms_kpi_dtls_lm.php?key=<?php echo $row['HR_PMS_LIST_ID'].'&emp_id='.$row['EMP_ID'];?>"><?php echo $row['PMS_TITLE'];?>
								
								</a>
							     <?php echo ',<br>';
								       echo $row['EMP_NAME'];
							           echo ',<br>';
									   echo $row['EMP_ID'];
									   echo ',<br>';
									   echo $row['EMP_DEPT'];
									   echo ',<br>';
									   echo $row['EMP_DESIGNATION'];
									   echo ',<br>';
									   echo $row['EMP_WORK_STATION'];?>
									   <input class="btn btn-primary btn pull-right" type="submit" name="submit_approval_single" value="Approve"/>
								</td>
								<td>
							     <?php echo 'Created Date: '.$row['CREATED_BY'];
								       echo ',<br>';
								       echo 'Created By: '.$row['CREATED_DATE'];
							           echo ',<br>';
									   echo 'Remarks: '.$row['LINE_MANAGE_1_REMARKS'];
									 ?>
									 <input class="form-control" placeholder="Denied Remarks" type='text'/>
									  <input class="btn btn-primary btn pull-right" type="submit" name="submit_denied_single" value="Denied"/>
								</td>
						 </tr>
						 <?php
						  }
						  if($v_view_approval>0){
						   ?>
						   <tr>
							<td></td>
							<td>
							<!--<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve"/>	-->
							</td>
							<td>
							<!--<input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Denied"/>       -->
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
				    
					if(isset($_POST['submit_approval_single'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "update HR_PMS_EMP 
										set LINE_MANAGER_1_STATUS=1,
										LINE_MANAGER_1_UPDATED=SYSDATE
                                         where ID='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						  
					echo 'Successfully Approved PMS ID '.$TT_ID_SELECTTED."</br>";
					}echo "<script>window.location = 'http://202.40.181.98:9090/rHR/lm_pms_approval.php'</script>";
					}else{
						echo 'Sorry! You have not select any ID Code.';
					}
					}
					
					// Denied option
					if(isset($_POST['submit_denied_single'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "update HR_PMS_EMP 
										set LINE_MANAGER_1_STATUS=0,
										    LINE_MANAGER_1_UPDATED=SYSDATE
                                         where ID='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						  
					echo 'Successfully Denied PMS ID '.$TT_ID_SELECTTED."</br>";
					}echo "<script>window.location = 'http://202.40.181.98:9090/rHR/lm_pms_approval.php'</script>";
					}else{
						echo 'Sorry! You have not select any ID Code.';
					}
					}
					
					
				 ?>
			</div>
</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  