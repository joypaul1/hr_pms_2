<?php
require_once ('../../../helper/3step_com_conn.php');
require_once ('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('pms-hr-approval')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$emp_session_id   = $_SESSION['HR_APPS']['emp_id_hr'];
$v_excel_download = 0;

?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="row justify-content-center">
                <div class="col-4">
                    <label class="form-label" for="title">Select PMS <span class="text-danger">*</span></label>
                    <select required name="HR_PMS_LIST_ID" class="form-control cust-control">
                        <option hidden value=""><-Select PMS -></option>
                        <?php
                        $strSQL = @oci_parse($objConnect, "SELECT  ID,PMS_NAME from HR_PMS_LIST WHERE IS_ACTIVE = 1 ");
                        @oci_execute($strSQL);
                        while ($row = @oci_fetch_assoc($strSQL)) { ?>
                            <option value="<?php echo $row['ID']; ?>" <?php echo (isset($_POST['HR_PMS_LIST_ID']) && $_POST['HR_PMS_LIST_ID'] == $row['ID']) ? 'selected="selected"' : ''; ?>>
                                <?php echo $row['PMS_NAME']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-3">
                    <label class="form-label" for="title">Select Concern</label>
                    <select name="concern_name" class="form-control cust-control">
                        <option hidden value=""><- concern list -></option>
                        <?php

                        $strSQL = oci_parse($objConnect, "SELECT UNIQUE(R_CONCERN) AS R_CONCERN FROM RML_HR_APPS_USER ORDER BY R_CONCERN");
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                            ?>
                            <option value="<?php echo $row['R_CONCERN']; ?>" <?php echo (isset($_POST['concern_name']) && $_POST['concern_name'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>>
                                <?php echo $row['R_CONCERN']; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-2">
                    <label class="form-label" for="title">RML ID</label>
                    <input class="form-control cust-control" type='text' name='rml_id'
                        value='<?php echo isset($_POST['rml_id']) ? $_POST['rml_id'] : ''; ?>'>
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
    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header">
            <i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i>
            <b>Final Grade Report</b>
        </h5>
        <div class="card-body">
            <div class="table-responsive text-break">
                <table class="table table-bordered" id="table">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Concern</th>
                            <th scope="col">Department</th>
                            <th scope="col">DESIGNATION</th>
                            <th scope="col">RATING POINT</th>
                            <th scope="col">SCORE POINT</th>
                            <th scope="col">GRADE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['HR_PMS_LIST_ID'])) {
                            $v_rml_id       = isset($_REQUEST['rml_id']) ? $_REQUEST['rml_id'] : null;
                            $concern_name   = isset($_REQUEST['concern_name']) ? $_REQUEST['concern_name'] : null;
                            $HR_PMS_LIST_ID = $_REQUEST['HR_PMS_LIST_ID'];

                            // Create the base SQL query
                            $sql = "SELECT B.EMP_NAME,B.RML_ID,B.R_CONCERN,B.DEPT_NAME,B.DESIGNATION,A.RATING_POINT,A.SCORE_POINT,A.GRADE,A.HR_PMS_LIST_ID,B.IS_ACTIVE
                            FROM HR_PMS_EMP A, RML_HR_APPS_USER B
                            WHERE A.EMP_ID=B.RML_ID
                            AND A.HR_PMS_LIST_ID='$HR_PMS_LIST_ID'";

                            // Add filters for $concern_name and $v_rml_id if they exist
                            if ($concern_name) {
                                $sql .= " AND B.R_CONCERN = :concern_name";
                            }

                            if ($v_rml_id) {
                                $sql .= " AND B.RML_ID = :rml_id";
                            }

                            $strSQL = oci_parse($objConnect, $sql);

                            // Bind parameters if filters exist
                            if ($concern_name) {
                                oci_bind_by_name($strSQL, ":concern_name", $concern_name);
                            }

                            if ($v_rml_id) {
                                oci_bind_by_name($strSQL, ":rml_id", $v_rml_id);
                            }
                            echo $sql ;
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                                $v_excel_download = 1;
                                ?>
                                <tr>
                                    <td>
                                        <strong>
                                            <?php echo $number; ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <?php echo $row['EMP_NAME'] . '(' . $row['RML_ID'] . ')'; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['R_CONCERN']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['DEPT_NAME']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['DESIGNATION']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['RATING_POINT']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['SCORE_POINT']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['GRADE']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </div>
            <?php
            if ($v_excel_download == 1) {
                ?>
                <div class="text-right mt-2">
                    <a class="btn btn-sm btn-success text-white" id="downloadLink" onclick="exportF(this)" style=""><i class='bx bxs-file-export'></i>
                        Export To Excel</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <!--/ Bordered Table -->



</div>

<!-- / Content -->

<script>
    function exportF(elem) {
        var table = document.getElementById("table");
        table.style.border = "1px solid red";

        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);

        elem.setAttribute("download", "grade_report.xls"); // Choose the file name
        return false;
    }
</script>
<?php require_once ('../../../layouts/footer_info.php'); ?>
<?php require_once ('../../../layouts/footer.php'); ?>