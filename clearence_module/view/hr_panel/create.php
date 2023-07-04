<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body col-lg-12 ">
        <div class='card-title'>
            <div href="#" style="font-size: 18px;font-weight:700">
                <i class="menu-icon tf-icons bx bx-message-alt-add" style="margin:0;font-size:20px"></i>Clearence Create
            </div>
        </div>
        <form action="<?php echo ($basePath . '/clearence_module/action/hr_panel.php'); ?>" method="post">
            <input type='hidden' hidden name='actionType' value='create'>
            <div class="row justify-content-center">
                <div class="col-sm-3">
                    <label for="exampleInputEmail1">Emp. ID:</label>
                    <input required class="form-control cust-control" id="date" name="emp_id" type="text" />
                </div>
                <div class="col-sm-3">
                    <label for="title">Select Concern</label>
                    <select name="concern_id" class="form-control cust-control text-center" required>
                        <option hidden value=""><-- Select Concern --></option>
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


                <div style="
                        border: 1px solid #eee5e5;
                        padding: 2%;
                        box-shadow: 1px 1px 1px 1px lightgray;
                        margin: 2%;
                    ">
                    <h5 class="text-center"> Select Department <span style="font-size: 12px;"> </h5>
                    <?php
                    $departmentArray = [];
                    $strSQL  = oci_parse($objConnect, "SELECT ID, DEPT_NAME FROM DEVELOPERS.RML_HR_DEPARTMENT where IS_ACTIVE=1");
                    oci_execute($strSQL);
                    while ($row = oci_fetch_assoc($strSQL)) {
                        echo ('
                            <div class="form-check-inline col-4">
                                <input type="checkbox" class="form-check-input"  value="' . $row['ID'] . '" name="department_id[]"' . (isset($_POST['department_id']) && $_POST['department_id'] == $row['ID'] ? "checked" : "") . '
                                id="check_' . $row['ID'] . '">
                                <label class="form-check-label" for="check_' . $row['ID'] . '">' . $row['DEPT_NAME'] . '</label>
                            </div>
                            ');
                    }

                    ?>



                </div>
                <div class="col-sm-2">
                    <div class="md-form mt-4">
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Submit to Create">
                    </div>
                </div>

            </div>



        </form>
    </div>



</div>

<!-- / Content -->


<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>