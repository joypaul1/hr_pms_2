<?php
session_start();
session_regenerate_id(TRUE);

require_once('../../layouts/header.php');

$v_page        = 'permission';
$v_active_open = 'active open';
$v_active      = 'active';
require_once('../../inc/config.php'); // Include config file
require_once('../../layouts/left_menu.php');
require_once('../../layouts/top_menu.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

// Initialize an empty array
$dataArray = array();
$sql       = "SELECT * FROM tbl_permissions"; //  select query execution
$result    = mysqli_query($conn_hr, $sql);
// Loop through the fetched rows
while ($row = mysqli_fetch_array($result)) {
    $dataArray[] = $row; // Append the row data to the array
}

mysqli_close($conn_hr);

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Permissions List';
                $rightSideName = 'Permissions Create';
                $routePath     = '/role_permission/permission/create.php';
                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->



                <div class="card-body">
                    <div class="table-responsive text-nowrap" "="">
                    <table class=" table table-bordered text-center dataTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Slug</th>
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
                                echo "<td>";
                                echo '<a href="' . $basePath . '/role_permission/permission/edit.php?id=' . $row['id'] . '&amp;&amp;actionType=edit" class="btn btn-sm btn-secondary flo~at-right"> <i class="bx bx-edit-alt me-1"></i></a>';
                                echo ' <button data-id="' . $row['id'] . '" data-href="' . $basePath . '/' . 'action/role_permission/permission.php" type="button" class="btn btn-sm btn-danger float-right delete_check"><i class="bx bx-trash-alt me-1"></i> </button>';
                                echo "</tr>";
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

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>
<script>
    $(document).on('click', '.delete_check', function() {
        var id = $(this).data('id');
        let url = $(this).data('href');
        console.log(url);
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
                        location.reload();// Reload the page
                    })
                    .fail(function() {
                        swal.fire('Oops...', 'Something went wrong!', 'error');
                    });

            }

        })

    });
</script>