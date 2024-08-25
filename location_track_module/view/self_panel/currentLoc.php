<?php
$dynamic_link_css[] = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js[] = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('loyalty-card-all-module')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card  col-lg-12 ">

        <?php
        $leftSideName = 'User Current Location Tracking';
        include('../../../layouts/_tableHeader.php');
        ?>

        <div class="card-body">
            <form action="<?php echo ($basePath . '/location_track_module/action/self_panel.php'); ?>" method="post"
                target="_blank">
                <input type='hidden' hidden name='actionType' value='getCurentLocation'>
                <div class="row justify-content-center">
                    <div class="col-8">
                        <label>Search User By RML ID : <span class="text-danger"> *</span></label>
                        <input required class="form-control cust-control" id="autocomplete" type="text"
                            placeholder="EX : EMPLOYEE RML ID / RMWL ID">
                        <input type="hidden" name="RML_ID" id="RML_ID" value="">
                        <div class="text-info" id="message"></div>
                    </div>
                </div>
                <div class="mt-2 w-25 mx-auto">
                    <button class="form-control btn btn-sm btn-primary" type="submit">Submit to View</button>
                </div>
            </form>

        </div>

    </div>



</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
    $(function () {
        $("#autocomplete").autocomplete({
            source: function (request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo ($basePath . '/location_track_module/action/dropdown.php'); ?>",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        actionType: 'searchUser',
                        search: request.term
                    },
                    beforeSend: function () {
                        $("#userInfo").empty();
                        showPleaseWaitMessage();

                    },
                    success: function (data) {
                        hidePleaseWaitMessage();
                        // Process the response data here
                        response($.map(data, function (item) {
                            return {
                                label: item.label,
                                value: item.value,
                                searchData: item.searchData,
                                // empData: item
                            };
                        }));
                    },
                    error: function (data) {
                        hidePleaseWaitMessage();
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                $('#autocomplete').val(ui.item.label); // display the selected text
                $('#RML_ID').val(ui.item.value); // display the selected text
                // userInfo(ui.item.empData.data);
                buttonValidation();
                return false;
            },
            focus: function (event, ui) {
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

        $(document).on('change', '#autocomplete', function () {
            // buttonValidation();
        });

        $(document).on('input', '#star_date', function () {
            // buttonValidation();
        });

        function buttonValidation() {
            console.log($("#start_date").val());
            if ($("input[name='RML_ID']").val() && $("#start_date").val()) {
                $("button[type='submit']").prop('disabled', false);
            } else {
                $("button[type='submit']").prop('disabled', true);
            }
        }

    });
</script>