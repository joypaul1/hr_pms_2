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
	
	$v_page='department_attendance';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	
 $is_exel_download_eanble=0;
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">   	
<div class="container-fluid">
      <!-- Breadcrumbs-->
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						    <div class="col-sm-3">
							    <label class="form-label" for="basic-default-fullname">Select Department Type</label>
							    <select name="emp_dept" class="form-control"> 
								  <option selected value="">---</option>
								      <?php
						                $strSQL  = oci_parse($objConnect, "select distinct(DEPT_NAME) AS  DEPT_NAME from RML_HR_APPS_USER 
																			where DEPT_NAME is not null and is_active=1 
																			order by DEPT_NAME"); 
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
									  <option value="<?php echo $row['DEPT_NAME'];?>"><?php echo $row['DEPT_NAME'];?></option>
									  <?php
									   }
									  ?>
							    </select>
							</div>
							<div class="col-sm-3">
							    <label class="form-label" for="basic-default-fullname" style="color:red;">Select Start Date<b>**</b></label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' >
							   </div>
							</div>
							<div class="col-sm-3">
							    <label class="form-label" for="basic-default-fullname" style="color:red;">Select End Date<b>**</b></label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' >
							   </div>
							</div>
							<div class="col-sm-3">
							    <label class="form-label" for="basic-default-fullname">Select Attendance Status</label>
							    <select  name="attn_status" class="form-control">
								 <option selected value="">---</option>
									  <option value="P">Present</option>
									  <option value="L">Late</option>
									  <option value="A">Absent</option>
									  <option value="RP">Roster Present</option>
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
							  <input class="form-control btn btn-primary" type="submit" value="Search Attendance">
							  </div>
								
						</div>
						<hr>
					</form>
				</div>
				<?php
						
				@$emp_id = $_REQUEST['emp_id'];
				@$attn_status = $_REQUEST['attn_status'];
				
				@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
				@$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
				?>
				
				
				
				<div class="card" id="table">
					<div class="card-body">
					   <div class="col-lg-12">	
				        <div class="row mt-3 text-uppercase d-flex justify-content-center">
							<h3><b>RANGS MOTORS LIMITED</b></h3>
							<h6>117/A,Lavel-04,Old Airport Road,Bijoy Sharani,</h6>
							<h6>Tejgoan,Dhaka-1215</h6>
							<h6>Date :-         <?php if(isset($_POST['attn_status'])){
								                 echo  $attn_start_date.' -To- '.$attn_end_date;
							                    }?> 
							<h6>
					    </div>
					  
				       </div>
				    </div>
					
					  
					  
					  
	                 <div class="card-body">
					 <div class="table-responsive text-nowrap">
					   <table class="table table-bordered table-responsive"  style="width:100%">  
						<thead class="table-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">Emp ID</th>
								  <th scope="col">User Name</th>
								  <th scope="col">Date</th>
								  <th scope="col">IN Time</th>
								  <th scope="col">OUT Time</th>
								  <th scope="col">Late Time(Minutes)</th>
								  <th scope="col">Status</th>
								  <th scope="col">Branch Name</th>
								  <th scope="col">Dept. Name</th>
								  <th scope="col">ATTN Lock Status</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						
						if(isset($_POST['attn_status'])){
						   $v_emp_dept = $_REQUEST['emp_dept'];
						   $strSQL  = oci_parse($objConnect, 
						   "select RML_ID,
						           ATTN_DATE,
								   RML_NAME,
								   IN_TIME,
								   OUT_TIME,
								   STATUS,
								   DEPT_NAME,
								   IN_LAT,
								   IN_LANG,
								   DAY_NAME,
								   BRANCH_NAME,
								   LOCK_STATUS,
								   LOCAK_DATE,
								   LATE_TIME
                            from RML_HR_ATTN_DAILY_PROC
                                where trunc(ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
                                and ('$attn_status' is null OR STATUS='$attn_status')
								and ('$emp_id' is null or RML_ID='$emp_id')
								and ('$v_emp_dept' is null or DEPT_NAME='$v_emp_dept')
                                order by ATTN_DATE"); 
						 
						 oci_execute($strSQL);
						  $number=0;
							$lateCount=0;
							$presentCount=0;
							$absentCount=0;
							$tourCount=0;
							$leaveCount=0;
							$weekendCount=0;
							$holidayCount=0;
							$lateMinutesCount=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
						   $is_exel_download_eanble=1;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['RML_NAME']; ?></td>
							  <td><?php echo $row['ATTN_DATE']; ?></td>
							  <td><?php echo $row['IN_TIME'];?></td>
							  <td><?php echo $row['OUT_TIME'];?></td>
							  <td align="center"><?php echo $row['LATE_TIME']; $lateMinutesCount+=$row['LATE_TIME'];?></td>
							  <td align="center">
							      <?php 
								     if($row['STATUS']=='L'){
										 echo '<span style="color:red;text-align:center;">Late</span>';
								          $lateCount++;
									 }elseif ($row['STATUS']=='A'){
										  echo '<span style="color:red;text-align:center;">Absent</span>';
										 $absentCount++;
									 }elseif ($row['STATUS']=='T'){
										  echo '<span style="color:green;text-align:center;">Tour</span>';
										  $tourCount++;
									 }elseif ($row['STATUS']=='W'){
										  echo 'Weekend';
										 $weekendCount++;
									 }elseif ($row['STATUS']=='H'){
										  echo 'Holiday';
										 $holidayCount++;
									 }elseif ($row['STATUS']=='P'){
										  echo 'Present';
										 $presentCount++;
									 }elseif($row['STATUS']=='SL' || 
											 $row['STATUS']=='CL' || 
											 $row['STATUS']=='EL' ||
											 $row['STATUS']=='PL' ||
											 $row['STATUS']=='ML'){
									     echo $row['STATUS'];
										 $leaveCount++;
									 }else {
										  echo $row['STATUS'];
										  $presentCount++;
									 }
									 
								   ?>
							  </td>
							  <td><?php echo $row['BRANCH_NAME'];?></td>
							  <td><?php echo $row['DEPT_NAME'];?></td>
							  <td><?php 
							     if($row['LOCK_STATUS']==1)
									 echo 'Locked-'.$row['LOCAK_DATE'];
							  ?>
							  
							  </td>
							
						 </tr>
						 <?php 
						  }
						  }
						
						?>
					</tbody>	
				        
		              </table>
					  
					</div>
					
					<?php
					if($is_exel_download_eanble!=0){
					?>
					<div>
					<a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export To Excel</a>
					</div> 
					<?php
					}
					?>
					
				  </div>
				</div>
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
   </div>
</div>
<!-- / Content -->

	<script>
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "EMP_ATTN.xls"); // Choose the file name
		  return false;
		}
	</script>


<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  