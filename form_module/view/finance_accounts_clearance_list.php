<?php

$dynamic_link_css[] = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js[] = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('accounts-clearance-form')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
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
        $leftSideName  = 'Pending List';
        // if (checkPermission('hr-offboarding-create')) {
        //     $rightSideName = 'Offboarding Create';
        //     $routePath     = 'offboarding_module/view/hr_panel/create.php';
        // }
        include('../../layouts/_tableHeader.php');
        ?>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">EMP Info</th>
                            <th scope="col">HOD Status</th>
                            <th scope="col">Accounts Clearnence Form</th>
                            <th scope="col">Created Info</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['emp_id'])) {

                            $v_emp_id = $_REQUEST['emp_id'];
                            $query = "SELECT
                                        A.ID,
                                        B.EMP_NAME,
                                        B.RML_ID,
                                        B.R_CONCERN,
                                        B.DEPT_NAME,
                                        B.DESIGNATION,
                                        A.APPROVAL_STATUS,
                                        A.HOD_STATUS,
                                        A.EXIT_INTERVIEW_STATUS,
                                        A.EXIT_INTERVIEW_DATE,
                                        A.EXIT_INTERVIEW_BY,
                                        A.CREATED_DATE,
                                        A.CREATED_BY,
                                        A.LAST_WORKING_DATE,
                                        A.RESIGNATION_DATE,
                                        A.REASON,
                                        A.RML_HR_APPS_USER_ID
                                    FROM
                                        EMP_CLEARENCE A
                                    JOIN
                                        RML_HR_APPS_USER B ON A.RML_HR_APPS_USER_ID = B.ID
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
                                <tr style="text-align: center;">
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
                                    <td>
                                        <?php
                                        if ($row['APPROVAL_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['APPROVAL_STATUS'] == '0') {
                                            echo 'Denied';
                                        } else {
                                            echo 'Pending';
                                        }
                                        ?>

                                    </td>
                                    <?php

                                    ?>

                                    <td>
                                        <?php
                                        $singledataOFAccClear = oci_parse($objConnect, "SELECT * FROM  ACCOUNTS_CLEARENCE_FORMS  WHERE EMP_CLEARENCE_ID =" . $row['ID'] . " FETCH FIRST 1 ROWS ONLY");
                                        oci_execute($singledataOFAccClear);
                                        $clearenceFormFata = oci_fetch_assoc($singledataOFAccClear);


                                        if ($clearenceFormFata) {
                                            echo '<a href="' . $basePath . '/document/accounts_form.php?accountclearenceId=' . $row['ID'] . '" target="_blank">
                                            <button type="button" class="btn btn-sm btn-outline-info">
                                                Account Clearence Form Print  <i class="menu-icon tf-icons bx bx-right-arrow"></i>
                                            </button>
                                        </a>';
                                        } else {
                                            echo "Pending";
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        echo 'Created:' . $row['CREATED_DATE'];
                                        echo '</br>';
                                        echo 'Created By' . $row['CREATED_BY'];
                                        ?>
                                    </td>
                                </tr>


                            <?php
                            }
                        } else {
                            
                            $query = "SELECT 
                            A.ID,
                            B.EMP_NAME,
                            B.RML_ID,
                            B.R_CONCERN,
                            B.DEPT_NAME,
                            B.DESIGNATION,
                            A.APPROVAL_STATUS,
                            A.HOD_STATUS,
                            A.EXIT_INTERVIEW_STATUS,
                            A.EXIT_INTERVIEW_DATE,
                            A.EXIT_INTERVIEW_BY,
                            A.CREATED_DATE,
                            A.CREATED_BY,
                            A.LAST_WORKING_DATE,
                            A.RESIGNATION_DATE,
                            A.REASON,
                            A.RML_HR_APPS_USER_ID
                        FROM
                            EMP_CLEARENCE A
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
                            ";
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                $query
                            );


                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;

                            ?>
                                <tr class="text-left">
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
                                        if ($row['HOD_STATUS'] == '1') {
                                            echo 'Approved';
                                        } else if ($row['HOD_STATUS'] == '0') {
                                            echo 'Denied';
                                        } else if ($row['HOD_STATUS'] == '') {
                                            echo 'Pending';
                                        }
                                        ?>
                                    </td>
                                    <?php

                                    ?>

                                    <?php

                                    ?>

                                    <td>
                                        <?php
                                        $singledataOFAccClear = oci_parse($objConnect, "SELECT * FROM ACCOUNTS_CLEARENCE_FORMS WHERE EMP_CLEARENCE_ID =" . $row['ID'] . " FETCH FIRST 1 ROWS ONLY");
                                        oci_execute($singledataOFAccClear);
                                        $clearenceFormFata = oci_fetch_assoc($singledataOFAccClear);


                                        if ($clearenceFormFata) {
                                            echo '<a href="' . $basePath . '/document/accounts_form.php?accountclearenceId=' . $row['ID'] . '" target="_blank">
                                            <button type="button" class="btn btn-sm btn-outline-info">
                                                Account Clearence Form Print  <i class="menu-icon tf-icons bx bx-right-arrow"></i>
                                            </button>
                                        </a>';
                                        } else {
                                            echo "Pending" . '</br>';
                                            echo '<a href="' . $basePath . '/form_module/view/finance_accounts_clearance.php?rml_hr_apps_user_id=' . $row['RML_HR_APPS_USER_ID'] . '" target="_blank">
                                                <button type="button" class="btn btn-sm btn-outline-info">
                                                    Create Form   <i class="menu-icon tf-icons bx bx-right-arrow"></i>
                                                </button>
                                            </a>';
                                        }
                                        ?>
                                    </td>

                                    <td><?php
                                        echo 'Created: ' . $row['CREATED_DATE'];
                                        echo '</br>';
                                        echo 'Created By: ' . $row['CREATED_BY'];
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

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>

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