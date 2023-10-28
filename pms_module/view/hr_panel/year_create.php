<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
if (!checkPermission('pms-hr-year-create')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$basePath =  $_SESSION['basePath'];
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Year Create';
                $rightSideName = 'Year List';
                $routePath     = 'pms_module/view/hr_panel/year.php';
                include('../../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="col-6 ">

                        <form method="post" action="<?php echo $basePath ?>/pms_module/action/hr_panel.php">
                            <input type="hidden" name="actionType" value="year_create">

                            <div class="form-group">
                                <label class="form-label" for="pms_name">PMS Name <span class="text-danger">*</span></label>
                                <input required="" placeholder="Name here.." value="<?php echo isset($_POST['pms_name']) ?>" id="pms_name" name="pms_name" class="form-control cust-control" type='text' />
                            </div>
                            <div class="form-group mt-2">
                                <label class="form-label" for="start_date">Select Start Date <span class="text-danger">*</span></label>
                                <input required="" type="date" name="start_date" class="form-control  cust-control" id="start_date" value="">
                            </div>
                            <div class="form-group mt-2">
                                <label class="form-label" for="end_date">Select End Date <span class="text-danger">*</span></label>
                                <input required="" type="date" name="end_date" class="form-control  cust-control" id="end_date" value="">
                            </div>
                            <!-- <div class="form-group mt-2">
                                <label class="form-label" for="step_status">Select Step <span class="text-danger">*</span> </label>
                                <select name="step_status" class="form-control  cust-control" required id="step_status">
                                    <option value="0" selected><- Select Active Step -></option>
                                    <option value="1">Step 1</option>
                                    <option value="2">Step 2</option>
                                    <option value="3">Step 3</option>
                                </select>
                            </div> -->
                            <div class="form-group mt-2">
                                <label class="form-label" for="status">Select Active Status <span class="text-danger">*</span> </label>
                                <select name="status" class="form-control  cust-control" id="status" required>
                                    <option value="1">Active</option>
                                    <option value="0" selected> Deactive </option>
                                </select>
                                <small id="status" class="form-text text-danger">If you Active This one ? Others PMS will be automatically Deactivated!!</small>
                            </div>

                            <div class="b-block text-right">

                                <input type="submit" value="Save Data" name="submit" class="btn btn-sm btn-primary">

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>

<?php require_once('../../../layouts/footer.php'); ?>