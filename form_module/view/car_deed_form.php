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
            <input type="hidden" name="actionType" value="searchData" >
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
                    <h5 class="text-center"> <i class="menu-icon tf-icons bx bx-right-arrow m-0 text-info"></i>Invoice Number :
                     <?php echo isset($_POST["invoice_id"]) ? trim($_POST["invoice_id"]) : ' ' ?> </h5>
                    <p class="text-center"> <i class=" m-0 text-info"></i><u>Car Reference List</u> </p>

                    <?php 
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"])  == 'searchData') { 
                        $invoice_id = trim($_POST["invoice_id"]);

                        $deedSQL = oci_parse($objConnect, "SELECT REF_CODE FROM LEASE_ALL_INFO_ERP WHERE DOCNUMBR = :invoice_id");
                        oci_bind_by_name($deedSQL, ":invoice_id", $invoice_id);
                        oci_execute($deedSQL);
                        
                        if ($row = oci_fetch_assoc($deedSQL)) {
                            do {
                                echo '<div class="form-check-inline col-5">
                                        <input type="checkbox" class="form-check-input" value="'.$row['REF_CODE'].'" name="reference_id[]" id="'.$row['REF_CODE'].'">
                                        <label class="form-check-label" for="'.$row['REF_CODE'].'">'.$row['REF_CODE'].'</label>
                                    </div>';
                            } while ($row = oci_fetch_assoc($deedSQL));
                        } else {
                            echo '<strong class="text-danger">Sorry! No data found. </strong>';
                        }
                        
                    }
                    ?>
                 
                       

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