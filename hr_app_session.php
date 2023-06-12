<?php 
    session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 1)
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
	
	$v_page='roster';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						   
							<div class="col-sm-3">
								<div class="form-group">
								  <label for="title">Select Company</label>
					<select name="r_concern" class="form-control">
					<option selected value="">--</option>
				    <?php
					$strSQL  = oci_parse($objConnect, "select distinct(R_CONCERN) R_CONCERN from RML_HR_APPS_USER 
														where R_CONCERN is not null  
														and is_active=1 
														and R_CONCERN NOT IN ('RG')
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
							</div>
							<div class="col-sm-3">
							<label>From Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control" name="start_date" type="date" />
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
								<div class="form-group">
								  <label for="title"> <br></label>
								  <input class="form-control btn btn-primary" type="submit" value="Search Data">
								</div>
							</div>
							
						</div>	
						
						
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="session_list" style="width:100%">  
						<thead class="table-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Session Date</center></th>
								  <th scope="col"><center>RML ID</center></th>
								  <th scope="col"><center>Emp-Name</center></th>
								  <th scope="col"><center>Designation</center></th>
								  <th scope="col"><center>Device ID</center></th>
								  <th scope="col"><center>First Login Time</center></th>
								  <th scope="col"><center>Last Login Time</center></th>
								  <th scope="col"><center>Total Apps In</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['HR']['emp_id_hr'];
						
						
						if(isset($_POST['start_date'])){
							$v_r_concern=$_REQUEST['r_concern'];
							$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            $attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
							
						  $strSQL  = oci_parse($objConnect, "SELECT UNIQUE TRUNC(a.SESSTION_TIME) SESSTION_DAY,
																	B.RML_ID,
																	B.EMP_NAME,
																	B.DESIGNATION,
																	B.IEMI_NO DEVICE_ID,
																	(SELECT COUNT(ID) FROM HR_APPS_USER_SESSION bb
																				 WHERE bb.RML_COLL_APPS_USER_ID=A.RML_COLL_APPS_USER_ID
																				 AND TRUNC(BB.SESSTION_TIME)=TRUNC(a.SESSTION_TIME)
																	 ) TOTAL_LOGIN,
																	   (SELECT   to_char(MIN(SESSTION_TIME),'HH:MI:SS  AM')  FROM HR_APPS_USER_SESSION bb
																				 WHERE bb.RML_COLL_APPS_USER_ID=A.RML_COLL_APPS_USER_ID
																				 AND TRUNC(BB.SESSTION_TIME)=TRUNC(a.SESSTION_TIME)
																	 ) FIRST_LOGIN,
																	  (SELECT to_char(MAX(SESSTION_TIME),'HH:MI:SS  AM') FROM HR_APPS_USER_SESSION bb
																				 WHERE bb.RML_COLL_APPS_USER_ID=A.RML_COLL_APPS_USER_ID
																				 AND TRUNC(BB.SESSTION_TIME)=TRUNC(a.SESSTION_TIME)
																	 ) LAST_LOGIN
														FROM HR_APPS_USER_SESSION a,RML_HR_APPS_USER b
														WHERE A.RML_COLL_APPS_USER_ID=b.ID
														and ('$v_r_concern' IS NULL OR b.R_CONCERN='$v_r_concern')
														AND TRUNC(SESSTION_TIME) BETWEEN TO_DATE('$attn_start_date','DD/MM/YYYY') AND TO_DATE('$attn_end_date','DD/MM/YYYY')
														ORDER BY B.RML_ID,SESSTION_DAY"); 	
											   
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['SESSTION_DAY'];?></td>
							  <td><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['DESIGNATION'];?></td>
							  <td><?php echo $row['DEVICE_ID'];?></td>
							  <td><?php echo $row['FIRST_LOGIN'];?></td>
							  <td><?php echo $row['LAST_LOGIN'];?></td>
							  <td><?php echo $row['TOTAL_LOGIN'];?></td>

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
			<div>
		     <a class="btn btn-success subbtn" id="session_list" onclick="exportF(this)" style="margin-left:5px;">Export to excel</a>
	        </div> 
			 
				
			</div>
		</div>   
   

</div>

<script>
	function exportF(elem) {
		  var table = document.getElementById("session_list");
		  table.style.border="1px solid red";


		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  
		  elem.setAttribute("download", "EMP_SESSION_REPORT.xls"); // Choose the file name
		  return false;
		}
	</script>
<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  