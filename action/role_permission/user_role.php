<?php
header('Content-type: application/json; charset=UTF-8');

require_once('../../inc/config.php');

$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$basePath =  $baseUrl . '/rHRT';

session_start();
$response = array();


// Handle Create request
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  trim($_POST["actionType"]) == 'create') {

    $get_role_id = ($_POST["role_id"]);
    $get_permission_id = $_POST['permission_id'];

    if (empty($get_role_id) && count($get_permission_id) > 0) {
        $message = [
            'text' => 'Please Select Role & Permission Data!',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/role_permission/role_permission/create.php");
        exit();
    } else {
        try {
            $conn_hr->begin_transaction();
            $sql = "INSERT INTO  tbl_roles_permissions ( role_id, permission_id) VALUES (?, ?)";
            if ($stmt = mysqli_prepare($conn_hr, $sql)) {

                mysqli_stmt_bind_param($stmt, "ss", $param_role_id, $param_permission_id); // Bind variables to the prepared statement as parameters
                foreach ($get_permission_id as $key => $permission_id) {
                    // Set parameters
                    $param_role_id = $get_role_id;
                    $param_permission_id = $permission_id;
                    // Attempt to execute the prepared statement
                    $result = mysqli_stmt_execute($stmt);
                    if (!$result) {
                        $message = [
                            'text' =>  "Oops! Something went wrong. Please try again later.",
                            'status' => 'false',
                        ];
                        $_SESSION['noti_message'] = $message;
                        header("location:" . $basePath . "/role_permission/role_permission/create.php");
                    }
                }
            }
            mysqli_stmt_close($stmt);  // Close statement
            $conn_hr->commit();
        } catch (Exception $e) {
            $conn_hr->rollback();
            // Handle the exception
            $message = [
                'text' =>   $e->getMessage(),
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/role_permission/role_permission/create.php");
            exit();
        }
    }
    mysqli_close($conn_hr); // Close connection
    $message = [
        'text' => 'Data Created Successfully.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/role_permission/role_permission/index.php");
    exit();
}


// Handle edit request
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  trim($_POST["actionType"]) == 'update') {

    $user_id  = trim($_GET["editID"]);
  
    $deleteID  = [];
    $insertID  = [];
    $getUserWiseRole = getUserWiseRole($conn_hr, $user_id);
    $newRole_id = $_REQUEST['role_id'];
    if(count($_REQUEST['role_id'])> 0){
        $newRole_id = $_REQUEST['role_id'];

    }
    $getUserWiseRole  = array_column($getUserWiseRole, 'role_id');

    $deleteID = array_diff($getUserWiseRole, $newRole_id); // form tbl_user_role
    $insertID = array_diff($newRole_id, $getUserWiseRole); // form tbl_user_role
   
    // Begin the database transaction
    try {
        // $conn_hr->begin_transaction();
        //delete data from database
        if (count($deleteID) > 0) {
            foreach ($deleteID as $key => $roleID) {
                $sql = "DELETE FROM tbl_users_roles  WHERE user_id = $user_id AND role_id = $roleID"; //user role delete    
                $result = $conn_hr->query($sql);
                if ($result) {
                    //delete user role wise permission 
                    $getRoleWisePermission = getRoleWisePermission($conn_hr, $roleID);
                    $getUserWisePermission = getUserWisePermission($conn_hr, $user_id);
                    foreach ($getRoleWisePermission as $key => $permissionData) {
                        $getUserWiseDeletePermission = getUserWiseDeletePermission($conn_hr, $user_id, $permissionData);
                    }
                    //end delete user role wise permission 
                } else {

                    $message = [
                        'text' =>  $conn_hr->error,
                        'status' => 'false',
                    ];
                    $_SESSION['noti_message'] = $message;
                    header("location:" . $basePath . "/role_permission/user_role/index.php");
                }
            }
        }  //end delete data from database

        //insert data from database
        if (count($insertID) > 0) {
            foreach ($insertID as $key => $inID) {
                $sql = "INSERT INTO tbl_users_roles (user_id , role_id)  VALUES  ($user_id , $inID)";
                $result = $conn_hr->query($sql);

                if ($result) {

                    $getRoleWisePermission = getRoleWisePermission($conn_hr, $inID);
                   
                    foreach ($getRoleWisePermission as $key => $permission_id) {

                        // $getUserWiseInsertPermission = getUserWiseInsertPermission($conn_hr, $user_id, $permission_id);
                        $sql = "SELECT * FROM tbl_users_permissions WHERE user_id = $user_id AND permission_id = $permission_id"; //get user wise permission
                        $result     = mysqli_query($conn_hr, $sql);
                    
                        if (mysqli_num_rows($result) == 0) {
                            $sql = "INSERT INTO tbl_users_permissions (user_id , permission_id)  VALUES  ($user_id , $permission_id)"; //user wise permission insert 
                            mysqli_query($conn_hr, $sql);
                        }
                    }
                  
                    //end insert user role wise permission 
                } else {

                    $message = [
                        'text' =>  $conn_hr->error,
                        'status' => 'false',
                    ];
                    $_SESSION['noti_message'] = $message;
                    header("location:" . $basePath . "/role_permission/user_role/edit.php?id=" . $role_id . "&amp;&amp;actionType=edit");
                }
            }
        }  //end insert data from database

        $conn_hr->commit();
    } catch (Exception $e) {
        // $conn_hr->rollback();
        // echo 'An error occurred: ' . $e->getMessage();  // Handle the exception
        $message = [
            'text' => $e->getMessage(),
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" . $basePath . "/role_permission/user_role/index.php");
    }
    // $conn_hr->close();
    $message = [
        'text' => 'Data Updated Successfully.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/role_permission/user_role/index.php");
    exit();
}

if (($_GET["deleteID"])) {

    // Prepare a delete statement
    $sql = "DELETE FROM tbl_roles_permissions WHERE id = ?";


    if ($stmt = mysqli_prepare($conn_hr, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = intval($_GET['deleteID']);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {

            $response['status']  = 'success';
            $response['message'] = 'Deleted Successfully1111 ...';
            echo json_encode($response);
            exit();
        } else {
            $response['status']  = 'error';
            $response['message'] = 'Something went wrong! Please try again';
            echo json_encode($response);
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn_hr);
} else {
    // Check existence of id parameter
    if (empty(trim($_GET["deleteID"]))) {
        // URL doesn't contain id parameter. Redirect to error page
        $response['status']  = 'error';
        $response['message'] = "URL doesn't contain id parameter!";
        echo json_encode($response);
        header("location:" . $basePath . "/role_permission/user_role/index.php");
        exit();
    }
}



function getUserWiseRole($conn_hr, $user_id)
{
    $userRoleArray = [];
    // $sql        = "SELECT * FROM tbl_roles_permissions Where role_id =" . $role_id; 
    $sql = "SELECT role_id FROM tbl_users_roles WHERE user_id=" . $user_id; //  select query execution
    $perResult     = mysqli_query($conn_hr, $sql);
    // Loop through the fetched rows
    if ($perResult) {
        while ($row = mysqli_fetch_array($perResult)) {
            $userRoleArray[] = array(
                'role_id' => $row['role_id'],
            );
        }
    }
    return $userRoleArray;
}

function getRoleWisePermission($conn_hr, $role_id)
{
    $permissionArray = [];
    $sql        = "SELECT * FROM tbl_roles_permissions Where role_id =" . $role_id; //  select query execution
    $perResult     = mysqli_query($conn_hr, $sql);
    // Loop through the fetched rows
    if ($perResult) {
        while ($row = mysqli_fetch_array($perResult)) {
            $permissionArray[] = array(
                'permission_id' => $row['permission_id']
            );
        }
    }
    return   $permissionArray = array_column($permissionArray, 'permission_id');
}
function getUserWisePermission($conn_hr, $user_id)
{

    $permissionArray = [];
    $sql        = "SELECT * FROM tbl_users_permissions  Where user_id=" . $user_id; //  select query execution
    $perResult     = mysqli_query($conn_hr, $sql);
    // Loop through the fetched rows
    if ($perResult) {
        while ($row = mysqli_fetch_array($perResult)) {
            $permissionArray[] = array(
                'permission_id' => $row['permission_id']
            );
        }
    }
    return $permissionArray = array_column($permissionArray, 'permission_id');
}
function getUserWiseDeletePermission($conn_hr, $user_id, $permission_id)
{
    global $basePath;

    $sql = "SELECT * FROM tbl_users_permissions WHERE user_id = $user_id AND permission_id = $permission_id"; //user role delete 
    $result     = mysqli_query($conn_hr, $sql);
    if (mysqli_num_rows($result) > 0) {
        $sql = "DELETE FROM tbl_users_permissions WHERE user_id = $user_id AND permission_id = $permission_id"; //user role delete 
        $perResult     = mysqli_query($conn_hr, $sql);
        if ($perResult != TRUE) {
            $message = [
                'text' =>  $conn_hr->error,
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/role_permission/user_role/index.php");
        }
    }
    return true;
}
function getUserWiseInsertPermission($conn_hr, $user_id, $permission_id)
{

    $sql = "SELECT * FROM tbl_users_permissions WHERE user_id = $user_id AND permission_id = $permission_id"; //get user wise permission
    $result     = mysqli_query($conn_hr, $sql);

    if (mysqli_num_rows($result) == 0) {

        $sql = "INSERT INTO tbl_users_permissions (user_id , permission_id)  VALUES  ($user_id , $permission_id)"; //user wise permission insert 
        mysqli_query($conn_hr, $sql);
    }
    return true;
   
}
