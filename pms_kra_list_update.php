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
	
	$v_page='pms_kra_create';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	$emp_session_id=$_SESSION['HR']['emp_id_hr'];
	$v_key = $_REQUEST['key'];
	
	$strSQL  = oci_parse($objConnect, "select KRA_NAME FROM HR_PMS_KRA_LIST WHERE ID=$v_key"); 
	oci_execute($strSQL);

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
   <div class="container-fluid">
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   <form id="Form1" action="" method="post"></form>
						<div class="row">
						    <div class="col-sm-12">
							    <label for="exampleInputEmail1">KRA Name:</label>
								<?php
								 while($row=oci_fetch_assoc($strSQL)){	
								 ?>
							    <input required="" form="Form1" name="kra_name"  value="<?php echo $row['KRA_NAME'];?>" class="form-control"  type='text'/>
							<?php
								 }
							 ?>
							</div>	
						</div>	
						
						<div class="row">
                          <div class="col-sm-8"></div>						
							<div class="col-sm-4">
								<div class="md-form mt-3">
									<input class="form-control btn btn-primary" form="Form1" type="submit" value="Update">
								</div>
							</div>
						</div>
						<hr>
					</form>
					
				</div>

				
				
						<?php
						

						if(isset($_POST['kra_name'])){
						  
						  $v_kra_name = $_REQUEST['kra_name'];
						  $strSQL  = oci_parse($objConnect,"UPDATE HR_PMS_KRA_LIST SET KRA_NAME='$v_kra_name',UPDATED_DATE=SYSDATE WHERE ID='$v_key'"); 
						
						  if(oci_execute($strSQL)){ 
							echo "<script>window.location = 'http://202.40.181.98:9090/rHR/pms_kra_create.php'</script>";	  
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