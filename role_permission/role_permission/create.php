<?php
$v_page        = 'role_permission';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../helper/com_conn.php');


$permissionArray = [];
$roleArray = [];

$sql        = "SELECT id,name FROM tbl_permissions"; //  select query execution
$perResult     = mysqli_query($conn_hr, $sql);
// Loop through the fetched rows
if ($perResult) {
    while ($row = mysqli_fetch_array($perResult)) {
        $permissionArray[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
}
$sql = "SELECT r.* FROM tbl_roles as r LEFT JOIN tbl_roles_permissions  as rp ON r.id = rp.role_id WHERE rp.role_id IS NULL"; //  select query execution
$roleResult     = mysqli_query($conn_hr, $sql);
// Loop through the fetched rows
if ($roleResult) {
    while ($row = mysqli_fetch_array($roleResult)) {
        $roleArray[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
}
// print_r($roleArray);
// die();
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Role & Permission Create';
                $rightSideName = 'Role & Permission List';
                $routePath     = 'role_permission/role_permission/index.php';
                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="card-body">
                        <div class="col-12">
                            <form method="POST" action="<?php echo ($basePath . '/action/role_permission/role_permission.php') ?>">
                                <input type="hidden" name="actionType" value="create">

                                <div class="row mb-3">

                                    <div class="col-md-3">
                                        <label for="name" class="col-12 col-form-label text-md-center">NON Permission Role</label>
                                        <hr>
                                        <!-- -->
                                        <?php
                                        foreach ($roleArray as $key => $row) {
                                            echo ('<div class="form-check-inline col-12">
                                            <input class="form-check-input" type="radio" name="role_id" 
                                            id="role' . $row['id'] . '" value="' . $row['id'] . '">
                                            <label class="form-check-label" for="role' . $row['id'] . '">'. $row['name'] .'</label>
                                            </div>');
                                        }
                                        ?>

                                    </div>
                                    <div class="col-md-9">
                                        <label for="name" class="col-12 col-form-label text-md-center">All
                                            Permission</label>
                                        <hr>
                                        <?php

                                        foreach ($permissionArray as $key => $row) {
                                            echo '<div class="form-check-inline col-4">
                                                    <input class="form-check-input" type="checkbox" name="permission_id[]" 
                                                    id="checkbox1' . $row['id'] . '" value="' . $row['id'] . '">
                                                    <label class="form-check-label" for="checkbox1' . $row['id'] . '">' . $row['name'] . '</label>
                                                </div>';
                                        }


                                        ?>
                                    </div>
                                </div>


                                <div class="row mb-0">
                                    <div class="d-block text-center">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>

<?php require_once('../../layouts/footer.php'); ?>