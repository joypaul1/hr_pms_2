<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('pms-hod-report')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

//eheck data exit or not exist
$exitSql = oci_parse(
    $objConnect,
    "SELECT * FROM PMS_RATTING_CRITERIA_LM WHERE HR_PMS_EMP_ID =" . $_GET['tab_id'] . " AND HR_PMS_LIST_ID = " . $_GET['key']
);


$exitData = array();
if (oci_execute($exitSql)) {
    $exitData = oci_fetch_assoc($exitSql);
}

$exitSql_2 = oci_parse(
    $objConnect,
    "SELECT * FROM PMS_RATTING_CRITERIA_HOD WHERE HR_PMS_EMP_ID =" . $_GET['tab_id'] . " AND HR_PMS_LIST_ID = " . $_GET['key']
);

$exitData_2   = array();
$readonlyMood = false;
if (oci_execute($exitSql_2)) {
    $exitData_2 = oci_fetch_assoc($exitSql_2);
    if ($exitData_2) {
        if ($exitData_2['HOD_STATUS'] == 1) {
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

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="">
            <div class="card mb-4">

                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <!-- <div class="shadow-sm p-2 mb-1 text-center text-danger rounded font-weight-bold"><i class='bx bxs-shield-alt-2'></i>[Note
                                : Here You Can Set Min Value 0 and Max Value 10] <i class='bx bxs-shield-alt-2'></i></div> -->
                            <div class='card card-body '>
                                <div class="shadow-sm p-2 mt-3 mb-1 text-center text-white rounded font-weight-bold" style="background: #0e024efa;">Line Manger RATING <i
                                        class="bx bx-star text-success"></i></div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="KNOWLEDGE">JOB KNOWLEDGE </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['JOB_KNOWLEDGE'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="TRANSPERANCY">TRANSPERANCY </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['TRANSPERANCY'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="OWNERSHIP_CAN_DO">OWNERSHIP CAN DO </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['OWNERSHIP_CAN_DO'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="COMMUNICATION_SKILL"> COMMUNICATION SKILL </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['COMMUNICATION_SKILL'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="TEAM_WORK">TEAM WORK </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['TEAM_WORK'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="CREATIVITY_MAKER">CREATIVITY MAKER </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['CREATIVITY_MAKER'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="LEADERSHIP">LEADERSHIP </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['LEADERSHIP'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="CUSTOMER_RESPONSIBILITY">CUSTOMER RESPONSIBILITY </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['CUSTOMER_RESPONSIBILITY'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="PROBLEM_SOLVING">PROBLEM SOLVING </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['PROBLEM_SOLVING'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>
                                    <div class="col-sm-6 col-md-3  col-lg-3 ">
                                        <label for="WORK_ETHICS">WORK ETHICS </label>
                                        <input type="number" readonly value="<?php echo $exitData ? $exitData['WORK_ETHICS'] : 0 ?>"
                                            class="form-control cust-control" />
                                    </div>

                                </div>
                                <div class="shadow-sm p-2 mt-3 mb-1 text-center text-white rounded font-weight-bold" style="background: #0e024efa;">
                                    Head Of Department RATING <i class="bx bxs-hand-down text-info"></i></div>

                                <div class="mt-3">
                                    <form action="<?php echo ($basePath . '/pms_module/action/hod_panel.php'); ?>" method="post" id="ratingForm">
                                        <input type='hidden' name='actionType' value='rating_form'>
                                        <input type="hidden" name="tab_id" value="<?php echo $HR_PMS_EMP_ID ?>">
                                        <input type="hidden" name="key" value="<?php echo $HR_PMS_LIST_ID ?>">
                                        <input type="hidden" name="emp_id" value="<?php echo $EMP_ID ?>">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="KNOWLEDGE">JOB KNOWLEDGE </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['JOB_KNOWLEDGE'] : $exitData['JOB_KNOWLEDGE'] ?>"
                                                    class="form-control cust-control" id="KNOWLEDGE" name="JOB_KNOWLEDGE" required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="TRANSPERANCY">TRANSPERANCY </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['TRANSPERANCY'] : $exitData['TRANSPERANCY'] ?>"
                                                    class="form-control cust-control" id="TRANSPERANCY" name="TRANSPERANCY" required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="OWNERSHIP_CAN_DO">OWNERSHIP CAN DO </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['OWNERSHIP_CAN_DO'] : $exitData['OWNERSHIP_CAN_DO'] ?>"
                                                    class="form-control cust-control" id="OWNERSHIP_CAN_DO" name="OWNERSHIP_CAN_DO" required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="COMMUNICATION_SKILL"> COMMUNICATION SKILL </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['COMMUNICATION_SKILL'] : 0 ?>"
                                                    class="form-control cust-control" id="COMMUNICATION_SKILL" name="COMMUNICATION_SKILL" required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="TEAM_WORK">TEAM WORK </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['TEAM_WORK'] : $exitData['TEAM_WORK'] ?>"
                                                    class="form-control cust-control" id="TEAM_WORK" name="TEAM_WORK" required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="CREATIVITY_MAKER"> CREATIVITY MAKER </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData ? $exitData['CREATIVITY_MAKER'] : 0 ?>"
                                                    class="form-control cust-control" id="CREATIVITY_MAKER" name="CREATIVITY_MAKER" required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="LEADERSHIP"> LEADERSHIP </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['LEADERSHIP'] : $exitData['LEADERSHIP'] ?>"
                                                    class="form-control cust-control" id="LEADERSHIP" name="LEADERSHIP" required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="CUSTOMER_RESPONSIBILITY">CUSTOMER RESPONSIBILITY </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['CUSTOMER_RESPONSIBILITY'] : $exitData['CUSTOMER_RESPONSIBILITY'] ?>"
                                                    class="form-control cust-control" id="CUSTOMER_RESPONSIBILITY" name="CUSTOMER_RESPONSIBILITY"
                                                    required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="PROBLEM_SOLVING">PROBLEM SOLVING </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['PROBLEM_SOLVING'] : $exitData['PROBLEM_SOLVING'] ?>"
                                                    class="form-control cust-control" id="PROBLEM_SOLVING" name="PROBLEM_SOLVING" required />
                                            </div>
                                            <div class="col-sm-6 col-md-3  col-lg-3 ">
                                                <label for="WORK_ETHICS">WORK ETHICS </label>
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['WORK_ETHICS'] : $exitData['WORK_ETHICS'] ?>"
                                                    class="form-control cust-control" id="WORK_ETHICS" name="WORK_ETHICS" required />
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
                                <div class="row ">

                                    <div class="col-12">
                                        <div class="shadow-sm p-2 mt-3 mb-1 text-center text-white rounded font-weight-bold"
                                            style="background: #0e024efa;">
                                            <i class='bx bxs-shield-alt-2'></i>[Note : Here You Can Set Achivement Rating Value] <i
                                                class='bx bxs-shield-alt-2'></i>
                                        </div>
                                    </div>

                                            <div class="col-12">

                                                    <div class='card card-body '>

                                                    <div class=" d-flex text-center">
                                                <div class="col-2">
                                                    <u> <strong>KRA Name</strong></u>
                                                </div>
                                                <div class="col-2">
                                                    <u> <strong>KPI Name</strong></u>
                                                </div>
                                                <div class="col-1">
                                                    <u> <strong>T</strong></u>
                                                </div>
                                                <div class="col-1">
                                                    <u> <strong>TW</strong></u>
                                                </div>
                                                <div class="col-2">
                                                    <u><strong>Ach. Comment</strong></u>
                                                </div>
                                                <div class="col-2">
                                                    <u><strong>Achivement</strong></u>
                                                </div>
                                                <div class="col-1">
                                                    <u><strong>AW</strong></u>
                                                </div>
                                                <div class="col-1">
                                                    <u><strong>Score</strong></u>
                                                </div>

                                            </div>
                                            <form action="<?php echo ($basePath . '/pms_module/action/hod_panel.php'); ?>" method="post"
                                                class=" justify-content-center" id="scoreForm">
                                                <input type="hidden" name="actionType" value="kpi_achivement">
                                                <input type="hidden" name="tab_id" value="<?php echo $_GET['tab_id'] ?>">
                                                <input type="hidden" name="key" value="<?php echo $_GET['key'] ?>">
                                                <input type="hidden" name="emp_id" value="<?php echo $_GET['emp_id'] ?>">
                                                <?php
                                                $locakSataus = false;

                                                $KRASQL = oci_parse(
                                                    $objConnect,
                                                    "SELECT  * FROM HR_PMS_KRA_LIST  WHERE CREATED_BY = '$EMP_ID' AND HR_PMS_LIST_ID = '$HR_PMS_LIST_ID'"
                                                );
                                                oci_execute($KRASQL);
                                                $number = 0;
                                                while ($kraRow = oci_fetch_assoc($KRASQL)) {
                                                    $table_ID = $kraRow['ID'];

                                                    $strSQLInner = oci_parse($objConnect, "SELECT ID,TARGET,KPI_NAME,ACHIVEMENT, ACHIVEMENT_COMMENTS,WEIGHTAGE,ACHIEVEMENT_LOCK_STATUS FROM HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                                    oci_execute($strSQLInner);
                                                    while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                                        $achivement      = $rowIN['ACHIVEMENT'] ? $rowIN['ACHIVEMENT'] : 0;
                                                        $targetWeightage = $rowIN['WEIGHTAGE'] ? $rowIN['WEIGHTAGE'] : 0;
                                                        $target          = 100;
                                                        $awValue         = ($achivement / $target) * 100;
                                                        $score           = ($targetWeightage * $awValue) / 100;
                                                        if($rowIN['ACHIEVEMENT_LOCK_STATUS'] == 1){
                                                            $locakSataus = true;
                                                        }
                                                        ?>

                                            <div class="row mb-2">
                                                <div class="col-2">
                                                    <textarea type="text"  disabled class="form-control "
                                                        placeholder="kpi name"> <?php echo trim($kraRow['KRA_NAME']); ?> </textarea>
                                                </div>
                                                <div class="col-2">
                                                    <textarea type="text" disabled class="form-control "
                                                        placeholder="kpi name"><?php echo trim($rowIN['KPI_NAME']); ?> </textarea>
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
                                                    <textarea type="text" name="ACHIVEMENT_COMMENTS[<?php echo $rowIN['ID']; ?>]"
                                                        <?php if( $locakSataus){ 
                                                            echo 'readonly';
                                                        }?>
                                                      
                                                        class="form-control" required  placeholder="ACH. COMMENTS"> <?php echo $rowIN['ACHIVEMENT_COMMENTS']?trim($rowIN['ACHIVEMENT_COMMENTS']):''; ?> </textarea>
                                                </div>
                                                <div class="col-2">
                                                    <input type="number" name="achivement[<?php echo $rowIN['ID']; ?>]"
                                                        <?php if( $locakSataus){ 
                                                            echo 'readonly';
                                                        }?>
                                                        value="<?php echo $rowIN['ACHIVEMENT']?$rowIN['ACHIVEMENT']:0; ?>"
                                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                        class="form-control text-center achivement" max="100" min='0' required  placeholder="target achivement">
                                                </div>
                                              
                                                
                                                <div class="col-1">
                                                    <input type="text" readonly onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                        class="form-control text-center achivementWeightage" value="<?php echo $awValue ?>"
                                                        placeholder="achivement weight">
                                                </div>
                                                <div class="col-1">
                                                    <input type="text" value="<?php echo $score ?>" readonly
                                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                        class="form-control text-center score" placeholder="score">
                                                </div>


                                            </div>



                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <div class="col-sm-12 d-flex justify-content-end mt-0">
                                                    <strong class="d-flex justify-content-end gap-2  align-items-center">
                                                        <span style="color:chocolate">Total Score :</span>
                                                        <input type="number" disabled
                                                            style="width: 40%;height: 32px;text-align: center;background: lightgreen;"
                                                            value="<?php echo 0 ?>" class="form-control" id="totalScore" />
                                                    </strong>
                                                </div>
                                               
                                                <?php

                                                    if ($locakSataus != true) {
                                                        echo '<div class="text-center mt-2">
                                                                <button  type="submit" name="submit_draft" class="btn btn-sm btn-info">Draft <i class="bx bxl-codepen"></i></button>
                                                                <button  type="submit" name="submit_confirm" class="btn btn-sm btn-warning">Confirm <i class="bx bx-save" ></i> </button>
                                                                </div>';
                                                    }
                                                    else {
                                                        echo "<span class='d-block text-center font-weight-bold mt-2'>All Ready Comfirmed <i class='bx bxs-home-smile text-success'></i></span>";
                                                    }
                                                ?>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="shadow-sm p-2 mt-3 mb-1 text-center text-white rounded font-weight-bold" style="background: #0e024efa;"><i
                                                class='bx bxs-shield-alt-2'></i>[Grading Making Generate System ] <i class='bx bxs-shield-alt-2'></i>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <form action="#" method="post" class="justify-content-center">
                                            <div class="card card-body ">
                                                <div class="row mb-2 text-center">
                                                    <div class="col-3">
                                                        <label for="" class="font-weight-bold">Rating Point ( 20 %) </label>
                                                        <input type="text" value="" readonly class="form-control text-center gradeRating">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="font-weight-bold">Score ( 80 %) </label>
                                                        <input type="text" value="" readonly class="form-control text-center gradeScore">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="font-weight-bold">Total Point </label>
                                                        <input type="text" readonly="" class="form-control text-center totalPoint" value="100"
                                                            placeholder="target">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="font-weight-bold"> Mark </label>
                                                        <input type="text" readonly="" class="form-control text-center totalMark" value="A"
                                                            placeholder="target">
                                                    </div>



                                                </div>
                                                <!-- <div class="text-center">
                                                    <button type="submit" name="submit_confirm" class="btn btn-sm btn-info">Confirm <i
                                                            class="bx bx-save"></i> </button> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-6">
                                        <div class="card card-body mt-3">
                                            <strong class="text-center">Grading System</strong>
                                            <table class="table table-bordered tex-center text-break">
                                                <thead style="background: beige;">
                                                    <tr class="text-center">
                                                        <th>Achivement</th>
                                                        <th>Grade</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class='text-center'>
                                                    <tr>
                                                        <td> 100% - Up</td>
                                                        <td>O</td>
                                                        <td>OUTSTADING</td>
                                                    </tr>
                                                    <tr>
                                                        <td>90% - 99%</td>
                                                        <td>E</td>
                                                        <td>EXCELLNT</td>
                                                    </tr>
                                                    <tr>
                                                        <td>80% - 89%</td>
                                                        <td>G</td>
                                                        <td>GOOD</td>
                                                    </tr>
                                                    <tr>
                                                        <td>70% - 79%</td>
                                                        <td>A</td>
                                                        <td>AVERAGE</td>
                                                    </tr>
                                                    <tr>
                                                        <td>61% - 69%</td>
                                                        <td>U</td>
                                                        <td>UNSATISFATORY</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Up - 60 %</td>
                                                        <td>I</td>
                                                        <td>INCOMPETENT</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
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

    $(function () {
        let totalRating = 0;
        ratingCalculation();
        scoreCalculation();
        pointCalculaiton();
    });

    $(document).on('change input', "form#ratingForm input[type='number']", function (event) {
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
    $(document).on('change input', "form#scoreForm input[type='number']", function (event) {

        var value = parseInt(this.value, 10);
        var max = parseInt(100);
        var min = parseInt(0);
        if (value > max) {
            this.value = max;
        } else if (value < min) {
            this.value = min;
        }
        scoreCalculation();


    });
    $(document).on('change input', '.achivement', function () {
        console.log(213123);
        $achivement = $(this).val() || 0;
        $target = $(this).parent().parent('.row').find('.target').val();
        $targetWeightage = $(this).parent().parent('.row').find('.targetWeightage').val();
        $achivementWeightage = ($achivement / $target) * 100;
        $(this).parent().parent('.row').find('.achivementWeightage').val($achivementWeightage);
        $(this).parent().parent('.row').find('.score').val(($achivementWeightage * $targetWeightage) / 100);
        scoreCalculation();

    });

    function scoreCalculation() {
        console.log(213123);
        let totalScore = 0;
        let oldScore = $('#totalScore').val();
        $("form#scoreForm .score").each(function () {
            var rating = Number($(this).val());
            console.log(rating);
            totalScore += rating;
        });
        $('#totalScore').val(totalScore);
        pointCalculaiton();
    }

    function ratingCalculation() {
        let totalRating = 0;
        let oldRating = $('#totalRating').val();
        totalRating -= oldRating;
        $("form#ratingForm input[type='number']").each(function () {
            var rating = Number($(this).val());
            totalRating += rating;
        });
        $('#totalRating').val(totalRating);
        pointCalculaiton();
    }
    function pointCalculaiton() {
        let totalRating = $("#totalRating").val() || 0;
        let totalScore = $("#totalScore").val() || 0;
        let actualRating = parseFloat(parseFloat(totalRating / 100) * 20);
        let actualScore = parseFloat(parseFloat(totalScore / 100) * 80);
        let totalPoints = parseFloat(actualRating + actualScore);
        gradeMarking(totalPoints);
        $('.gradeRating').val((actualRating).toFixed(2));
        $('.gradeScore').val((actualScore).toFixed(2));
        $('.totalPoint').val(Math.round(totalPoints).toFixed(2));

    }

    function gradeMarking(totalPoints) {
        totalPoints = Math.round(totalPoints);
        let finalGrade = 'N/A';

        if (totalPoints >= 100) {
            finalGrade = 'O';
        } else if (totalPoints >= 90) {
            finalGrade = 'E';
        } else if (totalPoints >= 80) {
            finalGrade = 'G';
        } else if (totalPoints >= 70) {
            finalGrade = 'A';
        } else if (totalPoints >= 61) {
            finalGrade = 'U';
        } else if (totalPoints <= 60) {
            finalGrade = 'I';
        }

        $('.totalMark').val(finalGrade);
    }


</script>