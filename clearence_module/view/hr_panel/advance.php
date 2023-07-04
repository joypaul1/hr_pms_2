<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');

$v_excel_download=0; 
?>
<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

	<div class="card card-body">
		<form action="" method="post">
			<div class="row">
				<div class="col-sm-3">
					<label class="form-label" for="basic-default-fullname">Select Company</label>
					<select name="company_name" class="form-control  cust-control">
						<option selected value="">All</option>
						<?php

						$strSQL  = oci_parse($objConnect, "SELECT UNIQUE(R_CONCERN) AS R_CONCERN FROM RML_HR_APPS_USER ORDER BY R_CONCERN");
						oci_execute($strSQL);
						while ($row = oci_fetch_assoc($strSQL)) {
						?>
							<option value="<?php echo $row['R_CONCERN']; ?>" <?php echo (isset($_POST['company_name']) && $_POST['company_name'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>><?php echo $row['R_CONCERN']; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="form-label" for="basic-default-fullname">Select Start Date*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar">
							</i>
						</div>
						<input required="" type="date" name="start_date" class="form-control  cust-control" id="title" value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
					</div>
				</div>
				<div class="col-sm-2">
					<label class="form-label" for="basic-default-fullname">Select End Date*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar">
							</i>
						</div>
						<input required="" type="date" name="end_date" class="form-control  cust-control" id="title" value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
					</div>
				</div>
				<div class="col-sm-3">
					<label class="form-label" for="basic-default-fullname">Select Leave Type</label>
					<select name="emp_leave" class="form-control  cust-control">
						<option selected value="">All</option>
						<?php

						$strSQL  = oci_parse($objConnect, "select distinct(LEAVE_TYPE) LEAVE_TYPE from RML_HR_EMP_LEAVE 
															where LEAVE_TYPE is not null 
															order by LEAVE_TYPE");
						oci_execute($strSQL);
						while ($row = oci_fetch_assoc($strSQL)) {
						?>
							<option value="<?php echo $row['LEAVE_TYPE']; ?>"><?php echo $row['LEAVE_TYPE']; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label class="form-label" for="basic-default-fullname">&nbsp;</label>
						<input class="form-control  btn btn-sm btn-primary" type="submit" value="Search Data">
					</div>
				</div>


			</div>
			
		</form>
	</div>




	<!-- Bordered Table -->
	<div class="card mt-2">
		<h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i> <b>Leave Taken List</b></h5>
		<div class="card-body">
			<div class="table-responsive text-nowrap">
				<table class="table table-bordered" id="table">
					<thead class="table-dark">
						<tr>
							<th>SL</th>
							<th scope="col">Emp ID</th>
							<th scope="col">Name</th>
							<th scope="col">Dept.</th>
							<th scope="col">Leave Type</th>
							<th scope="col">To Date</th>
							<th scope="col">From Date</th>
							<th scope="col">Entry From</th>
							<th scope="col">Branch</th>
							<th scope="col">Approval Status</th>
						</tr>
					</thead>
					<tbody>

						<?php
						if (isset($_POST['start_date'])) {
							$company_name = $_REQUEST['company_name'];
							$leave_type = $_REQUEST['emp_leave'];
							$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
							$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

							$strSQL  = oci_parse(
								$objConnect,
								"SELECT 
						        B.RML_ID,
								B.EMP_NAME,
								B.R_CONCERN,
								B.DEPT_NAME,
								B.DESIGNATION,
								B.BRANCH_NAME,
								A.LEAVE_TYPE,
								A.START_DATE,
								A.END_DATE,
								A.ENTRY_FROM,
								A.IS_APPROVED
							FROM RML_HR_EMP_LEAVE A,RML_HR_APPS_USER B
							WHERE  A.RML_ID=B.RML_ID
							AND ('$leave_type' is null OR A.LEAVE_TYPE='$leave_type')
							AND ('$company_name' is null OR B.R_CONCERN='$company_name')
							AND (trunc(A.START_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy') OR
																		 trunc(A.END_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy') )
							ORDER BY START_DATE DESC"
							);
							oci_execute($strSQL);
							$number = 0;
							while ($row = oci_fetch_assoc($strSQL)) {
								$number++;
								$v_excel_download = 1;
						?>
								<tr>
									<td>
										<i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
									</td>
									<td><?php echo $row['RML_ID']; ?></td>
									<td><?php echo $row['EMP_NAME']; ?></td>
									<td><?php echo $row['DEPT_NAME']; ?></td>
									<td><?php echo $row['LEAVE_TYPE']; ?></td>
									<td><?php echo $row['START_DATE']; ?></td>
									<td><?php echo $row['END_DATE']; ?></td>
									<td><?php echo $row['ENTRY_FROM']; ?></td>
									<td><?php echo $row['BRANCH_NAME']; ?></td>
									<td><?php
										if ($row['IS_APPROVED'] == '1') {
											echo 'Approved';
										} else if ($row['IS_APPROVED'] == '0') {
											echo 'Denied';
										} else {
											echo 'Pending';
										}

										?></td>

								</tr>


						<?php
							}
						}
						?>



					</tbody>
				</table>
			</div>
			<?php
			if ($v_excel_download == 1) {
			?>
				<div>
					<a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export to excel</a>
				</div>
			<?php
			}
			?>
		</div>
	</div>
	<!--/ Bordered Table -->



</div>
<!-- / Content -->

<script>
	function exportF(elem) {
		var table = document.getElementById("table");
		table.style.border = "1px solid red";


		var html = table.outerHTML;
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);

		elem.setAttribute("download", "EMP_LEAVE_REPORT.xls"); // Choose the file name
		return false;
	}
</script>




<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>