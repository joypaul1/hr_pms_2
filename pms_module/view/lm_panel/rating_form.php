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

$exitData     = array();
$readonlyMood = false;
if (oci_execute($exitSql)) {
    $exitData = oci_fetch_assoc($exitSql);
    if ($exitData) {
        if ($exitData['LM_STATUS'] == 1) {
            $readonlyMood = true;
        }
    }
}

$HR_PMS_EMP_ID  = $_GET['tab_id'];
$HR_PMS_LIST_ID = $_GET['key'];
$EMP_ID         = $_GET['emp_id'];


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
                // $leftSideName = 'PMS Rating Create';
                // if (checkPermission('self-leave-report')) {
                //     $routePath = 'leave_module/view/self_panel/index.php';
                // }
                // include('../../../layouts/_tableHeader.php');
                ?>

                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="shadow-sm p-2 mb-1 text-center text-danger rounded font-weight-bold"><i class='bx bxs-shield-alt-2'></i>[Note
                                : Here You Can Set Min Value 0 and Max Value 10] <i class='bx bxs-shield-alt-2'></i></div>
                            <div class='card card-body '>

                                <form action="<?php echo ($basePath . '/pms_module/action/lm_panel.php'); ?>" method="post" id="ratingForm">
                                    <input type='hidden' name='actionType' value='rating_form'>
                                    <input type="hidden" name="tab_id" value="<?php echo $HR_PMS_EMP_ID ?>">
                                    <input type="hidden" name="key" value="<?php echo $HR_PMS_LIST_ID ?>">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="KNOWLEDGE">JOB KNOWLEDGE </label>
                                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                value="<?php echo $exitData ? $exitData['JOB_KNOWLEDGE'] : 0 ?>" class="form-control cust-control"
                                                id="KNOWLEDGE" name="JOB_KNOWLEDGE" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="TRANSPERANCY">TRANSPERANCY </label>
                                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                value="<?php echo $exitData ? $exitData['TRANSPERANCY'] : 0 ?>" class="form-control cust-control"
                                                id="TRANSPERANCY" name="TRANSPERANCY" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="OWNERSHIP_CAN_DO">OWNERSHIP CAN DO </label>
                                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                value="<?php echo $exitData ? $exitData['OWNERSHIP_CAN_DO'] : 0 ?>" class="form-control cust-control"
                                                id="OWNERSHIP_CAN_DO" name="OWNERSHIP_CAN_DO" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="TEAM_WORK">TEAM WORK </label>
                                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                value="<?php echo $exitData ? $exitData['TEAM_WORK'] : 0 ?>" class="form-control cust-control"
                                                id="TEAM_WORK" name="TEAM_WORK" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="LEADERSHIP">LEADERSHIP </label>
                                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                value="<?php echo $exitData ? $exitData['LEADERSHIP'] : 0 ?>" class="form-control cust-control"
                                                id="LEADERSHIP" name="LEADERSHIP" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="CUSTOMER_RESPONSIBILITY">CUSTOMER RESPONSIBILITY </label>
                                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                value="<?php echo $exitData ? $exitData['CUSTOMER_RESPONSIBILITY'] : 0 ?>"
                                                class="form-control cust-control" id="CUSTOMER_RESPONSIBILITY" name="CUSTOMER_RESPONSIBILITY"
                                                required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="PROBLEM_SOLVING">PROBLEM SOLVING </label>
                                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                value="<?php echo $exitData ? $exitData['PROBLEM_SOLVING'] : 0 ?>" class="form-control cust-control"
                                                id="PROBLEM_SOLVING" name="PROBLEM_SOLVING" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="WORK_ETHICS">PROBLEM SOLVING </label>
                                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                value="<?php echo $exitData ? $exitData['WORK_ETHICS'] : 0 ?>" class="form-control cust-control"
                                                id="WORK_ETHICS" name="WORK_ETHICS" required />
                                        </div>
                                        <div class="col-sm-12 d-flex justify-content-end mt-2">
                                            <strong class="d-flex justify-content-end gap-2  align-items-center">
                                                <span style="color:chocolate">Total Rating Point :</span>
                                                <input type="number" disabled
                                                    style="width: 40%;height: 32px;text-align: center;background: lightgreen;"
                                                    value="<?php echo 0 ?>" class="form-control" id="totalRating" />
                                            </strong>
                                        </div>
                                    </div>


                                    <?php

                                    if ($readonlyMood != true) {
                                        echo '<div class="text-center mt-2">
                                                <button  type="submit" name="submit_draft" class="btn btn-sm btn-info">Draft <i class="bx bxl-codepen"></i></button>
                                                <button  type="submit" name="submit_confirm" class="btn btn-sm btn-warning">Confirm <i class="bx bx-save" ></i> </button>
                                                </div>';
                                    }
                                    else {
                                        echo "<span class='d-block text-center font-weight-bold mt-2'>All Ready Comfirmed Rating <i class='bx bxs-home-smile text-success'></i></span>";
                                    }
                                    ?>
                                </form>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="shadow-sm p-2 mb-1 text-center text-info rounded font-weight-bold"><i class='bx bxs-shield-alt-2'></i>[Note :
                                Here You Can Set Achivement Rating (Min Value 0 and Max Value 100) ] <i class='bx bxs-shield-alt-2'></i></div>
                            <div class='card card-body '>


                                <div class=" d-flex text-center">
                                    <div class="col-4">
                                        <u> <strong>KPI Name</strong></u>
                                    </div>
                                    <div class="col-1">
                                        <u> <strong>T</strong></u>
                                    </div>
                                    <div class="col-1">
                                        <u> <strong>TW</strong></u>
                                    </div>
                                    <div class="col-2">
                                        <u><strong>A</strong></u>
                                    </div>
                                    <div class="col-2">
                                        <u><strong>AW</strong></u>
                                    </div>
                                    <div class="col-2">
                                        <u><strong>Score</strong></u>
                                    </div>

                                </div>
                                <form action="<?php echo ($basePath . '/pms_module/action/lm_panel.php'); ?>" method="post"
                                    class="justify-content-center">
                                    <input type="hidden" name="actionType" value="kpi_achivement">
                                    <input type="hidden" name="tab_id" value="<?php echo $_GET['tab_id'] ?>">
                                    <input type="hidden" name="key" value="<?php echo $_GET['key'] ?>">
                                    <input type="hidden" name="emp_id" value="<?php echo $_GET['emp_id'] ?>">
                                    <?php
                                    $KRASQL = oci_parse(
                                        $objConnect,
                                        "SELECT  * FROM HR_PMS_KRA_LIST  WHERE CREATED_BY = '$EMP_ID' AND HR_PMS_LIST_ID = '$HR_PMS_LIST_ID'"
                                    );
                                    oci_execute($KRASQL);
                                    $number = 0;
                                    while ($kraRow = oci_fetch_assoc($KRASQL)) {
                                        $table_ID = $kraRow['ID'];

                                        $strSQLInner = oci_parse($objConnect, "SELECT ID,TARGET,KPI_NAME,ACHIVEMENT, WEIGHTAGE FROM HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $achivement      = $rowIN['ACHIVEMENT'] ? $rowIN['ACHIVEMENT'] : 0;
                                            $targetWeightage = $rowIN['WEIGHTAGE'] ? $rowIN['WEIGHTAGE'] : 0;
                                            $target          = 100;
                                            $awValue         = ($achivement / $target) * 100;
                                            $score           = ($targetWeightage * $awValue) / 100;
                                            ?>

                                            <div class="row mb-2">
                                                <div class="col-4">
                                                    <input type="text" value="<?php echo $rowIN['KPI_NAME']; ?>" disabled class="form-control text-center "
                                                        placeholder="kpi name">
                                                </div>
                                                <div class="col-1">
                                                    <input type="text" disabled class="form-control text-center target"
                                                        value="<?php echo $rowIN['TARGET']; ?>" placeholder="target">
                                                </div>
                                                <div class="col-1">
                                                    <input type="text" disabled class="form-control text-center targetWeightage"
                                                        value="<?php echo $rowIN['WEIGHTAGE']; ?>" placeholder="WEIGHTAGE">
                                                </div>
                                                <div class="col-2">
                                                    <input type="text" name="achivement[<?php echo $rowIN['ID']; ?>]"
                                                        value="<?php echo $rowIN['ACHIVEMENT']; ?>"
                                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                        class="form-control text-center achivement" placeholder="target achivement">
                                                </div>
                                                <div class="col-2">
                                                    <input type="text" readonly onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                        class="form-control text-center achivementWeightage" value="<?php echo $awValue ?>"
                                                        placeholder="achivement weight">
                                                </div>
                                                <div class="col-2">
                                                    <input type="text" value="<?php echo $score ?>" readonly
                                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                        class="form-control text-center score" placeholder="score">
                                                </div>


                                            </div>
                                            
                                        <?php
                                        }
                                    }

                                    // ddd


                                    echo '<div class="text-center">
                                            <button  type="submit" name="submit_confirm" class="btn btn-sm btn-warning">Confirm <i class="bx bx-save" ></i> </button>
                                            </div>';


                                    ?>

                                </form>
                            </div>
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
     let totalRating = 0;
    $(function () {
        ratingCalculation();
       
    });
    $(document).on('input', "form#ratingForm input[type='number']", function (event) {

        var value = parseInt(this.value, 10);
        var max = parseInt(10);
        var min = parseInt(0);
        if (value > max) {
            this.value = max;
        } else if (value < min) {
            this.value = min
        }
        ratingCalculation();
    });

    function ratingCalculation(){
        $("form#ratingForm input[type='number']").each(function(){
            var rating = Number($(this).val()); 
            totalRating += rating;
        });
        $('#totalRating').val(totalRating);
    }
</script>