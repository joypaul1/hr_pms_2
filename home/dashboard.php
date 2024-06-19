<?php
require_once ('../helper/com_conn.php');
require_once ('../inc/connoracle.php');
$basePath = $_SESSION['basePath'];

$sqlQuary = "SELECT 'Offboarding' APPROVAL_TYPE,count(C.RML_ID) NUMBER_TOTAL,'$basePath/offboarding_module/view/lm_panel/approval.php' 	APPROVAL_LINK
		FROM EMP_CLEARENCE A,EMP_CLEARENCE_DTLS B,RML_HR_APPS_USER C
		WHERE A.ID=B.EMP_CLEARENCE_ID
		AND A.RML_HR_APPS_USER_ID=C.ID
		AND B.APPROVAL_STATUS IS NULL
		AND B.CONCERN_NAME IN (
						SELECT R_CONCERN from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
						(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id')
						 )
		AND B.DEPARTMENT_ID IN (
						SELECT DEPARTMENT_ID from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
						(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id')
						)
	UNION ALL
	SELECT 'PMS [Level-1]' APPROVAL_TYPE,COUNT(EMP_ID)NUMBER_TOTAL,'lm_pms_approval.php' APPROVAL_LINK 
	FROM HR_PMS_EMP
	WHERE SELF_SUBMITTED_STATUS=1
	AND LINE_MANAGER_1_STATUS IS NULL
	AND LINE_MANAGER_1_ID='$emp_session_id'
	UNION ALL
	SELECT 'PMS [Level-2]' APPROVAL_TYPE,COUNT(EMP_ID)NUMBER_TOTAL,'lm_pms_approval_2.php' APPROVAL_LINK 
	FROM HR_PMS_EMP
	WHERE LINE_MANAGER_1_STATUS=1
	AND SELF_SUBMITTED_STATUS=1
	AND LINE_MANAGER_2_STATUS IS NULL
	AND LINE_MANAGER_2_ID='$emp_session_id'";


$allDataSQL = @oci_parse($objConnect, $sqlQuary);
@oci_execute($allDataSQL);

$sqlAtt = "SELECT RML_ID,(RML_HR_ATTN_STATUS_COUNT(
	RML_ID,
	TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	'P'
)) PRESENT_TOTAL,
(RML_HR_ATTN_STATUS_COUNT(
	RML_ID,
	TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	'L'
)) LATE_TOTAL,
(RML_HR_ATTN_STATUS_COUNT(
	RML_ID,
	TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	'A'
)) ABSENT_TOTAL,
(RML_HR_ATTN_STATUS_COUNT(
	RML_ID,
	TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	'H'
)) HOLIDAY_TOTAL,
(RML_HR_ATTN_STATUS_COUNT(
	RML_ID,
	TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	'W'
)) WEEKEND_TOTAL,
(RML_HR_ATTN_STATUS_COUNT(
	RML_ID,
	TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	'T'
)) TOUR_TOTAL,
 (RML_HR_ATTN_STATUS_COUNT(
	RML_ID,
	TO_DATE ((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	TO_DATE ((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),
	'LV'
)) LEAVE_TOTAL FROM RML_HR_APPS_USER
  WHERE RML_ID='$emp_session_id'
  AND IS_ACTIVE=1";

$attDataSQL = @oci_parse($objConnect, $sqlAtt);
@oci_execute($attDataSQL);
$attData = @oci_fetch_assoc($attDataSQL);
// ($attData['PRESENT_TOTAL']);

$attBarChartData = [ $attData['PRESENT_TOTAL'], $attData['LATE_TOTAL'], $attData['ABSENT_TOTAL'], $attData['HOLIDAY_TOTAL'] + $attData['WEEKEND_TOTAL'], $attData['TOUR_TOTAL'], $attData['LEAVE_TOTAL'] ];
$attPieChartData = [ $attData['PRESENT_TOTAL'], $attData['LATE_TOTAL'], $attData['ABSENT_TOTAL'], $attData['HOLIDAY_TOTAL'] + $attData['WEEKEND_TOTAL'], $attData['TOUR_TOTAL'], $attData['LEAVE_TOTAL'] ];

$userProfile = [];
$userSQL     = @oci_parse(
	$objConnect,
	"SELECT DEPT_NAME, BRANCH_NAME, DESIGNATION, DOJ, R_CONCERN
	From RML_HR_APPS_USER  WHERE RML_ID='$emp_session_id'"
);

@oci_execute($userSQL);
$userProfile = @oci_fetch_assoc($userSQL);

?>
<div class="container-xxl flex-grow-1 container-p-y">
	<div class="row">
		<!--	<div class="col-lg-12 ">
			<div class=" card card-title p-2">
				<marquee>Welcome to our new Rangs Group HR appps Web portal. If you face any problem please, inform us [IT & ERP Dept.]</marquee> 
			</div>
		</div>-->
		<div class="col-sm-12 col-md-12 col-lg-12 mb-2 order-0">
			<div class="card" style="background: linear-gradient(to bottom, #24ff72, #0c184e69);">
				<div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
					<div class="flex-shrink-0  mx-sm-0 mx-auto">
						<img src="<?php echo $_SESSION['HR_APPS']['emp_image_hr'] != null ? ($basePath . '/' . $_SESSION['HR_APPS']['emp_image_hr']) : $basePath . '/' . "assets/img/avatars/1.png"; ?>"
							alt="User Image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
					</div>
					<div class="flex-grow-1 mt-3 ">
						<div
							class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
							<div class="user-profile-info">

								<h4 class="text-whites">
									<?php echo $_SESSION['HR_APPS']['first_name_hr']; ?>
								</h4>
								<ul
									class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
									<li class="list-inline-item fw-medium">

										<span class="badge bg-label-success"> <i class="bx bx-pen"></i>
											<?php echo $userProfile['DESIGNATION'] ?>
										</span>
									</li>
									<li class="list-inline-item fw-medium">

										<span class="badge bg-label-danger"><i class='bx bx-network-chart'></i>
											<?php echo $userProfile['DEPT_NAME'] ?>
										</span>
									</li>
									<li class="list-inline-item fw-medium">

										<span class="badge bg-label-info"><i class="bx bx-map"></i>
											<?php echo $userProfile['BRANCH_NAME'] ?>
										</span>
									</li>

									<li class="list-inline-item fw-medium">
										<span class="badge bg-label-warning">
											<i class="bx bx-calendar-alt"></i>
											<?php echo $userProfile['DOJ'] ?>
										</span>
									</li>
								</ul>
							</div>
							<a href="javascript:void(0)" class="btn btn btn-danger btn-buy-now text-nowrap">
								<i class="bx bx-group me-1"></i>Team Member <i class='bx bx-arrow-from-left'></i>
							</a>
						</div>
					</div>
				</div>
			</div>


		</div>
		<div class="col-sm-12 col-md-6  col-lg-6 order-0">
			<div class="card">
				<h5 class="card-header m-auto boxDkh text-white ">Approval Pending List</h5>
				<div class="card-body ">
					<div class="table-responsive text-nowrap">
						<table class="table  table-bordered">
							<thead class="table-darks" style="background-color:#0c184e">
								<tr>
									<th scope="col" align="center"> <strong>SL</strong></th>
									<th scope="col" align="center"><strong>Approval Type</strong></th>
									<th scope="col" align="center"><strong>Count</strong></th>
								</tr>
							</thead>
							<tbody>
								<?php

								$number = 0;
								while ($row = oci_fetch_assoc($allDataSQL)) {
									$number++;
									?>
									<tr>
										<td align="center"><i class="fab fa-angular fa-lg text-danger me-3 "></i>
											<strong>
												<?php echo $number; ?>
											</strong>
										</td>
										<td>
											<?php echo $row['APPROVAL_TYPE']; ?>
										</td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['APPROVAL_LINK']; ?>>
												<span class="badge badge-center rounded-pill bg-info">
													<?php echo $row['NUMBER_TOTAL']; ?>
												</span>
											</a>
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
			<div class="card mt-3">
				<h5 class="card-header m-auto boxDkh text-white ">My Last 7 Days Attendance</h5>
				<div class="card-body">

					<!-- <h5 class="card-title text-primary">.</h5> -->
					<div class="table-responsive text-nowrap">
						<table class="table table-bordered">
							<thead class="table-darks" style="background-color:#0c184e">
								<tr>
									<th scope="col" align="center"> <strong>SL</strong></th>
									<th scope="col" align="center"><strong>Date</strong></th>
									<th scope="col" align="center"><strong>In/Out-Time</strong></th>
									<th scope="col" align="center"><strong>Status</strong></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$allDataSQL = oci_parse(
									$objConnect,
									"select ATTN_DATE,IN_TIME,OUT_TIME,STATUS,DAY_NAME
                                                                     from RML_HR_ATTN_DAILY_PROC
                                                                     where trunc(ATTN_DATE) between to_date(sysdate-6,'dd/mm/RRRR') and to_date(sysdate,'dd/mm/RRRR')
																	and RML_ID='$emp_session_id'
                                                                    order by ATTN_DATE DESC"
								);
								oci_execute($allDataSQL);
								$number = 0;
								while ($row = oci_fetch_assoc($allDataSQL)) {
									$number++;
									?>
									<tr>
										<td align="center">
											<strong>
												<?php echo $number; ?>
											</strong>
										</td>
										<td>
											<?php echo $row['ATTN_DATE']; ?>
										</td>
										<td>
											<?php echo $row['IN_TIME'];
											echo '<br>';
											echo $row['OUT_TIME'];
											?>
										</td>
										<td>
											<?php echo $row['STATUS']; ?>
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
		<!--  attendance -->
		<div class="col-sm-12 col-md-6  col-lg-6 order-0">
			<div class="card boxDkh">
				<h5 class="card-header m-auto" style="color:#fff">
					The Month of <span class="badge bg-label-success rounded-pill">
						<?php echo date('F') ?>
					</span> Attendance
				</h5>
				<div class="">

					<div class="nav-align-top">
						<div class="tab-content boxDkb">
							<div class=" tab-pane active show" id="navs-justified-Barchart" role="tabpanel">
								<div id="attendanceBarChat" class="px-2 "></div>
							</div>
							<div class="tab-pane fade " id="navs-justified-Piechart" role="tabpanel">
								<div id="attPieChart"></div>
							</div>

						</div>
						<ul class="nav nav-tabs nav-fill" role="tablist">
							<li class="nav-item">
								<button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
									data-bs-target="#navs-justified-Barchart" aria-controls="navs-justified-Barchart" aria-selected="false">
									<i class='bx bxs-bar-chart-square' style="color:#37d7ce"></i> Barchart
								</button>
							</li>
							<li class="nav-item">
								<button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-Piechart"
									aria-controls="navs-justified-Piechart" aria-selected="true">
									<i class='bx bxs-pie-chart-alt-2' style="color:#37d7ce"></i> PieChart
								</button>
							</li>

						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- End attendance -->
		<!-- <-- Approval -->
		<div class="col-sm-12 col-md-6 col-lg-6 mb-2 order-0">


		</div>

		<!-- End Approval -->

	</div>
</div>
<!-- / Content -->



<?php require_once ('../layouts/footer_info.php'); ?>

<?php require_once ('../layouts/footer.php'); ?>


<script>
	let cardColor, headingColor, axisColor, shadeColor, borderColor;
	const attendanceBarChatEl = document.querySelector("#attendanceBarChat"),
		attendanceBarChatOptions = {
			series: [{
				name: new Date().getFullYear(),
				data: <?php echo json_encode($attBarChartData); ?>,
			},],
			chart: {
				height: 300,
				stacked: false,
				type: "bar",
				foreColor: '#fff',
				fontFamily: 'Helvetica, Arial, sans-serif',
			},
			plotOptions: {
				bar: {
					distributed: true,
					horizontal: false,
					columnWidth: "33%",
				},
			},
			colors: [config.colors.success, config.colors.warning, config.colors.danger, '#14d0c5', '#8829ca', '#b84467'],
			dataLabels: {
				enabled: true,
			},
			grid: {
				borderColor: "#40475D"
			},
			stroke: {
				curve: "smooth",
				width: 6,
				lineCap: "round",
				// colors: [cardColor],
			},
			legend: {
				show: false,
			},
			grid: {
				borderColor: borderColor,
				padding: {
					top: 0,
					bottom: -8,
					left: 20,
					right: 20,
				},
			},
			xaxis: {
				categories: ["P", "L", "A", "H", "T", "LV"],
				labels: {
					style: {
						fontSize: "13px",
						colors: axisColor,
					},
				},
				axisTicks: {
					show: false,
				},
				axisBorder: {
					show: false,
				},
			},
			yaxis: {
				labels: {
					style: {
						fontSize: "13px",
						colors: axisColor,
					},
				},
			},
			responsive: [{
				breakpoint: 1700,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "32%",
						},
					},
				},
			},
			{
				breakpoint: 1580,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "35%",
						},
					},
				},
			},
			{
				breakpoint: 1440,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "42%",
						},
					},
				},
			},
			{
				breakpoint: 1300,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "48%",
						},
					},
				},
			},
			{
				breakpoint: 1200,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "40%",
						},
					},
				},
			},
			{
				breakpoint: 1040,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 11,
							columnWidth: "48%",
						},
					},
				},
			},
			{
				breakpoint: 991,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "30%",
						},
					},
				},
			},
			{
				breakpoint: 840,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "35%",
						},
					},
				},
			},
			{
				breakpoint: 768,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "28%",
						},
					},
				},
			},
			{
				breakpoint: 640,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "32%",
						},
					},
				},
			},
			{
				breakpoint: 576,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "37%",
						},
					},
				},
			},
			{
				breakpoint: 480,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "45%",
						},
					},
				},
			},
			{
				breakpoint: 420,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "52%",
						},
					},
				},
			},
			{
				breakpoint: 380,
				options: {
					plotOptions: {
						bar: {
							borderRadius: 10,
							columnWidth: "60%",
						},
					},
				},
			},
			],
			states: {
				hover: {
					filter: {
						type: "none",
					},
				},
				active: {
					filter: {
						type: "none",
					},
				},
			},
		};
	if (typeof attendanceBarChatEl !== undefined &&
		attendanceBarChatEl !== null
	) {
		const attendanceBarChat = new ApexCharts(
			attendanceBarChatEl,
			attendanceBarChatOptions
		);
		attendanceBarChat.render();
	}



	let $attPieChartData = <?php echo json_encode($attPieChartData) ?>;
	// Convert string elements to integers using map
	var $FinalPieChartData = $attPieChartData.map(function (item) {
		return parseInt(item, 10); // Convert each element to an integer
	});
	var attpieChartOptions = {
		series: $FinalPieChartData,
		chart: {
			width: 455,
			type: 'pie',
			foreColor: '#fff',
			fontFamily: 'Helvetica, Arial, sans-serif',

		},
		labels: ['Preset', 'Late', 'Absent', 'Holyday', 'Tour', 'Leave'],
		// labels: ['Preset', 'Late', 'Absent'],
		colors: [config.colors.success, config.colors.warning, config.colors.danger, '#14d0c5', '#8829ca', '#b84467'],
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					width: 200
				},
				legend: {
					position: 'bottom'
				}
			}
		}]
	};

	var attPieChart = new ApexCharts(document.querySelector("#attPieChart"), attpieChartOptions);
	attPieChart.render();
</script>