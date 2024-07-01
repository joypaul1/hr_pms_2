<?php 
   
	session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 1 && $_SESSION['HR']['hr_role']!= 2)
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
	
	$v_page='';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
    $emp_session_id=$_SESSION['HR']['emp_id_hr'];	
	
    $emp_id=htmlentities($_REQUEST['emp_id']);
    
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
    <form id="Form1" action="" method="post"></form>
	<form id="Form2" action="" method="post"></form>
        <?php
		 $strSQL  = oci_parse($objConnect, 
		            "select RML_ID,
							EMP_NAME,
							MOBILE_NO,
							DEPT_NAME,
							IEMI_NO,
							LINE_MANAGER_RML_ID,
							DEPT_HEAD_RML_ID,
							BRANCH_NAME,
							DESIGNATION,
							BLOOD,
							MAIL,
							DOJ,
							DOC,
							GENDER,
							R_CONCERN,
							ATTN_RANGE_M,
							USER_CREATE_DATE,
							USER_ROLE,
							LAT,LAT_2,LAT_3,LAT_4,LAT_5,LAT_6,
							LANG,LANG_2,LANG_3,LANG_4,LANG_5,LANG_6,
							TRACE_LOCATION
					 from RML_HR_APPS_USER 
						  where RML_ID='$emp_id'"); 
						  
						  oci_execute($strSQL);


		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
								<div class="md-form">
							
								 <div class="resume-item d-flex flex-column flex-md-row">
						   
						   
							<div class="container">
							
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Emp ID:</label>
												  <input type="text"class="form-control" id="title" form="Form2" name="form_rml_id" value= "<?php echo $row['RML_ID'];?>" readonly>
												</div>
											</div>
										
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Name:</label>
												  <input type="text" name="emp_form_name" class="form-control" id="title"  value= "<?php echo $row['EMP_NAME'];?>" form="Form2">
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Mobile:</label>
												  <input type="text" name="emp_mobile" class="form-control" id="title" value= "<?php echo $row['MOBILE_NO'];?>" form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Department:</label>
												  <input type="text" name="emp_dept" class="form-control" id="title" value= "<?php echo $row['DEPT_NAME'];?>" form="Form2">
												</div>
											</div>
										</div>
										
										<div class="row mt-2">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Responsible-1 ID:</label>
												  <input type="text" class="form-control" id="title" name="form_res1_id" value= "<?php echo $row['LINE_MANAGER_RML_ID'];?>" form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Responsible-2 ID:</label>
												  <input type="text" class="form-control" id="title" name="form_res2_id" value= "<?php echo $row['DEPT_HEAD_RML_ID'];?>" form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">IEMI_NO:</label>
												  <input type="text" class="form-control" id="title" name="form_iemi_no" value= "<?php echo $row['IEMI_NO'];?>"  form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Mail:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['MAIL'];?>" readonly>
												</div>
											</div>
											
										</div>
										
										<div class="row mt-2">
											
										
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Designation:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['DESIGNATION'];?>" readonly>
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">DOJ:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['DOJ'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">DOC:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['DOC'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Joning Date:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['DOJ'];?>" readonly>
												</div>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Brance Name:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['BRANCH_NAME'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Emp Concern:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['R_CONCERN'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Apps Attn Range(Meter):</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['ATTN_RANGE_M']?>" readonly>
												</div>
											</div>
											 <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">User Role:</label>
												  <select required="" name="emp_role" class="form-control" form="Form2">
															  <?php
															    
																       if($row['USER_ROLE']=='NU'){
																	  ?> 
																	    <option value="NU">Normal User</option>
													                    <option value="LM">Line Manager</option>
																	  
																	  <?php
															           }else{
																		   ?> 
																		     <option value="LM">Line Manager</option>
													                         <option value="NU">Normal User</option>
																		   <?php
																	   }
															          
															  ?>
														</select>
												 
												</div>
											</div>
										</div>
										
										
										<div class="row mt-2">
										    <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Employee Status:</label>
												 <select  name="emp_status" class="form-control" form="Form2">
													  <option value="1">Active</option>
													  <option value="0">In-Active</option>
													  </select>
												 
												</div>
											 </div>
											
											
                                            <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Location Traceable Status:</label>
												  <select required="" name="traceable_status" class="form-control" form="Form2">
															  <?php
															    
																       if($row['TRACE_LOCATION']=='1'){
																	  ?> 
																	    <option value="1">Active</option>
													                    <option value="0">In-Active</option>
																	  
																	  <?php
															           }else{
																		   ?> 
																		     <option value="0">In-Active</option>
																		     <option value="1">Active</option>
													                    
																		   <?php
																	   }
															          
															  ?>
														</select>
												 
												</div>
											</div>	
                                            <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Primary Lat:</label>
												  <input type="text" class="form-control" name="lat" id="title" value= "<?php echo $row['LAT'];?>" form="Form2" >
												</div>
											</div>											
										    <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Primary Lang:</label>
												  <input type="text" class="form-control" name="lang" id="title" value= "<?php echo $row['LANG'];?>" form="Form2">
												</div>
											</div>	
										</div>
										<div class="row mt-2">
										   <div class="col-sm-3"></div>	
										   <div class="col-sm-3"></div>	
										  <div class="col-sm-3">
											<div class="form-group">
												  <label for="title">Lat-2:</label>
												  <input type="text" class="form-control" name="lat_2" id="title" value= "<?php echo $row['LAT_2'];?>" form="Form2" >
												</div>
											</div>											
										    <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lang-2:</label>
												  <input type="text" class="form-control" name="lang_2" id="title" value= "<?php echo $row['LANG_2'];?>" form="Form2">
												</div>
											</div>	
                                           											
										</div>
										<div class="row mt-2">
										   <div class="col-sm-3"></div>	
										   <div class="col-sm-3"></div>	
                                            <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lat-3:</label>
												  <input type="text" class="form-control" name="lat_3" id="title" value= "<?php echo $row['LAT_3'];?>" form="Form2" >
												</div>
											</div>											
										    <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lang-3:</label>
												  <input type="text" class="form-control" name="lang_3" id="title" value= "<?php echo $row['LANG_3'];?>" form="Form2">
												</div>
											</div>												
										</div>
										<div class="row mt-2">
										   <div class="col-sm-3"></div>	
										   <div class="col-sm-3"></div>	
										   <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lat-4:</label>
												  <input type="text" class="form-control" name="lat_4" id="title" value= "<?php echo $row['LAT_4'];?>" form="Form2" >
												</div>
											</div>											
										    <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lang-4:</label>
												  <input type="text" class="form-control" name="lang_4" id="title" value= "<?php echo $row['LANG_4'];?>" form="Form2">
												</div>
											</div>	
                                           											
										</div>
										<div class="row mt-2">
										   <div class="col-sm-3"></div>	
										   <div class="col-sm-3"></div>	
                                            <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lat-5:</label>
												  <input type="text" class="form-control" name="lat_5" id="title" value= "<?php echo $row['LAT_5'];?>" form="Form2" >
												</div>
											</div>											
										    <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lang-5:</label>
												  <input type="text" class="form-control" name="lang_5" id="title" value= "<?php echo $row['LANG_5'];?>" form="Form2">
												</div>
											</div>												
										</div>
										<div class="row mt-2">
										   <div class="col-sm-3"></div>	
										   <div class="col-sm-3"></div>	
                                            <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lat-6:</label>
												  <input type="text" class="form-control" name="lat_6" id="title" value= "<?php echo $row['LAT_6'];?>" form="Form2" >
												</div>
											</div>											
										    <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Lang-6:</label>
												  <input type="text" class="form-control" name="lang_6" id="title" value= "<?php echo $row['LANG_6'];?>" form="Form2">
												</div>
											</div>												
										</div>
										<div class="row mt-3">
										   <div class="col-sm-9"></div>	
										   <div class="col-sm-3">
										   <button type="submit" name="submit" class="form-control btn btn-primary" form="Form2">Submit Update</button>
										   </div>	
											
										</div>
									</div>
								</div>
						
							</div>

						 <?php
						  }
						 ?>
						 
					
					
					</div>
					
				  </div>
			
				</div>
				  
			
		
	
	              <?php

                          
						 
						  if(isset($_POST['form_iemi_no'])){
							  
							$v_emp_primary_lat = $_REQUEST['lat'];
						    $v_emp_primary_lang = $_REQUEST['lang'];
							
							$v_emp_primary_lat_2 = $_REQUEST['lat_2'];
						    $v_emp_primary_lang_2 = $_REQUEST['lang_2'];
							$v_emp_primary_lat_3 = $_REQUEST['lat_3'];
						    $v_emp_primary_lang_3 = $_REQUEST['lang_3']; 
							$v_emp_primary_lat_4 = $_REQUEST['lat_4'];
						    $v_emp_primary_lang_4 = $_REQUEST['lang_4'];
							$v_emp_primary_lat_5 = $_REQUEST['lat_5'];
						    $v_emp_primary_lang_5 = $_REQUEST['lang_5'];
							$v_emp_primary_lat_6 = $_REQUEST['lat_6'];
						    $v_emp_primary_lang_6 = $_REQUEST['lang_6'];
							
							$form_rml_id = $_REQUEST['form_rml_id'];
                            $emp_form_name = $_REQUEST['emp_form_name'];
                            $emp_mobile = $_REQUEST['emp_mobile'];
                            $emp_dept = $_REQUEST['emp_dept'];
						  
						  
						    $form_iemi_no = $_REQUEST['form_iemi_no'];
						    $form_res1_id = $_REQUEST['form_res1_id'];
						    $form_res2_id = $_REQUEST['form_res2_id'];
						    $emp_role = $_REQUEST['emp_role'];
						    $form_emp_status = $_REQUEST['emp_status'];
						    $traceable_status = $_REQUEST['traceable_status'];
							  
							  
							   
							   $strSQL  = oci_parse($objConnect, "update RML_HR_APPS_USER SET
							            EMP_NAME='$emp_form_name',
                                        MOBILE_NO='$emp_mobile',
										DEPT_NAME='$emp_dept',									
										IEMI_NO='$form_iemi_no',
										LINE_MANAGER_RML_ID='$form_res1_id',
										DEPT_HEAD_RML_ID='$form_res2_id',
										IS_ACTIVE='$form_emp_status',
										USER_ROLE='$emp_role',
										LAT='$v_emp_primary_lat',
										LAT_2='$v_emp_primary_lat_2',
										LAT_3='$v_emp_primary_lat_3',
										LAT_4='$v_emp_primary_lat_4',
										LAT_5='$v_emp_primary_lat_5',
										LAT_6='$v_emp_primary_lat_6',
										LANG='$v_emp_primary_lang',
										LANG_2='$v_emp_primary_lang_2',
										LANG_3='$v_emp_primary_lang_3',
										LANG_4='$v_emp_primary_lang_4',
										LANG_5='$v_emp_primary_lang_5',
										LANG_6='$v_emp_primary_lang_6',
										TRACE_LOCATION='$traceable_status'
								where RML_ID='$form_rml_id'"); 
						 
						   if(oci_execute($strSQL)){
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Information is updated successfully.
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						   } 
						  }
						?>
		 </div>
       </div>
    

</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  