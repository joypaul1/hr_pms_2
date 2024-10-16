<?php
if (!isset($_SESSION['HR_APPS'])) {
  $currentScriptPath = __FILE__;
  $directoryPath     = dirname($currentScriptPath);
  $includeFilePath   = $directoryPath . '/../config_file_path.php';
  //  $includeFilePath;
  // Get the real path of the included or required file
  $realIncludePath = realpath($includeFilePath);
  require($includeFilePath);
  // if ($realIncludePath !== false) {
  //   // echo "Full path to the included/required file: " . $realIncludePath;
  //  // Include the file
  // } else {
  //   echo "Included/required file not found.";
  // }
  header("Location:" . $basePath);
  exit;
}
$basePath = $_SESSION['basePath'];
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

  <title>Rangs Mobile Apps Admin Panel</title>

  <meta name="description" content="">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />

  <!-- Favicon -->
  <!-- <link rel="icon" type="image/x-icon" href="<?php echo $basePath ?>/assets/img/favicon/favicon.ico" > -->
  <link rel="icon" type="image/x-icon" href="<?php echo $basePath ?>/images/app_icon_hr.png">

  <!-- Fonts -->

  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/fonts/boxicons.css?v=0.2">

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/css/core.css" class="template-customizer-core-css">
  <link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css">
  <link rel="stylesheet" href="<?php echo $basePath ?>/assets/css/demo.css">

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">

  <link rel="stylesheet" href="<?php echo $basePath ?>/assets/vendor/libs/apex-charts/apex-charts.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css"
    integrity="sha512-y4S4cBeErz9ykN3iwUC4kmP/Ca+zd8n8FDzlVbq5Nr73gn1VBXZhpriQ7avR+8fQLpyq4izWm0b8s6q4Vedb9w==" crossorigin="anonymous"
    referrerpolicy="no-referrer">
  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="<?php echo $basePath ?>/assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="<?php echo $basePath ?>/assets/js/config.js"></script>
  <!-- // Echo the value of $dynamic_link_css to verify its content -->

  <?php
  if (isset($dynamic_link_css) && count($dynamic_link_css) > 0) {
    foreach ($dynamic_link_css as $key => $linkCss) {
      echo "<link rel='stylesheet' type='text/css' href='$linkCss'>";
    }
  }
  ?>


</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">