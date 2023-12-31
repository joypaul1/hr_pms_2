<?php
$v_page        = 'role_permission';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../helper/2step_com_conn.php');




// Initialize an empty array
$dataArray = array();
$roleWisepermission = array();
$tableName = 'tbl_roles_permissions';
$num_per_page = 10;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $num_per_page;
// $sql        = "SELECT * FROM $tableName limit $start_from,$num_per_page"; //  select query execution


// $sql  = "SELECT r.name AS role_name, r.id AS role_id, GROUP_CONCAT(p.name) AS permissions
// FROM tbl_roles AS r
// INNER  JOIN tbl_roles_permissions AS rp ON r.id = rp.role_id
// LEFT  JOIN tbl_permissions AS p ON rp.permission_id = p.id
// GROUP BY role_id";
$sql = "SELECT r.name AS role_name, r.id AS role_id, GROUP_CONCAT(p.name) AS permissions
FROM tbl_roles AS r
LEFT  JOIN tbl_roles_permissions AS rp ON r.id = rp.role_id
LEFT JOIN tbl_permissions AS p ON rp.permission_id = p.id
GROUP BY role_name, role_id;";
$result     = mysqli_query($conn_hr, $sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $roleWisepermission[] = array(
            'role_id' => $row['role_id'],
            'role_name' => $row['role_name'],
            'permissions' => $row['permissions']
        );
    }
}
// print_r( $roleWisepermission);
// die();

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Role & Permission List';
                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->



                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class=" table table-bordered text-center dataTable">
                            <thead>
                                <tr class="text-center">
                                    <th>Id</th>
                                    <th>Role </th>
                                    <th>Action</th>
                                    <th>Permission </th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $si = 1;
                                foreach ($roleWisepermission as $key => $row) {


                                    echo "<tr>";
                                    echo "<td>" . $si++ . "</td>";
                                    
                                    echo "<td>" . $row['role_name'] . "</td>";
                                    echo "<td>";
                                    if (checkPermission('role-permission-edit')) {

                                    echo '<a  href="edit.php?id=' . $row['role_id'] . '&amp;&amp;actionType=edit"  class="btn btn-sm btn-secondary flo~at-right"> <i class="bx bx-edit-alt me-1"></i></a>';
                                    // href="edit.php?id=' . $row['role_id'] . '&amp;&amp;actionType=edit" 
                                    }
                                    if (checkPermission('role-permission-delete')) {

                                    echo ' <button data-id="' . $row['role_id'] . '" data-href="' . $basePath . '/' . 'action/role_permission/role_permissions.php" type="button" class="btn btn-sm btn-danger float-right "><i class="bx bx-trash-alt me-1"></i> </button>';
                                    }
                                    // delete_check
                                    echo "</td>";
                                    echo "<td>" . $row['permissions'] . "</td>";
                                    
                                    echo "</tr>";
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-title">


                    <?php
                    // require_once('../../helper/pagination.php');
                    // echo generatePagination($tableName, $page, $num_per_page);

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