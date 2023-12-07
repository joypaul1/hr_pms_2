<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('resale-product-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form method="GET">
            <div class="row justify-content-center">
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Engine No.</label>

                    <input placeholder="Engine Number" type="text" name="eng_no" class="form-control  cust-control" id="eng"
                        value="<?php echo isset($_GET['eng_no']) ? $_GET['eng_no'] : null ?>">
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Chassis No.</label>

                    <input placeholder="Chassis Number" type="text" name="chs_no" class="form-control  cust-control" id="chs"
                        value="<?php echo isset($_GET['chs_no']) ? $_GET['chs_no'] : null ?>">
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Model No.</label>

                    <input placeholder="Model Number" type="text" name="model" class="form-control  cust-control" id="mdl"
                        value="<?php echo isset($_GET['model']) ? $_GET['model'] : null ?>">
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
        <!-- <h5 class="card-header "><b>Leave Taken List</b></h5> -->
        <!-- table header -->
        <?php
        $leftSideName = 'Pending Prodduct List';


        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table  table-bordered">
                    <thead style="background-color: #0e024efa;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Action</th>
                            <th scope="col">Brand & Category </th>
                            <th scope="col">Ref. Code & Model </th>
                            <th scope="col">Engine & Chassis & Registation </th>
                            <th scope="col">Book Value & Grade & Depo</th>

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
                                WHERE PUBLISHED_STATUS ='N' AND WORK_STATUS ='Y'");

                        oci_execute($productSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                        <?php echo $number; ?>
                                    </strong>
                                </td>
                                <td class="text-center">
                                    <?php
                                    echo '<a href="' . $basePath . '/resale_module/view/self_panel/edit.php?id=' . $row['ID'] . '&amp;&amp;actionType=edit" disabled class="btn btn-sm btn-warning float-right"> <i class="bx bx-edit-alt me-1"></i> Edit </a>';
                                    ?>
                                </td>

                                <td class="text-left">
                                    BRAND : 
                                    <?php if ($row['BRAND_ID'] == 1) {
                                        echo "EICHER";
                                    }
                                    else if ($row['BRAND_ID'] == 2) {
                                        echo 'MAHINDRA';
                                    }
                                    else {
                                        echo 'DONGFING';
                                    } ?>
                                    <br>
                                    CATEGORY : <?php echo $row['CATEGORY'] ?>
                                </td>
                                <td>
                                   REF : <?php echo $row['REF_CODE']; ?> </br>
                                   MOD : <?php echo $row['MODEL']; ?>
                                </td>
                                <td>
                                   ENG No. : <?php echo $row['ENG_NO']; ?></br>
                                   CHS No. : <?php echo $row['CHS_NO']; ?> </br>
                                   REG No. : <?php echo $row['REG_NO']; ?> </br>
                                </td>
                               
                                <td>
                                    BOOK VAL. : <?php echo number_format($row['BOOK_VALUE']) ?></br>
                                    GRADE NUM. : <?php echo $row['GRADE']; ?></br>
                                    DEPO lOC. : <?php echo $row['DEPO_LOCATION']; ?></br>

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

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>