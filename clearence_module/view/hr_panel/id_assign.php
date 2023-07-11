<?php
$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
if (!checkPermission('hr-clearence-id-assign')) {

    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body col-lg-12 ">
        <div class='card-title'>
            <div href="#" style="font-size: 18px;font-weight:700">
                <i class="menu-icon tf-icons bx bx-message-alt-add" style="margin:0;font-size:20px"></i>Clearence Create
            </div>
        </div>
        <form action="<?php echo ($basePath . '/clearence_module/action/hr_panel.php'); ?>" method="post">
            <input type='hidden' hidden name='actionType' value='idAssign'>
            <div class="row">
                <div class="col-sm-4">
                    <label for="emp_id">Emp. ID:</label>
                    <input required class="form-control cust-control" id="autocomplete" name="" type="text" />
                    <div class="text-info" id="message"></div>
                    <input required class="form-control" id="emp_id" name="emp_id" type="hidden" hidden />

                </div>
                <div class="col-sm-6">
                    <span class="d-block text-center text-info mb-2">
                        <i class="menu-icon tf-icons bx bx-user" style="margin:0;font-size:20px"></i> Search Employee Information :
                    </span>
                    <span class="w-100" id="userInfo"></span>

                </div>
                <!-- <div class="col-sm-12">
                    <label for="exampleInputEmail1">Remarks? </label>
                    <input required class="form-control" id="" name="emp_id" type="text" />
                </div> -->
            </div>
            <div class="row mt-2">
                <div class="col-sm-6">
                    <section style="border: 1px solid #eee5e5;
                        padding: 2%;">


                        <h5 class="text-center"> Select Concern <span style="font-size: 12px;"> </h5>
                        <hr />
                        <?php
                        $departmentArray = [];
                        $strSQL  = oci_parse($objConnect, "SELECT UNIQUE(R_CONCERN) AS R_CONCERN FROM RML_HR_APPS_USER ORDER BY R_CONCERN");
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                            echo ('
                            <div class="form-check-inline col-12">
                                <input type="checkbox" class="form-check-input concern_id"  value="' . $row['R_CONCERN'] . '" name="concern_id[]"' . (isset($_POST['concern_id']) && $_POST['concern_id'] == $row['R_CONCERN'] ? "checked" : "") . '
                                id="check_' . $row['R_CONCERN'] . '">
                                <label class="form-check-label" for="check_' . $row['R_CONCERN'] . '">' . $row['R_CONCERN'] . '</label>
                            </div>
                            ');
                        }

                        ?>
                    </section>


                </div>
                <div class="col-sm-6">
                    <section style="border: 1px solid #eee5e5;
                        padding: 2%;">

                        <h5 class="text-center"> Select Department <span style="font-size: 12px;"> </h5>
                        <hr />
                        <?php
                        $departmentArray = [];
                        $strSQL  = oci_parse($objConnect, "SELECT ID, DEPT_NAME FROM DEVELOPERS.RML_HR_DEPARTMENT where IS_ACTIVE=1");
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                            echo ('
                            <div class="form-check-inline col-12">
                                <input type="checkbox" class="form-check-input department_id"  value="' . $row['ID'] . '" name="department_id[]"' . (isset($_POST['department_id']) && $_POST['department_id'] == $row['ID'] ? "checked" : "") . '
                                id="check_' . $row['ID'] . '">
                                <label class="form-check-label" for="check_' . $row['ID'] . '">' . $row['DEPT_NAME'] . '</label>
                            </div>
                            ');
                        }

                        ?>

                    </section>

                </div>
                <div class="mt-2 w-25 mx-auto">
                    <button class="form-control btn btn-sm btn-primary" type="submit" disabled>Submit to Create
                    </button>
                </div>

            </div>



        </form>
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