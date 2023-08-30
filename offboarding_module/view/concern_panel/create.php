<?php
$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('concern-offboarding-create')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card  col-lg-12 ">

        <?php
        $leftSideName  = 'Offboarding Create';
        if (checkPermission('concern-offboarding-report')) {
            $rightSideName = 'Offboarding Report';
            $routePath     = 'offboarding_module/view/concern_panel/index.php';
        }

        include('../../../layouts/_tableHeader.php');
        ?>

        <div class="card-body">
            <form action="<?php echo ($basePath . '/offboarding_module/action/concern_panel.php'); ?>" method="post">
                <input type='hidden' hidden name='actionType' value='createClearence'>
                <div class="row ">
                    <div class="col-sm-4">
                        <label for="emp_id">Emp. ID:</label>
                        <input required class="form-control cust-control" id="autocomplete" name="emp_rml_id" type="text" />
                        <div class="text-info" id="message"></div>
                        <input required class="form-control " id="emp_id" name="emp_id" type="hidden" hidden />
                        <input required class="form-control " id="concern_name" name="concern_name" type="hidden" hidden />

                    </div>
                    <div class="col-sm-8">
                        <span class="w-100" id="userInfo"></span>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <label for="last_working_day">Last Working Day <span class="text-danger"> *</span></label>
                        <input class="form-control" id="last_working_day" name="last_working_day" required type="date" />
                    </div>
                    <div class="col-sm-6">
                        <label for="resignation_date">Resignation Date <span class="text-danger"> *</span></label>
                        <input class="form-control" id="resignation_date" name="resignation_date" required type="date" />
                    </div>
                    <div class="col-sm-12">
                        <label for="reason_of_resignation">Reason OF Resignation <span class="text-danger"> *</span> </label>
                        <input class="form-control" id="reason_of_resignation" name="reason_of_resignation" autocomplete="off" type="text" required />
                    </div>
                </div>
                <div class="row  showDepartment" style="display:none;border: 1px solid #eee5e5; margin-top: 2%;">
                    <h5 class="text-center mt-2"> Select Department <span style="font-size: 12px;"> </h5>

                    <hr />

                    <?php
                    $departmentArray = [];
                    $strSQL  = oci_parse($objConnect, "SELECT ID, DEPT_NAME FROM RML_HR_DEPARTMENT where IS_ACTIVE=1 AND OFFBOARDING_STATUS=1");
                    oci_execute($strSQL);
                    while ($row = oci_fetch_assoc($strSQL)) {
                        echo ('
                            <div class="form-check-inline col-4">
                                <input type="checkbox" class="form-check-input department_id"  value="' . $row['ID'] . '" name="department_id[]"' . (isset($_POST['department_id']) && $_POST['department_id'] == $row['ID'] ? "checked" : "") . '
                                id="check_' . $row['ID'] . '">
                                <label class="form-check-label" for="check_' . $row['ID'] . '">' . $row['DEPT_NAME'] . '</label>
                            </div>
                            ');
                    }

                    ?>

                </div>
                <div class="mt-2 w-25 mx-auto">
                    <button class="form-control btn btn-sm btn-primary" type="submit" disabled>Submit to Create</button>
                </div>

            </form>
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
                    url: "<?php echo ($basePath . '/offboarding_module/action/concern_panel.php'); ?>",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        actionType: 'searchUser',
                        search: request.term
                    },
                    beforeSend: function() {
                        $("#userInfo").empty();
                        $("#emp_id").val(null);
                        showDepartment();
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
                                concern: item.concern,
                                empData: item
                            };
                        }));
                    },
                    error: function(data) {
                        // console.log(data)
                        hidePleaseWaitMessage();
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#autocomplete').val(ui.item.label); // display the selected text
                $('#emp_id').val(ui.item.id); // save selected id to input
                $('#concern_name').val(ui.item.concern); // save selected id to input
                userInfo(ui.item.empData.data);
                showDepartment();
                buttonValidation();
                return false;
            },
            focus: function(event, ui) {
                // $("#autocomplete").val(ui.item.label);
                // $("#emp_id").val(ui.item.id);
                // $("#concern_name").val(ui.item.concern);
                // buttonValidation();
                // showDepartment();
                return false;
            },
        });

        // Function to display the "Please wait" message
        function showDepartment() {
            if ($('#emp_id').val()) {
                $('.showDepartment').css('display', 'block');
            } else {
                $('.showDepartment').css('display', 'none')

            }

        }

        // Function to display the "Please wait" message
        function showPleaseWaitMessage() {
            $('#message').text('Please wait for searching...');
        }

        // Function to hide the "Please wait" message
        function hidePleaseWaitMessage() {
            $('#message').empty();
        }

        function userInfo(info) {

            let basePath = "<?php echo $basePath =  $_SESSION['basePath'] ?>";
            let html = `<div class="justify-content-center">
                    <div class="card p-3">
                        <div class="d-flex  text-center">
                            <div class="w-100">
                              
                                <div class="p-2  bg-primary d-flex justify-content-between rounded text-white stats">
                                    <div class="d-flex flex-column">
                                        <span class="articles">Name </span>
                                        <span class="number1">${info.EMP_NAME}</span>

                                    </div>
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
                                    <div class="d-flex flex-column">
                                        <span class="rating">Designation</span>
                                        <span class="number3">${info.DESIGNATION}</span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="rating">View Profile</span>
                                        <span class="number3">
                                        <a target="_blank" href="${basePath}/user_profile.php?emp_id=${info.RML_ID}"><button class="btn btn-sm btn-info ml-2" type='button'>Go To Profile </button></a> 
                                        </span>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>`;

            $("#userInfo").append(html);
        }


        $(document).on('change', '#autocomplete', function() {
            showDepartment();
            buttonValidation();
        });

        $(document).on('change', '#last_working_day', function() {

            buttonValidation();
        });
        $(document).on('change', '#resignation_date', function() {

            buttonValidation();
        });
        $(document).on('input', '#reason_of_resignation', function() {

            buttonValidation();
        });

        function buttonValidation() {

            if ($("#emp_id").val() && $("#last_working_day").val() && $("#resignation_date").val() && $("#reason_of_resignation").val()) {
                $("button[type='submit']").prop('disabled', false);

            } else {
                $("button[type='submit']").prop('disabled', true);
            }
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
    });
</script>