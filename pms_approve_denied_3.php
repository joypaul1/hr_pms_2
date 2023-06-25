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
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	$emp_session_id=$_SESSION['HR']['emp_id_hr'];
	$v_key = $_REQUEST['key'];
	$v_emp_id = $_REQUEST['emp_id'];
	$v_emp_table_id = $_REQUEST['tab_id'];
	
	
	
	
	
	$strSQL  = oci_parse($objConnect, 
								"select RML_ID,
								       EMPLOYEE_NAME EMP_NAME,
									   COMPANY_NAME R_CONCERN,
									   DEPARTMENT DEPT_NAME,
									   WORKSTATION BRANCH_NAME,
									   DESIGNATION,
									   BRAND EMP_GROUP,
									   COLL_HR_EMP_NAME((SELECT aa.LINE_MANAGER_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)) LINE_MANAGER_1_NAME,
									   COLL_HR_EMP_NAME((SELECT aa.DEPT_HEAD_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)) LINE_MANAGER_2_NAME
								from empinfo_view_api@ERP_PAYROLL bb where RML_ID='$v_emp_id'"); 
						  
    oci_execute($strSQL);
	
	
	
	
	// approval status
	$v_line_manager_status='';
	$strSQLsss  = oci_parse($objConnect, 
								"select HR_STATUS from HR_PMS_EMP where ID=$v_emp_table_id"); 
						  
    oci_execute($strSQLsss);
	 while($rowrr=oci_fetch_assoc($strSQLsss)){	
	 $v_line_manager_status=$rowrr['HR_STATUS'];
	 }
	
?>


  <div class="content-wrapper">
    <div class="container-fluid">
		</br>
		

		 <div class="container-fluid">
			
			<div class="row mt-3 center">
				<h3><b>Performance Assessment</b></h3>
				<h6>Employee Information</h6>
			</div>
            <hr>
			<div class="row">
				<div class="col-lg-12">
				   <form id="Form1" action="" method="post"></form>
				   <form id="Form2" action="" method="post"></form>
					
					   <?php
					    while($row=oci_fetch_assoc($strSQL)){	
					    ?>
					
						<div class="row">
						    <div class="col-sm-3">
							    <label for="exampleInputEmail1">Employee ID:</label>
							    <input name="emp_id" readonly form="Form1"  placeholder="EMP-ID" class="form-control"  type='text' value='<?php echo $row['RML_ID'];?>' />
							</div>
							<div class="col-sm-3">
							    <label for="exampleInputEmail1">Employee Name:</label>
							    <input required="" name="emp_name" readonly  placeholder="EMP Name" class="form-control"  type='text' value='<?php echo $row['EMP_NAME'];?>' />
							</div>
							<div class="col-sm-3">
							    <label for="exampleInputEmail1">Employee Designation:</label>
							    <input required="" name="emp_name" readonly  placeholder="EMP Name" class="form-control"  type='text' value='<?php echo $row['DESIGNATION'];?>' />
							</div>
							<div class="col-sm-3">
							    <label for="exampleInputEmail1">Employee Department:</label>
							    <input required="" name="emp_name" readonly  placeholder="EMP Name" class="form-control"  type='text' value='<?php echo $row['DEPT_NAME'];?>' />
							</div>
						</div>

                        <div class="row mt-3">
						    <div class="col-sm-3">
							    <label for="exampleInputEmail1">PMS Line Manager-1:</label>
							    <input class="form-control" required=""  readonly type='text' value='<?php echo $row['LINE_MANAGER_1_NAME'];?>' />
							</div>
							<div class="col-sm-3">
							    <label for="exampleInputEmail1">PMS Line Manager-2:</label>
							    <input required=""  required="" class="form-control" readonly  type='text' value='<?php echo $row['LINE_MANAGER_2_NAME'];?>' />
							</div>
							<div class="col-sm-3">
							    <label for="exampleInputEmail1">Employee Group:</label>
							    <input required="" readonly  placeholder="EMP Name" class="form-control"  type='text' value='<?php echo $row['EMP_GROUP'];?>' />
							</div>
							<div class="col-sm-3">
							    <label for="exampleInputEmail1">Employee Branch:</label>
							    <input required="" readonly  placeholder="EMP Name" class="form-control"  type='text' value='<?php echo $row['BRANCH_NAME'];?>' />
							</div>
						</div>
                        
						  <?php
						
					    if($v_line_manager_status==""){	
					    ?>
						
						
						 <div class="row mt-3">
						   <div class="col-sm-6">
							    <label class="form-label" for="basic-default-fullname">Remarks</label>
							    <input required="" name="remarks" form="Form1" placeholder="Approval Or Denied Remarks" class="form-control"  type='text'  />
							</div>
							<div class="col-sm-3">

							    <label class="form-label" for="basic-default-fullname">Select Type</label>
							    <select  name="app_status" class="form-control" form="Form1" required="">
								 <option selected value="">---</option>
									  <option value="1">Approve</option>
									  <option value="0">Denied</option>
									  
							    </select> 
							</div>
							
							<div class="col-sm-3">
								<div class="md-form">
								<label class="form-label" for="basic-default-fullname">&nbsp;</label>
								<input class="form-control btn btn-primary" type="submit" form="Form1" value="Submit">
								</div>
						    </div>
							
						</div>
						 <?php
					    }
					    ?>
						

						
						<hr>
						<?php
                      }					
		            ?>	
					
					
				</div>

				
				
						<?php
						

						if(isset($_POST['app_status'])){
						  
						  $v_remarks = $_REQUEST['remarks'];
						  $v_app_status = $_REQUEST['app_status'];
						  
						  
						  if($v_app_status==1){
						  $strSQL  = oci_parse($objConnect, 
						      "update HR_PMS_EMP SET 
							          HR_STATUS_REMARKS='$v_remarks',HR_STATUS=$v_app_status,HR_STATUS_DATE=SYSDATE
                                      WHERE ID=$v_emp_table_id"); 
									
							}
						else if($v_app_status==0){
							$strSQL  = oci_parse($objConnect, 
						      "update HR_PMS_EMP SET 
							          HR_STATUS_REMARKS='$v_remarks',
									  HR_STATUS=$v_app_status,
									  HR_STATUS_DATE=SYSDATE,
									  SELF_SUBMITTED_STATUS='',
									  LINE_MANAGER_1_STATUS='',
									  LINE_MANAGER_2_STATUS=''
                                      WHERE ID=$v_emp_table_id"); 
									  
						}
						
						
						 if(@oci_execute($strSQL)){
							  
							  echo '<div class="alert alert-primary">';
				              echo "Approval Done.";
				              echo '</div>';
							  echo "<script>window.location = 'http://202.40.181.98:9090/rHR/pms_approve_denied_3.php?key=$v_key&emp_id=$v_emp_id&tab_id=$v_emp_table_id'</script>";
							  
						}
						
						}
										
						
						
                           ?>

		 </div>
       </div>
		
		
		
		
		
		
		
		
			<div class="row">
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">

						<thead class="thead-dark">
								<tr>
								  <th class="text-center">Sl <br>No</th>
								  <th scope="col">Key Result Areas<br>KRA</th>
								  <th scope="col">Key Performance indicators<br>KPI</th>
								  <th scope="col">Weightage(%)<br>(Range of 5-30)</th>
								  <th scope="col">Target</th>
								  <th scope="col">Remarks</th>
								</tr>
					   </thead>
					   
					   <tbody>
                        <tr>
						<?php
						  $strSQL  = oci_parse($objConnect, 
						            "select KRA_NAME,ID
							        FROM HR_PMS_KRA_LIST WHERE CREATED_BY='$v_emp_id' AND HR_PMS_LIST_ID='$v_key' ORDER BY ID");								
						  oci_execute($strSQL);
						  $number=0;
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $table_ID   = $row['ID'];
						   $number++;
                           ?>
						   
							  <td class="align-middle"><?php echo $number;?></td>
							  <td class="align-middle"><?php echo $row['KRA_NAME'];?></td>
							  <td class="align-middle">
							     <table width="100%">
								<?php 
								
								 $slNumber   = 0;
							     $strSQLInner  = oci_parse($objConnect, "select KPI_NAME from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID"); 
						         oci_execute($strSQLInner);
							     while($rowIN=oci_fetch_assoc($strSQLInner)){	
								    $slNumber++;
									 ?>
							       <tr>
							         <td height="60px"><?php echo $slNumber.'. '.$rowIN['KPI_NAME'];?></td>
								   </tr>
							    <?php 
							     }
							    ?>
							    </table>
							  </td>
							  
							  <td class="align-middle">
							     <table width="100%">
								<?php 

							     $strSQLInner  = oci_parse($objConnect, "select WEIGHTAGE from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID"); 
						         oci_execute($strSQLInner);
							     while($rowIN=oci_fetch_assoc($strSQLInner)){	
									 ?>
							       <tr>
									 <td height="60px" class="align-middle"><?php echo $rowIN['WEIGHTAGE'];?></td>
								   </tr>
							    <?php 
							     }
							    ?>
							    </table>
							  </td> 
							  
							  <td class="align-middle">
							    <table width="100%">
								<?php 
							     $strSQLInner  = oci_parse($objConnect, "select TARGET from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID"); 
						         oci_execute($strSQLInner);
							     while($rowIN=oci_fetch_assoc($strSQLInner)){	
									 ?>
							       <tr>
							        
									 <td height="60px" class="align-middle"><?php echo $rowIN['TARGET'];?></td>
								   </tr>
							    <?php 
							     }
							    ?>
							    </table>
							  </td> 

                             <td class="align-middle">
							     <table width="100%">
								<?php 
								 $slNumberR   = 0;
							     $strSQLInner  = oci_parse($objConnect, "select REMARKS from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID ORDER BY ID"); 
						         oci_execute($strSQLInner);
							     while($rowIN=oci_fetch_assoc($strSQLInner)){	
								 $slNumberR++;
									 ?>
							       <tr>
							         <td height="60px"><?php echo $slNumberR.'. '.$rowIN['REMARKS'];?></td>
								
								   </tr>
							    <?php 
							     }
							    ?>
							    </table>
							  </td> 
						 </tr>
						 <?php
						  
						  }
						?>
					</tbody>	
				 
		              </table>
					</div>
				  </div>
				</div>
			</div>
	
	   
	   
	   
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	