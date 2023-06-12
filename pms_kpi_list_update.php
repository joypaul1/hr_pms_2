<?php 
    session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 4)
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
	
	$strSQL  = oci_parse($objConnect, 
			"SELECT 
				KPI_NAME,
				HR_KRA_LIST_ID,
				WEIGHTAGE,
				REMARKS,
				TARGET,
			   (
			    SELECT SELF_SUBMITTED_STATUS 
				 FROM HR_PMS_EMP 
				 WHERE IS_ACTIVE=1 
				       AND EMP_ID='$emp_session_id' 
				       AND HR_PMS_LIST_ID=(SELECT HR_PMS_LIST_ID FROM HR_PMS_KRA_LIST WHERE ID=HR_KRA_LIST_ID)
			    ) SUBMITTED_STATUS											
			FROM HR_PMS_KPI_LIST 
				WHERE ID=$v_key"); 
	oci_execute($strSQL);

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
   <div class="container-fluid">
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   <form action="" method="post">
				    <?php
					while($row=oci_fetch_assoc($strSQL)){	
					$kra_id=$row['HR_KRA_LIST_ID'];
					?>
                    
					<div class="row">
						<div class="col-sm-12">
							<label for="exampleInputEmail1">KPI Name:</label>
							<textarea   class="form-control" rows="2" id="comment" name="kpi_name" ><?php echo $row['KPI_NAME'];?></textarea>
						</div>	
					</div>	
					
				<div class="row mt-3">
					<div class="col-sm-6">
						<label for="exampleInputEmail1">Select KRA Title:</label>
						<select required=""  name="kra_id" class="form-control">
							    <option selected value="">--</option>
							    <?php
								$strSQL  = oci_parse($objConnect, "select ID,KRA_NAME from HR_PMS_KRA_LIST where is_active=1 AND CREATED_BY='$emp_session_id' ORDER BY ID");    
								oci_execute($strSQL);
								 while($row1=oci_fetch_assoc($strSQL)){	
								 if($kra_id==$row1['ID'])
								 {
								 ?><option selected value="<?php echo $row1['ID'];?>"><?php echo $row1['KRA_NAME'];?></option>	
								<?php
								 }else {
								 ?>
								 <option value="<?php echo $row1['ID'];?>"><?php echo $row1['KRA_NAME'];?></option>	
								<?php
								 }
					            }
					            ?>
						</select>
					</div>
					<div class="col-sm-3">
						<label for="exampleInputEmail1">Select Weightage(%):</label>
						<input required="" class="form-control"  type='text'  name="weightage"  value="<?php echo $row['WEIGHTAGE'];?>" />
					</div>	
					<div class="col-sm-3">
						<label for="exampleInputEmail1">Select Target(%):</label>
						<input required="" class="form-control"  type='text'  name="target"  value="<?php echo $row['TARGET'];?>" />
					</div>	
				</div>
				<div class="row">						
					<div class="col-sm-12">
						<div class="md-form mt-3">
							<label for="comment">Remarks:</label>
							<textarea  class="form-control" rows="2" id="comment" name="ramarks" ><?php echo $row['REMARKS'];?></textarea>
						</div>
					</div>
				</div>	
					
					<?php
					if($row['SUBMITTED_STATUS']!='1'){
					?>	
					<div class="row">
					  <div class="col-sm-8"></div>						
						<div class="col-sm-4">
							<div class="md-form mt-3">
								<input class="form-control btn btn-primary" type="submit" value="Update">
							</div>
						</div>
					</div>
					<?php
					}
					}
					?>
						<hr>
					</form>
					
				</div>

				
				
						<?php
						

						if(isset($_POST['kpi_name'])){
						  
						  $v_kpi_name  = $_REQUEST['kpi_name'];
						  $v_kra_id    = $_REQUEST['kra_id'];
						  $v_weightage = $_REQUEST['weightage'];
						  $v_target    = $_REQUEST['target'];
						  $v_ramarks   = $_REQUEST['ramarks'];
						  
						  $strSQL  = oci_parse($objConnect,"UPDATE HR_PMS_KPI_LIST SET 
						                                   KPI_NAME='$v_kpi_name',
						                                   HR_KRA_LIST_ID='$v_kra_id',
						                                   WEIGHTAGE='$v_weightage',
						                                   TARGET='$v_target',
						                                   REMARKS='$v_ramarks',
														   UPDATED_DATE=SYSDATE 
														   WHERE ID='$v_key'"); 
						
						  if(oci_execute($strSQL)){ 
							echo "<script>window.location = 'http://202.40.181.98:9090/rHR/pms_kpi_list.php'</script>";	  
						}
						}
                           ?>

		 </div>
       </div>
	   
    </div>	

</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  