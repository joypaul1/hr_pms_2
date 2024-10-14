<?php
$emp_session_id      = $_SESSION['HR_APPS']['emp_id_hr'];
$objConnect          = oci_connect("DEVELOPERS", "Test1234", "10.99.99.20:1525/ORCLPDB", 'AL32UTF8');
$notification_number = 0;
$sqlQuary            = "SELECT sum(NUMBER_TOTAL) AS TOTAL_NOTI from V_HR_APPROVAL_LIST where LINE_MANAGER_RML_ID='$emp_session_id'";
$allDataSQL          = @oci_parse($objConnect, $sqlQuary);
@oci_execute($allDataSQL);
while ($row = @oci_fetch_assoc($allDataSQL)) {
  $notification_number = $row['TOTAL_NOTI'];
}
?>


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

            <form action="<?php echo ($basePath . '/admin_setting/view/user_profile.php') ?>" method="GET">
                <div class="navbar-nav align-items-center">
                    <div class="nav-item d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <?php if (getUserWiseRoleName('super-admin') || getUserWiseRoleName('hr')) { ?>
                            <input type="text" name="emp_id" class="form-control border-0 shadow-none"
                            placeholder="Search Employee" aria-label="Search...">
                        <?php
            }
            ?>
                    </div>
                </div>
            </form>


            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                    <a class="github-button" href="" data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">
                        <strong>
                            <?php echo $_SESSION['HR_APPS']['first_name_hr']; ?>
                        </strong>
                    </a>
                </li>
                <!-- notification  -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        <i class="bx bx-bell bx-sm" style="color:orangered"></i>
                        <span
                            class="badge bg-danger rounded-pill badge-notifications"><?php echo $notification_number; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0">
                        <li class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto">Approval Notification</h5>
                                <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                    data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark all as read"
                                    data-bs-original-title="Mark all as read"><i
                                        class="bx fs-4 bx-envelope-open"></i></a>
                            </div>
                        </li>
                        <li class="dropdown-notifications-list scrollable-container ps">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-group-item-action dropdown-notifications-item">


                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <table class="table table-bordered">
                                                <?php
                        $sqlQuary   = "SELECT APPROVAL_TYPE,NUMBER_TOTAL,APPROVAL_LINK from V_HR_APPROVAL_LIST where LINE_MANAGER_RML_ID='$emp_session_id'";
                        $allDataSQL = oci_parse($objConnect, $sqlQuary);
                        oci_execute($allDataSQL);
                        while ($row = oci_fetch_assoc($allDataSQL)) {
                          ?>

                                                <tr>
                                                    <td style="width: 70%;"><?php echo $row['APPROVAL_TYPE']; ?></td>
                                                    <td style="width: 30%;" align="center">
                                                        <a target="_blank"
                                                            href=<?php echo $row['APPROVAL_LINK']; ?>><span
                                                                class="badge badge-center rounded-pill bg-warning"><?php echo $row['NUMBER_TOTAL']; ?></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                        }
                        ?>

                                            </table>
                                        </div>
                                    </div>

                                </li>

                            </ul>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                            </div>
                        </li>


                    </ul>
                </li>
                <!-- notification  -->
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="<?php echo $_SESSION['HR_APPS']['emp_image_hr'] != null ? ($basePath . '/' . $_SESSION['HR_APPS']['emp_image_hr']) : $basePath . '/' . "assets/img/avatars/1.png"; ?>"
                                alt class="w-px-40 h-auto rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="<?php echo $_SESSION['HR_APPS']['emp_image_hr'] != null ? ($basePath . '/' . $_SESSION['HR_APPS']['emp_image_hr']) : $basePath . '/' . "assets/img/avatars/1.png"; ?>"
                                                alt class="w-px-40 h-auto rounded-circle">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">
                                            <?php echo $_SESSION['HR_APPS']['first_name_hr']; ?>
                                        </span>
                                        <small class="text-muted">
                                            <?php echo (implode(',', getUserAccessRoleByID($_SESSION['HR_APPS']['id_hr']))); ?>
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $basePath ?>/user_profile_self.php">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $basePath ?>/imageChange.php">
                                <i class="bx bx-image me-2"></i>
                                <span class="align-middle">Image Change</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $basePath ?>/password_change.php">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">Password Change</span>
                            </a>
                        </li>

                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $basePath ?>/index.php?logout_hr=true">
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