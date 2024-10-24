<?php
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css';
$dynamic_link_js[] = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js';
// $dynamic_link_css[] = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.min.css';
// $dynamic_link_js[] = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.min.js';
$dynamic_link_css[] = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css';
$dynamic_link_js[] = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('loyalty-card-all-module')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-12 ">
        <?php
        $leftSideName = 'Customer Profile Create';
        $rightSideName = 'Loyalty Card List';
        $routePath = 'loyalty_card_module/view/self_panel/list.php';
        include('../../../layouts/_tableHeader.php');
        ?>

        <form action="<?php echo ($basePath . '/loyalty_card_module/action/self_panel.php'); ?>" method="post">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="card-title-text"><u> Customer/ Company Information : </u> </h5>
                </div>
                <input type='hidden' hidden name='actionType' value='createCard'>
                <div class="row justify-content-centers">
                    <div class="col-4">
                        <label for="cust_id">Full Name : <span class="text-danger"> * </span></label>
                        <input required class="form-control cust-control" name="CUSTOMER_NAME" type="text"
                            placeholder="Customer name here..">
                    </div>
                    <div class="col-4">
                        <label for="cust_id">Phone Number : <span class="text-danger"> * </span></label>
                        <input required name='CUSTOMER_MOBILE_NO' max="11" class="form-control cust-control"
                            type="number" placeholder="Customer mobile number..">
                    </div>
                    <div class="col-4">
                        <label for="CUSTOMER_EMAIL">Email Address : </label>
                        <input name='CUSTOMER_EMAIL' class="form-control cust-control" type="text"
                            placeholder="Customer mail address..">
                    </div>
                    <div class="col-8 mt-1">
                        <label for="PARTY_ADDRESS">Customer Address : <span class="text-danger"> * </span></label>
                        <input required name="PARTY_ADDRESS" class="form-control cust-control" type="text"
                            placeholder="Customer address here..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="CUSTOMER_DOB">Customer’s Birthday : </label>
                        <input name='CUSTOMER_DOB' class="form-control cust-control datepicker" type="text"
                            placeholder="Customer Birthday here..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="EMERGENCY_C_N">Emergency C/N : </label>
                        <input name='EMERGENCY_C_N' class="form-control cust-control" type="number" max="11"
                            placeholder="Emergency Contact Number..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="CUSTOMER_DISTRICT">Customer District :<span class="text-danger"> *</span> </label>
                        <select class="form-control cust-control select2" name="CUSTOMER_DISTRICT"
                            id="CUSTOMER_DISTRICT" required>
                            <option value="<?php NULL ?>"><- select type -></option>
                            <?php
                            $strSQL = @oci_parse($objConnect, "SELECT  ID, NAME FROM WSHOP.DISTRICT ORDER BY NAME");
                            @oci_execute($strSQL);
                            while ($row = @oci_fetch_assoc($strSQL)) {
                                ?>
                                <option value="<?= $row['ID'] ?>"><?= $row['NAME'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-4 mt-1">
                        <label for="CUSTOMER_NID"> NID Number : </label>
                        <input name="CUSTOMER_NID" id="CUSTOMER_NID" class="form-control cust-control" type="number"
                            placeholder="Customer nid here..">
                    </div>
                    <!-- <div class="col-4 mt-1">
                        <label for="CUSTOMER_NID"> Point Of Contact Person : </label>
                        <input name="CUSTOMER_NID" id="CUSTOMER_NID" class="form-control cust-control" type="text"
                            placeholder="Point Of Contact Person here..">
                    </div> -->
                    <div class="col-4 mt-1">
                        <label for="POC_CONTACT">Point Of Contact Person phone number : </label>
                        <input name="POC_CONTACT" id="POC_CONTACT" class="form-control cust-control" type="number"
                            placeholder="POC phone number here..">
                    </div>
                </div>
                <div class="vehicle_info_add">
                    <div class="card mt-2">
                        <div class="card-header d-flex align-items-center justify-content-between"
                            style="padding: 1.0% 1rem">
                            <div href="#" style="font-size: 16px;font-weight:700">
                                <i class="menu-icon tf-icons bx bxs-car-wash" style="margin:0;font-size:30px"></i>
                                Vehicle Information
                            </div>
                            <div>
                                <a href="http://localhost/rHRT/loyalty_card_module/view/self_panel/list.php"
                                    class="btn btn-sm btn-success add_more">
                                    <i class="menu-icon tf-icons bx bx-message-alt-add" style="margin:0;"></i> Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <label for="VEHICLE_TYPE">Vehicle Type :<span class="text-danger"> *</span> </label>
                                <select class="form-control cust-control select2" name="VEHICLE_TYPE" id="VEHICLE_TYPE"
                                    required>
                                    <option value="<?php NULL ?>"><- select type -></option>
                                    <?php
                                    $strSQL = @oci_parse($objConnect, "SELECT  ID, NAME FROM LOYALTY.VEHICLE_TYPE ORDER BY ID");
                                    @oci_execute($strSQL);
                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        ?>
                                        <option value="<?= $row['ID'] ?>"><?= $row['NAME'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-4 ">
                                <label for="ENG_NO"> Model : <span class="text-danger"> * </span></label>
                                <input required class="form-control cust-control" name="ENG_NO" type="text"
                                    placeholder="Engine Number here..">
                            </div>
                            <div class="col-4">
                                <label for="REG_NO"> Registration Number : <span class="text-danger"> * </span></label>
                                <input required class="form-control cust-control" name="REG_NO" type="text"
                                    placeholder="Registration Number here..">
                            </div>
                            <div class="col-4  mt-1">
                                <label for="CHAS_NO"> VIN / Chassis NO. : <span class="text-danger"> * </span></label>
                                <input required class="form-control cust-control" name="CHAS_NO" type="text"
                                    placeholder="VIN Number here..">
                            </div>
                            <div class="col-4  mt-1">
                                <label for="ENG_NO"> Engine Number : <span class="text-danger"> * </span></label>
                                <input required class="form-control cust-control" name="ENG_NO" type="text"
                                    placeholder="Engine Number here..">
                            </div>
                            <div class="col-4 mt-1">
                                <label for="DRIVER_NAME"> Driver / Transport Name :</label>
                                <input required class="form-control cust-control" name="DRIVER_NAME" type="text"
                                    placeholder="Driver / Transport name here..">
                            </div>
                            <div class="col-4 mt-1">
                                <label for="DRIVER_MOBILE"> Driver / Transport Contat Number:</label>
                                <input required class="form-control cust-control" name="DRIVER_MOBILE" type="number"
                                    placeholder="Driver mobile number here..">
                            </div>
                            <div class="col-4 mt-1">
                                <label for="VEHICLE_SOURCE_TYPE"> Brand Company :<span class="text-danger">*
                                    </span>
                                </label>
                                <select class="form-control cust-control select2" name="VEHICLE_SOURCE_TYPE"
                                    id="VEHICLE_SOURCE_TYPE" required>
                                    <option value="<?php NULL ?>"><- select source from -></option>
                                    <?php
                                    $strSQL = @oci_parse($objConnect, "SELECT  ID, NAME FROM LOYALTY.VEHICLE_SOURCE ORDER BY NAME");
                                    @oci_execute($strSQL);
                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        ?>
                                        <option value="<?= $row['ID'] ?>"><?= $row['NAME'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-4 mt-1">
                                <label for="DISTRIBUTOR_NAME"> Distributor Name :</label>
                                <input class="form-control cust-control" name="DISTRIBUTOR_NAME" type="text"
                                    placeholder="Distributor Name here..">
                            </div>
                            <div class="col-4 mt-1">
                                <label for="SERVICE_DAY"> Preferred Service Day/Time :</label>
                                <input class="form-control cust-control" name="SERVICE_DAY" type="text"
                                    placeholder="Preferred Service Day/Time here..">
                            </div>
                            <div class="col-4 mt-1">
                                <label for="SERVICE_NOTE"> Special Requests/Notes :</label>
                                <input class="form-control cust-control" name="SERVICE_NOTE" type="text"
                                    placeholder="Special Requests/Notes  here..">
                            </div>
                            <div class="col-4 mt-1">
                                <label for="BANNER_NAME"> Banner Name :</label>
                                <input class="form-control cust-control" name="BANNER_NAME" type="text"
                                    placeholder="Banner Name here..">
                            </div>ss
                        </div>
                    </div>
                </div>
                <div class="mx-auto w-25 mt-5">
                    <button class="form-control cust-control btn btn-sm btn-primary" type="submit" disabled>Submit to
                        Create
                        Card</button>
                </div>
        </form>

    </div>



</div>

<!-- / Content -->
<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
    $(document).ready(function () {
        // Add more sections when Add button is clicked
        $('.add_more').on('click', function (e) {
            e.preventDefault();  // Prevent default action

            // Clone the first vehicle_info_add div
            var clone = $('.vehicle_info_add').first().clone();

            // Clear input values in the cloned div
            clone.find('input').val('');
            clone.find('select').prop('selectedIndex', 0);  // Reset selects to default

            // Add the remove button to the cloned div
            clone.find('.card-header div:last-child').append(`
            <button type="button" class="btn btn-sm btn-danger remove_section">
                <i class="menu-icon tf-icons bx bx-trash" style="margin:0;"></i> Remove
            </button>
        `);

            // Append the cloned div after the last vehicle_info_add
            $('.vehicle_info_add').last().after(clone);
        });

        // Use event delegation to handle dynamic remove buttons
        $(document).on('click', '.remove_section', function (e) {
            e.preventDefault();  // Prevent default action

            // Only remove the section if there is more than one vehicle_info_add
            if ($('.vehicle_info_add').length > 1) {
                $(this).closest('.vehicle_info_add').remove();  // Remove the parent vehicle_info_add block
            } else {
                alert('At least one vehicle information section is required.');
            }
        });
    });

    $(function () {
        $('.select2').each(function () {
            $(this).select2();

        });
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
        });


        $(document).on('change', '#autocomplete', function () {
            buttonValidation();
        });

        $(document).on('change', '#star_date', function () {
            buttonValidation();
        });
        $(document).on('change', '#end_date', function () {
            buttonValidation();
        });
        $(document).on('input', '#card_type', function () {
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