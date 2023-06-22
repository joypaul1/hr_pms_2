<?php
$v_page        = 'role';
$v_active_open = 'active open';
$v_active      = 'active';
require_once('../../helper/2step_com_conn.php');

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
                $routePath     = 'role_permission/role/index.php';
                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="col-6">

                        <form  method="post"  action="<?php echo ($basePath.'/'.'action/role_permission/role.php'); ?>">
                            <input type="hidden" name="actionType" value="create">
                         
                            <div class="mb-3">
                                <label class="form-label" for="name"> Name</label>
                                <input type="text" name="name" class="form-control" id="name" required placeholder="Role Name.." >
                              
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
