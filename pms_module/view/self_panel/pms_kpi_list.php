<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
// if (!checkPermission('concern-offboarding-create')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }
$emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between" style="padding: 1.0% 1rem">
                <div href="#" style="font-size: 20px;font-weight:700">
                    <i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i>KPI List
                </div>
                <div>
                </div>
            </div>
            <div class="row card-body mt-2">


                <div class="col-lg-12">
                    <div class="md-form mt-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" border="1" cellspacing="0" cellpadding="0">
                                <thead style="background: beige;">
                                    <tr class="text-center">
                                        <th class="text-center">Sl</th>
                                        <th scope="col">KPI Name</th>
                                        <th scope="col">KRA Name</th>
                                        <th scope="col">WEIGHTAGE</th>
                                        <th scope="col">TARGET</th>
                                        <th scope="col">Achievement (%)</th>
                                        <th scope="col">Eligibility Factor</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php



                                    $strSQL = oci_parse(
                                        $objConnect,
                                        "SELECT B.ID,
											   B.KPI_NAME,
											   A.KRA_NAME,
											   (SELECT D.SELF_SUBMITTED_STATUS FROM HR_PMS_EMP D WHERE D.HR_PMS_LIST_ID = A.HR_PMS_LIST_ID AND D.EMP_ID=B.CREATED_BY) AS SUBMITTED_STATUS,
											   B.WEIGHTAGE,
											   B.TARGET,
											   B.ELIGIBILITY_FACTOR,
											   B.REMARKS,
											   B.CREATED_BY,
											   B.CREATED_DATE,
											   B.IS_ACTIVE,
											   B.ACHIVEMENT,
											   B.ACHIEVEMENT_LOCK_STATUS
										  FROM HR_PMS_KPI_LIST B, HR_PMS_KRA_LIST A
										 WHERE A.id = B.HR_KRA_LIST_ID 
										 AND B.CREATED_BY = '$emp_session_id'"
                                    );
                                    oci_execute($strSQL);
                                    $number = 0;


                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $number; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['KPI_NAME']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['KRA_NAME']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['WEIGHTAGE']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['TARGET']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['ACHIVEMENT']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['ELIGIBILITY_FACTOR']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['REMARKS']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($row['IS_ACTIVE'] == '1')
                                                    echo 'Active';
                                                else
                                                    echo 'In-Active';
                                                ?>
                                            </td>
                                            <td>
                                                <input form="Form2" name="table_id" class="form-control" type='text' value='<?php echo $row['ID']; ?>' style="display:none" />
                                                <a class="btn btn-warning btn-sm" href="pms_kpi_list_edit.php?id=<?php echo $row['ID']; ?>">Update</a>

                                                <?php
                                                if ($row['ACHIEVEMENT_LOCK_STATUS'] == '1') {
                                                ?>
                                                    <input form="Form2" name="table_id" class="form-control" type='text' value='<?php echo $row['ID']; ?>' style="display:none" />
                                                    <a class="btn btn-warning btn-sm" href="pms_kpi_list_edit.php?id=<?php echo $row['ID']; ?>">Achivement</a>
                                                <?php
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                    <?php

                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <?php
                    if (isset($_POST['submit_approval'])) {
                        $table_id = $_REQUEST['table_id'];
                        $kra_name = $_REQUEST['kra_name'];

                        $updateSQL = oci_parse(
                            $objConnect,
                            "UPDATE HR_PMS_KRA_LIST SET KRA_NAME='$kra_name',UPDATED_DATE=SYSDATE WHERE ID='$table_id'"
                        );

                        if (oci_execute($updateSQL)) {
                            echo "<script>window.location = 'http://202.40.181.98:9090/rHR/pms_kra_create.php'</script>";
                        }
                    }

                    ?>




                </div>
            </div>
        </div>

    </div>

</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>