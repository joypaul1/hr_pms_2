<?php

$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('upload-check')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
// $emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Update Document For Invoice Number : <?php echo $_GET['invoice_no']?> </h5>

                </div>
                <div class="card-body">
                    <form action="#" method="post" enctype="multipart/form-data" id="form">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="fileToUpload">Select Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="fileToUpload" name="file" />
                                <?php if (!empty($_SESSION['imageStatus'])) {
                                    echo '<p class="text-info"> ' . $_SESSION['imageStatus'] . '</p>';
                                    unset($_SESSION['imageStatus']);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">

                            <input type="submit" value="Upload Image" name="submit" class="btn btn-primary">

                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>



</div>


<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>