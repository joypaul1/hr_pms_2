<!-- Layout container -->
<div class="layout-page">

  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <!-- Search -->

      <form action="" method="post">
        <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <?php
            if ($_SESSION['HR']['hr_role'] == 2) { ?>
              <input type="text" name="search_input" class="form-control border-0 shadow-none"
                placeholder="Search Employee" aria-label="Search..." />
              <?php
            }
            ?>
          </div>
        </div>
      </form>

      <?php
      if (isset($_POST['search_input'])) {
        $v_search_input = $_REQUEST['search_input'];
        echo "<script>window.location = '".$basePath."/user_profile.php?emp_id=$v_search_input'</script>";
      }



      ?>

      <!-- /Search -->

      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Place this tag where you want the button to render. -->
        <li class="nav-item lh-1 me-3">
          <a class="github-button" href="" data-icon="octicon-star" data-size="large" data-show-count="true"
            aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">
            <strong>
              <?php echo $_SESSION['HR']['first_name_hr']; ?>
            </strong>
          </a>
        </li>

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
              <img
                src="<?php echo $_SESSION['HR']['emp_image_hr'] != null ?($basePath.'/'.$_SESSION['HR']['emp_image_hr']) : $baseUrl.'/'."assets/img/avatars/1.png"; ?>"
                alt class="w-px-40 h-auto rounded-circle" />
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="#">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img
                        src="<?php echo $_SESSION['HR']['emp_image_hr'] != null ?($basePath.'/'.$_SESSION['HR']['emp_image_hr']) : $basePath.'/'."assets/img/avatars/1.png"; ?>"
                        alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <span class="fw-semibold d-block">
                      <?php echo $_SESSION['HR']['first_name_hr']; ?>
                    </span>
                    <small class="text-muted">
                      <?php echo (implode(',', getUserAccessRoleByID($_SESSION['HR']['id_hr']))); ?>
                    </small>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="<?php  echo $basePath ?>/user_profile_self.php">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">My Profile</span>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="<?php  echo $basePath ?>/imageChange.php">
                <i class="bx bx-image me-2"></i>
                <span class="align-middle">Image Change</span>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="<?php  echo $basePath ?>/password_change.php">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">Password Change</span>
              </a>
            </li>

            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="<?php  echo $basePath ?>/index.php?logout_hr=true">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
              </a>
            </li>
          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>
  </nav>

  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->