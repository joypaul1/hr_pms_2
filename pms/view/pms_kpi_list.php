<?php


require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');




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
                        <div class="resume-item d-flex flex-column flex-md-row">
                            <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
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
                                        "SELECT 
											    B.ID, 
												B.KPI_NAME, 
												(SELECT KRA_NAME FROM HR_PMS_KRA_LIST WHERE ID=HR_KRA_LIST_ID)KRA_NAME, 
												WEIGHTAGE, 
												TARGET,ELIGIBILITY_FACTOR, 
												REMARKS, 
												CREATED_BY, 
												CREATED_DATE, 
												IS_ACTIVE,ACHIVEMENT, 
												ACHIEVEMENT_LOCK_STATUS
											FROM HR_PMS_KPI_LIST B
											WHERE CREATED_BY='$emp_session_id'"
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
                                                <input form="Form2" name="table_id" class="form-control" type='text' value='<?php echo $row['ID']; ?>'
                                                    style="display:none" />
                                                <a class="btn btn-warning btn-sm" href="pms_kpi_list_update.php?key=<?php echo $row['ID']; ?>">Update</a>

                                                <?php
                                                if ($row['ACHIEVEMENT_LOCK_STATUS'] == '1') {
                                                    ?>
                                                    <input form="Form2" name="table_id" class="form-control" type='text' value='<?php echo $row['ID']; ?>'
                                                        style="display:none" />
                                                    <a class="btn btn-warning btn-sm"
                                                        href="pms_kpi_list_update.php?key=<?php echo $row['ID']; ?>">Achivement</a>
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

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>