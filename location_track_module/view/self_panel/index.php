<?php
$dynamic_link_css[] = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js[] = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
// if (!checkPermission('geo-location')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }

?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card  col-lg-12 ">

        <?php
        $leftSideName = 'User Location Tracking';
        include('../../../layouts/_tableHeader.php');
        ?>

        <div class="card-body">
            <form action="<?php echo ($basePath . '/location_track_module/action/self_panel.php'); ?>" method="post"
                target="_blank">
                <input type='hidden' hidden name='actionType' value='createCard'>
                <div class="row justify-content-center">
                    <div class="col-3">
                        <label for="start_date">Select Date :<span class="text-danger"> *</span></label>
                        <input class="form-control" id="start_date" name="start_date" required type="date">
                    </div>
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
                        response($.map(data, function (item) {
                            return {
                                label: item.label,
                                value: item.value,
                                searchData: item.searchData,
                            };
                        }));
                    },
                    error: function () {
                        hidePleaseWaitMessage();
                        $('#message').text('Error occurred while searching. Please try again.');
                    }
                });
            },
            select: function (event, ui) {
                $('#autocomplete').val(ui.item.label);
                $('#RML_ID').val(ui.item.value);
                buttonValidation();
                return false;
            },
            focus: function (event, ui) {
                return false;
            },
        });

        // Initial button state
        $("button[type='submit']").prop('disabled', true);

        // Function to display the "Please wait" message
        function showPleaseWaitMessage() {
            $('#message').text('Please wait for searching...');
        }

        // Function to hide the "Please wait" message
        function hidePleaseWaitMessage() {
            $('#message').empty();
        }

        // Validate button on input changes
        $('#start_date, #autocomplete').on('change input', function () {
            buttonValidation();
        });

        function buttonValidation() {
            if ($('#RML_ID').val() && $('#start_date').val()) {
                $("button[type='submit']").prop('disabled', false);
            } else {
                $("button[type='submit']").prop('disabled', true);
            }
        }
    });

</script>