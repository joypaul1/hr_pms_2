<?php
$dynamic_link_js[] = 'https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js';

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
if (!checkPermission('upload-document')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}

?>
<style>
    /* Define a CSS style for printing */
    @media print {
        body * {
            visibility: hidden;
        }

        #printableArea {
            visibility: visible;
        }
    }
</style>
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
                        <a href="<?php echo $basePath ?>/deed_module/view/report_panel/complete_deed.php">
                            <button class="form-control  btn btn-sm btn-warning" type="button">Reset Data</button>
                        </a>
                    </div>
                </div>


            </div>

        </form>
    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">

        <!-- End table  header -->
        <div class="card-body">
            <div class="d-flex justify-content-end gap-1 mb-1">
                <button class="btn btn-info" onclick="exportExcel()">
                    <span class="tf-icons bx bxs-file-export"></span>&nbsp; Excel
                </button>
            </div>
            <div class="table-responsive text-nowrap" id='printableArea'>
                <table class="table table-bordered" id="downloadSection" border="1" cellspacing="0" cellpadding="0">
                    <thead style="background-color: #18392B;">
                        <tr class="text-center">
                            <th> Sl</th>
                            <th> Invoice Number</th>
                            <th> Document Upload </th>
                            <th> check Upload </th>
                            <th> REF. Number </th>
                            <th> Total Unit</th>
                            <th> Eng. No. </th>
                            <th> Chassis NO. </th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        // if (isset($_REQUEST['start_date'])) {
                        //     $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        // } else {
                        //     $v_start_date = date('d/m/Y');
                        // }
                        // TRUNC(D.ENTRY_DATE) >= TO_DATE(:v_start_date, 'DD/MM/YYYY')


                        $serach_inv_id = null;
                        if (isset($_REQUEST['serach_inv_id'])) {
                            $serach_inv_id = $_REQUEST['serach_inv_id'];
                        }
                        $SQLQUERY = "SELECT
                                        MIN(D.ID) AS MIN_ID,
                                        D.INVOICE_NO,
                                        COUNT(D.INVOICE_NO) AS INVOICE_NO_COUNT,
                                        LISTAGG(D.CHASSIS_NO, ', ') WITHIN GROUP (ORDER BY D.ID) AS CHASSIS_NO_LIST,
                                        LISTAGG(D.REF_NUMBER, ', ') WITHIN GROUP (ORDER BY D.ID) AS REF_NUMBER_LIST,
                                        LISTAGG(D.ENG_NO, ', ') WITHIN GROUP (ORDER BY D.ID) AS ENG_NO_LIST,
                                    CASE 
                                        WHEN D.INVOICE_NO = DPF.INVOICE_NO THEN 'true'
                                        ELSE 'false'
                                    END AS PDF_STATUS,
                                    CASE 
                                        WHEN D.INVOICE_NO = DCF.INVOICE_NO THEN 'true'
                                        ELSE 'false'
                                    END AS CHECK_STATUS,
                                    (SELECT PDF_NAME FROM DEED_INFO_DOC_PDF WHERE INVOICE_NO = D.INVOICE_NO) AS PDF_LINK
                                    FROM 
                                        DEED_INFO D
                                    LEFT JOIN 
                                        DEED_INFO_DOC_PDF DPF ON D.INVOICE_NO = DPF.INVOICE_NO 
                                    LEFT JOIN  
                                        DEED_INFO_CHEQUE_PDF DCF ON D.INVOICE_NO = DCF.INVOICE_NO
                                    WHERE 
                                        (:serach_inv_id IS NULL OR D.INVOICE_NO = :serach_inv_id)
                                    GROUP BY 
                                        D.INVOICE_NO, DPF.INVOICE_NO, DCF.INVOICE_NO";

                        // Prepare the SQL statement
                        $stmt = oci_parse($objConnect, $SQLQUERY);
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
                                    <td>
                                        <?php if ($row['PDF_STATUS'] == 'true') {
                                            echo '<span class="badge rounded-pill bg-success">YES</span>';
                                        } else {
                                            echo '<span class="badge rounded-pill bg-danger">NO</span>';
                                        }  ?>

                                    </td>
                                    <td>
                                        <?php if ($row['CHECK_STATUS'] == 'true') {
                                            echo '<span class="badge rounded-pill bg-success">YES</span>';
                                        } else {
                                            echo '<span class="badge rounded-pill bg-danger">NO</span>';
                                        }  ?>

                                    </td>
                                    <td>
                                        <?php
                                        echo  '<li class="list-group-item list-group-item-primary">' . $row['REF_NUMBER_LIST'] . '</li>';
                                        ?>
                                    </td>

                                    <td>
                                        <span class="badge badge-center rounded-pill bg-warning"> <?php echo str_pad($row['INVOICE_NO_COUNT'], 2, '0', STR_PAD_LEFT) ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        echo  '<li class="list-group-item list-group-item-primary">' . $row['ENG_NO_LIST'] . '</li>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo  '<li class="list-group-item list-group-item-primary">' . $row['CHASSIS_NO_LIST'] . '</li>';
                                        ?>

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

<script type="text/javascript">
    function printPage() {
        var sTable = document.getElementById('downloadSection').innerHTML;

        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');

        win.document.write('<html><head>');
        win.document.write('<title>Profile</title>'); // <title> FOR PDF HEADER.
        // win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(sTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('</body></html>');

        win.document.close(); // CLOSE THE CURRENT WINDOW.

        win.print(); // PRINT THE CONTENTS.
    }

    function exportExcel() {
        let type = 'xlsx';
        const nowDate = new Date();
        const year = nowDate.getFullYear(); // Get the current year (e.g., 2023)
        const month = String(nowDate.getMonth() + 1).padStart(2, '0'); // Get the current month (e.g., 09 for September)
        const day = String(nowDate.getDate()).padStart(2, '0'); // Get the current day of the month (e.g., 07)
        const formattedDate = `${day}_${month}_${year}`;

        let fname = 'completeDeed_' + formattedDate + '.xlsx';
        var data = document.getElementById('downloadSection');
        var excelFile = XLSX.utils.table_to_book(data, {
            sheet: "sheet1"
        });
        XLSX.write(excelFile, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        });
        XLSX.writeFile(excelFile, fname);

    }
</script>
<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>