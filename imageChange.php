<?php
session_start();
session_regenerate_id(TRUE);

if ($_SESSION['HR']['hr_role'] != 4 && $_SESSION['HR']['hr_role'] != 3) {
    header('location:index.php?lmsg_hr=true');
    exit;
}

if (!isset($_SESSION['HR']['id_hr'], $_SESSION['HR']['hr_role'])) {
    header('location:index.php?lmsg_hr=true');
    exit;
}
require_once('inc/config.php');
require_once('layouts/header.php');

// $v_page = 'tour_create_self';
// $v_active_open = 'active open';
// $v_active = 'active';


require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
require_once('inc/connoracle.php');


$emp_session_id = $_SESSION['HR']['emp_id_hr'];

// print_r($_SESSION['HR']['emp_image_hr']);
// die();


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

<?php require_once('layouts/footer_info.php'); ?>
<?php require_once('layouts/footer.php'); ?>