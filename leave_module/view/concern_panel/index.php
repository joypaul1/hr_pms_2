<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('concern-leave-report')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12">
        <form action="" method="post">
            <div class="card-body row justify-content-center">
                <!-- <div class="col-sm-2"></div> -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                        <input  placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' >
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Select Start Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="start_date" class="form-control  cust-control" id="title" value="">
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Select End Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="end_date" class="form-control  cust-control" id="title" value="">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>
            </div>
        </form>
    </div>
  

    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>Leave Taken List</b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>SL</th>
                            <th scope="col">Emp Info</th>
                            <th class="text-center">Leave Info</th>
                            <th scope="col">Approval Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['emp_id'])) {

                            $v_emp_id = $_REQUEST['emp_id'];
                            $v_leave_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            $v_leave_end_date   = date("d/m/Y", strtotime($_REQUEST['end_date']));
                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT B.RML_ID,
								B.EMP_NAME,
								B.DEPT_NAME,
								B.BRANCH_NAME,
								A.LEAVE_TYPE,
								A.START_DATE,
								A.END_DATE,
								A.ENTRY_DATE,
								A.IS_APPROVED
							FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
							WHERE  A.RML_ID=B.RML_ID
							AND B.R_CONCERN IN (SELECT R_CONCERN from RML_HR_APPS_USER WHERE IS_ACTIVE=1 AND RML_ID ='$emp_session_id') 
							AND ('$v_emp_id' IS NULL OR A.RML_ID='$v_emp_id')
							AND trunc(START_DATE) BETWEEN TO_DATE('$v_leave_start_date','DD/MM/YYYY') AND TO_DATE('$v_leave_end_date','DD/MM/YYYY')
							ORDER BY START_DATE DESC"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                                <tr>
                                    <td>
                                         <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php 
									     echo $row['RML_ID']; 
										 echo '<br>';
                                         echo 'Name: '.$row['EMP_NAME'];	
                                         echo '<br>';
                                         echo 'Dept: '.$row['DEPT_NAME'];
                                         echo '<br>';
                                         echo 'Brance: '.$row['BRANCH_NAME'];											 
									    ?>
									</td>
									 <td><?php 
									    $leave_days=($row['END_DATE']-$row['START_DATE']+1);
										if($leave_days==1)
											$display=$leave_days.' Day';
									    else
											$display=$leave_days.' Days';
										 echo  $display; 
										 echo '<br>';
									     echo 'Leave Type:  '.$row['LEAVE_TYPE']; 
										 echo '<br>';
                                         echo 'Start: '.$row['START_DATE'];	
                                         echo '<br>';
                                         echo 'End: '.$row['END_DATE'];
                                         echo '<br>';
                                         echo 'Entry: '.$row['ENTRY_DATE'];											 
									    ?>
									</td>
                                    <td><?php
									
									   
										
                                        if ($row['IS_APPROVED'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['IS_APPROVED'] == '0') {
                                            echo 'Denied';
                                        } else {
                                            echo 'Pending';
                                        }

                                        ?></td>
                                </tr>


                            <?php
                            }
                        } else {


                            $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT B.RML_ID,
								B.EMP_NAME,
								B.DEPT_NAME,
								B.BRANCH_NAME,
								A.LEAVE_TYPE,
								A.START_DATE,
								A.END_DATE,
								A.ENTRY_DATE,
								A.IS_APPROVED
							FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
							WHERE  A.RML_ID=B.RML_ID
							AND b.R_CONCERN='RMWL'
							AND START_DATE BETWEEN to_date((SELECT TO_CHAR(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1),'dd/mm/yyyy') FROM dual),'dd/mm/yyyy') AND to_date(( SELECT TO_CHAR(add_months(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1), 1) -1,'dd/mm/yyyy') FROM dual),'dd/mm/yyyy')
							ORDER BY START_DATE DESC"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                            ?>
                                <tr>
                                    <td>
                                         <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php 
									     echo $row['RML_ID']; 
										 echo '<br>';
                                         echo 'Name: '.$row['EMP_NAME'];	
                                         echo '<br>';
                                         echo 'Dept: '.$row['DEPT_NAME'];
                                         echo '<br>';
                                         echo 'Brance: '.$row['BRANCH_NAME'];											 
									    ?>
									</td>
									 <td><?php 
									    $leave_days=($row['END_DATE']-$row['START_DATE']+1);
										if($leave_days==1)
											$display=$leave_days.' Day';
									    else
											$display=$leave_days.' Days';
										 echo  $display; 
										 echo '<br>';
									     echo 'Leave Type:  '.$row['LEAVE_TYPE']; 
										 echo '<br>';
                                         echo 'Start: '.$row['START_DATE'];	
                                         echo '<br>';
                                         echo 'End: '.$row['END_DATE'];
                                         echo '<br>';
                                         echo 'Entry: '.$row['ENTRY_DATE'];											 
									    ?>
									</td>
                                    <td><?php
									
									   
										
                                        if ($row['IS_APPROVED'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['IS_APPROVED'] == '0') {
                                            echo 'Denied';
                                        } else {
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

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
