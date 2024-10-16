<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];
if (!checkPermission('lm-offboarding-report')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}


?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12">
        <form action="" method="post">
            <div class="card-body row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                        <input required="" placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>'>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Bordered Table -->
    <div class="card mt-2">

        <?php
        $leftSideName  = 'Offboarding List';
        if (checkPermission('hr-offboarding-create')) {
            $rightSideName = 'Offboarding Create';
            $routePath     = 'offboarding_module/view/hr_panel/create.php';
        }
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
            <a class="btn btn-sm btn-primary text-white" onclick="exportF(this)" style="margin-left:5px;"> <i class="bx bx-download"></i> Export To Excel</a>
        </div>';
        // if ($_SESSION['HR_APPS']['user_concern'] != "RMWL") {
        $html .= '<div>
                <a target="_blank" href="approval_report.php" class="btn btn-sm btn-warning text-white" style="margin-left:5px;"> <i class="bx bxs-arrow-to-right"></i>View Approval Details </a>
            </div>';
        // }
        $html .= '<div>';
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
                            <th scope="col">Approval Status</th>
                            <th scope="col">Exit Interview Status</th>
                            <th scope="col">Created Info</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['emp_id'])) {

                            $v_emp_id = $_REQUEST['emp_id'];
                            $query = "SELECT A.ID,
                                    B.EMP_NAME,
                                    B.RML_ID,
                                    B.R_CONCERN,
                                    B.DEPT_NAME,
                                    B.DESIGNATION,
                                    A.APPROVAL_STATUS,
                                    A.EXIT_INTERVIEW_STATUS,
                                    A.EXIT_INTERVIEW_DATE,
                                    A.EXIT_INTERVIEW_BY,
                                    A.CREATED_DATE,
                                    A.CREATED_BY
                                    FROM EMP_CLEARENCE A
                                    JOIN
                                        RML_HR_APPS_USER B ON A.RML_HR_APPS_USER_ID = B.ID
                                    JOIN
                                        EMP_CLEARENCE_DTLS C ON A.ID = C.EMP_CLEARENCE_ID
                                    WHERE C.CONCERN_NAME IN (
                                        SELECT R_CONCERN from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
                                        (SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id'))
                                    AND C.DEPARTMENT_ID IN (
                                        SELECT RML_HR_DEPARTMENT_ID from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
                                        (SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id'))
                                    AND B.RML_ID='$v_emp_id'";
                            $strSQL  = oci_parse($objConnect, $query);
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php
                                        echo $row['RML_ID'];
                                        echo '</br>';
                                        echo $row['EMP_NAME'];
                                        echo '</br>';
                                        echo $row['DEPT_NAME'] . '=>' . $row['R_CONCERN'];
                                        echo '</br>';
                                        echo $row['DESIGNATION'];
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($row['APPROVAL_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['APPROVAL_STATUS'] == '0') {
                                            echo 'Denied';
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?>
                                        </br>
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#statusModal">
                                            See Status <i class="menu-icon tf-icons bx bx-right-arrow"></i>
                                        </button>

                                        <!--statusModal Modal -->
                                        <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel1"> APPROVAL STATUS VIEW FOR :
                                                            <span class="text-info"> <?php echo $row['RML_ID'] ?> </span>

                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row text-left">
                                                            <?php
                                                            $statusDataSQL = oci_parse($objConnect, "SELECT 
                                                                d.ID, d.EMP_CLEARENCE_ID, d.CONCERN_NAME, 
                                                                d.DEPARTMENT_ID, d.APPROVAL_STATUS, d.APPROVE_BY, 
                                                                d.APPROVE_DATE, h.DEPT_NAME
                                                            FROM EMP_CLEARENCE_DTLS d
                                                            JOIN RML_HR_DEPARTMENT h ON d.DEPARTMENT_ID = h.ID
                                                            WHERE  d.EMP_CLEARENCE_ID = {$row['ID']}
                                                            ");

                                                            oci_execute($statusDataSQL);

                                                            while ($statusRow = oci_fetch_array($statusDataSQL)) {

                                                                $checked = $statusRow['APPROVAL_STATUS'] == 1 ? 'checked' : '';

                                                                echo '<div class="form-check-inline col-5">
                                                                <input disabled type="checkbox" class="form-check-input" ' . $checked . '  id="check_1">
                                                                <label  style="opacity:1" class="form-check-label" for="check_1">' . $statusRow['DEPT_NAME'] . ' </label>
                                                            </div><div class=" col-5">
                                                            <input type="text" id="APPROVE_DATE" class="form-control cust-control"
                                                            value="' . $statusRow['APPROVE_DATE'] . '" disabled placeholder="APPROVE DATE">
                                                            </div>';
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--statusModal Modal -->
                                    </td>
                                    <td><?php
                                        if ($row['EXIT_INTERVIEW_STATUS'] == '1') {
                                            echo 'Approved';
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_DATE'];
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_BY'];
                                        } else if ($row['EXIT_INTERVIEW_STATUS'] == '0') {
                                            echo 'Denied';
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_DATE'];
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_BY'];
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        echo $row['CREATED_DATE'];
                                        echo '</br>';
                                        echo $row['CREATED_BY'];
                                        ?>
                                    </td>
                                </tr>


                            <?php
                            }
                        } else {
                            $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
                            $query = "SELECT A.ID,
                                        B.EMP_NAME,
                                        B.RML_ID,
                                        B.R_CONCERN,
                                        B.DEPT_NAME,
                                        B.DESIGNATION,
                                        A.APPROVAL_STATUS,
                                        A.EXIT_INTERVIEW_STATUS,
                                        A.EXIT_INTERVIEW_DATE,
                                        A.EXIT_INTERVIEW_BY,
                                        A.CREATED_DATE,
                                        A.CREATED_BY
                                FROM EMP_CLEARENCE A
                                JOIN
                                    RML_HR_APPS_USER B ON A.RML_HR_APPS_USER_ID = B.ID
                                JOIN
                                    EMP_CLEARENCE_DTLS C ON A.ID = C.EMP_CLEARENCE_ID
                                WHERE C.CONCERN_NAME IN (
                                    SELECT R_CONCERN from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
                                    (SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id'))
                                AND C.DEPARTMENT_ID IN (
                                    SELECT RML_HR_DEPARTMENT_ID from HR_DEPT_CLEARENCE_CONCERN WHERE RML_HR_APPS_USER_ID=
                                    (SELECT ID FROM RML_HR_APPS_USER WHERE RML_ID='$emp_session_id'))
                                AND ROWNUM <=10";
                            $allDataSQL  = oci_parse($objConnect, $query);

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                            ?>
                                <tr class="text-center">
                                    <td>
                                        <strong><?php
                                                echo $number
                                                ?></strong>
                                    </td>
                                    <td><?php
                                        echo $row['RML_ID'];
                                        echo '</br>';
                                        echo $row['EMP_NAME'];
                                        echo '</br>';
                                        echo $row['DEPT_NAME'] . '=>' . $row['R_CONCERN'];
                                        echo '</br>';
                                        echo $row['DESIGNATION'];

                                        ?>
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
                                        </br>
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="seeStatus(<?php echo $row['ID']  ?>)">
                                            See Status <i class="menu-icon tf-icons bx bx-right-arrow"></i>
                                        </button>

                                    </td>
                                    <td><?php
                                        if ($row['EXIT_INTERVIEW_STATUS'] == '1') {
                                            echo 'Approved';
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_DATE'];
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_BY'];
                                        } else if ($row['EXIT_INTERVIEW_STATUS'] == '0') {
                                            echo 'Denied';
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_DATE'];
                                            echo '</br>';
                                            echo $row['EXIT_INTERVIEW_BY'];
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?>


                                    </td>
                                    <td><?php
                                        echo $row['CREATED_DATE'];
                                        echo '</br>';
                                        echo $row['CREATED_BY'];
                                        ?>
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
    <!--/ Bordered Table -->

    <!--statusModal Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"> APPROVAL STATUS VIEW :


                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row text-left ">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!--statusModal Modal -->

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
        var fileName = "Offboarding Information(" + formattedDate + ").xls";

        var url = 'data:application/vnd.ms-excel,' + escape(html);

        // Set the href and download attributes
        elem.setAttribute("href", url);
        elem.setAttribute("download", fileName);

        return false;
    }
</script>

<script>
    function seeStatus(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "<?php echo $basePath . "/offboarding_module/action/hr_panel.php"; ?>",
            data: {
                rml_emp_id: id,
                'actionType': 'approvalStatus'
            },
            success: function(data) {
                $('#statusModal').modal('show');
                $('.modal-body').empty('');
                $('.modal-body').append(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>