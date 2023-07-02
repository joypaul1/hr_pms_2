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
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                        <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                        <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                        <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                    </defs>
                    <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                            <g id="Icon" transform="translate(27.000000, 15.000000)">
                                <g id="Mask" transform="translate(0.000000, 8.000000)">
                                    <mask id="mask-2" fill="white">
                                        <use xlink:href="#path-1"></use>
                                    </mask>
                                    <use fill="#696cff" xlink:href="#path-1"></use>
                                    <g id="Path-3" mask="url(#mask-2)">
                                        <use fill="#696cff" xlink:href="#path-3"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                    </g>
                                    <g id="Path-4" mask="url(#mask-2)">
                                        <use fill="#696cff" xlink:href="#path-4"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                    </g>
                                </g>
                                <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                    <use fill="#696cff" xlink:href="#path-5"></use>
                                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </span>
            <span class="demo menu-text fw-bolder ms-2 mt-3">
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

        <li class="menu-item  <?php echo isActive('/leave_module'); ?>">
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
                    <li class="menu-item <?php echo isActive('/hr_panel'); ?>">
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
                            <?php //if (checkPermission('hr-leave-assign')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/assign.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/assign.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Assign</div>
                                    </a>
                                </li>
                            <?php //} ?>
                            <?php //if (checkPermission('hr-leave-advance')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/advance.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/advance.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Advance</div>
                                    </a>
                                </li>
                            <?php // } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (checkPermission('lm-leave-create') || checkPermission('lm-leave-list')) { ?>
                    <li class="menu-item <?php echo isActive('/lm_panel'); ?>">
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
                    <li class="menu-item <?php echo isActive('/concern_panel'); ?>">
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
    
        <li class="menu-item <?php echo isActive('/tour_module'); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase"></i>
                <div>Tour Module</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?php echo isActive('/self_panel'); ?>">
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
                    <li class="menu-item <?php echo isActive('/hr_panel'); ?>" >
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>HR Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('hr-tour-create')) { ?>


                                <li class="menu-item <?php echo isActive('/hr_panel'); ?>">
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

                            <?php if (checkPermission('hr-tour-report')) { ?>

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

                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>Concern Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('concern-tour-report')) { ?>
                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/tour_module/view/self_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Create</div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('concern-tour-createt')) { ?>

                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/tour_module/view/self_panel/index.php" class="menu-link withoutIcon">
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

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-fingerprint"></i>
                <div>Attendance Module</div>
            </a>
            <ul class="menu-sub">
                <?php if (checkPermission('self-attendance-report')) { ?>
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>Self Panel</div>
                        </a>
                        <ul class="menu-sub">

                            <li class="menu-item ">
                                <a href="<?php echo $basePath ?>/attendance_module/view/self_panel/index.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attendance Report
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (checkPermission('hr-attendance-create') || checkPermission('hr-attendance-single-report') || checkPermission('hr-attendance-advance-report') || (checkPermission('hr-attendance-punch-data-syn'))) { ?>
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>HR Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('hr-attendance-create')) { ?>
                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/create.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Create</div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('hr-attendance-single-report')) { ?>
                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Single Report</div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('hr-attendance-advance-report')) { ?>
                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/advance.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Advance Report</div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPermission('hr-attendance-punch-data-syn')) { ?>

                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/punch_data_syn.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Punch Data Syn</div>
                                    </a>
                                </li>
                            <?php } ?>



                        </ul>
                    </li>
                <?php } ?>
                <?php if (checkPermission('lm-attendance-create') || (checkPermission('lm-attendance-report'))) { ?>

                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>LM Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('lm-attendance-create')) { ?>
                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module\view\lm_panel\create.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attendance Create
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('lm-attendance-report')) { ?>

                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module\view\lm_panel\index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attendance Report
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>


                        </ul>
                    </li>
                <?php } ?>

                <?php if (checkPermission('concern-attendance-create') || (checkPermission('concern-attendance-report'))) { ?>

                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>Concern Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (checkPermission('concern-attendance-create')) { ?>

                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module\view\concern_panel\create.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attendance Create
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPermission('concern-attendance-report')) { ?>
                                <li class="menu-item ">
                                    <a href="<?php echo $basePath ?>/attendance_module\view\concern_panel\index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attendance Report
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

            <li class="menu-item  <?php echo isActive('/pms');?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-crown"></i>
                    <div data-i18n="Misc">PMS Module</div>
                </a>
                <ul class="menu-sub">

                    <?php if (checkPermission('pms-list')) { ?>

                        <li class="menu-item <?php echo isActive('pms/view/pms_list_self.php');?>">
                            <a href="<?php echo $basePath ?>/pms/view/pms_list_self.php" class="menu-link">
                                <div data-i18n="Error">PMS List</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (checkPermission('pms-kra-list')) { ?>

                        <li class="menu-item <?php echo isActive('pms/view/pms_kra_create.php');?>">
                            <a href="<?php echo $basePath ?>/pms/view/pms_kra_create.php" class="menu-link">
                                <div data-i18n="Error">KRA List</div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (checkPermission('pms-kpi-list')) { ?>

                        <li class="menu-item <?php echo isActive('pms/view/pms_kpi_list.php');?>">
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


            <li class="menu-item  <?php echo isActive('/role_permission');?> ">

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