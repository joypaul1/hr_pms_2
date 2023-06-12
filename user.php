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
	
	$v_page='user';
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
			    <div class="col-sm-3">
			     <label for="title">RML-ID</label>
				 <input type="text" class="form-control" id="title" placeholder="EMP-ID" name="emp_rml_id">
				</div>
			</div>
			
			<div class="row mt-2">
			    <div class="col-sm-3">
				    <label for="title">Select Company</label>
					<select name="r_concern" class="form-control">
					<option selected value="">--</option>
				    <?php
					$strSQL  = oci_parse($objConnect, "select distinct(R_CONCERN) R_CONCERN from RML_HR_APPS_USER 
														where R_CONCERN is not null  and is_active=1 
														order by R_CONCERN"); 
					oci_execute($strSQL);
				    while($row=oci_fetch_assoc($strSQL)){	
				    ?>
				    <option value="<?php echo $row['R_CONCERN'];?>" <?php echo (isset($_POST['r_concern']) && $_POST['r_concern'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>><?php echo $row['R_CONCERN'];?></option>
				    <?php
				    }
				    ?>
					</select>
				</div>
				<div class="col-sm-3">
					<label for="title">Select Department</label>
					<select name="emp_dept" class="form-control">  
					<option selected value="">--</option>
						<?php
						$strSQL  = oci_parse($objConnect, 
						         "select distinct(DEPT_NAME) DEPT_NAME FROM RML_HR_DEPARTMENT 
										where DEPT_NAME is not null and is_active=1 
											order by DEPT_NAME"); 
						oci_execute($strSQL);
						while($row=oci_fetch_assoc($strSQL)){	
					    ?>
					    <option value="<?php echo $row['DEPT_NAME'];?>" <?php echo (isset($_POST['emp_dept']) && $_POST['emp_dept'] == $row['DEPT_NAME']) ? 'selected="selected"' : ''; ?>><?php echo $row['DEPT_NAME'];?></option>
					    <?php
					    }
					    ?>
					</select>
							  
				</div>
				<div class="col-sm-3">
				    <label for="title">Select Group</label>
					<select name="emp_group" class="form-control">
						<option selected value="">--</option>
						<?php					   
						$strSQL  = oci_parse($objConnect, 
								"select distinct(EMP_GROUP) EMP_GROUP from RML_HR_APPS_USER 
									where EMP_GROUP is not null  and is_active=1 
									order by EMP_GROUP"); 
						oci_execute($strSQL);
						while($row=oci_fetch_assoc($strSQL)){	
						?>
						<option value="<?php echo $row['EMP_GROUP'];?>" <?php echo (isset($_POST['emp_group']) && $_POST['emp_group'] == $row['EMP_GROUP']) ? 'selected="selected"' : ''; ?>><?php echo $row['EMP_GROUP'];?></option>
						<?php
						}
						?>
					</select>
				</div>
							
				<div class="col-sm-3">
					<div class="form-group">
					  <label for="title"> <br></label>
					  <input class="form-control btn btn-primary" type="submit" value="Search Data">
					</div>
				</div>
							
			</div>				
		</form>
		</div>
		</br>		
				
				
				
				

  <!-- Bordered Table -->
  <div class="card">
	<h5 class="card-header"><b>Apps User List</b></h5>
	<div class="card-body">
	  <div class="table-responsive text-nowrap">
		<table class="table table-bordered">
		  <thead class="table-dark">
			<tr>
			  <th>SL</th>
			  <th>User ID</th>
			  <th>User Name</th>
			  <th>Designation</th>
			  <th>Department</th>
			  <th>Branch</th>
			  <th>Mobile Number</th>
			  <th>Incrg-1</th>
			  <th>Incrg-2</th>
			  <th>Actions</th>
			</tr>
		  </thead>
		  <tbody>
		    
			<?php
			if(isset($_POST['r_concern'])){
			   $v_emp_id = $_REQUEST['emp_rml_id'];
			   $emp_group = $_REQUEST['emp_group'];
			   $r_concern = $_REQUEST['r_concern'];
			   $emp_dept = $_REQUEST['emp_dept'];
			   $strSQL  = oci_parse($objConnect, "select  RML_ID,EMP_GROUP,
																 EMP_NAME,
																 MOBILE_NO,
																 COLL_HR_EMP_NAME(LINE_MANAGER_RML_ID) LINE_MANAGER_RML_ID,
																 COLL_HR_EMP_NAME(DEPT_HEAD_RML_ID) DEPT_HEAD_RML_ID,
																 DEPT_NAME,
																 BRANCH_NAME,
																 DESIGNATION
														from RML_HR_APPS_USER
														where ('$emp_group' is null OR EMP_GROUP='$emp_group')
														 and ('$v_emp_id' is null OR RML_ID='$v_emp_id')
														 and ('$r_concern' is null OR R_CONCERN='$r_concern')
														 and ('$emp_dept' is null OR DEPT_NAME='$emp_dept')
														 "); 
				oci_execute($strSQL);
				$number=0;	
                while($row=oci_fetch_assoc($strSQL)){	
				$number++;
				$password="p";
                $encrypted_rml_id=openssl_encrypt($row['RML_ID'],"AES-128-ECB",$password);  
                 ?>	
                <tr>
			      <td>
				  <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number;?></strong>
			    </td>
			    <td><?php echo $row['RML_ID'];?></td>
			    <td><?php echo $row['EMP_NAME'];?></td>
			    <td><?php echo $row['DESIGNATION'];?></td>
			    <td><?php echo $row['DEPT_NAME'];?></td>
			    <td><?php echo $row['BRANCH_NAME'];?></td>
			    <td><?php echo $row['MOBILE_NO'];?></td>
			    <td><?php echo $row['LINE_MANAGER_RML_ID'];?></td>
			    <td><?php echo $row['DEPT_HEAD_RML_ID'];?></td>
			    <td>
				<div class="dropdown">
				  <button
					type="button"
					class="btn p-0 dropdown-toggle hide-arrow"
					data-bs-toggle="dropdown">
					<i class="bx bx-dots-vertical-rounded"></i>
				  </button>
				  <div class="dropdown-menu">
					<a class="dropdown-item" href="user_profile.php?emp_id=<?php echo $row['RML_ID']; ?>"
					  ><i class="bx bx-edit-alt me-1"></i> Edit</a
					>
					
				  </div>
				</div>
			  </td>
			</tr>
 

           <?php
			}
			}
			else{	 
			
			
			$emp_session_id=$_SESSION['HR']['emp_id_hr'];
		    $allDataSQL  = oci_parse($objConnect, 
			            "SELECT  
							RML_ID,
							EMP_NAME,
							MOBILE_NO,
							COLL_HR_EMP_NAME(LINE_MANAGER_RML_ID) LINE_MANAGER_RML_ID,
							COLL_HR_EMP_NAME(DEPT_HEAD_RML_ID) DEPT_HEAD_RML_ID,
							DEPT_NAME,
							BRANCH_NAME,
							DESIGNATION
							from RML_HR_APPS_USER
						where DEPT_NAME =(select a.DEPT_NAME from RML_HR_APPS_USER a where a.RML_ID='$emp_session_id')
								AND IS_ACTIVE=1"); 
									
						  oci_execute($allDataSQL);
						  $number=0;
		    while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
						   
				$password="";
                $encrypted_rml_id=openssl_encrypt($row['RML_ID'],"AES-128-ECB",$password);  		   
						   
            ?>
		  
		    
			<tr>
			  <td>
				<i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number;?></strong>
			  </td>
			  <td><?php echo $row['RML_ID'];?></td>
			  <td><?php echo $row['EMP_NAME'];?></td>
			  <td><?php echo $row['DESIGNATION'];?></td>
			  <td><?php echo $row['DEPT_NAME'];?></td>
			  <td><?php echo $row['BRANCH_NAME'];?></td>
			  <td><?php echo $row['MOBILE_NO'];?></td>
			  <td><?php echo $row['LINE_MANAGER_RML_ID'];?></td>
			  <td><?php echo $row['DEPT_HEAD_RML_ID'];?></td>
			  <td>
				<div class="dropdown">
				  <button
					type="button"
					class="btn p-0 dropdown-toggle hide-arrow"
					data-bs-toggle="dropdown"
				  >
					<i class="bx bx-dots-vertical-rounded"></i>
				  </button>
				  <div class="dropdown-menu">
					<a class="dropdown-item" href="user_profile.php?emp_id=<?php echo $encrypted_rml_id; ?>"
					  ><i class="bx bx-edit-alt me-1"></i> Edit</a
					>
					
				  </div>
				</div>
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
  <!--/ Bordered Table -->

  

</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  