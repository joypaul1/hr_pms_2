<?php
$v_page        = 'user_role';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../helper/2step_com_conn.php');


// Initialize an empty array
$dataArray = array();

$num_per_page = 10;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $num_per_page;
// Retrieve user-wise roles
$sql = "SELECT u.id as u_id, u.first_name as u_name,  GROUP_CONCAT(r.name) AS roles
        FROM tbl_users u
        LEFT JOIN tbl_users_roles ur ON u.id = ur.user_id
        LEFT JOIN tbl_roles r ON ur.role_id = r.id
        GROUP BY u.id, u.first_name";
$result = $conn_hr->query($sql);
if ($result) {
    // Process the query result
    while ($row = $result->fetch_assoc()) {
        // Access the retrieved data
        $dataArray[] = [
            'u_id' => $row['u_id'],
            'u_name' => $row['u_name'],
            'roles' => $row['roles'],

        ];
        // echo "User ID: " . $row["u_id"] . ", Username: " . $row["u_name"] . ", Role Name: " . $row["roles"] . "<br>";
    }
} else {
    echo "Error executing query: " . $conn_hr->error;
}


?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'User Role List';
                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->



                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class=" table table-bordered text-center dataTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>User Name</th>
                                    <th>Role Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php

                                foreach ($dataArray as $key => $row) {

                                    echo "<tr>";
                                    echo "<td>" .  $key + 1 . "</td>";
                                    echo "<td>" . $row['u_name'] . "</td>";
                                    echo "<td>" . $row['roles'] . "</td>";
                                    echo "<td>";
                                    if (checkPermission('user-role-edit')) {
                                        echo '<a href="' . $basePath . '/role_permission/user_role/edit.php?id=' . $row['u_id'] . '&amp;&amp;actionType=edit" class="btn btn-sm btn-secondary flo~at-right"> <i class="bx bx-edit-alt me-1"></i></a>';
                                    }
                                    if (checkPermission('user-role-delete')) {
                                        echo ' <button data-id="' . $row['u_id'] . '" data-href="' . $basePath . '/' . 'action/role_permission/user_role.php" type="button" class="btn btn-sm btn-danger float-right delete_check"><i class="bx bx-trash-alt me-1"></i> </button>';
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