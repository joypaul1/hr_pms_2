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
// $readonlyMood = false;
if (oci_execute($exitSql)) {
    $exitData = oci_fetch_assoc($exitSql);
}

$exitSql_2 = oci_parse(
    $objConnect,
    "SELECT * FROM PMS_RATTING_CRITERIA_HOD WHERE HR_PMS_EMP_ID =" . $_GET['tab_id'] . " AND HR_PMS_LIST_ID = " . $_GET['key']
);

$exitData_2 = array();
$readonlyMood = false;
if (oci_execute($exitSql_2)) {
    $exitData_2 = oci_fetch_assoc($exitSql_2);
    if($exitData_2){
        if ($exitData_2['HOD_STATUS'] == 1) {
            $readonlyMood = true;
        }
    }
}

 $HR_PMS_EMP_ID           = $_GET['tab_id'];
 $HR_PMS_LIST_ID          = $_GET['key'];
 $EMP_ID                  = $_GET['emp_id'];


?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <form id="Form2" action="" method="post"></form>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="">
            <div class="card mb-4">


                <?php
                $leftSideName = 'PMS Rating Create';
                if (checkPermission('self-leave-report')) {
                    $routePath = 'leave_module/view/self_panel/index.php';
                }
                include('../../../layouts/_tableHeader.php');
                ?>
                
                <div class="card-body">
              


                        <div class="row ">
                         
                            <div class="col-12">
                            <div class="shadow-sm p-2 mb-1 text-center text-info rounded font-weight-bold"><i class='bx bxs-shield-alt-2'></i>[Note :     Here You Can Set Achivement Rating Value] <i class='bx bxs-shield-alt-2'></i></div>
                            </div>    
                           
                            <div class="col-12">    
                            
                                <div class='card card-body '>
                            
                                            <div class=" d-flex text-center">
                                                <div class="col-4">
                                                <u> <strong>KPI Name</strong></u>
                                                </div>
                                                <div class="col-1">
                                                    <u>  <strong>T</strong></u>
                                                </div>
                                                <div class="col-1">
                                                    <u>  <strong>TW</strong></u>
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
                                            <form action="<?php echo ($basePath . '/pms_module/action/hod_panel.php'); ?>" method="post"     class="justify-content-center">
                                            <input type="hidden" name="actionType" value="kpi_achivement">
                                            <input type="hidden" name="tab_id" value="<?php echo $_GET['tab_id'] ?>">
                                            <input type="hidden" name="key" value="<?php echo  $_GET['key'] ?>"> 
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
                                                    $achivement         = $rowIN['ACHIVEMENT']?$rowIN['ACHIVEMENT']: 0;
                                                    $targetWeightage    = $rowIN['WEIGHTAGE']?$rowIN['WEIGHTAGE']: 0;
                                                    $target             = 100; 
                                                    $awValue            =($achivement / $target) * 100;
                                                    $score              = ($targetWeightage* $awValue)/100;
                                            ?>
                                                
                                                    <div class="row mb-2">
                                                        <div class="col-4">
                                                            <input type="text" value="<?php echo $rowIN['KPI_NAME']; ?>" disabled class="form-control text-center " placeholder="kpi name">
                                                        </div>
                                                        <div class="col-1">
                                                            <input type="text" disabled  class="form-control text-center target" 
                                                            value="<?php echo $rowIN['TARGET']; ?>" placeholder="target">
                                                        </div>
                                                        <div class="col-1">
                                                            <input type="text" disabled  class="form-control text-center targetWeightage" 
                                                            value="<?php echo $rowIN['WEIGHTAGE']; ?>" placeholder="WEIGHTAGE">
                                                        </div>
                                                        <div class="col-2">
                                                        <input type="text" name="achivement[<?php echo $rowIN['ID']; ?>]"  value="<?php echo $rowIN['ACHIVEMENT']; ?>"   onkeypress='return event.charCode >= 48 && event.charCode <= 57'     class="form-control text-center achivement" placeholder="target achivement">
                                                        </div>
                                                        <div class="col-2">
                                                        <input type="text" readonly onkeypress='return event.charCode >= 48 && event.charCode <= 57'     class="form-control text-center achivementWeightage" value="<?php echo $awValue ?>" placeholder="achivement weight">
                                                        </div>
                                                        <div class="col-2">
                                                        <input type="text"  value="<?php echo $score ?>"  readonly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  class="form-control text-center score" placeholder="score">
                                                        </div>
                                                        

                                                    </div>
                                            
                                            
                                            
                                            <?php 
                                            }}
                                                
                                                    echo '
                                                    <div class="text-right">
                                                    <button  type="submit" name="submit_confirm" class="btn btn-sm btn-warning">Confirm <i class="bx bx-save" ></i> </button>
                                                    </div>';
                                            
                                                    // echo "<span class='d-block text-center font-weight-bold'>All Ready Comfirmed Rating <i class='bx bxs-home-smile text-success'></i></span>";
                                                    // <div class="text-center">
                                                    // <button  type="submit" name="submit_draft" class="btn btn-sm btn-info">Draft <i class="bx bxl-codepen"></i></button>
                                                
                                            ?>
                                    
                                        </form>
                                </div>

                              


                                <div class='mt-3 card card-body '>
                                <div class="shadow-sm p-2 mb-1 text-center text-success rounded font-weight-bold"><i class="bx bxs-shield-alt-2"></i>[Here You Can View Generate Grade] <i class="bx bxs-shield-alt-2"></i></div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                       <div class='col-12'>
                       <div class="shadow-sm p-2 mb-3 text-center text-danger rounded font-weight-bold"><i class='bx bxs-shield-alt-2'></i>[Note : Here You Can Set Min Value 0 and Max Value 10] <i class='bx bxs-shield-alt-2'></i></div>
                       </div>
                        <div class="col-6 card card-body" style="background: #f3f3f3;">
                                <div class="shadow-sm p-2 mb-3 text-center rounded font-weight-bold">L.M. RATING  <i class='bx bx-star text-success' ></i></div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">JOB KNOWLEDGE</label>
                                    <div class="col-sm-6s">
                                        <input type="number"readonly
                                            value="<?php echo $exitData ? $exitData['JOB_KNOWLEDGE'] : 0 ?>" class="form-control" id="basic-default-company" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">TRANSPERANCY</label>
                                    <div class="col-sm-6s">
                                        <input type="number" class="form-control" id="basic-default-company"  
                                            readonly
                                            name="TRANSPERANCY"
                                            value="<?php echo $exitData ? $exitData['TRANSPERANCY'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">OWNERSHIP CAN DO</label>
                                    <div class="col-sm-6s">
                                        <input type="number"readonly class="form-control" id="basic-default-company"  name="OWNERSHIP_CAN_DO"
                                            value="<?php echo $exitData ? $exitData['OWNERSHIP_CAN_DO'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">COMMUNICATION SKILL</label>
                                    <div class="col-sm-6s">
                                        <input type="number" readonly class="form-control" id="basic-default-company"  name="COMMUNICATION_SKILL"
                                            value="<?php echo $exitData ? $exitData['COMMUNICATION_SKILL'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">TEAM WORK</label>
                                    <div class="col-sm-6s">
                                        <input type="number" readonly class="form-control" id="basic-default-company"  name="TEAM_WORK"
                                            value="<?php echo $exitData ? $exitData['TEAM_WORK'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">CREATIVITY MAKER</label>
                                    <div class="col-sm-6s">
                                        <input type="number" readonly class="form-control" id="basic-default-company"  name="CREATIVITY_MAKER"
                                            value="<?php echo $exitData ? $exitData['CREATIVITY_MAKER'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">LEADERSHIP</label>
                                    <div class="col-sm-6s">
                                        <input type="number" readonly class="form-control" id="basic-default-company"  name="LEADERSHIP"
                                            value="<?php echo $exitData ? $exitData['LEADERSHIP'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">CUSTOMER RESPONSIBILITY</label>
                                    <div class="col-sm-6s">
                                        <input type="number" readonly class="form-control" id="basic-default-company"  name="CUSTOMER_RESPONSIBILITY"
                                            value="<?php echo $exitData ? $exitData['CUSTOMER_RESPONSIBILITY'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">PROBLEM SOLVING</label>
                                    <div class="col-sm-6s">
                                        <input type="number"readonly class="form-control" id="basic-default-company"  name="PROBLEM_SOLVING"
                                            value="<?php echo $exitData ? $exitData['PROBLEM_SOLVING'] : 0 ?>" required />
                                    </div>
                                </div>
                                <div class="rows mb-3">
                                    <label class="col-sm-6s col-form-label" for="basic-default-company">WORK ETHICS</label>
                                    <div class="col-sm-6s">
                                        <input type="number"readonly class="form-control" id="basic-default-company"  name="WORK_ETHICS"
                                            value="<?php echo $exitData ? $exitData['WORK_ETHICS'] : 0 ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 card card-body">
                             
                                <div class="shadow-sm p-2 mb-3 text-center rounded font-weight-bold" style="background-color: #90ee9096;">H.O.D   RATING   <i class='bx   bxs-hand-down text-info'></i> </div>
                                    <form action="<?php echo ($basePath . '/pms_module/action/hod_panel.php'); ?>" method="post">
                                        <input type='hidden' name='actionType' value='rating_form'>
                                        <input type="hidden" name="tab_id" value="<?php echo $HR_PMS_EMP_ID ?>">
                                        <input type="hidden" name="key" value="<?php echo $HR_PMS_LIST_ID ?>">
                                        <div class="rows mb-3">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">JOB KNOWLEDGE</label>
                                            <div class="col-sm-6s">
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?>
                                                    value="<?php echo $exitData_2 ? $exitData_2['JOB_KNOWLEDGE'] : 0 ?>" class="form-control" id="basic-default-company"
                                                    name="JOB_KNOWLEDGE" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">TRANSPERANCY</label>
                                            <div class="col-sm-6s">
                                                <input type="number" class="form-control" id="basic-default-company"  
                                                    <?php  echo $readonlyMood == true ? "readonly" : '' ?>
                                                    name="TRANSPERANCY"
                                                    value="<?php echo $exitData_2 ? $exitData_2['TRANSPERANCY'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">OWNERSHIP CAN DO</label>
                                            <div class="col-sm-6s">
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="OWNERSHIP_CAN_DO"
                                                    value="<?php echo $exitData_2 ? $exitData_2['OWNERSHIP_CAN_DO'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">COMMUNICATION SKILL</label>
                                            <div class="col-sm-6s">
                                                <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="COMMUNICATION_SKILL"
                                                    value="<?php echo $exitData_2 ? $exitData_2['COMMUNICATION_SKILL'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">TEAM WORK</label>
                                            <div class="col-sm-6s">
                                                <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="TEAM_WORK"
                                                    value="<?php echo $exitData_2 ? $exitData_2['TEAM_WORK'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">CREATIVITY MAKER</label>
                                            <div class="col-sm-6s">
                                                <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="CREATIVITY_MAKER"
                                                    value="<?php echo $exitData_2 ? $exitData_2['CREATIVITY_MAKER'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">LEADERSHIP</label>
                                            <div class="col-sm-6s">
                                                <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="LEADERSHIP"
                                                    value="<?php echo $exitData_2 ? $exitData_2['LEADERSHIP'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">CUSTOMER RESPONSIBILITY</label>
                                            <div class="col-sm-6s">
                                                <input type="number"  <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="CUSTOMER_RESPONSIBILITY"
                                                    value="<?php echo $exitData_2 ? $exitData_2['CUSTOMER_RESPONSIBILITY'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">PROBLEM SOLVING</label>
                                            <div class="col-sm-6s">
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="PROBLEM_SOLVING"
                                                    value="<?php echo $exitData_2 ? $exitData_2['PROBLEM_SOLVING'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <div class="rows mb-2">
                                            <label class="col-sm-6s col-form-label" for="basic-default-company">WORK ETHICS</label>
                                            <div class="col-sm-6s">
                                                <input type="number" <?php echo $readonlyMood == true ? "readonly" : '' ?> class="form-control" id="basic-default-company"  name="WORK_ETHICS"
                                                    value="<?php echo $exitData_2 ? $exitData_2['WORK_ETHICS'] : 0 ?>" required />
                                            </div>
                                        </div>
                                        <?php 
                                            if($readonlyMood != true){
                                                echo '<div class="text-center">
                                                <button  type="submit" name="submit_draft" class="btn btn-sm btn-info">Draft <i class="bx bxl-codepen"></i></button> 
                                                <button  type="submit" name="submit_confirm" class="btn btn-sm btn-warning">Confirm <i class="bx bx-save" ></i> </button>
                                                </div>';
                                            }else{
                                                echo "<span class='d-block text-center font-weight-bold'>All Ready Comfirmed Rating <i class='bx bxs-home-smile text-success'></i></span>";
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
        $(document).on('keyup', '.achivement', function () {
            console.log($(this).val());
            $achivement = $(this).val()||0;
            $target = $(this).parent().parent('.row').find('.target').val();
            $targetWeightage = $(this).parent().parent('.row').find('.targetWeightage').val();
            $achivementWeightage = ($achivement / $target) *100;
            $(this).parent().parent('.row').find('.achivementWeightage').val($achivementWeightage);
            $(this).parent().parent('.row').find('.score').val(($achivementWeightage *  $targetWeightage)/100);


            // console.log($target, $targetWeightage, 'achivementWeightage', 'score' );
            
        });
    });
</script>