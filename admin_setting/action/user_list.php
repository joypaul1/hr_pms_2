<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];

// Handle Create request
if ($_SERVER['REQUEST_METHOD'] === 'GET' &&  isset($_GET["rml_id"])) {
    $getID = trim($_GET['rml_id']);
    $strSQL  = oci_parse(
        $objConnect,
        "SELECT EMP_NAME,RML_ID,R_CONCERN,MAIL,MOBILE_NO,DEPT_NAME,BRANCH_NAME,DESIGNATION  FROM RML_HR_APPS_USER  WHERE RML_ID='$getID'"
    );
    oci_execute($strSQL);
    $erpUserData = oci_fetch_assoc($strSQL);

    $EMP_NAME = $erpUserData['EMP_NAME'];
    $RML_ID = $erpUserData['RML_ID'];
    $MOBILE_NO = $erpUserData['MOBILE_NO'];
    $R_CONCERN = $erpUserData['R_CONCERN'];
    $MAIL = $erpUserData['MAIL'];
    $defaulPass = md5(123);

    try {
        $conn_hr->begin_transaction();
        //WEB USER CREATE
        $checkData = mysqli_query($conn_hr,  "SELECT `id`FROM `tbl_users` WHERE emp_id ='$RML_ID'");
        if (mysqli_num_rows($checkData) > 0) {
            $message = [
                'text' =>   'Already Web User exited!',
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/admin_setting/view/user_list.php");
            // $_SESSION['should_reload'] = true;
            exit();
        } else {
            $auditsql = "INSERT INTO tbl_users(
                first_name, 
                emp_id, 
                concern, 
                email, 
                password, 
                real_pass) 
            VALUES ('$EMP_NAME','$RML_ID','$R_CONCERN','$MAIL','$defaulPass','123')";
            mysqli_query($conn_hr, $auditsql);
        }

        $selectQuery    = "SELECT id FROM tbl_users WHERE emp_id = '$RML_ID'";
        $dataResult     = mysqli_query($conn_hr, $selectQuery);
        $insertedData   = mysqli_fetch_assoc($dataResult);
        $user_id        = $insertedData['id'];

        // NORMAL_USER/PUBLIC_USER ROLE 
        $publicRoleID = 7;

        $sql    = "INSERT INTO tbl_users_roles (user_id , role_id)  VALUES  ($user_id , $publicRoleID)";
        $result = $conn_hr->query($sql);

        if ($result) {

            $getRoleWisePermission = getRoleWisePermission($conn_hr, $publicRoleID);
            foreach ($getRoleWisePermission as $key => $permission_id) {

                $sql = "SELECT * FROM tbl_users_permissions WHERE user_id = $user_id AND permission_id = $permission_id"; //get user wise permission
                $result     = mysqli_query($conn_hr, $sql);

                if (mysqli_num_rows($result) == 0) {
                    $sql = "INSERT INTO tbl_users_permissions (user_id , permission_id)  VALUES  ($user_id , $permission_id)"; //user wise permission insert 
                    mysqli_query($conn_hr, $sql);
                }
            }
        }
        $conn_hr->commit();
    } catch (\Exception $e) {
        $conn_hr->rollback();
        // Handle the exception
        $message = [
            'text' =>   $e->getMessage(),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        // $_SESSION['should_reload'] = true;
        // echo '<script>location.reload();</script>';

        header("location:" . $basePath . "/admin_setting/view/user_list.php");
        exit();
    }
    mysqli_close($conn_hr); // Close connection
    $message = [
        'text' => 'Web User Created Successfully.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    header("location:" . $basePath . "/admin_setting/view/user_list.php");
    exit();
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
