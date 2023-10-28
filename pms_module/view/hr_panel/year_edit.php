<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
if (!checkPermission('pms-hr-year-edit')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$query = "SELECT  ID, PMS_NAME, CREATED_BY, START_DATE, IS_ACTIVE,  END_DATE, TABLE_REMARKS, ACHIVEMENT_OPEN_STATUS,STEP_1_STATUS, STEP_2_STATUS, STEP_3_STATUS FROM HR_PMS_LIST WHERE ID =" . $_GET['id'];
$allDataSQL  = oci_parse($objConnect, $query);

oci_execute($allDataSQL);
$row  = oci_fetch_assoc($allDataSQL);

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




                            <div class="form-group mt-2">
                                <label class="form-label" for="status">Change PMS Active Status ? <span class="text-danger">*</span> </label>
                                <select name="status" class="form-control  cust-control" id="status" required>
                                    <option value="1" <?php echo $row['IS_ACTIVE'] == 1 ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?php echo $row['IS_ACTIVE'] == 0 ? 'selected' : '' ?>>Deactive </option>
                                </select>
                                <small id="status" class="form-text text-danger">If you Active This one ? Others PMS will be automatically Deactivated!!</small>
                            </div>



                        </div>



                        <div class="col-md-3 mx-auto my-auto">

                            <div class="">
                                <div class="form-group">
                                    <label for="step_status_1">1. Step 1 Status</label>
                                    <select class="form-control" name="step_status_1" id="step_status_1">
                                        <option <?php echo $row['STEP_1_STATUS'] == '0' ? 'disabled' : ''  ?>><- Select Option -></option>
                                        <option  <?php echo $row['STEP_1_STATUS'] == '0' ? 'disabled' : ''  ?> <?php echo $row['STEP_1_STATUS'] == '' ? 'Selected' : ''  ?> value=" ">Deactive </option>
                                        <option  <?php echo $row['STEP_1_STATUS'] == '0' ? 'disabled' : ''  ?> <?php echo $row['STEP_1_STATUS'] == '1' ? 'Selected' : ''  ?> value="1"> Active </option>
                                        <option <?php echo $row['STEP_1_STATUS'] == '0' ? 'Selected' : '' ?> value="0"> Step Done </option>

                                    </select>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="step_status_2">2. Step 2 Status</label><br>
                                    <?php if ($row['STEP_1_STATUS'] == '0') { ?>
                                        <select class="form-control" name="step_status_2" id="step_status_2">
                                            <option <?php echo $row['STEP_2_STATUS'] == '0' ? 'disabled' : ''  ?>><- Select Option -></option>
                                            <option <?php echo $row['STEP_2_STATUS'] == '0' ? 'disabled' : ''  ?> <?php echo $row['STEP_2_STATUS'] == '' ? 'Selected' : ''  ?> value=" ">Deactive </option>
                                            <option <?php echo $row['STEP_2_STATUS'] == '0' ? 'disabled' : ''  ?> <?php echo $row['STEP_2_STATUS'] == '1' ? 'Selected' : ''  ?> value="1"> Active </option>
                                            <option <?php echo $row['STEP_2_STATUS'] == '0'  ? 'Selected' : '' ?> value="0"> Step Done </option>

                                        </select>
                                    <?php } else {
                                        echo "<span class='text-info'>Waiting For Step 1 Done. </span></span>";
                                    } ?>
                                </div>  
                                <br>
                                <div class="form-group">
                                    <label for="step_status_3">3. Step 3 Status</label>
                                    <?php if ($row['STEP_2_STATUS'] == '0' &&  $row['STEP_1_STATUS'] == '0') { ?>
                                        <select class="form-control" name="step_status_3" id="step_status_3" >
                                            <option <?php echo $row['STEP_3_STATUS'] == '0' ? 'disabled' : ''  ?>><- Select Option -></option>
                                            <option  <?php echo $row['STEP_3_STATUS'] == '0' ? 'disabled' : ''  ?> <?php echo $row['STEP_3_STATUS'] == '' ? 'Selected' : ''  ?> value=" ">Deactive </option>
                                            <option  <?php echo $row['STEP_3_STATUS'] == '0' ? 'disabled' : ''  ?> <?php echo $row['STEP_3_STATUS'] == '1' ? 'Selected' : ''  ?> value="1"> Active </option>
                                            <option <?php echo $row['STEP_3_STATUS'] == '0'  ? 'Selected' : '' ?> value="0"> Step Done </option>

                                        </select>
                                    <?php } else {
                                        echo "<br> <span class='text-info'>Waiting For Step 2 Done. </span></span>";
                                    } ?>
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

<script>
    // alert(213);
    $(document).on('click', "input[name='step_status_1']", function(e) {
        if ($(this).is(':checked')) {
            $(this).val(1);

        } else {
            $(this).val(0);

        }
        console.log($(this).val())
    })
    $(document).on('click', "input[name='step_status_2']", function(e) {
        if ($(this).is(':checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);

        }
    })
    $(document).on('click', "input[name='step_status_3']", function(e) {
        if ($(this).is(':checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);

        }
    })
</script>