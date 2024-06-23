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
        <li class="menu-item <?php echo isActive('/home/dashboard.php'); ?>">
            <a href="<?php echo $basePath ?>/home/dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Home</div>
            </a>
        </li>
        <?php if (checkPermission('loyalty-card-all-module')) { ?>
            <li class="menu-header big text-uppercase" style="background-color: #18392B;">
                <span class="text-white"><b>Loyalty Card System </b></span>
            </li>
            <section style="width: 98%;">
                <!-- Resale- module-list -->
                <li class="menu-item  <?php echo isActive('/loyalty_card_module/view'); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-registered"></i>
                        <div>Loyalty Card Module</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item <?php echo isActive('/loyalty_card_module/view/dashboard_panel/cardDashboard.php'); ?>  ">
                            <a href="<?php echo $basePath ?>/loyalty_card_module/view/dashboard_panel/cardDashboard.php" class="menu-link ">
                                <div>Dashboard Panel</div>
                            </a>
                        </li>

                        <li class="menu-item <?php echo isActive('/loyalty_card_module/view/self_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>Card Panel</div>
                            </a>
                            <ul class="menu-sub">

                                <li class="menu-item <?php echo isActive('/loyalty_card_module/view/self_panel/create.php'); ?> ">
                                    <a href="<?php echo $basePath ?>/loyalty_card_module/view/self_panel/create.php" class="menu-link withoutIcon">
                                        <div>
                                            <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                            Create Card
                                        </div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo isActive('/loyalty_card_module/view/self_panel/list.php'); ?>">
                                    <a href="<?php echo $basePath ?>/loyalty_card_module/view/self_panel/list.php" class="menu-link withoutIcon">
                                        <div>
                                            <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                            List Of Card
                                        </div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo isActive('/loyalty_card_module/view/self_panel/cardReport.php'); ?>">
                                    <a href="<?php echo $basePath ?>/loyalty_card_module/view/self_panel/cardReport.php" class="menu-link withoutIcon">
                                        <div>
                                            <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                            Card OF Report
                                        </div>
                                    </a>
                                </li>


                            </ul>
                        </li>
                    </ul>

                </li>
            </section>
        <?php } ?>
        <?php if (checkPermission('resale-dashboard-panel') || checkPermission('resale-product-panel') || checkPermission('resale-report-panel')) { ?>
            <li class="menu-header big text-uppercase" style="background-color: #18392B;">
                <span class="text-white"><b>Resale Bidding System </b></span>
            </li>
            <section style="width: 98%;">
                <!-- Resale- module-list -->
                <li class="menu-item  <?php echo isActive('/resale_module/view'); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-registered"></i>
                        <div>Resale Module</div>
                    </a>


                    <ul class="menu-sub">

                        <?php if (checkPermission('resale-dashboard-panel')) { ?>
                            <li class="menu-item <?php echo isActive('/resale_module/view/dashboard_panel/resaleDashboard.php'); ?>  ">
                                <a href="<?php echo $basePath ?>/resale_module/view/dashboard_panel/resaleDashboard.php" class="menu-link ">
                                    <div>Dashboard Panel</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (checkPermission('resale-product-panel')) { ?>
                            <li class="menu-item <?php echo isActive('/resale_module/view/self_panel'); ?>">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div>Product Panel</div>
                                </a>
                                <ul class="menu-sub">

                                    <li class="menu-item <?php echo isActive('/resale_module/view/self_panel/pendingList.php'); ?> ">
                                        <a href="<?php echo $basePath ?>/resale_module/view/self_panel/pendingList.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Pending List
                                            </div>
                                        </a>
                                    </li>
                                    <li
                                        class="menu-item <?php echo isActive('/resale_module/view/self_panel/prepublishedList.php'); ?> <?php echo isActive('/resale_module/view/self_panel/edit.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/self_panel/prepublishedList.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Pre-Published List
                                            </div>
                                        </a>
                                    </li>

                                    <li class="menu-item <?php echo isActive('/resale_module/view/self_panel/publishedList.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/self_panel/publishedList.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Published List
                                            </div>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (checkPermission('resale-report-panel')) { ?>
                            <li class="menu-item <?php echo isActive('/resale_module/view/bidreport_panel'); ?>">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div>Bid Panel</div>
                                </a>
                                <ul class="menu-sub">

                                    <li
                                        class="menu-item <?php echo isActive('/resale_module/view/bidreport_panel/bidReport.php'); ?> <?php echo isActive('/resale_module/view/bidreport_panel/edit.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/bidreport_panel/bidReport.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Bid Report
                                            </div>
                                        </a>
                                    </li>
                                    <li
                                        class="menu-item <?php echo isActive('/resale_module/view/bidreport_panel/bidSummary.php'); ?> <?php echo isActive('/resale_module/view/bidreport_panel/edit.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/bidreport_panel/bidSummary.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Bid Summary
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-item <?php echo isActive('/resale_module/view/report_panel'); ?>">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div>Report Panel</div>
                                </a>
                                <ul class="menu-sub">

                                    <li class="menu-item <?php echo isActive('/resale_module/view/report_panel/product_info.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/report_panel/product_info.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Product Info.
                                            </div>
                                        </a>
                                    </li>
                                    <li class="menu-item <?php echo isActive('/resale_module/view/report_panel/web_user.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/report_panel/web_user.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Web User List
                                            </div>
                                        </a>
                                    </li>
                                    <li class="menu-item <?php echo isActive('/resale_module/view/report_panel/contact_list.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/report_panel/contact_list.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Contact List
                                            </div>
                                        </a>
                                    </li>
                                    <li class="menu-item <?php echo isActive('/resale_module/view/report_panel/subscriber_list.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/report_panel/subscriber_list.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Subscriber List
                                            </div>
                                        </a>
                                    </li>



                                </ul>
                            </li>

                            <li class="menu-item <?php echo isActive('/resale_module/view/form_panel'); ?>">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div>Form Panel</div>
                                </a>
                                <ul class="menu-sub">

                                    <li
                                        class="menu-item <?php echo isActive('/resale_module/view/form_panel/customer_review/index.php'); ?><?php echo isActive('/resale_module/view/form_panel/customer_review/create.php'); ?><?php echo isActive('/resale_module/view/form_panel/customer_review/edit.php'); ?>">
                                        <a href="<?php echo $basePath ?>/resale_module/view/form_panel/customer_review/index.php"
                                            class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Customer Review
                                            </div>
                                        </a>
                                    </li>
                                    <li class="menu-item <?php echo isActive('/resale_module/view/form_panel/sale_concern/index.php'); ?>
                                <?php echo isActive('/resale_module/view/form_panel/sale_concern/create.php'); ?>
                                <?php echo isActive('/resale_module/view/form_panel/sale_concern/edit.php'); ?>
                                ">
                                        <a href="<?php echo $basePath ?>/resale_module/view/form_panel/sale_concern/index.php" class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Sale Concern
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>



                    </ul>

                </li>
            </section>
        <?php } ?>
        <li class="menu-header big text-uppercase" style="background-color: #18392B;">
            <span class="text-white"><b> HR Apps System</b></span>
        </li>
        <section style="width: 98%;">
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
                            <?php if (checkPermission('self-leave-report')) { ?>
                                <li class="menu-item <?php echo isActive('/leave_module/view/self_panel/index.php'); ?>">
                                    <a href="<?php echo $basePath ?>/leave_module/view/self_panel/index.php" class="menu-link withoutIcon">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Report
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>

                    <?php if (checkPermission('hr-leave-create') || checkPermission('hr-leave-report')) { ?>
                        <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>HR Panel</div>
                            </a>
                            <ul class="menu-sub">
                                <?php if (checkPermission('hr-leave-create')) { ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/create.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/create.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Create
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('hr-leave-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/index.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/index.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Report
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('hr-leave-approval')) { ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/approval.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/approval.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Approval
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('hr-leave-assign')) {
                                    ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/assign.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/assign.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Assign
                                                (R&C)
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('hr-leave-advance')) {
                                    ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/hr_panel/advance.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/hr_panel/advance.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Advance
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (checkPermission('lm-leave-approval') || checkPermission('lm-leave-report')) { ?>
                        <li class="menu-item <?php echo isActive('/leave_module/view/lm_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>LM Panel</div>
                            </a>
                            <ul class="menu-sub">

                                <?php if (checkPermission('lm-leave-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/lm_panel/index.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/lm_panel/index.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Report
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('lm-leave-approval')) { ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/lm_panel/approval.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/lm_panel/approval.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Approval
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        checkPermission('concern-leave-create') ||
                        checkPermission('concern-leave-delete') ||
                        checkPermission('concern-leave-report')
                    ) { ?>
                        <li class="menu-item <?php echo isActive('/leave_module/view/concern_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>Concern Panel</div>
                            </a>
                            <ul class="menu-sub">
                                <?php if (checkPermission('concern-leave-create')) { ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/concern_panel/create.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/concern_panel/create.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Create
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('concern-leave-delete')) { ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/concern_panel/delete.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/concern_panel/delete.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Delete
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('concern-leave-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/leave_module/view/concern_panel/index.php'); ?>">
                                        <a href="<?php echo $basePath ?>/leave_module/view/concern_panel/index.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Leave Report
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>

            </li>
            <!-- Leave- module-list -->

            <!-- Tour- module-list -->

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


                                    <li class="menu-item <?php echo isActive('/tour_module/view/hr_panel/create.php'); ?>">
                                        <a href="<?php echo $basePath ?>/tour_module/view/hr_panel/create.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Create</div>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (checkPermission('hr-tour-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/tour_module/view/hr_panel/index.php'); ?>">
                                        <a href="<?php echo $basePath ?>/tour_module/view/hr_panel/index.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Report</div>
                                        </a>
                                    </li>
                                <?php } ?>


                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (checkPermission('lm-tour-approval') || (checkPermission('lm-tour-report'))) { ?>
                        <li class="menu-item <?php echo isActive('/tour_module/view/lm_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>LM Panel</div>
                            </a>
                            <ul class="menu-sub">
                                <?php if (checkPermission('lm-tour-report')) { ?>

                                    <li class="menu-item <?php echo isActive('/tour_module/view/lm_panel/index.php'); ?>">
                                        <a href="<?php echo $basePath ?>/tour_module/view/lm_panel/index.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Report</div>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (checkPermission('lm-tour-approval')) { ?>

                                    <li class="menu-item <?php echo isActive('/tour_module/view/lm_panel/approval.php'); ?>">
                                        <a href="<?php echo $basePath ?>/tour_module/view/lm_panel/approval.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Tour Approval
                                            </div>
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
            <!-- tour- module-list -->

            <!-- attendance-module-list -->

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
                    <?php if (checkPermission('hr-attendance-manual-entry') || checkPermission('hr-attendance-single-report') || checkPermission('hr-attendance-advance-report') || (checkPermission('hr-attendance-punch-data-syn'))) { ?>
                        <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel'); ?>"">
                        <a href=" javascript:void(0)" class="menu-link menu-toggle">
                            <div>HR Panel</div>
                            </a>
                            <ul class="menu-sub">
                                <?php if (checkPermission('hr-attendance-manual-entry')) { ?>
                                    <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel/manualEntry.php'); ?>">
                                        <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/manualEntry.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Manual Entry
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('hr-attendance-single-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel/single_attendance.php'); ?>">
                                        <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/single_attendance.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Single Report
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (checkPermission('hr-attendance-advance-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel/advance.php'); ?>">
                                        <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/advance.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Advance Report
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>



                                <?php if (checkPermission('hr-attendance-punch-data-syn')) { ?>

                                    <li class="menu-item <?php echo isActive('/attendance_module/view/hr_panel/punch_data_syn.php'); ?>">
                                        <a href="<?php echo $basePath ?>/attendance_module/view/hr_panel/punch_data_syn.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Punch Data Syn
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>



                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (checkPermission('lm-attendance-concern') || (checkPermission('lm-attendance-approval')) || (checkPermission('lm-attendance-outdoor'))) { ?>

                        <li class="menu-item  <?php echo isActive('/attendance_module/view/lm_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>LM Panel</div>
                            </a>
                            <ul class="menu-sub">
                                <?php if (checkPermission('lm-attendance-approval')) { ?>
                                    <li class="menu-item <?php echo isActive('/attendance_module/view/lm_panel/approval.php'); ?>">
                                        <a href="<?php echo $basePath ?>/attendance_module/view/lm_panel/approval.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attend. Approval
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('lm-attendance-concern')) { ?>

                                    <li class="menu-item <?php echo isActive('/attendance_module/view/lm_panel/concern.php'); ?>">
                                        <a href="<?php echo $basePath ?>/attendance_module/view/lm_panel/concern.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Attend. Concern
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('lm-attendance-outdoor')) { ?>
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
                    <?php if ((checkPermission('concern-attendance-report'))) { ?>

                        <li class="menu-item <?php echo isActive('/attendance_module/view/concern_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>Concern Panel</div>
                            </a>
                            <ul class="menu-sub">

                                <?php if (checkPermission('concern-attendance-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/attendance_module/view/concern_panel/index.php'); ?>">
                                        <a href="<?php echo $basePath ?>/attendance_module/view/concern_panel/index.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Report
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('concern-attendance-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/attendance_module/view/concern_panel/punch_data_syn.php'); ?>">
                                        <a href="<?php echo $basePath ?>/attendance_module/view/concern_panel/punch_data_syn.php"
                                            class="menu-link withoutIcon">
                                            <div>
                                                <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> W.S. Punch Data Syn
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>



                            </ul>
                        </li>
                    <?php } ?>

                </ul>
            </li>
            <!-- attendance-module-list -->
            <!-- offboarding Module  -->
            <?php if (checkPermission('hr-offboarding-create') || checkPermission('lm-offboarding-report') || checkPermission('lm-offboarding-approval') || (checkPermission('concern-offboarding-create')) || (checkPermission('concern-offboarding-report'))) { ?>
                <li class="menu-item  <?php echo isActive('/offboarding_module/view'); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-file "></i>
                        <div>Offboarding Module</div>
                    </a>

                    <ul class="menu-sub">
                        <?php if (checkPermission('hr-offboarding-create') || checkPermission('hr-offboarding-report')) { ?>
                            <li class="menu-item <?php echo isActive('/offboarding_module/view/hr_panel'); ?>">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div>HR Panel</div>
                                </a>
                                <ul class="menu-sub">

                                    <?php if (checkPermission('hr-offboarding-report')) { ?>
                                        <li
                                            class="menu-item <?php echo isActive('/offboarding_module/view/hr_panel/create.php'); ?> <?php echo isActive('/offboarding_module/view/hr_panel/index.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/hr_panel/index.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> List</div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (checkPermission('hr-offboarding-approval')) { ?>
                                        <li class="menu-item <?php echo isActive('/offboarding_module/view/hr_panel/approval.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/hr_panel/approval.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Approval</div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (checkPermission('hr-offboarding-exit-interview')) { ?>
                                        <li class="menu-item <?php echo isActive('/offboarding_module/view/hr_panel/exit_interview.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/hr_panel/exit_interview.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Exit Interview
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (checkPermission("hr-offboarding-id-assign-list")) { ?>
                                        <li
                                            class="menu-item <?php echo isActive('/offboarding_module/view/hr_panel/id_assign.php'); ?><?php echo isActive('/offboarding_module/view/hr_panel/id_assign_list.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/hr_panel/id_assign_list.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> ID Assign List
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (checkPermission('lm-offboarding-approval') || checkPermission('lm-offboarding-report')) { ?>
                            <li class="menu-item <?php echo isActive('/offboarding_module/view/lm_panel'); ?>">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div>LM Panel</div>
                                </a>
                                <ul class="menu-sub">
                                    <?php if (checkPermission('lm-hod-approval')) { ?>
                                        <li class="menu-item <?php echo isActive('/offboarding_module/view/lm_panel/hod_approval.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/lm_panel/hod_approval.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> HOD Approval
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (checkPermission('lm-offboarding-approval')) { ?>
                                        <li class="menu-item <?php echo isActive('/offboarding_module/view/lm_panel/approval.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/lm_panel/approval.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Offboarding
                                                    Approval</div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (checkPermission('lm-offboarding-report')) { ?>
                                        <li class="menu-item <?php echo isActive('/offboarding_module/view/lm_panel/index.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/lm_panel/index.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Offboarding
                                                    Report</div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($_SESSION['HR_APPS']['emp_id_hr'] == "RMWL-0605" || $_SESSION['HR_APPS']['emp_id_hr'] == "RMWL-0942") { ?>
                                        <li class="menu-item <?php echo isActive('/offboarding_module/view/lm_panel/exit_interview.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/lm_panel/exit_interview.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Exit Interview
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (checkPermission('concern-offboarding-create') || checkPermission('concern-offboarding-report')) { ?>
                            <li class="menu-item <?php echo isActive('/offboarding_module/view/concern_panel'); ?>">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div>Concern Panel</div>
                                </a>
                                <ul class="menu-sub">
                                    <?php if (checkPermission('concern-offboarding-create')) {

                                        ?>
                                        <li class="menu-item <?php echo isActive('/offboarding_module/view/concern_panel/create.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/concern_panel/create.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Offboarding
                                                    Create</div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (checkPermission('concern-offboarding-report')) { ?>
                                        <li class="menu-item <?php echo isActive('/offboarding_module/view/concern_panel/index.php'); ?>">
                                            <a href="<?php echo $basePath ?>/offboarding_module/view/concern_panel/index.php" class="menu-link withoutIcon">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Offboarding
                                                    Report</div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>

                </li>
            <?php } ?>
            <!-- offboarding Module  -->
            <!-- pms Module  -->


            <li class="menu-item  <?php echo isActive('/pms_module/view'); ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-crown"></i>
                    <div data-i18n="Misc">PMS Module</div>

                </a>

                <ul class="menu-sub">

                    <li class="menu-item <?php echo isActive('/pms_module/view/self_panel'); ?>">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <div>Self Panel</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item <?php echo isActive('pms_module/view/self_panel/pms_list_self.php'); ?>">
                                <a href="<?php echo $basePath ?>/pms_module/view/self_panel/pms_list_self.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>PMS List</div>
                                </a>
                            </li>


                            <li class="menu-item <?php echo isActive('pms_module/view/self_panel/pms_kra_create.php'); ?>">
                                <a href="<?php echo $basePath ?>/pms_module/view/self_panel/pms_kra_create.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>KRA List</div>
                                </a>
                            </li>

                            <li class="menu-item <?php echo isActive('pms_module/view/self_panel/pms_kpi_list.php'); ?>">
                                <a href="<?php echo $basePath ?>/pms_module/view/self_panel/pms_kpi_list.php" class="menu-link withoutIcon">
                                    <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>KPI List</div>
                                </a>
                            </li>


                        </ul>
                    </li>
                    <?php if (checkPermission('pms-hr-approval') || checkPermission('pms-hr-report')) { ?>
                        <li class="menu-item <?php echo isActive('/pms_module/view/hr_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>HR Panel</div>
                            </a>
                            <ul class="menu-sub">


                                <?php if (checkPermission('pms-hr-approval')) { ?>
                                    <li class="menu-item <?php echo isActive('/pms_module/view/hr_panel/approval.php'); ?>">
                                        <a href="<?php echo $basePath ?>/pms_module/view/hr_panel/approval.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Approval</div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('pms-hr-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/pms_module/view/hr_panel/report.php'); ?>">
                                        <a href="<?php echo $basePath ?>/pms_module/view/hr_panel/report.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Report</div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('pms-hr-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/pms_module/view/hr_panel/gradeReport.php'); ?>">
                                        <a href="<?php echo $basePath ?>/pms_module/view/hr_panel/gradeReport.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Grade Report
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('pms-hr-year-create')) { ?>
                                    <li class="menu-item <?php echo isActive('/pms_module/view/hr_panel/year.php'); ?>">
                                        <a href="<?php echo $basePath ?>/pms_module/view/hr_panel/year.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Year Create</div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (checkPermission('pms-lm-approval') || checkPermission('pms-lm-report') || checkPermission('pms-hod-approval') || checkPermission('pms-hod-report')) { ?>
                        <li class="menu-item <?php echo isActive('/pms_module/view/lm_panel'); ?> <?php echo isActive('/pms_module/view/hod_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>LM Panel</div>
                            </a>
                            <ul class="menu-sub">
                                <?php if (checkPermission('pms-lm-approval')) { ?>
                                    <li class="menu-item <?php echo isActive('/pms_module/view/lm_panel/approval.php'); ?>">
                                        <a href="<?php echo $basePath ?>/pms_module/view/lm_panel/approval.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>LM Approval</div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('pms-lm-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/pms_module/view/lm_panel/report.php'); ?>">
                                        <a href="<?php echo $basePath ?>/pms_module/view/lm_panel/report.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>LM Report</div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('pms-hod-approval')) { ?>
                                    <li class="menu-item <?php echo isActive('/pms_module/view/hod_panel/approval.php'); ?>">
                                        <a href="<?php echo $basePath ?>/pms_module/view/hod_panel/approval.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>HOD Approval</div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('pms-hod-report')) { ?>
                                    <li class="menu-item <?php echo isActive('/pms_module/view/hod_panel/report.php'); ?>">
                                        <a href="<?php echo $basePath ?>/pms_module/view/hod_panel/report.php" class="menu-link withoutIcon">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>HOD Report</div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                </ul>

            </li>

            <!--pms Module -->


            <!-- Report - module-list -->


            <li class="menu-item <?php echo isActive('/report_module'); ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                    <div data-i18n="Misc">Report Module</div>
                </a>
                <ul class="menu-sub">

                    <?php if (checkPermission('accounts-clearance-report')) { ?>
                        <li class="menu-item <?php echo isActive('/report_module/view/accounts_clearance.php'); ?>">
                            <a href="<?php echo $basePath ?>/report_module/view/accounts_clearance.php" class="menu-link">
                                <div>Accounts Clearance</div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <!-- Report-list -->
            <!-- car Deed -->

            <?php if (checkPermission('deed-create')) { ?>

                <li class="menu-item  <?php echo isActive('/deed_module/view'); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-file "></i>
                        <div>Deed Module</div>
                    </a>
                    <ul class="menu-sub">

                        <li class="menu-item <?php echo isActive('/deed_module/view/form_panel'); ?>">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>Form Panel</div>
                            </a>
                            <ul class="menu-sub">
                                <?php if (checkPermission('deed-create')) { ?>
                                    <li class="menu-item <?php echo isActive('/deed_module/view/form_panel/create.php'); ?>">
                                        <a href="<?php echo $basePath ?>/deed_module/view/form_panel/create.php" class="menu-link">
                                            <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Create </div>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkPermission('upload-document')) { ?>

                                    <li class="menu-item <?php echo isActive('/deed_module/view/form_panel/upload_doc.php'); ?>">
                                        <a href="<?php echo $basePath ?>/deed_module/view/form_panel/upload_doc.php" class="menu-link">
                                            <div><i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Upload Doc.
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (checkPermission('upload-check')) { ?>

                                    <li class="menu-item <?php echo isActive('/deed_module/view/form_panel/upload_cheque.php'); ?>">
                                        <a href="<?php echo $basePath ?>/deed_module/view/form_panel/upload_cheque.php" class="menu-link">
                                            <div><i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i>
                                                Upload Cheque
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </li>
                        <?php ?>

                        <?php if (checkPermission('report-one')) { ?>
                            <li class="menu-item <?php echo isActive('/deed_module/view/report_panel'); ?>">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div>Report Panel</div>
                                </a>
                                <ul class="menu-sub">
                                    <?php if (checkPermission('report-one')) { ?>

                                        <li class="menu-item <?php echo isActive('/deed_module/view/report_panel/complete_deed.php'); ?>">
                                            <a href="<?php echo $basePath ?>/deed_module/view/report_panel/complete_deed.php" class="menu-link">
                                                <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Complete Deed
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </li>
                        <?php } ?>


                        <li class="menu-item">
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                <div>User Manual</div>
                            </a>
                            <ul class="menu-sub">

                                <li class="menu-item ">
                                    <a href="#" class="menu-link">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Module </div>
                                    </a>
                                </li>
                                <li class="menu-item ">
                                    <a href="#" class="menu-link">
                                        <div> <i class="menu-icon tf-icon bx bx-subdirectory-right" style="margin:0;font-size:20px"></i> Root Path </div>
                                    </a>
                                </li>

                            </ul>
                        </li>



                    </ul>

                </li>
            <?php } ?>


            <!-- car Deed -->
            <!-- From module -->
            <li class="menu-item <?php echo isActive('/form_module/view'); ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-edit"></i>
                    <div data-i18n="Misc">Form Module</div>
                </a>
                <ul class="menu-sub">
                    <?php if (checkPermission('accounts-clearance-form')) { ?>
                        <li class="menu-item <?php echo isActive('/form_module/view/finance_accounts_clearance_list.php'); ?>">
                            <a href="<?php echo $basePath ?>/form_module/view/finance_accounts_clearance_list.php" class="menu-link">
                                <div>Accounts Clearence Form</div>
                            </a>
                        </li>
                    <?php } ?>


                </ul>
            </li>
            <!-- From module -->

            <!-- roster - module-list -->
            <!-- <?php if (checkPermission('roster-create') || (checkPermission('roster-list'))) { ?>

                <li class="menu-item <?php echo isActive('/roster'); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                        <div data-i18n="Misc">Roster Module</div>
                    </a>
                    <ul class="menu-sub">
                        <?php if (checkPermission('roster-create')) { ?>
                            <li class="menu-item <?php echo isActive('/roster/view/create.php'); ?>">
                                <a href="<?php echo $basePath ?>/roster/view/create.php" class="menu-link">
                                    <div >Roster Create</div>
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

            <?php } ?> -->
            <!-- roster-list -->
            <!-- Application Setting Module -->

            <?php if (checkPermission('designation-list') || (checkPermission('branch-list')) || (checkPermission('department-list')) || checkPermission('holiday-list')) { ?>

                <li class="menu-item  <?php echo isActive('/admin_setting/view'); ?>">
                    <a href=" javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-cog"></i>
                        <div data-i18n="Misc"> Admin Setting </div>
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