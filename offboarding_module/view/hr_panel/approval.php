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
                <form>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="John Doe">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-company">Company</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-company" placeholder="ACME Inc.">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-email">Email</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" id="basic-default-email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2">
                                <span class="input-group-text" id="basic-default-email2">@example.com</span>
                            </div>
                            <div class="form-text">You can use letters, numbers &amp; periods</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-phone">Phone No</label>
                        <div class="col-sm-10">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-message">Message</label>
                        <div class="col-sm-10">
                            <textarea id="basic-default-message" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2"></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php

        if (isset($_POST['submit_approval_single'])) {
            if (!empty($_POST['check_list'])) {
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

                    $attnProcSQL  = oci_parse($objConnect, "BEGIN
															CLEARENCE_APPROVAL(1,'$emp_session_id',$TT_ID_SELECTTED);
															END;");

                    if (oci_execute($attnProcSQL)) {
                        //$errorMsg = "Your Selected Leave Successfully Approved";
                        echo '<div class="alert alert-primary">';
                        echo 'Successfully Approved Offboarding ID ' . $TT_ID_SELECTTED;
                        echo '<br>';
                        echo '</div>';
                    }
                }
                $message = [
                    'text'   => 'Successfully Approved Offboarding ID.',
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
                exit();
            } else {
                //$errorMsg = "Sorry! You have not select any ID Code.";

                // echo '<div class="alert alert-danger">';
                // echo 'Sorry! You have not select any ID Code.';
                // echo '</div>';
                $message = [
                    'text'   => 'Sorry! You have not select any ID Code.',
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
                exit();
            }
        }


        if (isset($_POST['submit_approval'])) { //to run PHP script on submit

            if (!empty($_POST['check_list'])) {
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

                    $attnProcSQL  = oci_parse($objConnect, "UPDATE EMP_CLEARENCE_DTLS
								SET    APPROVAL_STATUS  = 1,
									   APPROVE_BY       = '$emp_session_id',
									   APPROVE_DATE     = SYSDATE
								WHERE  ID               = $TT_ID_SELECTTED");

                    if (oci_execute($attnProcSQL)) {
                        //$errorMsg = "Your Selected Leave Successfully Approved";
                        echo '<div class="alert alert-primary">';
                        echo 'Successfully Approved Offboarding ID ' . $TT_ID_SELECTTED;
                        echo '<br>';
                        echo '</div>';
                    }
                }
                $message = [
                    'text'   => 'Successfully Approved Offboarding ID.',
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
                exit();
            } else {
                //$errorMsg = "Sorry! You have not select any ID Code.";

                // echo '<div class="alert alert-danger">';
                // echo 'Sorry! You have not select any ID Code.';
                // echo '</div>';
                $message = [
                    'text'   => 'Sorry! You have not select any ID Code.',
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
                exit();
            }
        }

        // Denied option
        if (isset($_POST['submit_denied'])) { //to run PHP script on submit
            if (!empty($_POST['check_list'])) {
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
                    $strSQL = oci_parse(
                        $objConnect,
                        "update RML_HR_EMP_LEAVE 
										set LINE_MNGR_APVL_STS=0,
										LINE_MNGR_APVL_DATE=sysdate,
										LINE_MNGR_APVL_BY='$emp_session_id',
										IS_APPROVED=0
                                         where ID='$TT_ID_SELECTTED'"
                    );

                    oci_execute($strSQL);

                    echo 'Successfully Denied Outdoor Attendance ID ' . $TT_ID_SELECTTED . "</br>";
                }
                $message = [
                    'text'   => 'Successfully Denied Outdoor Attendance ID',
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
            } else {
                // echo '<div class="alert alert-danger">';
                // echo 'Sorry! You have not select any ID Code.';
                // echo '</div>';
                $message = [
                    'text'   => 'Sorry! You have not select any ID Code.',
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script>window.location = '$basePath/offboarding_module/view/hr_panel/approval.php'</script>";
                exit();
            }
        }


        ?>
    </div>

</div>

<!-- / Content -->


<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>