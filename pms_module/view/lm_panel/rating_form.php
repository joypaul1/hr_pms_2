<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('self-leave-create')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

//eheck data exit or not exist
$exitSql = oci_parse(
    $objConnect,
    "SELECT * FROM PMS_RATTING_CRITERIA_LM WHERE HR_PMS_EMP_ID =" . $_GET['tab_id'] . " AND HR_PMS_LIST_ID = " . $_GET['key']
);

$exitData = array();
$readonlyMood = false;
 if (oci_execute($exitSql)) {
     $exitData = oci_fetch_assoc($exitSql);
    if($exitData){
        if ($exitData['LM_STATUS'] == 1) {
            $readonlyMood = true;
        }
    }
 }

 $HR_PMS_EMP_ID           = $_GET['tab_id'];
 $HR_PMS_LIST_ID          = $_GET['key'];


?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <form id="Form2" action="" method="post"></form>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">


                <?php
                $leftSideName = 'PMS Rating Create';
                if (checkPermission('self-leave-report')) {
                    $routePath = 'leave_module/view/self_panel/index.php';
                }
                include('../../../layouts/_tableHeader.php');
                ?>
                
                <div class="card-body">
                <div class="shadow-sm p-2 mb-3 text-center text-danger rounded font-weight-bold"><i class='bx bxs-shield-alt-2'></i>[Note : Here You Can Set Min Value 0 and Max Value 10] <i class='bx bxs-shield-alt-2'></i></div>
                    <div class=' card card-body '>
                        <div class="">
                            <form action="<?php echo ($basePath . '/pms_module/action/lm_panel.php'); ?>" method="post">
                                <input type='hidden' name='actionType' value='rating_form'>
                                <input type="hidden" name="tab_id" value="<?php echo $HR_PMS_EMP_ID ?>">
                                <input type="hidden" name="key" value="<?php echo $HR_PMS_LIST_ID ?>">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">JOB KNOWLEDGE</label>
                                    <div class="col-sm-3">
                                        <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                            value="<?php echo $exitData ? $exitData['JOB_KNOWLEDGE'] : 0 ?>" class="form-control" id="basic-default-company"
                                            name="JOB_KNOWLEDGE" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">TRANSPERANCY</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" id="basic-default-company"  
                                            <?php  echo $readonlyMood == true ? "readonly" : '' ?>
                                            name="TRANSPERANCY"
                                            value="<?php echo $exitData ? $exitData['TRANSPERANCY'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">OWNERSHIP CAN DO</label>
                                    <div class="col-sm-3">
                                        <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="OWNERSHIP_CAN_DO"
                                            value="<?php echo $exitData ? $exitData['OWNERSHIP_CAN_DO'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">COMMUNICATION SKILL</label>
                                    <div class="col-sm-3">
                                        <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="COMMUNICATION_SKILL"
                                            value="<?php echo $exitData ? $exitData['COMMUNICATION_SKILL'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">TEAM WORK</label>
                                    <div class="col-sm-3">
                                        <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="TEAM_WORK"
                                            value="<?php echo $exitData ? $exitData['TEAM_WORK'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">CREATIVITY MAKER</label>
                                    <div class="col-sm-3">
                                        <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="CREATIVITY_MAKER"
                                            value="<?php echo $exitData ? $exitData['CREATIVITY_MAKER'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">LEADERSHIP</label>
                                    <div class="col-sm-3">
                                        <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="LEADERSHIP"
                                            value="<?php echo $exitData ? $exitData['LEADERSHIP'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">CUSTOMER RESPONSIBILITY</label>
                                    <div class="col-sm-3">
                                        <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="CUSTOMER_RESPONSIBILITY"
                                            value="<?php echo $exitData ? $exitData['CUSTOMER_RESPONSIBILITY'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">PROBLEM SOLVING</label>
                                    <div class="col-sm-3">
                                        <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="PROBLEM_SOLVING"
                                            value="<?php echo $exitData ? $exitData['PROBLEM_SOLVING'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="basic-default-company">WORK ETHICS</label>
                                    <div class="col-sm-3">
                                        <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="WORK_ETHICS"
                                            value="<?php echo $exitData ? $exitData['WORK_ETHICS'] : 0 ?>" required />
                                    </div>
                                </div>
                                <?php 
                                    if($readonlyMood != true){
                                        echo '<div class="text-center">
                                        <button  type="submit" name="submit_draft" class="btn btn-sm btn-info">Draft <i class="bx bxl-codepen"></i></button>
                                        <button  type="submit" name="submit_confirm" class="btn btn-sm btn-warning">Confirm <i class="bx bx-save" ></i> </button>
                                        </div>';
                                    }
                                ?>
                        
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>



</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>

<?php require_once('../../../layouts/footer.php'); ?>
<script>
    $(function () {
        $(document).on('input', "input[type='number']", function (event) {

            var value = parseInt(this.value, 10);
            var max = parseInt(10);
            var min = parseInt(0);
            if (value > max) {
                this.value = max;
            } else if (value < min) {
                this.value = min
            }
        });

    });
</script>