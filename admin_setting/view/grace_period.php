<?php
require_once ('../../helper/2step_com_conn.php');
require_once ('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">


    <!-- Bordered Table -->
    <div class="card">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i> <b>Grace Period</b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th scope="col">Sl</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Grace Time</th>
                            <th scope="col">Late Start</th>
                            <th scope="col">Concern</th>
                            <th scope="col">Created By</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
                        $allDataSQL     = oci_parse(
                            $objConnect,
                            "SELECT
							ID,
							START_DATE,
							END_DATE,
							GRACE_TIME,
							LATE_START_TIME,
							CONCERN_ORGANIZATION,
							CREATE_DATE,
							CREATED_BY
							FROM HR_ATTN_GRACE_PERIOD"
                        );

                        @oci_execute($allDataSQL);
                        $number = 0;
                        while ($row = @oci_fetch_assoc($allDataSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td><?php echo $number; ?></td>
                                <td><?php echo $row['START_DATE']; ?></td>
                                <td><?php echo $row['END_DATE']; ?></td>
                                <td><?php echo $row['GRACE_TIME']; ?></td>
                                <td><?php echo $row['LATE_START_TIME']; ?></td>
                                <td><?php echo $row['CONCERN_ORGANIZATION']; ?></td>
                                <td><?php echo $row['CREATED_BY']; ?></td>
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


<?php require_once ('../../layouts/footer_info.php'); ?>
<?php require_once ('../../layouts/footer.php'); ?>