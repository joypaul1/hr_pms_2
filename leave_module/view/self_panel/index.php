<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];

if (!checkPermission('self-leave-report')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form action="" method="post">
            <div class="row justify-content-center">
                <input required name="emp_id" type='hidden' value='<?php echo $emp_session_id; ?>'>
                <div class="col-sm-2">
                    <label class="form-label" for="basic-default-fullname">Select Start Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="start_date" class="form-control  cust-control" id="title" value="">
                    </div>
                </div>
                <div class="col-sm-2">
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
                        <input class="form-control  btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>


            </div>

        </form>
    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">
        <!-- <h5 class="card-header "><b>Leave Taken List</b></h5> -->
        <!-- table header -->
        <?php
        $leftSideName  = 'Self Leave List';
        if (checkPermission('self-leave-create')) {
            $rightSideName = 'Leave Create';
            $routePath     = 'leave_module/view/self_panel/create.php';
        }

        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table  table-bordered">
                    <thead style="background-color: #b8860b;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Leave Type</th>
                            <th scope="col">To Date</th>
                            <th scope="col">From Date</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Approval Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['start_date'])) {

                            $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            $v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT B.RML_ID,
                                 B.EMP_NAME,
                                 B.DEPT_NAME,
                                 B.BRANCH_NAME,
                                 A.LEAVE_TYPE,
                                 A.START_DATE,
                                 A.END_DATE,
                                 A.ENTRY_FROM,
                                 A.IS_APPROVED
                             FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
                             WHERE  A.RML_ID=B.RML_ID
                             AND A.RML_ID='$emp_session_id'
							 AND TRUNC (A.START_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
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
                                    <td><?php echo $row['LEAVE_TYPE']; ?></td>
                                    <td><?php echo $row['START_DATE']; ?></td>
                                    <td><?php echo $row['END_DATE']; ?></td>
                                    <td><?php echo $row['ENTRY_FROM']; ?></td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
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


                            // $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
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
                                 A.IS_APPROVED
                             FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
                             WHERE  A.RML_ID=B.RML_ID
                             AND A.RML_ID='$emp_session_id'
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
                                    <td><?php echo $row['LEAVE_TYPE']; ?></td>
                                    <td><?php echo $row['START_DATE']; ?></td>
                                    <td><?php echo $row['END_DATE']; ?></td>
                                    <td><?php echo $row['ENTRY_FROM']; ?></td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
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