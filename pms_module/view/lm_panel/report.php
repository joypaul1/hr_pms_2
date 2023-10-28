<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
if (!checkPermission('pms-lm-report')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}
$emp_session_id  = $_SESSION['HR']['emp_id_hr'];
$v_view_approval = 0;


?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- form store request  -->
    <form id="Form1" action="" method="post"></form>
    <form id="Form2" action="" method="post"></form>
    <form id="Form3" action="" method="post"></form>
    <!-- form store request  -->


    <div class="card col-lg-12">
        <form action="" method="post">
            <div class="card-body row justify-content-center">
                <!-- <div class="col-sm-2"></div> -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">EMP RML ID</label>
                        <!-- <input required="" placeholder="Employee ID" name="emp_id" class="form-control cust-control" type='text'
                            value='<?php echo isset($_POST['emp_id']) ? $_POST['emp_id'] : ''; ?>' > -->
                        <select name="emp_concern" class="form-control cust-control" form="Form1">
                            <option selected value=""><- Select Concern -></option>
                            <?php
                            $strSQL = oci_parse($objConnect, "select RML_ID,EMP_NAME from RML_HR_APPS_USER 
																		where LINE_MANAGER_RML_ID ='$emp_session_id'
																		and is_active=1 
																		order by EMP_NAME");
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {
                                ?>
                                <option value="<?php echo $row['RML_ID']; ?>">
                                    <?php echo $row['EMP_NAME']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" form="Form1" value="Search Data">
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>PSM Approval/Denie Report</b></h5>
        <div class="card-body">
            <div class="table-responsive-sm text-break">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>SL</th>
                            <th scope="col">Rating Create</th>
                            <th scope="col">PMS Title Info.</th>
                            <th scope="col">Approve/Denine</th>
                            <th scope="col">Approval Date</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Employe Info.</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <?php
                    if (isset($_POST['emp_concern'])) {
                        $emp_concern = $_REQUEST['emp_concern'];
                        $strSQL      = oci_parse($objConnect, "SELECT A.ID,
                                                    A.EMP_ID,
                                                    A.EMP_NAME,
                                                    A.LINE_MANAGER_1_STATUS,
                                                    A.LINE_MANAGER_1_UPDATED,
                                                    A.LINE_MANAGE_1_REMARKS,
                                                    A.EMP_DEPT,
                                                    A.EMP_WORK_STATION,
                                                    A.EMP_DESIGNATION,A.SELF_SUBMITTED_DATE,
                                                    A.GROUP_NAME,
                                                    A.GROUP_CONCERN,
                                                    A.CREATED_DATE,
                                                    A.CREATED_BY,HR_PMS_LIST_ID,
                                                    (SELECT AA.PMS_NAME FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS PMS_TITLE,
                                                    (SELECT AA.STEP_1_STATUS FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS STEP_1_STATUS,
                                                    (SELECT AA.STEP_2_STATUS FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS STEP_2_STATUS
													FROM HR_PMS_EMP A
													WHERE SELF_SUBMITTED_STATUS=1
                                                    AND LINE_MANAGER_1_STATUS  IS NOT NULL 
													AND LINE_MANAGER_1_ID='$emp_session_id'
													AND A.EMP_ID='$emp_concern'");

                        oci_execute($strSQL);
                        $number = 0;

                        while ($row = oci_fetch_assoc($strSQL)) {
                            $number++;
                            $v_view_approval = 1;
                            ?>
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-center">
                                        <?php echo $number; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['STEP_1_STATUS'] === '0' && $row['STEP_2_STATUS'] === '0') { ?>
                                            <a
                                                href="rating_form.php?key=<?php echo $row['HR_PMS_LIST_ID'] . '&emp_id=' . $row['EMP_ID'] . '&tab_id=' . $row['ID']; ?>"><button
                                                    type="button" class="btn btn-sm btn-warning"><i class='bx bxs-edit-alt'></i></button>
                                            </a>
                                        <?php }
                                        else { ?>
                                            <span class="badge bg-info"> Wait For Step 1 & Step 2 Done </span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php echo $row['PMS_TITLE']; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['LINE_MANAGER_1_STATUS']) {
                                            echo "<button class='btn btn-sm btn-success'><i class='bx bxs-badge-check'></i></button>";
                                        }
                                        else {
                                            echo '<button class="btn btn-sm btn-danger"><i class="bx bxs-message-alt-x"></i></button>';
                                        } ?>
                                    </td>
                                    <td>
                                        <?php echo $row['LINE_MANAGER_1_UPDATED'] ?>
                                    </td>
                                    <td>
                                        <?php echo mb_strimwidth($row['LINE_MANAGE_1_REMARKS'], 0, 20, "...") ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row['EMP_NAME'];
                                        echo ' [ ';
                                        echo $row['EMP_ID'];
                                        echo ' ] ,<br>';
                                        echo $row['EMP_DESIGNATION'];
                                        echo ', ';
                                        echo $row['EMP_DEPT'];
                                        echo ', ';
                                        echo $row['EMP_WORK_STATION'];
                                        ?>
                                    </td>
                                    <td>
                                        <a
                                            href="pms_approve_denied.php?key=<?php echo $row['HR_PMS_LIST_ID'] . '&emp_id=' . $row['EMP_ID'] . '&tab_id=' . $row['ID']; ?>">
                                            <button type="button" class="btn btn-sm btn-info"><i class=" tf-icons bx bx bx-book-open"></i><i
                                                    class=" tf-icons bx bx bx-book-open"></i></button>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                        }
                    }
                    else {
                        $allDataSQL = oci_parse(
                            $objConnect,
                            "SELECT A.ID,
							           A.EMP_ID,
							           A.EMP_NAME,
                                       A.LINE_MANAGER_1_STATUS,
                                       A.LINE_MANAGER_1_UPDATED,
                                       A.LINE_MANAGE_1_REMARKS,
									   A.EMP_DEPT,A.SELF_SUBMITTED_DATE,
									   A.EMP_WORK_STATION,
									   A.EMP_DESIGNATION,
									   A.GROUP_NAME,
									   A.GROUP_CONCERN,
									   A.CREATED_DATE,
									   A.CREATED_BY,HR_PMS_LIST_ID,
                                      (SELECT AA.PMS_NAME FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS PMS_TITLE,
                                      (SELECT AA.STEP_1_STATUS FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS STEP_1_STATUS,
                                      (SELECT AA.STEP_2_STATUS FROM HR_PMS_LIST AA WHERE AA.ID=HR_PMS_LIST_ID) AS STEP_2_STATUS
									FROM HR_PMS_EMP A
									WHERE SELF_SUBMITTED_STATUS=1
								    AND LINE_MANAGER_1_STATUS  IS NOT NULL 
									AND LINE_MANAGER_1_ID='$emp_session_id'"
                        );

                        oci_execute($allDataSQL);
                        $number = 0;

                        while ($row = oci_fetch_assoc($allDataSQL)) {
                           
                            $number++;
                            $v_view_approval = 1;
                            ?>
                                <tr class="text-center">
                                    <td class="text-center">
                                        <?php echo $number; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['STEP_1_STATUS'] === '0' && $row['STEP_2_STATUS'] === '0') { ?>
                                            <a
                                                href="rating_form.php?key=<?php echo $row['HR_PMS_LIST_ID'] . '&emp_id=' . $row['EMP_ID'] . '&tab_id=' . $row['ID']; ?>"><button
                                                    type="button" class="btn btn-sm btn-warning"><i class='bx bxs-edit-alt'></i></button>
                                            </a>
                                        <?php }
                                        else { ?>
                                            <span class="badge bg-info"> Wait For Step 1 & Step 2 Done </span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php echo $row['PMS_TITLE']; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['LINE_MANAGER_1_STATUS']) {
                                            echo "<button class='btn btn-sm btn-success'><i class='bx bxs-badge-check'></i></button>";
                                        }
                                        else {
                                            echo '<button class="btn btn-sm btn-danger"><i class="bx bxs-message-alt-x"></i></button>';
                                        } ?>
                                    </td>
                                    <td>
                                        <?php echo $row['LINE_MANAGER_1_UPDATED'] ?>
                                    </td>
                                    <td>
                                        <?php echo mb_strimwidth($row['LINE_MANAGE_1_REMARKS'], 0, 20, "...") ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row['EMP_NAME'];
                                        echo ' [ ';
                                        echo $row['EMP_ID'];
                                        echo ' ] ,<br>';
                                        echo $row['EMP_DESIGNATION'];
                                        echo ', ';
                                        echo $row['EMP_DEPT'];
                                        echo ', ';
                                        echo $row['EMP_WORK_STATION'];
                                        ?>
                                    </td>

                                    <td>
                                        <a
                                            href="pms_approve_denied.php?key=<?php echo $row['HR_PMS_LIST_ID'] . '&emp_id=' . $row['EMP_ID'] . '&tab_id=' . $row['ID']; ?>"><button
                                                type="button" class="btn btn-sm btn-info"> <i class=" tf-icons bx bx-book-open"></i> </button>
                                        </a>
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

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>