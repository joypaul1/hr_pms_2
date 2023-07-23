<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
if (!checkPermission('hr-offboarding-approval')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$v_view_approval = 0;
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
                        <input required="" form="Form1" placeholder="Employee ID" name="emp_concern" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_concern']) ? $_POST['emp_concern'] : ''; ?>' />
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
            $leftSideName  = 'Offboarding Approval List';
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
						FROM EMP_CLEARENCE A,EMP_CLEARENCE_DTLS B,RML_HR_APPS_USER C
						WHERE A.ID=B.EMP_CLEARENCE_ID
						AND A.RML_HR_APPS_USER_ID=C.ID
						AND B.APPROVAL_STATUS IS NULL
						AND A.APPROVAL_STATUS IS NULL
						AND B.CONCERN_NAME IN (
										SELECT R_CONCERN from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
										(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id')
										 )
						AND B.DEPARTMENT_ID IN (
										SELECT RML_HR_DEPARTMENT_ID from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
										(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id')
										)"
                    );

                    @oci_execute($allDataSQL);
                    $number = 0;

                    while ($row = oci_fetch_assoc($allDataSQL)) {

                        $number++;
                    ?>
                        <form action="<?php echo $basePath ?>/offboarding_module/action/hr_panel.php" method="POST">

                            <input type="hidden" name="check_list_id" value="<?php echo $row["ID"]; ?>">
                            <input type="hidden" name="actionType" value="offboarding_approval">
                            <span class="w-100">
                                <div class="justify-content-center">
                                    <div class="card p-3">
                                        <div class="d-flex  text-center">
                                            <div class="w-100">
                                                <div class="p-2 d-flex justify-content-between rounded text-white " style="background-color:#3f6f70">
                                                    <div class="d-flex flex-column">
                                                        <span class="articles">Name </span>
                                                        <span class="number1"> <?php echo $row["EMP_NAME"] ?> </span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="articles">ID</span>
                                                        <span class="number1"> <?php echo $row["RML_ID"] ?> </span>

                                                    </div>

                                                    <div class="d-flex flex-column">
                                                        <span class="rating">Department</span>
                                                        <span class="number3"> <?php echo $row["DEPT_NAME"] ?></span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="rating">Designation</span>
                                                        <span class="number3"> <?php echo $row["DESIGNATION"] ?></span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="rating">Work Station</span>
                                                        <span class="number3"> <?php echo $row["BRANCH_NAME"] ?></span>
                                                    </div>


                                                </div>
                                                <div class="d-flex ">
                                                    <input type="text" name="remarks" class="form-control mt-2" placeholder="remarks here..." />
                                                </div>
                                                <div class="mt-2 d-flex flex-row">
                                                    <div class="col-6"></div>
                                                    <div class="col-6 d-flex flex-row">
                                                        <button type="submit" class="btn btn-sm  btn-outline-info w-50">Approve</button>
                                                        <a  onclick="denied($(this))"  data-href="<?php echo $basePath . '/offboarding_module/action/hr_panel.php?id=' . "$row[ID]" . '&actionType=offboarding_denine' ?>" class="btn btn-sm btn-outline-danger w-50 ml-2">
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
        <?php


        // if (isset($_POST['submit_approval_single'])) {
        //     if (!empty($_POST['check_list'])) {
        //         foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

        //             $attnProcSQL  = oci_parse($objConnect, "BEGIN
        // 													CLEARENCE_APPROVAL(1,'$emp_session_id',$TT_ID_SELECTTED);
        // 													END;");

        //             if (oci_execute($attnProcSQL)) {
        //                 //$errorMsg = "Your Selected Leave Successfully Approved";
        //                 echo '<div class="alert alert-primary">';
        //                 echo 'Successfully Approved Offboarding ID ' . $TT_ID_SELECTTED;
        //                 echo '<br>';
        //                 echo '</div>';
        //             }
        //         }
        //         $message = [
        //             'text'   => 'Successfully Approved Offboarding ID.',
        //             'status' => 'true',
        //         ];
        //         $_SESSION['noti_message'] = $message;
        //         echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
        //         exit();
        //     } else {
        //         //$errorMsg = "Sorry! You have not select any ID Code.";

        //         // echo '<div class="alert alert-danger">';
        //         // echo 'Sorry! You have not select any ID Code.';
        //         // echo '</div>';
        //         $message = [
        //             'text'   => 'Sorry! You have not select any ID Code.',
        //             'status' => 'false',
        //         ];
        //         $_SESSION['noti_message'] = $message;
        //         echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
        //         exit();
        //     }
        // }


        // if (isset($_POST['submit_approval'])) { //to run PHP script on submit

        //     if (!empty($_POST['check_list'])) {
        //         // Loop to store and display values of individual checked checkbox.
        //         foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

        //             $attnProcSQL  = oci_parse($objConnect, "UPDATE EMP_CLEARENCE_DTLS
        // 						SET    APPROVAL_STATUS  = 1,
        // 							   APPROVE_BY       = '$emp_session_id',
        // 							   APPROVE_DATE     = SYSDATE
        // 						WHERE  ID               = $TT_ID_SELECTTED");

        //             if (oci_execute($attnProcSQL)) {
        //                 //$errorMsg = "Your Selected Leave Successfully Approved";
        //                 echo '<div class="alert alert-primary">';
        //                 echo 'Successfully Approved Offboarding ID ' . $TT_ID_SELECTTED;
        //                 echo '<br>';
        //                 echo '</div>';
        //             }
        //         }
        //         $message = [
        //             'text'   => 'Successfully Approved Offboarding ID.',
        //             'status' => 'true',
        //         ];
        //         $_SESSION['noti_message'] = $message;
        //         echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
        //         exit();
        //     } else {
        //         //$errorMsg = "Sorry! You have not select any ID Code.";

        //         // echo '<div class="alert alert-danger">';
        //         // echo 'Sorry! You have not select any ID Code.';
        //         // echo '</div>';
        //         $message = [
        //             'text'   => 'Sorry! You have not select any ID Code.',
        //             'status' => 'false',
        //         ];
        //         $_SESSION['noti_message'] = $message;
        //         echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
        //         exit();
        //     }
        // }

        // Denied option
        // if (isset($_POST['submit_denied'])) { //to run PHP script on submit
        //     if (!empty($_POST['check_list'])) {
        //         // Loop to store and display values of individual checked checkbox.
        //         foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
        //             $strSQL = oci_parse(
        //                 $objConnect,
        //                 "update RML_HR_EMP_LEAVE 
        // 								set LINE_MNGR_APVL_STS=0,
        // 								LINE_MNGR_APVL_DATE=sysdate,
        // 								LINE_MNGR_APVL_BY='$emp_session_id',
        // 								IS_APPROVED=0
        //                                  where ID='$TT_ID_SELECTTED'"
        //             );

        //             oci_execute($strSQL);

        //             echo 'Successfully Denied Outdoor Attendance ID ' . $TT_ID_SELECTTED . "</br>";
        //         }
        //         $message = [
        //             'text'   => 'Successfully Denied Outdoor Attendance ID',
        //             'status' => 'true',
        //         ];
        //         $_SESSION['noti_message'] = $message;
        //         echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
        //     } else {

        //         $message = [
        //             'text'   => 'Sorry! You have not select any ID Code.',
        //             'status' => 'false',
        //         ];
        //         $_SESSION['noti_message'] = $message;
        //         echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
        //         exit();
        //     }
        // }


        ?>
    </div>

</div>

<!-- / Content -->


<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function denied(here){
        console.log((here).attr('href'));
        

    }
    // $.ajax({
    //         url: url,
    //         type: 'GET',
    //         data: {
    //             deleteID: id
    //         },
    //         dataType: 'json'
    //     })
    //     .done(function(response) {
    //         console.log(response);
    //         swal.fire('Deleted!', response.message, response.status);
    //         location.reload(); // Reload the page
    //     })
    //     .fail(function() {
    //         swal.fire('Oops...', 'Something went wrong!', 'error');
    //     });
</script>