<?php

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



    <!-- Bordered Table -->
    <div class="card mt-2">
        <?php
        $leftSideName = 'Contact List';

        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive  text-break">
                <table class="table table-bordered" id="table">
                    <thead style="background-color: #b8860b;">
                        <tr class="text-center">
                            <th style="width:15px">SL</th>
                            <th>Name </th>
                            <th>MOBILE </th>
                            <th>Message </th>
                            <th>Contact DATE </th>

                        </tr>
                    </thead>
                    <tbody style="">

                        <?php
                        $query = "SELECT 
                                    ID, NAME, MOBILE, 
                                    MESSAGES, CREATED_DATE
                                    FROM CLIENT_CONTACT";



                        $productSQL = oci_parse($objConnect, $query);

                        oci_execute($productSQL);


                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td style="width:10px">
                                    <?php echo $number; ?>
                                </td>
                                <td class="text-left">
                                    <?php echo $row['NAME'] ?>
                                </td>
                                <td>
                                    <?php echo $row['MOBILE']; ?>
                                </td>

                                <td>
                                    <?php echo $row['MESSAGES']; ?>
                                </td>
                                <td>
                                    <?php echo $row['CREATED_DATE']; ?>
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
        elem.setAttribute("download", "Resale Web User.xls"); // Choose the file name
        return false;
    }
</script>