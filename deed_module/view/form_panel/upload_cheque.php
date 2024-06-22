<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('upload-document')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body">
        <form action="" method="post">
            <div class="row justify-content-center">

                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Search By Invoice No. *</label>
                    <input required="" type="text" name="serach_inv_id" class="form-control cust-control" value="<?php echo isset($_POST['serach_inv_id']) ? $_POST['serach_inv_id'] : null ?>">
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control  btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <a href="<?php echo $basePath ?>/deed_module/view/form_panel/upload_cheque.php">
                            <button class="form-control  btn btn-sm btn-warning" type="button">Reset Data</button>
                        </a>
                    </div>
                </div>


            </div>

        </form>
    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">
        <!-- table header -->
        <?php
        $leftSideName  = 'Deed List';
        if (checkPermission('deed-create')) {
            $rightSideName = 'Deed Create';
            $routePath     = 'deed_module/view/form_panel/create.php';
        }

        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table  table-bordered">
                    <thead style="background-color: #18392B;">
                        <tr class="text-center">
                            <th>Sl</th>
                            <th>Invoice Number</th>
                            <th>REF. Number </th>
                            <th>Total Unit</th>
                            <th colspan="2"> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                        </tr>
                        <?php
                        $serach_inv_id = null;
                        if (isset($_REQUEST['serach_inv_id'])) {
                            $serach_inv_id = $_REQUEST['serach_inv_id'];
                        }
                        $SQLQUERY = "SELECT
                                        MIN(D.ID) AS MIN_ID,
                                        D.INVOICE_NO,
                                        COUNT(D.INVOICE_NO) AS INVOICE_NO_COUNT,
                                        LISTAGG(D.ID, ', ') WITHIN GROUP (ORDER BY D.ID) AS ID_LIST,
                                        LISTAGG(D.REF_NUMBER, ', ') WITHIN GROUP (ORDER BY D.ID) AS REF_NUMBER_LIST,
                                    CASE 
                                        WHEN D.INVOICE_NO = DCF.INVOICE_NO THEN 'true'
                                        ELSE 'false'
                                    END AS CHEQUE_STATUS,
                                    (SELECT PDF_NAME FROM DEED_INFO_CHEQUE_PDF WHERE INVOICE_NO = D.INVOICE_NO) AS PDF_LINK
                                    FROM 
                                        DEED_INFO D
                                    LEFT JOIN 
                                    DEED_INFO_CHEQUE_PDF DCF ON D.INVOICE_NO = DCF.INVOICE_NO
                                    WHERE 
                                        (:serach_inv_id IS NULL OR D.INVOICE_NO = :serach_inv_id)
                                    GROUP BY 
                                        D.INVOICE_NO, DCF.INVOICE_NO";


                        // Prepare the SQL statement
                        $stmt = oci_parse($objConnect, $SQLQUERY);

                        // Bind the variables
                        oci_bind_by_name($stmt, ':serach_inv_id', $serach_inv_id);

                        // Execute the query    
                        if (oci_execute($stmt)) {
                            $number = 0;
                            while ($row = oci_fetch_assoc($stmt)) {
                                $number++;
                        ?>
                                <tr class="text-center">
                                    <td> <?php echo  str_pad($number, 2, '0', STR_PAD_LEFT) ?></td>
                                    <td> <?php echo $row['INVOICE_NO'] ?></td>
                                    <td> <?php echo $row['REF_NUMBER_LIST'] ?></td>

                                    <td><span class="badge badge-center rounded-pill bg-warning">0<?php echo $row['INVOICE_NO_COUNT'] ?> </span> </td>
                                    <td>
                                        <a target="_blank" href="<?php echo $basePath . '/deed_module/view/form_panel/car_deed_print_form.php?inserted_id=' . $row['ID_LIST'] ?>" class="btn btn-sm btn-outline-primary">View Deed <i class='bx bx-right-arrow'></i></a>
                                    </td>
                                    <td>
                                        <?php if ($row['CHEQUE_STATUS'] == 'true') {
                                            echo "<a target='_blank' href='$basePath" . '/' . $row['PDF_LINK'] . "'> <span class='badge bg-label-info'>view file <i class='bx bxs-file'></i> </span></a>";
                                        } else {  ?>
                                            <a target="_blank" href="<?php echo $basePath . '/deed_module/view/form_panel/uploadCheque.php?invoice_no=' . $row['INVOICE_NO'] . '&min_id=' . $row['MIN_ID'] . '&ids=' . trim($row['ID_LIST'])  ?>" class="btn btn-sm btn-outline-info">Upload Cheque <i class='bx bx-right-arrow'></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>


                        <?php
                            }
                        } else {
                            $error = oci_error($stmt); // Handle errors if the execution fails
                            $errorMes = $error['message'];
                            echo "<tr class='text-center'> $errorMes </tr>";
                        }

                        // Free the statement when done
                        oci_free_statement($stmt);


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