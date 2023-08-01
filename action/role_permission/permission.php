<?php
header('Content-type: application/json; charset=UTF-8');

require_once('../../inc/config.php');

// $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
//  =  $baseUrl . '/rHRT';
$basePath =  $_SESSION['basePath'];

session_start();
$response = array();


// Handle Create request
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  trim($_POST["actionType"]) == 'create') {

    $name = trim($_POST["name"]);

    if (empty($name)) {
        $message = [
            'text' => 'Please input Role Name',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" .  . "/role_permission/permission/create.php");
        exit;
    } else {
        $sql = "INSERT INTO  tbl_permissions ( name, slug, permission_module_id) VALUES (?, ?,?)";

        if ($stmt = mysqli_prepare($conn_hr, $sql)) {

            mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_slug,  $param_permission_module_id); // Bind variables to the prepared statement as parameters

            // Set parameters
            $param_name =  $name;
            $param_permission_module_id = trim($_POST["permission_module_id"]);
            $param_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $param_name)));

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to list page
                $message = [
                    'text' => 'Role Data Insert Successfully.',
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" .  . "/role_permission/permission/index.php");
                exit();
            } else {
                $message = [
                    'text' =>  "Oops! Something went wrong. Please try again later.",
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" .  . "/role_permission/permission/create.php");
            }
        }
        mysqli_stmt_close($stmt);  // Close statement
    }
    mysqli_close($conn_hr); // Close connection
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  trim($_POST["actionType"]) == 'update') {

    $name = trim($_POST["name"]);
    $id  = trim($_GET["editID"]);
    if (empty($name)) {
        $message = [
            'text' => 'Please input Role Name',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        header("location:" .  . "/role_permission/permission/edit.php?id=" . $id . "&amp;&amp;actionType=edit");
        exit;
    } else {
        $sql = "UPDATE tbl_permissions SET name=?, slug=?,permission_module_id=? WHERE id=?";

        if ($stmt = mysqli_prepare($conn_hr, $sql)) { 

            mysqli_stmt_bind_param($stmt, "ssii", $param_name, $param_slug, $param_permission_module_id, $param_id); // Bind variables to the prepared statement as parameters

            // Set parameters
            $param_name = $name;
            $param_permission_module_id = trim($_POST["permission_module_id"]);
            $param_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $param_name)));
            $param_id =  $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to list page
                $message = [
                    'text' => 'Role Data Updated Successfully.',
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" .  . "/role_permission/permission/index.php");
                exit();
            } else {
                $message = [
                    'text' =>  "Oops! Something went wrong. Please try again later.",
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                header("location:" .  . "/role_permission/permission/index.php");
            }
        }
        mysqli_stmt_close($stmt);  // Close statement
    }
    mysqli_close($conn_hr); // Close connection
}

if (($_GET["deleteID"])) {

    // Prepare a delete statement
    $sql = "DELETE FROM tbl_permissions WHERE id = ?";


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
        header("location:" .  . "/role_permission/permission/index.php");
        exit();
    }
}
