<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('concern-leave-report')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];


//To run PHP script on submit
if (isset($_POST['submit_delete'])) {
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
            $strSQL = oci_parse(
                $objConnect,
                "begin RML_HR_LEAVE_DELETE('$TT_ID_SELECTTED','$emp_session_id');end;"
            );
            oci_execute($strSQL);
            $attnProcSQL  = oci_parse($objConnect, "DECLARE V_START_DATE VARCHAR2(100);
						                V_END_DATE VARCHAR2(100);
										V_RML_ID VARCHAR2(100);
									  BEGIN
									   SELECT TO_CHAR(START_DATE,'dd/mm/yyyy'),TO_CHAR(END_DATE,'dd/mm/yyyy'),RML_ID 
									   INTO V_START_DATE,V_END_DATE,V_RML_ID
									   FROM RML_HR_EMP_LEAVE_DELETE
									   WHERE ID='$TT_ID_SELECTTED';
									   RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_START_DATE,'dd/mm/yyyy'),TO_DATE(V_END_DATE,'dd/mm/yyyy'));end;");

            if (oci_execute($attnProcSQL)) {
                $message = [
                    'text' => 'Successfully Deleted Leave. TABLE_ID ' . $TT_ID_SELECTTED,
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
            }
        }
        echo "<script>window.location = " . $basePath . "'/leave_module/view/concern_panel/delete.php'</script>";
    } else {
        $message = [
            'text' => "Sorry! You have not select any ID Code.",
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>window.location = " . $basePath . "'/leave_module/view/concern_panel/delete.php'</script>";
    }
}
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12">

        <form id="Form1" action="" method="post"></form>
        <form id="Form2" action="" method="post"></form>
        <div class="card-body row justify-content-center">
            <div class="col-sm-6"></div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                    <input form="Form1" placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>'>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                    <input form="Form1" class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                </div>
            </div>
        </div>

    </div>


    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>Leave List[&#177; 10 Days]</b></h5>
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
                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT A.ID,
								B.RML_ID,
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
							AND trunc(START_DATE) BETWEEN trunc(sysdate)-10 and trunc(sysdate)+10
							ORDER BY START_DATE DESC"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>" form="Form2">
                                        <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php
                                        echo $row['RML_ID'];
                                        echo '<br>';
                                        echo 'Name: ' . $row['EMP_NAME'];
                                        echo '<br>';
                                        echo 'Dept: ' . $row['DEPT_NAME'];
                                        echo '<br>';
                                        echo 'Brance: ' . $row['BRANCH_NAME'];
                                        ?>
                                    </td>
                                    <td><?php
                                        $leave_days = ($row['END_DATE'] - $row['START_DATE'] + 1);
                                        if ($leave_days == 1)
                                            $display = $leave_days . ' Day';
                                        else
                                            $display = $leave_days . ' Days';
                                        echo  $display;
                                        echo '<br>';
                                        echo 'Leave Type:  ' . $row['LEAVE_TYPE'];
                                        echo '<br>';
                                        echo 'Start: ' . $row['START_DATE'];
                                        echo '<br>';
                                        echo 'End: ' . $row['END_DATE'];
                                        echo '<br>';
                                        echo 'Entry: ' . $row['ENTRY_DATE'];
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
                                        ?>
                                        <br>
                                        <input class="btn btn-primary btn pull-right" form="Form2" type="submit" name="submit_delete" value="Delete">
                                    </td>
                                </tr>


                            <?php
                            }
                        } else {


                            $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT A.ID,B.RML_ID,
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
							AND trunc(START_DATE) BETWEEN trunc(sysdate)-10 and trunc(sysdate)+10
							ORDER BY START_DATE DESC"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>" form="Form2">
                                        <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php
                                        echo $row['RML_ID'];
                                        echo '<br>';
                                        echo 'Name: ' . $row['EMP_NAME'];
                                        echo '<br>';
                                        echo 'Dept: ' . $row['DEPT_NAME'];
                                        echo '<br>';
                                        echo 'Brance: ' . $row['BRANCH_NAME'];
                                        ?>
                                    </td>
                                    <td><?php
                                        $leave_days = ($row['END_DATE'] - $row['START_DATE'] + 1);
                                        if ($leave_days == 1)
                                            $display = $leave_days . ' Day';
                                        else
                                            $display = $leave_days . ' Days';
                                        echo  $display;
                                        echo '<br>';
                                        echo 'Leave Type:  ' . $row['LEAVE_TYPE'];
                                        echo '<br>';
                                        echo 'Start: ' . $row['START_DATE'];
                                        echo '<br>';
                                        echo 'End: ' . $row['END_DATE'];
                                        echo '<br>';
                                        echo 'Entry: ' . $row['ENTRY_DATE'];
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
                                        ?>
                                        <br>
                                        <input class="btn btn-primary btn pull-right" form="Form2" type="submit" name="submit_delete" value="Delete">
                                    </td>
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