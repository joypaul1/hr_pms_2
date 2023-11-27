<?php
$dynamic_link_js[]  = 'https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/6/tinymce.min.js';
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');

$data       = [];
$product_id = trim($_GET["id"]);
// Check existence of id parameter before processing further
if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'edit') {

    $productSQL = oci_parse($objConnect, "SELECT 
                        ID, 
                        REF_CODE, 
                        ENG_NO, 
                        CHS_NO, 
                        REG_NO, 
                        BOOK_VALUE, 
                        DISPLAY_PRICE, 
                        GRADE, 
                        DEPO_LOCATION, 
                        BRAND_ID, 
                        CATEGORY, 
                        MODEL, 
                        INVOICE_STATUS, 
                        BOOKED_STATUS, 
                        PRODUCT_BID_ID, 
                        BODY_SIT, 
                        COLOR, 
                        FUEL_TYPE,
                        PIC_URL,
                        DESCRIPTION,
                        HISTORY,
                        PUBLISHED_STATUS
                        FROM PRODUCT
                        WHERE ID ='$product_id'");

    oci_execute($productSQL);
    $data = oci_fetch_array($productSQL);

}
else {
    $message                  = [
        'text'   => "Oops! Something went wrong. Please try again later.",
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/resale_module/view/self_panel/pendingList.php");
    exit();
}
print_r($data['PIC_URL']);
// die();
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Product Edit';
                $rightSideName = 'Pending List';
                $routePath     = '/resale_module/view/self_panel/pendingList.php';
                include('../../../layouts/_tableHeader.php');
                ?>

                <!-- End table  header -->
                <div class="card-body row">
                    <div class="col-8">
                 
                        <form method="post" action="<?php echo ($basePath . '/resale_module/action/self_panel.php?editID=' . trim($_GET["id"])); ?>"
                            enctype="multipart/form-data">
                            <input type="hidden" name="actionType" value="pro_edit">
                            <input type="hidden" name="editId" value="<?php echo $data['ID'] ?>">

                            <div class="mb-3">
                                <label class="form-label" for="DISPLAY_PRICE"> DISPLAY PRICE (MIN BID)</label>
                                <input type="number" name="DISPLAY_PRICE" class="form-control" value="<?php echo $data['DISPLAY_PRICE'] ?>" required
                                    id="DISPLAY_PRICE" placeholder="DISPLAY_PRICE Name..">

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="BODY_SIT"> BODY TYPE/SIT </label>
                                <input type="text" name="BODY_SIT" class="form-control" value="<?php echo $data['BODY_SIT'] ?>" required id="BODY_SIT"
                                    placeholder="BODY_SIT Name..">

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="COLOR"> COLOR</label>
                                <input type="text" name="COLOR" class="form-control" value="<?php echo $data['COLOR'] ?>" required id="COLOR"
                                    placeholder="COLOR Name..">

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="FUEL_TYPE"> FUEL TYPE</label>
                                <input type="text" name="FUEL_TYPE" class="form-control" value="<?php echo $data['FUEL_TYPE'] ?>" required
                                    id="FUEL_TYPE" placeholder="FUEL_TYPE Name..">

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="FUEL_TYPE"> THUMBNAIL IMAGE</label>
                                <input type="file" name="PIC_URL" <?php echo !isset($data['PIC_URL']) ? 'required' : '' ?>
                                    data-default-file="<?php echo 'http://202.40.181.98:9090/' . $data['PIC_URL'] ?>" class="dropify"
                                    data-max-file-size="3M" />

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="DESCRIPTION"> DESCRIPTION</label>
                                <textarea name="DESCRIPTION" class="editor">
                                <?php echo $data['DESCRIPTION']; ?>
                          
                                </textarea>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="HISTORY"> HISTORY</label>
                                <textarea name="HISTORY" class="editor">
                                <?php echo $data['HISTORY']; ?>

                                </textarea>

                            </div>
                            <div class="text-center shadow-sm p-3 mb-2 bg-body rounded fw-bold">Image Details Section</div>
                            <div class="d-flex flex-row gap-1 bd-highlight mb-3">
                                <?php
                                $product_image      = array();
                                $product_images_SQL = @oci_parse($objConnect, "SELECT 
                                                        ID, URL, PRODUCT_ID,PIC_ORDER
                                                        FROM PRODUCT_PICTURE
                                                        WHERE PRODUCT_ID='$product_id'");

                                if (@oci_execute($product_images_SQL)) {
                                    while ($row = oci_fetch_assoc($product_images_SQL)) {
                                        $product_image[] = array(
                                            "ID"         => $row['ID'],
                                            "URL"        => $row['URL'],
                                            "PRODUCT_ID" => $row['PRODUCT_ID'],
                                            "PIC_ORDER"  => $row['PIC_ORDER']
                                        );
                                    }
                                }
                                // print_r($product_image);
                                
                                // Check if $product_image has elements before accessing them
                                if (!empty($product_image)) {
                                    if (isset($product_image[0])) {
                                        echo '<input type="file" name="old_img_detials_1" data-default-file="http://202.40.181.98:9090/' . $product_image[0]['URL'] . '" class="dropify" data-max-file-size="3M" />';
                                    }
                                    else {
                                        echo '<input type="file" name="img_detials_1" required class="dropify" data-max-file-size="3M" />';
                                    }

                                    if (isset($product_image[1])) {
                                        echo '<input type="file" name="img_detials_2" data-default-file="http://202.40.181.98:9090/' . $product_image[1]['URL'] . '" class="dropify" data-max-file-size="3M" />';
                                    }
                                    else {
                                        echo '<input type="file" name="img_detials_2" required  class="dropify" data-max-file-size="3M" />';
                                    }

                                    if (isset($product_image[2])) {
                                        echo '<input type="file" name="img_detials_3" data-default-file="http://202.40.181.98:9090/' . $product_image[2]['URL'] . '" class="dropify" data-max-file-size="3M" />';
                                    }
                                    else {
                                        echo '<input type="file" name="img_detials_3" required class="dropify" data-max-file-size="3M" />';
                                    }

                                    if (isset($product_image[3])) {
                                        echo '<input type="file" name="img_detials_4" data-default-file="http://202.40.181.98:9090/' . $product_image[3]['URL'] . '" class="dropify" data-max-file-size="3M" />';
                                    }
                                    else {
                                        echo '<input type="file" name="img_detials_4" required class="dropify" data-max-file-size="3M" />';
                                    }
                                }
                                else {
                                    for ($i = 1; $i <= 4; $i++) {
                                        echo '<input type="file" required name="img_detials_' . $i . '" class="dropify" data-max-file-size="3M" />';
                                    }
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="HISTORY"> STATUS</label>

                                <select class="form-select" name="PUBLISHED_STATUS" aria-label="Default select example">
                                    <option <?php $data['PUBLISHED_STATUS'] == 'Y' ? 'Selected' : '' ?> value="Y">Published</option>
                                    <option <?php $data['PUBLISHED_STATUS'] == 'N' ? 'Selected' : '' ?> value="N">Unpublished</option>
                                </select>
                                <?php if (!empty($_SESSION['imageStatus'])) {
                                    echo '<p class="text-info"> ' . $_SESSION['imageStatus'] . '</p>';
                                    unset($_SESSION['imageStatus']);
                                }
                                ?>
                            </div>

                            <div class="b-block text-right">
                                <input type="submit" value="update" name="submit" class="btn btn-primary">
                            </div>
                        </form>

                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label class="form-label" for="MODEL"> Model</label>
                            <input type="text" name="MODEL" class="form-control" value="<?php echo $data['MODEL'] ?>" required id="name" disabled
                                placeholder="MODEL Name..">

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="REF_CODE"> REFERENCE CODE</label>
                            <input type="text" name="REF_CODE" class="form-control" value="<?php echo $data['REF_CODE'] ?>" required id="name"
                                disabled placeholder="REF_CODE Name..">

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ENG_NO"> ENGINE NO.</label>
                            <input type="text" name="ENG_NO" class="form-control" value="<?php echo $data['ENG_NO'] ?>" required id="name" disabled
                                placeholder="ENG_NO Name..">

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="CHS_NO"> CHASSIS NO.</label>
                            <input type="text" name="CHS_NO" class="form-control" value="<?php echo $data['CHS_NO'] ?>" required id="name" disabled
                                placeholder="CHS_NO Name..">

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="REG_NO"> REGISTATION NO.</label>
                            <input type="text" name="REG_NO" class="form-control" value="<?php echo $data['REG_NO'] ?>" required id="name" disabled
                                placeholder="REG_NO Name..">

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>

<?php require_once('../../../layouts/footer.php'); ?>
<script>
    $('.dropify').dropify({
        messages: {
            'default': 'Select Product Details Image',
            'replace': 'Replace Product Details Image',
            'remove': 'Remove',
            'error': 'Ooops, something wrong happended.'
        }
    });
    tinymce.init({
        selector: ".editor",
        plugins:
            "advcode advlist advtable anchor autocorrect autolink autosave casechange charmap checklist codesample directionality editimage emoticons export footnotes formatpainter help image insertdatetime link linkchecker lists media mediaembed mergetags nonbreaking pagebreak permanentpen powerpaste searchreplace table tableofcontents tinymcespellchecker typography visualblocks visualchars wordcount",
        toolbar:
            "undo redo spellcheckdialog  | blocks fontfamily fontsizeinput | bold italic underline forecolor backcolor | link image | align lineheight checklist bullist numlist | indent outdent | removeformat typography",
        height: "300px",

        //HTML custom font options
        font_size_formats:
            "8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 30pt 36pt 48pt 60pt 72pt 96pt",

        toolbar_sticky: true,
        autosave_restore_when_empty: true,
        spellchecker_active: true,
        spellchecker_language: "en_US",
        spellchecker_languages:
            "English (United States)=en_US,English (United Kingdom)=en_GB",
        typography_langs: ["en-US"],
        typography_default_lang: "en-US",


    });
</script>