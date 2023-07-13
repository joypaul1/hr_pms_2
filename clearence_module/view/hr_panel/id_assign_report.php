<?php
$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
if (!checkPermission('hr-clearence-id-assign-report')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12 ">
        <?php
        $leftSideName  = 'ID Assign Report';
        if (checkPermission('hr-clearence-id-assign-create')) {
            $rightSideName = 'ID Assign Create';
            $routePath     = 'clearence_module/view/hr_panel/id_assign.php';
        }

        include('../../../layouts/_tableHeader.php');
        ?>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
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

                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT A.ID,
									   B.EMP_NAME,
									   B.RML_ID,
									   B.R_CONCERN,
									   B.DEPT_NAME,
									   B.DESIGNATION,
									   RML_HR_APPS_USER_ID,
									   APPROVAL_STATUS,
									   EXIT_INTERVIEW_STATUS,
									   EXIT_INTERVIEW_DATE,
									   EXIT_INTERVIEW_BY,
									   CREATED_DATE,
									   CREATED_BY
								  FROM EMP_CLEARENCE A,RML_HR_APPS_USER B
								  WHERE A.RML_HR_APPS_USER_ID=B.ID
								  AND B.RML_ID='$v_emp_id'"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
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


                            $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT B.EMP_NAME,
									   B.DEPT_NAME,
									   B.DESIGNATION,
									   B.R_CONCERN EMP_CONCERN,
									   A.R_CONCERN RESPONSIBLE_CONCERN,
									   (SELECT DEPT_NAME FROM RML_HR_DEPARTMENT WHERE ID=A.RML_HR_DEPARTMENT_ID) RESPONSIBLE_DEPT
								FROM HR_DEPT_CLEARENCE_CONCERN A,RML_HR_APPS_USER B
								WHERE A.RML_HR_APPS_USER_ID=B.ID"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                            ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
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
</div>



</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
    $(function() {

        $("#autocomplete").autocomplete({

            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo ($basePath . '/clearence_module/action/hr_panel.php'); ?>",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        actionType: 'searchUser',
                        search: request.term
                    },
                    beforeSend: function() {
                        $("#userInfo").empty();
                        $("#emp_id").val(null);
                        showPleaseWaitMessage();
                    },
                    success: function(data) {
                        hidePleaseWaitMessage();
                        // Process the response data here
                        response($.map(data, function(item) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,
                                empData: item
                            };
                        }));
                    },
                    error: function(data) {
                        console.log(data)
                        hidePleaseWaitMessage();
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#autocomplete').val(ui.item.label); // display the selected text
                $('#emp_id').val(ui.item.id); // save selected id to input
                userInfo(ui.item.empData.data);
                buttonValidation();
                return false;
            },
            focus: function(event, ui) {
                $("#autocomplete").val(ui.item.label);
                $("#emp_id").val(ui.item.id);
                return false;
            },
        });

        // Function to display the "Please wait" message
        function showPleaseWaitMessage() {
            $('#message').text('Please wait for searching...');
        }

        // Function to hide the "Please wait" message
        function hidePleaseWaitMessage() {
            $('#message').empty();
        }

        function userInfo(info) {

            let basePath = "/rHRT";
            let html = `<div class="justify-content-center">
                            <div class="card p-3">
                                <div class="d-flex  text-center">
                                    <div class="w-100">
                                        <h4 class="mb-0 mt-0">${info.EMP_NAME}</h4>
                                        <span>${info.DESIGNATION}</span>
                                        <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                                            <div class="d-flex flex-column">
                                                <span class="articles">ID</span>
                                                <span class="number1">${info.RML_ID}</span>

                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="followers">Concern</span>
                                                <span class="number2">${info.R_CONCERN}</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="rating">Department</span>
                                                <span class="number3">${info.DEPT_NAME}</span>
                                            </div>
                                        </div>
                                        <div class="mt-2 d-flex flex-row justify-content-center">
                                            <a target="_blank" href="${basePath}/user_profile.php?emp_id=${info.RML_ID}"><button class="btn btn-sm btn-info ml-2" type='button'>Go To Profile </button></a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

            $("#userInfo").append(html);
        }
    });

    $(document).on('change', '#autocomplete', function() {
        buttonValidation();
    });
    $(document).on('click', '.concern_id', function() {
        buttonValidation();
    });
    $(document).on('click', '.department_id', function() {
        buttonValidation();
    });

    function buttonValidation() {

        if ($("#emp_id").val() && concernCheck() && derpartmentCheck()) {
            $("button[type='submit']").prop('disabled', false);

        } else {
            $("button[type='submit']").prop('disabled', true);
        }
    }


    function concernCheck() {
        let flag = false;
        $('.concern_id').each(function() {
            var isChecked = $(this).prop('checked');
            if (isChecked) {
                flag = true;

            }
        });
        return flag;
    }

    function derpartmentCheck() {
        let flag = false;
        $('.department_id').each(function() {
            var isChecked = $(this).prop('checked');
            if (isChecked) {
                flag = true;

            }
        });
        return flag;
    }
</script>