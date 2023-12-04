<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];

if (!checkPermission('resale-product-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y" <!-- Bordered Table -->
    <div class="card mt-2">
        <!-- <h5 class="card-header "><b>Leave Taken List</b></h5> -->
        <!-- table header -->
        <?php
        $leftSideName = 'Bid History List';
        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table  table-bordered">
                    <thead style="background-color: #0e024efa;">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Bidder Info</th>
                            <th scope="col"> Bid Amount</th>
                            <th scope="col"> ENTRY DATE</th>
                            <th scope="col">Action </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $productID = $_GET['id'];

                        $productSQL = oci_parse($objConnect, "SELECT
                            BB.USER_NAME,BB.USER_MOBILE,BB.ADDRESS,AA.ID as BID_ID,
                            AA.USER_ID,AA.PRODUCT_ID,AA.BOOKED_STATUS,AA.BID_AMOUNT,AA.ENTRY_DATE
                         FROM 
                                (
                                SELECT A.ID,A.USER_ID,A.PRODUCT_ID,A.BOOKED_STATUS,A.BID_AMOUNT,A.ENTRY_DATE
                                FROM PRODUCT_BID A
                                WHERE PRODUCT_ID=$productID
                                ORDER BY BID_AMOUNT DESC
                                ) AA,USER_PROFILE BB
                            WHERE AA.USER_ID=BB.ID");

                        oci_execute($productSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                        <?php echo $number; ?>
                                        (
                                        <?php echo $row['BID_ID'] ?>)
                                    </strong>
                                </td>
                                <td>
                                    <strong>CUSTOMER NAME :</strong>
                                    <?php echo ($row['USER_NAME']); ?> </br>
                                    <strong>MOBILE NO. :</strong>

                                    <?php echo ($row['USER_MOBILE']); ?> </br>
                                    <strong>ADDRESS :</strong>
                                    <?php echo ($row['ADDRESS']); ?>

                                </td>

                                <td class="text-right">
                                    <?php echo number_format($row['BID_AMOUNT']) ?>
                                </td>
                                <td class="text-right">
                                    <?php echo ($row['ENTRY_DATE']) ?>
                                </td>


                                <td class="text-center">
                                    <?php if($row['BOOKED_STATUS'] == 'Y' ){
                                        echo  '<button data-bid-id="'.$row['BID_ID'].'" data-product-id="'. $productID.'"
                                        data-href="'.($basePath . '/resale_module/action/self_panel.php?actionType=bidConfirm') .'"
                                        type="button" class="btn btn-sm btn-success float-right delete_check"><i class="bx bx-check"></i>Looked </button>';
                                    }else{
                                        echo  '<button data-bid-id="'.$row['BID_ID'].'" data-product-id="'. $productID.'"
                                        data-href="'.($basePath . '/resale_module/action/self_panel.php?actionType=bidConfirm') .'"
                                        type="button" class="btn btn-sm btn-danger float-right delete_check"><i class="bx bx-check"></i> </button>';
                                    }?>
                                   

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
<script>
    //delete data processing

    $(document).on('click', '.delete_check', function () {
        var bid_id = $(this).data('bid-id');
        var product_id = $(this).data('product-id');
        let url = $(this).data('href');
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm!',
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        product_id: product_id,
                        bid_id: bid_id
                    },
                    dataType: 'json'
                })
                    .done(function (res) {
                        if (res.status) {
                            swal.fire('Bid Looked!', res.message, res.status);
                            setInterval(function () {
                                location.reload();
                            }, 1000);

                        } else {
                            swal.fire('Oops...', res.message, res.status);

                        }
                    })
                    .fail(function () {
                        swal.fire('Oops...', 'Something went wrong!', 'error');
                    });

            }

        })

    });
</script>