<?php
$v_page        = 'role_permission';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../helper/com_conn.php');


$userInfo = [];
$userSql        = "SELECT id,first_name FROM tbl_users WHERE id=" . trim($_GET["id"]); //  select query execution
$useResult     = mysqli_query($conn_hr, $userSql); 
if (mysqli_num_rows($useResult) == 1) {
    while ($row = mysqli_fetch_array($useResult)) {
        $userInfo = array(
            'id' => $row['id'],
            'first_name' => $row['first_name']
        );
    }
} else {
    $message                  = [
        'text'   => "Oops! Something went wrong. Please try again later.",
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    print_r($_SESSION['noti_message']['status']);
    header("location:" . $basePath . "/role_permission/user_role/index.php");
    exit();
}




$roleArray = [];
$userRoleArray = [];

$sql        = "SELECT id,name FROM tbl_roles"; //  select query execution
$perResult     = mysqli_query($conn_hr, $sql);
// Loop through the fetched rows
if ($perResult) {
    while ($row = mysqli_fetch_array($perResult)) {
        $roleArray[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
} else {
    $message                  = [
        'text'   => "Oops! Something went wrong. Please try again later.",
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    print_r($_SESSION['noti_message']['status']);
    header("location:" . $basePath . "/role_permission/user_role/index.php");
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'edit') {

    $sql = "SELECT role_id FROM tbl_users_roles WHERE user_id=" . trim($_GET["id"]); // Prepare a select statement

    $result     = mysqli_query($conn_hr, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $userRoleArray[] = array(
                'role_id' => $row['role_id']
            );
           
        }
    }
} else {
    $message                  = [
        'text'   => "Oops! Something went wrong. Please try again later.",
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    print_r($_SESSION['noti_message']['status']);
    header("location:" . $basePath . "/role_permission/user_role/index.php");
    exit();
}
//  print_r($userRoleArray);
//  die();
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
                $routePath     = 'role_permission/user_role/index.php';
                include('../../layouts/_tableHeader.php');

                ?>

                <!-- End table  header -->
                <div class="card-body">

                    <div class="col-12">
                        <form method="POST" action="<?php echo ($basePath . '/action/role_permission/user_role.php?editID=' . trim($_GET["id"])); ?>">
                            <input type="hidden" name="actionType" value="update">
                            <input type="hidden" name="editId" value="<?php echo  $data['id'] ?>">
                            <div class="row mb-3">

                                <div class="col-md-3">
                                    <label for="name" class="col-12 col-form-label text-md-center">Role</label>
                                    <hr>
                                    <i class="menu-icon tf-icons bx bx-right-arrow"></i> <?php echo($userInfo['first_name']) ?>


                                </div>
                                <div class="col-md-9">
                                    <label for="name" class="col-12 col-form-label text-md-center">All
                                        Permission</label>
                                    <hr>
                                    <?php

                                    foreach ($roleArray as $key => $row) {
                                        echo '<div class="form-check-inline col-4">
                                                    <input class="form-check-input" type="checkbox" name="role_id[]" ' .
                                            (in_array($row["id"], array_column($userRoleArray, 'role_id')) ? 'checked' : '') . '
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

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>

<?php require_once('../../layouts/footer.php'); ?>