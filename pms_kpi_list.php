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

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
   <div class="container-fluid">
	    <div class="container-fluid">
			<div class="row mt-2">
				
				
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
						<thead class="thead-dark">
								<tr>
								  <th class="text-center">Sl</th>
								  <th scope="col">KPI Name</th>
								  <th scope="col">KRA Name</th>
								  <th scope="col">WEIGHTAGE</th>
								  <th scope="col">TARGET</th>
								  <th scope="col">Achievement (%)</th>
								  <th scope="col">Eligibility Factor</th>
								  <th scope="col">Remarks</th>
								  <th scope="col">Status</th>
								  <th scope="col">Action</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
					
						
						  
						  $strSQL  = oci_parse($objConnect, 
						                    "SELECT 
											    B.ID, 
												B.KPI_NAME, 
												(SELECT KRA_NAME FROM HR_PMS_KRA_LIST WHERE ID=HR_KRA_LIST_ID)KRA_NAME, 
												WEIGHTAGE, 
												TARGET,ELIGIBILITY_FACTOR, 
												REMARKS, 
												CREATED_BY, 
												CREATED_DATE, 
												IS_ACTIVE,ACHIVEMENT, 
												ACHIEVEMENT_LOCK_STATUS
											FROM HR_PMS_KPI_LIST B
											WHERE CREATED_BY='$emp_session_id'"); 
						  oci_execute($strSQL);
						  $number=0;
							
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td class="text-center"><?php echo $number;?></td>
							  <td><?php echo $row['KPI_NAME'];?></td>
							  <td><?php echo $row['KRA_NAME'];?></td>
							  <td><?php echo $row['WEIGHTAGE'];?></td>
							  <td><?php echo $row['TARGET'];?></td>
							  <td><?php echo $row['ACHIVEMENT'];?></td>
							  <td><?php echo $row['ELIGIBILITY_FACTOR'];?></td>
							  <td><?php echo $row['REMARKS'];?></td>
							  <td>
							      <?php 
								  if($row['IS_ACTIVE']=='1')
								     echo 'Active';
							      else 
								     echo 'In-Active';
								  ?>
							  </td>
							   <td>
								<input form="Form2" name="table_id" class="form-control"  type='text' value='<?php echo $row['ID'];?>' style="display:none"/>
								<a class="btn btn-warning btn-sm" href="pms_kpi_list_update.php?key=<?php echo $row['ID'];?>">Update</a>
								
								<?php 
								  if($row['ACHIEVEMENT_LOCK_STATUS']=='1'){
									   ?>
								<input form="Form2" name="table_id" class="form-control"  type='text' value='<?php echo $row['ID'];?>' style="display:none"/>
								<a class="btn btn-warning btn-sm" href="pms_kpi_list_update.php?key=<?php echo $row['ID'];?>">Achivement</a>
								  <?php 
								  } 
								  ?>
							   </td>
							 
						 </tr>
						 <?php
						  
						  }
						?>
					</tbody>	
				 
		              </table>
					</div>
				  </div>
				  
				   <?php
				if(isset($_POST['submit_approval'])){
					$table_id = $_REQUEST['table_id'];
					$kra_name = $_REQUEST['kra_name'];
                    
					$updateSQL  = oci_parse($objConnect, 
						            "UPDATE HR_PMS_KRA_LIST SET KRA_NAME='$kra_name',UPDATED_DATE=SYSDATE WHERE ID='$table_id'"); 
			 						
					if(oci_execute($updateSQL)){
						echo "<script>window.location = 'http://202.40.181.98:9090/rHR/pms_kra_create.php'</script>";
					}
					
                    }	
				
				?>
				  
				  
				  
				  
				</div>
			</div>
		</div>
	   
    </div>	

</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  