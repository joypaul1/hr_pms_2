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
    $exitData = oci_fetch_row($exitSql);
    print_r($exitData);
    // if ($exitData['LM_STATUS'] == 1) {
    //     $readonlyMood = true;
    // }
}



if (isset($_POST['submit_draft']) && count($exitData) < 0) {
    $JOB_KNOWLEDGE           = $_REQUEST['JOB_KNOWLEDGE'];
    $TRANSPERANCY            = $_REQUEST['TRANSPERANCY'];
    $OWNERSHIP_CAN_DO        = $_REQUEST['OWNERSHIP_CAN_DO'];
    $COMMUNICATION_SKILL     = $_REQUEST['COMMUNICATION_SKILL'];
    $TEAM_WORK               = $_REQUEST['TEAM_WORK'];
    $CREATIVITY_MAKER        = $_REQUEST['CREATIVITY_MAKER'];
    $LEADERSHIP              = $_REQUEST['LEADERSHIP'];
    $CUSTOMER_RESPONSIBILITY = $_REQUEST['CUSTOMER_RESPONSIBILITY'];
    $PROBLEM_SOLVING         = $_REQUEST['PROBLEM_SOLVING'];
    $WORK_ETHICS             = $_REQUEST['WORK_ETHICS'];
    $HR_PMS_EMP_ID           = $_GET['tab_id'];
    $HR_PMS_LIST_ID          = $_GET['key'];

    $strSQL = oci_parse(
        $objConnect,
        "INSERT INTO PMS_RATTING_CRITERIA_LM (
            JOB_KNOWLEDGE, TRANSPERANCY, 
            OWNERSHIP_CAN_DO, COMMUNICATION_SKILL, TEAM_WORK, 
            CREATIVITY_MAKER, LEADERSHIP, CUSTOMER_RESPONSIBILITY, 
            PROBLEM_SOLVING, WORK_ETHICS, HR_PMS_EMP_ID, 
            HR_PMS_LIST_ID, LM_STATUS, SUBMITTED_DATE) 
         VALUES (
            '$JOB_KNOWLEDGE','$TRANSPERANCY','$OWNERSHIP_CAN_DO','$COMMUNICATION_SKILL','$TEAM_WORK','$CREATIVITY_MAKER','$LEADERSHIP','$CUSTOMER_RESPONSIBILITY','$PROBLEM_SOLVING','$WORK_ETHICS','$HR_PMS_EMP_ID','$HR_PMS_LIST_ID',
            0,SYSDATE)"
    );


    if (oci_execute($strSQL)) {
        $message                  = [
            'text'   => "Successfully Draft Saved.",
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
    }
    else {
        @$lastError = error_get_last();
        @$error = $lastError ? "" . $lastError["message"] . "" : "";
        $message                  = [
            'text'   => (preg_split("/\@@@@/", @$error)[1]),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
    }
}

if( count($exitData) > 0 && isset($_POST['submit_draft']) || isset($_POST['submit_confirm']) ){
   
    $JOB_KNOWLEDGE           = $_REQUEST['JOB_KNOWLEDGE'];
    $TRANSPERANCY            = $_REQUEST['TRANSPERANCY'];
    $OWNERSHIP_CAN_DO        = $_REQUEST['OWNERSHIP_CAN_DO'];
    $COMMUNICATION_SKILL     = $_REQUEST['COMMUNICATION_SKILL'];
    $TEAM_WORK               = $_REQUEST['TEAM_WORK'];
    $CREATIVITY_MAKER        = $_REQUEST['CREATIVITY_MAKER'];
    $LEADERSHIP              = $_REQUEST['LEADERSHIP'];
    $CUSTOMER_RESPONSIBILITY = $_REQUEST['CUSTOMER_RESPONSIBILITY'];
    $PROBLEM_SOLVING         = $_REQUEST['PROBLEM_SOLVING'];
    $WORK_ETHICS             = $_REQUEST['WORK_ETHICS'];
    $HR_PMS_EMP_ID           = $_GET['tab_id'];
    $HR_PMS_LIST_ID          = $_GET['key'];

    if (isset($_POST['submit_draft'])){
        $strSQL = oci_parse(
        $objConnect, "UPDATE PMS_RATTING_CRITERIA_LM 
        SET JOB_KNOWLEDGE = '$JOB_KNOWLEDGE',TRANSPERANCY = '$TRANSPERANCY', OWNERSHIP_CAN_DO = '$OWNERSHIP_CAN_DO', COMMUNICATION_SKILL = '$COMMUNICATION_SKILL',TEAM_WORK = '$TEAM_WORK', CREATIVITY_MAKER = '$CREATIVITY_MAKER', LEADERSHIP = '$LEADERSHIP',CUSTOMER_RESPONSIBILITY = '$CUSTOMER_RESPONSIBILITY',PROBLEM_SOLVING = '$PROBLEM_SOLVING', WORK_ETHICS = '$WORK_ETHICS'
        WHERE  HR_PMS_EMP_ID =" . $_GET['tab_id'] . " AND HR_PMS_LIST_ID = " . $_GET['key']);
        if (oci_execute($strSQL)) {
            $message                  = [
                'text'   => "Successfully Draft Saved.",
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
        }
        else {
            @$lastError = error_get_last();
            @$error = $lastError ? "" . $lastError["message"] . "" : "";
            $message                  = [
                'text'   => (preg_split("/\@@@@/", @$error)[1]),
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
        }

    }else if(isset($_POST['submit_confirm'])){
     
        $strSQL = oci_parse(
        $objConnect, "UPDATE PMS_RATTING_CRITERIA_LM 
        SET JOB_KNOWLEDGE = '$JOB_KNOWLEDGE',TRANSPERANCY = '$TRANSPERANCY', OWNERSHIP_CAN_DO = '$OWNERSHIP_CAN_DO', COMMUNICATION_SKILL = '$COMMUNICATION_SKILL',TEAM_WORK = '$TEAM_WORK', CREATIVITY_MAKER = '$CREATIVITY_MAKER', LEADERSHIP = '$LEADERSHIP',CUSTOMER_RESPONSIBILITY = '$CUSTOMER_RESPONSIBILITY',PROBLEM_SOLVING = '$PROBLEM_SOLVING', WORK_ETHICS = '$WORK_ETHICS',
        LM_STATUS = 1 WHERE  HR_PMS_EMP_ID =" . $_GET['tab_id'] . " AND HR_PMS_LIST_ID = " . $_GET['key']);
        if (oci_execute($strSQL)) {
            $message                  = [
                'text'   => "Successfully Draft Saved.",
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
        }
        else {
            @$lastError = error_get_last();
            @$error = $lastError ? "" . $lastError["message"] . "" : "";
            $message                  = [
                'text'   => (preg_split("/\@@@@/", @$error)[1]),
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
        }
    }
}

// if($readonlyMood == true){
//     echo'213123';
// }else{
//     echo'kookpoj';
//     echo $exitData['LM_STATUS'];
// }
// die();
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
                    // $rightSideName = 'Leave Report';
                    $routePath = 'leave_module/view/self_panel/index.php';
                }

                include('../../../layouts/_tableHeader.php');

                ?>
                <div class="card-body">
                    <span class="d-block text-center text-danger mb-3"> [Note : Here Can Min Value 0 and Max Value 10]</span>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">JOB KNOWLEDGE</label>
                        <div class="col-sm-3">
                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                value="<?php echo $exitData ? $exitData['JOB_KNOWLEDGE'] : 0 ?>" class="form-control" id="basic-default-company"
                                form="Form2" name="JOB_KNOWLEDGE" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">TRANSPERANCY</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="basic-default-company" form="Form2" 
                                <?php  echo $readonlyMood == true ? "readonly" : '' ?>
                                name="TRANSPERANCY"
                                value="<?php echo $exitData ? $exitData['TRANSPERANCY'] : 0 ?>" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">OWNERSHIP CAN DO</label>
                        <div class="col-sm-3">
                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company" form="Form2" name="OWNERSHIP_CAN_DO"
                                value="<?php echo $exitData ? $exitData['OWNERSHIP_CAN_DO'] : 0 ?>" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">COMMUNICATION SKILL</label>
                        <div class="col-sm-3">
                            <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company" form="Form2" name="COMMUNICATION_SKILL"
                                value="<?php echo $exitData ? $exitData['COMMUNICATION_SKILL'] : 0 ?>" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">TEAM WORK</label>
                        <div class="col-sm-3">
                            <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company" form="Form2" name="TEAM_WORK"
                                value="<?php echo $exitData ? $exitData['TEAM_WORK'] : 0 ?>" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">CREATIVITY MAKER</label>
                        <div class="col-sm-3">
                            <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company" form="Form2" name="CREATIVITY_MAKER"
                                value="<?php echo $exitData ? $exitData['CREATIVITY_MAKER'] : 0 ?>" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">LEADERSHIP</label>
                        <div class="col-sm-3">
                            <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company" form="Form2" name="LEADERSHIP"
                                value="<?php echo $exitData ? $exitData['LEADERSHIP'] : 0 ?>" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">CUSTOMER RESPONSIBILITY</label>
                        <div class="col-sm-3">
                            <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company" form="Form2" name="CUSTOMER_RESPONSIBILITY"
                                value="<?php echo $exitData ? $exitData['CUSTOMER_RESPONSIBILITY'] : 0 ?>" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">PROBLEM SOLVING</label>
                        <div class="col-sm-3">
                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company" form="Form2" name="PROBLEM_SOLVING"
                                value="<?php echo $exitData ? $exitData['PROBLEM_SOLVING'] : 0 ?>" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="basic-default-company">WORK ETHICS</label>
                        <div class="col-sm-3">
                            <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company" form="Form2" name="WORK_ETHICS"
                                value="<?php echo $exitData ? $exitData['WORK_ETHICS'] : 0 ?>" required />
                        </div>
                    </div>
                    <?php 
                        if($readonlyMood != true){
                            echo '<div class="text-center">
                            <button form="Form2" type="submit" name="submit_draft" class="btn btn-sm btn-primary">Draft </button>
                            <button form="Form2" type="submit" name="submit_confirm" class="btn btn-sm btn-primary">Confirm </button>
                            </div>';
                        }
                    ?>
                
                    

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