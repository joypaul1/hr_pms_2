<?php
$v_page        = 'role_permission';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../helper/com_conn.php');



$roleWisepermission = [];
$roleArray = [];
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
}



if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'edit') {

    $sql = "SELECT role_id FROM tbl_users_roles WHERE user_id=".trim($_GET["id"]); // Prepare a select statement


    $result     = mysqli_query($conn_hr, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            print_r($row);
            $roleArray[] = array(
                'role_id' => $row['role_id']
            );
            print_r($roleArray);
            die();
        }
   
    }
    die();

    if ($stmt = mysqli_prepare($conn_hr, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id); // Bind variables to the prepared statement as parameters
        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $roleWisepermission[] = array(
                        'role_name' => $row['role_name'],
                        'role_id' => $row['role_id'],
                        'permission_id' => $row['permission_id']
                    );
                }
                // print_r($roleWisepermission);

            } else {
                // URL doesn't contain valid id parameter. Redirect to role_permission index page
                $message                  = [
                    'text'   => "URL doesn't contain valid id parameter.",
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;

                header("location:" . $basePath . "/role_permission/user_role/index.php");
                exit();
            }
        } else {
            $message                  = [
                'text'   => "Oops! Something went wrong. Please try again later.",
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;

            header("location:" . $basePath . "/role_permission/user_role/index.php");
        }
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn_hr);
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
                        <form method="POST" action="<?php echo ($basePath . '/action/role_permission/role_permission.php?editID=' . trim($_GET["id"])); ?>">
                            <input type="hidden" name="actionType" value="update">
                            <input type="hidden" name="editId" value="<?php echo  $data['id'] ?>">
                            <div class="row mb-3">

                                <div class="col-md-3">
                                    <label for="name" class="col-12 col-form-label text-md-center">Role</label>
                                    <hr>
                                    <i class="menu-icon tf-icons bx bx-right-arrow"></i> <?php print_r($roleWisepermission[0]['role_name']) ?>


                                </div>
                                <div class="col-md-9">
                                    <label for="name" class="col-12 col-form-label text-md-center">All
                                        Permission</label>
                                    <hr>
                                    <?php

                                    foreach ($roleArray as $key => $row) {
                                        echo '<div class="form-check-inline col-4">
                                                    <input class="form-check-input" type="checkbox" name="permission_id[]" ' .
                                            (in_array($row["id"], array_column($roleWisepermission, 'permission_id')) ? 'checked' : '') . '
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