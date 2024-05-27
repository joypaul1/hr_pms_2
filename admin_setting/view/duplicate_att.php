<?php
require_once ('../../helper/2step_com_conn.php');
require_once ('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- -->
    <!--  -->

    <!-- Bordered Table -->
    <div class="card">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i> <b>Duplicate Attendance
                Process[Monitoring Data]</b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th scope="col">Sl</th>
                            <th scope="col">RML ID</th>
                            <th scope="col">ATTN. DATE</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
                        $deptSQL        = @oci_parse($objConnect, "SELECT RML_ID,ATTN_DATE,count(*) AS TOTAL_COUNT
				                        from RML_HR_ATTN_DAILY_PROC
										where  ATTN_DATE between to_date('01/01/2017','dd/mm/yyyy') and SYSDATE group by RML_ID,ATTN_DATE
										having count(RML_ID)>1
										order by ATTN_DATE");

                        @oci_execute($deptSQL);
                        $number = 0;
                        while ($row = @oci_fetch_assoc($deptSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td><?php echo $number; ?></td>
                                <td><?php echo $row['RML_ID']; ?></td>
                                <td><?php echo $row['ATTN_DATE']; ?></td>
                                <td><?php echo $row['TOTAL_COUNT']; ?></td>
                            </tr>
                            <?php
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Bordered Table -->
    <div class="card card-body mt-2">
        <?php
        if (isset($_POST['key_code'])) {
            $key_code     = $_REQUEST['key_code'];
            $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));

            $synSQL = @oci_parse(
                $objConnect,
                "BEGIN FOR X IN (SELECT RML_ID, ATTN_DATE FROM RML_HR_ATTN_DAILY_PROC WHERE ATTN_DATE BETWEEN TO_DATE ('$v_start_date', 'dd/mm/yyyy') AND TO_DATE ('$v_start_date', 'dd/mm/yyyy')GROUP BY RML_ID, ATTN_DATE HAVING COUNT (RML_ID) > 1) LOOP RML_HR_DUPLICATE_ATTN_DELETE (X.RML_ID, X.ATTN_DATE);END LOOP;END;"
            );
            if (@oci_execute($synSQL)) {
                echo '<div class="alert alert-success" role="alert" style="color:#11d200">
                    Duplicate Data is Deleted Successfully.
                </div>';
            }
        }

        ?>

        <form action="" method="POST">
            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">Security Code:</label>
                        <input required class="form-control" type='text' name='key_code'
                            value='<?php echo isset($_POST['key_code']) ? $_POST['key_code'] : ''; ?>'>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">Select Date</label>
                        <input required="" class="form-control" type='date' name='start_date'
                            value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>'>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary mt-2" type="submit" value="Submit To Process">
                    </div>
                </div>
            </div>
        </form>

    </div>



</div>


<?php require_once ('../../layouts/footer_info.php'); ?>
<?php require_once ('../../layouts/footer.php'); ?>