<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connloyaltyoracle.php');
$basePath = $_SESSION['basePath'];
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];

if (!checkPermission('loyalty-card-all-module')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
if (isset($_POST['process_to_print_id']) && !empty($_POST['process_to_print_id'])) {
    $cardID = $_POST['process_to_print_id'];
    $query = "UPDATE CARD_INFO
        SET
        PRINT_PROCESS_STATUS = 1,
        PRINT_PROCESS_BY = '$emp_session_id',
        PRINT_PROCESS_DATE= SYSDATE
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
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Get the current page, default is 1
$start = ($page - 1) * $limit; // Calculate the start record
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form method="GET" class="row justify-content-center align-items-center">
            <div class="col-4">
                <input class="form-control" type="text" placeholder="Mobile Number / Reference Code Enter.."
                    name="search_data" value="<?= isset($_GET['search_data']) ? $_GET['search_data'] : NULL ?>">
            </div>

            <div class="col-4 ">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                    <a href="<?php echo $basePath . '/loyalty_card_module/view/self_panel/list.php' ?>"
                        class="form-control btn btn-sm btn-warning">Reset Data</a>
                </div>
            </div>
        </form>
    </div>


    <!-- Bordered Table -->
    <div class="card mt-2">

        <!-- table header -->
        <?php
        $leftSideName = 'Loyalty Card List';
        $rightSideName = 'Card Create';
        $routePath = '/loyalty_card_module/view/self_panel/create.php';
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
                            <th scope="col">Card Type </th>
                            <th scope="col">Card VALIDity</th>
                            <th scope="col">Created Details</th>
                            <th scope="col"> Action </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Build the SQL query with pagination
                        $query = "SELECT * FROM (
                                    SELECT ROWNUM rnum, data.* FROM (
                                        SELECT ID,
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
                                        FROM CARD_INFO
                                        WHERE PRINT_PROCESS_STATUS IS NULL";

                        // Check for search input and modify query accordingly
                        if (isset($_GET['search_data']) && $_GET['search_data']) {
                            $searchData = urldecode(trim($_GET['search_data']));
                            $query .= " AND (LOWER(REF_NO) LIKE LOWER('%$searchData%') OR LOWER(CUSTOMER_MOBILE) LIKE LOWER('%$searchData%'))";
                        }

                        $query .= " ORDER BY ID DESC
                                        ) data
                                        WHERE ROWNUM <= " . ($start + $limit) . "
                                    )
                                    WHERE rnum > " . $start;

                        $cardSQL = oci_parse($objConnect, $query);
                        oci_execute($cardSQL);
                        $number = $start; // Start numbering from the calculated starting point
                        
                        while ($row = oci_fetch_assoc($cardSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $number; ?>
                                </td>
                                <td>
                                    NAME : <?= $row['CUSTOMER_NAME']; ?> <br>
                                    MOBILE : <?= $row['CUSTOMER_MOBILE']; ?> <br>
                                    REF. NO. : <?= $row['REF_NO']; ?> <br>
                                    ENG. NO. : <?= $row['ENG_NO']; ?> <br>
                                    CHS. NO. : <?= $row['CHS_NO']; ?> <br>
                                    REG. NO. : <?= $row['REG_NO']; ?>
                                </td>
                                <td>
                                    <span class="btn btn-sm btn-info">
                                        <?= $row['CARD_TYPE_NAME']; ?>
                                    </span>
                                </td>
                                <td>
                                    (<?= $row['VALID_START_DATE']; ?>) - (<?= $row['VALID_END_DATE']; ?>)
                                    <br>
                                    <?php
                                    $startDate = date_create(date('Y-m-d', strtotime($row['VALID_END_DATE'])));
                                    $endDate = date_create(date('Y-m-d', strtotime($row['VALID_START_DATE'])));
                                    $diff = date_diff($startDate, $endDate);
                                    $days = $diff->format("%a");
                                    ?>
                                    Expire: <?= $days; ?> Days
                                </td>
                                <td>
                                    Date : <?= $row['CREATED_DATE']; ?> <br>
                                    BY : <?= $row['CREATED_BY']; ?>
                                </td>
                                <td class="text-start">
                                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                        <input type="hidden" name="process_to_print_id" value="<?= $row['ID']; ?>">
                                        <button class="btn btn-sm btn-warning" type="submit">Print On Process <i
                                                class="bx bx-chevrons-right"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }

                        // If no records are found
                        if ($number === $start) {
                            echo '<tr><td colspan="6" class="text-center text-danger fw-bold">Data Not Found.</td></tr>';
                        }

                        // Pagination Logic
                        $totalQuery = "SELECT COUNT(*) AS TOTAL_RECORDS FROM CARD_INFO WHERE PRINT_PROCESS_STATUS IS NULL";
                        $totalSQL = oci_parse($objConnect, $totalQuery);
                        oci_execute($totalSQL);
                        $totalRow = oci_fetch_assoc($totalSQL);
                        $total_records = $totalRow['TOTAL_RECORDS'];
                        $total_pages = ceil($total_records / $limit);
                        ?>
                    </tbody>

                </table>
                <!-- Display pagination links -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="btn btn-primary">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="btn btn-<?= ($i == $page) ? 'secondary' : 'light' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="btn btn-primary">Next</a>
                    <?php endif; ?>
                </div>
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