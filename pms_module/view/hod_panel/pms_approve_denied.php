<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
// if (!checkPermission('concern-offboarding-create')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$v_key          = $_REQUEST['key'];
$v_emp_id       = $_REQUEST['emp_id'];
$v_emp_table_id = $_REQUEST['tab_id'];

$strSQL = oci_parse(
    $objConnect,
    "select RML_ID,
EMPLOYEE_NAME EMP_NAME,
COMPANY_NAME R_CONCERN,
DEPARTMENT DEPT_NAME,
WORKSTATION BRANCH_NAME,
DESIGNATION,
BRAND EMP_GROUP,
COLL_HR_EMP_NAME((SELECT aa.LINE_MANAGER_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)) LINE_MANAGER_1_NAME,
COLL_HR_EMP_NAME((SELECT aa.DEPT_HEAD_RML_ID from RML_HR_APPS_USER aa where aa.RML_ID=bb.RML_ID)) LINE_MANAGER_2_NAME
from empinfo_view_api@ERP_PAYROLL bb where BB.RML_ID='$v_emp_id'"
);
oci_execute($strSQL);

$LINE_MANAGER_2_STATUS = '';
$strSQLsss             = oci_parse(
    $objConnect,
    "select LINE_MANAGER_2_STATUS from HR_PMS_EMP where ID=$v_emp_table_id "
);

oci_execute($strSQLsss);
while ($rowrr = oci_fetch_assoc($strSQLsss)) {
    $v_line_manager_status = $rowrr['LINE_MANAGER_2_STATUS'];
}

$commentSQL = oci_parse($objConnect, "SELECT SELF_SUBMITTED_STATUS ,SELF_REMARKS, LINE_MANAGE_1_REMARKS,
LINE_MANAGE_2_REMARKS,HR_STATUS_REMARKS
                                    FROM HR_PMS_EMP WHERE ID='$v_emp_table_id'");
oci_execute($commentSQL);
while ($row = oci_fetch_assoc($commentSQL)) {
  
    $SUBMITTED_STATUS      = $row['SELF_SUBMITTED_STATUS'];
    $SELF_REMARKS          = $row['SELF_REMARKS'];
    $LINE_MANAGE_1_REMARKS = $row['LINE_MANAGE_1_REMARKS'];
    $LINE_MANAGE_2_REMARKS = $row['LINE_MANAGE_2_REMARKS'];
    $HR_STATUS_REMARKS     = $row['HR_STATUS_REMARKS'];
}

?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="row card-body">
            <form action="<?php echo $basePath . '/pms_module/action/hod_panel.php' ?>" method="post">
                <input type="hidden" name="actionType" value="pms_approved_denied">
                <input type="hidden" name="hr_pms_pms_emp_table_id" value="<?php echo $v_emp_table_id ?>">
                <div class="">
                    <?php
                    while ($row = oci_fetch_assoc($strSQL)) {
                        ?>

                        <div class="row">
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Employee ID:</label>
                                <input name="emp_id" readonly placeholder="EMP-ID" class="form-control cust-control" type='text'
                                    value='<?php echo $row['RML_ID']; ?>' />
                            </div>
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Employee Name:</label>
                                <input required="" name="emp_name" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                    value='<?php echo $row['EMP_NAME']; ?>' />
                            </div>
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Employee Designation:</label>
                                <input required="" name="emp_name" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                    value='<?php echo $row['DESIGNATION']; ?>' />
                            </div>
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Employee Department:</label>
                                <input required="" name="emp_dep" readonly placeholder="EMP dep" class="form-control cust-control" type='text'
                                    value='<?php echo $row['DEPT_NAME']; ?>' />
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">PMS Line Manager-1:</label>
                                <input class="form-control cust-control" required="" readonly type='text'
                                    value='<?php echo $row['LINE_MANAGER_1_NAME']; ?>' />
                            </div>
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">PMS Line Manager-2:</label>
                                <input required="" required="" class="form-control cust-control" readonly type='text'
                                    value='<?php echo $row['LINE_MANAGER_2_NAME']; ?>' />
                            </div>
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Employee Group:</label>
                                <input required="" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                    value='<?php echo $row['EMP_GROUP']; ?>' />
                            </div>
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Employee Branch:</label>
                                <input required="" readonly placeholder="EMP Name" class="form-control cust-control" type='text'
                                    value='<?php echo $row['BRANCH_NAME']; ?>' />
                            </div>
                        </div>

                        <?php
                        if ($v_line_manager_status == "") {
                            ?>
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="basic-default-fullname">Comment</label>
                                    <input required="" name="remarks" placeholder="Approval Or Denied Remarks" class="form-control cust-control" type="text">
                                </div>
                                <div class="col-sm-3">

                                    <label class="form-label" for="basic-default-fullname">Select Type</label>
                                    <select name="app_status" class="form-control cust-control" required="">
                                        <option selected="" value="">---</option>
                                        <option value="1">Approve</option>
                                        <option value="0">Denied</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <div class="md-form">
                                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                                        <input class="form-control btn btn-primary cust-control" type="submit" value="Submit">
                                    </div>
                                </div>

                            </div>

                            <?php
                        }
                    }
                    ?>


                </div>

            </form>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>
                <?php echo $_GET['emp_id'] ?> For PMS DEtails
            </b></h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered" border="1" cellspacing="0" cellpadding="0">
                    <thead style="background: beige;">
                        <tr class="text-center">
                            <th class="">Sl <br>No</th>
                            <th scope="col">KRA(Key Result Areas)<br>KRA</th>
                            <th scope="col">KPI (Key Performance indicators)<br>KPI</th>
                            <th scope="col">Weightage (%) <br>(Range of 5-30)</th>
                            <th scope="col">Target</th>
                            <th scope="col">Remarks</th>
                        </tr>
                    </thead>


                    <tbody>
                        <tr>
                            <?php
                            $strSQL = oci_parse(
                                $objConnect,
                                "select KRA_NAME,ID
							        FROM HR_PMS_KRA_LIST WHERE CREATED_BY='$v_emp_id' AND HR_PMS_LIST_ID='$v_key' ORDER BY ID"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $table_ID = $row['ID'];
                                $number++;
                                ?>

                                <td class="align-middle">
                                    <?php echo $number; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['KRA_NAME']; ?>
                                </td>
                                <td class="align-middle">
                                    <table width="100%">
                                        <?php

                                        $slNumber    = 0;
                                        $strSQLInner = oci_parse($objConnect, "select KPI_NAME from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $slNumber++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $slNumber . '. ' . $rowIN['KPI_NAME']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td class="align-middle">
                                    <table width="100%">
                                        <?php

                                        $strSQLInner = oci_parse($objConnect, "select WEIGHTAGE from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <?php echo $rowIN['WEIGHTAGE']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </td>

                                <td class="align-middle">
                                    <table width="100%">
                                        <?php
                                        $strSQLInner = oci_parse($objConnect, "select TARGET from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            ?>
                                            <tr>

                                                <td class="align-middle">
                                                    <?php echo $rowIN['TARGET']; ?>
                                                </td>
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
                                        $strSQLInner = oci_parse($objConnect, "select REMARKS from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID ORDER BY ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $slNumberR++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $slNumberR . '. ' . $rowIN['REMARKS']; ?>
                                                </td>

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
    <!--/ Bordered Table -->

    <style>
        .card-big-shadow {
            max-width: 320px;
            position: relative;
        }

        .coloured-cards .card {
            margin-top: 30px;
        }

        .card[data-radius="none"] {
            border-radius: 0px;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 2px rgba(204, 197, 185, 0.5);
            background-color: #FFFFFF;
            color: #252422;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }


        .card[data-background="image"] .title,
        .card[data-background="image"] .stats,
        .card[data-background="image"] .category,
        .card[data-background="image"] .description,
        .card[data-background="image"] .content,
        .card[data-background="image"] .card-footer,
        .card[data-background="image"] small,
        .card[data-background="image"] .content a,
        .card[data-background="color"] .title,
        .card[data-background="color"] .stats,
        .card[data-background="color"] .category,
        .card[data-background="color"] .description,
        .card[data-background="color"] .content,
        .card[data-background="color"] .card-footer,
        .card[data-background="color"] small,
        .card[data-background="color"] .content a {
            color: #7e6e34;
        }

        .card.card-just-text .content {
            padding: 15px 15px;
            text-align: center;
        }

        .card .content {
            padding: 20px 20px 10px 20px;
        }

        .card[data-color="blue"] .category {
            color: #7a9e9f;
        }

        .card .category,
        .card .label {
            font-size: 14px;
            margin-bottom: 0px;
        }

        .card-big-shadow:before {
            background-image: url("http://static.tumblr.com/i21wc39/coTmrkw40/shadow.png");
            background-position: center bottom;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            bottom: -12%;
            content: "";
            display: block;
            left: -12%;
            position: absolute;
            right: 0;
            top: 0;
            z-index: 0;
        }

        h4,
        .h4 {
            font-size: 1.5em;
            font-weight: 600;
            line-height: 1.2em;
        }

        h6,
        .h6 {
            font-size: 0.9em;
            font-weight: 600;
            text-transform: uppercase;
        }

        .card .description {
            font-size: 16px;
            color: #66615b;
        }

        .content-card {
            /* margin-top: 30px; */
        }

        a:hover,
        a:focus {
            text-decoration: none;
        }

        .card-just-text {
            min-height: 240px !important;
        }

        /*======== COLORS ===========*/
        .card[data-color="blue"] {
            background: #b8d8d8;
        }

        .card[data-color="blue"] .description {
            color: #506568;
        }

        .card[data-color="green"] {
            background: #d5e5a3;
        }

        .card[data-color="green"] .description {
            color: #60773d;
        }

        .card[data-color="green"] .category {
            color: #92ac56;
        }

        .card[data-color="yellow"] {
            background: #ffe28c;
        }

        .card[data-color="yellow"] .description {
            color: #b25825;
        }

        .card[data-color="yellow"] .category {
            color: #d88715;
        }

        .card[data-color="brown"] {
            background: #d6c1ab;
        }

        .card[data-color="brown"] .description {
            color: #75442e;
        }

        .card[data-color="brown"] .category {
            color: #a47e65;
        }

        .card[data-color="purple"] {
            background: #baa9ba;
        }

        .card[data-color="purple"] .description {
            color: #3a283d;
        }

        .card[data-color="purple"] .category {
            color: #5a283d;
        }

        .card[data-color="orange"] {
            background: #ff8f5e;
        }

        .card[data-color="orange"] .description {
            color: #772510;
        }

        .card[data-color="orange"] .category {
            color: #e95e37;
        }
    </style>
    <div class="card">
        <u>
            <h4 class="text-center card-header"> Comment Section Area <i style="font-size: 30px;
            color: lightseagreen;" class='bx bxs-message-rounded-dots'></i>
            </h4>
        </u>
        <div class="card">
            <div class="card-body row">
                <div class="col-md-3  col-sm-4 content-card">
                    <div class="card-big-shadow">
                        <div class="card card-just-text" data-background="color" data-color="blue" data-radius="none">
                            <div class="content">
                                <!-- <h6 class="category">Best cards</h6> -->
                                <h4 class="title shadow-none bg-light rounded">Self </h4>
                                <p class="description">
                                    <?php echo $SELF_REMARKS ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3  col-sm-4 content-card">
                    <div class="card-big-shadow">
                        <div class="card card-just-text" data-background="color" data-color="green" data-radius="none">
                            <div class="content">
                                <h4 class="title shadow-none bg-light rounded">LM. </h4>
                                <p class="description">
                                    <?php echo $LINE_MANAGE_1_REMARKS ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3  col-sm-4 content-card">
                    <div class="card-big-shadow">
                        <div class="card card-just-text" data-background="color" data-color="yellow" data-radius="none">
                            <div class="content">

                                <h4 class="title shadow-none bg-light rounded">H.O.D. </h4>
                                <p class="description">
                                    <?php echo $LINE_MANAGE_2_REMARKS ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3  col-sm-4 content-card">
                    <div class="card-big-shadow">
                        <div class="card card-just-text" data-background="color" data-color="brown" data-radius="none">
                            <div class="content">
                                <h4 class="title shadow-none bg-light rounded">HR </h4>
                                <p class="description">
                                    <?php echo $HR_STATUS_REMARKS ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>