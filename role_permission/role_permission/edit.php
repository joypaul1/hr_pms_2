<?php
$v_page        = 'role_permission';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../helper/2step_com_conn.php');



$roleData = [];
$roleWisepermission = [];
$permissionArray = [];
$permissionSql        =
    "SELECT p.permission_module_id, pm.name AS permission_module_name, GROUP_CONCAT(p.id) AS ids, GROUP_CONCAT(p.name) AS names
    FROM tbl_permissions p
    JOIN tbl_permission_module pm ON p.permission_module_id = pm.id
    GROUP BY p.permission_module_id, pm.name"; //  select query execution

$perResult     = mysqli_query($conn_hr, $permissionSql);
// Loop through the fetched rows
if ($perResult) {
    while ($row = mysqli_fetch_array($perResult)) {

        $permission_data = [
            "permission_module_id" => $row['permission_module_id'],
            "permission_module_name" => $row['permission_module_name'],
            "ids" => explode(",", $row['ids']),
            "names" => explode(",", $row['names'])
        ];
        $permissionArray[] = $permission_data;
    }
}

$roleSql        = "SELECT id,name FROM tbl_roles Where id=" . trim($_GET["id"]); //  select query execution
$roleResult     = mysqli_query($conn_hr, $roleSql);
// Loop through the fetched rows
if ($roleResult) {
    while ($row = mysqli_fetch_assoc($roleResult)) {
        $roleData = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'edit') {

    $sql = "SELECT r.id AS role_id, r.name AS role_name, p.id AS permission_id
    FROM tbl_roles AS r
    JOIN tbl_roles_permissions AS rp ON r.id = rp.role_id
    JOIN tbl_permissions AS p ON rp.permission_id = p.id
    WHERE r.id =?"; // Prepare a select statement
    if ($stmt = mysqli_prepare($conn_hr, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id); // Bind variables to the prepared statement as parameters
        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $roleWisepermission[] = array(
                        // 'role_name' => $row['role_name'],
                        // 'role_id' => $row['role_id'],
                        'permission_id' => $row['permission_id']
                    );
                }
            }
        } else {
            $message                  = [
                'text'   => "Oops! Something went wrong. Please try again later.",
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;

            header("location:" . $basePath . "/role_permission/role_permission/index.php");
        }


        // Close connection

    }
} else {
    $message                  = [
        'text'   => "Oops! Something went wrong. Please try again later.",
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    print_r($_SESSION['noti_message']['status']);
    header("location:" . $basePath . "/role_permission/role_permission/index.php");
    exit();
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
                $leftSideName  = 'Role & Permission Edit';
                $rightSideName = 'Role & Permission List';
                $routePath     = 'role_permission/role_permission/index.php';
                include('../../layouts/_tableHeader.php');

                ?>

                <!-- End table  header -->
                <div class="card-body">

                    <div class="col-12">
                        <form method="POST" action="<?php echo ($basePath . '/action/role_permission/role_permission.php?editID=' . trim($_GET["id"])); ?>">
                            <input type="hidden" name="actionType" value="update">
                            <input type="hidden" name="editId" value="<?php echo  $data['id'] ?>">
                            <div class="row mb-3">

                                <div class="col-md-3">
                                    <label for="name" class="col-12 col-form-label text-md-center">Role</label>
                                    <hr>
                                    <i class="menu-icon tf-icons bx bx-right-arrow"></i> <?php print_r($roleData['name']) ?>


                                </div>
                                <div class="col-md-9">
                                    <div class="">
                                        <label for="name" class="col-12 col-form-label text-md-center">All Permission

                                            <span> <input type="checkbox" onclick="checkAll(this);"> Check All</span>

                                        </label>

                                    </div>
                                    <hr>

                                    <!-- <fieldset>
                                        <legend>What is Your Favorite Pet?</legend>
                                        <input type="checkbox" name="favorite_pet" value="Cats">Cats<br>
                                        <input type="checkbox" name="favorite_pet" value="Dogs">Dogs<br>
                                        <input type="checkbox" name="favorite_pet" value="Birds">Birds<br>
                                        <br>
                                        <input type="submit" value="Submit now">
                                    </fieldset> -->

                                    <!-- //           echo '<div class="form-check-inline col-4">
                                    //           <input class="form-check-input" type="checkbox" name="permission_id[]" '
                                    //   . (in_array($row["id"], array_column($roleWisepermission, 'permission_id')) ? 'checked' : '') . '
                                    //           id="checkbox1' . $row['id'] . '" value="' . $row['id'] . '">
                                    //           <label class="form-check-label" for="checkbox1' . $row['id'] . '">' . $row['name'] . '</label>
                                    //       </div>'; -->
                                    <?php
                                    foreach ($permissionArray as $key => $row) {

                                        echo '<div style="
                                        border: 1px solid #eee5e5;
                                        padding: 2%;
                                        box-shadow: 1px 1px 1px 1px lightgray;
                                        margin: 2%;
                                    ">
                                        <h5 class="text-center"> <i class="menu-icon tf-icons bx bx-star m-0 text-info"></i> ' . $row['permission_module_name'] . ' <span style="font-size: 12px;"> <input type="checkbox" onclick="checkdivArea($(this));"> ALL CHECK?</span></h5> ';
                                        foreach ($row['ids'] as $keyId => $dataId) {
                                            echo '<div class="form-check-inline col-5">
                                            <input type="checkbox" class="form-check-input" 
                                            '. (in_array($dataId, array_column($roleWisepermission, 'permission_id')) ? 'checked' : '') . '
                                            value ="'.$dataId.'"
                                            name="permission_id[]"  id="check_' . $dataId . '">
                                            <label class="form-check-label" for="check_' . $dataId . '">' . $row['names'][$keyId] . '</label>
                                            </div>';
                                        }


                                        echo '</div>';
                                    }


                                    ?>
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="d-block text-right">
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


<script>
    function checkAll(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
    function checkdivArea(here) {
        var checkboxes =(here.parents('h5').parent().find('input[type="checkbox"]'))
    //    for (var i = 0; i < checkboxes.length; i++) {
            // checkboxes[i].checked = source.checked;
        // }
    }
</script>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>

<?php require_once('../../layouts/footer.php'); ?>