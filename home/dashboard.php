<?php
$v_page        = 'role';
$v_active_open = 'active open';
$v_active      = 'active';
require_once('../helper/com_conn.php');
require_once('../inc/connoracle.php');



?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class=" card card-title ">
            <div class="col-lg-12 p-2">
                <marquee >DEMO TEXT</marquee>
            </div>
        </div>
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Congratulations <?php echo $_SESSION['HR']['first_name_hr']; ?>! 🎉</h5>
                            <p class="mb-4">
                                Access Are Predefine according to <span class="fw-bold">Rangs Motors HR Policy.</span>
                                If you need more access please contact with HR.
                            </p>
                            <a href="" class="btn btn-sm btn-outline-primary">Universal Notification</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="<?php echo $basePath ?>/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- Total Revenue -->
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <img src="<?php echo $basePath ?>/images/dashing_images.png" class="img-fluid" style="width: auto; height: 410px;">
            </div>
        </div>
       
    </div>
    
</div>
<!-- / Content -->



<?php require_once('../layouts/footer_info.php'); ?>
<?php require_once('../layouts/footer.php'); ?>