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
                $leftSideName  = 'Role Create';
                $rightSideName = 'Role List';
                $routePath     = '/role_permission/role/index.php';
                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="col-6">

                        <form  method="post"  action="<?php echo ($basePath.'/'.'action/role_permission/role.php'); ?>">
                            <input type="hidden" name="formType" value="create">
                            <!-- <input type="hidden" name="_token" value="<?  bin2hex(random_bytes(32)) ?>"> -->
                            <div class="mb-3">
                                <label class="form-label" for="name"> Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Role Name.." >
                                <small class="text-danger"></small>
                            </div>

                            <div class="b-block text-right">
                              
                            <input type="submit" value="Save" name="submit" class="btn btn-primary">

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>

<?php require_once('../../layouts/footer.php'); ?>
