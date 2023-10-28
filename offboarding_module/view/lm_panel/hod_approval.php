<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$v_view_approval = 0;
$basePath =  $_SESSION['basePath'];
if (!checkPermission('lm-hod-approval')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
        <div class="card card-body">
            <form id="Form1" action="" method="post"></form>
            <form id="Form2" action="" method="post"></form>
            <form id="Form3" action="" method="post"></form>
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                        <input required="" form="Form1" placeholder="Employee ID" name="emp_concern" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_concern']) ? $_POST['emp_concern'] : ''; ?>' >
                    </div>
                </div>
                <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <div class="form-group">
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Approval Data" form="Form1">
                    </div>
                </div>
            </div>

        </div>

        <div class="card  col-lg-12 mt-2">
            <!-- <h5 class="card-header"><b>Offboarding Approval List</b></h5> -->
            <?php
            $leftSideName  = 'HOD Approval List';
            include('../../../layouts/_tableHeader.php');
            ?>
            <div class="card-body">

                <div class="col-sm-12">
                    <?php
                    $allDataSQL = oci_parse(
                        $objConnect,
                        "SELECT B.ID,
							   C.EMP_NAME,
							   C.RML_ID,
							   C.R_CONCERN,
							   C.DEPT_NAME,
							   C.DESIGNATION,
							   C.BRANCH_NAME,
							   A.CREATED_DATE,
							   A.CREATED_BY
						FROM EMP_CLEARENCE A,HOD_CLEARENCE_DTLS B,RML_HR_APPS_USER C					
						WHERE A.ID=B.EMP_CLEARENCE_ID
						AND A.RML_HR_APPS_USER_ID=C.ID
						AND B.APPROVAL_STATUS IS NULL
						AND A.HOD_STATUS IS NULL
						AND HOD_ID='$emp_session_id'"
						
                    );

                    @oci_execute($allDataSQL);
                    $number = 0;

                    while ($row = oci_fetch_assoc($allDataSQL)) {

                        $number++;
                    ?>
                        <form action="<?php echo $basePath ?>/offboarding_module/action/lm_panel.php" method="POST">

                            <input type="hidden" name="check_list_id" value="<?php echo $row["ID"]; ?>">
                            <input type="hidden" name="actionType" value="hod_approval">
                            <span class="w-100">
                                <div class="justify-content-center">
                                    <div class="card p-3">
                                        <div class="d-flex  text-center">
                                            <div class="w-100">
                                                <div class="p-2 d-flex justify-content-between rounded text-white " style="background-color:#3f6f70">
                                                    <div class="d-flex flex-column">
                                                        <span class="articles">Name </span> <hr style="margin:0">
                                                        <span class="number1"> <?php echo $row["EMP_NAME"] ?> </span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="articles">ID</span> <hr style="margin:0">
                                                        <span class="number1"> <?php echo $row["RML_ID"] ?> </span>

                                                    </div>

                                                    <div class="d-flex flex-column">
                                                        <span class="rating">Department</span> <hr style="margin:0">
                                                        <span class="number3"> <?php echo $row["DEPT_NAME"] ?></span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="rating">Designation</span> <hr style="margin:0">
                                                        <span class="number3"> <?php echo $row["DESIGNATION"] ?></span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="rating">Work Station</span> <hr style="margin:0">
                                                        <span class="number3"> <?php echo $row["BRANCH_NAME"] ?></span>
                                                    </div>


                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div style="width: 30%;">
                                                        <label class="form-label">All Document Submit </label>
                                                        <input type="text" name="remark_1" oninput="limitCharter($(this))" class="form-control " placeholder="All Document Submit ..." >
                                                    </div>
                                                    <div style="width: 30%;">
                                                        <label class="form-label">Any Paymnet Due/Clear</label>
                                                        <input type="text" name="remark_2" oninput="limitCharter($(this))" class="form-control " placeholder="Any Paymnet Due/Clear ..." >
                                                    </div style="width: 30%;">
                                                    <div>
                                                        <label class="form-label">Any Other(Remarks)</label>
                                                        <input type="text" name="remark_3" oninput="limitCharter($(this))" class="form-control " placeholder="Any Other(Remarks) ..." >
                                                    </div>
                                                    
                                                    <!-- <input type="text" name="remark_2" oninput="limitCharter($(this))" class="form-control mt-2" placeholder="remarks here..." >
                                                    <input type="text" name="remark_3" oninput="limitCharter($(this))" class="form-control mt-2" placeholder="remarks here..." > -->
                                                </div>
                                                <div class="mt-2 d-flex flex-row">
                                                    <div class="col-6"></div>
                                                    <div class="col-6 d-flex flex-row">
                                                        <button type="submit" class="btn btn-sm  btn-outline-info w-50">Approve</button>
                                                        <a onclick="denied($(this))" data-href="<?php echo $basePath . '/offboarding_module/action/lm_panel.php?id=' . "$row[ID]" . '&actionType=offboarding_denine' ?>" class="btn btn-sm btn-outline-danger w-50 ml-2">
                                                            Deny
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </form>

                    <?php } ?>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- / Content -->


<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
    function limitCharter(here){
        if(here.val().length > 50){
            // alert('Sorry!Text must be less than 50!');
            toastr.warning('Sorry! Text must be less than 50!');
            here.val(here.val().substring(0,50));

        }
    }
</script>