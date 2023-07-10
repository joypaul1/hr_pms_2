<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
if (!checkPermission('lm-attendance-outdoor')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
?>




<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
        <div class="card card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label>Select a Concern:</label>
                        <select name="emp_concern" class="form-control text-center cust-control">
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
                    <div class="col-sm-3">
                        <label>From Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                            <input required="" class="form-control cust-control" name="start_date" type="date" />
                        </div>
                    </div>
                    <div class="col-sm-3">
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
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                            <input class="form-control  btn  btn-sm  btn-primary" placeholder=" Search Employee" type="submit" value="Search Employee">
                        </div>
                    </div>

                </div>

            </form>
        </div>

        <div class="card col-lg-12 mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>Concern Outdoor Attendance List</b></h5>
            <div class="card-body">
                <div class="resume-item d-flex flex-column flex-md-row">
                    <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
                        <thead class="table-dark text-center">
                            <tr class="text-center">
                                <th scope="col">Sl</th>
                                <th scope="col">Emp ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Entry Date</th>
                                <th scope="col">Outdoor Remarks</th>
                                <th scope="col">Approval Status</th>
                                <th scope="col">Approval By</th>
                                <th scope="col">Approved Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            // $emp_id=$_SESSION['emp_id'];
                            $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                            @$emp_concern = $_REQUEST['emp_concern'];
                            @$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            @$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

                            if (isset($_POST['emp_concern'])) {
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
															 and b.INSIDE_OR_OUTSIDE='Outside Office'
															 and trunc(b.ATTN_DATE) between to_date('$start_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')
															  and ('$emp_concern' is null OR a.RML_ID='$emp_concern')
															 and a.LINE_MANAGER_RML_ID= '$emp_session_id'
															order by ATTN_DATE");


                                oci_execute($strSQL);
                                $number = 0;
                                while ($row = oci_fetch_assoc($strSQL)) {
                                    $number++;
                            ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td><?php echo $row['RML_ID']; ?></td>
                                        <td><?php echo $row['EMP_NAME']; ?></td>
                                        <td><?php echo $row['ATTN_DATE']; ?></td>
                                        <td><?php echo $row['OUTSIDE_REMARKS']; ?></td>
                                        <td align="center"><?php
                                                            if ($row['LINE_MANAGER_APPROVAL'] == '1') {
                                                                echo 'Approved';
                                                            } elseif ($row['LINE_MANAGER_APPROVAL'] == '0') {
                                                                echo 'Denide';
                                                            } else {
                                                                echo 'Pending';
                                                            }
                                                            ?>
                                        </td>
                                        <td><?php
                                            if ($row['LINE_MANAGER_APPROVAL'] == '1') {
                                                echo $row['LINE_MANAGER_NAME'];
                                            } else {
                                                echo '';
                                            }



                                            ?></td>
                                        <td><?php echo $row['LINE_MANAGER_APPROVAL_DATE']; ?></td>
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

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>