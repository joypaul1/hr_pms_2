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
	
	$v_page='pmp_hr';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	$emp_session_id=$_SESSION['HR']['emp_id_hr'];

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="col-lg-12">
		<form action="" method="post">
		<div class="row">
			<div class="col-sm-12">
				<label for="exampleInputEmail1">PMS Name:</label>
				<input required="" name="pms_name"  placeholder="Enter PMS Name" class="form-control"  type='text'/>
			</div>
		</div>	
						
		<div class="row">						
			<div class="col-sm-12">
				<div class="md-form mt-3">
					<input class="btn btn-primary btn pull-right" type="submit" value="Submit to Create">
				</div>
			</div>
		</div>
		</form>		
	</div>
	</br>
    <?php
	if(isset($_POST['pms_name'])){				  
		$v_pms_name = $_REQUEST['pms_name'];
        $strSQL  = oci_parse($objConnect, 
		        "INSERT INTO HR_PMS_LIST (
					   PMS_NAME, 
					   CREATED_BY, 
					   CREATED_DATE, 
					   IS_ACTIVE, 
					   BG_COLOR) 
					VALUES ( 
					 '$v_pms_name',
					 '$emp_session_id',
					 SYSDATE,
					 1,
					 'card bg-success text-white mb-4' )"); 
	    if(@oci_execute($strSQL)){
            echo '';
	    }
	}	
    ?>	





	
				
		

  <!-- Bordered Table -->
  <div class="card">
	<h5 class="card-header"><b>PMS List</b></h5>
	<div class="card-body">
	  <div class="table-responsive text-nowrap">
		<table class="table table-bordered">
		  <thead class="table-dark">
			<tr>
			  <th scope="col">Sl</th>
			  <th scope="col">PMS Name</th>
			  <th scope="col">Created Date</th>
			  <th scope="col">Created By</th>
			  <th scope="col">Closed Date</th>
			  <th scope="col">Closed By</th>
			  <th scope="col">Status</th>
			</tr>
		  </thead>
		  <tbody>
		    
			<?php
			
			
		    $allDataSQL  = oci_parse($objConnect, 
			            "SELECT 
						  ID, 
						  PMS_NAME, 
						  CREATED_BY, 
						  CREATED_DATE, 
						  IS_ACTIVE, 
						  CLOSED_DATE,
						  CLOSED_BY
					FROM HR_PMS_LIST"); 
									
			oci_execute($allDataSQL);
			$number=0;
		    while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
            ?>
			<tr>
			    <td>
				<i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number;?></strong>
			    </td>
			    <td><?php echo $row['PMS_NAME'];?></td>
				<td><?php echo $row['CREATED_DATE'];?></td>
				<td><?php echo $row['CREATED_BY'];?></td>
				<td><?php echo $row['CLOSED_DATE'];?></td>
				<td><?php echo $row['CLOSED_BY'];?></td>
				<td><?php 
					if($row['IS_ACTIVE']==1)
						echo 'Active';
					else 
					    echo 'In-Active';	 
					?></td>
			 
			</tr>
			<?php
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