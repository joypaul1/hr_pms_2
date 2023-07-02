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
	
	$v_page='attendance_report_rmwl';
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
							    <label for="title">Select Branch</label>
								<select  required=""  class="form-control" name="branch_name">
									 <option selected value="">--</option>
									 <option value="All">All</option>
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
						     <div class="col-sm-3">
							    <label for="title">Select Start Date</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							<div class="col-sm-3">
							    <label for="title">Select End Date</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
							   </div>
							</div>	
							<div class="col-sm-3">
							    <label for="title">Select Attendance Status:</label>
								<select name="attn_type" class="form-control">
								  <option  value="">--</option>
								  <option value="P">Present</option>
								  <option value="L">Late</option>
								  <option value="A">Absent</option>
								  <option value="SL">Sick Leave</option>
								  <option value="CL">Casual Leave</option>
								  <option value="EL">Earned/Annual Leave</option>
								  <option value="ML">Maternity Leave</option>
								  <option value="PL">Paternity Leave</option>
								  </select>
								</select>
							  
							</div>
						</div>
						<div class="row mt-3">
						     <div class="col-sm-9"></div>
						  	 <div class="col-sm-3">
							 <input class="form-control btn btn-primary" type="submit" value="Search Attendance"> 
							 </div>
						</div>
			</div>	
		
		
					</form>
				</div>
				
				<div class="col-lg-12 md-form mt-4">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">  
					   <table class="table table-bordered piechart-key" id="table" style="width:100%">  
						<thead class="table-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">Emp ID</th>
								  <th scope="col">User Name</th>
								  <th scope="col">Date</th>
								  <th scope="col">IN Time</th>
								  <th scope="col">OUT Time</th>
								  <th scope="col">Status</th>
								  <th scope="col">Branch Name</th>
								  <th scope="col">Dept. Name</th>
								  
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						

			if(isset($_POST['attn_type'])){
				// $emp_sesssion_id=$_SESSION['emp_id'];
				$emp_session_id = $_SESSION['HR']['emp_id_hr'];
				$branch_name = $_REQUEST['branch_name'];
				$attn_type = $_REQUEST['attn_type'];
				$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                $attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						
				
				
				if($branch_name=="All"){
				             $strSQL  = oci_parse($objConnect, "select RML_ID,ATTN_DATE,RML_NAME,IN_TIME,OUT_TIME,STATUS,DEPT_NAME,IN_LAT,IN_LANG,DAY_NAME,BRANCH_NAME
													 from RML_HR_ATTN_DAILY_PROC
													 where R_CONCERN='RMWL'
													 and trunc(ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
													 and ('$attn_type' is null OR STATUS='$attn_type')
													order by ATTN_DATE"); 
							}else{
							 $strSQL  = oci_parse($objConnect, "select RML_ID,ATTN_DATE,RML_NAME,IN_TIME,OUT_TIME,STATUS,DEPT_NAME,IN_LAT,IN_LANG,DAY_NAME,BRANCH_NAME
													 from RML_HR_ATTN_DAILY_PROC
													 where R_CONCERN='RMWL'
													 and BRANCH_NAME='$branch_name'
													 and trunc(ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
													 and ('$attn_type' is null OR STATUS='$attn_type')
													order by ATTN_DATE"); 	
							}
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							 <td><?php echo $number;?></td>
							  <td><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['RML_NAME'];?></td>
							  <td><?php echo $row['ATTN_DATE'];?></td>
							  <td><?php echo $row['IN_TIME'];?></td>
							  <td><?php echo $row['OUT_TIME'];?></td>
							  <td align="center">
							      <?php 
								     if($row['STATUS']=='L'){
										  echo '<span style="color:red;text-align:center;">Late</span>';
								          //$lateCount++;
									 }elseif ($row['STATUS']=='A'){
										  echo '<span style="color:red;text-align:center;">Absent</span>';
										 //$absentCount++;
									 }elseif ($row['STATUS']=='W'){
										  echo 'Weekend';
										 //$weekendCount++;
									 }elseif ($row['STATUS']=='H'){
										 echo 'Holiday';
										 //$holidayCount++;
									 }elseif ($row['STATUS']=='P'){
										 echo 'Present';
										// $presentCount++;
									 }elseif($row['STATUS']=='SL' || 
											 $row['STATUS']=='CL' || 
											 $row['STATUS']=='EL' ||
											 $row['STATUS']=='ML'){
										 echo $row['STATUS'];
										// $leaveCount++;
									 }else {
										 
									 }
									 
								   ?>
							  </td>
							  <td><?php echo $row['BRANCH_NAME'];?></td>
							  <td><?php echo $row['DEPT_NAME'];?></td>
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