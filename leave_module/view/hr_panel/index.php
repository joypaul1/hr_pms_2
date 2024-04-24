<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('hr-leave-report')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];


?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12">
        <form action="" method="post">
            <div class="card-body row justify-content-center">
			<div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                        <input  placeholder="Employee ID" name="emp_id" class="form-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' >
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Leave Start Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
						<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Leave End Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
						<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
                    </div>
                </div>
                <div class="col-sm-3">
					<label class="form-label" for="basic-default-fullname">Select Leave Status</label>
					<div class="input-group">
					<select name="leave_status" class="form-control">
						<option  value="Pending">Pending</option>
						<option  value="1">Approved</option>
						<option  value="0">Denied</option>
					</select>
					</div>
				</div>
               
            </div>
			
			 <div class="row">
			 <div class="col-sm-9"> </div>
			    <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
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
                <table class="table table-bordered" id="table">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Emp ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Dept.</th>
							<th scope="col">Branch</th>
							<th scope="col">Concern</th>
                            <th scope="col">Leave Type</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Entry From</th>
                            <th scope="col">Approval Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['emp_id'])) {

                            $v_emp_id = $_REQUEST['emp_id'];
                             $v_leave_status = $_REQUEST['leave_status'];
							 $leave_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
							 $leave_end_date= date("d/m/Y", strtotime($_REQUEST['end_date']));
                            if($v_leave_status=="Pending"){
								$quary="SELECT B.RML_ID,
								B.EMP_NAME,
								B.DEPT_NAME,
								B.BRANCH_NAME,
								A.LEAVE_TYPE,
								A.START_DATE,
								A.END_DATE,
								A.ENTRY_FROM,
								A.IS_APPROVED,
								B.R_CONCERN
							FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
							WHERE  A.RML_ID=B.RML_ID
							AND A.IS_APPROVED IS NULL
							AND B.IS_ACTIVE=1
							AND (TRUNC(A.START_DATE) BETWEEN TO_DATE('$leave_start_date','DD/MM/YYYY') AND  TO_DATE('$leave_end_date','DD/MM/YYYY')
							    OR 
								TRUNC(A.END_DATE) BETWEEN TO_DATE('$leave_start_date','DD/MM/YYYY') AND  TO_DATE('$leave_end_date','DD/MM/YYYY'))
							ORDER BY START_DATE DESC";
							}else{
								 $quary="SELECT B.RML_ID,
								B.EMP_NAME,
								B.DEPT_NAME,
								B.BRANCH_NAME,
								A.LEAVE_TYPE,
								A.START_DATE,
								A.END_DATE,
								A.ENTRY_FROM,
								A.IS_APPROVED,
								B.R_CONCERN
							FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
							WHERE  A.RML_ID=B.RML_ID
							AND B.IS_ACTIVE=1
							AND ('$v_emp_id' IS NULL OR A.RML_ID='$v_emp_id')
							AND A.IS_APPROVED='$v_leave_status'
							AND (TRUNC(A.START_DATE) BETWEEN TO_DATE('$leave_start_date','DD/MM/YYYY') AND  TO_DATE('$leave_end_date','DD/MM/YYYY')
							    OR 
								TRUNC(A.END_DATE) BETWEEN TO_DATE('$leave_start_date','DD/MM/YYYY') AND  TO_DATE('$leave_end_date','DD/MM/YYYY'))
							ORDER BY START_DATE DESC";
							}
                           
							//echo $quary;
							//die();
							$strSQL  = oci_parse($objConnect,$quary);
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                                <tr>
                                    <td>
                                         <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php echo $row['RML_ID']; ?></td>
                                    <td><?php echo $row['EMP_NAME']; ?></td>
                                    <td><?php echo $row['DEPT_NAME']; ?></td>
									<td><?php echo $row['BRANCH_NAME']; ?></td>
									<td><?php echo $row['R_CONCERN']; ?></td>
                                    <td><?php echo $row['LEAVE_TYPE']; ?></td>
                                    <td><?php echo $row['START_DATE']; ?></td>
                                    <td><?php echo $row['END_DATE']; ?></td>
                                    <td><?php echo $row['ENTRY_FROM']; ?></td>
                                    
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


                            $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT B.RML_ID,
								B.EMP_NAME,
								B.DEPT_NAME,
								B.BRANCH_NAME,
								A.LEAVE_TYPE,
								A.START_DATE,
								A.END_DATE,
								A.ENTRY_FROM,
								A.IS_APPROVED,
								B.R_CONCERN
							FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
							WHERE  A.RML_ID=B.RML_ID
							AND TRUNC(START_DATE) BETWEEN TO_DATE(SYSDATE,'dd/mm/RRRR')-1 AND TO_DATE(SYSDATE,'dd/mm/RRRR')
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
                                    <td><?php echo $row['RML_ID']; ?></td>
                                    <td><?php echo $row['EMP_NAME']; ?></td>
                                    <td><?php echo $row['DEPT_NAME']; ?></td>
									 <td><?php echo $row['BRANCH_NAME']; ?></td>
									 <td><?php echo $row['R_CONCERN']; ?></td>
                                    <td><?php echo $row['LEAVE_TYPE']; ?></td>
                                    <td><?php echo $row['START_DATE']; ?></td>
                                    <td><?php echo $row['END_DATE']; ?></td>
                                    <td><?php echo $row['ENTRY_FROM']; ?></td>
                                   
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
			<br>
			<div>
			<a class="btn btn-success" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export To Excel</a>
			</div> 
        </div>
    </div>
    <!--/ Bordered Table -->
<script>
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Leave Information.xls"); // Choose the file name
		  return false;
		}
	</script>


</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>