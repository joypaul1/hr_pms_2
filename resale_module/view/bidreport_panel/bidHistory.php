<?php

require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('resale-report-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->
<div class="container-xxl flex-grow-1 container-p-y" <!-- Bordered Table -->
    <div class="card mt-2">
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
                            <th scope="col"> BID REF.</th>
                            <th scope="col"> ENTRY DATE</th>
                            <th scope="col">Action </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $productID = $_GET['id'];

                        // $productSQL = oci_parse($objConnect, "SELECT
                        //     BB.USER_NAME,BB.USER_MOBILE,BB.ADDRESS,AA.ID as BID_ID,
                        //     AA.USER_ID,AA.PRODUCT_ID,AA.BOOKED_STATUS,AA.BID_AMOUNT,AA.ENTRY_DATE,
                        //     AA.BID_PRICE_TYPE,AA.REFERENCE_TYPE, AA.RESALE_TEAM_ID
                        //  FROM 
                        //     ( A.ID,A.USER_ID,A.PRODUCT_ID,A.BOOKED_STATUS,A.BID_AMOUNT,A.ENTRY_DATE,
                        //     A.BID_PRICE_TYPE,A.REFERENCE_TYPE, A.RESALE_TEAM_ID
                        //     FROM PRODUCT_BID A
                        //     WHERE PRODUCT_ID=$productID
                        //     ORDER BY BID_AMOUNT DESC ) AA,USER_PROFILE BB
                        //     WHERE AA.USER_ID=BB.ID");
                        $productSQL = oci_parse($objConnect, "SELECT 
                                        BB.USER_NAME, BB.USER_MOBILE, BB.ADDRESS, AA.ID as BID_ID, AA.USER_ID, 
                                        AA.PRODUCT_ID, AA.BOOKED_STATUS, AA.BID_AMOUNT, AA.ENTRY_DATE, 
                                        AA.BID_PRICE_TYPE, AA.REFERENCE_TYPE, AA.RESALE_TEAM_ID, AA.INVOICE_STATUS
                                    FROM 
                                        (SELECT 
                                            A.ID, A.USER_ID, A.PRODUCT_ID, A.BOOKED_STATUS, A.BID_AMOUNT, 
                                            A.ENTRY_DATE, A.BID_PRICE_TYPE, A.REFERENCE_TYPE, A.RESALE_TEAM_ID,
                                            P.INVOICE_STATUS
                                        FROM 
                                            PRODUCT_BID A
                                        JOIN PRODUCT P ON A.PRODUCT_ID = P.ID 
                                        WHERE 
                                            A.PRODUCT_ID = $productID
                                        ORDER BY 
                                            A.BID_AMOUNT DESC) AA
                                            
                                    JOIN  USER_PROFILE BB ON AA.USER_ID = BB.ID");

                        oci_execute($productSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($productSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <input type="hidden" id="INVOICE_STATUS" value="<?php echo $row['INVOICE_STATUS'] ?>">
                                <td>
                                    <strong>
                                        <?php echo $number; ?>
                                        (
                                        <?php echo $row['BID_ID'] ?>)
                                    </strong>
                                </td>
                                <td>
                                    <strong>CUSTOMER NAME :</strong>
                                    <?php echo ($row['USER_NAME']); ?> </br>
                                    <strong>MOBILE NO :</strong>

                                    <?php echo ($row['USER_MOBILE']); ?> </br>
                                    <strong>ADDRESS :</strong>
                                    <?php echo ($row['ADDRESS']); ?>
                                </td>

                                <td class="text-right">
                                    <?php echo number_format($row['BID_AMOUNT']) ?>
                                    <br>
                                    BID FOR :
                                    <?php echo ($row['BID_PRICE_TYPE']) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo ucwords(str_replace('_', ' ', ($row['REFERENCE_TYPE']))) ?>
                                </td>
                                <td class="text-right">
                                    <?php echo ($row['ENTRY_DATE']) ?>
                                </td>


                                <td class="text-center">

                                    <?php
                                    if ($row['BOOKED_STATUS'] == 'Y') {
                                        echo '<button style="margin-bottom:2%" data-bid-id="' . $row['BID_ID'] . '" data-product-id="' . $productID . '" data-status="N"
                                        data-href="' . ($basePath . '/resale_module/action/self_panel.php?actionType=bidConfirm') . '"
                                        type="button" class="btn btn-sm btn-info float-right bid_looked"><i class="bx bx-check"></i> Bid Looked </button> </br>';

                                        if ($row['INVOICE_STATUS'] != 'Y') {
                                            echo '<button data-bid-id="' . $row['BID_ID'] . '" data-product-id="' . $productID . '" data-status="Y"
                                            data-href="' . ($basePath . '/resale_module/action/self_panel.php?  actionType=invoiceConfirm') . '"
                                            type="button" class="btn btn-sm btn-warning float-right     invocie_looked"> Customer Confirm <i class="bx bx-question-mark"></i> </button>';
                                        }
                                        else {
                                            echo '<button  type="button" class="btn btn-sm btn-warning float-right">
                                            <i class="bx bx-check"></i>  Customer Confirm </button>';
                                        }

                                    }
                                    else {
                                        echo '<button data-bid-id="' . $row['BID_ID'] . '" data-product-id="' . $productID . '"  data-status="Y"
                                        data-href="' . ($basePath . '/resale_module/action/self_panel.php?actionType=invoiceConfirm') . '"
                                        type="button" class="btn btn-sm btn-danger float-right bid_looked"><i class="bx bx-question-mark"></i> </button>';
                                    }
                                    ?>


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
    $(document).ready(function () {
        var $INVOICE_STATUS = $('#INVOICE_STATUS').val();
        if ($INVOICE_STATUS == 'Y') {
            $("button").attr("disabled", "disabled");;
        }
    });

    $(document).on('click', '.bid_looked', function () {
        var bid_id = $(this).data('bid-id');
        var status = $(this).data('status');
        var product_id = $(this).data('product-id');
        let url = $(this).data('href');
        if (status == 'Y') {
            swal.fire({
                title: 'Are you sure looked this Bid?',
                // text: "You won't be able to revert this!",
                icon: 'success',
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
                            bid_id: bid_id,
                            status: status,
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
            // console.log(status);
        } else {
            swal.fire({
                title: 'Are you sure unlooked this Bid?',
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
                            bid_id: bid_id,
                            status: status,
                        },
                        dataType: 'json'
                    })
                        .done(function (res) {
                            if (res.status) {
                                swal.fire('Bid UnLooked!', res.message, res.status);
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
        }


    });

    $(document).on('click', '.invocie_looked', function () {
        var bid_id = $(this).data('bid-id');
        var product_id = $(this).data('product-id');
        let url = $(this).data('href');
        var status = $(this).data('status');
        swal.fire({
            title: 'Are you sure looked this Bid for Invoice?',
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
                        bid_id: bid_id,
                        status: status,
                    },
                    dataType: 'json'
                })
                    .done(function (res) {
                        if (res.status) {
                            swal.fire('Customer Confirm!', res.message, res.status);
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

        });


    });
</script>