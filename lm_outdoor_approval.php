<?php 
    session_start();
	session_regenerate_id(TRUE);
	
	if($_SESSION['HR']['hr_role']!= 3)
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
	
	$v_page='lm_outdoor_approval';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	$emp_session_id=$_SESSION['HR']['emp_id_hr'];
    $v_view_approval=0;
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<form id="Form3" action="" method="post"></form>
						<div class="row">
						    <div class="col-sm-4">
							    <label>Select Your Concern:</label>
								<select name="emp_concern" class="form-control" form="Form1" > 
								 <option selected value="">Select Concern</option>
								      <?php
									   
									   
						                $strSQL  = oci_parse($objConnect, "select RML_ID,EMP_NAME from RML_HR_APPS_USER 
																		where LINE_MANAGER_RML_ID ='$emp_session_id'
																		and is_active=1 
																		order by EMP_NAME"); 
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
	
									  <option value="<?php echo $row['RML_ID'];?>"><?php echo $row['EMP_NAME'];?></option>
									  <?php
									   }
									  ?>
							</select>
							</div>
							<div class="col-sm-4">
							<label>From Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control" form="Form1" name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-4">
							<label>To Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" form="Form1" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							
						</div>	
						<div class="row mt-3">		
                              <div class="col-sm-4">
							  </div>
							 <div class="col-sm-4">
							  </div>
                             <div class="col-sm-4">
							    <input class="form-control btn btn-primary" type="submit" value="Search Approval Data" form="Form1">
							  </div>							  	
						</div>
						
					</form>
				</div>
				
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="table-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Emp Info</center></th>
								  <th scope="col"><center>Entry Info</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						@$emp_concern = $_REQUEST['emp_concern'];
						@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

						if(isset($_POST['emp_concern'])){
						  $strSQL  = oci_parse($objConnect, "select a.ID,b.RML_ID,b.EMP_NAME, 
															a.ATTN_DATE,
															to_char(a.ATTN_DATE,'HH:MI:SS  AM') ATTN_TIME,
															a.LAT,
															a.LANG,
															a.OUTSIDE_REMARKS,a.EMP_DISTANCE,a.ENTRY_DATE,b.DEPT_NAME,b.DESIGNATION
											from RML_HR_ATTN_DAILY a ,RML_HR_APPS_USER b
											where A.RML_ID=B.RML_ID
											 and ('$emp_concern' is null OR A.RML_ID='$emp_concern')
											and a.LINE_MANAGER_ID = '$emp_session_id'
											and trunc(a.ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
											AND a.IS_ALL_APPROVED = 0
											AND A.LINE_MANAGER_APPROVAL IS NULL
											AND B.IS_ACTIVE=1
											order by b.RML_ID,ATTN_DATE desc"); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
						   $v_view_approval=1;
                           ?>
						   <tr>
							 <td align="center">
							   <input type="checkbox" name="check_list[]" value="<?php echo $row['ID'];?>">
							   <?php echo $number;?>
							  </td>
							  <td>
							     <?php echo $row['RML_ID'];
								       echo ',<br>';
									   echo $row['EMP_NAME'];
									   echo ',<br>';
									   echo $row['DEPT_NAME'];
									   echo ',<br>';
									   echo $row['DESIGNATION'];
							     ?>
							  </td>
							   <td><?php echo $row['ATTN_DATE'];
							            echo ',<br>';
									    echo $row['ATTN_TIME'];
							            $latitu=$row['LAT'];
							            $lng=$row['LANG'];
								        $url="http://www.google.com/maps/place/".$latitu.",".$lng;
										
										echo ',<br>';
										echo 'Remarks: '.$row['OUTSIDE_REMARKS'];
										echo ',<br>';
										?>
										<a id="myLink" href="<?php echo $url;?>" target="_blank">View Entry Location</a>
								</td>
							 
						 </tr>
						 <?php
						  }
						   if($v_view_approval>0){
						  ?>
						   <tr>
						    <td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve"/>
                            							
							</td>
							
							<td><input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Denied"/>	</td>
							
						
						   </tr>
						  <?php
						  }
						  }else{
							
						     $allDataSQL  = oci_parse($objConnect, "select a.ID,b.RML_ID,b.EMP_NAME, 
                                                            a.ATTN_DATE,
                                                            to_char(a.ATTN_DATE,'HH:MI:SS  AM') ATTN_TIME,
                                                            a.LAT,
                                                            a.LANG,
                                                            a.OUTSIDE_REMARKS,a.EMP_DISTANCE,a.ENTRY_DATE,b.DEPT_NAME,b.DESIGNATION
                                            from RML_HR_ATTN_DAILY a ,RML_HR_APPS_USER b
                                            where A.RML_ID=B.RML_ID
                                            and a.LINE_MANAGER_ID = '$emp_session_id'
                                            and trunc (a.ATTN_DATE)>TO_DATE('31/12/2022','DD/MM/YYYY')
                                            AND a.IS_ALL_APPROVED = 0
                                            AND A.LINE_MANAGER_APPROVAL IS NULL
                                            AND B.IS_ACTIVE=1
                                            order by b.RML_ID,ATTN_DATE desc"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
						   $v_view_approval=1;
                           ?>
						   <tr>
							  <td align="center">
							   <input type="checkbox" name="check_list[]" value="<?php echo $row['ID'];?>">
							   <?php echo $number;?>
							  </td>
							  <td>
							     <?php echo $row['RML_ID'];
								       echo ',<br>';
									   echo $row['EMP_NAME'];
									   echo ',<br>';
									   echo $row['DEPT_NAME'];
									   echo ',<br>';
									   echo $row['DESIGNATION'];
							     ?>
							  </td>
							  <td><?php echo $row['ATTN_DATE'];
							            echo ',<br>';
									    echo $row['ATTN_TIME'];
							            $latitu=$row['LAT'];
							            $lng=$row['LANG'];
								        $url="http://www.google.com/maps/place/".$latitu.",".$lng;
										
							            
										echo ',<br>';
										echo 'Remarks: '.$row['OUTSIDE_REMARKS'];
										echo ',<br>';
										?>
										<a id="myLink" href="<?php echo $url;?>" target="_blank">View Entry Location</a>
								</td>
						 </tr>
						 <?php
						  }
						  if($v_view_approval>0){
						   ?>
						   <tr>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve"/>
                            							
							</td>
							
							<td><input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Denied"/></td>
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
			  </form>
				<?php
				    $localIP = $_SERVER['REMOTE_ADDR'];
					
					if(isset($_POST['submit_approval'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "update RML_HR_ATTN_DAILY set 
														LINE_MANAGER_APPROVAL='1',
														IS_ALL_APPROVED='1',
														LINE_MANAGER_APPROVAL_REMARKS='Approved by $emp_session_id',
														LINE_MANAGER_APPROVAL_DATE=SYSDATE
                                                       where ID='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						 $attnProcSQL  = oci_parse($objConnect, "declare V_ATTN_DATE VARCHAR2(100);V_RML_ID VARCHAR2(100);begin  SELECT TO_CHAR(ATTN_DATE,'dd/mm/yyyy'),RML_ID INTO V_ATTN_DATE,V_RML_ID FROM RML_HR_ATTN_DAILY  WHERE ID='$TT_ID_SELECTTED';RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_ATTN_DATE,'dd/mm/yyyy'),TO_DATE(V_ATTN_DATE,'dd/mm/yyyy'));end;");
			   
			            if(oci_execute($attnProcSQL)){
							echo '<div class="alert alert-primary">';
						    echo 'Successfully Approved Outdoor Attendance ID '.$TT_ID_SELECTTED;
						    echo '</div>';
						}
					}
					echo "<script>window.location = 'http://202.40.181.98:9090/rHR/lm_outdoor_approval.php'</script>";
					}else{
						echo '<div class="alert alert-danger">';
						echo 'Sorry! You have not select any ID Code.';
						echo '</div>';
					}
					}
					
					// Denied option
					if(isset($_POST['submit_denied'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "update RML_HR_ATTN_DAILY set 
														LINE_MANAGER_APPROVAL='0',
														IS_ALL_APPROVED='0',
														LINE_MANAGER_APPROVAL_REMARKS='Denied by $emp_session_id',
														LINE_MANAGER_APPROVAL_DATE=SYSDATE
                                                       where ID='$TT_ID_SELECTTED'");
						
						if(oci_execute($strSQL))
						{
						echo '<div class="alert alert-danger">';
						echo 'Successfully Denied Outdoor Attendance ID '.$TT_ID_SELECTTED;
						echo '</div>';	
						}
					}
					 echo "<script>window.location = 'http://202.40.181.98:9090/rHR/lm_outdoor_approval.php'</script>";
					
					}else{
						echo '<div class="alert alert-danger">';
						echo 'Sorry! You have not select any ID Code.';
						echo '</div>';
					}
					}
					
					
				 ?>
			</div>
   

</div>

<!-- / Content -->

<?php require_once('layouts/footer_info.php'); ?>   										
<?php require_once('layouts/footer.php'); ?>  