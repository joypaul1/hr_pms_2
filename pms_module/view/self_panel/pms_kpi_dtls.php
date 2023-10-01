<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
// if (!checkPermission('concern-offboarding-create')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$v_key = $_REQUEST['key'];




$strSQL  = oci_parse($objConnect, "SELECT SELF_SUBMITTED_STATUS
											FROM HR_PMS_EMP
											WHERE EMP_ID='$emp_session_id'
											AND HR_PMS_LIST_ID='$v_key'");
oci_execute($strSQL);
while ($row = oci_fetch_assoc($strSQL)) {
    $SUBMITTED_STATUS = $row['SELF_SUBMITTED_STATUS'];
}




// Weaightage value
$v_previous_weightage = 0;
$WATESQL  = oci_parse(
    $objConnect,
    "SELECT PMS_WEIGHTAGE('$emp_session_id',$v_key) AS WEIGHTAGE  FROM DUAL"
);
oci_execute($WATESQL);
while ($row = oci_fetch_assoc($WATESQL)) {
    $v_previous_weightage = $row['WEIGHTAGE'];
}


?>
<div class="container-xxl flex-grow-1 container-p-y">
    <?php
    if ($SUBMITTED_STATUS != 1) {
    ?>
        <div class="card col-lg-12">
            <form action="" method="post">
                <div class="card-body row justify-content-end">
                    <div class="col-sm-3">
                        <label for="exampleInputEmail1">Select KRA:</label>
                        <select required="" name="kra_id" class="form-control cust-control">
                            <option value=""><-Select KRA -></option>
                            <?php
                            $query = "select BB.ID,
                                    BB.KRA_NAME,
                                    (select  PMS_NAME  FROM HR_PMS_LIST where id=BB.HR_PMS_LIST_ID) PMS_NAME,
                                    (SELECT A.SELF_SUBMITTED_STATUS FROM HR_PMS_EMP A 
                                            WHERE A.HR_PMS_LIST_ID=BB.HR_PMS_LIST_ID 
                                            AND A.EMP_ID='$emp_session_id'
                                    )SUBMITTED_STATUS,
                                    CREATED_BY,
                                    CREATED_DATE,UPDATED_DATE,
                                    IS_ACTIVE 
                                FROM HR_PMS_KRA_LIST BB
                                WHERE BB.CREATED_BY='$emp_session_id'";


                            $strSQL  = oci_parse($objConnect, $query);
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {

                            ?>
                                <option value="<?php echo $row['ID']; ?>"><?php echo $row['KRA_NAME']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">KPI Name</label>
                            <textarea required="" class="form-control" rows="1" id="comment" name="kpi_name"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="weightage">Select Weightage(%):</label>
                        <select required="" name="weightage" class="form-control cust-control" id='weightage'>
                            <option selected value="">--</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="basic-default-fullname">Target(%)</label>
                        <input required="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control cust-control" type='number' name="target" />

                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="basic-default-fullname">Eligibility Factor </label>
                        <input required="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control cust-control" type='number' name="eligi_factor" />

                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="basic-default-fullname">Remarks </label>
                        <input required=""  class="form-control cust-control" type='text' name="ramarks" />

                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                            <input class="form-control btn btn-sm btn-primary" type="submit" value="Submit to Create">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php
    }
    if (isset($_POST['kpi_name'])) {
        $v_kpi_name = $_REQUEST['kpi_name'];
        $v_kra_id = $_REQUEST['kra_id'];
        $v_weightage = $_REQUEST['weightage'];
        $v_target = $_REQUEST['target'];
        $v_ramarks = $_REQUEST['ramarks'];
        $v_eligi_factor = $_REQUEST['eligi_factor'];

        if (($v_previous_weightage + $v_weightage) > 100) {
            $error = 'Overflow. Your total weightage value must equal to 100.Please check your weaightage sum';
            echo '<div class="alert alert-danger">';
            echo $error;
            echo '</div>';
        } else {

            $strSQL  = oci_parse(
                $objConnect,
                "INSERT INTO HR_PMS_KPI_LIST (
                           KPI_NAME, 
                           HR_KRA_LIST_ID, 
                           CREATED_BY, 
                           CREATED_DATE, 
                           IS_ACTIVE,
                           WEIGHTAGE,
                           REMARKS,
                           TARGET,
                           ELIGIBILITY_FACTOR) 
                   VALUES ( 
                           '$v_kpi_name',
                            $v_kra_id,
                            '$emp_session_id',
                            sysdate,
                            1,
                            $v_weightage,
                            '$v_ramarks',
                            $v_target,
                            $v_eligi_factor
                            )"
            );

            if (@oci_execute($strSQL)) {
                echo 'KPI is created successfully.';
            } else {
                $lastError = error_get_last();
                $error = $lastError ? "" . $lastError["message"] . "" : "";
                if (strpos($error, 'ATTN_DATE_PK') !== false) {
                    echo 'Contact With IT.';
                }
            }
        }
    }
    ?>
    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>KPI Details </b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered" border="1" cellspacing="0" cellpadding="0">
                    <thead class="table-dark">
                        <tr class="text-center">

                            <th class="text-center">Sl.</th>
                            <th scope="col">Key Result Areas<br>KRA</th>
                            <th scope="col">Key Performance indicators<br>KPI</th>
                            <th scope="col">Weightage(%)<br>(Range of 5-30)</th>
                            <th scope="col">Target</th>
                            <th scope="col">Eligibility Factor</th>
                            <th scope="col">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $strSQL  = oci_parse(
                                $objConnect,
                                "select KRA_NAME,ID FROM HR_PMS_KRA_LIST WHERE CREATED_BY='$emp_session_id' AND HR_PMS_LIST_ID='$v_key' ORDER BY ID"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $table_ID   = $row['ID'];
                                $number++;
                            ?>

                                <td class="align-middle"><?php echo $number; ?></td>
                                <td class="align-middle"><?php echo $row['KRA_NAME']; ?></td>
                                <td class="align-middle">
                                    <table width="100%">
                                        <?php

                                        $slNumber   = 0;
                                        $strSQLInner  = oci_parse($objConnect, "select KPI_NAME from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $slNumber++;
                                        ?>
                                            <tr>
                                                <td height="60px"><?php echo $slNumber . '. ' . $rowIN['KPI_NAME']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td class="align-middle">
                                    <table width="100%">
                                        <?php

                                        $strSQLInner  = oci_parse($objConnect, "select WEIGHTAGE from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                        ?>
                                            <tr>
                                                <td height="60px" class="align-middle"><?php echo $rowIN['WEIGHTAGE']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td class="align-middle">
                                    <table width="100%">
                                        <?php
                                        $strSQLInner  = oci_parse($objConnect, "select TARGET from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                        ?>
                                            <tr>

                                                <td height="60px" class="align-middle"><?php echo $rowIN['TARGET']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </td>
                                <td class="align-middle">
                                    <table width="100%">
                                        <?php
                                        $strSQLInner  = oci_parse($objConnect, "select ELIGIBILITY_FACTOR from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                        ?>
                                            <tr>

                                                <td height="60px" class="align-middle"><?php echo $rowIN['ELIGIBILITY_FACTOR']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td class="align-middle">
                                    <table width="100%">
                                        <?php
                                        $slNumberR   = 0;
                                        $strSQLInner  = oci_parse($objConnect, "select REMARKS from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID ORDER BY ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $slNumberR++;
                                        ?>
                                            <tr>
                                                <td height="60px"><?php echo $slNumberR . '. ' . $rowIN['REMARKS']; ?></td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </td>


                        </tr>
                    <?php

                            }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <?php require_once('../../../layouts/footer_info.php'); ?>
    <?php require_once('../../../layouts/footer.php'); ?>