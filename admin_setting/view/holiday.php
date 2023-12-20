<?php
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$errorMsg       = '';
$basePath       = $_SESSION['basePath'];
if (!checkPermission('holiday-list')) {
    echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
}

?>

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body col-12 ">

        <form action="" method="post">
            <div class="row">
                <div class="col-4">
                    <label for="exampleInputEmail1">Select Date:</label>
                    <input required="" class="form-control cust-control" id="date" name="holiday_date" type="date">
                </div>
                <div class="col-4">
                    <label for="exampleInputEmail1">Select Type:</label>
                    <select required="" name="holiday_type" class="form-control cust-control">
                        <option selected value="">---</option>
                        <option value="W">Weekend</option>
                        <option value="H">Holiday</option>
                    </select>
                </div>
                <?php
                $allRole = ((getUserAccessRoleByID($_SESSION['HR']['id_hr'])));
                if (in_array('Concern', $allRole)) { ?>
                    <div class="col-4">
                        <label for="exampleInputEmail1">Select Concern:</label>
                        <select required="" name="emp_concern" class="form-control cust-control">
                            <option selected value="">---</option>
                            <option value="RMWL">Workshoop</option>
                        </select>
                    </div>
                <?php }
                else { ?>
                    <div class="col-4">
                        <label for="exampleInputEmail1">Select Concern:</label>
                        <select required="" name="emp_concern" class="form-control cust-control">
                            <option selected value="">---</option>
                            <option value="ALL">ALL</option>
                            <option value="RG">RG</option>
                            <option value="RML">RML</option>
                            <option value="RCL">RCL</option>
                            <option value="RMWL">Workshoop</option>
                            <option value="SASH">Amishe</option>
                            <option value="RIL">RIL</option>
                            <option value="RREL">RREL</option>
                            <option value="TL">TL</option>
                        </select>
                    </div>
                <?php } ?>
            </div>
            <div class="">
                <div class="col-12">
                    <div class="md-form mt-3">
                        <label for="comment">Holiday Remarks:</label>
                        <textarea required="" class="form-control" rows="2" id="comment" name="holiday_ramarks"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8"> </div>
                <div class="col-4">
                    <div class="md-form mt-3">
                        <input class="form-control btn btn btn-primary" type="submit" value="Submit to Create">
                    </div>
                </div>
            </div>
        </form>
    </div>
    </br>
    <?php
    if (isset($_POST['holiday_date'])) {
        $emp_session_id  = $_SESSION['HR']['emp_id_hr'];
        $holiday_date    = date("d/m/Y", strtotime($_REQUEST['holiday_date']));
        $emp_concern     = $_REQUEST['emp_concern'];
        $holiday_type    = $_REQUEST['holiday_type'];
        $holiday_ramarks = $_REQUEST['holiday_ramarks'];

        if (isset($_POST['holiday_type'])) {
            $strSQL = oci_parse(
                $objConnect,
                "INSERT INTO RML_COLL_ATTN_HOLIDAY (
					   ATTN_DATE, STATUS, 
					   ENTRY_DATE, REMARKS, CONCERN, 
					   ENTRY_BY) 
					VALUES ( TO_DATE('$holiday_date','dd/mm/yyyy') , 
					 '$holiday_type' ,
					  SYSDATE ,
					 '$holiday_ramarks' ,
					 '$emp_concern' ,
					 '$emp_session_id' )"
            );
            if (@oci_execute($strSQL)) {
                $errorMsg = 'Holiday/Weekend is created successfully.';

                echo '<div class="alert alert-primary">';
                echo $errorMsg;
                echo '</div>';
                unset($errorMsg);
            }
            else {

                $lastError = error_get_last();
                $error     = $lastError ? "" . $lastError["message"] . "" : "";
                if (strpos($error, 'DATE_CONCERN_CONSTRAIN') !== false) {
                    $errorMsg = 'This Holiday/Weekend is already created. You can not create duplicate holiday or weekend at same day.';

                    echo '<div class="alert alert-danger">';
                    echo $errorMsg;
                    echo '</div>';
                    unset($errorMsg);
                }
            }
        }
    }
    ?>



    <!-- Bordered Table -->
    <div class="card">
        <h5 class="card-header"><u><b>Last 20 Holiday List : </b></u></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th scope="col">Sl</th>
                            <th scope="col">Group Concern</th>
                            <th scope="col">Date</th>
                            <th scope="col">Type</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Create Date</th>
                            <th scope="col">Created By</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $allRole = ((getUserAccessRoleByID($_SESSION['HR']['id_hr'])));
                        if (in_array('Concern', $allRole)) {
                            $query = "SELECT * FROM
(
select CONCERN,
        ATTN_DATE,
        STATUS,
        REMARKS,
        ENTRY_DATE,
        (SELECT A.EMP_NAME FROM RML_HR_APPS_USER A WHERE A.RML_ID=ENTRY_BY) AS ENTRY_BY
    from RML_COLL_ATTN_HOLIDAY Where CONCERN = 'RMWL'
    order by ATTN_DATE DESC
)
WHERE ROWNUM<=10";
                        }
                        else {
                            $query = "SELECT * FROM
    (
    select CONCERN,
            ATTN_DATE,
            STATUS,
            REMARKS,
            ENTRY_DATE,
            (SELECT A.EMP_NAME FROM RML_HR_APPS_USER A WHERE A.RML_ID=ENTRY_BY) AS ENTRY_BY
        from RML_COLL_ATTN_HOLIDAY
        order by ATTN_DATE DESC
    )
    WHERE ROWNUM<=10";
                        }
                        $allDataSQL = oci_parse(
                            $objConnect, $query

                        );

                        oci_execute($allDataSQL);
                        $number = 0;
                        while ($row = oci_fetch_assoc($allDataSQL)) {
                            $number++;
                            ?>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                        <?php echo $number; ?>
                                    </strong>
                                </td>
                                <td>
                                    <?php echo $row['CONCERN']; ?>
                                </td>
                                <td>
                                    <?php echo $row['ATTN_DATE']; ?>
                                </td>
                                <td>
                                    <?php echo $row['STATUS']; ?>
                                </td>
                                <td>
                                    <?php echo $row['REMARKS']; ?>
                                </td>
                                <td>
                                    <?php echo $row['ENTRY_DATE']; ?>
                                </td>
                                <td>
                                    <?php echo $row['ENTRY_BY']; ?>
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
    <!--/ Bordered Table -->



</div>

<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>