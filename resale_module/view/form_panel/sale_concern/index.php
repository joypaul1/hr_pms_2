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
                $leftSideName = 'Sale Concern List';
                $rightSideName = 'Sale Concern Create';
                $routePath     = 'resale_module/view/form_panel/sale_concern/create.php';
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
                                    <th>Shop Name</th>
                                    <th>Proprietor Name</th>
                                    <th>Location</th>
                                    <!-- <th>Image</th> -->
                                </tr>
                            </thead>

                            <tbody>

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