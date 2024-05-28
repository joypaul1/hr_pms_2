<!-- Menu -->
<?php
$v_active      = 'active';
$v_active_open = 'active open';
$currentUrl    = $_SERVER['REQUEST_URI'];
function isActive($url)
{
    global $currentUrl;
    return strpos($currentUrl, $url) !== false ? 'active open' : '';
}
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?php echo $basePath ?>/home/dashboard.php" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?php echo $basePath ?>/images/app_icon_hr.png" class="img-fluid" style="width: 35px;">
            </span>
            <span class=" fw-bolder mt-3" style="margin-left: 2px;">
                <h3 class="text-white">Rangs Group</h3>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <section style="width: 98%;">
            <!-- Application Setting Module -->

            <?php if (checkPermission('designation-list') || (checkPermission('branch-list')) || (checkPermission('department-list')) || checkPermission('holiday-list')) { ?>

                <li class="menu-item  <?php echo isActive('/admin_setting/view'); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-cog"></i>
                        <div data-i18n="Misc">Admin Setting </div>
                    </a>
                    <ul class="menu-sub">

                        <?php //if (checkPermission('department-list')) { ?>

                        <li class="menu-item <?php echo isActive('admin_setting/view/duplicate_att.php'); ?>">
                            <a href="<?php echo $basePath ?>/admin_setting/view/duplicate_att.php" class="menu-link">
                                <div> Duplicate Attendance </div>
                            </a>
                        </li>
                        <?php //} ?>
                        <?php //if (checkPermission('department-list')) { ?>
                        <li class="menu-item <?php echo isActive('admin_setting/view/grace_period.php'); ?>">
                            <a href="<?php echo $basePath ?>/admin_setting/view/grace_period.php" class="menu-link">
                                <div> Grace Period </div>
                            </a>
                        </li>
                        <?php //} ?>
                        <?php //if (checkPermission('department-list')) { ?>
                        <li class="menu-item <?php echo isActive('admin_setting/view/leave_delete.php'); ?>">
                            <a href="<?php echo $basePath ?>/admin_setting/view/leave_delete.php" class="menu-link">
                                <div> Leave Delete </div>
                            </a>
                        </li>
                        <?php //} ?>
                        <?php if (checkPermission('department-list')) { ?>

                            <li class="menu-item <?php echo isActive('admin_setting/view/department.php'); ?>">
                                <a href="<?php echo $basePath ?>/admin_setting/view/department.php" class="menu-link">
                                    <div>Department List</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (checkPermission('designation-list')) { ?>

                            <li class="menu-item <?php echo isActive('admin_setting/view/designation.php'); ?>">
                                <a href="<?php echo $basePath ?>/admin_setting/view/designation.php" class="menu-link">
                                    <div>Designation List</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (checkPermission('branch-list')) { ?>

                            <li class="menu-item <?php echo isActive('admin_setting/view/branch.php'); ?>">
                                <a href="<?php echo $basePath ?>/admin_setting/view/branch.php" class="menu-link">
                                    <div>Branch List</div>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (checkPermission('holiday-list')) { ?>
                            <li class="menu-item <?php echo isActive('admin_setting/view/holiday.php'); ?>">
                                <a href="<?php echo $basePath ?>/admin_setting/view/holiday.php" class="menu-link">
                                    <div data-i18n="Under Maintenance">Holiday List</div>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (checkPermission('user-create')) { ?>

                            <li class="menu-item <?php echo isActive('admin_setting/view/user_create.php'); ?>">
                                <a href="<?php echo $basePath ?>/admin_setting/view/user_create.php" class="menu-link">
                                    <div data-i18n="Under Maintenance"> User Create</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (checkPermission('user-list')) { ?>

                            <li class="menu-item <?php echo isActive('admin_setting/view/user_list.php'); ?>">
                                <a href="<?php echo $basePath ?>/admin_setting/view/user_list.php" class="menu-link">
                                    <div data-i18n="Under Maintenance"> User List</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (checkPermission('user-transfer')) { ?>
                            <li class="menu-item <?php echo isActive('admin_setting/view/user_transfer.php'); ?>">
                                <a href="<?php echo $basePath ?>/admin_setting/view/user_transfer.php" class="menu-link">
                                    <div data-i18n="Under Maintenance"> User Transfer</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (checkPermission('concern-work-station')) { ?>
                            <li class="menu-item <?php echo isActive('admin_setting/view/workstation.php'); ?>">
                                <a href="<?php echo $basePath ?>/admin_setting/view/workstation.php" class="menu-link">
                                    <div data-i18n="Under Maintenance"> Work Station Change</div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                </li>
            <?php } ?>

            <!-- Application Setting Module -->
            <!-- role&permission Module -->

            <?php if (
                checkPermission('role-list') || (checkPermission('permission-list') || (checkPermission('role-permission-list')) || (checkPermission('user-role-list')))
            ) { ?>

                <li class="menu-item  <?php echo isActive('/role_permission'); ?> ">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-accessibility"></i>
                        <div data-i18n="Misc"> Role Permission </div>
                    </a>
                    <ul class="menu-sub">
                        <?php if (checkPermission('role-list')) { ?>
                            <li class="menu-item <?php if ($v_page == 'role') echo $v_active; ?>">
                                <a href="<?php echo $basePath ?>/role_permission/role/index.php" class="menu-link">
                                    <div>Role List</div>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (checkPermission('permission-list')) { ?>

                            <li class="menu-item <?php if ($v_page == 'permission') echo $v_active; ?>">
                                <a href="<?php echo $basePath ?>/role_permission/permission/index.php" class="menu-link ">
                                    <div>Permssion List</div>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (checkPermission('role-permission-list')) { ?>

                            <li class="menu-item <?php if ($v_page == 'role_permission') echo $v_active; ?>">
                                <a href="<?php echo $basePath ?>/role_permission/role_permission/index.php" class="menu-link">
                                    <div>Role & Permission </div>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (checkPermission('user-role-list')) { ?>

                            <li class="menu-item <?php if ($v_page == 'user_role') echo $v_active; ?>">
                                <a href="<?php echo $basePath ?>/role_permission/user_role/index.php" class="menu-link ">
                                    <div>User Role</div>
                                </a>
                            </li>
                        <?php } ?>




                    </ul>
                </li>
            <?php } ?>

    </ul>
</aside>
<!-- / Menu -->