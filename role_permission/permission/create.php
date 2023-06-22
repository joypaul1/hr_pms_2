<?php

$v_page        = 'permission';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../helper/2step_com_conn.php');

$perModule = [];
// SQL QUERY
$query = "SELECT id,name FROM `tbl_permission_module`;";
  
// FETCHING DATA FROM DATABASE
$result = $conn_hr->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc())
    {
        $perModule[]=array(
            'id' =>$row["id"],
            'name' => $row['name']
        );
    }
}

?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Permissions Create';
                $rightSideName = 'Permissions List';
                $routePath     = 'role_permission/permission/index.php';
                include('../../layouts/_tableHeader.php');

                ?>
                <!-- End table  header -->

                <div class="card-body">
                    <div class="col-6">

                        <form  method="post"  action="<?php echo ($basePath.'/'.'action/role_permission/permission.php'); ?>">
                            <input type="hidden" name="actionType" value="create">
                         
                            <div class="mb-3">
                                <label class="form-label" for="option"> Permission Module</label>
                                <select class ="form-control" id="option" name="permission_module_id" reqired>
                                    <option hidden> <-- Select Permission Module --></option> 
                                    <?php 
                                        foreach($perModule as $module){
                                            echo "<option value='".$module['id']."'>".$module['name']."</option>";
                                        }
                                    ?>
                                  
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name"> Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Permissions Name.." required>
                            </div>


                            <div class="b-block text-center">
                              
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
