<?php
session_start();
session_regenerate_id(TRUE);
require_once('inc/config.php');
require_once('layouts/header.php');
require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">


    </br>


    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Update Your Profile Image</h5>

                </div>
                <div class="card-body">
                    <form action="action/upload.php" method="post" enctype="multipart/form-data" id="form">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="fileToUpload">Select Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="fileToUpload" name="file" >
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

<?php require_once('layouts/footer_info.php'); ?>
<?php require_once('layouts/footer.php'); ?>