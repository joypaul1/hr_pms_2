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

    <div class="card card-body ">
        <form action="" method="get">
            <div class="row justify-content-center">
                <input required name="emp_id" type='hidden' value='<?php echo $emp_session_id; ?>'>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Select Start Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="start_date" class="form-control  cust-control" id="title" value="">
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Select End Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="end_date" class="form-control  cust-control" id="title" value="">
                    </div>
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
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="table">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">RML ID</th>
                            <th scope="col">EMP NAME </th>
                            <th scope="col">DEPARTMENT</th>
                            <th scope="col">DESIGNATION</th>
                            <th scope="col">OFFBORDING START DATE </th>
                            <th scope="col">ADMINISTRATION APPROVAL DATE </th>
                            <th scope="col">ADMINISTRATION REMARKS </th>
                            <th scope="col">Finance & Accounts APPROVAL DATE </th>
                            <th scope="col">Finance & Accounts REMARKS </th>
                            <th scope="col">Human Resources APPROVAL DATE </th>
                            <th scope="col">Human Resources REMARKS </th>
                            <th scope="col">IT & ERP APPROVAL DATE </th>
                            <th scope="col">IT & ERP REMARKS </th>
                            <th scope="col">Internal Audit APPROVAL DATE </th>
                            <th scope="col">Internal Audit REMARKS </th>
                            <th scope="col">Legal DEPARTMENT DATE </th>
                            <th scope="col">Legal DEPARTMENT REMARKS </th>
                            <th scope="col">Age</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php


                        $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                        $quary = "WITH
                                    CTE_EMP_CLEARENCE AS (
                                        SELECT
                                            A.ID AS EMP_CLEARENCE_ID,
                                            A.RML_HR_APPS_USER_ID,
                                            A.APPROVAL_STATUS,
                                            A.CREATED_DATE
                                        FROM
                                            DEVELOPERS.EMP_CLEARENCE A
                                    )
                                    SELECT
                                        CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID,
                                        TO_CHAR (CTE_EMP_CLEARENCE.CREATED_DATE, 'DD-MM-YYYY') AS CREATED_DATE,
                                        B.EMP_NAME,
                                        B.RML_ID,
                                        B.R_CONCERN,
                                        B.DEPT_NAME,
                                        B.DESIGNATION,
                                        CTE_EMP_CLEARENCE.APPROVAL_STATUS,
                                        LISTAGG (H.DEPT_NAME, ',') WITHIN GROUP (ORDER BY CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID) AS APPROVAL_DEPARTMENT_NAMES,
                                        --finance_accounts
                                        (
                                            SELECT
                                                NVL(ECD.REMARKS,'-')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 1
                                        ) AS FINANCE_ACCOUNTS_REMARKS,
                                        (
                                            SELECT
                                                TO_CHAR (ECD.APPROVE_DATE, 'DD-MM-YYYY')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 1
                                        ) AS FINANCE_ACCOUNTS_APPROVAL_DATE,
                                        -- Internal_Audit
                                        (
                                            SELECT
                                                NVL(ECD.REMARKS,'-')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 14
                                        ) AS INTERNAL_AUDIT_REMARKS,
                                        (
                                            SELECT
                                                TO_CHAR (ECD.APPROVE_DATE, 'DD-MM-YYYY')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 14
                                        ) AS INTERNAL_AUDIT_APPROVAL_DATE,
                                        -- Internal_Audit
                                        -- IT_ERP_Audit
                                        (
                                            SELECT
                                                NVL(ECD.REMARKS,'-')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 15
                                        ) AS IT_ERP_REMARKS,
                                        (
                                            SELECT
                                                TO_CHAR (ECD.APPROVE_DATE, 'DD-MM-YYYY')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 15
                                        ) AS INTERNAL_AUDIT_APPROVAL_DATE,
                                        -- IT_ERP_Audit
                                        -- Legal
                                        (
                                            SELECT
                                                NVL(ECD.REMARKS,'-')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 18
                                        ) AS LEGAL_REMARKS,
                                        (
                                            SELECT
                                                TO_CHAR (ECD.APPROVE_DATE, 'DD-MM-YYYY')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 18
                                        ) AS LEGAL_APPROVAL_DATE,
                                        -- Legal
                                        -- Administration
                                        (
                                            SELECT
                                                NVL(ECD.REMARKS,'-')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 81
                                        ) AS ADMINISTRATION_REMARKS,
                                        (
                                            SELECT
                                                TO_CHAR (ECD.APPROVE_DATE, 'DD-MM-YYYY')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 81
                                        ) AS ADMINISTRATION_APPROVAL_DATE,
                                        -- Administration
                                        -- Human_Resources
                                        (
                                            SELECT
                                                NVL(ECD.REMARKS,'-')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 141
                                        ) AS HUMAN_RESOURCES_REMARKS,
                                        (
                                            SELECT
                                                TO_CHAR (ECD.APPROVE_DATE, 'DD-MM-YYYY')
                                            FROM
                                                DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                            WHERE
                                                ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                                AND ECD.DEPARTMENT_ID = 141
                                        ) AS HUMAN_RESOURCES_APPROVAL_DATE,
                                        -- Human Resources
                                        (SELECT TO_CHAR (ECD.APPROVE_DATE, 'DD-MM-YYYY')
                                                FROM DEVELOPERS.EMP_CLEARENCE_DTLS ECD
                                                WHERE ECD.EMP_CLEARENCE_ID = CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID
                                            ORDER BY ECD.APPROVE_DATE DESC
                                        FETCH FIRST 1 ROW ONLY) AS LAST_APPROVAL_DATE
                                      
                                    FROM
                                        CTE_EMP_CLEARENCE
                                        JOIN DEVELOPERS.RML_HR_APPS_USER B ON CTE_EMP_CLEARENCE.RML_HR_APPS_USER_ID = B.ID
                                        LEFT JOIN DEVELOPERS.EMP_CLEARENCE_DTLS D ON CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID = D.EMP_CLEARENCE_ID
                                        LEFT JOIN DEVELOPERS.RML_HR_DEPARTMENT H ON D.DEPARTMENT_ID = H.ID
                                        --where CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID = 605
                                    
                                    GROUP BY
                                        CTE_EMP_CLEARENCE.EMP_CLEARENCE_ID,
                                        B.EMP_NAME,
                                        B.RML_ID,
                                        B.R_CONCERN,
                                        B.DEPT_NAME,
                                        B.DESIGNATION,
                                        CTE_EMP_CLEARENCE.APPROVAL_STATUS,
                                        CTE_EMP_CLEARENCE.CREATED_DATE";
                        $allDataSQL  = oci_parse(
                            $objConnect,
                            $quary
                        );

                        oci_execute($allDataSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($allDataSQL)) {
                            $number++;
                            // print_r($row);
                            $startDate = date('Y-m-d', strtotime($row['CREATED_DATE']));
                            $days = 0;
                            if ($row['APPROVAL_STATUS'] == '1') {
                                $endDate = date('Y-m-d', strtotime($row['LAST_APPROVAL_DATE']));
                                $diff   = (strtotime($endDate) - strtotime($startDate));
                                $days   = floor($diff / (60 * 60 * 24));
                            } else {
                                $endDate = date('Y-m-d');
                                $diff   = (strtotime($endDate) - strtotime($startDate));
                                $days   = floor($diff / (60 * 60 * 24));
                            }

                        ?>
                            <tr class="text-center">
                                <td>
                                    <strong><?php echo $number; ?></strong>
                                </td>
                                <td> <?= $row['RML_ID']; ?>
                                </td>
                                <td> <?= $row['EMP_NAME']; ?></td>
                                <td> <?= $row['DEPT_NAME']; ?></td>
                                <td> <?= $row['DESIGNATION']; ?></td>
                                <td > <?= date('d/m/Y', strtotime($row['CREATED_DATE'])) ?></td>

                                <td>
                                    <?php echo isset($row['ADMINISTRATION_APPROVAL_DATE']) ?
                                        date('d/m/Y', strtotime($row['ADMINISTRATION_APPROVAL_DATE'])) : "-"  ?>

                                </td>
                                <td>
                                    <?php echo isset($row['Administration_Remarks']) ?
                                        $row['Administration_Remarks'] : "-"  ?>
                                </td>
                                <td>
                                    <?php echo isset($row['FINANCE_ACCOUNTS_APPROVAL_DATE']) ?
                                        date('d/m/Y', strtotime($row['FINANCE_ACCOUNTS_APPROVAL_DATE']))
                                        : "-" ?>
                                </td>
                                <td>
                                    <?php echo isset($row['FINANCE_ACCOUNTS_REMARKS']) ? $row['FINANCE_ACCOUNTS_REMARKS'] : "-" ?>
                                </td>

                                <td>
                                    <?php echo isset($row['HUMAN_RESOURCES_APPROVAL_DATE']) ?
                                        date('d/m/Y', strtotime($row['HUMAN_RESOURCES_APPROVAL_DATE'])) : "-" ?>

                                </td>
                                <td>
                                    <?php echo isset($row['HUMAN_RESOURCES_REMARKS']) ?
                                        $row['HUMAN_RESOURCES_REMARKS'] : "-" ?>
                                </td>
                                <td>
                                    <?php echo isset($row['INTERNAL_AUDIT_APPROVAL_DATE']) ?
                                        date('d/m/Y', strtotime($row['INTERNAL_AUDIT_APPROVAL_DATE'])) : "-" ?>
                                </td>
                                <td>
                                    <?php echo isset($row['IT_ERP_REMARKS']) ? $row['IT_ERP_REMARKS'] : "-" ?>

                                </td>

                                <td>
                                    <?php echo isset($row['INTERNAL_AUDIT_APPROVAL_DATE']) ?
                                        date('d/m/Y', strtotime($row['INTERNAL_AUDIT_APPROVAL_DATE']))
                                        : "-" ?>
                                </td>
                                <td>
                                    <?php echo isset($row['INTERNAL_AUDIT_REMARKS']) ? $row['INTERNAL_AUDIT_REMARKS'] : "-" ?>
                                </td>
                                <td>
                                    <?php echo isset($row['LEGAL_APPROVAL_DATE']) ?
                                        date('d/m/Y', strtotime($row['LEGAL_APPROVAL_DATE']))
                                        : "-" ?>
                                </td>
                                <td>
                                    <?php echo isset($row['LEGAL_REMARKS']) ? $row['LEGAL_REMARKS'] : "-" ?>

                                </td>

                                <td><?= $days ?></td>
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