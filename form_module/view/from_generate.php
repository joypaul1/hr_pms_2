<?php
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');

if (!checkPermission('self-leave-create')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}


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
                $leftSideName  = 'From Generate Panel';
                include('../../layouts/_tableHeader.php');

                ?>
                








            </div>
        </div>

    </div>





</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>