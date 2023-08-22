<?php
session_start();
session_regenerate_id(TRUE);

require_once('inc/config.php');
require_once('layouts/header.php');
require_once('layouts/left_menu.php');
require_once('layouts/top_menu.php');
// require_once('inc/config.php');
// require_once('inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
//if (!checkPermission('self-attendance-report')) {
// echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
//}

$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div style="border: 1px solid #eee5e5;padding: 2%;
                                        box-shadow: 1px 1px 1px 1px lightgray;
                                        margin: 2%;
                                    ">
                            <h5 class="text-center"> <i class="menu-icon tf-icons bx bx-star m-0 text-info"></i>User Single Permission </h5>
                            <?php

                            $module_name = 'Form Module';

                            // Get permission_module_id based on module name
                            $moduleQuery = "SELECT id FROM tbl_permission_module WHERE name = '$module_name'";
                            $moduleResult = mysqli_query($conn_hr, $moduleQuery);

                            if ($moduleResult && $moduleRow = mysqli_fetch_assoc($moduleResult)) {
                                $permission_module_id = $moduleRow['id'];
                                // Fetch data from tbl_permissions based on permission_module_id
                                $perSql = "SELECT id,name FROM tbl_permissions WHERE permission_module_id = '$permission_module_id'";
                                $perResult = mysqli_query($conn_hr, $perSql);
                                if ($perResult) {
                                    while ($row = $perResult->fetch_assoc()) {
                                        // print_r($row); // Printing each row of data
                                        echo '<div class="form-check-inline col-5">
                                                <input type="checkbox" class="form-check-input" value="' . $row['id'] . '" name="permission_id[]" id="check_' . $row['name'] . '">
                                                <label class="form-check-label" for="check_' . $row['name'] . '">' . $row['name'] . '</label>
                                            </div>';
                                    }
                                    mysqli_free_result($perResult); // Free the result set
                                } else {
                                    echo "Query execution failed: " . mysqli_error($conn_hr);
                                }
                            } else {
                                echo "Module not found or query execution failed.";
                            }

                            mysqli_free_result($moduleResult);

                            ?>

                        </div>

                    </div>
                    <div class="col-sm-3">
                        <label>RML ID :</label>
                        <div class="input-group">

                            <input required="" class="form-control cust-control" type='text' name='rml_id' value='<?php echo isset($_POST['rml_id']) ? $_POST['rml_id'] : ''; ?>' />

                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                            <input class="form-control  btn  btn-sm  btn-primary" placeholder=" Search" type="submit" value="Submit">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body ">
            <div class="resume-item d-flex flex-column flex-md-row">



                <?php

                if (isset($_POST['rml_id'])) {

                    $rml_id = $_POST['rml_id'];
                    $user_id = null;
                    $userQuery = "SELECT id FROM tbl_users WHERE emp_id = '$rml_id'";
                    $userResult = mysqli_query($conn_hr, $userQuery);

                    if ($userResult) {
                        if (mysqli_num_rows($userResult) > 0) {
                            while ($row = mysqli_fetch_assoc($userResult)) {
                                $user_id = $row['id'];
                            }
                        } else {
                            echo "<p class='text-danger'> User User not found! Please create a user.</p>";
                        }
                        mysqli_free_result($userResult);
                    } else {
                        echo "<p class='text-danger'> Query execution failed:" . mysqli_error($conn_hr) . "</p>";
                    }
                    if ($user_id) {
                        if (isset($_POST['permission_id'])) {

                            foreach ($_POST['permission_id'] as $permission_id) {
                                $upSql = "SELECT * FROM tbl_users_permissions WHERE user_id = $user_id AND permission_id = $permission_id";
                                $upResult     = mysqli_query($conn_hr, $upSql);
                                if (mysqli_num_rows($upResult) == 0) {
                                    $sql = "INSERT INTO tbl_users_permissions (user_id , permission_id)  VALUES  ($user_id , $permission_id)";
                                    mysqli_query($conn_hr, $sql);
                                }
                                // else{
                                //     echo "<p class='text-info'>Already Permission Given this ID :".$permission_id."</p>";

                                // }
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php require_once('layouts/footer_info.php'); ?>
<?php require_once('layouts/footer.php'); ?>