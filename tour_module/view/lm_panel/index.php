<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('lm-tour-report')) {
    echo "<script>
		window.location.href = '$basePath/index.php?logout=true';
	</script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>
<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12 mb-3">
        <div class="card-body">

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label>Select a Concern:</label>
                        <select name="emp_concern" class="form-control cust-control">
                            <option selected value="">---</option>
                            <?php
                            $strSQL  = oci_parse(
                                $objConnect,
                                "select RML_ID,EMP_NAME from RML_HR_APPS_USER 
									where LINE_MANAGER_RML_ID ='$emp_session_id'
										and is_active=1 order by EMP_NAME"
                            );
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
                        <input required="" class="form-control cust-control" name="start_date" type="date" />

                    </div>
                    <div class="col-sm-2">
                        <label>To Date:</label>
                        <input required="" class="form-control cust-control" id="date" name="end_date" type="date" />

                    </div>
                    <div class="col-sm-3">
                        <label> Approval Status:</label>
                        <select name="app_status" class="form-control text-center cust-control ">
                            <option hidden value=""><-- Select Status--></option>
                            <option value="1">Approved</option>
                            <option value="0">Denied</option>


                        </select>
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

    </div>




    <!-- Bordered Table -->
    <div class="card">
        <h5 class="card-header"><b>Concern Tour Taken List</b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Concern Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Date Range</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['emp_concern'])) {

                            $v_emp_id = $_REQUEST['emp_concern'];
                            $v_app_status = $_REQUEST['app_status'];
                            $attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            $attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

                            $strSQL  = oci_parse(
                                $objConnect,
                                "select b.EMP_NAME,a.RML_ID,
				                a.ENTRY_DATE,a.START_DATE,a.END_DATE,
						        a.REMARKS,a.ENTRY_BY,b.DEPT_NAME,b.BRANCH_NAME,
						        b.DESIGNATION,a.LINE_MANAGER_APPROVAL_STATUS
					        from RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
					            where a.RML_ID=b.RML_ID
					            and a.LINE_MANAGER_ID='$emp_session_id'
								and ('$v_emp_id' IS NULL OR a.RML_ID='$v_emp_id')
								and ('$v_app_status' is null OR a.LINE_MANAGER_APPROVAL_STATUS='$v_app_status')
								AND START_DATE BETWEEN TO_DATE('$attn_start_date','DD/MM/YYYY') AND TO_DATE('$attn_end_date','DD/MM/YYYY')
					        order by START_DATE desc"
                            );

                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php echo $row['EMP_NAME']; ?></td>
                                    <td><?php echo $row['DEPT_NAME']; ?></td>
                                    <td>
                                        <?php
                                        $tour_day = abs(round(strtotime($row['END_DATE']) - strtotime($row['START_DATE'])) / 86400) + 1;;
                                        echo $row['START_DATE'] . "-To-" . $row['END_DATE'];
                                        echo '<br>';
                                        echo $tour_day;
                                        if ($tour_day == 1)
                                            echo '-Day';
                                        else
                                            echo '-Days';
                                        ?></td>
                                    <td><?php echo $row['REMARKS']; ?></td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
                                    <td><?php
                                        if ($row['LINE_MANAGER_APPROVAL_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['LINE_MANAGER_APPROVAL_STATUS'] == '0') {
                                            echo 'Denied';
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?></td>

                                </tr>


                            <?php
                            }
                        } else {
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "select b.EMP_NAME,a.RML_ID,
				        a.ENTRY_DATE,a.START_DATE,a.END_DATE,
						a.REMARKS,a.ENTRY_BY,b.DEPT_NAME,b.BRANCH_NAME,
						b.DESIGNATION,a.LINE_MANAGER_APPROVAL_STATUS
					from RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
					where a.RML_ID=b.RML_ID
					and a.LINE_MANAGER_ID='$emp_session_id'
					AND START_DATE BETWEEN to_date((SELECT TO_CHAR(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1),'dd/mm/yyyy') FROM dual),'dd/mm/yyyy') AND to_date(( SELECT TO_CHAR(add_months(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1), 1) -1,'dd/mm/yyyy') FROM dual),'dd/mm/yyyy')
					order by START_DATE desc"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                            ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php echo $row['EMP_NAME']; ?></td>
                                    <td><?php echo $row['DEPT_NAME']; ?></td>
                                    <td>
                                        <?php
                                        $tour_day = abs(round(strtotime($row['END_DATE']) - strtotime($row['START_DATE'])) / 86400) + 1;;

                                        echo $row['START_DATE'] . "-To-" . $row['END_DATE'];
                                        echo '<br>';
                                        echo $tour_day;
                                        if ($tour_day == 1)
                                            echo '-Day';
                                        else
                                            echo '-Days';
                                        ?></td>
                                    <td><?php echo $row['REMARKS']; ?></td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
                                    <td><?php
                                        if ($row['LINE_MANAGER_APPROVAL_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['LINE_MANAGER_APPROVAL_STATUS'] == '0') {
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