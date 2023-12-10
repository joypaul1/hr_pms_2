<?php
require_once('../../../../helper/4step_com_conn.php');
require_once('../../../../inc/connresaleoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('resale-product-panel')) {
    echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
}
?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Customer Review List';
                $rightSideName = 'Customer Review Create';
                $routePath     = 'resale_module/view/form_panel/customer_review/create.php';
                include('../../../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class=" table table-bordered text-center dataTable">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th>SL.</th>
                                    <th>Action</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $commentSQL = oci_parse($objConnect, "SELECT 
                                    ID, PIC_URL, NAME, 
                                    TYPE, COMMENTS, STATUS, 
                                    SORT_ORDER
                                    FROM CLIENT_COMMENTS");

                                oci_execute($commentSQL);
                                $number = 0;
                                while ($row = oci_fetch_assoc($commentSQL)) {
                                    $number++;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            echo $number;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo '<a href="' . $basePath . '/resale_module/view/form_panel/customer_review/edit.php?id=' . $row['ID'] . '&amp;&amp;actionType=edit" disabled class="btn btn-sm btn-warning float-right"> <i class="bx bx-edit-alt"></i> </a>';
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['NAME'] ?>
                                        </td>
                                        <td>
                                            <img src="<?php echo 'http://202.40.181.98:9090/' . $row['PIC_URL'] ?>" width="100px" alt="">
                                        </td>
                                        <td>
                                            <?php  if($row['STATUS'] == 1){
                                                echo "<span class ='badge bg-success'> Active</span>";
                                            }else{
                                                echo "<span class ='badge bg-warning'> Deactive</span>";
                                            } ?>
                                        </td>
                                        <td>
                                            <?php echo $row['COMMENTS'] ?>
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
        </div>
    </div>



</div>


<!-- / Content -->

<?php require_once('../../../../layouts/footer_info.php'); ?>
<?php require_once('../../../../layouts/footer.php'); ?>
<script>
    //delete data processing

    $(document).on('click', '.delete_check', function () {
        var id = $(this).data('id');
        let url = $(this).data('href');
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
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
                        deleteID: id
                    },
                    dataType: 'json'
                })
                    .done(function (response) {
                        console.log(response);
                        swal.fire('Deleted!', response.message, response.status);
                        location.reload(); // Reload the page
                    })
                    .fail(function () {
                        swal.fire('Oops...', 'Something went wrong!', 'error');
                    });

            }

        })

    });
</script>