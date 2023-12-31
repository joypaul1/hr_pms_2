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
$data       = [];
$commentSQL = oci_parse($objConnect, "SELECT 
                                    ID, PIC_URL, NAME, 
                                    TYPE, COMMENTS, STATUS, 
                                    SORT_ORDER
                                    FROM CLIENT_COMMENTS WHERE ID =" . $_GET['id']);
oci_execute($commentSQL);

$data = oci_fetch_assoc($commentSQL);

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Customer Review Create';
                $rightSideName = 'Customer Review List';
                $routePath     = 'resale_module/view/form_panel/customer_review/index.php';
                include('../../../../layouts/_tableHeader.php');
                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="col-6">

                        <form method="post" action="<?php echo ($basePath . '/' . 'resale_module/action/form_panel.php'); ?>"
                            enctype="multipart/form-data">
                            <input type="hidden" name="actionType" value="edit">
                            <input type="hidden" name="editId" value="<?php echo $data['ID'] ?>">

                            <div class="mb-3">
                                <label class="form-label" for="name"> Name <span class="text-danger">*</span></label>
                                <input type="text" name="NAME" value="<?php echo $data['NAME'] ?>" class="form-control" id="name" required
                                    placeholder=" Name here..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="TYPE"> Comment Type <span class="text-danger">*</span></label>
                                <input type="text" name="TYPE" value="<?php echo $data['TYPE'] ?>" class="form-control" id="name" required
                                    placeholder="comment type..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="COMMENTS"> Review/Comment <span class="text-danger">*</span></label>
                                <textarea name="COMMENTS" class="editor" required>
                                <?php echo $data['COMMENTS'] ?> 
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                                <input type="file" name="image"  <?php echo !isset($data['PIC_URL']) ? 'required' : '' ?> data-default-file="<?php echo 'http://202.40.181.98:9090/' . $data['PIC_URL'] ?>" class="dropify" data-max-width="110" data-max-height="110" />
                                <small class="text-danger">[Image size will be max (100*100)px]</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="STATUS">Status <span class="text-danger">*</span></label>
                                <select name="STATUS" class="form-control" id="STATUS" required>
                                    <option value="1" <?php echo $data['STATUS'] == '1' ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo $data['STATUS'] == '0' ? 'selected' : ''; ?>>Deactive</option>
                                </select>
                            </div>

                            <div class="b-block text-right">
                                <input type="submit" value="Save" name="submit" class="btn btn-primary">
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
            'default': 'Select Customer  Image',
            'replace': 'Replace Customer Image',
            'remove': 'Remove',
            'error': 'Ooops, something wrong happended.'
        }
    });
    // Get all elements with the 'editor' class
    const editorElements = document.querySelectorAll('.editor');

    // Loop through each element and create a ClassicEditor instance
    editorElements.forEach(element => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error(error);
            });
    });
</script>