<?php
$dynamic_link_js[]  = 'https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js';
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
                        CASH_PRICE, 
                        CREDIT_PRICE,
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
                        AUCTTION_START_DATE,
                        AUCTION_END_DATE,
                        PUBLISHED_STATUS,
                        REG_PAPER
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
                $leftSideName  = 'Product Edit';
                $rightSideName = 'Pending List';
                $routePath     = '/resale_module/view/self_panel/pendingList.php';
                include('../../../layouts/_tableHeader.php');
                ?>
                <div class="card-body row ">

                    <div class="col-4">
                        <label class="form-label" for="MODEL"> Model</label>
                        <input type="text" name="MODEL" class="form-control" value="<?php echo $data['MODEL'] ?>" required id="MODEL" disabled
                            placeholder="MODEL Name..">

                    </div>
                    <div class="col-4">
                        <label class="form-label" for="REF_CODE"> REFERENCE CODE</label>
                        <input type="text" name="REF_CODE" class="form-control" value="<?php echo $data['REF_CODE'] ?>" required id="REF_CODE"
                            disabled placeholder="REF_CODE Name..">

                    </div>
                    <div class="col-4">
                        <label class="form-label" for="ENG_NO"> ENGINE NO.</label>
                        <input type="text" name="ENG_NO" class="form-control" value="<?php echo $data['ENG_NO'] ?>" required id="ENG_NO" disabled
                            placeholder="ENG_NO Name..">

                    </div>
                    <div class="col-4">
                        <label class="form-label" for="CHS_NO"> CHASSIS NO.</label>
                        <input type="text" name="CHS_NO" class="form-control" value="<?php echo $data['CHS_NO'] ?>" required id="CHS_NO" disabled
                            placeholder="CHS_NO Name..">

                    </div>
                    <div class="col-4">
                        <label class="form-label" for="REG_NO"> REGISTATION NO.</label>
                        <input type="text" name="REG_NO" class="form-control" value="<?php echo $data['REG_NO'] ?>" required id="name" disabled
                            placeholder="REG_NO Name..">

                    </div>
                    <div class="col-4">
                        <label class="form-label" for="REG_NO"> DEPO LOCATION</label>
                        <input type="text" name="REG_NO" class="form-control" value="<?php echo $data['DEPO_LOCATION'] ?>" required id="name" disabled
                            placeholder="REG_NO Name..">

                    </div>
                    <div class="col-4">
                        <label class="form-label" for="REG_NO"> Booked Value</label>
                        <input type="text" name="BOOK_VALUE" class="form-control" value="<?php echo number_format($data['BOOK_VALUE'], 2) ?>" required
                            id="BOOK_VALUE" disabled placeholder="booked value ..">

                    </div>
                </div>
                <style>
                    .cust-design {
                        padding: 12px 20px;
                        cursor: pointer;
                        border-width: 1px;
                        border-radius: 0 40px 0 40px;
                        font-size: 14px;
                        font-weight: 500;
                        -webkit-box-shadow: 0px 10px 20px -6px rgba(0, 0, 0, 0.12);
                        -moz-box-shadow: 0px 10px 20px -6px rgba(0, 0, 0, 0.12);
                        box-shadow: 0px 10px 20px -6px rgba(0, 0, 0, 0.12);
                    }


                    .btn-group button:not(:disabled),
                    [type="button"]:not(:disabled),
                    [type="reset"]:not(:disabled),
                    [type="submit"]:not(:disabled) {
                        cursor: pointer;
                    }
                </style>
                <!-- End table  header -->
                <div class="card-body d-flex justify-content-center">
                    <div class="col-10">
                        <div class="btn-group mb-5  d-flex justify-content-center text-center">
                            <button id="step_1" type="button" class="btn btn-success" style="border-radius: 0 40px 0 40px;">Basic Info Section
                            </button>
                            <button id="step_2" type="button" class="btn btn-primary" style="border-radius: 0 40px 0 40px;">Image Section</button>
                            <button id="step_3" type="button" class="btn btn-primary" style="border-radius: 40px 0px 40px 0px;">Description
                                Section</button>
                            <button id="step_4" type="button" class="btn btn-primary" style="border-radius: 40px 0px 40px 0px;">Status
                                Section</button>
                        </div>
                        <div class="step_1">
                            <form method="post"
                                action="<?php echo ($basePath . '/resale_module/action/self_panel.php?editID=' . trim($_GET["id"])); ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="actionType" value="pro_edit_1">
                                <input type="hidden" name="editId" value="<?php echo $data['ID'] ?>">

                                <div class="mb-3">
                                    <label class="form-label" for="CASH_PRICE"> CASH PRICE (MIN BID) <small class='text-danger'>*</small></label>
                                    <input type="number" name="CASH_PRICE" class="form-control" value="<?php echo $data['CASH_PRICE'] ?>" required
                                        id="CASH_PRICE" placeholder="CASH PRICE (EX:10,000,00.00)">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="CREDIT_PRICE">CREDIT PRICE (MIN BID) <small class='text-danger'>*</small></label>
                                    <input type="number" name="CREDIT_PRICE" class="form-control" value="<?php echo $data['CREDIT_PRICE'] ?>" required
                                        id="CREDIT_PRICE" placeholder="CREDIT PRICE (EX:10,000,00.00)">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="REG_PAPER"> REGISTATION PAPER UPDATE? <small class='text-danger'>*</small></label>
                                    <select name="REG_PAPER" class="form-control" id="" required>
                                        <option value=" " hidden><- Select Status -></option>
                                        <option value="Yes" <?php echo $data['REG_PAPER'] == 'Yes' ? 'Selected' : '' ?>>Yes</option>
                                        <option value="No" <?php echo $data['REG_PAPER'] == 'No' ? 'Selected' : '' ?>>No</option>
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="BODY_SIT"> BODY TYPE/SIT <small class='text-danger'>*</small></label>
                                    <input type="text" name="BODY_SIT" class="form-control" value="<?php echo $data['BODY_SIT'] ?>" required
                                        id="BODY_SIT" placeholder="BODY/SIT ..">

                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="COLOR"> COLOR <small class='text-danger'>*</small></label>
                                    <input type="text" name="COLOR" class="form-control" value="<?php echo $data['COLOR'] ?>" required id="COLOR"
                                        placeholder="COLOR Name..">

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="FUEL_TYPE"> FUEL TYPE <small class='text-danger'>*</small></label>
                                    <input type="text" name="FUEL_TYPE" class="form-control" value="<?php echo $data['FUEL_TYPE'] ?>" required
                                        id="FUEL_TYPE" placeholder="FUEL TYPE Name..">

                                </div>

                                <div class="b-block text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="step_2 d-none">
                            <form method="post"
                                action="<?php echo ($basePath . '/resale_module/action/self_panel.php?editID=' . trim($_GET["id"])); ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="actionType" value="pro_edit_2">
                                <input type="hidden" name="editId" value="<?php echo $data['ID'] ?>">


                                <div class="mb-3">
                                    <label class="form-label" for="FUEL_TYPE">
                                        <strong>THUMBNAIL IMAGE
                                            <small class="text-danger">[Max File Size (645 × 387)px ]</small></strong>
                                    </label>
                                    <input type="file" name="PIC_URL" <?php echo !isset($data['PIC_URL']) ? 'required' : '' ?>
                                        data-default-file="<?php echo $baseUrl . '/' . $data['PIC_URL'] ?>" class="dropify" data-max-width="645"
                                        data-max-height="387" />

                                </div>

                                <div class="text-center shadow-sm p-3 mb-2 bg-body rounded fw-bold">Image Details Section <span
                                        class="text-danger">(4image mandatory) <small>[Max File Size (645 × 387)px ]</small></span></div>
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
                                        echo '<input type="hidden" name="new_image_or_old_image" value="0"/>';

                                        if (isset($product_image[0])) {
                                            echo '<input type="file" name="old_img_detials[' . $product_image[0]['ID'] . ']" data-default-file="' . $baseUrl . '/' . $product_image[0]['URL'] . '" class="dropify" data-max-width="645" data-max-height ="387" />';
                                        }

                                        if (isset($product_image[1])) {
                                            echo '<input type="file" name="old_img_detials[' . $product_image[1]['ID'] . ']" data-default-file="' . $baseUrl . '/' . $product_image[1]['URL'] . '" class="dropify" data-max-width="645" data-max-height ="387" />';
                                        }


                                        if (isset($product_image[2])) {
                                            echo '<input type="file" name="old_img_detials[' . $product_image[2]['ID'] . ']" data-default-file="' . $baseUrl . '/' . $product_image[2]['URL'] . '" class="dropify" data-max-width="645" data-max-height ="387" />';
                                        }


                                        if (isset($product_image[3])) {
                                            echo '<input type="file" name="old_img_detials[' . $product_image[3]['ID'] . ']" data-default-file="' . $baseUrl . '/' . $product_image[3]['URL'] . '" class="dropify" data-max-width="645" data-max-height ="387" />';
                                        }

                                    }
                                    else {
                                        echo '<input type="hidden" name="new_image_or_old_image" value="1"/>';
                                        for ($i = 1; $i <= 4; $i++) {
                                            echo '<input type="file" required name="new_image_detials[]" class="dropify" data-max-width="645" data-max-height ="387" />';
                                        }
                                    }
                                    ?>
                                </div>
                                <?php if (!empty($_SESSION['imageStatus'])) {
                                    echo '<p class="text-info"> ' . $_SESSION['imageStatus'] . '</p>';
                                    unset($_SESSION['imageStatus']);
                                }
                                ?>


                                <div class="b-block text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>

                        <div class="step_3 d-none">
                            <form method="post"
                                action="<?php echo ($basePath . '/resale_module/action/self_panel.php?editID=' . trim($_GET["id"])); ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="actionType" value="pro_edit_3">
                                <input type="hidden" name="editId" value="<?php echo $data['ID'] ?>">

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

                                <div class="b-block text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="step_4 d-none">
                            <form method="post"
                                action="<?php echo ($basePath . '/resale_module/action/self_panel.php?editID=' . trim($_GET["id"])); ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="actionType" value="pro_edit_4">
                                <input type="hidden" name="editId" value="<?php echo $data['ID'] ?>">

                                <div class="mb-3">
                                    <label class="form-label" for="auctionStartDate">AUCTION START DATE</label>
                                    <?php
                                    $auctionStartDate = $data['AUCTTION_START_DATE'];

                                    // Convert date format from dd-MMM-yy to Y-m-d
                                    $auctionStartDateObj = DateTime::createFromFormat('d-M-y', $auctionStartDate);
                                    $formattedStartDate  = $auctionStartDateObj ? $auctionStartDateObj->format('Y-m-d') : date('Y-m-d');

                                    ?>
                                    <input type="date" name="AUCTTION_START_DATE" class="form-control" value="<?php echo $formattedStartDate; ?>"
                                        required id="auctionStartDate">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="auctionEndDate">AUCTION END DATE</label>
                                    <?php
                                    $auctionEndDate = $data['AUCTION_END_DATE'];
                                    // Convert date format from dd-MMM-yy to Y-m-d
                                    
                                    $auctionEndDate   = DateTime::createFromFormat('d-M-y', $auctionEndDate);
                                    $formattedEndDate = $auctionEndDate ? $auctionEndDate->format('Y-m-d') : date('Y-m-d', strtotime('+30 day'));

                                    ?>
                                    <input type="date" name="AUCTION_END_DATE" class="form-control" value="<?php echo $formattedEndDate; ?>" required
                                        id="auctionEndDate">
                                </div>




                                <div class="mb-3">
                                    <label class="form-label" for="HISTORY"> STATUS</label>

                                    <select class="form-select" name="PUBLISHED_STATUS" aria-label="Default select example">
                                        <option <?php echo $data['PUBLISHED_STATUS'] == 'N' ? 'selected' : ''; ?> value="N">Unpublished</option>
                                        <option <?php echo $data['PUBLISHED_STATUS'] == 'Y' ? 'selected' : ''; ?> value="Y">Published</option>
                                    </select>


                                </div>

                                <div class="b-block text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>

                                </div>
                            </form>
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
    // This function ensures that the checkInputValue function is called when the document loads
    // function initialize() {
    //     checkInputValue();
    //     displayPriceInput.addEventListener('change', checkInputValue);
    //     displayPriceInput.addEventListener('input', checkInputValue);
    // }

    // Add an event listener to wait for the document to finish loading before calling initialize
    // document.addEventListener('DOMContentLoaded', initialize);
    // const displayPriceInput = document.getElementById('DISPLAY_PRICE');
    // const submitButton = document.querySelector('button[type="submit"]');

    // Function to check if the input value exists and enable/disable the button accordingly
    // function checkInputValue() {
    // Get the values of DISPLAY_PRICE and BOOK_VALUE
    // const displayPrice = parseFloat(displayPriceInput.value.trim()); // Get the trimmed value of DISPLAY_PRICE
    // const bookValue = parseFloat(<?php echo $data['BOOK_VALUE'] ? $data['BOOK_VALUE'] : 10000; ?>);



    // Check if DISPLAY_PRICE has a value or not
    // if (!displayPrice) {
    // If value is empty or doesn't exist, disable the submit button
    // submitButton.disabled = true;
    // } else if ((displayPrice < bookValue)) {
    // If value exists, enable the submit button
    // displayPriceInput.style.borderColor = 'red';
    // submitButton.disabled = true;
    // } else if ((displayPrice > bookValue)) {
    // If value exists, enable the submit button
    // displayPriceInput.style.borderColor = '';
    // submitButton.disabled = false;
    // } else {
    //displayPriceInput.style.borderColor = '';
    // If value exists, enable the submit button
    //submitButton.disabled = false;
    //}
    //}

    // Add an event listener to the DISPLAY_PRICE input for change and input events
    // displayPriceInput.addEventListener('change', checkInputValue);
    // displayPriceInput.addEventListener('input', checkInputValue);

</script>
<script>

    $('.dropify').dropify({
        messages: {
            'default': 'Select Product Details Image',
            'replace': 'Replace Product Details Image',
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

    // Get all step buttons and their respective step sections
    const stepButtons = document.querySelectorAll('[id^="step_"]');
    const stepSections = document.querySelectorAll('[class^="step_"]');

    // Function to show the selected step section and update button classes
    function showStep(stepId) {
        // Hide all step sections
        stepSections.forEach(section => {
            section.classList.add('d-none');
        });

        // Show the selected step section
        const selectedStep = document.querySelector(`.${stepId}`);
        if (selectedStep) {
            selectedStep.classList.remove('d-none');
        }

        // Update button classes
        stepButtons.forEach(button => {
            if (button.id === stepId) {
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');
            } else {
                button.classList.remove('btn-success');
                button.classList.add('btn-primary');
            }
        });
    }

    // Add click event listeners to each step button
    stepButtons.forEach(button => {
        button.addEventListener('click', () => {
            const stepId = button.id;
            showStep(`${stepId}`);
        });
    });


</script>