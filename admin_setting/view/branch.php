<?php
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];
if (!checkPermission('branch-list')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body col-lg-12">
        <form action="" method="post">
        <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">Branch Name</label>
                        <input required="" placeholder="Branch Name" name="department_name" class="form-control cust-control" type='text' value='<?php echo isset($_POST['department_name']) ? $_POST['department_name'] : ''; ?>' />
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Search Data">
                    </div>
                </div>
            </div>
        </form>
    </div>
    </br>



    <!-- Bordered Table -->
    <div class="card">
        <h5 class="card-header"><b>Apps Branch Name</b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th>Branch Name</th>
                            <th>Lat</th>
                            <th>Lang</th>
                            <th>Concern</th>
                            <th>Create By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['department_name'])) {

                            $department_name = $_REQUEST['department_name'];

                            $strSQL  = oci_parse(
                                $objConnect,
                                "SELECT ID,
			                            BRANCH_NAME,
										CONCERN_NAME,
										CREATED_BY,
										IS_ACTIVE,
                                        LATITUDE,
										LONGITUDE 										
						FROM RML_HR_BRANCH
                         where BRANCH_NAME like '%$department_name%'"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $number++;
                        ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
                                    <td><?php echo $row['LATITUDE']; ?></td>
                                    <td><?php echo $row['LONGITUDE']; ?></td>
                                    <td><?php echo $row['CONCERN_NAME']; ?></td>
                                    <td><?php echo $row['CREATED_BY']; ?></td>
                                    <td><?php
                                        if ($row['IS_ACTIVE'] == 1)
                                            echo 'Active';
                                        else
                                            echo 'In-Active';
                                        ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="user_edit.php?emp_id=<?php echo $row['RML_ID'] ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>


                            <?php
                            }
                        } else {



                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT ID,BRANCH_NAME,CONCERN_NAME,CREATED_BY,IS_ACTIVE,LATITUDE,LONGITUDE 
						FROM RML_HR_BRANCH
                        ORDER BY BRANCH_NAME"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                            ?>
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $number; ?></strong>
                                    </td>
                                    <td><?php echo $row['BRANCH_NAME']; ?></td>
                                    <td><?php echo $row['LATITUDE']; ?></td>
                                    <td><?php echo $row['LONGITUDE']; ?></td>
                                    <td><?php echo $row['CONCERN_NAME']; ?></td>
                                    <td><?php echo $row['CREATED_BY']; ?></td>
                                    <td><?php
                                        if ($row['IS_ACTIVE'] == 1)
                                            echo 'Active';
                                        else
                                            echo 'In-Active';
                                        ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="user_edit.php?emp_id=<?php echo $row['RML_ID'] ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>

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



</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>