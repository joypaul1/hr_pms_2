<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];

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
                        <div class="table-responsive text-break ">
                            <table class="table table-bordered " border="1" cellspacing="0" cellpadding="0">
                                <thead style="background-color: #0e024efa;">
                                    <tr class="text-center">
                                        <th class="text-center">Sl</th>
                                        <th scope="col">KRA Name</th>
                                        <th scope="col">KPI Name</th>
                                        <th scope="col">WEIGHTAGE</th>
                                        <th scope="col">TARGET</th>
                                        <th scope="col">Achievement (%)</th>
                                        <th scope="col">Eligibility Factor</th>
                                        <th scope="col">Comment</th>
                                        <!-- <th scope="col">Status</th> -->
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
                                               (SELECT E.STEP_3_STATUS FROM HR_PMS_LIST E WHERE E.ID=A.HR_PMS_LIST_ID) AS STEP_3_STATUS,
											   B.WEIGHTAGE,
											   B.TARGET,
											   B.ELIGIBILITY_FACTOR,
											   B.REMARKS,
											   B.CREATED_BY,
											   B.CREATED_DATE,
											   B.IS_ACTIVE,
											   B.ACHIVEMENT,
											   B.ACHIVEMENT_COMMENTS,
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
                                        <tr class="text-center">
                                            <td class="text-center">
                                                <?php echo $number; ?>
                                            </td>
                                            <td class="text-left">
                                                <?php echo $row['KRA_NAME']; ?>
                                            </td>
                                            <td class="text-left">
                                                <?php echo $row['KPI_NAME']; ?>
                                            </td>

                                            <td>
                                                <?php echo $row['WEIGHTAGE']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['TARGET']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $existAchievement = false;
                                                if ($row['ACHIVEMENT'] || $row['STEP_3_STATUS'] === NULL || $row['STEP_3_STATUS'] === '0') {
                                                    $existAchievement = true;
                                                }
                                                if ($row['STEP_3_STATUS'] === '1' || $row['STEP_3_STATUS'] === '0') {
                                                    ?>

                                                    <form action="<?php echo $basePath . "/pms_module/action/self_panel.php" ?>" method="post">
                                                        <input type="hidden" name="actionType" value='kpi_achivement'>
                                                        <input type="hidden" name="editId" value='<?php echo $row['ID'] ?>'>
                                                        <div class="d-flex  flex-column gap-2">
                                                            <input required="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="<?php echo $row['ACHIVEMENT'] ?>" style="padding:5px !important"
                                                                name="achivement" placeholder="achivement" class="form-control text-center cust-control"
                                                                type='number' <?php if ($existAchievement) {
                                                                    echo 'readonly';
                                                                } ?>>
                                                            <input required=""  value="<?php echo $row['ACHIVEMENT_COMMENTS'] ?>"
                                                                style="padding:5px !important" name="ACHIVEMENT_COMMENTS" placeholder="describe achivement"
                                                                class="form-control text-center cust-control" type='text' <?php if ($existAchievement) {
                                                                    echo 'readonly';
                                                                } ?>>
                                                            <?php if ($row['STEP_3_STATUS'] === '1') {
                                                                if (!$existAchievement) {
                                                                    echo '<button class="btn btn-sm btn-info"> <i class="bx bxs-comment-check"
                                                            style="margin:0;font-size:18px"></i> Save</button>';
                                                                }
                                                            } ?>


                                                        </div>
                                                    </form>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php echo $row['ELIGIBILITY_FACTOR']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['REMARKS']; ?>
                                            </td>
                                            <!-- <td>
                                                <?php

                                                // if ($row['IS_ACTIVE'] == '1')
                                                    // echo '<span class="badge badge-sm badge-pill bg-success"><i class="menu-icon tf-icons bx bxs-message-alt-check " style="margin:0;font-size:20px"></i></span>';
                                                // else
                                                    // echo '<span class="badge badge-sm badge-pill bg-info"><i class="menu-icon tf-icons bx bxs-message-alt-x" style="margin:0;font-size:20px"></i></span>';
                                                ?>
                                            </td> -->
                                            <td>
                                                <?php
                                                if ($row['SUBMITTED_STATUS'] != '1') {
                                                    ?>
                                                    <a class="btn btn-warning btn-sm" href="pms_kpi_list_edit.php?id=<?php echo $row['ID']; ?>"><i class="menu-icon tf-icons bx bx-edit" style="margin:0;font-size:20px"></i></a>
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
                    // if (isset($_POST['submit_approval'])) {
                    //     $table_id = $_REQUEST['table_id'];
                    //     $kra_name = $_REQUEST['kra_name'];
                    
                    //     $updateSQL = oci_parse(
                    //         $objConnect,
                    //         "UPDATE HR_PMS_KRA_LIST SET KRA_NAME='$kra_name',UPDATED_DATE=SYSDATE WHERE ID='$table_id'"
                    //     );
                    
                    //     if (oci_execute($updateSQL)) {
                    //         echo "<script>window.location = 'http://202.40.181.98:9090/rHR/pms_kra_create.php'</script>";
                    //     }
                    // }
                    
                    ?>




                </div>
            </div>
        </div>

    </div>

</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>