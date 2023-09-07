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
            <div class="table-responsive text-nowrap">
                <table class="table  table-bordered" id="downloadSection"  border="1" cellspacing="0" cellpadding="10" >
                    <thead style="background: beige;">
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
                        // if (isset($_REQUEST['end_date'])) {
                        //     $v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                        // } else {
                        //     $v_end_date = date('d/m/Y');
                        // }

                        // $SQLQUERY = "SELECT
                        //                 MIN(D.ID) AS MIN_ID,
                        //                 D.INVOICE_NO,
                        //                 COUNT(D.INVOICE_NO) AS INVOICE_NO_COUNT,
                        //                 LISTAGG(D.CHASSIS_NO, ', ') WITHIN GROUP (ORDER BY D.ID) AS CHASSIS_NO_LIST,
                        //                 LISTAGG(D.ENG_NO, ', ') WITHIN GROUP (ORDER BY D.ID) AS ENG_NO_LIST,
                        //                 LISTAGG(D.REF_NUMBER, ', ') WITHIN GROUP (ORDER BY D.ID) AS REF_NUMBER_LIST

                        //             FROM
                        //                 DEED_INFO D
                        //             WHERE
                        //                 TRUNC(D.ENTRY_DATE) >= TO_DATE(:v_start_date, 'DD/MM/YYYY')
                        //                 AND TRUNC(D.ENTRY_DATE) <= TO_DATE(:v_end_date, 'DD/MM/YYYY')
                        //             GROUP BY
                        //                 D.INVOICE_NO";

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

                        // Bind the variables
                        // oci_bind_by_name($stmt, ':v_start_date', $v_start_date);
                        // oci_bind_by_name($stmt, ':v_end_date', $v_end_date);
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
                                        <span class="badge badge-center rounded-pill bg-warning">0 <?php echo $row['INVOICE_NO_COUNT'] ?></span>
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
            <div class="text-center mt-3">
                <a  class="btn btn-primary " onclick="exportF(this)">
                    <span class="tf-icons bx bx-download"></span>&nbsp; Excel
                </a>
            </div>

        </div>
    </div>
    <!--/ Bordered Table -->



</div>

<script>
    // function exportF(elem) {
        // var table = document.getElementById("downloadSection");
        // var html = table.outerHTML;
        // var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        // // elem.setAttribute("href", url);
        // elem.setAttribute("download", "Visit Assign Report.xls"); // Choose the file name
        // return false;
        
    // }
</script>
<script type="text/javascript">
        function exportF() {
 
            // Variable to store the final csv data
            var csv_data = [];
 
            // Get each row data
            var rows = document.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
 
                // Get each column data
                var cols = rows[i].querySelectorAll('td,th');
 
                // Stores each csv row data
                var csvrow = [];
                for (var j = 0; j < cols.length; j++) {
 
                    // Get the text data of each cell
                    // of a row and push it to csvrow
                    csvrow.push(cols[j].innerHTML);
                }
 
                // Combine each column value with comma
                csv_data.push(csvrow.join(","));
            }
 
            // Combine each row data with new line character
            csv_data = csv_data.join('\n');
 
            // Call this function to download csv file 
            downloadCSVFile(csv_data);
 
        }
 
        function downloadCSVFile(csv_data) {
 
            // Create CSV file object and feed
            // our csv_data into it
            CSVFile = new Blob([csv_data], {
                type: "text/csv"
            });
 
            // Create to temporary link to initiate
            // download process
            var temp_link = document.createElement('a');
 
            // Download csv file
            temp_link.download = "GfG.csv";
            var url = window.URL.createObjectURL(CSVFile);
            temp_link.href = url;
 
            // This link should not be displayed
            temp_link.style.display = "none";
            document.body.appendChild(temp_link);
 
            // Automatically click the link to
            // trigger download
            temp_link.click();
            document.body.removeChild(temp_link);
        }
    </script>
<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>