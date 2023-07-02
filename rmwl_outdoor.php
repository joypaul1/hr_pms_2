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
	
	$v_page='rmwl_outdoor';
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
			<div class="row mt-3">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						    <div class="col-sm-3">
							<label>Enter RML ID:</label>
							<input type="text" class="form-control" id="title" placeholder="EMP-ID" name="emp_concern">
							</div>
							<div class="col-sm-3">
							<label>From Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-3">
							<label>To Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							<div class="col-sm-3">
							<label>Select Approval Status:</label>
							<select  name="approval_status" class="form-control">
								 <option selected value="">Select Approval Status</option>
									  <option value="1">Approved</option>
									  <option value="0">Pending/Denide</option>
							</select>
							  
							</div>
							
						</div>	
						<div class="row mt-3">	
						      <div class="col-sm-3">
							  </div>
							 <div class="col-sm-3">
							  </div>
							   <div class="col-sm-3">
							  </div>
                             <div class="col-sm-3">
							    <input class="form-control btn btn-primary" type="submit" placeholder="Search" value="Search Employee">
							  </div>
								
							
						</div>
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="table-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">Emp ID</th>
								  <th scope="col">User Name</th>
								  <th scope="col">Lat,Lang</th>
								  <th scope="col">Entry Date</th>
								  <th scope="col">Outdoor Remarks</th>
								  <th scope="col">Approval Status</th>
								  <th scope="col">Approval By</th>
								  <th scope="col">Approved Date</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						@$emp_concern = $_REQUEST['emp_concern'];
						@$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						@$approval_status = $_REQUEST['approval_status'];

						if(isset($_POST['start_date'])){
						
						 $strSQL  = oci_parse($objConnect, "select a.RML_ID,
															 a.EMP_NAME,
															 b.ATTN_DATE,
															 b.LAT,b.LANG,
															 b.OUTSIDE_REMARKS,
															 b.EMP_DISTANCE,
															(select EMP_NAME from RML_HR_APPS_USER where RML_ID=b.LINE_MANAGER_ID) LINE_MANAGER_NAME,
															 b.LINE_MANAGER_APPROVAL,
															 b.LINE_MANAGER_APPROVAL_DATE
															 from RML_HR_APPS_USER a,RML_HR_ATTN_DAILY b
															 where A.RML_ID=B.RML_ID
															 and a.R_CONCERN='RMWL'
															 and b.INSIDE_OR_OUTSIDE='Outside Office'
															 and trunc(b.ATTN_DATE) between to_date('$start_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')
															  and ('$emp_concern' is null OR a.RML_ID='$emp_concern')
															  and ('$approval_status' is null OR b.IS_ALL_APPROVED='$approval_status')
															order by ATTN_DATE"); 
					
						  oci_execute($strSQL);
						  $number=0;
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['LAT'].','.$row['LANG'];?></td>
							  <td><?php echo $row['ATTN_DATE'];?></td>
							  <td><?php echo $row['OUTSIDE_REMARKS'];?></td>
							  <td align="center"><?php 
							        if($row['LINE_MANAGER_APPROVAL']=='1'){
								          echo 'Approved';
									 }elseif ($row['LINE_MANAGER_APPROVAL']=='0'){
										echo 'Denide';
									 }else{
										 echo 'Pending';
									 }
								  ?>
							  </td>
							  <td><?php 
							     if($row['LINE_MANAGER_APPROVAL']=='1'){
								          echo $row['LINE_MANAGER_NAME'];
									 }else{
										echo '';
									 }
							  
							  
							  
							  ?></td>
							  <td><?php echo $row['LINE_MANAGER_APPROVAL_DATE'];?></td>
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
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	