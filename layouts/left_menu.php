<!-- Menu -->
<?php
$v_active = 'active';
$v_active_open = 'active open';
$currentUrl = $_SERVER['REQUEST_URI'];
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
            <span class="demo menu-text fw-bolder mt-3" style="margin-left: 2px;">
                <h3>Rangs Group</h3>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->

        <li class="menu-item  <?php echo isActive('/leave_module/view'); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Leave Module</div>
            </a>


            <ul class="menu-sub">
                <li class="menu-item <?php echo isActive('/self_panel'); ?>">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div>Self Panel</div>
                    </a>
                    <ul class="menu-sub">
                        <?php if (checkPermission('self-leave-create')) { ?>
                            <li class="menu-item <?php echo isActive('/leave_module/view/self_panel/create.php'); ?>">
                                <a href="<?php echo $basePath ?>/leave_module/view/self_panel/create.php" class="menu-link withoutIcon">
                                    <div>
                                        <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                        Leave Create
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (checkPermission('self-leave-list')) { ?>
                            <li class="menu-item <?php echo isActive('/leave_module/view/self_panel/index.php'); ?>">
                                <a href="<?php echo $basePath ?>/leave_module/view/self_panel/index.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Report</div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if (checkPermission('hr-leave-create') || checkPermission('hr-leave-list')) { ?>
                    <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>HR Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('hr-leave-create')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/create.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/create.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Create</div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('hr-leave-list')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/index.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Report</div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('hr-leave-approval')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/approval.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/approval.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Approval</div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php //if (checkPermission('hr-leave-assign')) { 
                            ?>
                            <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/assign.php'); ?>">
                                <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/assign.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Assign</div>
                                </a>
                            </li>
                            <?php //} 
                            ?>
                            <?php //if (checkPermission('hr-leave-advance')) { 
                            ?>
                            <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/advance.php'); ?>">
                                <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/advance.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Advance</div>
                                </a>
                            </li>
                            <?php // } 
                            ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (checkPermission('lm-leave-create') || checkPermission('lm-leave-list')) { ?>
                    <li class="menu-item <?php echo isActive('/leave_module/view/lm_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>LM Panel</div>
                        </a>
                        <ul class="menu-sub">

                            <?php if (checkPermission('lm-leave-list')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/lm_panel/index.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/lm_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Report</div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('lm-leave-create')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/lm_panel/approval.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/lm_panel/approval.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Approval</div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (checkPermission('concern-leave-create') || checkPermission('concern-leave-list')) { ?>
                    <li class="menu-item <?php echo isActive('/leave_module/view/concern_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>Concern Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('concern-leave-create')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/concern_panel/create.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/concern_panel/create.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Create</div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('concern-leave-list')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/concern_panel/index.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/concern_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Report</div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>

        </li>

        <li class="menu-item <?php echo isActive('/tour_module/view'); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase"></i>
                <div>Tour Module</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?php echo isActive('/tour_module/view/self_panel'); ?>">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div>Self Panel</div>
                    </a>
                    <ul class="menu-sub">
                        <?php if (checkPermission('self-tour-create')) { ?>
                            <li class="menu-item <?php echo isActive('/tour_module/view/self_panel/create.php'); ?>">
                                <a href="<?php echo $basePath ?>/tour_module/view/self_panel/create.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Create</div>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (checkPermission('self-tour-report')) { ?>
                            <li class="menu-item <?php echo isActive('/tour_module/view/self_panel/index.php'); ?>">
                                <a href="<?php echo $basePath ?>/tour_module/view/self_panel/index.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Report</div>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </li>
                <?php if (checkPermission('hr-tour-create') || (checkPermission('hr-tour-report'))) { ?>
                    <li class="menu-item <?php echo isActive('/tour_module/view/hr_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>HR Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('hr-tour-create')) { ?>


                                <li class="menu-item <?php echo isActive('/tour_module/view/hr_panel'); ?>">
                                    <a href="<?php echo $basePath ?>/tour_module/view/hr_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Create</div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('hr-tour-report')) { ?>
                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/tour_module/view/hr_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Report</div>
                                    </a>
                                </li>
                            <?php } ?>


                        </ul>
                    </li>
                <?php } ?>
                <?php if (checkPermission('lm-tour-create') || (checkPermission('lm-tour-report'))) { ?>
                    <li class="menu-item <?php echo isActive('/tour_module/view/lm_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>LM Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('lm-tour-create')) { ?>

                                <li class="menu-item <?php echo isActive('/tour_module/view/lm_panel/index.php'); ?>">
                                    <a href="<?php echo $basePath ?>/tour_module/view/lm_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Report</div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('lm-tour-report')) { ?>

                                <li class="menu-item <?php echo isActive('/tour_module/view/lm_panel/approval.php'); ?>">
                                    <a href="<?php echo $basePath ?>/tour_module/view/lm_panel/approval.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Approval</div>
                                    </a>
                                </li>
                            <?php } ?>


                        </ul>
                    </li>
                <?php } ?>
                <?php if (checkPermission('concern-tour-create') || (checkPermission('concern-tour-report'))) { ?>

                    <li class="menu-item  <?php echo isActive('/tour_module/view/concern_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>Concern Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('concern-tour-create')) { ?>
                                <li class="menu-item <?php echo isActive('/tour_module/view/concern_panel/create.php'); ?>">
                                    <a href="<?php echo $basePath ?>/tour_module/view/concern_panel/create.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Create</div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('concern-tour-report')) { ?>

                                <li class="menu-item <?php echo isActive('/tour_module/view/concern_panel/index.php'); ?>">
                                    <a href="<?php echo $basePath ?>/tour_module/view/concern_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Report</div>
                                    </a>
                                </li>

                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

            </ul>
        </li>

        <!-- roster-list -->
        <?php if (checkPermission('roster-create') || (checkPermission('roster-list'))) { ?>

            <li class="menu-item <?php echo isActive('/roster'); ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                    <div data-i18n="Misc">Roster Module</div>
                </a>
                <ul class="menu-sub">
                    <?php if (checkPermission('roster-create')) { ?>
                        <li class="menu-item <?php echo isActive('/roster/view/create.php'); ?>">
                            <a href="<?php echo $basePath ?>/roster/view/create.php" class="menu-link">
                                <div data-i18n="Error">Roster Create</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ((checkPermission('roster-list'))) { ?>
                        <li class="menu-item <?php echo isActive('/roster/view/index.php'); ?>">
                            <a href="<?php echo $basePath ?>/roster/view/index.php" class="menu-link">
                                <div data-i18n="Under Maintenance">Roster List</div>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </li>

        <?php } ?>

        <li class="menu-item <?php echo isActive('/attendance_module/view'); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-fingerprint"></i>
                <div>Attendance Module</div>
            </a>
            <ul class="menu-sub">
                <?php if (checkPermission('self-attendance-report')) { ?>
                    <li class="menu-item <?php echo isActive('/attendance_module/view/self_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>Self Panel</div>
                        </a>
                        <ul class="menu-sub">

                            <li class="menu-item <?php echo isActive('/attendance_module/view/self_panel/index.php'); ?>">
                                <a href="<?php echo $basePath ?>/attendance_module/view/self_panel/index.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attend Report
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (checkPermission('hr-attendance-create') || checkPermission('hr-attendance-single-report') || checkPermission('hr-attendance-advance-report') || (checkPermission('hr-attendance-punch-data-syn'))) { ?>
                    <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel'); ?>"">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>HR Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('hr-attendance-create')) { ?>
                                <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel/manualEntry.php'); ?>">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/manualEntry.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Manual Entry</div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('hr-attendance-single-report')) { ?>
                                <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel/single_attendance.php'); ?>">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/single_attendance.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Single Report</div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('hr-attendance-advance-report')) { ?>
                                <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel/advance.php'); ?>">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/advance.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Advance Report</div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('hr-attendance-punch-data-syn')) { ?>

                                <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel/punch_data_syn.php'); ?>">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/punch_data_syn.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Punch Data Syn</div>
                                    </a>
                                </li>
                            <?php } ?>



                        </ul>
                    </li>
                <?php } ?>
                <?php if (checkPermission('lm-attendance-create') || (checkPermission('lm-attendance-report'))) { ?>

                    <li class="menu-item  <?php echo isActive('/attendance_module/view/lm_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>LM Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('lm-attendance-create')) { ?>
                                <li class="menu-item <?php echo isActive('/attendance_module/view/lm_panel/approval.php'); ?>">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/lm_panel/approval.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attend. Approval
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('lm-attendance-report')) { ?>

                                <li class="menu-item <?php echo isActive('/attendance_module/view/lm_panel/concern.php'); ?>">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/lm_panel/concern.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attend. Concern
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('lm-attendance-report')) { ?>
                                <li class="menu-item <?php echo isActive('/attendance_module/view/lm_panel/outdoor.php'); ?>">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/lm_panel/outdoor.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attend. Outdoor
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>


                        </ul>
                    </li>
                <?php } ?>

                <?php if (checkPermission('concern-attendance-create') || (checkPermission('concern-attendance-report'))) { ?>

                    <li class="menu-item <?php echo isActive('/attendance_module/view/concern_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>Concern Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('concern-attendance-create')) { ?>

                                <!-- <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module\view\concern_panel\create.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attendance Create
                                        </div>
                                    </a>
                                </li> -->
                            <?php } ?>
                            <?php if (checkPermission('concern-attendance-report')) { ?>
                                <li class="menu-item <?php echo isActive('/attendance_module/view/concern_panel/index.php'); ?>">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/concern_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>  Report
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>



                        </ul>
                    </li>
                <?php } ?>

            </ul>
        </li>
        <!-- -->
        <?php if (checkPermission('pms-list') || (checkPermission('pms-kra-list')) || (checkPermission('pms-kpi-list'))) { ?>

            <li class="menu-item  <?php echo isActive('/pms'); ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-crown"></i>
                    <div data-i18n="Misc">PMS Module</div>
                </a>
                <ul class="menu-sub">

                    <?php if (checkPermission('pms-list')) { ?>

                        <li class="menu-item <?php echo isActive('pms/view/pms_list_self.php'); ?>">
                            <a href="<?php echo $basePath ?>/pms/view/pms_list_self.php" class="menu-link">
                                <div data-i18n="Error">PMS List</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (checkPermission('pms-kra-list')) { ?>

                        <li class="menu-item <?php echo isActive('pms/view/pms_kra_create.php'); ?>">
                            <a href="<?php echo $basePath ?>/pms/view/pms_kra_create.php" class="menu-link">
                                <div data-i18n="Error">KRA List</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (checkPermission('pms-kpi-list')) { ?>

                        <li class="menu-item <?php echo isActive('pms/view/pms_kpi_list.php'); ?>">
                            <a href="<?php echo $basePath ?>/pms/view/pms_kpi_list.php" class="menu-link">
                                <div data-i18n="Under Maintenance">KPI List</div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

            </li>
        <?php } ?>

        <?php if (checkPermission('role-list') || (checkPermission('permission-list') ||  (checkPermission('role-permission-list'))
            || (checkPermission('user-role-list')))) { ?>


            <li class="menu-item  <?php echo isActive('/role_permission'); ?> ">

                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-accessibility"></i>

                    <div data-i18n="Misc"> Role Permission </div>
                </a>
                <ul class="menu-sub">
                    <?php if (checkPermission('role-list')) { ?>

                        <li class="menu-item <?php if ($v_page == 'role') echo $v_active; ?>">
                            <a href="<?php echo $basePath ?>/role_permission/role/index.php" class="menu-link">
                                <div data-i18n="Error">Role List</div>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (checkPermission('permission-list')) {
                    ?>

                        <li class="menu-item <?php if ($v_page == 'permission') echo $v_active; ?>">
                            <a href="<?php echo $basePath ?>/role_permission/permission/index.php" class="menu-link ">
                                <div data-i18n="Error">Permssion List</div>
                            </a>
                        </li>
                    <?php }  ?>

                    <?php if (checkPermission('role-permission-list')) {  ?>

                        <li class="menu-item <?php if ($v_page == 'role_permission') echo $v_active; ?>">
                            <a href="<?php echo $basePath ?>/role_permission/role_permission/index.php" class="menu-link">
                                <div data-i18n="Error">Role & Permission </div>
                            </a>
                        </li>
                    <?php  } ?>

                    <?php if (checkPermission('user-role-list')) { ?>

                        <li class="menu-item <?php if ($v_page == 'user_role') echo $v_active; ?>">
                            <a href="<?php echo $basePath ?>/role_permission/user_role/index.php" class="menu-link ">
                                <div data-i18n="Error">User Role</div>
                            </a>
                        </li>
                    <?php }
                    ?>




                </ul>
            </li>
        <?php } ?>



    </ul>
</aside>
<!-- / Menu -->