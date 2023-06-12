<?php 
    session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 5)
	{
		header('location:index.php?lmsg_hr=true');
		exit;
	} 

		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	
	$v_page='user_list_rmwl';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	
   $emp_session_id=$_SESSION['HR']['emp_id_hr'];
?>

  <div class="content-wrapper">
    <div class="container-fluid">

	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
					
						<div class="row mt-3">
						    <div class="col-sm-4">
							    <label for="title">Select Branch</label>
								<select class="form-control" name="branch_name">
									 <option selected value="">--</option>
										   <?php
											$strSQL  = oci_parse($objConnect, "select distinct(BRANCH_NAME) AS BRANCH_NAME from RML_HR_APPS_USER
																			where R_CONCERN='RMWL'
																			order by BRANCH_NAME"); 
											oci_execute($strSQL);
										   while($row=oci_fetch_assoc($strSQL)){	
										  ?>
		                                  <option value="<?php echo $row['BRANCH_NAME'];?>" <?php echo (isset($_POST['branch_name']) && $_POST['branch_name'] == $row['BRANCH_NAME']) ? 'selected="selected"' : ''; ?>><?php echo $row['BRANCH_NAME'];?></option>
										  <?php
										   }
										  ?>
								</select>
							</div>
						    <div class="col-sm-4">
								<label for="title">Select Status</label>
								<select required=""  name="emp_status" class="form-control">
									<option selected value="">--</option>
								    <option value="1">Active</option>
								    <option value="0">In-Active</option>
								</select>
							  
							</div>
							<div class="col-sm-4">
							    <label for="title">&nbsp;</label>
								<div class="md-form">
									<input class="form-control btn btn-primary" type="submit" value="Search Attendance"> 
								</div>
							</div>
						</div>
						
				</div>	
				</form>
			</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">  
					   <table class="table table-bordered piechart-key" id="table" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">ID</th>
								  <th scope="col">Name</th>
								  <th scope="col">Mobile</th>
								  <th scope="col">Designation</th>
								  <th scope="col">Department</th>
								  <th scope="col">Branch</th>
								  <th scope="col">Incrg-1</th>
								  <th scope="col">Incrg-2</th>
								  
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
					

			if(isset($_POST['emp_status'])){
				$branch_name = $_REQUEST['branch_name'];
				$emp_status = $_REQUEST['emp_status'];
				$strSQL  = oci_parse($objConnect, "select  RML_ID,
																 EMP_NAME,
																 MOBILE_NO,
																 COLL_HR_EMP_NAME(LINE_MANAGER_RML_ID) LINE_MANAGER_RML_ID,
																 COLL_HR_EMP_NAME(DEPT_HEAD_RML_ID) DEPT_HEAD_RML_ID,
																 DEPT_NAME,
																 BRANCH_NAME,
																 DESIGNATION
														from RML_HR_APPS_USER
														where R_CONCERN='RMWL'
														and IS_ACTIVE='$emp_status'
														and ('$branch_name' is null OR BRANCH_NAME='$branch_name')
														order by BRANCH_NAME"); 

						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td>
								  <a target="_blank" href="user_edit_rmwl.php?emp_id=<?php echo $row['RML_ID'] ?>"><?php echo $row['RML_ID'] ?></a>
							  </td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['MOBILE_NO'];?></td>
							  <td><?php echo $row['DESIGNATION'];?></td>
							  <td><?php echo $row['DEPT_NAME'];?></td>
							  <td><?php echo $row['BRANCH_NAME'];?></td>
							  <td><?php echo $row['LINE_MANAGER_RML_ID'];?></td>
							  <td><?php echo $row['DEPT_HEAD_RML_ID'];?></td>
						 </tr>
						 <?php
						  
						  }
						  }
						
						?>
					</tbody>	
				 
		              </table>
					</div>
					<div>
					<a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export to excel</a>
					</div>
				  </div>
				</div>
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	<script>
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Manpower Information RMWL.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	