<?php
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
                    <thead style="background-color: #18392B;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Customer & VALIDity Info </th>
                            <th scope="col">Card TYpe</th>
                            <th scope="col">REceiver Details</th>
                            <th scope="col">HandOver Action </th>
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
                        RECEIVED_PRINT_BY,
                        RECEIVED_PRINT_DATE,
                        (SELECT CP.TITLE FROM CARD_TYPE CP WHERE CP.ID = CARD_TYPE_ID) AS CARD_TYPE_NAME
                        FROM CARD_INFO WHERE ROWNUM <= 25
                        AND RECEIVED_PRINT_STATUS = 1 AND RECEIVED_PRINT_BY IS NOT NULL
                        AND TRUNC (RECEIVED_PRINT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')";

                        // Checking and adding the BRAND_ID condition if applicable
                        if (isset($_GET['search_data']) && $_GET['search_data']) {
                            $searchData = urldecode(trim($_GET['search_data']));
                            $query .= " AND LOWER(REF_NO) LIKE LOWER('%$searchData%')";
                            $query .= " OR LOWER(CUSTOMER_MOBILE) LIKE LOWER('%$searchData%')";
                        }
                        $query .= "  ORDER BY ID DESC";
                        // echo $query ;
                        $cardSQL = @oci_parse($objConnect, $query);

                        @oci_execute($cardSQL);
                        $number = 0;
                        while ($row = @oci_fetch_assoc($cardSQL)) {
                            $number++;
                        ?>
                            <tr>
                                <td>
                                    <?php
                                    echo $number;
                                    ?>
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
                                    </br>
                                    VALIDity : <?= $row['VALID_START_DATE'] ?> TO <?= $row['VALID_END_DATE'] ?>
                                    <br>
                                    <?php
                                    $startDate  = date_create(date('Y-m-d', strtotime($row['VALID_END_DATE'])));
                                    $endDate    = date_create(date('Y-m-d', strtotime($row['VALID_START_DATE'])));
                                    $diff = date_diff($startDate, $endDate);
                                    $days =  $diff->format("%a")
                                    ?>
                                    Expire : <?= $days ?> Days
                                </td>
                                <td class="text-center">
                                    <span class="btn btn-sm btn-info">
                                        <?= $row['CARD_TYPE_NAME'] ?>
                                    </span>

                                </td>
                                <td class="text-center">
                                    REC. BY : <?= $row['RECEIVED_PRINT_BY'] ?></br>
                                    Date : <?= $row['RECEIVED_PRINT_DATE'] ?>
                                </td>
                                <td class="text-start">
                                    <?php
                                    if (isset($row['HANDOVER_DATE']) && $row['HANDOVER_DATE']) {
                                        // echo "<span class='text-center'><i class='bx bxs-badge-check' style='
                                        // font-size: 35px;color: green;'></i></span> " . '</br>';
                                        echo 'Name : ' . $row['HANDOVER_TO_NAME'] . '</br>';
                                        echo 'Mobile : ' . $row['HANDOVER_MOBILE_NUMBER'] . '</br>';
                                        echo 'Date : ' . $row['HANDOVER_DATE'] . '</br>';
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