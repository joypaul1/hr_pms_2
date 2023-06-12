<?php 
    session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 5)
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
	
	$v_page='leave_list_rmwl';
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
				<div class="col-sm-4">
					<div class="form-group">
					 <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
					  <input  required="" placeholder="Employee ID" name="emp_id" class="form-control"  type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' />
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
	<h5 class="card-header"><b>Leave Taken List</b></h5>
	<div class="card-body">
	  <div class="table-responsive text-nowrap">
		<table class="table table-bordered">
		  <thead class="table-dark">
			<tr>
			  <th>SL</th>
			  <th scope="col">Emp ID</th>
			  <th scope="col">Name</th>
			  <th scope="col">Dept.</th>
			  <th scope="col">Leave Type</th>
			  <th scope="col">To Date</th>
			  <th scope="col">From Date</th>
			  <th scope="col">Entry From</th>
			  <th scope="col">Branch</th>
			  <th scope="col">Approval Status</th>
			</tr>
		  </thead>
		  <tbody>
		    
			<?php
			if(isset($_POST['emp_id'])){
			 
			   $v_emp_id = $_REQUEST['emp_id'];
			  
			   $strSQL  = oci_parse($objConnect, 
			               "SELECT B.RML_ID,
								B.EMP_NAME,
								B.DEPT_NAME,
								B.BRANCH_NAME,
								A.LEAVE_TYPE,
								A.START_DATE,
								A.END_DATE,
								A.ENTRY_FROM,
								A.IS_APPROVED
							FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
							WHERE  A.RML_ID=B.RML_ID
							AND b.R_CONCERN='RMWL'
							AND A.RML_ID='$v_emp_id'
							ORDER BY START_DATE DESC"); 
				oci_execute($strSQL);
				$number=0;	
                while($row=oci_fetch_assoc($strSQL)){	
				$number++;
                 ?>	
                <tr>
			      <td>
				  <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number;?></strong>
			      </td>
			      <td><?php echo $row['RML_ID'];?></td>
				  <td><?php echo $row['EMP_NAME'];?></td>
				  <td><?php echo $row['DEPT_NAME'];?></td>
				  <td><?php echo $row['LEAVE_TYPE'];?></td>
				  <td><?php echo $row['START_DATE'];?></td>
				  <td><?php echo $row['END_DATE'];?></td>
				  <td><?php echo $row['ENTRY_FROM'];?></td>
				  <td><?php echo $row['BRANCH_NAME'];?></td>
				  <td><?php 
							 if($row['IS_APPROVED']=='1'){
								 echo 'Approved';
								}else if($row['IS_APPROVED']=='0'){
									 echo 'Denied';
								}else{
									echo 'Pending';
								}
						
				  ?></td>
			   
			</tr>
 

           <?php
			}
			}
			else{	 
			
			
			$emp_session_id=$_SESSION['HR']['emp_id_hr'];
		    $allDataSQL  = oci_parse($objConnect, 
			            "SELECT B.RML_ID,
								B.EMP_NAME,
								B.DEPT_NAME,
								B.BRANCH_NAME,
								A.LEAVE_TYPE,
								A.START_DATE,
								A.END_DATE,
								A.ENTRY_FROM,
								A.IS_APPROVED
							FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
							WHERE  A.RML_ID=B.RML_ID
							AND b.R_CONCERN='RMWL'
							AND START_DATE BETWEEN to_date((SELECT TO_CHAR(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1),'dd/mm/yyyy') FROM dual),'dd/mm/yyyy') AND to_date(( SELECT TO_CHAR(add_months(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1), 1) -1,'dd/mm/yyyy') FROM dual),'dd/mm/yyyy')
							ORDER BY START_DATE DESC"); 
									
			oci_execute($allDataSQL);
			$number=0;
		    while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
            ?>
			<tr>
			    <td>
				  <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number;?></strong>
			      </td>
			      <td><?php echo $row['RML_ID'];?></td>
				  <td><?php echo $row['EMP_NAME'];?></td>
				  <td><?php echo $row['DEPT_NAME'];?></td>
				  <td><?php echo $row['LEAVE_TYPE'];?></td>
				  <td><?php echo $row['START_DATE'];?></td>
				  <td><?php echo $row['END_DATE'];?></td>
				  <td><?php echo $row['ENTRY_FROM'];?></td>
				  <td><?php echo $row['BRANCH_NAME'];?></td>
				  <td><?php 
							 if($row['IS_APPROVED']=='1'){
								 echo 'Approved';
								}else if($row['IS_APPROVED']=='0'){
									 echo 'Denied';
								}else{
									echo 'Pending';
								}
						
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