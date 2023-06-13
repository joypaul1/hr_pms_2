<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="" class="app-brand-link">
      <span class="app-brand-logo demo">
        <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink">
          <defs>
            <path
              d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
              id="path-1"></path>
            <path
              d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
              id="path-3"></path>
            <path
              d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
              id="path-4"></path>
            <path
              d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
              id="path-5"></path>
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
                <g id="Triangle"
                  transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
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


    <?php
    // Admin Role
    if ($_SESSION['HR']['hr_role'] == 2) { ?>
      <li class="menu-item active">
        <a href="<?php  echo $basePath ?>/dashboard_hr.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text"><b style="color:red;">HR Admin Module</b></span>
      </li>

      <li class="menu-item 
         <?php
         if (
           $v_page == 'department' ||
           $v_page == 'designation' ||
           $v_page == 'branch' ||
           $v_page == 'hr_holiday'
         )
           echo $v_active_open;
         ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-dock-top"></i>
          <div data-i18n="Account Settings">Admin Settings</div>
        </a>
        <ul class="menu-sub">

          <li class="menu-item <?php if ($v_page == 'department') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/department.php" class="menu-link">
              <div data-i18n="Notifications">Department List</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'designation') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/designation.php" class="menu-link">
              <div data-i18n="Connections">Designation List</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'branch') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/branch.php" class="menu-link">
              <div data-i18n="Connections">Branch List</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'hr_holiday') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/hr_holiday.php" class="menu-link">
              <div data-i18n="Connections">Holiday List</div>
            </a>
          </li>

        </ul>
      </li>

      <li class="menu-item 
         <?php
         if (
           $v_page == 'user' ||
           $v_page == 'user_create' ||
           $v_page == 'user_transfer'
         )
           echo $v_active_open;
         ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Account Settings">Apps User Module</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?php if ($v_page == 'user_create') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/user_create.php" class="menu-link">
              <div data-i18n="Account">User Create</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'user') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/user.php" class="menu-link">
              <div data-i18n="Account">User List</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'user_transfer') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/user_transfer.php" class="menu-link">
              <div data-i18n="Account">User Transfer</div>
            </a>
          </li>

        </ul>
      </li>

      <li class="menu-item 
         <?php
         if (
           $v_page == 'leave' ||
           $v_page == 'leave_create' ||
           $v_page == 'leave_approval_list' ||
           $v_page == 'leave_assign' ||
           $v_page == 'leave_report'
         )
           echo $v_active_open;
         ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
          <div data-i18n="Authentications">Leave Module</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?php if ($v_page == 'leave_create') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave_create.php" class="menu-link">
              <div data-i18n="Basic">Leave Create</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'leave') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave.php" class="menu-link">
              <div data-i18n="Basic">Leave List</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'leave_approval_list') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave_approval_list.php" class="menu-link">
              <div data-i18n="Basic">Leave Approval</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'leave_assign') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave_assign.php" class="menu-link">
              <div data-i18n="Vertical Form">Leave Assign</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'leave_report') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave_report.php" class="menu-link">
              <div data-i18n="Vertical Form">Advance Report</div>
            </a>
          </li>

        </ul>
      </li>
      <li class="menu-item 
         <?php
         if (
           $v_page == 'leave' ||
           $v_page == 'leave_create' ||
           $v_page == 'leave_approval_list' ||
           $v_page == 'leave_assign' ||
           $v_page == 'leave_report'
         )
           echo $v_active_open;
         ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
          <div data-i18n="Authentications">Leave Module</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?php if ($v_page == 'leave_create') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave_create.php" class="menu-link">
              <div data-i18n="Basic">Leave Create</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'leave') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave.php" class="menu-link">
              <div data-i18n="Basic">Leave List</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'leave_approval_list') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave_approval_list.php" class="menu-link">
              <div data-i18n="Basic">Leave Approval</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'leave_assign') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave_assign.php" class="menu-link">
              <div data-i18n="Vertical Form">Leave Assign</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'leave_report') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/leave_report.php" class="menu-link">
              <div data-i18n="Vertical Form">Advance Report</div>
            </a>
          </li>

        </ul>
      </li>

      <li class="menu-item 
         <?php
         if (
           $v_page == 'tour_create' ||
           $v_page == 'tour'
         )
           echo $v_active_open;
         ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Authentications">Tour Module</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?php if ($v_page == 'tour_create') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/tour_create.php" class="menu-link">
              <div data-i18n="Basic">Tour Create</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'tour') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/tour.php" class="menu-link">
              <div data-i18n="Basic">Tour List</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item 
         <?php
         if (
           $v_page == 'hr_manual_attendance' ||
           $v_page == 'punch_data_syn' ||
           $v_page == 'single_attendance' ||
           $v_page == 'department_attendance'
         )
           echo $v_active_open;
         ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cube-alt"></i>
          <div data-i18n="Misc">Attendance Module</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?php if ($v_page == 'hr_manual_attendance') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/hr_manual_attendance.php" class="menu-link">
              <div data-i18n="Error">Manual Entry</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'single_attendance') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/single_attendance.php" class="menu-link">
              <div data-i18n="Basic Inputs">Single Report</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'department_attendance') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/department_attendance.php" class="menu-link">
              <div data-i18n="Input groups">Advance Report</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'punch_data_syn') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/punch_data_syn.php" class="menu-link">
              <div data-i18n="Under Maintenance">Punch Data SYN</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item 
         <?php
         if (
           $v_page == 'roster_create' ||
           $v_page == 'roster'
         )
           echo $v_active_open;
         ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cube-alt"></i>
          <div data-i18n="Misc">Roster Module</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?php if ($v_page == 'roster_create') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/roster_create.php" class="menu-link">
              <div data-i18n="Error">Roster Create</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'roster') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/roster.php" class="menu-link">
              <div data-i18n="Under Maintenance">Roster List</div>
            </a>
          </li>
        </ul>
      </li>


      <li class="menu-header small text-uppercase">
        <span class="menu-header-text"><b style="color:red;">HR PMS Module</b></span>
      </li>

      <li class="menu-item 
        <?php
        if (
          $v_page == 'pms_hr' ||
          $v_page == 'pmp_hr_approval_list' ||
          $v_page == 'pms_kpi_list'
        )
          echo $v_active_open;
        ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-crown"></i>
          <div data-i18n="Misc">PMS Module</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?php if ($v_page == 'pms_hr') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/pms_hr.php" class="menu-link">
              <div data-i18n="Error">PMS List</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'pms_kpi_list') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/pms_kpi_list.php" class="menu-link">
              <div data-i18n="Error">KPI List</div>
            </a>
          </li>
          <li class="menu-item <?php if ($v_page == 'pmp_hr_approval_list') echo $v_active; ?>">
            <a href="<?php  echo $basePath ?>/pmp_hr_approval_list.php" class="menu-link">
              <div data-i18n="Under Maintenance">PMS Approval List</div>
            </a>
          </li>
        </ul>
      </li>









      <?php
      // Self Role 
    }
    else if ($_SESSION['HR']['hr_role'] == 4) { ?>
        <li class="menu-item active">
          <a href="<?php  echo $basePath ?>/dashboard_nu.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
          </a>
        </li>

        <li class="menu-header small text-uppercase">
          <span class="menu-header-text"><b style="color:red;">HR Apps Module</b></span>
        </li>
        <li class="menu-item 
        <?php
        if ($v_page == 'leave_create_self' || $v_page == 'leave_self')
          echo $v_active_open;
        ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Misc">Leave Module</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?php if ($v_page == 'leave_create_self') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/leave_create_self.php" class="menu-link">
                <div data-i18n="Error">Leave Create</div>
              </a>
            </li>
            <li class="menu-item <?php if ($v_page == 'leave_self') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/leave_self.php" class="menu-link">
                <div data-i18n="Error">Leave Report</div>
              </a>
            </li>

          </ul>

        </li>

        <li class="menu-item 
        <?php
        if ($v_page == 'tour_create_self' || $v_page == 'tour_self')
          echo $v_active_open;
        ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-task"></i>
            <div data-i18n="Misc">Tour Module</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?php if ($v_page == 'tour_create_self') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/tour_create_self.php" class="menu-link">
                <div data-i18n="Error">Tour Create</div>
              </a>
            </li>
            <li class="menu-item <?php if ($v_page == 'tour_self') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/tour_self.php" class="menu-link">
                <div data-i18n="Error">Tour Report</div>
              </a>
            </li>
          </ul>
        </li>
        <li class="menu-item 
        <?php
        if (
          $v_page == 'lm_self_attendance' ||
          $v_page == 'self_outdoor_attn'
        )
          echo $v_active_open;
        ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-table"></i>
            <div data-i18n="Misc">Attendance Module</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?php if ($v_page == 'lm_self_attendance') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/lm_self_attendance.php" class="menu-link">
                <div data-i18n="Error">Self Attendance</div>
              </a>
            </li>

            <li class="menu-item <?php if ($v_page == 'self_outdoor_attn') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/self_outdoor_attn.php" class="menu-link">
                <div data-i18n="Error">Outdoor Attendance</div>
              </a>
            </li>

          </ul>
        </li>
        <li class="menu-item 
        <?php
        if (
          $v_page == 'pms_kra_create' ||
          $v_page == 'pms_list_self' ||
          $v_page == 'pms_kpi_list' ||
          $v_page == 'pms_kpi_list_update'
        )
          echo $v_active_open;
        ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-crown"></i>
            <div data-i18n="Misc">PMS Module</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?php if ($v_page == 'pms_list_self') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/pms_list_self.php" class="menu-link">
                <div data-i18n="Error">PMS List</div>
              </a>
            </li>
            <li class="menu-item <?php if ($v_page == 'pms_kra_create') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/pms_kra_create.php" class="menu-link">
                <div data-i18n="Error">KRA List</div>
              </a>
            </li>
            <li class="menu-item <?php if ($v_page == 'pms_kpi_list') echo $v_active; ?>">
              <a href="<?php  echo $basePath ?>/pms_kpi_list.php" class="menu-link">
                <div data-i18n="Under Maintenance">KPI List</div>
              </a>
            </li>
          </ul>

        </li>


      <?php
      // IT Role
    }
    else if ($_SESSION['HR']['hr_role'] == 1) { ?>
          <li class="menu-item active">
            <a href="<?php  echo $basePath ?>/dashboard_it.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div data-i18n="Analytics">Dashboard</div>
            </a>
          </li>

          <li class="menu-header small text-uppercase">
            <span class="menu-header-text"><b style="color:red;">HR User Module</b></span>
          </li>
          <li class="menu-item 
        <?php
        if (
          $v_page == 'user_apps'
          || $v_page == 'user_web'
          || $v_page == 'user_web_create'
          || $v_page == 'user_apps_access'
        )
          echo $v_active_open;
        ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-collection"></i>
              <div data-i18n="Misc">Apps user Module</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item <?php if ($v_page == 'user_apps') echo $v_active; ?>">
                <a href="<?php  echo $basePath ?>/user_apps.php" class="menu-link">
                  <div data-i18n="Error">Apps User</div>
                </a>
              </li>
              <li class="menu-item <?php if ($v_page == 'user_web_create') echo $v_active; ?>">
                <a href="user_web_create.php" class="menu-link">
                  <div data-i18n="Error">Web User Create</div>
                </a>
              </li>
              <li class="menu-item <?php if ($v_page == 'user_web') echo $v_active; ?>">
                <a href="<?php  echo $basePath ?>/user_web.php" class="menu-link">
                  <div data-i18n="Error">Web User</div>
                </a>
              </li>
              <li class="menu-item <?php if ($v_page == 'user_apps_access') echo $v_active; ?>">
                <a href="<?php  echo $basePath ?>/user_apps_access.php" class="menu-link">
                  <div data-i18n="Error">User Apss Access</div>
                </a>
              </li>



            </ul>
          </li>

          <li class="menu-header small text-uppercase">
            <span class="menu-header-text"><b style="color:red;">Report Module</b></span>
          </li>
          <li class="menu-item 
        <?php
        if ($v_page == 'hr_app_session' || $v_page == 'dd')
          echo $v_active_open;
        ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-collection"></i>
              <div data-i18n="Misc">Admin Report</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item <?php if ($v_page == 'hr_app_session') echo $v_active; ?>">
                <a href="<?php  echo $basePath ?>/hr_app_session.php" class="menu-link">
                  <div data-i18n="Error">App Session Data</div>
                </a>
              </li>

            </ul>
          </li>
      <?php
    }
    else if ($_SESSION['HR']['hr_role'] == 5) { ?>
            <li class="menu-item active">
              <a href="<?php  echo $basePath ?>/dashboard_rmwl.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text"><b style="color:red;">HR User Module</b></span>
            </li>
            <li class="menu-item 
        <?php
        if (
          $v_page == 'new_emp_create_rmwl' ||
          $v_page == 'user_list_rmwl' ||
          $v_page == 'rmwl_manual_attendance' ||
          $v_page == 'hr_emp_transfer_rmwl'
        )
          echo $v_active_open;
        ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Misc">Apps Admin Module</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?php if ($v_page == 'new_emp_create_rmwl') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/new_emp_create_rmwl.php" class="menu-link">
                    <div data-i18n="Error">New User Create</div>
                  </a>
                </li>
                <li class="menu-item <?php if ($v_page == 'user_list_rmwl') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/user_list_rmwl.php" class="menu-link">
                    <div data-i18n="Error">Apps User List</div>
                  </a>
                </li>

                <li class="menu-item <?php if ($v_page == 'hr_emp_transfer_rmwl') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/hr_emp_transfer_rmwl.php" class="menu-link">
                    <div data-i18n="Error">Workstation Change</div>
                  </a>
                </li>

                <li class="menu-item <?php if ($v_page == 'rmwl_manual_attendance') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/rmwl_manual_attendance.php" class="menu-link">
                    <div data-i18n="Error">New Attendance</div>
                  </a>
                </li>

              </ul>
            </li>


            <li class="menu-item 
        <?php
        if (
          $v_page == 'rmwl_leave' ||
          $v_page == 'leave_list_rmwl' ||
          $v_page == 'kk' ||
          $v_page == 'kkkk'
        )
          echo $v_active_open;
        ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Misc">Leave Module</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?php if ($v_page == 'rmwl_leave') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/rmwl_leave.php" class="menu-link">
                    <div data-i18n="Error">New Create</div>
                  </a>
                </li>
                <li class="menu-item <?php if ($v_page == 'leave_list_rmwl') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/leave_list_rmwl.php" class="menu-link">
                    <div data-i18n="Error">Leave List</div>
                  </a>
                </li>


              </ul>
            </li>


            <li class="menu-header small text-uppercase">
              <span class="menu-header-text"><b style="color:red;">Report Module</b></span>
            </li>
            <li class="menu-item 
        <?php
        if (
          $v_page == 'rmwl_single_attendance' ||
          $v_page == 'attendance_report_rmwl' ||
          $v_page == 'rmwl_outdoor'
        )
          echo $v_active_open;
        ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Misc">Report Module</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?php if ($v_page == 'rmwl_single_attendance') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/rmwl_single_attendance.php" class="menu-link">
                    <div data-i18n="Error">Single Attendance</div>
                  </a>
                </li>
                <li class="menu-item <?php if ($v_page == 'attendance_report_rmwl') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/attendance_report_rmwl.php" class="menu-link">
                    <div data-i18n="Error">Advance Report</div>
                  </a>
                </li>
                <li class="menu-item <?php if ($v_page == 'rmwl_outdoor') echo $v_active; ?>">
                  <a href="<?php  echo $basePath ?>/rmwl_outdoor.php" class="menu-link">
                    <div data-i18n="Error">Outdoor Attendance</div>
                  </a>
                </li>

              </ul>
            </li>





      <?php
      // Line Manager
    }
    else if ($_SESSION['HR']['hr_role'] == 3) { ?>
              <li class="menu-item active">
                <a href="<?php  echo $basePath ?>/dashboard_lm.php" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-home-circle"></i>
                  <div data-i18n="Analytics">Dashboard</div>
                </a>
              </li>

              <li class="menu-header small text-uppercase">
                <span class="menu-header-text"><b style="color:red;">HR Apps Module</b></span>
              </li>
              <li class="menu-item 
        <?php
        if (
          $v_page == 'leave_create_self' ||
          $v_page == 'leave_self' ||
          $v_page == 'leave_concern'
        )
          echo $v_active_open;
        ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-collection"></i>
                  <div data-i18n="Misc">Leave Module</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item <?php if ($v_page == 'leave_create_self') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/leave_create_self.php" class="menu-link">
                      <div data-i18n="Error">Leave Create</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'leave_self') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/leave_self.php" class="menu-link">
                      <div data-i18n="Error">Self Report</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'leave_concern') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/leave_concern.php" class="menu-link">
                      <div data-i18n="Error">Concern Report</div>
                    </a>
                  </li>

                </ul>

              </li>

              <li class="menu-item 
        <?php
        if (
          $v_page == 'tour_create_self' ||
          $v_page == 'tour_self' ||
          $v_page == 'tour_concern'
        )
          echo $v_active_open;
        ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-task"></i>
                  <div data-i18n="Misc">Tour Module</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item <?php if ($v_page == 'tour_create_self') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/tour_create_self.php" class="menu-link">
                      <div data-i18n="Error">Tour Create</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'tour_self') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/tour_self.php" class="menu-link">
                      <div data-i18n="Error">Self Report</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'tour_concern') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/tour_concern.php" class="menu-link">
                      <div data-i18n="Error">Concern Report</div>
                    </a>
                  </li>
                </ul>

              </li>
              <li class="menu-item 
        <?php
        if (
          $v_page == 'lm_outdoor_approval' ||
          $v_page == 'lm_leave_approval' ||
          $v_page == 'lm_tour_approval' ||
          $v_page == 'lm_pms_approval'
        )
          echo $v_active_open;
        ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-envelope"></i>
                  <div data-i18n="Misc">Approval Module</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item <?php if ($v_page == 'lm_outdoor_approval') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/lm_outdoor_approval.php" class="menu-link">
                      <div data-i18n="Error">Attendance Approval</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'lm_leave_approval') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/lm_leave_approval.php" class="menu-link">
                      <div data-i18n="Error">Leave Approval</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'lm_tour_approval') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/lm_tour_approval.php" class="menu-link">
                      <div data-i18n="Error">Tour Approval</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'lm_pms_approval') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/lm_pms_approval.php" class="menu-link">
                      <div data-i18n="Error">PMS Approval</div>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="menu-item 
        <?php
        if (
          $v_page == 'lm_self_attendance' ||
          $v_page == 'concern_attendance' ||
          $v_page == 'concern_outdoor_attn'
        )
          echo $v_active_open;
        ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-table"></i>
                  <div data-i18n="Misc">Report Module</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item <?php if ($v_page == 'lm_self_attendance') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/lm_self_attendance.php" class="menu-link">
                      <div data-i18n="Error">Self Attendance</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'concern_attendance') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/concern_attendance.php" class="menu-link">
                      <div data-i18n="Error">Concern Attendance</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'concern_outdoor_attn') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/concern_outdoor_attn.php" class="menu-link">
                      <div data-i18n="Error">Outdoor Attendance</div>
                    </a>
                  </li>

                </ul>
              </li>
              <li class="menu-item 
        <?php
        if ($v_page == 'pms_kra_create' || $v_page == 'pms_list_self' || $v_page == 'pms_kpi_list')
          echo $v_active_open;
        ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-crown"></i>
                  <div data-i18n="Misc">PMP Module</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item <?php if ($v_page == 'pms_list_self') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/pms_list_self.php" class="menu-link">
                      <div data-i18n="Error">PMS List</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'pms_kra_create') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/pms_kra_create.php" class="menu-link">
                      <div data-i18n="Error">KRA Create</div>
                    </a>
                  </li>
                  <li class="menu-item <?php if ($v_page == 'pms_kpi_list') echo $v_active; ?>">
                    <a href="<?php  echo $basePath ?>/pms_kpi_list.php" class="menu-link">
                      <div data-i18n="Under Maintenance">KPI List</div>
                    </a>
                  </li>
                </ul>

              </li>

      <?php
    }
    ?>
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text"><b style="color:red;">Multiple Role Permission</b></span>
    </li>
    <li class="menu-item 
        <?php
        if (
          $v_page == 'role'
          || $v_page == 'permission'
          || $v_page == 'role_permission'
          || $v_page == 'user_role'
        )
          echo $v_active_open;
        ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Misc"> Role Permission </div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?php if ($v_page == 'role') echo $v_active; ?>">
          <a href="<?php  echo $basePath ?>/role_permission/role/index.php" class="menu-link">
            <div data-i18n="Error">Role List</div>
          </a>
        </li>
        <li class="menu-item <?php if ($v_page == 'permission') echo $v_active; ?>">
          <a href="<?php  echo $basePath ?>/role_permission/permission/index.php" class="menu-link">
            <div data-i18n="Error">Permssion List</div>
          </a>
        </li>
        <li class="menu-item <?php if ($v_page == 'role_permission') echo $v_active; ?>">
          <a href="<?php  echo $basePath ?>/role_permission/role_permission/index.php" class="menu-link">
            <div data-i18n="Error">Role & Permission </div>
          </a>
        </li>
        <li class="menu-item <?php if ($v_page == 'user_role') echo $v_active; ?>">
          <a href="<?php  echo $basePath ?>/role_permission/user_role/index.php" class="menu-link">
            <div data-i18n="Error">User Role</div>
          </a>
        </li>



      </ul>
    </li>
  </ul>
</aside>
<!-- / Menu -->