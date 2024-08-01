<?php
// $dynamic_link_css[] = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.css';
// $dynamic_link_js[]  = 'https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/select2/select2.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connloyaltyoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('loyalty-card-all-module')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
$v_start_date = isset($_POST['start_date']) ? date('d/m/Y', strtotime($_POST['start_date'])) : date('01/m/Y');
$v_end_date   = isset($_POST['end_date']) ? date('d/m/Y', strtotime($_POST['end_date'])) : date('t/m/Y');
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form method="POST" class="row justify-content-center align-items-center">
            <div class="col-4">
                <label for="ref_code">Mobile Number / Reference Code : </label>

                <input class="form-control" id="ref_code" type="text" placeholder="Mobile Number / Reference Code Enter.." name="search_data" value="<?= isset($_POST['search_data']) ? $_POST['search_data'] : NULL ?>">
            </div>
            <div class="col-2">
                <label class="form-label" for="basic-default-fullname">Start Date <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar">
                        </i>
                    </div>
                    <input required value="<?php echo DateTime::createFromFormat('d/m/Y', $v_start_date)->format('Y-m-d') ?>" class="form-control" type="date" name="start_date">
                </div>

            </div>
            <div class="col-2">
                <label class="form-label" for="basic-default-fullname">End Date <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar">
                        </i>
                    </div>
                    <input required="" value="<?php echo DateTime::createFromFormat('d/m/Y', $v_end_date)->format('Y-m-d') ?>" class="form-control" type="date" name="end_date">
                </div>
            </div>

            <div class="col-2">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <button class="form-control btn btn-sm btn-primary" type="submit">Search Data</button>
                    <a href="<?php echo $basePath . '/loyalty_card_module/view/self_panel/printed_card.php' ?>" class="form-control btn btn-sm btn-warning">Reset Data</a>
                </div>
            </div>
            <span class="text-danger text-center">[Note: Search By Handover Date wise]</span>
        </form>

    </div>


    <!-- Bordered Table -->
    <div class="card mt-2">

        <!-- table header -->
        <?php

        $leftSideName  = 'Loyalty Card Report';
        $rightSideName = 'Card Create';
        $routePath     = '/loyalty_card_module/view/self_panel/create.php';
        include('../../../layouts/_tableHeader.php');
        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="text-end">
                <a class="btn btn-sm btn-info text-white" id="" onclick="exportF(this)" style="margin-bottom:2px;"> <i class='bx bx-cloud-download'></i> Export To Excel </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="downloadData">
                    <thead style="background-color: #18392B;">
                        <tr class="text-center">
                            <th colspan="16">Start Date : <?= $v_start_date ?> - End Date : <?= $v_end_date ?></th>
                        </tr>
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">CUSTOMER NAME </th>
                            <th scope="col">CUSTOMER MOBILE </th>
                            <th scope="col">CUSTOMER REF. NO. </th>
                            <th scope="col">ENG. NO. </th>
                            <th scope="col">REG. NO. </th>
                            <th scope="col">CHS. NO. </th>
                            <th scope="col">Card type </th>
                            <th scope="col">VALIDity START DATE</th>
                            <th scope="col">VALIDity END DATE</th>
                            <th scope="col">VALIDity END Days</th>
                            <th scope="col">HANDOVER DATE</th>
                            <th scope="col">HANDOVER TO NAME</th>
                            <th scope="col">HANDOVER MOBILE Num.</th>
                            <th scope="col">CARD CREATED DATE</th>
                            <th scope="col">CARD CREATED BY</th>

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
                                    CREATED_DATE,
                                    CREATED_BY,
                                    (SELECT CP.TITLE FROM CARD_TYPE CP WHERE CP.ID = CARD_TYPE_ID) AS CARD_TYPE_NAME
                                    FROM CARD_INFO WHERE HANDOVER_STATUS = 1
                                    AND  TRUNC (HANDOVER_DATE)
                                    BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')";

                        // Checking and adding the BRAND_ID condition if applicable
                        if (isset($_POST['search_data']) && $_POST['search_data']) {
                            $searchData = urldecode(trim($_POST['search_data']));
                            $query .= " AND LOWER(REF_NO) LIKE LOWER('%$searchData%')";
                            $query .= " OR LOWER(CUSTOMER_MOBILE) LIKE LOWER('%$searchData%')";
                        }
                        $query .= "  ORDER BY ID DESC";
                        
                        $cardSQL = oci_parse($objConnect, $query);

                        oci_execute($cardSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($cardSQL)) {
                            $number++;
                        ?>
                            <tr>
                                <td>
                                    <?= $number  ?>
                                </td>
                                <td>
                                    <?= $row['CUSTOMER_NAME'] ?>
                                </td>
                                <td>
                                    <?= $row['CUSTOMER_MOBILE'] ?>
                                </td>
                                <td>
                                    <?= $row['REF_NO'] ?>
                                </td>
                                <td>
                                    <?= $row['ENG_NO'] ?>
                                </td>
                                <td>
                                    <?= $row['CHS_NO'] ?>
                                </td>
                                <td>
                                    <?= $row['REG_NO'] ?>
                                </td>
                                <td>
                                    <?= $row['CARD_TYPE_NAME'] ?>
                                </td>
                                <td><?= date('d-m-Y', strtotime($row['VALID_END_DATE'])) ?></td>
                                <td><?= date('d-m-Y', strtotime($row['VALID_END_DATE'])) ?></td>
                                <td>
                                    <?php
                                    $startDate  = date_create(date('Y-m-d', strtotime($row['VALID_END_DATE'])));
                                    $endDate    = date_create(date('Y-m-d', strtotime($row['VALID_START_DATE'])));
                                    $diff = date_diff($startDate, $endDate);
                                    $days =  $diff->format("%a")
                                    ?> <?= $days ?> Days

                                </td>
                                <td> <?= $row['HANDOVER_DATE'] ?> </td>
                                <td> <?= $row['HANDOVER_TO_NAME'] ?> </td>
                                <td> <?= $row['HANDOVER_MOBILE_NUMBER'] ?> </td>
                                <td><?= date('d-m-Y', strtotime($row['CREATED_DATE'])) ?></td>
                                <td> <?= $row['CREATED_BY'] ?> </td>

                            </tr>
                        <?php
                        }
                        if ($number === 0) {
                            echo '<tr><td colspan="16" class="text-center text-danger fw-bold">Data Not Found.</td></tr>';
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
<script>
    function exportF(elem) {
        var table = document.getElementById("downloadData");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "loyalty_card_report.xls"); // Choose the file name
        return false;
    }
</script>