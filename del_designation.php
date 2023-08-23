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
	
	$v_page='designation';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="col-lg-12">
		<form action="" method="post">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
					 <label class="form-label" for="basic-default-fullname">Designation Name</label>
					  <input  required="" placeholder="Designation Name" name="department_name" class="form-control"  type='text' value='<?php echo isset($_POST['department_name']) ? $_POST['department_name'] : ''; ?>' />
					  </div>
				</div>
				 
				<div class="col-sm-4">
					<div class="form-group">
					   <label class="form-label" for="basic-default-fullname">&nbsp;</label>
					  <input class="form-control btn btn-primary" type="submit" value="Search Data">
					</div>
				</div>
			</div>	
		</form>
	</div>
	</br>		
				
		

  <!-- Bordered Table -->
  <div class="card">
	<h5 class="card-header"><b>Apps Designation Name</b></h5>
	<div class="card-body">
	  <div class="table-responsive text-nowrap">
		<table class="table table-bordered">
		  <thead class="table-dark">
			<tr>
			  <th>SL</th>
			  <th>Designation Name</th>
			  <th>Creator ID</th>
			  <th>Create Date</th>
			  <th>Status</th>
			</tr>
		  </thead>
		  <tbody>
		    
			<?php
			if(isset($_POST['department_name'])){
			 
			   $department_name = $_REQUEST['department_name'];
			  
			   $strSQL  = oci_parse($objConnect, "SELECT 
                          ID, DESIGNATION_NAME, CREATED_BY, 
                          CREATED_DATE, IS_ACTIVE
                           FROM RML_HR_DESIGNATION where DESIGNATION_NAME like '%$department_name%'"); 
				oci_execute($strSQL);
				$number=0;	
                while($row=oci_fetch_assoc($strSQL)){	
				$number++;
                 ?>	
                <tr>
			      <td>
				  <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number;?></strong>
			    </td>
			    <td><?php echo $row['DESIGNATION_NAME'];?></td>
				<td><?php echo $row['CREATED_BY'];?></td>
				<td><?php echo $row['CREATED_DATE'];?></td>
				<td><?php 
				    if($row['IS_ACTIVE']==1)
					    echo 'Active';
					else 
					    echo 'In-Active';	 
				    ?>
				</td>
			    <td>
				
			  </td>
			</tr>
 

           <?php
			}
			}
			else{	 
			
			
			$emp_session_id=$_SESSION['HR']['emp_id_hr'];
		    $allDataSQL  = oci_parse($objConnect, 
			            "SELECT 
                          ID, DESIGNATION_NAME, CREATED_BY, 
                          CREATED_DATE, IS_ACTIVE
                           FROM RML_HR_DESIGNATION"); 
									
			oci_execute($allDataSQL);
			$number=0;
		    while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
            ?>
			<tr>
			    <td>
				<i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number;?></strong>
			    </td>
			    <td><?php echo $row['DESIGNATION_NAME'];?></td>
				<td><?php echo $row['CREATED_BY'];?></td>
				<td><?php echo $row['CREATED_DATE'];?></td>
				<td><?php 
					if($row['IS_ACTIVE']==1)
						echo 'Active';
					else 
					    echo 'In-Active';	 
					?></td>
			 
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
  <!--/ Bordered Table -->

  

</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  