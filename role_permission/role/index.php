<?php
session_start();
session_regenerate_id(TRUE);


require_once('../../inc/config.php');
require_once('../../layouts/header.php');

$v_page        = 'rmwl_leave';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../layouts/left_menu.php');
require_once('../../layouts/top_menu.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

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
                    $routePath     = '/role_permission/role/create.php';
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
                            <tr>
                                <td>1</td>
                                <td>Public</td>
                                <td>public</td>
                                <td>
                                    <a href="http://192.168.172.61:8082/role/7/edit" class="btn btn-sm btn-secondary float-right">
                                        <i class="bx bx-edit-alt me-1"></i>
                                    </a>
                                    <button data-href="http://192.168.172.61:8082/role/7" type="button"
                                        class="btn btn-sm btn-danger float-right delete_check">
                                        <i class="bx bx-trash-alt me-1"></i>
                                    </button>
                                </td>

                            </tr>

                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>