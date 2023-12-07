<?php
$dynamic_link_css[] = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.css';
$dynamic_link_js[]  = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('resale-product-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>
<style>
    .light-style .select2-container--default .select2-selection--single .select2-selection__arrow b {
        background-image: none !important;
    }
</style>
<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form method="GET">
            <div class="row justify-content-center">
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Brand </label>
                    <select class="form-select select2" name="brand_id" id="brand_id">
                        <option value="" hidden><-- Select Brand --></option>
                        <option value="1">Eicher</option>
                        <option value="2">Mahindra</option>
                        <option value="3">Dongfeng</option>
                    </select>

                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Category</label>

                    <select class="form-select select2" name="cateogry_id" id="cateogry_id">
                        <option value="" hidden><-- Select Category</option> -->

                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Model.</label>

                    <select class="form-select select2" name="model_id" id="model_id">
                        <option value="" hidden><-- Select Model --></option>

                    </select>
                </div>


                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control  btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>


            </div>

        </form>
    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">

        <!-- table header -->
        <?php
        $leftSideName = 'Pending Product List';
        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-break">
                <table class="table table-bordered">
                    <thead style="background-color: #0e024efa;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Brand & Category </th>
                            <th scope="col">Ref. Code & Model </th>
                            <th scope="col">Engine & Chassis & Registation </th>
                            <th scope="col">Book Value & Grade & Depo</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
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
                                    PIC_URL
                                FROM PRODUCT
                                WHERE PUBLISHED_STATUS ='N' AND WORK_STATUS IS NULL");

                        oci_execute($productSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                        <?php
                                        echo $number;
                                        ?>
                                    </strong>
                                </td>
                                <td class="text-left">
                                    BRAND :
                                    <?php
                                    if ($row['BRAND_ID'] == 1) {
                                        echo "EICHER";
                                    }
                                    else if ($row['BRAND_ID'] == 2) {
                                        echo 'MAHINDRA';
                                    }
                                    else {
                                        echo 'DONGFENG';
                                    }
                                    ?>
                                    <br>
                                    CATEGORY :
                                    <?php
                                    echo $row['CATEGORY'];
                                    ?>
                                </td>
                                <td>
                                    REF :
                                    <?php
                                    echo $row['REF_CODE'];
                                    ?> </br>
                                    MOD :
                                    <?php
                                    echo $row['MODEL'];
                                    ?>
                                </td>
                                <td>
                                    ENG No. :
                                    <?php
                                    echo $row['ENG_NO'];
                                    ?></br>
                                    CHS No. :
                                    <?php
                                    echo $row['CHS_NO'];
                                    ?> </br>
                                    REG No. :
                                    <?php
                                    echo $row['REG_NO'];
                                    ?> </br>
                                </td>

                                <td>
                                    BOOK VAL. :
                                    <?php
                                    echo number_format($row['BOOK_VALUE']);
                                    ?></br>
                                    GRADE NUM. :
                                    <?php
                                    echo $row['GRADE'];
                                    ?></br>
                                    DEPO lOC. :
                                    <?php
                                    echo $row['DEPO_LOCATION'];
                                    ?></br>

                                </td>
                                <td class="text-center">
                                    <?php
                                    echo '<button  data-product-id="' . $row['ID'] . '"
                                            data-href="' . ($basePath . '/resale_module/action/self_panel.php?actionType=started_work') . '" type="button" 
                                            class="btn btn-sm btn-info float-right start_work">
                                            Star Work <i class="bx bx-chevrons-right"></i> </button>';
                                    ?>
                                </td>

                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Bordered Table -->



</div>


<!-- / Content -->

<?php
require_once('../../../layouts/footer_info.php');
?>
<?php
require_once('../../../layouts/footer.php');
?>
<script>
    $(document).ready(function () {
        $('.select2').each(function () {
            $(this).select2();

        });
    });

    $('#brand_id').on('change', function () {
        $('#cateogry_id').html(' ');
        let url = "<?php echo ($basePath . '/resale_module/action/dropdown.php?actionType=brand_wise_category') ?> ";
        $.ajax({
            type: "GET",
            url: url,
            data: {brand_id: $(this).val()},
            dataType: "json",
            success: function (res) {
                $('#cateogry_id').append('<option hidden> <-- Select Category --></option>')
                $.map(res.data, function (optionData, indexOrKey) {
                    $('#cateogry_id').append('<option value='+optionData.value+'>'+optionData.value+'</option>')
                });
                
            }
        });
    });
    // $('#brand_id').select2({
    //     data:brandData
    // });
    //delete data processing

    $(document).on('click', '.start_work', function () {
        var product_id = $(this).data('product-id');
        let url = $(this).data('href');
        swal.fire({
            title: 'Are you to  sure start work?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm!',
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        product_id: product_id
                    },
                    dataType: 'json'
                })
                    .done(function (res) {
                        if (res.status) {
                            swal.fire('Star Work!', res.message, res.status);
                            setInterval(function () {
                                location.reload();
                            }, 1000);

                        } else {
                            swal.fire('Oops...', res.message, res.status);

                        }
                    })
                    .fail(function () {
                        swal.fire('Oops...', 'Something went wrong!', 'error');
                    });

            }

        })

    });
</script>