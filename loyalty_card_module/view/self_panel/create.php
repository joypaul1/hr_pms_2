<?php
$dynamic_link_css[] = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js[] = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('loyalty-card-all-module	')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card  col-lg-12 ">

        <?php
        $leftSideName  = 'Loyalty Card Create';
        $rightSideName = 'Loyalty Card List';
        $routePath     = 'loyalty_card_module/view/self_panel/index.php';
        include('../../../layouts/_tableHeader.php');
        ?>

        <div class="card-body">
            <form action="<?php echo ($basePath . '/loyalty_card_module/action/self_panel.php'); ?>" method="post">
                <input type='hidden' hidden name='actionType' value='createCard'>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <label for="cust_id">Customer Reference Code : </label>
                        <input required class="form-control cust-control" id="autocomplete"  type="text">
                        <input type="hidden" name="cust_id" id="cust_id" value="">
                        <div class="text-info" id="message"></div>
                    </div>
                    <div class="col-12">
                        <span class="w-100" id="userInfo"></span>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <label for="start_date">Card Valid Start Date <span class="text-danger"> *</span></label>
                        <input class="form-control" id="start_date" name="start_date" required type="date">
                    </div>
                    <div class="col-sm-6">
                        <label for="end_date">Card Valid End Date <span class="text-danger"> *</span></label>
                        <input class="form-control" id="end_date" name="end_date" required type="date">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label for="card_type">Type of Card <span class="text-danger"> *</span> </label>
                        <select class="form-control" name="card_type" id="card_type" required>
                            <option value="<?php NULL ?>"><- select card type -></option>
                            <?php
                            $strSQL  = oci_parse($objConnect, "SELECT  ID, TITLE, STATUS
                            FROM LOYALTY.CARD_TYPE");
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {
                            ?>
                                <option value="<?= $row['ID'] ?>"><?= $row['TITLE'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
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
                    url: "<?php echo ($basePath . '/loyalty_card_module/action/dropdown.php'); ?>",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        actionType: 'searchUser',
                        search: request.term
                    },
                    beforeSend: function() {
                        $("#userInfo").empty();
                        showPleaseWaitMessage();

                    },
                    success: function(data) {
                        hidePleaseWaitMessage();
                        // Process the response data here
                        response($.map(data, function(item) {
                            return {
                                label: item.label,
                                value: item.value,
                                empData: item
                            };
                        }));
                    },
                    error: function(data) {
                        hidePleaseWaitMessage();
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#autocomplete').val(ui.item.label); // display the selected text
                userInfo(ui.item.empData.data);
                buttonValidation();
                return false;
            },
            focus: function(event, ui) {
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

            let basePath = "<?php echo $basePath =  $_SESSION['basePath'] ?>";
            let html = `<div class="justify-content-center">
                    <div class="card p-3">
                    <div class="card-title text-center text-white bg-warning p-2"> Customer / Party Information </div>
                        <div class="d-flex text-center">
                            <div class="bg-primary w-100">
                                <div class="p-2 d-flex justify-content-between rounded text-white stats">
                                    <div class="d-flex flex-column">
                                        <u class="articles">Name </u>
                                        <span class="number1">${info.CUSTOMER_NAME}</span>
                                        <input name="CUSTOMER_NAME" required="" value="${info.CUSTOMER_NAME}" type="hidden">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <u class="articles">REF. CODE.</u>
                                        <span class="number1">${info.REF_CODE}</span>
                                        <input name="REF_CODE" required="" value="${info.REF_CODE}" type="hidden">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <u class="followers">MOBILE</u>
                                        <span class="">${info.CUSTOMER_MOBILE_NO}</span>
                                        <input name="CUSTOMER_MOBILE_NO" required="" value="${info.CUSTOMER_MOBILE_NO}" type="hidden">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <u class="rating">REG. NO.</u>
                                        <span class="number3">${info.REG_NO}</span>
                                        <input name="REG_NO" required="" value="${info.REG_NO}" type="hidden">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <u class="rating">ENG. NO.</u>
                                        <span class="number3">${info.ENG_NO}</span>
                                        <input name="ENG_NO" required="" value="${info.ENG_NO}" type="hidden">

                                    </div>
                                    <div class="d-flex flex-column">
                                        <u class="rating">CHA. NO.</u>
                                        <span class="number3">${info.CHASSIS_NO}</span>
                                        <input name="CHASSIS_NO" required="" value="${info.CHASSIS_NO}" type="hidden">

                                    </div>
                                </div>
                                <div class="d-flex flex-column text-white">
                                    <u class="rating">Address</u>
                                    <span class="number3">${info.PARTY_ADDRESS}</span>
                                    <input name="PARTY_ADDRESS" required="" value="${info.PARTY_ADDRESS}" type="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

            $("#userInfo").append(html);
        }


        $(document).on('change', '#autocomplete', function() {
            buttonValidation();
        });

        $(document).on('change', '#star_date', function() {
            buttonValidation();
        });
        $(document).on('change', '#end_date', function() {
            buttonValidation();
        });
        $(document).on('input', '#card_type', function() {
            buttonValidation();
        });

        function buttonValidation() {
            if ($("input[name='CUSTOMER_NAME']").val() && $("#start_date").val() && $("#end_date").val() && $("input[name='REF_CODE']").val() && $("#card_type").val()) {
                $("button[type='submit']").prop('disabled', false);

            } else {
                $("button[type='submit']").prop('disabled', true);
            }
        }

    });
</script>