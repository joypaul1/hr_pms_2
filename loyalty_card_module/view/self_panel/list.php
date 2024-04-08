<?php
$dynamic_link_css[] = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.css';
$dynamic_link_js[]  = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connloyaltyoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('loyalty-card-all-module')) {
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
        <form method="GET" class="row justify-content-center align-items-center">
            <div class="col-4">
                <input class="form-control" type="text" placeholder="Mobile Number / Reference Code Enter.." name="search_data" value="<?= isset($_GET['search_data']) ? $_GET['search_data'] : NULL ?>">
            </div>

            <div class="col-4 ">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                    <a href="<?php echo $basePath . '/loyalty_card_module/view/self_panel/list.php' ?>" class="form-control btn btn-sm btn-warning">Reset Data</a>
                </div>
            </div>
        </form>

    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">

        <!-- table header -->
        <?php
        $leftSideName  = 'Loyalty Card List';
        $rightSideName = 'Card Create';
        $routePath     = '/loyalty_card_module/view/self_panel/create.php';
        include('../../../layouts/_tableHeader.php');
        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: #02c102;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">CARD TYPE</th>
                            <th scope="col">Customer Info </th>
                            <th scope="col">Card VALIDity</th>
                            <th scope="col">Action </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT ID,
                        CUSTOMER_NAME,
                        CUSTOMER_MOBILE,
                        REF_NO,
                        ENG_NO,
                        REG_NO,
                        CHS_NO,
                        VALID_START_DATE,
                        VALID_END_DATE,
                        CARD_TYPE_ID,
                        HANDOVER_DATE,
                        HANDOVER_TO_NAME,
                        HANDOVER_MOBILE_NUMBER,
                        VARIFICATION_PIN,
                        HANDOVER_STATUS,
                        (SELECT CP.TITLE FROM CARD_TYPE CP WHERE CP.ID = CARD_TYPE_ID) AS CARD_TYPE_NAME
                        FROM CARD_INFO";

                        // Checking and adding the BRAND_ID condition if applicable
                        if (isset($_GET['search_data']) && $_GET['search_data']) {
                            $searchData = urldecode($_GET['search_data']);
                            $query .= " WHERE CUSTOMER_MOBILE ='$searchData'";
                            $query .= " OR REF_NO ='$searchData'";
                        }

                        $cardSQL = oci_parse($objConnect, $query);

                        oci_execute($cardSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($cardSQL)) {
                            $number++;
                        ?>
                            <tr>
                                <td>
                                    <?php
                                    echo $number;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <span class="btn btn-sm btn-info">
                                        <?= $row['CARD_TYPE_NAME'] ?>
                                    </span>
                                </td>
                                <td>
                                    NAME :
                                    <?php
                                    echo $row['CUSTOMER_NAME'];
                                    ?> </br>
                                    MOBILE :
                                    <?php
                                    echo $row['CUSTOMER_MOBILE'];
                                    ?>
                                    </br>
                                    REF. NO. :
                                    <?php
                                    echo $row['REF_NO'];
                                    ?>
                                    </br>
                                    ENG. NO. :
                                    <?php
                                    echo $row['ENG_NO'];
                                    ?></br>
                                    CHS. NO. :
                                    <?php
                                    echo $row['CHS_NO'];
                                    ?> </br>
                                    REG. NO. :
                                    <?php
                                    echo $row['REG_NO'];
                                    ?>
                                </td>
                                <td>
                                    Start : <?= $row['VALID_START_DATE'] ?>
                                    <br>
                                    End : <?= $row['VALID_END_DATE'] ?>

                                </td>
                                <td class="text-center">
                                    <?php
                                    if (isset($row['HANDOVER_DATE']) && $row['HANDOVER_DATE']) {
                                        echo "<span ><i class='bx bxs-badge-check' style='
                                        font-size: 35px;color: green;'></i></span>";
                                    } else {
                                        echo '<a href="' . ($basePath . '/loyalty_card_module/view/self_panel/hand_over_card.php?id=' . $row['ID']) . '" class="btn btn-sm btn-warning text-white"> Hand Over Card <i class="bx bx-chevrons-right"></i> </a>';
                                    }

                                    ?>
                                </td>

                            </tr>
                        <?php
                        }
                        if ($number === 0) {
                            echo '<tr><td colspan="5" class="text-center text-danger fw-bold">Data Not Found.</td></tr>';
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
require_once('../../../layouts/footer.php');
?>