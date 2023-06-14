<?php
session_start();
session_regenerate_id(TRUE);

require_once('../../layouts/header.php');

$v_page        = 'role';
$v_active_open = 'active open';
$v_active      = 'active';
require_once('../../inc/config.php'); // Include config file
require_once('../../layouts/left_menu.php');
require_once('../../layouts/top_menu.php');

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

// Initialize an empty array
$dataArray = array();

$num_per_page = 01;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $num_per_page;
$sql       = "SELECT * FROM tbl_roles limit $start_from,$num_per_page"; //  select query execution
$result    = mysqli_query($conn_hr, $sql);
// Loop through the fetched rows
while ($row = mysqli_fetch_array($result)) {
    $dataArray[] = $row; // Append the row data to the array
}

//;

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Role List';
                $rightSideName = 'Role Create';
                $routePath     = 'role_permission/role/create.php';
                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->



                <div class="card-body">
                    <div class="table-responsive text-nowrap">
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
                                    echo '<a href="' . $basePath . '/role_permission/role/edit.php?id=' . $row['id'] . '&amp;&amp;actionType=edit" class="btn btn-sm btn-secondary flo~at-right"> <i class="bx bx-edit-alt me-1"></i></a>';
                                    echo ' <button data-id="' . $row['id'] . '" data-href="' . $basePath . '/' . 'action/role_permission/role.php" type="button" class="btn btn-sm btn-danger float-right delete_check"><i class="bx bx-trash-alt me-1"></i> </button>';
                                    echo "</tr>";
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-title">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-center">

                            <?php
                            $sql       = "SELECT * FROM tbl_roles"; //  select query execution
                            $result    = mysqli_query($conn_hr, $sql);
                            $total_record = mysqli_num_rows($result);
                            $total_page = ceil($total_record / $num_per_page);
                           

                            if ($page > 1) {
                                echo " <li class='page-item'><a href='".$basePath . '/' . $routePath."?page=" . ($page - 1) . "' class='page-link'>Previous</a></li>";
                                // echo "<a  class='btn btn-danger'>Previous</a>";
                            }

                            // echo($total_page);
                            for ($i = 1; $i < $total_page; $i++) {
                                echo (" <li class='page-item active'>
                                        <a href='index.php?page=" . $i . "' class='page-link'>
                                        $i
                                        </a>
                                    </li>");
                            }

                            if ($i > $page) {
                                echo " <li class='page-item'><a href='".$basePath . '/' . $routePath."?page=" . ($page + 1) . "' class='page-link'>Next</a></li>";
                            }
                            mysqli_close($conn_hr)
                            ?>
                            <!-- <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li> -->

                            <!-- <li class='page-item active'>
                                <span class='page-link'>
                                    2
                                </span>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li> -->
                        </ul>
                    </nav>

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
                        location.reload(); // Reload the page
                    })
                    .fail(function() {
                        swal.fire('Oops...', 'Something went wrong!', 'error');
                    });

            }

        })

    });
</script>