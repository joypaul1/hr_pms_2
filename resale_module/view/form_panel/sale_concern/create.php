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

                        <form method="post" action="<?php echo ($basePath . '/' . 'action/role_permission/role.php'); ?>">
                            <input type="hidden" name="actionType" value="create">

                            <div class="mb-3">
                                <label class="form-label" for="name"> Name <span class="text-danger">*</span></label>
                                <input type="text" name="TITLE_NAME" class="form-control" id="name" required placeholder="Shop Name..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="designation">Designation <span class="text-danger">*</span></label>
                                <input type="text" name="DESIGNATION" class="form-control" id="designation" required placeholder="designation Name..">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mobile">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="MOBILE" class="form-control" id="mobile" required placeholder="mobile number..">
                            </div>
                           
                            <div class="mb-3">
                                <label class="form-label" for="PIC_URL"> Image</label>
                                <input type="file" name="PIC_URL" class="dropify" data-min-width="570" data-min-height="682" />
                                <small class="text-danger">[Image size will be max (570 × 682 )px]</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="STATUS">Status <span class="text-danger">*</span></label>
                               <select name="STATUS" class="form-control" id="STATUS" required>
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
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