<?php

$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('car-deed-form')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card text-center">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2"> Comming Soon !</h2>
            <p class="mb-4 mx-2">Sorry for the inconvenience but we're performing some maintenance at the moment</p>
            <a href="<?php echo $basePath ?>/home/dashboard.php" class="btn btn-primary">Back to home</a>
            <div class="mt-4">
                <img src="<?php echo $basePath ?>/assets/img/illustrations/girl-doing-yoga-light.png" alt="girl-doing-yoga-light" width="500" class="img-fluid" data-app-dark-img="illustrations/girl-doing-yoga-dark.png" data-app-light-img="illustrations/girl-doing-yoga-light.png">
            </div>
        </div>
    </div>



</div>


<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>