<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('self-leave-report')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form action="" method="post">
            <div class="row justify-content-center">
                <input required name="emp_id" type='hidden' value='<?php echo $emp_session_id; ?>'>
                <div class="col-sm-2">
                    <label class="form-label" for="basic-default-fullname">Select Start Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="start_date" class="form-control  cust-control" id="title" value="">
                    </div>
                </div>
                <div class="col-sm-2">
                    <label class="form-label" for="basic-default-fullname">Select End Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="end_date" class="form-control  cust-control" id="title" value="">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control  btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>


            </div>

        </form>
    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">
        <!-- <h5 class="card-header "><b>Leave Taken List</b></h5> -->
        <!-- table header -->
        <?php
        $leftSideName = 'Pending Prodduct List';
      

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table  table-bordered">
                    <thead style="background-color: #0e024efa;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Action</th>
                            <th scope="col">Price</th>
                            <th scope="col">Ref. Code  </th>
                            <th scope="col">Model  </th>
                            <th scope="col">Engine </th>
                            <th scope="col">Chassis </th>
                            <th scope="col">Reg Num.</th>
                            <th scope="col">Color</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $productSQL = oci_parse($objConnect, "SELECT 
                                    ID, 
                                    REF_CODE, 
                                    ENG_NO, 
                                    CHS_NO, 
                                    REG_NO, 
                                    BOOK_VALUE, 
                                    DISPLAY_PRICE, 
                                    GRADE, 
                                    DEPO_LOCATION, 
                                    BRAND_ID, 
                                    CATEGORY, 
                                    MODEL, 
                                    INVOICE_STATUS, 
                                    BOOKED_STATUS, 
                                    PRODUCT_BID_ID, 
                                    BODY_SIT, 
                                    COLOR, 
                                    FUEL_TYPE,
                                    PIC_URL
                                FROM PRODUCT
                                WHERE PUBLISHED_STATUS ='N'");

                        oci_execute($productSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                        <?php echo $number; ?>
                                    </strong>
                                </td>
                               
                                <td>
                                    <?php
                                    echo '<a href="' . $basePath . '/resale_module/view/self_panel/edit.php?id=' . $row['ID'] . '&amp;&amp;actionType=edit" disabled class="btn btn-sm btn-warning float-right"> <i class="bx bx-edit-alt me-1"></i></a>';
                                    ?>
                                </td>
                                <td>
                                    <?php echo $row['DISPLAY_PRICE']; ?>
                                </td>
                                <td>
                                    <?php echo $row['REF_CODE']; ?>
                                </td>
                                <td>
                                    <?php echo $row['MODEL']; ?>
                                </td>
                                <td>
                                    <?php echo $row['ENG_NO']; ?>
                                </td>
                                <td>
                                    <?php echo $row['CHS_NO']; ?>
                                </td>
                                <td>
                                    <?php echo $row['REG_NO']; ?>
                                </td>
                                <td>
                                    <?php echo $row['COLOR']; ?>
                                </td>

                            </tr>
                            <?php
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

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>