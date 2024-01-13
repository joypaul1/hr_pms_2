<?php
$dynamic_link_css[] = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.css';
$dynamic_link_js[]  = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('resale-report-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$number = 0;
?>

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

                    <select class="form-select select2" name="category_id" id="category_id">
                        <option value="" hidden><-- Select Category</option> -->

                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Model.</label>

                    <select class="form-select select2" name="model_id" id="model_id">
                        <option value="" hidden><-- Select Model --></option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">STATUS </label>
                    <select class="form-select select2" name="status" id="status">
                        <option value="1">ALL</option>
                        <option value="2">Pending</option>
                        <option value="4">Working</option>
                        <option value="5">Published</option>
                    </select>

                </div>
            </div>

            <div class="d-flex flex-row  justify-content-end mt-3">
                <div class="col-sm-3">
                    <button class="form-control btn btn-sm btn-primary" type="submit">
                        Search Data
                    </button>
                    <a href="<?php echo $basePath . '/resale_module/view/report_panel/product_info.php' ?>"
                        class="form-control  btn btn-sm btn-warning"> Reset Data
                    </a>
                </div>


            </div>
        </form>
    </div>

    <style>
        tbody {
            display: block;
            height: 250px;
            overflow-y: scroll;
        }

        tr {
            display: block;
        }

        .table th{
            font-size: 10px;
        }
        th,td {
            width: 250px;
        }

        .table tr {
            font-size: 12px !important;
            color: black !important;
        }
    </style>


    <!-- Bordered Table -->
    <div class="card mt-2">

        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive  text-break">
                <table class="table table-bordered" id="table">
                    <thead style="background-color: #02c102;">
                        <tr class="text-center">
                            <th style="width:10px">SL</th>
                            <th>Brand </th>
                            <th>Category </th>
                            <th>Ref. Code </th>
                            <th>Model </th>
                            <th>Engine </th>
                            <th>Chassis </th>
                            <th>Registation </th>
                            <th>Book Value</th>
                            <th>Cash Price</th>
                            <th>Credit Price</th>
                            <th>Grade </th>
                            <th>Depo</th>
                            <!-- <th scope="col">Start By </th>
                            <th scope="col">Stat Date </th> -->

                        </tr>
                    </thead>
                    <tbody >

                        <?php
                        $query = "SELECT 
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
                                START_DATE,
                                START_BY
                                FROM PRODUCT WHERE ID IS NOT NULL";

                        // Checking and adding the BRAND_ID condition if applicable
                        if (isset($_GET['brand_id']) && $_GET['brand_id']) {
                            $query .= " AND BRAND_ID = :brandId";
                        }
                        if (isset($_GET['category_id']) && $_GET['category_id']) {
                            $query .= " AND CATEGORY = :categoryId";
                        }
                        if (isset($_GET['model_id']) && $_GET['model_id']) {
                            $query .= " AND MODEL = :modelId";
                        }
                        if (isset($_GET['status']) && $_GET['status'] != '1') {
                            // WHERE PUBLISHED_STATUS ='N' AND WORK_STATUS ='Y'
                            if ($_GET['status'] == '2') {
                                $query .= " AND PUBLISHED_STATUS ='N'";
                            }
                            if ($_GET['status'] == '3') {
                                $query .= " WORK_STATUS ='Y'";
                            }
                            if ($_GET['status'] == '4') {
                                $query .= " PUBLISHED_STATUS ='Y'";
                            }

                        }

                        $productSQL = oci_parse($objConnect, $query);

                        // Bind the parameter if the condition applies
                        if (isset($_GET['brand_id']) && $_GET['brand_id']) {
                            oci_bind_by_name($productSQL, ':brandId', $_GET['brand_id']);
                        }
                        if (isset($_GET['category_id']) && $_GET['category_id']) {
                            $category = str_replace('-', ' ', $_GET["category_id"]);
                            oci_bind_by_name($productSQL, ':categoryId', $category);
                        }
                        if (isset($_GET['model_id']) && $_GET['model_id']) {

                            $model = str_replace('-', ' ', $_GET["model_id"]);
                            oci_bind_by_name($productSQL, ':modelId', $model);
                        }
                        oci_execute($productSQL);


                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td style="width:10px">
                                    <?php echo $number; ?>
                                </td>

                                <td class="text-left">
                                    <?php if ($row['BRAND_ID'] == 1) {
                                        echo "EICHER";
                                    }
                                    else if ($row['BRAND_ID'] == 2) {
                                        echo 'MAHINDRA';
                                    }
                                    else {
                                        echo 'DONGFING';
                                    } ?>
                                </td>
                                <td class="text-left">
                                    <?php echo $row['CATEGORY'] ?>
                                </td>
                                <td>
                                    <?php echo $row['REF_CODE']; ?>

                                </td>
                                <td>
                                    <?php echo $row['MODEL']; ?>
                                </td>
                                <td>
                                    <?php echo $row['ENG_NO']; ?>
                                </td>
                                <td>
                                    <?php echo $row['CHS_NO']; ?>
                                </td>
                                <td>
                                    <?php echo $row['REG_NO']; ?>
                                </td>
                                <td>
                                    <?php echo number_format($row['BOOK_VALUE']) ?>
                                </td>
                                <td>
                                    <?php echo number_format($row['CASH_PRICE']) ?>
                                </td>
                                <td>
                                    <?php echo number_format($row['CREDIT_PRICE']) ?></br>
                                </td>
                                <td>
                                    <?php echo $row['GRADE']; ?>
                                </td>
                                <td>
                                    <?php echo $row['DEPO_LOCATION']; ?></br>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>

                </table>
                <strong>Total Data :
                    <?php echo $number ?>
                </strong>

            </div>
            <div class='text-right'>
                <a class="btn btn-md btn-info text-white" onclick="exportF(this)" style="margin-left:5px;">
                    <i class='bx bxs-file-export'></i>
                    Export To Excel</a>
            </div>
        </div>
    </div>
    <!--/ Bordered Table -->



</div>


<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
    function exportF(elem) {
        var table = document.getElementById("table");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Resale Product.xls"); // Choose the file name
        return false;
    }
</script>

<script>
    $(document).ready(function () {
        $('.select2').each(function () {
            $(this).select2();

        });
    });

    $('#brand_id').on('change', function () {
        categoryData($(this).val());
    });


    function categoryData(brand_id) {
        $('#category_id').html(' ');
        let url = "<?php echo ($basePath . '/resale_module/action/dropdown.php?actionType=brand_wise_category') ?> ";
        $.ajax({
            type: "GET",
            url: url,
            data: { brand_id: brand_id },
            dataType: "json",
            success: function (res) {
                $('#category_id').append('<option value="" hidden> <-- Select Category --></option>')
                $.map(res.data, function (optionData, indexOrKey) {
                    $('#category_id').append('<option value=' + (optionData.value).replaceAll(' ', '-') + '>' + optionData.value + '</option>')
                });

            }
        });
    };

    $('#category_id').on('change', function () {
        modelData($(this).val());
    });

    function modelData(category_data) {
        $('#model_id').html(' ');
        let url = "<?php echo ($basePath . '/resale_module/action/dropdown.php?actionType=category_wise_model') ?> ";
        $.ajax({
            type: "GET",
            url: url,
            data: { categoryData: category_data },
            dataType: "json",
            success: function (res) {
                $('#model_id').append('<option value="" hidden> <-- Select Model --></option>')
                $.map(res.data, function (optionData, indexOrKey) {
                    $('#model_id').append('<option value=' + (optionData.value).replaceAll(' ', '-') + '>' + optionData.value + '</option>')
                });

            }
        });
    };

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