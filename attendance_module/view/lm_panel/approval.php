<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('lm-attendance-approval')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$v_view_approval = 0;

$emp_session_id = $_SESSION['HR']['emp_id_hr'];







        // Single ID Approval
        if (isset($_POST['submit_approval_single'])) {
			
            if (!empty($_POST['check_list'])) {
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
					$sql="update RML_HR_ATTN_DAILY set 
														LINE_MANAGER_APPROVAL=1,
														IS_ALL_APPROVED=1,
														LINE_MANAGER_APPROVAL_REMARKS='web approval',
														LINE_MANAGER_APPROVAL_DATE=SYSDATE
                                                       where ID='$TT_ID_SELECTTED'";
                    $strSQL = oci_parse($objConnect,$sql );
                    oci_execute($strSQL);
                    $attnProcSQL  = oci_parse($objConnect, "declare V_ATTN_DATE VARCHAR2(100); V_RML_ID VARCHAR2(100); BEGIN SELECT TO_CHAR(ATTN_DATE,'dd/mm/yyyy'),RML_ID INTO V_ATTN_DATE,V_RML_ID FROM RML_HR_ATTN_DAILY  WHERE ID='$TT_ID_SELECTTED';RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_ATTN_DATE,'dd/mm/yyyy'),TO_DATE(V_ATTN_DATE,'dd/mm/yyyy'));END;");

                    if (oci_execute($attnProcSQL)) {
                        $message = [
                            'text' => 'Successfully Approved Outdoor Attendance ID ' . $TT_ID_SELECTTED,
                            'status' => 'true',
                        ];
                        $_SESSION['noti_message'] = $message;
                    }
                }
				echo "<script>window.location = ".$basePath."'/attendance_module/view/lm_panel/approval.php'</script>";
            } else {
                $message = [
                    'text' => 'Sorry! You have not select any ID Code.',
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
            }
        }
		
		
		
		
		
		
		
		 if (isset($_POST['submit_approval'])) { //to run PHP script on submit
            if (!empty($_POST['check_list'])) {
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
                    $strSQL = oci_parse(
                        $objConnect,
                        "update RML_HR_ATTN_DAILY set 
														LINE_MANAGER_APPROVAL=1,
														IS_ALL_APPROVED=1,
														LINE_MANAGER_APPROVAL_REMARKS='web approval',
														LINE_MANAGER_APPROVAL_DATE=SYSDATE
                                                       where ID='$TT_ID_SELECTTED'"
                    );

                    oci_execute($strSQL);
					 $attnProcSQL  = oci_parse($objConnect, "declare V_ATTN_DATE VARCHAR2(100); V_RML_ID VARCHAR2(100); BEGIN SELECT TO_CHAR(ATTN_DATE,'dd/mm/yyyy'),RML_ID INTO V_ATTN_DATE,V_RML_ID FROM RML_HR_ATTN_DAILY  WHERE ID='$TT_ID_SELECTTED';RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_ATTN_DATE,'dd/mm/yyyy'),TO_DATE(V_ATTN_DATE,'dd/mm/yyyy'));END;");
                    //$attnProcSQL  = oci_parse($objConnect, "declare V_START_DATE VARCHAR2(100); V_END_DATE VARCHAR2(100); V_RML_ID VARCHAR2(100);begin  SELECT TO_CHAR(START_DATE,'dd/mm/yyyy'),TO_CHAR(END_DATE,'dd/mm/yyyy'),RML_ID INTO V_START_DATE,V_END_DATE,V_RML_ID  FROM RML_HR_EMP_LEAVE WHERE ID=$TT_ID_SELECTTED; RML_HR_ATTN_PROC(V_RML_ID,TO_DATE(V_START_DATE,'dd/mm/yyyy'),TO_DATE(V_END_DATE,'dd/mm/yyyy'));end;");

                    if (oci_execute($attnProcSQL)) {
                        $message = [
                            'text' => 'Successfully Approved Outdoor Attendance ID ' . $TT_ID_SELECTTED,
                            'status' => 'true',
                        ];
                        $_SESSION['noti_message'] = $message;
                    }
                }
               echo "<script>window.location = ".$basePath."'/attendance_module/view/lm_panel/approval.php'</script>";
            } else {
                $message = [
                    'text' => 'Sorry! You have not select any ID Code.',
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
            }
        }
		
		
		// Denied option
        if (isset($_POST['submit_denied'])) { //to run PHP script on submit
            if (!empty($_POST['check_list'])) {
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
                    $strSQL = oci_parse(
                        $objConnect,
                        "update RML_HR_ATTN_DAILY set 
														LINE_MANAGER_APPROVAL=0,
														IS_ALL_APPROVED=0,
														LINE_MANAGER_APPROVAL_REMARKS='web approval',
														LINE_MANAGER_APPROVAL_DATE=SYSDATE
                                                       where ID='$TT_ID_SELECTTED'"
                    );

                    oci_execute($strSQL);
                    $message = [
                        'text' => 'Successfully Denied Outdoor Attendance ID ' . $TT_ID_SELECTTED,
                        'status' => 'true',
                    ];
                    $_SESSION['noti_message'] = $message;
                }
                 echo "<script>window.location = ".$basePath."'/attendance_module/view/lm_panel/approval.php'</script>";
            } else {
                $message = [
                    'text' => 'Sorry! You have not select any ID Code.',
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
            }
        }

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
        <div class="card card-body">
            <form id="Form1" action="" method="post"></form>
            <form id="Form2" action="" method="post"></form>
            <div class="row">
                <div class="col-sm-3">
                    <label>Select Your Concern:</label>
                    <select name="emp_concern" class="form-control  cust-control" form="Form1">
                        <option selected value="">---</option>
                        <?php


                        $strSQL  = oci_parse($objConnect, "select RML_ID,EMP_NAME from RML_HR_APPS_USER 
                                                                            where LINE_MANAGER_RML_ID ='$emp_session_id'
                                                                            and is_active=1 
                                                                            order by EMP_NAME");
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                        ?>

                            <option value="<?php echo $row['RML_ID']; ?>"><?php echo $row['EMP_NAME']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>From Date:</label>
                    <input required="" class="form-control  cust-control" form="Form1" name="start_date" form="Form1" type="date" />

                </div>
                <div class="col-sm-3">
                    <label>To Date:</label>
                    <input required="" class="form-control  cust-control" form="Form1" id="date" name="end_date" form="Form1" type="date" />

                </div>
                <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Approval Data" form="Form1">
                </div>
            </div>

        </div>

        <div class="card  col-lg-12 mt-2">
            <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>Concern Attendance Approval List</b></h5>
          
                <div class="">
                    <div class="resume-item d-flex flex-column flex-md-row">
                        <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
                            <thead class="table-dark text-center">
                                <tr class="text-center">
                                    <th scope="col">Sl</th>
                                    <th scope="col">Emp Info</th>
                                    <th scope="col">Entry Info</th>
                                </tr>
                            </thead>



                            <?php
                            @$emp_concern = $_REQUEST['emp_concern'];
                            @$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

                            if (isset($_POST['start_date'])) {
								$sql="select  a.ID,
											  b.EMP_NAME,
											  a.RML_ID,
											  a.ENTRY_DATE,
											  a.ATTN_DATE,
											  a.OUTSIDE_REMARKS,
											  a.ENTRY_BY,
											  b.DEPT_NAME,
											  b.BRANCH_NAME,
											  b.DESIGNATION
										FROM RML_HR_ATTN_DAILY a, RML_HR_APPS_USER b
										WHERE A.RML_ID = B.RML_ID
										AND b.LINE_MANAGER_RML_ID = '$emp_session_id'
										AND trunc(a.ATTN_DATE) BETWEEN  trunc(SYSDATE)-( select KEY_VALUE from HR_GLOBAL_CONFIGARATION
											   where KEY_TYPE='ATTN_OUTDOOR_APPROVAL') AND  trunc(SYSDATE)
										AND a.IS_ALL_APPROVED = 0
										and ('$emp_concern' is null OR A.RML_ID='$emp_concern')
										AND A.LINE_MANAGER_APPROVAL IS NULL
										AND B.IS_ACTIVE = 1";
														
			
                            
                        $strSQL  = oci_parse($objConnect, $sql);

                                oci_execute($strSQL);
                                $number = 0;

                                while ($row = oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    $v_view_approval = 1;
                            ?>
                                    <tbody>
                                       <tr>
                                            <td><input type="checkbox" name="check_list[]"  form="Form2" value="<?php echo $row['ID'];  ?>">
                                                <?php echo $number; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['EMP_NAME'];
                                                echo ',<br>';
                                                echo $row['RML_ID'];
                                                echo ',<br>';
                                                echo $row['DEPT_NAME'];
                                                echo ',<br>';
                                                echo $row['DESIGNATION'];
                                                echo ',<br>';
                                                echo $row['BRANCH_NAME']; ?>
                                                <input class="btn btn-primary btn pull-right" form="Form2"  type="submit" name="submit_approval_single" value="Approve" />
                                            </td>
                                            <td>
                                                <?php echo $row['ATTN_DATE'];
                                                echo ',<br>';
                                                echo 'Remarks:-' . $row['OUTSIDE_REMARKS'];
                                                ?>
                                            </td>


                                        </tr>
                                    <?php
                                }
                                if ($v_view_approval > 0) {
                                    ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input class="btn btn-primary btn pull-right" form="Form2"  type="submit" name="submit_approval" value="Approve" />
                                            </td>

                                            <td><input class="btn btn-primary btn pull-right" form="Form2"  type="submit" name="submit_denied" value="Denied" /></td>
                                        </tr>

                                    <?php
                                }
                            } else {

                                $allDataSQL  = oci_parse($objConnect, "select a.ID,
								                                              b.EMP_NAME,
																			  a.RML_ID,
																			  a.ENTRY_DATE,
																			  a.ATTN_DATE,
																			  a.OUTSIDE_REMARKS,
																			  a.ENTRY_BY,
																			  b.DEPT_NAME,
																			  b.BRANCH_NAME,
																			  b.DESIGNATION
														FROM RML_HR_ATTN_DAILY a, RML_HR_APPS_USER b
														WHERE A.RML_ID = B.RML_ID
														AND b.LINE_MANAGER_RML_ID = '$emp_session_id'
														AND trunc(a.ATTN_DATE) BETWEEN  trunc(SYSDATE)-( select KEY_VALUE from HR_GLOBAL_CONFIGARATION
                                                               where KEY_TYPE='ATTN_OUTDOOR_APPROVAL') AND  trunc(SYSDATE)
														AND a.IS_ALL_APPROVED = 0
														AND A.LINE_MANAGER_APPROVAL IS NULL
														AND B.IS_ACTIVE = 1");

                                @oci_execute($allDataSQL);
                                $number = 0;

                                while ($row = oci_fetch_assoc($allDataSQL)) {
                                    $number++;
                                    $v_view_approval = 1;
                                    ?>
                                        <tr>
                                            <td><input type="checkbox" name="check_list[]" form="Form2"  value="<?php echo $row['ID']; ?>">
                                                <?php echo $number; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['EMP_NAME'];
                                                echo ',<br>';
                                                echo $row['RML_ID'];
                                                echo ',<br>';
                                                echo $row['DEPT_NAME'];
                                                echo ',<br>';
                                                echo $row['DESIGNATION'];
                                                echo ',<br>';
                                                echo $row['BRANCH_NAME']; ?>
                                                <input class="btn btn-primary btn pull-right" form="Form2"  type="submit" name="submit_approval_single" value="Approve" />
                                            </td>
                                            <td>
                                                <?php echo $row['ATTN_DATE'];
                                                echo ',<br>';
                                                echo 'Remarks:-' . $row['OUTSIDE_REMARKS'];
                                                ?>
                                            </td>


                                        </tr>
                                    <?php
                                }
                                if ($v_view_approval > 0) {
                                    ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input class="btn btn-primary btn pull-right" form="Form2"  type="submit" name="submit_approval" value="Approve" />
                                            </td>
                                            <td>
                                                <input class="btn btn-primary btn pull-right" form="Form2"  type="submit" name="submit_denied" value="Denied" />
                                            </td>

                                        </tr>
                                <?php
                                }
                            }
                                ?>
                                    </tbody>

                        </table>
                    </div>

                </div>
 
        </div>
    </div>

</div>

<!-- / Content -->



<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>