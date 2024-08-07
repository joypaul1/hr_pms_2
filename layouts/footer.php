</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->


<!-- Core JS -->
<script src="<?php echo $basePath ?>/assets/vendor/libs/jquery/jquery.js?v=0.3"></script>
<script src="<?php echo $basePath ?>/assets/vendor/libs/popper/popper.js?v=0.3"></script>
<script src="<?php echo $basePath ?>/assets/vendor/js/bootstrap.js?v=0.3"></script>
<script src="<?php echo $basePath ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js?v=0.3"></script>

<script src="<?php echo $basePath ?>/assets/vendor/js/menu.js?v=0.3"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?php echo $basePath ?>/assets/vendor/libs/apex-charts/apexcharts.js?v=0.3"></script>

<!-- Main JS -->
<script src="<?php echo $basePath ?>/assets/js/main.js?v=0.3"></script>

<!-- Page JS -->
<script src="<?php echo $basePath ?>/assets/js/dashboards-analytics.js?v=0.3"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js" integrity="sha512-7x7HoEikRZhV0FAORWP+hrUzl75JW/uLHBbg2kHnPdFmScpIeHY0ieUVSacjusrKrlA/RsA2tDOBvisFmKc3xw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- // Echo the value of $dynamic_link_css to verify its content -->
<?php if (isset($dynamic_link_js) && count($dynamic_link_js) > 0) {
    foreach ($dynamic_link_js as $key => $linkJs) {
        echo "<script src='$linkJs'></script>";
    }
} ?>
<!-- Place this tag in your head or just before your close body tag. -->



<?php
if (!empty($_SESSION['noti_message'])) {
    if ($_SESSION['noti_message']['status'] == 'false') {
        echo "<script>toastr.warning('{$_SESSION['noti_message']['text']}');</script>";
    }
    if ($_SESSION['noti_message']['status'] == 'true') {
        echo "<script>toastr.success('{$_SESSION['noti_message']['text']}');</script>";
    }
    unset($_SESSION['noti_message']);
}
?>
</body>

</html>