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
                    <i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i> Approval Report
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