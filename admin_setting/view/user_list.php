<?php
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];
if (!checkPermission('user-list')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body col-lg-12">
        <form action="" method="post">
            <div class="row justify-content-center">
                <div class="col-sm-3">
                    <label for="title">RML-ID</label>
                    <input type="text" class="form-control cust-control" id="title" placeholder="EMP-ID" name="emp_rml_id">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-sm-3">
                    <label for="title">Select Company</label>
                    <select name="r_concern" class="form-control cust-control">
                        <option selected value="">--</option>
                        <?php
                        $strSQL  = oci_parse($objConnect, "select distinct(R_CONCERN) R_CONCERN from RML_HR_APPS_USER 
														where R_CONCERN is not null  and is_active=1 
														order by R_CONCERN");
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                        ?>
                            <option value="<?php echo $row['R_CONCERN']; ?>" <?php echo (isset($_POST['r_concern']) && $_POST['r_concern'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>><?php echo $row['R_CONCERN']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="title">Select Department</label>
                    <select name="emp_dept" class="form-control cust-control">
                        <option selected value="">--</option>
                        <?php
                        $strSQL  = oci_parse(
                            $objConnect,
                            "SELECT distinct(DEPT_NAME) DEPT_NAME FROM RML_HR_DEPARTMENT 
										where DEPT_NAME is not null and is_active=1 
											order by DEPT_NAME"
                        );
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                        ?>
                            <option value="<?php echo $row['DEPT_NAME']; ?>" <?php echo (isset($_POST['emp_dept']) && $_POST['emp_dept'] == $row['DEPT_NAME']) ? 'selected="selected"' : ''; ?>><?php echo $row['DEPT_NAME']; ?></option>
                        <?php
                        }
                        ?>
                    </select>

                </div>
                <div class="col-sm-3">
                    <label for="title">Select Group</label>
                    <select name="emp_group" class="form-control cust-control">
                        <option selected value="">--</option>
                        <?php
                        $strSQL  = oci_parse(
                            $objConnect,
                            "SELECT distinct(EMP_GROUP) EMP_GROUP from RML_HR_APPS_USER
									where EMP_GROUP is not null  and is_active=1
									order by EMP_GROUP"
                        );
                        oci_execute($strSQL);
                        while ($row = oci_fetch_assoc($strSQL)) {
                        ?>
                            <option value="<?php echo $row['EMP_GROUP']; ?>" <?php echo (isset($_POST['emp_group']) && $_POST['emp_group'] == $row['EMP_GROUP']) ? 'selected="selected"' : ''; ?>><?php echo $row['EMP_GROUP']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"> <br></label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>

            </div>
        </form>
    </div>






    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><b>ERP User List</b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>SL</th>
                            <th>User ID</th>
                            <th>Web App. User </th>
                            <th>User Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Mobile Number</th>
                            <th>Incrg-1</th>
                            <th>Incrg-2</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $mysql_users = [];
                        $queryMysql = "SELECT emp_id FROM tbl_users";
                        $resultMysql = mysqli_query($conn_hr, $queryMysql);

                        while ($row = mysqli_fetch_assoc($resultMysql)) {
                            $mysql_users[] = $row['emp_id'];
                        }
                        $oracle_rml_ids =  "'" . implode("','", $mysql_users) . "'";

                        if (isset($_POST['r_concern'])) {
                            $v_emp_id = $_REQUEST['emp_rml_id'];
                            $emp_group = $_REQUEST['emp_group'];
                            $r_concern = $_REQUEST['r_concern'];
                            $emp_dept = $_REQUEST['emp_dept'];
                            $strSQL  = oci_parse($objConnect, "SELECT  RML_ID,EMP_GROUP,
																EMP_NAME,
																MOBILE_NO,
																COLL_HR_EMP_NAME(LINE_MANAGER_RML_ID) LINE_MANAGER_RML_ID,
																COLL_HR_EMP_NAME(DEPT_HEAD_RML_ID) DEPT_HEAD_RML_ID,
																DEPT_NAME,
																BRANCH_NAME,
																DESIGNATION,
                                                                CASE
                                                                    WHEN RML_ID IN ($oracle_rml_ids) THEN 'yes'
                                                                    ELSE 'no'
                                                                END AS APPS_USER_STATUS
														FROM RML_HR_APPS_USER
														WHERE ('$emp_group' is null OR EMP_GROUP='$emp_group')
														AND ('$v_emp_id' is null OR RML_ID='$v_emp_id')
														AND ('$r_concern' is null OR R_CONCERN='$r_concern')
														AND ('$emp_dept' is null OR DEPT_NAME='$emp_dept')");
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                                $password = "p";
                                $encrypted_rml_id = openssl_encrypt($row['RML_ID'], "AES-128-ECB", $password);
                        ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php echo $row['RML_ID']; ?></td>
                                    <td class="text-center">
                                        <?php if ($row['APPS_USER_STATUS'] == 'yes') {
                                            echo '<span  class="badge  rounded-pill bg-success">
                                            <span class="tf-icons bx bx-check"></span>
                                            </span>';
                                        } else {
                                            echo '<a href="' . $basePath . '/admin_setting/action/user_list.php?rml_id=' . $row['RML_ID'] . '"> 
                                                    <span data-toggle="tooltip" data-placement="top" title="defalt user Create?" class="badge rounded-pill bg-info">
                                                        <span class="tf-icons bx bx-edit-alt"></span>
                                                    </span>
                                                </a>';
                                        } ?>

                                    </td>
                                    <td><?php echo $row['EMP_NAME']; ?></td>
                                    <td><?php echo $row['DESIGNATION']; ?></td>
                                    <td><?php echo $row['DEPT_NAME']; ?></td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
                                    <td><?php echo $row['MOBILE_NO']; ?></td>
                                    <td><?php echo $row['LINE_MANAGER_RML_ID']; ?></td>
                                    <td><?php echo $row['DEPT_HEAD_RML_ID']; ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="user_profile.php?emp_id=<?php echo $row['RML_ID']; ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>


                            <?php
                            }
                        } else {


                            $emp_session_id = $_SESSION['HR']['emp_id_hr'];
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT  
                                    RML_ID,
                                    EMP_NAME,
                                    MOBILE_NO,
                                    COLL_HR_EMP_NAME(LINE_MANAGER_RML_ID) LINE_MANAGER_RML_ID,
                                    COLL_HR_EMP_NAME(DEPT_HEAD_RML_ID) DEPT_HEAD_RML_ID,
                                    DEPT_NAME,
                                    BRANCH_NAME,
                                    DESIGNATION,
                                    CASE
                                        WHEN RML_ID IN ($oracle_rml_ids) THEN 'yes'
                                        ELSE 'no'
                                    END AS APPS_USER_STATUS

                                from RML_HR_APPS_USER
                                where DEPT_NAME =(select a.DEPT_NAME from RML_HR_APPS_USER a where a.RML_ID='$emp_session_id')
                                AND IS_ACTIVE=1"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                                $password = "";
                                $encrypted_rml_id = openssl_encrypt($row['RML_ID'], "AES-128-ECB", $password);
                            ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php echo $row['RML_ID']; ?></td>
                                    <td class="text-center">
                                        <?php if ($row['APPS_USER_STATUS'] == 'yes') {
                                            echo '<span  class="badge  rounded-pill bg-success">
                                            <span class="tf-icons bx bx-check"></span>
                                          </span>';
                                        } else {
                                            echo '<a href="' . $basePath . '/admin_setting/action/user_list.php?rml_id=' . $row['RML_ID'] . '">
                                                <span data-toggle="tooltip" data-placement="top" title="defalt user Create?" class="badge rounded-pill bg-info">
                                                    <span class="tf-icons bx bx-edit-alt"></span>
                                                </span>
                                            </a>';
                                        } ?>

                                    </td>
                                    <td><?php echo $row['EMP_NAME']; ?></td>
                                    <td><?php echo $row['DESIGNATION']; ?></td>
                                    <td><?php echo $row['DEPT_NAME']; ?></td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
                                    <td><?php echo $row['MOBILE_NO']; ?></td>
                                    <td><?php echo $row['LINE_MANAGER_RML_ID']; ?></td>
                                    <td><?php echo $row['DEPT_HEAD_RML_ID']; ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="user_profile.php?emp_id=<?php echo $encrypted_rml_id; ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Bordered Table -->


    <?php
    // ob_start(); // Start output buffering
    // if (isset($_GET['rml_id'])) {
    // echo(23123);
    // $getID = trim($_GET['rml_id']);
    // $strSQL  = oci_parse(
    //     $objConnect,
    //     "SELECT EMP_NAME,RML_ID,R_CONCERN,MAIL,MOBILE_NO,DEPT_NAME,BRANCH_NAME,DESIGNATION  FROM RML_HR_APPS_USER  WHERE RML_ID='$getID'"
    // );
    // oci_execute($strSQL);
    // $erpUserData = oci_fetch_assoc($strSQL);

    // $EMP_NAME = $erpUserData['EMP_NAME'];
    // $RML_ID = $erpUserData['RML_ID'];
    // $MOBILE_NO = $erpUserData['MOBILE_NO'];
    // $R_CONCERN = $erpUserData['R_CONCERN'];
    // $MAIL = $erpUserData['MAIL'];
    // $defaulPass = md5(123);

    // try {
    //     $conn_hr->begin_transaction();
    //     //WEB USER CREATE 
    //     $checkData = mysqli_query($conn_hr,  "SELECT `id`FROM `tbl_users` WHERE emp_id ='$RML_ID'");
    //     if (mysqli_num_rows($checkData) > 0) {
    //         $message = [
    //             'text' =>   'Already Web User exited!',
    //             'status' => 'false',
    //         ];
    //         $_SESSION['noti_message'] = $message;
    //         // header("location:" . $basePath . "/admin_setting/view/user_list.php");
    //         // echo '<script>location.reload();</script>';
    //         $_SESSION['should_reload'] = true;
    //         // exit();
    //     } else {
    //         $auditsql = "INSERT INTO tbl_users(
    //         first_name, 
    //         emp_id, 
    //         concern, 
    //         email, 
    //         password, 
    //         real_pass) 
    //     VALUES ('$EMP_NAME','$RML_ID','$R_CONCERN','$MAIL','$defaulPass','123')";
    //         mysqli_query($conn_hr, $auditsql);
    //     }

    //     $selectQuery    = "SELECT id FROM tbl_users WHERE emp_id = '$RML_ID'";
    //     $dataResult     = mysqli_query($conn_hr, $selectQuery);
    //     $insertedData   = mysqli_fetch_assoc($dataResult);
    //     $user_id        = $insertedData['id'];

    //     // NORMAL_USER/PUBLIC_USER ROLE 
    //     $publicRoleID = 7;

    //     $sql    = "INSERT INTO tbl_users_roles (user_id , role_id)  VALUES  ($user_id , $publicRoleID)";
    //     $result = $conn_hr->query($sql);

    //     if ($result) {

    //         $getRoleWisePermission = getRoleWisePermission($conn_hr, $publicRoleID);
    //         foreach ($getRoleWisePermission as $key => $permission_id) {

    //             $sql = "SELECT * FROM tbl_users_permissions WHERE user_id = $user_id AND permission_id = $permission_id"; //get user wise permission
    //             $result     = mysqli_query($conn_hr, $sql);

    //             if (mysqli_num_rows($result) == 0) {
    //                 $sql = "INSERT INTO tbl_users_permissions (user_id , permission_id)  VALUES  ($user_id , $permission_id)"; //user wise permission insert 
    //                 mysqli_query($conn_hr, $sql);
    //             }
    //         }
    //     }
    //     $conn_hr->commit();
    // } catch (\Exception $e) {
    //     $conn_hr->rollback();
    //     // Handle the exception
    //     $message = [
    //         'text' =>   $e->getMessage(),
    //         'status' => 'false',
    //     ];
    //     $_SESSION['noti_message'] = $message;
    //     $_SESSION['should_reload'] = true;
    //     // echo '<script>location.reload();</script>';

    //     // header("location:" . $basePath . "/admin_setting/view/user_list.php");
    //     // exit();
    // }
    // mysqli_close($conn_hr); // Close connection
    // $message = [
    //     'text' => 'Web User Created Successfully.',
    //     'status' => 'true',
    // ];
    // $_SESSION['noti_message'] = $message;
    // $_SESSION['should_reload'] = true;

    // // Check if the flag is set to reload, then reload and unset the flag
    // if (isset($_SESSION['should_reload']) && $_SESSION['should_reload']) {
    //     unset($_SESSION['should_reload']);
    //     // echo '<script>location.reload();</script>';
    // }
    // }








    ?>
</div>

<!-- / Content -->
<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>