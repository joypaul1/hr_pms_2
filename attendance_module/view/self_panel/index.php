<?php
require_once ('../../../helper/3step_com_conn.php');
require_once ('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('self-attendance-report')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label>From Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                            <input required="" class="form-control cust-control" type='date' name='start_date'
                                value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>'>

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label>To Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                            <input required="" class="form-control  cust-control" type='date' name='end_date'
                                value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>'>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label>Select Attendance Status:</label>
                        <select name="attn_status" class="form-control  cust-control">
                            <option selected value="">Select Attendance Status</option>
                            <option value="P">Present</option>
                            <option value="L">Late</option>
                            <option value="A">Absent</option>
                        </select>

                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                            <input class="form-control  btn  btn-sm  btn-primary" placeholder=" Search Employee" type="submit" value="Search Data">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>
                Self Attendance List</b></h5>
        <div class="card-body ">
            <div class="resume-item d-flex flex-column flex-md-row">
                <table class="table table-bordered piechart-key" id="" style="width:100%">
                    <thead class="table-dark">
                        <tr class="text-center">
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

                        @$attn_status       = $_REQUEST['attn_status'];
                        @$attn_start_date   = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$attn_end_date     = date("d/m/Y", strtotime($_REQUEST['end_date']));

                        if (isset($_POST['attn_status'])) {
                            $strSQL = oci_parse($objConnect, "SELECT RML_ID,ATTN_DATE,RML_NAME,IN_TIME,OUT_TIME,STATUS,DEPT_NAME,IN_LAT,IN_LANG,DAY_NAME,BRANCH_NAME 
                            from RML_HR_ATTN_DAILY_PROC
                            where trunc(ATTN_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
                            and ('$attn_status' is null OR STATUS='$attn_status')
							and RML_ID='$emp_session_id' order by ATTN_DATE");
                            @oci_execute($strSQL);
                            $number       = 0;
                            $lateCount    = 0;
                            $presentCount = 0;
                            $absentCount  = 0;
                            $leaveCount   = 0;
                            $weekendCount = 0;
                            $holidayCount = 0;

                            while ($row = @oci_fetch_assoc($strSQL)) {
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
                                        }
                                        elseif ($row['STATUS'] == 'A') {
                                            $absentCount++;
                                        }
                                        elseif ($row['STATUS'] == 'W') {
                                            $weekendCount++;
                                        }
                                        elseif ($row['STATUS'] == 'H') {
                                            $holidayCount++;
                                        }
                                        elseif ($row['STATUS'] == 'P') {
                                            $presentCount++;
                                        }
                                        elseif (
                                            $row['STATUS'] == 'SL' ||
                                            $row['STATUS'] == 'CL' ||
                                            $row['STATUS'] == 'PL' ||
                                            $row['STATUS'] == 'EL' ||
                                            $row['STATUS'] == 'ML'
                                        ) {
                                            $leaveCount++;
                                        }
                                        else {
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
                                <td>Late: <?php echo $lateCount; ?></td>
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

<?php require_once ('../../../layouts/footer_info.php'); ?>
<?php require_once ('../../../layouts/footer.php'); ?>