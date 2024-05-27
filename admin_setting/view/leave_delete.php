<?php
require_once ('../../helper/2step_com_conn.php');
require_once ('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">
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
                        <label class="form-label" for="title">EMP ID:</label>
                        <input type="text" placeholder="EX:(RML-1260/RMWL-0942)" name="form_rml_id" class="form-control" id="form_rml_id"
                            value='<?php echo isset($_POST['form_rml_id']) ? $_POST['form_rml_id'] : ''; ?>' />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">Select Leave Type </label>
                        <select name="leave_type" class="form-control">
                            <option selected value=""><-- Select Type --></option>
                            <?php
                            $strSQL = oci_parse($objConnect, "SELECT distinct(LEAVE_TYPE) LEAVE_TYPE from RML_HR_EMP_LEAVE  where LEAVE_TYPE is not null order by LEAVE_TYPE");
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {
                                ?>
                                <option value="<?php echo $row['LEAVE_TYPE']; ?>"><?php echo $row['LEAVE_TYPE']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary mt-2" type="submit" value="Search Data">
                    </div>
                </div>
            </div>
        </form>

    </div>

    <!-- Bordered Table -->
    <div class="card">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i> <b>Leave Delete <b>
        </h5>
        <?php
        if (isset($_POST['submit_approval'])) {//to run PHP script on submit
            if (!empty($_POST['check_list'])) {
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
                    // Keep Deleted Data
                    $strSQLBackup = oci_parse(
                        $objConnect,
                        "begin RML_HR_LEAVE_DELETE('$TT_ID_SELECTTED','$emp_session_id');end;"
                    );

                    @oci_execute($strSQLBackup);

                    // Attendance Process That date
                    $attnProcSQL = oci_parse(
                        $objConnect,
                        "declare V_START_DATE VARCHAR2(100);
                        V_END_DATE VARCHAR2(100);
                        V_RML_ID VARCHAR2(100);
                        begin
                            SELECT TO_CHAR(START_DATE,'dd/mm/yyyy'),TO_CHAR(END_DATE,'dd/mm/yyyy'),RML_ID
                        INTO V_START_DATE,V_END_DATE,V_RML_ID
                        FROM RML_HR_EMP_LEAVE_DELETE
                        WHERE ID='$TT_ID_SELECTTED';
                        RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_START_DATE,'dd/mm/yyyy'),TO_DATE(V_END_DATE,'dd/mm/yyyy'));end;"
                    );

                    @oci_execute($attnProcSQL);
                    echo '<div class="alert alert-success" role="alert" style="color:#11d200">
                        Data is Deleted Successfully.' . $TT_ID_SELECTTED . '
                    </div>';
                }
            }
            else {
                echo 'Sorry! You have not select any ID Code.';
            }
        }
        ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th scope="col">Sl</th>
                            <th scope="col">
                                <center>Select ID</center>
                            </th>
                            <th scope="col">
                                <center>User Info</center>
                            </th>
                            <th scope="col">
                                <center> Others Info</center>
                            </th>
                            <th scope="col">
                                <center>Leave Date</center>
                            </th>
                            <th scope="col">
                                <center>Tour Remarks</center>
                            </th>
                            <th scope="col">
                                <center>Entry Info</center>
                            </th>
                        </tr>
                    </thead>
                    <form action="" method="post">
                        <tbody>
                            <?php

                            if (isset($_POST['form_rml_id'])) {

                                $form_rml_id = $_REQUEST['form_rml_id'];
                                @$leave_type = $_REQUEST['leave_type'];
                                $strSQL = @oci_parse(
                                    $objConnect,
                                    "SELECT a.ID,
                                    b.EMP_NAME,
                                    a.RML_ID,
                                    b.R_CONCERN,
                                    a.ENTRY_DATE,
                                    a.START_DATE,
                                    a.END_DATE,
                                    a.REMARKS,
                                    a.ENTRY_BY,
                                    b.DEPT_NAME,
                                    b.BRANCH_NAME,
                                    b.DESIGNATION,
                                    A.LEAVE_TYPE
                                from RML_HR_EMP_LEAVE a,RML_HR_APPS_USER b
                                where a.RML_ID=b.RML_ID
                                and A.RML_ID='$form_rml_id'
                                and ('$leave_type' IS NULL OR A.LEAVE_TYPE='$leave_type')
                                order by START_DATE desc"
                                );

                                @oci_execute($strSQL);
                                $number = 0;

                                while ($row = @oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td align="center">

                                            <input type="checkbox" name="check_list[]" value="<?php echo $row['ID']; ?>"
                                                style="text-align: center; vertical-align: middle;horiz-align: middle;">
                                        </td>
                                        <td>
                                            <?php
                                            echo '<i style="color:red;"><b>' . $row['RML_ID'] . '</b></i>';
                                            echo ',<br>';
                                            echo $row['EMP_NAME'];
                                            echo ',<br>';
                                            echo $row['R_CONCERN'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo '<b>' . $row['DEPT_NAME'] . '</b>';
                                            echo ',<br>';
                                            echo $row['DESIGNATION'];
                                            echo ',<br>';
                                            echo $row['BRANCH_NAME'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $startDate = new DateTime($row['START_DATE']);
                                            $endDate   = new DateTime($row['END_DATE']);
                                            $interval  = $startDate->diff($endDate);
                                            $days      = $interval->days + 1;

                                            echo '<b>' . $startDate->format('Y-m-d') . '</b>';
                                            echo ',<br>';
                                            echo $endDate->format('Y-m-d');
                                            echo ',<br>';
                                            echo $days . '-Day';
                                            ?>

                                        </td>

                                        <td><?php echo $row['REMARKS']; ?></td>
                                        <td>
                                            <?php
                                            echo '<b>' . $row['ENTRY_BY'] . '</b>';
                                            echo ',<br>';
                                            echo $row['ENTRY_DATE'];
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                } ?>
                                <tr>
                                    <td></td>
                                    <td align="center">
                                        <input class="btn btn-primary btn pull-center" type="submit" name="submit_approval" value="Delete & Save" />
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </form>

                </table>
            </div>
        </div>
    </div>
    <!--/ Bordered Table -->




</div>


<?php require_once ('../../layouts/footer_info.php'); ?>
<?php require_once ('../../layouts/footer.php'); ?>