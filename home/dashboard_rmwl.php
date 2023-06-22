<?php
$v_page        = 'role';
$v_active_open = 'active open';
$v_active      = 'active';
require_once('../helper/com_conn.php');
require_once('../inc/connoracle.php');






$userStatusSQL  = oci_parse(
  $objConnect,
  "SELECT IS_ACTIVE,count(*)AS USER_TOTAL 
					 FROM RML_HR_APPS_USER 
					 WHERE R_CONCERN!='RG'
					 AND R_CONCERN='RMWL'
					 group by IS_ACTIVE"
);
oci_execute($userStatusSQL);
$total_emp = 0;
$v_active_emp = 0;
$v_in_active_emp = 0;
while ($r = oci_fetch_assoc($userStatusSQL)) {
  $total_emp = $total_emp + $r['USER_TOTAL'];
  if ($r['IS_ACTIVE'] == 1)
    $v_active_emp = $r['USER_TOTAL'];
  else
    $v_in_active_emp = $r['USER_TOTAL'];
}

// Monthly Late Absent===============================================


$monthly_late = 0;
$monthly_absent = 0;
$lateAbsentSQL  = oci_parse(
  $objConnect,
  "select A.STATUS,COUNT(UNIQUE(A.RML_ID)) AS NUMNER_COUNT 
                       from RML_HR_ATTN_DAILY_PROC A,RML_HR_APPS_USER B
                        where A.RML_ID=B.RML_ID
                        AND ATTN_DATE between to_date(((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL)),'dd/mm/yyyy') 
                                             and to_date(( (SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL)),'dd/mm/yyyy')
                        AND A.STATUS IN ('L','A')
                         AND a.R_CONCERN='RMWL'
                        AND B.IS_ACTIVE=1
                        GROUP BY A.STATUS"
);
oci_execute($lateAbsentSQL);

while ($row = oci_fetch_assoc($lateAbsentSQL)) {

  if ($row['STATUS'] == 'L')
    $monthly_late = $row['NUMNER_COUNT'];
  else
    $monthly_absent = $row['NUMNER_COUNT'];
}
// Monthly Late Absent END//==============================================


// Joining User
$joinSQL  = oci_parse(
  $objConnect,
  "SELECT NVL(count(ID),0) AS JOINING_USER
                      FROM RML_HR_APPS_USER
                      WHERE to_char(DOJ,'dd/mm') = to_char(sysdate, 'dd/mm')"
);
oci_execute($joinSQL);
while ($row = oci_fetch_assoc($joinSQL)) {
  $today_joining_user = $row['JOINING_USER'];
}
?>
<!-- / Content -->


<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-8 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Congratulations <?php echo $_SESSION['HR']['first_name_hr']; ?>! 🎉</h5>
              <p class="mb-4">
                Access Are Predefine according to <span class="fw-bold">Rangs Motors HR Policy.</span>
                If you need more access please contact with HR.
              </p>

              <a href="" class="btn btn-sm btn-outline-primary">Universal Notification</a>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-4 order-1">
      <div class="row">
        <?php
        $userStatusSQL  = oci_parse(
          $objConnect,
          "SELECT count(*)AS USER_TOTAL 
					                 FROM RML_HR_APPS_USER 
									 WHERE R_CONCERN!='RG'
									 AND R_CONCERN='RMWL'
									 group by IS_ACTIVE"
        );
        oci_execute($userStatusSQL);
        $number = 0;
        while ($row = oci_fetch_assoc($userStatusSQL)) {
          $number++;
          if ($number == 1) {
        ?>

            <div class="col-lg-6 col-md-12 col-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                      <img src="assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                    </div>
                    <div class="dropdown">
                      <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      </div>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Active User</span>
                  <h3 class="card-title mb-2"><?php echo $row['USER_TOTAL']; ?></h3>
                  <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i><?php echo round(($row['USER_TOTAL'] * 100) / ($total_emp), 2); ?> %</small>
                </div>
              </div>
            </div>
          <?php
          }
          if ($number == 2) {
          ?>

            <div class="col-lg-6 col-md-12 col-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                      <img src="assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" />
                    </div>
                    <div class="dropdown">
                      <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      </div>
                    </div>
                  </div>
                  <span>In-Active User</span>
                  <h3 class="card-title text-nowrap mb-1"><?php echo $row['USER_TOTAL']; ?></h3>
                  <small class="text-success fw-semibold"><i class="bx bx-down-arrow-alt"></i> <?php echo round(($row['USER_TOTAL'] * 100) / ($total_emp), 2); ?>%</small>
                </div>
              </div>
            </div>

        <?php
          }
        }
        ?>
      </div>
    </div>

  </div>
  <div class="row">
    <!-- Order Statistics -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2"><u>Today Attendance Statistics</u></h5>
          </div>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <!-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                          <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                          <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                          <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div> -->
          </div>
        </div>
        <div class="card-body">

          <ul class="p-0 m-0 mt-3">



            <?php
            $attendanceSQL  = oci_parse(
              $objConnect,
              "SELECT STATUS,COUNT(STATUS) AS COUNT_NUMBER 
											FROM RML_HR_ATTN_DAILY_PROC A,RML_HR_APPS_USER B 
											WHERE A.RML_ID=B.RML_ID
											AND B.IS_ACTIVE=1
											AND ATTN_DATE= TO_DATE(TO_CHAR(SYSDATE,'DD/MM/YYYY'),'DD/MM/YYYY') 
											AND A.R_CONCERN!='RG'
											AND A.R_CONCERN='RMWL'
											GROUP BY STATUS"
            );
            oci_execute($attendanceSQL);
            $number = 0;

            while ($row = oci_fetch_assoc($attendanceSQL)) {
            ?>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0"><?php echo $row['STATUS']; ?></h6>
                    <small class="text-muted">Mobile Apps</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold"><?php echo $row['COUNT_NUMBER']; ?></small>
                  </div>
                </div>
              </li>
            <?php
            }
            ?>
          </ul>
        </div>
      </div>
    </div>


    <!-- Transactions -->
    <div class="col-md-6 col-lg-4 order-2 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2"><u>Branch Wise User Statistics</u></h5>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <!--
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                         <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Year</a>  
                        </div>-->
          </div>
        </div>





        <div class="card-body">
          <ul class="p-0 m-0">
            <?php
            $userStatusSQL  = oci_parse(
              $objConnect,
              "SELECT BRANCH_NAME,COUNT(BRANCH_NAME) AS TOTAL_EMP 
                                                  FROM RML_HR_APPS_USER 
                                                  WHERE IS_ACTIVE=1 
                                                  AND R_CONCERN!='RG'
                                                  AND R_CONCERN='RMWL'
                                                  GROUP BY BRANCH_NAME"
            );
            oci_execute($userStatusSQL);
            $number = 0;

            while ($row = oci_fetch_assoc($userStatusSQL)) {
            ?>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="assets/img/icons/unicons/chart.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">User Active</small>
                    <h6 class="mb-0"><?php echo $row['BRANCH_NAME']; ?></h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0"><?php echo $row['TOTAL_EMP']; ?></h6>
                    <span class="text-muted">User's</span>
                  </div>
                </div>
              </li>
            <?php
            }
            ?>
          </ul>
        </div>






      </div>
    </div>
    <!--/ Transactions -->
  </div>
</div>


<!-- / Content -->

<?php require_once('../layouts/footer_info.php'); ?>
<?php require_once('../layouts/footer.php'); ?>