<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$allDataSQL  = oci_parse(
    $objConnect,
    "SELECT  ID, PMS_NAME, CREATED_BY, START_DATE, IS_ACTIVE,  END_DATE, TABLE_REMARKS, ACHIVEMENT_OPEN_STATUS,STEP_1_STATUS, STEP_2_STATUS, STEP_3_STATUS FROM HR_PMS_LIST WHERE ID =" . $_GET['id']
);

oci_execute($allDataSQL);
$row  = oci_fetch_assoc($allDataSQL);
// print_r($row);
// ECHO $row['ID'];
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Year Edit';
                $rightSideName = 'Year List';
                $routePath     = 'pms_module/view/hr_panel/year.php';
                include('../../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->

                <form method="post" action="<?php echo $basePath ?>/pms_module/action/hr_panel.php">
                    <div class="card-body row">
                        <div class="col-md-6">

                            <input type="hidden" name="actionType" value="year_edit">
                            <input type="hidden" name="editId" value="<?php echo $_GET['id'] ?>">

                            <div class="form-group">
                                <label class="form-label" for="pms_name">PMS Name <span class="text-danger">*</span></label>
                                <input required placeholder="Name here.." value="<?php echo $row['PMS_NAME'] ?>" id="pms_name" name="pms_name" class="form-control cust-control" type='text' />
                            </div>
                            <div class="form-group mt-2">
                                <label class="form-label" for="start_date">Select Start Date <span class="text-danger">*</span></label>
                                <input readonly type="date" name="start_date" class="form-control  cust-control" id="start_date" value="<?php echo date('Y-m-d', strtotime($row['START_DATE'])) ?>">
                            </div>
                            <div class="form-group mt-2">
                                <label class="form-label" for="end_date">Select End Date <span class="text-danger">*</span></label>
                                <input readonly type="date" name="end_date" class="form-control  cust-control" id="end_date" value="<?php echo date('Y-m-d', strtotime($row['END_DATE'])) ?>">
                            </div>



                            <!-- <div class="form-group mt-2">
                                <label class="form-label" for="step_status">Select Step <span class="text-danger">*</span> </label>
                                <select name="step_status" class="form-control  cust-control" required id="step_status">
                                    <option value="0"><- Select Active Step -></option>
                                    <option value="1" <?php echo $row['STEP_1_STATUS'] == 1 ? 'selected' : '' ?>>Step 1</option>
                                    <option value="2" <?php echo $row['STEP_2_STATUS'] == 1 ? 'selected' : '' ?>> Step 2</option>
                                    <option value="3" <?php echo $row['STEP_3_STATUS'] == 1 ? 'selected' : '' ?>> Step 3</option>
                                </select>
                            </div> -->
                            <!-- <div class="form-group mt-2">
                                <label class="form-label" for="status">Select Active Status <span class="text-danger">*</span> </label>
                                <select name="status" class="form-control  cust-control" id="status" required>
                                    <option value="1" <?php echo $row['IS_ACTIVE'] == 1 ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?php echo $row['IS_ACTIVE'] == 0 ? 'selected' : '' ?>> In-active </option>
                                </select>
                                <small id="status" class="form-text text-danger">If you Active This one ? Others PMS will be automatically Deactivated!!</small>
                            </div> -->



                        </div>
                        <div class="col-md-6 mx-auto my-auto">

                            <div class="">
                                <div class="form-group">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                                    <label class="form-check-label" for="gridRadios1">
                                        Step 1 Active
                                    </label>
                                </div>
                                <br>
                                <div class="form-group">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                    <label class="form-check-label" for="gridRadios2">
                                        Step 2 Active
                                    </label>
                                </div>
                                <br>
                                
                                <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
                                    <label class="form-check-label" for="gridRadios3">
                                        Step 3 Active
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="b-block text-center mt-2">

                            <input type="submit" value="Save Data" name="submit" class="btn btn-sm btn-primary">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>

<?php require_once('../../../layouts/footer.php'); ?>