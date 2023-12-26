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
        $leftSideName = 'Web User List';

        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive  text-break">
                <table class="table table-bordered" id="table">
                    <thead style="background-color: #0e024efa;">
                        <tr class="text-center">
                            <th style="width:10px">SL</th>
                            <th>Name </th>
                            <th>MOBILE </th>
                            <th>EMAIL </th>
                            <th>ADDRESS </th>
                            <th>JOIN DATE </th>
                            <!-- <th scope="col">Start By </th>
                            <th scope="col">Stat Date </th> -->

                        </tr>
                    </thead>
                    <tbody style="">

                        <?php
                        $query = "SELECT 
                                    ID, USER_NAME, USER_MOBILE, 
                                    EMAIL, PASSWORD, PICTURE_LINK, 
                                    USER_ROLE_ID, STATUS, ONTIME_PIN, 
                                    CREATE_DATE, DISTRICT_ID, UPAZILA_ID, 
                                    ADDRESS, UPDATED, PENDRIVE
                                    FROM USER_PROFILE";



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
                                    <?php echo $row['USER_NAME'] ?>
                                </td>
                                <td>
                                    <?php echo $row['USER_MOBILE']; ?>
                                </td>

                                <td>
                                    <?php echo $row['EMAIL']; ?></br>
                                </td>
                                <td>
                                    <?php echo $row['ADDRESS']; ?></br>
                                </td>
                                <td>
                                    <?php echo $row['CREATE_DATE']; ?></br>
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
                    Export to excel</a>
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