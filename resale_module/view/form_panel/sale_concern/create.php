<?php
$dynamic_link_js[]  = 'https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js';
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css';
require_once('../../../../helper/4step_com_conn.php');
require_once('../../../../inc/connresaleoracle.php');

$basePath = $_SESSION['basePath'];

if (!checkPermission('resale-product-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Sale Concern Create';
                $rightSideName = 'Sale Concern List';
                $routePath     = 'resale_module/view/form_panel/sale_concern/index.php';
                include('../../../../layouts/_tableHeader.php');


                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="col-6">

                        <form method="post" action="<?php echo ($basePath . '/' . 'resale_module/action/form_panel.php'); ?>"
                            enctype="multipart/form-data">
                            <input type="hidden" name="actionType" value="createSaleConcern">

                            <div class="mb-3">
                                <label class="form-label" for="name"> Name <span class="text-danger">*</span></label>
                                <input type="text" name="TITLE_NAME" class="form-control" id="name" required placeholder="Name here..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="RML_ID"> RML ID <span class="text-danger">*</span></label>
                                <input type="text" name="RML_ID" class="form-control" id="RML_ID" required placeholder="RML ID here ..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="designation">Designation <span class="text-danger">*</span></label>
                                <input type="text" name="DESIGNATION" class="form-control" id="designation" required placeholder="designation Name..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mobile">Mobile Number <span class="text-danger">*</span></label>
                                <input type="number" name="MOBILE" class="form-control" id="mobile" required placeholder="mobile number..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mail">Mail Address </label>
                                <input type="email" name="MAIL" class="form-control" id="mail" placeholder="mail address..">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="PIC_URL"> Image</label>
                                <input type="file" name="PIC_URL" class="dropify" data-max-width="570" data-max-height="682" />
                                <small class="text-danger">[Image size will be max (570 × 682 )px]</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="WORK_STATION_ID">Work Station <span class="text-danger">*</span></label>
                                <select name="WORK_STATION_ID" class="form-control" id="WORK_STATION_ID" required>
                                    <option value="" hidden><- Select Work Station -></option>
                                    <?php
                                    $workStationSql = oci_parse($objConnect, "SELECT 
                                    ID, TITLE FROM  WORK_STATION WHERE STATUS= 'Y'");
                                    oci_execute($workStationSql);
                                    while ($stationData = oci_fetch_assoc($workStationSql)) {
                                        echo '<option value="' . $stationData["ID"] . '">' . $stationData['TITLE'] . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="STATUS">Status <span class="text-danger">*</span></label>
                                <select name="STATUS" class="form-control" id="STATUS" required>
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>

                            <div class="b-block text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../../../layouts/footer_info.php'); ?>
<?php require_once('../../../../layouts/footer.php'); ?>
<script>
    $('.dropify').dropify({
        messages: {
            'default': 'Select Image',
            'replace': 'Replace Image?',
            'remove': 'Remove',
            'error': 'Ooops, something wrong happended.'
        }
    }); 
</script>