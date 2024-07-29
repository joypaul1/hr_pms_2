<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connloyaltyoracle.php');
$basePath = $_SESSION['basePath'];
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];

if (!checkPermission('loyalty-card-all-module')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
if (isset($_POST['process_to_print_id']) && !empty($_POST['process_to_print_id'])) {
    $cardID =  $_POST['process_to_print_id'];
    $query = "UPDATE CARD_INFO
        SET
        RECEIVED_PRINT_STATUS = 1,
        RECEIVED_PRINT_BY = '$emp_session_id',
        RECEIVED_PRINT_DATE = SYSDATE
        WHERE ID = '$cardID'";
    $strSQL = oci_parse($objConnect, $query);


    if (@oci_execute($strSQL)) {
        $message = [
            'text' => 'Successfully Go to Printing Process',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
    }
}
// $message = [
//     'text' => "Sorry! You have not select any ID.",
//     'status' => 'false',
// ];
// $_SESSION['noti_message'] = $message;
?>

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
                    <thead style="background-color: #18392B;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Customer Info </th>
                            <th scope="col">Card TYpe </th>
                            <th scope="col">VENDOR Status</th>
                            <th scope="col"> Action </th>

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
                        PRINTING_WORK_DONE_STATUS,
                        PRINTING_WORK_DONE_DATE,
                        RECEIVED_PRINT_BY,
                        RECEIVED_PRINT_DATE,
                        RECEIVED_PRINT_STATUS,
                        (SELECT CP.TITLE FROM CARD_TYPE CP WHERE CP.ID = CARD_TYPE_ID) AS CARD_TYPE_NAME
                        FROM CARD_INFO WHERE ROWNUM <= 25 AND PRINT_PROCESS_STATUS = 1
                        AND RECEIVED_PRINT_STATUS IS NULL OR RECEIVED_PRINT_STATUS = 1
                        AND HANDOVER_STATUS IS NULL
                        ORDER BY ID DESC";
                        // echo $query;
                        // $stmt = oci_parse($objConnect, $query);
                        // Checking and adding the BRAND_ID condition if applicable
                        if (isset($_GET['search_data']) && $_GET['search_data']) {
                            $searchData = urldecode(trim($_GET['search_data']));
                            $query .= " AND CUSTOMER_MOBILE ='$searchData'";
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
                                    ?></br>
                                </td>
                                <td class="text-center">
                                    <span class="btn btn-sm btn-info">
                                        <?= $row['CARD_TYPE_NAME'] ?>
                                    </span>

                                </td>
                                <td class="text-center">
                                    <?php if ($row['PRINTING_WORK_DONE_STATUS']) {
                                        echo '<span class="badge bg-label-success">Complete  <i class="bx bxs-badge-check"></i></span>';
                                    } else {
                                        echo '<span class="badge bg-label-danger">Pending  <i class="bx bxs-hand" ></i></span>';
                                    }
                                    ?>
                                </td>
                                darkgreen
                                <td class="text-center">
                                    <?php if (!$row['PRINTING_WORK_DONE_STATUS']) { ?>
                                        <button class="btn btn-sm btn-info " disabled type="submit"> Received Form Vendor
                                            <i class="bx bx-chevrons-right"></i>
                                        </button>
                                    <?php }  else if(!$row['RECEIVED_PRINT_STATUS']) { ?>
                                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                            <input type="hidden" name="process_to_print_id" value="<?= $row['ID'] ?>">
                                            <button class="btn btn-sm btn-success" type="submit"> Received Form Vendor
                                                <i class="bx bx-chevrons-right"></i>
                                            </button>
                                        </form>
                                    <?php } ?>
                                   
                                    <?php if ($row['RECEIVED_PRINT_BY']) {
                                        echo "<span class='badge bg-label-info'>Rec. By: " . $row['RECEIVED_PRINT_BY'] . "</span>";
                                        ECHO "</br>";
                                        echo '<a href="' . ($basePath . '/loyalty_card_module/view/self_panel/hand_over_card.php?id=' . $row['ID']) . '"
                                        class="btn btn-sm btn-warning text-white"> Hand Over TO Customer <i class="bx bx-chevrons-right"></i> </a>';
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