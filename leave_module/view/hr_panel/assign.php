<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('hr-leave-assign')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$v_excel_download = 0;

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body">
        <form action="" method="post">
            <div class="row justify-content-center">
                <div class="col-sm-2">
                    <label class="form-label" for="title">RML ID</label>
                    <div class="input-group">
                        <input class="form-control cust-control" type='text' name='rml_id' value='<?php echo isset($_POST['rml_id']) ? $_POST['rml_id'] : ''; ?>' >
                    </div>
                </div>
                <div class="col-sm-2">
                    <label class="form-label" for="title">Select Company</label>
                    <select name="company_name" class="form-control cust-control">
                        <option selected value="">--</option>
                        <?php

                        $strSQL  = oci_parse($objConnect, "SELECT UNIQUE(R_CONCERN) AS R_CONCERN FROM RML_HR_APPS_USER ORDER BY R_CONCERN");
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                        ?>
                            <option value="<?php echo $row['R_CONCERN']; ?>" <?php echo (isset($_POST['company_name']) && $_POST['company_name'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>><?php echo $row['R_CONCERN']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="form-label" for="title">Select Leave Year</label>
                    <select required="" name="leave_year" class="form-control cust-control">
                        <?php
                        $strSQL  = oci_parse($objConnect, "select YEAR from RML_HR_EMP_LEAVE_PERIOD WHERE IS_ACTIVE=1");
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                        ?>

                            <option value="<?php echo $row['YEAR']; ?>"><?php echo $row['YEAR']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm-2">
                    <label class="form-label" for="title">Select Leave Type</label>
                    <select name="leave_type" class="form-control cust-control">
                        <option selected value="">--</option>
                        <?php
                        $strSQL  = oci_parse($objConnect, "select LEAVE_TITLE,SHORT_NAME  from RML_HR_EMP_LEAVE_NAME 
															order by LEAVE_TITLE");
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                        ?>
                            <option value="<?php echo $row['SHORT_NAME']; ?>"><?php echo $row['LEAVE_TITLE']; ?></option>
                        <?php
                        }
                        ?>
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

    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>Yearly Leave Assign</b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Leave Type</th>
                            <th scope="col">Assign Leave Days</th>
                            <th scope="col">Leave Taken Days</th>
                            <th scope="col">Late to Leave</th>

                            <th scope="col">Company</th>
                            <th scope="col">Department</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Concern</th>
                            <th scope="col">DOJ</th>
                            <th scope="col">Leave Year</th>
                            <th scope="col">Process Date</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['company_name'])) {
                            $v_rml_id = $_REQUEST['rml_id'];
                            $company_name = $_REQUEST['company_name'];
                            $leave_type = $_REQUEST['leave_type'];
                            $leave_year = $_REQUEST['leave_year'];

                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT  RML_ID,
                                     EMP_NAME,
                                     R_CONCERN,
                                     DEPT_NAME,
                                     BRANCH_NAME,
                                     DOJ,
                                     DOC,
                                     LEAVE_TYPE,
                                     LEAVE_ASSIGN,
									 LEAVE_TAKEN,
									 LATE_LEAVE,
                                     DAY_CALCULATION,
                                     LEAVE_PERIOD,
                                     PROCESS_DATE 									 
								FROM LEAVE_DETAILS_INFORMATION B
									 WHERE  ('$v_rml_id' IS NULL OR B.RML_ID='$v_rml_id')
									 AND ('$company_name' IS NULL OR B.R_CONCERN='$company_name')
									 AND  ('$leave_type' IS NULL OR B.LEAVE_TYPE='$leave_type')
									 AND B.LEAVE_PERIOD='$leave_year'
									 ORDER BY B.RML_ID"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                                $v_excel_download = 1;
                        ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php echo $row['EMP_NAME'] . '(' . $row['RML_ID'] . ')'; ?></td>
                                    <td><?php echo $row['LEAVE_TYPE']; ?></td>
                                    <td><?php echo $row['LEAVE_ASSIGN']; ?></td>

                                    <td><?php echo $row['LEAVE_TAKEN']; ?></td>
                                    <td><?php echo $row['LATE_LEAVE']; ?></td>
                                    <td><?php echo $row['R_CONCERN']; ?></td>
                                    <td><?php echo $row['DEPT_NAME']; ?></td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
                                    <td><?php echo $row['R_CONCERN']; ?></td>
                                    <td><?php echo $row['DOJ']; ?></td>
                                    <td><?php echo $row['LEAVE_PERIOD']; ?></td>
                                    <td><?php echo $row['PROCESS_DATE']; ?></td>

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
			    <br>
                <div>
                    <a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export to Excel</a>
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

        elem.setAttribute("download", "EMP_LEAVE_ASSIGN.xls"); // Choose the file name
        return false;
    }
</script>


<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>