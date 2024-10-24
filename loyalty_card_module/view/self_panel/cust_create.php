<?php
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css';
$dynamic_link_js[] = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js';
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
        $leftSideName = 'Custom Loyalty Card Create';
        $rightSideName = 'Loyalty Card List';
        $routePath = 'loyalty_card_module/view/self_panel/list.php';
        include('../../../layouts/_tableHeader.php');
        ?>

        <div class="card-body">
            <form action="<?php echo ($basePath . '/loyalty_card_module/action/self_panel.php'); ?>" method="post">
                <input type='hidden' hidden name='actionType' value='createCard'>
                <div class="row justify-content-center">
                <div class="col-4">
                        <label for="cust_id">Customer Name : <span class="text-danger"> * </span></label>
                        <input required class="form-control" name="CUSTOMER_NAME" type="text"
                            placeholder="Customer name here..">
                    </div>
                    <div class="col-4">
                        <label for="cust_id">Customer Mobile NO. : <span class="text-danger"> * </span></label>
                        <input required name='CUSTOMER_MOBILE_NO' class="form-control" type="text"
                            placeholder="Customer mobile number..">
                    </div>
                    <div class="col-4">
                        <label for="CUSTOMER_MAIL">Customer Mail Address : </label>
                        <input  name='CUSTOMER_MAIL' class="form-control" type="text"
                            placeholder="Customer mail address..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="ENG_NO"> Engine Number : <span class="text-danger"> * </span></label>
                        <input required class="form-control" name="ENG_NO" type="text"
                            placeholder="Engine Number here..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="CHASSIS_NO"> Chassis Number : <span class="text-danger"> * </span></label>
                        <input required class="form-control" name="CHASSIS_NO" type="text"
                            placeholder="Chassis Number here..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="REG_NO"> Registration Number : <span class="text-danger"> * </span></label>
                        <input required class="form-control" name="REG_NO" type="text"
                            placeholder="Registration Number here..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="REF_CODE"> Reference Code / Invoice Number :</label>
                        <input  class="form-control" name="REF_CODE" type="text"
                            placeholder="Reference Code here..">
                    </div>

                    <div class="col-4 mt-1">
                        <label for="DRIVER_NAME"> Driver Name :</label>
                        <input required class="form-control" name="DRIVER_NAME" type="text"
                            placeholder="Reference Code here..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="DRIVER_MOBILE"> Driver Mobile NO. :</label>
                        <input required class="form-control" name="DRIVER_MOBILE" type="text"
                            placeholder="Reference Code here..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="PARTY_ADDRESS">Customer Address : <span class="text-danger"> * </span></label>
                        <input required name="PARTY_ADDRESS" class="form-control" type="text"
                            placeholder="Customer address here..">
                    </div>
                    <div class="col-4 mt-1">
                        <label for="customer_nid">Customer NID No. : </label>
                        <input  name="customer_nid" class="form-control" type="text"
                            placeholder="Customer nid here..">
                    </div>
                    <div class="col-4">
                        <label for="VEHICLE_TYPE">Vehicle Type :<span class="text-danger"> *</span> </label>
                        <select class="form-control" name="VEHICLE_TYPE" id="VEHICLE_TYPE" required>
                            <option value="<?php NULL ?>"><- select  type -></option>
                            <?php
                            $strSQL = @oci_parse($objConnect, "SELECT  ID, NAME FROM LOYALTY.VEHICLE_TYPE ORDER BY ID");
                            @oci_execute($strSQL);
                            while ($row = @oci_fetch_assoc($strSQL)) {
                                ?>
                                <option value="<?= $row['ID'] ?>"><?= $row['NAME'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="card_type">Vehicle/Customer Source From :<span class="text-danger"> *</span> </label>
                        <select class="form-control" name="VEHICLE_SOURCE_TYPE" id="card_type" required>
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
                </div>
                <div class="mt-2 w-25 mx-auto">
                    <button class="form-control btn btn-sm btn-primary" type="submit" disabled>Submit to Create
                        Card</button>
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

        // $('.datepicker').datepicker({
        //     format: 'dd/mm/yyyy',
        // });


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