<?php

require_once('../helper/com_conn.php');
require_once('../inc/connoracle.php');

// echo $basePath;
// die();
?>
<div class="container-xxl flex-grow-1 container-p-y">
	<div class="row">
		<div class=" col-lg-12 ">
			<div class=" card card-title p-2">
				<marquee>সকলকে পবিত্র ঈদুল আজহার শুভেচ্ছা ও ঈদ মোবারাক</marquee>
			</div>
		</div>
		<div class="col-lg-6 mb-2 order-0">
			<div class="card">
				<div class="d-flex align-items-end row">
					<div class="col-sm-7">
						<div class="card-body">
							<h5 class="card-title text-primary">Congratulations <?php echo $_SESSION['HR']['first_name_hr']; ?>! 🎉</h5>
							<p class="mb-4">
								Access Are Predefine according to <span class="fw-bold">Rangs Motors HR Policy.</span>
								If you need more access please contact with HR.
							</p>
							<a href="" class="btn btn-sm btn-primary">Universal Notification</a>
						</div>
					</div>
					<div class="col-sm-5 text-center text-sm-left">
						<div class="card-body pb-0 px-0 px-md-4">
							<img src="<?php echo $basePath ?>/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--  
        <div class="col-lg-6 mb-4 order-0">
            <div class="card">
			   <div class="">
                <img src="<?php echo $basePath ?>/images/dashing_images.png" class="img-fluid" style="height:242px;width: 100%;border-radius: 2%;">
               </div>
            </div>
        </div>
		
		
		 <-- Approval -->
		<div class="col-lg-6 mb-2 order-0">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title text-primary">User Manual List</h5>
					
				</div>
			</div>
		</div>
		<!-- End Approval -->
		<!--  Approval --> 
		<div class="col-lg-6 mb-2 order-0">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title text-primary">Approval Pending List</h5>
					<div class="table-responsive text-nowrap">
						<table class="table table-bordered">
							<thead class="">
								<tr>
									<th scope="col" align="center"><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>SL</strong></th>
									<th scope="col" align="center"><strong>Approval Type</strong></th>
									<th scope="col" align="center"><strong>Count</strong></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$allDataSQL  = oci_parse(
									$objConnect,
									"SELECT 'OUTDOOR_ATTN' APPROVAL_TYPE, COUNT(A.ID) NUMBER_TOTAL, 
									 '" . $basePath . "/attendance_module/view/lm_panel/approval.php' AS APPROVAL_LINK
									FROM RML_HR_ATTN_DAILY a, RML_HR_APPS_USER b
									WHERE A.RML_ID = B.RML_ID
									AND b.LINE_MANAGER_RML_ID = '$emp_session_id'
									AND TRUNC(a.ATTN_DATE) > TO_DATE('01/01/2023', 'DD/MM/YYYY')
									AND a.IS_ALL_APPROVED = 0
									AND A.LINE_MANAGER_APPROVAL IS NULL
									AND B.IS_ACTIVE = 1
									UNION ALL
									select 'LEAVE' APPROVAL_TYPE,count(a.RML_ID)NUMBER_TOTAL,'$basePath/leave_module/view/lm_panel/approval.php' APPROVAL_LINK from RML_HR_EMP_LEAVE a,RML_HR_APPS_USER b
									where A.RML_ID=b.RML_ID
									and B.LINE_MANAGER_RML_ID='$emp_session_id'
									and trunc(a.START_DATE)>TO_DATE('01/01/2023','DD/MM/YYYY')
									and a.IS_APPROVED IS NULL
									UNION ALL
									select 'TOUR' APPROVAL_TYPE,count(a.RML_ID)NUMBER_TOTAL,'$basePath/tour_module/view/lm_panel/approval.php' APPROVAL_LINK from RML_HR_EMP_TOUR a,RML_HR_APPS_USER b
									where A.RML_ID=b.RML_ID
									and B.LINE_MANAGER_RML_ID='$emp_session_id'
									and trunc(a.START_DATE)>TO_DATE('31/12/2022','DD/MM/YYYY')
									and a.LINE_MANAGER_APPROVAL_STATUS IS NULL
									UNION ALL
									SELECT 'Offboarding' APPROVAL_TYPE,count(C.RML_ID),'$basePath/offboarding_module/view/lm_panel/approval.php' APPROVAL_LINK 
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
									AND LINE_MANAGER_2_ID='$emp_session_id'"
								);
								oci_execute($allDataSQL);
								$number = 0;
								while ($row = oci_fetch_assoc($allDataSQL)) {
									$number++;
								?>
									<tr>
										<td align="center"><i class="fab fa-angular fa-lg text-danger me-3 "></i>
											<strong><?php echo $number; ?></strong>
										</td>
										<td><?php echo $row['APPROVAL_TYPE']; ?></td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['APPROVAL_LINK']; ?>><?php echo $row['NUMBER_TOTAL']; ?></a>
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
		<!-- End Approval -->




	</div>




</div>
<!-- / Content -->



<?php require_once('../layouts/footer_info.php'); ?>
<?php require_once('../layouts/footer.php'); ?>