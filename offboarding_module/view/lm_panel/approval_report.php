<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];
if (!checkPermission('lm-offboarding-report')) {

    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}


?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">



    <!-- Bordered Table -->
    <div class="card mt-2">

        <?php
        $leftSideName  = 'Offboarding Apporval Details';
        ?>

        <?php

        $html = '<div class="card">
                <div class="card-header d-flex align-items-center justify-content-between" style="padding: 1.0% 1rem">
                    <div href="#" style="font-size: 18px;font-weight:700">
                        <i class="menu-icon tf-icons bx bx-edit" style="margin:0;font-size:30px"></i>';

        if (isset($leftSideName)) {
            $html .= $leftSideName;
        }
        $html .= '</div>
                            <div>
                                <a class="btn btn-sm btn-warning text-white" onclick="exportF(this)" style="margin-left:5px;"> <i class="bx bx-download"></i> Export To Excel</a>
                            </div>
                            <div>';
        if (isset($routePath)) {
            $route = $basePath . '/' . $routePath;
            $html .= '<a href="' . $route . '" class="btn btn-sm btn-info">';
        }

        if (isset($rightSideName)) {
            $html .= '<i class="menu-icon tf-icons bx bx-message-alt-add" style="margin:0;"></i>' . $rightSideName;
        }

        $html .= '</a>
                    </div>
                </div>
            </div>';

        echo $html;
        ?>
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-sm table-bordered" id="table">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">EMP Info</th>
                            <!-- <th scope="col">RML ID</th> -->
                            <th scope="col">Approval Status</th>
                            <th scope="col">Approval Details </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php


                        $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                        $allDataSQL  = oci_parse(
                            $objConnect,
                            "SELECT A.ID,
										   B.EMP_NAME,
										   B.RML_ID,
										   B.R_CONCERN,
										   B.DEPT_NAME,
										   B.DESIGNATION,
									       A.APPROVAL_STATUS
									  FROM EMP_CLEARENCE A,RML_HR_APPS_USER B
									  WHERE A.RML_HR_APPS_USER_ID=B.ID"
                        );

                        oci_execute($allDataSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($allDataSQL)) {
                            $number++;
                        ?>
                            <tr class="text-center">
                                <td>
                                    <strong><?php echo $number; ?></strong>
                                </td>
                                <td> <?= $row['EMP_NAME']; ?>
                                <br>
                                ID :  <?= $row['RML_ID']; ?>
                                </td>
                               
                                <td><?php
                                    if ($row['APPROVAL_STATUS'] == '1') {
                                        echo 'Approved';
                                    } else if ($row['APPROVAL_STATUS'] == '0') {
                                        echo 'Denied';
                                    } else if ($row['APPROVAL_STATUS'] == '') {
                                        echo 'Pending';
                                    }
                                    ?>


                                </td>
                                <td>
                                    <table class="table table-bordered">
                                        <?php
                                        $statusDataSQL = oci_parse($objConnect, "SELECT 
                                                d.ID, d.EMP_CLEARENCE_ID, d.REMARKS, 
                                                d.DEPARTMENT_ID, d.APPROVAL_STATUS, 
                                                d.APPROVE_DATE, h.DEPT_NAME
                                            FROM EMP_CLEARENCE_DTLS d
                                            JOIN RML_HR_DEPARTMENT h ON d.DEPARTMENT_ID = h.ID
                                            WHERE  d.EMP_CLEARENCE_ID = {$row['ID']}
                                            ");

                                        oci_execute($statusDataSQL);

                                        while ($statusRow = oci_fetch_array($statusDataSQL)) {
                                            $checked = $statusRow['APPROVAL_STATUS'] == 1 ? 'checked' : '';
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $statusRow['DEPT_NAME'] ?>
                                                </td>
                                                <td>
                                                    <?= $statusRow['APPROVE_DATE'] ?>
                                                </td>
                                                <td class="text-left">
                                                    <?= $statusRow['REMARKS'] ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
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
    <!--/ Bordered Table -->



</div>


<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
    function exportF(elem) {
        var table = document.getElementById("table");
        var html = table.outerHTML;

        // Get the current date
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD

        // Set the file name with the current date
        var fileName = "Offboarding_Approval_Details_Report (" + formattedDate + ").xls";

        var url = 'data:application/vnd.ms-excel,' + escape(html);

        // Set the href and download attributes
        elem.setAttribute("href", url);
        elem.setAttribute("download", fileName);

        return false;
    }
</script>