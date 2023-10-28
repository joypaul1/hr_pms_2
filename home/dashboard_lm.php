<?php
$v_page        = 'role';
$v_active_open = 'active open';
$v_active      = 'active';
require_once('../helper/com_conn.php');
require_once('../inc/connoracle.php');




$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$strSQL  = oci_parse($objConnect, "select A.id,
											  A.PMS_NAME,
											  A.IS_ACTIVE,
											  A.BG_COLOR    
									from HR_PMS_LIST a, HR_PMS_EMP b
									where a.id=B.HR_PMS_LIST_ID
									and B.EMP_ID='$emp_session_id'");
oci_execute($strSQL);


//====================== Personal Previous Month Attendance================================================
$RMLstrSQL  = oci_parse($objConnect, "select distinct(status) STATUS, count (status) TOTAL from RML_HR_ATTN_DAILY_PROC
                                            Where RML_ID='$emp_session_id'
                                            and trunc(ATTN_DATE) between  (select Last_Day(ADD_MONTHS(TO_DATE(SYSDATE,'dd/mm/RRRR'),-2))+1 from dual)  and ( select Last_Day(ADD_MONTHS(TO_DATE(SYSDATE,'dd/mm/RRRR'),-1)) from dual)
                                            group by status");

oci_execute($RMLstrSQL);
$Personal_Present_Previous_Month = 0;
$Personal_Late_Previous_Month = 0;
$Personal_Absent_Previous_Month = 0;
$Personal_Leave_Previous_Month = 0;
$Personal_Holiday_Previous_Month = 0;
$Personal_Weekend_Previous_Month = 0;

while ($row = oci_fetch_assoc($RMLstrSQL)) {
	$STATUS = $row['STATUS'];
	if ($STATUS == 'P') {
		$Personal_Present_Previous_Month = $row['TOTAL'];
	} else if ($STATUS == 'L') {
		$Personal_Late_Previous_Month = $row['TOTAL'];
	} else if ($STATUS == 'A') {
		$Personal_Absent_Previous_Month = $row['TOTAL'];
	} else if ($STATUS == 'ML') {
		$Personal_Leave_Previous_Month = $Personal_Leave_Previous_Month + $row['TOTAL'];
	} else if ($STATUS == 'CL') {
		$Personal_Leave_Previous_Month = $Personal_Leave_Previous_Month + $row['TOTAL'];
	} else if ($STATUS == 'EL') {
		$Personal_Leave_Previous_Month = $Personal_Leave_Previous_Month + $row['TOTAL'];
	} else if ($STATUS == 'H') {
		$Personal_Holiday_Previous_Month = $Personal_Holiday_Previous_Month + $row['TOTAL'];
	} else if ($STATUS == 'W') {
		$Personal_Weekend_Previous_Month = $Personal_Weekend_Previous_Month + $row['TOTAL'];
	}
}
//======================End Personal Previous Month Attendance================================================
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	// Load google charts
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(drawChart);

	// Draw the chart and set the chart values
	function drawChart() {
		var P = <?php echo $Personal_Present_Previous_Month; ?>;
		var L = <?php echo $Personal_Late_Previous_Month; ?>;
		var A = <?php echo $Personal_Absent_Previous_Month; ?>;
		var LV = <?php echo $Personal_Leave_Previous_Month; ?>;
		var H = <?php echo $Personal_Holiday_Previous_Month; ?>;
		var W = <?php echo $Personal_Weekend_Previous_Month; ?>;
		var data = google.visualization.arrayToDataTable([
			['Task', 'Hours per Day'],
			['Present: ' + P, P],
			['Absent :' + A, A],
			['Late: ' + L, L],
			['Holiday: ' + H, H],
			['Week-End: ' + W, W],
			['Leave: ' + LV, LV]
		]);

		// Optional; add a title and set the width and height of the chart
		var options = {
			'title': 'Your Previous Month Attendance Status ' + (P + L + A + LV + H + W) + ' Days',
			'width': 386,
			'height': 183
		};

		// Display the chart inside the <div> element with id="piechart"
		var chart = new google.visualization.PieChart(document.getElementById('previous_month'));
		chart.draw(data, options);
	}
</script>


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

							<a href="" class="btn btn-primary">Universal Notification</a>
						</div>
					</div>
					<div class="col-sm-5 text-center text-sm-left">
						<div class="card-body pb-0 px-0 px-md-4">
							<img src="<?php echo $basePath ?>/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" >
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 order-1" id="previous_month">

		</div>
	</div>
	<div class="row">
		<div class="col-12 mb-4 order-0">
			<div class="card">
				<h5 class="card-header"><u><b>Today Your Concern Attendance: </b></u></h5>
				<div class="card-body">
					<div class="table-responsive text-nowrap">
						<table class="table table-bordered">
							<thead class="">
								<tr>
									<th scope="col"><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>SL</strong></th>
									<th scope="col"><strong>Name</strong></th>
									<th scope="col"><strong>In-Time</strong></th>
									<th scope="col"><strong>Out-Time</strong></th>
									<th scope="col"><strong>Status</strong></th>
								</tr>
							</thead>
							<tbody>

								<?php


								$allDataSQL  = oci_parse(
									$objConnect,
									"select RML_ID,RML_NAME,ATTN_DATE,IN_TIME,OUT_TIME,STATUS from RML_HR_ATTN_DAILY_PROC
                   Where RML_ID IN (Select RML_ID from RML_HR_APPS_USER where LINE_MANAGER_RML_ID='$emp_session_id' and is_active=1)
                   and ATTN_DATE=trunc(SYSDATE)"
								);

								oci_execute($allDataSQL);
								$number = 0;
								while ($row = oci_fetch_assoc($allDataSQL)) {
									$number++;
								?>
									<tr>
										<td><i class="fab fa-angular fa-lg text-danger me-3"></i>
											<strong><?php echo $number; ?></strong>
										</td>
										<td><?php echo $row['RML_NAME'] . '[' . $row['RML_ID'] . ']'; ?></td>
										<td><?php echo $row['IN_TIME']; ?></td>
										<td><?php echo $row['OUT_TIME']; ?></td>
										<td><?php echo $row['STATUS']; ?></td>


									</tr>
								<?php
								}

								?>



							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 mb-4 order-0">
			<div class="card">
				<h5 class="card-header"><u><b>Approval Pending List 2023: </b></u></h5>
				<div class="card-body">
					<div class="table-responsive text-nowrap">
						<table class="table table-bordered">
							<thead class="">
								<tr>
									<th scope="col"><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>SL</strong></th>
									<th scope="col"><strong>Approval Type</strong></th>
									<th scope="col"><strong>Count</strong></th>
								</tr>
							</thead>
							<tbody>

								<?php


								$allDataSQL  = oci_parse(
									$objConnect,
									"select 'OUTDOOR_ATTN' APPROVAL_TYPE,count(A.ID) NUMBER_TOTAL,'lm_outdoor_approval.php' APPROVAL_LINK
								from RML_HR_ATTN_DAILY a ,RML_HR_APPS_USER b
								where A.RML_ID=B.RML_ID
								and a.LINE_MANAGER_ID = '$emp_session_id'
								 and trunc (a.ATTN_DATE)>TO_DATE('31/12/2022','DD/MM/YYYY')
								AND a.IS_ALL_APPROVED = 0
								AND A.LINE_MANAGER_APPROVAL IS NULL
								AND B.IS_ACTIVE=1
						UNION ALL
							select 'LEAVE' APPROVAL_TYPE,count(a.RML_ID)NUMBER_TOTAL,'lm_leave_approval.php' APPROVAL_LINK from RML_HR_EMP_LEAVE a,RML_HR_APPS_USER b
                            where A.RML_ID=b.RML_ID
                            and B.LINE_MANAGER_RML_ID='$emp_session_id'
							 and trunc(a.START_DATE)>TO_DATE('31/12/2022','DD/MM/YYYY')
                            and a.IS_APPROVED IS NULL
						UNION ALL
							select 'TOUR' APPROVAL_TYPE,count(a.RML_ID)NUMBER_TOTAL,'lm_tour_approval.php' APPROVAL_LINK from RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
							where A.RML_ID=b.RML_ID
							and B.LINE_MANAGER_RML_ID='$emp_session_id'
							and trunc(a.START_DATE)>TO_DATE('31/12/2022','DD/MM/YYYY')
							and a.LINE_MANAGER_APPROVAL_STATUS IS NULL
						UNION ALL
							SELECT 'PMS [Testing]' APPROVAL_TYPE,COUNT(EMP_ID)NUMBER_TOTAL,'lm_pms_approval.php' APPROVAL_LINK 
							FROM HR_PMS_EMP
							WHERE SELF_SUBMITTED_STATUS=1
							AND LINE_MANAGER_1_STATUS IS NULL
							AND LINE_MANAGER_1_ID='$emp_session_id'"
								);

								oci_execute($allDataSQL);
								$number = 0;
								while ($row = oci_fetch_assoc($allDataSQL)) {
									$number++;
								?>
									<tr>
										<td><i class="fab fa-angular fa-lg text-danger me-3"></i>
											<strong><?php echo $number; ?></strong>
										</td>
										<td><?php echo $row['APPROVAL_TYPE']; ?></td>
										<td>
											<a href=<?php echo $row['APPROVAL_LINK']; ?>><?php echo $row['NUMBER_TOTAL']; ?></a>
										</td>

									</tr>
								<?php
								}

								?>



							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>



	</div>



	<div class="row">
		<?php
		while ($row = oci_fetch_assoc($strSQL)) {
		?>
			<div class="col-xl-3 col-md-6">
				<div class="<?php echo $row['BG_COLOR']; ?>">
					<div class="card-body font-weight-bold">
						<?php
						if ($row['IS_ACTIVE'] == '1')
							echo $row['PMS_NAME'];
						else
							echo $row['PMS_NAME'] . '[Closed]';
						?></div>
					<div class="card-footer d-flex align-items-center justify-content-between">
						<a class="small text-white stretched-link" href="pms_kpi_dtls.php?key=<?php echo $row['ID']; ?>">View Details</a>
						<div class="small text-white"><i class="fa fa-angle-right"></i></div>
					</div>
				</div>
			</div>
		<?php
		}
		?>

	</div>
</div>
<!-- / Content -->

<?php require_once('../layouts/footer_info.php'); ?>
<?php require_once('../layouts/footer.php'); ?>