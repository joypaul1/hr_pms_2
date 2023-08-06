<?php

$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('accounts-clearance-form')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card col-lg-12">
        <form action="" method="post">
            <div class="card-body row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">Sell invoice ID</label>
                        <input required="" placeholder="Sell invoice  ID" name="invoice_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['invoice_id']) ? $_POST['invoice_id'] : ''; ?>' />
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-info" type="submit" value="Search Data">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bordered Table -->
    <div class="card mt-2">

        <div class="card-body row">
            <div class="col-8">
                <div style="
                        border: 1px solid #eee5e5;
                        padding: 2%;
                        box-shadow: 1px 1px 1px 1px lightgray;
                        margin: 2%;
                    ">
                    <h5 class="text-center"> <i class="menu-icon tf-icons bx bx-right-arrow m-0 text-info"></i>Invoice Number : 0000009789 </h5>
                    <p class="text-center"> <i class=" m-0 text-info"></i><u>Car Reference List</u> </p>
                    <div class="form-check-inline col-5">
                        <input type="checkbox" class="form-check-input" value="1" name="reference_id[]" id="check_1">
                        <label class="form-check-label" for="check_1">Ref-0009</label>
                    </div>
                    <div class="form-check-inline col-5">
                        <input type="checkbox" class="form-check-input" value="2" name="reference_id[]" id="check_2">
                        <label class="form-check-label" for="check_2">Ref-00019</label>
                    </div>
                    <div class="form-check-inline col-5">
                        <input type="checkbox" class="form-check-input" value="2" name="reference_id[]" id="check_2">
                        <label class="form-check-label" for="check_2">Ref-0109</label>
                    </div>
                    <div class="form-check-inline col-5">
                        <input type="checkbox" class="form-check-input" value="2" name="reference_id[]" id="check_2">
                        <label class="form-check-label" for="check_2">Ref-1009</label>
                    </div>

                </div>
            </div>
            <div class="col-4">
                <div style="
                        border: 1px solid #eee5e5;
                        padding: 2%;
                        box-shadow: 1px 1px 1px 1px lightgray;
                        margin: 2%;
                    ">
                     <div class="form-inline col-12">
                         <label class="d-block form-label text-center " for="cheque_number"><b>cheque Number</b></label>
                        <input type="text" class="form-control" placeholder="cheque Number" name="cheque_number" id="cheque_number">
                    </div>
                     <div class="form-inline col-12">
                       
                     <!-- <label class="d-block form-label text-center "for="submit">&nbsp;label> -->

                     <!-- <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data"> -->
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-center">
            <div class="col-3">
            <button type="submit" class="form-control btn btn-sm btn-primary">Submit </button>
            </div>
            </div>
        </div>
    </div>
    <!--/ Bordered Table -->



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