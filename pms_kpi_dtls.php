<?php 
	 session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 4 && $_SESSION['HR']['hr_role']!= 3)
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
	
	$v_page='pms_kpi_list';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	$emp_session_id=$_SESSION['HR']['emp_id_hr'];
	$v_key = $_REQUEST['key'];
	
	
	
	
	$strSQL  = oci_parse($objConnect, "SELECT SELF_SUBMITTED_STATUS
											FROM HR_PMS_EMP
											WHERE EMP_ID='$emp_session_id'
											AND HR_PMS_LIST_ID='$v_key'"); 
	oci_execute($strSQL);
	while($row=oci_fetch_assoc($strSQL)){
      $SUBMITTED_STATUS = $row['SELF_SUBMITTED_STATUS'];
	}		
	
?>


  <div class="content-wrapper">
    <div class="container-fluid">
	    <div class="container-fluid">
			<div class="row mt-3">
				
				
				 <?php
				 if($SUBMITTED_STATUS!=1){
				 ?>
				<div class="col-lg-12">
					<form action="" method="post">
					<div class="row">						
						<div class="col-sm-4">
							<label for="exampleInputEmail1">Select KRA:</label>
						    <select required=""  name="kra_id" class="form-control">
							    <option selected value="">--</option>
							    <?php
								$strSQL  = oci_parse($objConnect, "select ID,KRA_NAME from HR_PMS_KRA_LIST where is_active=1 AND HR_PMS_LIST_ID='$v_key' AND CREATED_BY='$emp_session_id' ORDER BY ID");    
								oci_execute($strSQL);
								 while($row=oci_fetch_assoc($strSQL)){	
								 ?><option value="<?php echo $row['ID'];?>"><?php echo $row['KRA_NAME'];?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="row">						
						<div class="col-sm-6">
							<div class="md-form mt-3">
								<label for="comment">KPI Name:</label>
								<textarea required=""  class="form-control" rows="2" id="comment" name="kpi_name"></textarea>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="md-form mt-3">
								<label for="comment">Remarks:</label>
								<textarea  class="form-control" rows="2" id="comment" name="ramarks"></textarea>
							</div>
						</div>
					</div>
					<div class="row  mt-3">
						
						<div class="col-sm-4">
							<label for="exampleInputEmail1">Weightage(%):</label>
                           <input required="" class="form-control"  type='text'  name="weightage"/>
						</div>	
						<div class="col-sm-4">
							<label for="exampleInputEmail1">Target(%):</label>
							<input required="" class="form-control"  type='text'  name="target"/>
						</div>	
					</div>	
					
						
					<div class="row">
                        <div class="col-sm-8"></div>					
						<div class="col-sm-4">
							<div class="md-form mt-3">
								<input class="form-control btn btn-primary" type="submit" value="Submit to Create">
							</div>
						</div>
					</div>
					<hr>
				  </form>	
				</div>
				 <?php
				 }
				 ?>
				
				

				
			<?php
						
            if(isset($_POST['kpi_name'])){
				$v_kpi_name = $_REQUEST['kpi_name'];
			    $v_kra_id = $_REQUEST['kra_id'];
				$v_weightage = $_REQUEST['weightage'];
				$v_target = $_REQUEST['target'];
				$v_ramarks = $_REQUEST['ramarks'];

				$strSQL  = oci_parse($objConnect, 
				       "INSERT INTO HR_PMS_KPI_LIST (
                                       KPI_NAME, 
									   HR_KRA_LIST_ID, 
                                       CREATED_BY, 
									   CREATED_DATE, 
									   IS_ACTIVE,
									   WEIGHTAGE,
									   REMARKS,
									   TARGET) 
                               VALUES ( 
                                       '$v_kpi_name',
                                        $v_kra_id,
                                        '$emp_session_id',
                                        sysdate,
										1,
										$v_weightage,
										'$v_ramarks',
										$v_target
										)"); 
						
						  if(@oci_execute($strSQL)){
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  KPI is created successfully.
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						}else{
							 $lastError = error_get_last();
				             $error=$lastError ? "".$lastError["message"]."":"";
							 if (strpos($error, 'ATTN_DATE_PK') !== false) {
											?>
											 <div class="container-fluid">
											  <div class="md-form mt-5">
												<ol class="breadcrumb">
												<li class="breadcrumb-item">
												  Contact With IT.
												</li>
											   </ol>
											  </div>
											  </div>
											<?php
										 }
						                }
						               }
                           ?>

		 </div>
       </div>
	   
	    <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
					  <!-- <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  -->
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
							        FROM HR_PMS_KRA_LIST WHERE CREATED_BY='$emp_session_id' AND HR_PMS_LIST_ID='$v_key' ORDER BY ID"); 
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
		</div>
	   
	   
	   
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	