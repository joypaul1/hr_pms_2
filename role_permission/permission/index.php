<?php

$v_page        = 'permission';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../helper/2step_com_conn.php');



// Initialize an empty array
$dataArray = array();
$tableName = 'tbl_permissions';
$num_per_page = 100;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $num_per_page;
$sql = "SELECT p.id, p.name, p.slug, m.name as permission_module
FROM tbl_permissions p
LEFT JOIN tbl_permission_module m ON p.permission_module_id = m.id";
// $sql        = "SELECT * FROM tbl_permissions RIGHT Join tbl_permission_module as pm ON  tbl_permissions.permission_module_id = pm.id "; //  select query execution
$result     = mysqli_query($conn_hr, $sql);
// Loop through the fetched rows
while ($row = mysqli_fetch_array($result)) {
    $dataArray[] = $row; // Append the row data to the array
}
// print_r($dataArray[0]['permission_name']);
// die();
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Permissions List';
                // if (checkPermission('permission-create')) {
                    $rightSideName = 'Permissions Create';
                    $routePath     = 'role_permission/permission/create.php';
                // }

                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class=" table table-bordered text-center dataTable">
                            <thead>
                                <tr class="text-center">
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>permission_module</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($dataArray as $key => $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['slug'] . "</td>";
                                    echo "<td>" . $row['permission_module'] . "</td>";
                                    echo "<td>";
                                    if (checkPermission('permission-edit')) {
                                        echo '<a  class="btn btn-sm btn-secondary flo~at-right"> <i class="bx bx-edit-alt me-1"></i></a>';
                                        // href="' . $basePath . '/role_permission/permission/edit.php?id=' . $row['id'] . '&amp;&amp;actionType=edit"
                                    }
                                    if (checkPermission('permission-delete')) {
                                        echo ' <button data-id="' . $row['id'] . '" data-href="' . $basePath . '/' . 'action/role_permission/permission.php" type="button" class="btn btn-sm btn-danger float-right "><i class="bx bx-trash-alt me-1"></i> </button>';
                                        // delete_check
                                    }
                                    echo "</tr>";
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-title">

                    <?php
                    require_once('../../helper/pagination.php');
                    echo generatePagination($tableName, $page, $num_per_page);

                    mysqli_close($conn_hr)
                    ?>
                </div>
            </div>
        </div>
    </div>



</div>


<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>
<script>
    //delete data processing
    $(document).on('click', '.delete_check', function() {
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
                    .done(function(response) {
                        console.log(response);
                        swal.fire('Deleted!', response.message, response.status);
                        location.reload(); // Reload the page
                    })
                    .fail(function() {
                        swal.fire('Oops...', 'Something went wrong!', 'error');
                    });

            }

        })

    });
</script>