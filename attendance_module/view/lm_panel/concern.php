<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
        <div class="card card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label>Select Your Concern:</label>
                        <select name="emp_concern" class="form-control text-center   cust-control">
                            <option hidden value=""><-- Concern --></option>
                            <?php
                            $strSQL  = oci_parse($objConnect, "select RML_ID,EMP_NAME from RML_HR_APPS_USER 
													where LINE_MANAGER_RML_ID ='$emp_session_id'
													and is_active=1 
													order by EMP_NAME");
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {
                            ?>
                                <option value="<?php echo $row['RML_ID']; ?>"><?php echo $row['EMP_NAME']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>From Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                            <input required="" class="form-control cust-control" name="start_date" type="date" />
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label>To Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                            <input required="" class="form-control cust-control" id="date" name="end_date" type="date" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label>Select Attendance Status:</label>
                        <select name="attn_status" class="form-control text-center cust-control ">
                            <option hidden value=""><-- Status--></option>
                            <option value="P">Present</option>
                            <option value="L">Late</option>
                            <option value="A">Absent</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                            <input class="form-control  btn  btn-sm  btn-primary" placeholder=" Search Employee" type="submit" value="Search">
                        </div>
                    </div>
                </div>
              
            </form>
        </div>

        <div class="card col-lg-12 mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>Concern Attendance List</b></h5>
            <div class="card-body">
                <div class="resume-item d-flex flex-column flex-md-row">
                    <table class="table table-bordered piechart-key" id="" style="width:100%">
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

                            if (isset($_POST['attn_status'])) {
                                $v_rml_id = $_REQUEST['emp_concern'];
                                $attn_status = $_REQUEST['attn_status'];
                                $attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                $attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                $strSQL  = oci_parse(
                                    $objConnect,
                                    "select A.RML_ID,
						                     A.ATTN_DATE,A.RML_NAME,
											 A.IN_TIME,A.OUT_TIME,
											 A.STATUS,A.DEPT_NAME,
											 A.IN_LAT,A.IN_LANG,
											 A.DAY_NAME,A.BRANCH_NAME
									from RML_HR_ATTN_DAILY_PROC A,RML_HR_APPS_USER B
									where A.RML_ID =B.RML_ID
									  AND B.IS_ACTIVE=1
									  AND B.LINE_MANAGER_RML_ID ='$emp_session_id'
									  AND trunc(A.ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
									  AND ('$attn_status' is null OR A.STATUS='$attn_status')
									  AND ('$v_rml_id' IS NULL OR A.RML_ID='$v_rml_id')
									  order by A.ATTN_DATE"
                                );
                                oci_execute($strSQL);
                                $number = 0;
                                $lateCount = 0;
                                $presentCount = 0;
                                $absentCount = 0;
                                $leaveCount = 0;
                                $weekendCount = 0;
                                $holidayCount = 0;

                                while ($row = oci_fetch_assoc($strSQL)) {
                                    $number++;
                            ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td><?php echo $row['RML_ID']; ?></td>
                                        <td><?php echo $row['RML_NAME']; ?></td>
                                        <td><?php echo $row['ATTN_DATE']; ?></td>
                                        <td><?php echo $row['IN_TIME']; ?></td>
                                        <td><?php echo $row['OUT_TIME']; ?></td>
                                        <td align="center">
                                            <?php
                                            if ($row['STATUS'] == 'L') {
                                                $lateCount++;
                                            } elseif ($row['STATUS'] == 'A') {
                                                $absentCount++;
                                            } elseif ($row['STATUS'] == 'W') {
                                                $weekendCount++;
                                            } elseif ($row['STATUS'] == 'H') {
                                                $holidayCount++;
                                            } elseif ($row['STATUS'] == 'P') {
                                                $presentCount++;
                                            } elseif (
                                                $row['STATUS'] == 'SL' ||
                                                $row['STATUS'] == 'CL' ||
                                                $row['STATUS'] == 'PL' ||
                                                $row['STATUS'] == 'EL' ||
                                                $row['STATUS'] == 'ML'
                                            ) {
                                                $leaveCount++;
                                            } else {
                                            }
                                            echo $row['STATUS'];
                                            ?>
                                        </td>
                                        <td><?php echo $row['BRANCH_NAME']; ?></td>
                                        <td><?php echo $row['DEPT_NAME']; ?></td>

                                    </tr>
                                <?php

                                }
                                ?>
                                <tr>
                                    <td></td>
                                    <td><b>Summary</b></td>
                                    <td>Present: <?php echo $presentCount; ?></td>
                                    <td>Late: <?php echo  $lateCount; ?></td>
                                    <td>Absent: <?php echo $absentCount; ?></td>
                                    <td>Weekend: <?php echo $weekendCount; ?></td>
                                    <td>Holiday: <?php echo $holidayCount; ?></td>
                                    <td>Leave: <?php echo $leaveCount; ?></td>
                                    <td></td>
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
<!-- / Content -->




<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>