<?php

$sqlQuary = "SELECT 'Offboarding' APPROVAL_TYPE,count(C.RML_ID) NUMBER_TOTAL,'$basePath/offboarding_module/view/lm_panel/approval.php' 	APPROVAL_LINK
		FROM EMP_CLEARENCE A,EMP_CLEARENCE_DTLS B,RML_HR_APPS_USER C
		WHERE A.ID=B.EMP_CLEARENCE_ID
		AND A.RML_HR_APPS_USER_ID=C.ID
		AND B.APPROVAL_STATUS IS NULL
		AND B.CONCERN_NAME IN (
						SELECT R_CONCERN from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
						(SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id'))
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

?>

<div class="card">
    <h5 class="card-header m-auto boxDkh text-white ">Approval Pending List</h5>
    <div class="card-body ">
        <div class="table-responsive text-nowrap">
            <table class="table  table-bordered">
                <thead class="table-darks" style="background-color:#18392b">
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