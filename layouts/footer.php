</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->


<!-- Core JS -->
<script src="<?php  echo $basePath ?>/assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?php  echo $basePath ?>/assets/vendor/libs/popper/popper.js"></script>
<script src="<?php  echo $basePath ?>/assets/vendor/js/bootstrap.js"></script>
<script src="<?php  echo $basePath ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="<?php  echo $basePath ?>/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?php  echo $basePath ?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="<?php  echo $basePath ?>/assets/js/main.js"></script>

<!-- Page JS -->
<script src="<?php  echo $basePath ?>/assets/js/dashboards-analytics.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>





<?php 
if (!empty($_SESSION['noti_message'])) {
    if($_SESSION['noti_message']['status'] == 'false'){
        echo "<script>toastr.warning('{$_SESSION['noti_message']['text']}');</script>";
    }
    if($_SESSION['noti_message']['status'] == 'true'){
        echo "<script>toastr.success('{$_SESSION['noti_message']['text']}');</script>";
    }
    unset($_SESSION['noti_message']);
}
?>
</body>

</html>