<?php
session_start();
session_regenerate_id(TRUE);


require_once('../../inc/config.php');
require_once('../../layouts/header.php');

$v_page        = 'role';
$v_active_open = 'active open';
$v_active      = 'active';

require_once('../../layouts/left_menu.php');
require_once('../../layouts/top_menu.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

$data = [];

// Check existence of id parameter before processing further
if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'edit') {

    $sql = "SELECT * FROM tbl_roles WHERE id = ?"; // Prepare a select statement
    if ($stmt = mysqli_prepare($conn_hr, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id); // Bind variables to the prepared statement as parameters
        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            }else {
                // URL doesn't contain valid id parameter. Redirect to role index page
                $message                  = [
                    'text'   => "URL doesn't contain valid id parameter.",
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
              
                header("location:" . $basePath . "/role_permission/role/index.php");
                exit();
            }
        }else {
            $message                  = [
                'text'   => "Oops! Something went wrong. Please try again later.",
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            
            header("location:" . $basePath . "/role_permission/role/index.php");
        }
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn_hr);
    }
}
else {
    $message                  = [
        'text'   => "Oops! Something went wrong. Please try again later.",
        'status' => 'false',
    ];
    $_SESSION['noti_message'] = $message;
    print_r($_SESSION['noti_message']['status']);
    header("location:" . $basePath . "/role_permission/role/index.php");
    exit();
}
// print_r($data['name']);
// die();
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-12">

            <div class="card border-top">
                <!-- table header -->
                <?php
                $leftSideName  = 'Role Edit';
                $rightSideName = 'Role List';
                $routePath     = 'role_permission/role/index.php';
                include('../../layouts/_tableHeader.php');
                
                ?>

                <!-- End table  header -->
                <div class="card-body">
                    <div class="col-6">

                        <form method="post" action="<?php echo ($basePath .'/action/role_permission/role.php?editID='.trim($_GET["id"])); ?>">
                            <input type="hidden" name="actionType" value="update">
                            <input type="hidden" name="editId" value="<?php echo  $data['id'] ?>" >
                            <div class="mb-3">
                                <label class="form-label" for="name"> Name</label>
                                <input type="text" name="name" class="form-control" 
                                value="<?php echo  $data['name'] ?>" required
                                id="name" placeholder="Role Name..">
                                
                            </div>

                            <div class="b-block text-right">

                                <input type="submit" value="update" name="submit" class="btn btn-primary">

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