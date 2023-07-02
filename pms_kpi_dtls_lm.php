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
	
	$v_page='pms_kpi_list';
	$v_active_open='active open';
	$v_active='active';
	
	
	require_once('layouts/left_menu.php'); 
	require_once('layouts/top_menu.php'); 
	require_once('inc/connoracle.php');
	
	
	$emp_session_id=$_SESSION['HR']['emp_id_hr'];
	$v_key = $_REQUEST['key'];
	$v_emp_id = $_REQUEST['emp_id'];
	
?>


  <div class="content-wrapper">
    <div class="container-fluid">
	    <div class="container-fluid">
		</br>
			<div class="row">
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">

						<thead class="table-dark">
								<tr>
								  <th class="text-center">Sl <br>No</th>
								  <th scope="col">Key Result Areas<br>KRA</th>
								  <th scope="col">Key Performance indicators<br>KPI</th>
								  <th scope="col">Weightage(%)<br>(Range of 5-30)</th>
								  <th scope="col">Target</th>
								  <th scope="col">Remarks</th>
								</tr>
					   </thead>
					   
					   <tbody>
                        <tr>
						<?php
						  $strSQL  = oci_parse($objConnect, 
						            "select KRA_NAME,ID
							        FROM HR_PMS_KRA_LIST WHERE CREATED_BY='$v_emp_id' AND HR_PMS_LIST_ID='$v_key' ORDER BY ID");								
						  oci_execute($strSQL);
						  $number=0;
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $table_ID   = $row['ID'];
						   $number++;
                           ?>
						   
							  <td class="align-middle"><?php echo $number;?></td>
							  <td class="align-middle"><?php echo $row['KRA_NAME'];?></td>
							  <td class="align-middle">
							     <table width="100%">
								<?php 
								
								 $slNumber   = 0;
							     $strSQLInner  = oci_parse($objConnect, "select KPI_NAME from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID"); 
						         oci_execute($strSQLInner);
							     while($rowIN=oci_fetch_assoc($strSQLInner)){	
								    $slNumber++;
									 ?>
							       <tr>
							         <td height="60px"><?php echo $slNumber.'. '.$rowIN['KPI_NAME'];?></td>
								   </tr>
							    <?php 
							     }
							    ?>
							    </table>
							  </td>
							  
							  <td class="align-middle">
							     <table width="100%">
								<?php 

							     $strSQLInner  = oci_parse($objConnect, "select WEIGHTAGE from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID"); 
						         oci_execute($strSQLInner);
							     while($rowIN=oci_fetch_assoc($strSQLInner)){	
									 ?>
							       <tr>
									 <td height="60px" class="align-middle"><?php echo $rowIN['WEIGHTAGE'];?></td>
								   </tr>
							    <?php 
							     }
							    ?>
							    </table>
							  </td> 
							  
							  <td class="align-middle">
							    <table width="100%">
								<?php 
							     $strSQLInner  = oci_parse($objConnect, "select TARGET from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID"); 
						         oci_execute($strSQLInner);
							     while($rowIN=oci_fetch_assoc($strSQLInner)){	
									 ?>
							       <tr>
							        
									 <td height="60px" class="align-middle"><?php echo $rowIN['TARGET'];?></td>
								   </tr>
							    <?php 
							     }
							    ?>
							    </table>
							  </td> 

                             <td class="align-middle">
							     <table width="100%">
								<?php 
								 $slNumberR   = 0;
							     $strSQLInner  = oci_parse($objConnect, "select REMARKS from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID ORDER BY ID"); 
						         oci_execute($strSQLInner);
							     while($rowIN=oci_fetch_assoc($strSQLInner)){	
								 $slNumberR++;
									 ?>
							       <tr>
							         <td height="60px"><?php echo $slNumberR.'. '.$rowIN['REMARKS'];?></td>
								
								   </tr>
							    <?php 
							     }
							    ?>
							    </table>
							  </td> 


						 </tr>
						 <?php
						  
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