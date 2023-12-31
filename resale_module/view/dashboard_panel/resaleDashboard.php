<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

?>
<div class="container-xxl flex-grow-1 container-p-y">
	<div class="row">
		<!-- <div class="col-lg-12 ">
			<div class=" card card-title p-2">
				<marquee>Welcome to our Resale Dashboard. If you face any problem please, inform us [IT & ERP Dept.]</marquee>
			</div>
		</div> -->

		<!-- New Visitors & Activity -->
		<div class="col-12 mb-4">
			<div class="card" style="background-color:#313c6af7  !important">
				<h5 class="card-header m-auto boxDkh text-white ">Web Site Analysis Information </h5>

				<div class="card-body  row g-4 text-white">
					<div class="col-md-6 pe-md-4 card-separator">
						<div class="card-title d-flex align-items-start justify-content-between text-white">
							<h5 class="mb-0 text-white">New Visitors</h5>
							<small>Last Week</small>
						</div>
						<div class="d-flex justify-content-between">
							<div class="mt-auto">
								<h2 class="mb-2 text-white">23%</h2>
								<small class="text-info text-nowrap fw-medium"><i class='bx bx-down-arrow-alt'></i> -13.24%</small>
							</div>
							<div id="visitorsChart"></div>
						</div>
					</div>

					<div class="col-md-6 ps-md-4">
						<div class="card-title d-flex align-items-start justify-content-between text-white">
							<h5 class="mb-0 text-white">Activity</h5>
							<small>Last Week</small>
						</div>
						<div class="d-flex justify-content-between">
							<div class="mt-auto">
								<h2 class="mb-2 text-white">82%</h2>
								<small class="text-success text-nowrap fw-medium"><i class='bx bx-up-arrow-alt'></i> 24.8%</small>
							</div>
							<div id="activityChart"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ New Visitors & Activity -->

		<!-- monthwiseBidChart -->
		<div class="col-6 mb-4">
			<div class="card" style="background-color:#313c6af7  !important">
				<h5 class="card-header m-auto boxDkh text-white"> Bidding Analysis Information</h5>
				<div class="card-body row g-4 text-white">
					<div class="d-flex justify-content-center">
						<div id="monthwiseBidChart"></div>
					</div>
				</div>
			</div>
		</div>
		<!--/monthwiseBidChart -->
		<!-- monthwiseSellChart -->
		<div class="col-6 mb-4">
			<div class="card" style="background-color:#313c6af7  !important">
				<h5 class="card-header m-auto boxDkh text-white"> Sells Analysis Information</h5>
				<div class="card-body row g-4 text-white">
					<div class="d-flex justify-content-center">
						<div id="monthwiseSellChart"></div>
					</div>
				</div>
			</div>
		</div>
		<!--/ monthwiseSellChart -->


		<div class="col-sm-12 col-md-6 col-lg-6 mb-2 order-0">
			<div class="card ">
				<h5 class="card-header m-auto boxDkh text-white ">Product Published Information</h5>
				<div class="card-body">
					<div class="table-responsive text-nowrap">
						<table class="table  table-bordered">
							<thead style="background-color:green">
								<tr>
									<th scope="col" align="center"> <strong>SL</strong></th>
									<th scope="col" align="center"><strong>Brand</strong></th>
									<th align="center"><strong>Product</strong></th>
									<th align="center"><strong>Pre-Published</strong></th>
									<th scope="col" align="center"><strong>Published</strong></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$PRODUCT_SQL = oci_parse(
									$objConnect,
									" SELECT 
												  B.TITLE BRAND_NAME,
												  (SELECT COUNT(A.ID) FROM PRODUCT A WHERE A.BRAND_ID=B.ID) TOTAL_PRODUCT,
												  PRE_PUBLISHED_PRODUCT(ID) TOTAL_PRE_PUBLISHED,
												  PUBLISHED_PRODUCT(ID,'Y')  TOTAL_PUBLISHED
												FROM BRAND B"
								);

								oci_execute($PRODUCT_SQL);
								$number = 0;
								while ($row = oci_fetch_assoc($PRODUCT_SQL)) {
									$number++;
									?>
									<tr>
										<td align="center"><i class="fab fa-angular fa-lg text-danger me-3 "></i>
											<strong>
												<?php echo $number; ?>
											</strong>
										</td>
										<td>
											<?php echo $row['BRAND_NAME']; ?>
										</td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['TOTAL_PRODUCT']; ?>>
												<span class="badge badge-center rounded-pill bg-info">
													<?php echo $row['TOTAL_PRODUCT']; ?>
												</span>
											</a>
										</td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['TOTAL_PRE_PUBLISHED']; ?>>
												<span class="badge badge-center rounded-pill bg-info">
													<?php echo $row['TOTAL_PRE_PUBLISHED']; ?>
												</span>
											</a>
										</td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['TOTAL_PUBLISHED']; ?>>
												<span class="badge badge-center rounded-pill bg-info">
													<?php echo $row['TOTAL_PUBLISHED']; ?>
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
				<h5 class="card-header m-auto boxDkh text-white ">Product Bid Information</h5>
				<div class="card-body">
					<div class="table-responsive text-nowrap">
						<div class="table-responsive text-nowrap">
							<table class="table  table-bordered">
								<thead style="background-color:green">
									<tr>
										<th scope="col" align="center"> <strong>SL</strong></th>
										<th scope="col" align="center"><strong>Product</strong></th>
										<th scope="col" align="center"><strong>Total Bid</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$PRODUCT_SQL = oci_parse(
										$objConnect,
										"SELECT 
													BB.ID,
													BB.MODEL,
													BB.BOOK_VALUE,
													BB.DISPLAY_PRICE,
													AA.MAX_BID_AMOUNT,
													AA.TOTAL_BID,
												   (BB.AUCTION_END_DATE-trunc(SYSDATE)) AUCTION_PENDING
												 FROM 
														(SELECT A.PRODUCT_ID,
															   COUNT(PRODUCT_ID) TOTAL_BID,
															   MAX_BID_AMOUNT(A.PRODUCT_ID) MAX_BID_AMOUNT
														FROM PRODUCT_BID A,PRODUCT B
														WHERE A.PRODUCT_ID=B.ID
														GROUP BY A.PRODUCT_ID) AA,PRODUCT BB
													WHERE AA.PRODUCT_ID=BB.ID"
									);

									oci_execute($PRODUCT_SQL);
									$number = 0;
									while ($row = oci_fetch_assoc($PRODUCT_SQL)) {
										$number++;
										?>
										<tr>
											<td align="center"><i class="fab fa-angular fa-lg text-danger me-3 "></i>
												<strong>
													<?php echo $number; ?>
												</strong>
											</td>
											<td>
												<?php
												echo $row['MODEL']
													?>
											</td>
											<td>
												<?php echo $row['TOTAL_BID']; ?>
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
		<!-- monthwiseSellChart -->
		<div class="col-sm-12 col-md-6 col-lg-6 mb-2 order-0">
			<div class="card" style="background-color:#313c6af7  !important">
				<h5 class="card-header m-auto boxDkh text-white"> Division Wise Customer </h5>
				<div class="card-body row g-4 text-white">
					<div class="d-flex justify-content-center">
						<div id="divisionWiseUser"></div>
					</div>
				</div>
			</div>
		</div>
		<!--/ monthwiseSellChart -->

	</div>



</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
	let isDarkStyle = true;

	let o, e, r, t, s, a, i, n, l;
	l = isDarkStyle
		? (
			(o = 'red'),
			(e = 'orange'),
			(r = 'gray'),
			(s = 'black'),
			(t = "dark"),
			(a = "#4f51c0"),
			(i = "#595cd9"),
			(n = "#8789ff"),
			"#c3c4ff")
		: (
			(o = 'red'),
			(e = 'orange'),
			(r = 'gray'),
			(s = 'black'),
			(t = ""),
			(a = "#e1e2ff"),
			(i = "#c3c4ff"),
			(n = "#a5a7ff"),
			"#696cff");
	const visitorsChart = document.querySelector("#visitorsChart"),
		visitorsChartOptions = {
			chart: {
				height: 120,
				width: 200,
				parentHeightOffset: 0,
				type: "bar",
				toolbar: { show: !1 },
			},
			plotOptions: {
				bar: {
					barHeight: "75%",
					columnWidth: "60%",
					startingShape: "rounded",
					endingShape: "rounded",
					borderRadius: 9,
					distributed: !0,
				},
			},
			grid: { show: !1, padding: { top: -25, bottom: -12 } },
			colors: ['orangered'],
			dataLabels: { enabled: !1 },
			series: [{ data: [40, 95, 60, 45, 90, 50, 75] }],
			legend: { show: !1 },
			responsive: [
				{
					breakpoint: 1440,
					options: {
						plotOptions: { bar: { borderRadius: 9, columnWidth: "60%" } },
					},
				},
				{
					breakpoint: 1300,
					options: {
						plotOptions: { bar: { borderRadius: 9, columnWidth: "60%" } },
					},
				},
				{
					breakpoint: 1200,
					options: {
						plotOptions: { bar: { borderRadius: 8, columnWidth: "50%" } },
					},
				},
				{
					breakpoint: 1040,
					options: {
						plotOptions: { bar: { borderRadius: 8, columnWidth: "50%" } },
					},
				},
				{
					breakpoint: 991,
					options: {
						plotOptions: { bar: { borderRadius: 8, columnWidth: "50%" } },
					},
				},
				{
					breakpoint: 420,
					options: {
						plotOptions: { bar: { borderRadius: 8, columnWidth: "50%" } },
					},
				},
			],
			xaxis: {
				categories: ["M", "T", "W", "T", "F", "S", "S"],
				axisBorder: { show: !1 },
				axisTicks: { show: !1 },
				labels: { style: { colors: r, fontSize: "13px" } },
			},
			yaxis: { labels: { show: !1 } },
		};

	if (typeof visitorsChart !== undefined &&
		visitorsChart !== null
	) {
		const attendanceBarChat = new ApexCharts(
			visitorsChart,
			visitorsChartOptions
		);
		attendanceBarChat.render();
	}


	const activityChart = document.querySelector("#activityChart"),
		activityChartOptions = {
			chart: {
				height: 120,
				width: 220,
				parentHeightOffset: 0,
				toolbar: { show: !1 },
				type: "area",
			},
			dataLabels: { enabled: !1 },
			stroke: { width: 2, curve: "smooth" },
			series: [{ data: [15, 20, 14, 22, 17, 40, 12, 35, 25] }],
			colors: [config.colors.success],
			fill: {
				type: "gradient",
				gradient: {
					shade: t,
					shadeIntensity: 0.8,
					opacityFrom: 0.8,
					opacityTo: 0.25,
					stops: [0, 85, 100],
				},
			},
			grid: { show: !1, padding: { top: -20, bottom: -8 } },
			legend: { show: !1 },
			xaxis: {
				categories: ["A1", "A2", "A3", "A4", "A5", "A6", "A7", "A8", "A9"],
				axisBorder: { show: !1 },
				axisTicks: { show: !1 },
				labels: { style: { fontSize: "13px", colors: r } },
			},
			yaxis: { labels: { show: !1 } },
		};

	if (typeof activityChart !== undefined &&
		activityChart !== null
	) {
		const activityBarChart = new ApexCharts(
			activityChart,
			activityChartOptions
		);
		activityBarChart.render();
	}


	//monthwisebidBarChart//
	const monthwiseBidChart = document.querySelector("#monthwiseBidChart"),
		monthwisebidChartOptions = {
			series: [{
				name: 'Eicher',
				data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 55, 57, 56]
			}, {
				name: 'Mahindra',
				data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 101, 98, 87]
			}, {
				name: 'Dongfeng',
				data: [35, 41, 36, 26, 45, 48, 52, 53, 41, 36, 26, 45]
			}],
			chart: {
				type: 'bar',
				height: 600,
				width: 500,
				foreColor: '#fff',
				fontFamily: 'Helvetica, Arial, sans-serif',
			},
			plotOptions: {
				bar: {
					horizontal: true,
					columnWidth: '55%',
					endingShape: 'rounded'
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 3,
				colors: ['transparent']
			},
			xaxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			},
			yaxis: {
				title: {
					text: 'TK (Thousands)'
				}
			},
			fill: {
				opacity: 2,
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return "TK " + val + " Thousands"
					}
				}
			}
		};

	if (typeof monthwiseBidChart !== undefined &&
		monthwiseBidChart !== null
	) {
		const monthwisebidBarChart = new ApexCharts(
			monthwiseBidChart,
			monthwisebidChartOptions
		);
		monthwisebidBarChart.render();
	}



	//monthwisebidBarChart//
	//monthwiseSellChart
	const monthwiseSellChart = document.querySelector("#monthwiseSellChart"),
		monthwiseSellChartOptions = {
			series: [{
				name: 'Eicher',
				data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 55, 57, 56]
			}, {
				name: 'Mahindra',
				data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 101, 98, 87]
			}, {
				name: 'Dongfeng',
				data: [35, 41, 36, 26, 45, 48, 52, 53, 41, 36, 26, 45]
			}],
			chart: {
				type: 'bar',
				height: 600,
				width: 500,
				foreColor: '#fff',
				fontFamily: 'Helvetica, Arial, sans-serif',
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '55%',
					endingShape: 'rounded'
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			xaxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			},
			yaxis: {
				title: {
					text: 'TK (Thousands)'
				}
			},
			fill: {
				opacity: 2,
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return "TK " + val + " Thousands"
					}
				}
			}
		};

	if (typeof monthwiseSellChart !== undefined &&
		monthwiseSellChart !== null
	) {
		const monthwisebidBarChart = new ApexCharts(
			monthwiseSellChart,
			monthwiseSellChartOptions
		);
		monthwisebidBarChart.render();
	}


	//divisionWiseUser 
	//divisionWiseUser
	const divisionWiseUser = document.querySelector("#divisionWiseUser"),
		divisionWiseUserOptions = {
			series: [
				{
					name: "",
					data: [200, 330, 548, 740, 880, 990, 1100, 1380],
				},
			],
			chart: {
				type: "bar",
				height: 350,
				foreColor: '#fff',
				fontFamily: 'Helvetica, Arial, sans-serif',
			},
			plotOptions: {
				bar: {
					borderRadius: 0,
					horizontal: true,
					distributed: true,
					barHeight: "80%",
					isFunnel: true,
				},
			},
			colors: [
				"#F44F5E",
				"#E55A89",
				"#D863B1",
				"#CA6CD8",
				"#B57BED",
				"#8D95EB",
				"#62ACEA",
				"#4BC3E6",
			],
			dataLabels: {
				enabled: false,
				formatter: function (val, opt) {
					return opt.w.globals.labels[opt.dataPointIndex];
				},
				dropShadow: {
					enabled: true,
				},
			},

			xaxis: {
				categories: [
					"Dhaka",
					"Chattogram",
					"Barishal",
					"Khulna",
					"Rajshahi",
					"Rangpur",
					"Mymensingh",
					"Sylhet",
				],
			},
			legend: {
				show: false,
			},
		};

	if (typeof divisionWiseUser !== undefined && divisionWiseUser !== null) {
		const divisionWiseUserBarChart = new ApexCharts(
			divisionWiseUser,
			divisionWiseUserOptions
		);
		divisionWiseUserBarChart.render();
	}

</script>