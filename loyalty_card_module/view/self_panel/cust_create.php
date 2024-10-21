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
        $leftSideName = 'Loyalty Card Create';
        $rightSideName = 'Loyalty Card List';
        $routePath = 'loyalty_card_module/view/self_panel/list.php';
        include('../../../layouts/_tableHeader.php');
        ?>

        <div class="card-body">
            <form action="<?php echo ($basePath . '/loyalty_card_module/action/self_panel.php'); ?>" method="post">
                <input type='hidden' hidden name='actionType' value='createCard'>
                <div class="row justify-content-center">
                    
                    <div class="col-4">
                        <label for="card_type">VEHICLE SOURCE TYPE <span class="text-danger"> *</span> </label>
                        <select class="form-control" name="VEHICLE_SOURCE_TYPE" id="card_type" required>
                            <option value="<?php NULL ?>"><- select source type -></option>
                            <?php
                            $strSQL = oci_parse($objConnect, "SELECT  ID, TITLE, STATUS
                            FROM LOYALTY.CARD_TYPE");
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {
                                ?>
                                <option value="<?= $row['ID'] ?>"><?= $row['TITLE'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="cust_id">Customer Name : </label>
                        <input required class="form-control" name="CUSTOMER_NAME" type="text"
                            placeholder="customer name here..">
                    </div>
                    <div class="col-4">
                        <label for="cust_id">Customer Mobile : </label>
                        <input required name='CUSTOMER_ADDRESS' class="form-control" type="text"
                            placeholder="customer mobile number..">
                    </div>
                    <div class="col-12">
                        <label for="cust_id">Customer Address : </label>
                        <input required name="CUSTOMER_ADDRESS" class="form-control" type="text"
                            placeholder="customer mobile number..">
                    </div>
                    <div class="col-3">
                        <label for="start_date">Card Valid Start Date <span class="text-danger"> *</span></label>
                        <input class="form-control" id="start_date" name="start_date" required type="date">
                    </div>
                    <div class="col-3">
                        <label for="end_date">Card Valid End Date <span class="text-danger"> *</span></label>
                        <input class="form-control" id="end_date" name="end_date" required type="date">
                    </div>
                    <div class="col-4">
                        <label for="card_type">Type of Card <span class="text-danger"> *</span> </label>
                        <select class="form-control" name="card_type" id="card_type" required>
                            <option value="<?php NULL ?>"><- select card type -></option>
                            <?php
                            $strSQL = oci_parse($objConnect, "SELECT  ID, TITLE, STATUS
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