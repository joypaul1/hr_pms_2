<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];

$v_ACHIEVEMENT_LOCK_STATUS = 0;
$v_key = $_REQUEST['id'];
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$query = "SELECT 
            KPI_NAME,
            HR_KRA_LIST_ID,ACHIEVEMENT_LOCK_STATUS,
            WEIGHTAGE,
            REMARKS,
            TARGET,ELIGIBILITY_FACTOR,ACHIVEMENT,
            (
            SELECT SELF_SUBMITTED_STATUS 
            FROM HR_PMS_EMP 
            WHERE IS_ACTIVE=1 
                AND EMP_ID='$emp_session_id' 
                AND HR_PMS_LIST_ID=(SELECT HR_PMS_LIST_ID FROM HR_PMS_KRA_LIST WHERE ID=HR_KRA_LIST_ID)
            ) SUBMITTED_STATUS											
            FROM HR_PMS_KPI_LIST 
            WHERE ID=$v_key";
$strSQL  = oci_parse($objConnect, $query);
oci_execute($strSQL);
$row = oci_fetch_assoc($strSQL);
$kra_id = $row['HR_KRA_LIST_ID'];
$v_ACHIEVEMENT_LOCK_STATUS = $row['ACHIEVEMENT_LOCK_STATUS'];
// print_r($row);
// die();
?>
<!-- / Content -->


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between" style="padding: 1.0% 1rem">
                <div href="#" style="font-size: 20px;font-weight:700">
                    <i class="menu-icon tf-icons bx bx-edit" style="margin:0;font-size:25px"></i>KPI Edit
                </div>
                <div>
                    <a href="<?php echo $basePath ?>/pms_module/view/self_panel/pms_kpi_list.php" class="btn btn-sm btn-info"><i class="menu-icon tf-icons bx bx-message-alt-add" style="margin:0;"></i>KPI List</a>
                </div>
            </div>
        </div>
        <div>
            <div class="row card-body mt-2">
                <div class="col-lg-12">
                    <form action="<?php echo $basePath . "/pms_module/action/self_panel.php"   ?>" method="POST">
                        <input type="hidden" name="actionType" value='kpi_edit'>
                        <input type="hidden" name="editId" value='<?php echo $v_key ?>'>
                        <input type="hidden" name="v_ACHIEVEMENT_LOCK_STATUS" value='<?php echo $v_ACHIEVEMENT_LOCK_STATUS ?>'>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="exampleInputEmail1">KPI Name:</label>
                                <textarea class="form-control " rows="2" id="comment" name="kpi_name"><?php echo $row['KPI_NAME']; ?></textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Select KRA Title:</label>
                                <select required="" name="kra_id" class="form-control cust-control">
                                    <option selected value="">--</option>
                                    <?php
                                    $strSQL  = oci_parse($objConnect, "select ID,KRA_NAME from HR_PMS_KRA_LIST where is_active=1 AND CREATED_BY='$emp_session_id' ORDER BY ID");
                                    oci_execute($strSQL);
                                    while ($row1 = oci_fetch_assoc($strSQL)) {
                                        if ($kra_id == $row1['ID']) {
                                    ?><option selected value="<?php echo $row1['ID']; ?>"><?php echo $row1['KRA_NAME']; ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?php echo $row1['ID']; ?>"><?php echo $row1['KRA_NAME']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Select Weightage(%):</label>
                                <select required="" name="weightage" class="form-control cust-control">
                                    <option selected value="<?php echo $row['WEIGHTAGE']; ?>"><?php echo $row['WEIGHTAGE']; ?></option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Select Target(%):</label>
                                <input required="" class="form-control cust-control" type='number' readonly name="target" value="<?php echo $row['TARGET']; ?>" />
                            </div>

                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Eligibility Factor:</label>
                                <input required="" class="form-control cust-control" type='number' name="eli_factor" value="<?php echo $row['ELIGIBILITY_FACTOR']; ?>" />
                            </div>
                        </div>

                        <?php
                        if ($row['ACHIEVEMENT_LOCK_STATUS'] == '1') {
                        ?>
                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <label for="exampleInputEmail1">Achievement(%):</label>
                                    <input required="" class="form-control cust-control" type='number' name="achivement" value="<?php echo $row['ACHIVEMENT']; ?>" />
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="md-form mt-3">
                                    <label for="comment">Comment:</label>
                                    <textarea class="form-control" rows="2" id="comment" name="ramarks"><?php echo $row['REMARKS']; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($row['SUBMITTED_STATUS'] != '1' || $row['ACHIEVEMENT_LOCK_STATUS'] == '1') {
                        ?>
                            <div class="row">
                                <div class="col-sm-9"></div>
                                <div class="col-sm-2">
                                    <div class="md-form mt-3">
                                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Update">
                                    </div>
                                </div>
                            </div>
                        <?php
                        }

                        ?>
                    </form>

                </div>



                <?php


                if (isset($_POST['kpi_name'])) {

                   
                }
                ?>

            </div>
        </div>

    </div>

</div>
<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>