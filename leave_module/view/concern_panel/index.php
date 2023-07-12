<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');

if (!checkPermission('concern-leave-report')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="col-lg-12 card">
        <div class="card-body text-center">
            <form action="" method="post">
                <div class="row justify-content-center">
              
                    <div class="col-sm-2">
                        <label class="form-label" for="emp_id">EMP RML ID<span class="text-danger">*</span></label>
                         <input required="" class="form-control cust-control" name="emp_id" id="emp_id" type="text">
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label" for="start_date">From Date <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input required="" id="start_date" class="form-control cust-control" name="start_date" type="date">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label"  for="end_date">End Date <span class="text-danger">*</span></label>
                        <div class="input-group">

                            <input required="" type="date" name="end_date" class="form-control cust-control" id="end_date" value="">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                            <input class="form-control  btn  btn-sm  btn-primary" type="submit" value="Search Data">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">
        <!-- <h5 class="card-header "><b>Leave Taken List</b></h5> -->
        <!-- table header -->
        <?php
        $leftSideName  = 'Concern Leave List';
        if (checkPermission('concern-leave-create')) {
            $rightSideName = 'Leave Create';
            $routePath     = 'leave_module/view/concern_panel/create.php';
        }

        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead style="background: beige;">
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
                        if (isset($_POST['emp_id'])) {

                            $v_emp_id = $_REQUEST['emp_id'];

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
                             ORDER BY START_DATE DESC"
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
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
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
