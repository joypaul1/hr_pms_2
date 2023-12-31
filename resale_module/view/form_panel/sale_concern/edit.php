<?php
$dynamic_link_js[]  = 'https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js';
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css';
require_once('../../../../helper/4step_com_conn.php');
require_once('../../../../inc/connresaleoracle.php');



if (!checkPermission('resale-product-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$data       = [];
$concernSQL = oci_parse($objConnect, "SELECT 
ID, RML_ID, TITLE_NAME,DESIGNATION, MOBILE, WORK_STATION_ID,MAIL, STATUS, PIC_URL,
(SELECT TITLE FROM WORK_STATION WHERE ID = A.WORK_STATION_ID) AS WORK_STATION
FROM RESALE_TEAM A WHERE A.ID =" . $_GET['id']);

oci_execute($concernSQL);
$data     = oci_fetch_assoc($concernSQL);
$baseUrl  = $_SESSION['baseUrl'];
$basePath = $_SESSION['basePath'];
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

                // echo $baseUrl;
                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="col-6">

                        <form method="post" action="<?php echo ($basePath . '/' . 'resale_module/action/form_panel.php'); ?>"
                            enctype="multipart/form-data">
                            <input type="hidden" name="actionType" value="editSaleConcern">
                            <input type="hidden" name="editId" value="<?php echo $data['ID'] ?>">

                            <div class="mb-3">
                                <label class="form-label" for="name"> Name <span class="text-danger">*</span></label>
                                <input type="text" name="TITLE_NAME" value="<?php echo $data['TITLE_NAME'] ?>" class="form-control" id="name" required
                                    placeholder="Name here..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="RML_ID"> RML ID <span class="text-danger">*</span></label>
                                <input type="text" value="<?php echo $data['RML_ID'] ?>" name="RML_ID" class="form-control" id="RML_ID" required
                                    placeholder="RML ID here ..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="designation">Designation <span class="text-danger">*</span></label>
                                <input type="text" value="<?php echo $data['DESIGNATION'] ?>" name="DESIGNATION" class="form-control" id="designation"
                                    required placeholder="designation Name..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mobile">Mobile Number <span class="text-danger">*</span></label>
                                <input type="number" value="<?php echo $data['MOBILE'] ?>" name="MOBILE" class="form-control" id="mobile" required
                                    placeholder="mobile number..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mail">Mail Address </label>
                                <input type="email" value="<?php echo $data['MAIL'] ?>" name="MAIL" class="form-control" id="mail"
                                    placeholder="mail address..">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="PIC_URL"> Image</label>
                                <input type="file" name="PIC_URL" <?php echo !isset($data['PIC_URL']) ? ' ' : '' ?>
                                    data-default-file="<?php echo $baseUrl . '/' . $data['PIC_URL'] ?>" class="dropify" data-max-width="250"
                                    data-max-height="300" />
                                <small class="text-danger">[Image size will be max (246 × 294 )px]</small>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="WORK_STATION_ID">Work Station <span class="text-danger">*</span></label>
                                <select name="WORK_STATION_ID" class="form-control" id="WORK_STATION_ID" required>
                                    <option value="" hidden><- Select Work Station -></option>
                                    <?php
                                    $workStationSql = oci_parse($objConnect, "SELECT ID, TITLE FROM WORK_STATION WHERE STATUS= 'Y'");
                                    oci_execute($workStationSql);
                                    while ($stationData = oci_fetch_assoc($workStationSql)) {
                                        $isSelected = $data['WORK_STATION_ID'] == $stationData["ID"] ? "selected" : "";
                                        echo '<option value="' . $stationData["ID"] . '" ' . $isSelected . '>
                                            ' . $stationData['TITLE'] . '
                                        </option>';
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="STATUS">Status <span class="text-danger">*</span></label>
                                <select name="STATUS" class="form-control" id="STATUS" required>
                                    <option value="1" <?php echo $data['STATUS'] == '1' ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo $data['STATUS'] == '0' ? 'selected' : ''; ?>>Deactive</option>
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