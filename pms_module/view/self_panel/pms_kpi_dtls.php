<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];

$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$v_key          = $_REQUEST['key'];

$LINE_MANAGE_1_REMARKS = null;
$LINE_MANAGE_2_REMARKS = null;
$HR_STATUS_REMARKS     = null;
$SELF_REMARKS          = null;


$strSQL = oci_parse($objConnect, "SELECT SELF_SUBMITTED_STATUS ,SELF_REMARKS, LINE_MANAGE_1_REMARKS,LINE_MANAGE_2_REMARKS,HR_STATUS_REMARKS
                                    FROM HR_PMS_EMP WHERE EMP_ID='$emp_session_id' AND HR_PMS_LIST_ID='$v_key'");
oci_execute($strSQL);
while ($row = oci_fetch_assoc($strSQL)) {
    $SUBMITTED_STATUS      = $row['SELF_SUBMITTED_STATUS'];
    $SELF_REMARKS          = $row['SELF_REMARKS'];
    $LINE_MANAGE_1_REMARKS = $row['LINE_MANAGE_1_REMARKS'];
    $LINE_MANAGE_2_REMARKS = $row['LINE_MANAGE_2_REMARKS'];
    $HR_STATUS_REMARKS     = $row['HR_STATUS_REMARKS'];
}

if (isset($_POST['kra_name'])) {

    $self_submitted_status = 0;

    $v_kra_name     = $_REQUEST['kra_name'];
    $v_pms_title_id = $_REQUEST['pms_title_id'];
    $strStatus      = oci_parse(
        $objConnect,
        "SELECT SELF_SUBMITTED_STATUS FROM HR_PMS_EMP 
                       WHERE EMP_ID='$emp_session_id'
                       AND HR_PMS_LIST_ID='$v_pms_title_id'"
    );

    if (oci_execute($strStatus)) {
        while ($row = oci_fetch_assoc($strStatus)) {
            $self_submitted_status = $row['SELF_SUBMITTED_STATUS'];
        }
    }

    if ($self_submitted_status == 0) {
        $strSQL = oci_parse(
            $objConnect,
            "INSERT INTO HR_PMS_KRA_LIST (
                             KRA_NAME,
                             HR_PMS_LIST_ID,											 
                             CREATED_BY, 
                             CREATED_DATE, 
                             IS_ACTIVE) 
                        VALUES ( 
                             '$v_kra_name',
                             '$v_pms_title_id',
                             '$emp_session_id',
                             sysdate,
                             1)"
        );
        if (@oci_execute($strSQL)) {
            $message                  = [
                'text'   => 'KRA is created successfully.',
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
        }
        else {
            $e                        = oci_error($strSQL);
            $message                  = [
                'text'   => htmlentities($e['message'], ENT_QUOTES),
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;

        }
    }
    else {

        $message                  = [
            'text'   => "You can not create new KRA  cause of this MS data are already submitted.",
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
    }
}
// Weaightage value
$v_previous_weightage = 0;
$WATESQL              = oci_parse(
    $objConnect,
    "SELECT PMS_WEIGHTAGE('$emp_session_id',$v_key) AS WEIGHTAGE  FROM DUAL"
);
oci_execute($WATESQL);
while ($row = oci_fetch_assoc($WATESQL)) {
    $v_previous_weightage = $row['WEIGHTAGE'];
}

if (isset($_POST['kpi_name'])) {
    $v_kpi_name     = $_REQUEST['kpi_name'];
    $v_kra_id       = $_REQUEST['kra_id'];
    $v_weightage    = $_REQUEST['weightage'];
    $v_target       = $_REQUEST['target'];
    $v_ramarks      = $_REQUEST['ramarks'];
    $v_eligi_factor = $_REQUEST['eligi_factor'];

    if (($v_previous_weightage + $v_weightage) > 100) {
        $error                    = 'Overflow. Your total weightage value must equal to 100.Please check your weaightage sum';
        $message                  = [
            'text'   => $error,
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
    }
    else {

        $strSQL = oci_parse(
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
            $v_previous_weightage     = $v_previous_weightage + $v_weightage;
            $message                  = [
                'text'   => 'KPI is created successfully.',
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;

        }
        else {
            $lastError                = error_get_last();
            $error                    = $lastError ? "" . $lastError["message"] . "" : "";
            $message                  = [
                'text'   => $error,
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
        }
    }
}
?>
<div class="container-xxl flex-grow-1 container-p-y">



    <?php
    if ($SUBMITTED_STATUS != 1) {
        ?>
        <div class="card col-lg-12">
            <form action="" method="post">
                <div class="card-body row  justify-content-end align-items-center">

                    <div class="col-sm-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="form-label  btn btn-sm text-white btn-warning" data-bs-toggle="modal" data-bs-target="#kraModal">
                            <i class='bx bxs-location-plus'></i> Add KRA ?
                        </button>
                        <select required="" name="kra_id" class="form-control text-center cust-control" id='kra_id'>
                            <option hidden value=""><- selecte KRA -></option>

                            <?php
                            $query = "SELECT BB.ID,
                                    BB.KRA_NAME,
                                    (select  PMS_NAME  FROM HR_PMS_LIST WHERE id=BB.HR_PMS_LIST_ID) PMS_NAME,
                                    (SELECT A.SELF_SUBMITTED_STATUS FROM HR_PMS_EMP A WHERE A.HR_PMS_LIST_ID=BB.HR_PMS_LIST_ID 
                                    AND A.EMP_ID='$emp_session_id')SUBMITTED_STATUS,
                                    CREATED_BY,
                                    CREATED_DATE,UPDATED_DATE,
                                    IS_ACTIVE 
                                FROM HR_PMS_KRA_LIST BB
                                WHERE BB.CREATED_BY='$emp_session_id'";


                                $strSQL = oci_parse($objConnect, $query);
                                oci_execute($strSQL);
                                while ($row = oci_fetch_assoc($strSQL)) {

                            ?>
                                <option value="<?php echo $row['ID']; ?>">
                                    <?php echo $row['KRA_NAME']; ?>
                                </option>
                            <?php }  ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="weightage">Remain Weightage <span class="text-danger">*</span>
                            <strong class="text-info">(
                                <?php echo 100 - $v_previous_weightage ?>%)
                            </strong>
                        </label>
                        <select required="" name="weightage" class="form-control text-center cust-control" id='weightage'>
                            <option hidden value=""><- selecte Weightage -></option>

                            <option value="5">5 (%)</option>
                            <option value="10">10 (%)</option>
                            <option value="15">15 (%)</option>
                            <option value="20">20 (%)</option>
                            <option value="25">25 (%)</option>
                            <option value="30">30 (%)</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="basic-default-fullname">Target(%) <span class="text-danger">*</span></label>
                        <input required="" value="100 (%)" style="background-color: #d9dee3;" onkeypress="return false;" class="form-control cust-control"
                            type='text'>
                        <input type="hidden" name="target" value="100">
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="basic-default-fullname">Eligibility Factor <span class="text-danger">*</span> </label>

                        <select required="" name="eligi_factor" class="form-control text-center cust-control" id='weightage'>
                            <option selected hidden value=""><- selecte Eligibility Factor -></option>
                            <option value="60">60 (%)</option>
                            <option value="70">70 (%)</option>
                            <option value="80">80 (%)</option>
                            <option value="90">90 (%)</option>
                            <option value="100">100 (%)</option>
                        </select>

                    </div>
                    <div class="col-sm-6 mt-2">
                        <label class="form-label" for="basic-default-fullname">KPI Name <span class="text-danger">*</span></label>
                        <input required="" class="form-control cust-control" type='text' name="kpi_name">

                    </div>
                    <div class="col-sm-6 mt-2">
                        <label class="form-label" for="basic-default-fullname">Any Comment ?</label>
                        <input class="form-control cust-control"" type='text' name=" ramarks">
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

    ?>
    <!-- Bordered Table -->
    <div class="card mt-2">
        <h5 class="card-header"><i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i><b>KPI Details </b></h5>
        <div class="card-body">
            <div class="table-responsive text-break">
                <table class="table table-bordered" border="1" cellspacing="0" cellpadding="0">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th scope="col">Key Result Areas (KRA)</th>
                            <th colspan="5">
                                <table class="table table-bordered text-break" width="100%">
                                    <th style="width: 45%;" scope="col">Key Performance indicators<br>(KPI)</th>
                                    <th style="width: 15%;" scope="col">Weightage<br>(5%-30%)</th>
                                    <th style="width: 10%;" scope="col">Target</th>
                                    <th style="width: 10%;" scope="col">Eligibility Factor</th>
                                    <th style="width: 20%;" scope="col">Comment</th>
                                </table>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $strSQL = oci_parse(
                                $objConnect,
                                "select A.KRA_NAME,A.ID FROM HR_PMS_KRA_LIST A WHERE A.CREATED_BY='$emp_session_id' AND A.HR_PMS_LIST_ID='$v_key' ORDER BY A.ID"
                            );
                            oci_execute($strSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($strSQL)) {
                                $table_ID = $row['ID'];
                                $number++;
                                ?>
                                <td class="align-middle gap-2">
                                    <?php if ($SUBMITTED_STATUS != 1) { ?>
                                        <a class="btn btn-sm btn-warning" style="padding: 1%;" href="pms_kra_edit.php?id=<?php echo $table_ID; ?>"><i
                                                class="menu-icon tf-icons bx bx-edit" style="margin:0;font-size:16px"></i></a>
                                    <?php } ?>
                                    <?php echo $row['KRA_NAME']; ?>


                                </td>
                                <td colspan="5">
                                    <table class="table table-bordered text-break" width="100%">
                                        <?php

                                        $slNumber    = 0;
                                        $strSQLInner = oci_parse($objConnect, "SELECT ID, KPI_NAME,WEIGHTAGE,TARGET,ELIGIBILITY_FACTOR,REMARKS from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $slNumber++;
                                            ?>
                                            <tr>
                                                <td style="width: 45%;">
                                                    <?php if ($SUBMITTED_STATUS != 1) { ?>
                                                        <a class="btn btn-info btn-sm" style="padding: 1%;"
                                                            href="pms_kpi_list_edit.php?id=<?php echo $rowIN['ID']; ?>"><i class="menu-icon tf-icons bx bx-edit"
                                                                style="margin:0;font-size:16px"></i></a>
                                                    <?php } ?>

                                                    <?php echo $rowIN['KPI_NAME']; ?>
                                                </td>
                                                <td style="width: 15%;text-align:center ">
                                                    <span class="WEIGHTAGE">
                                                        <?php echo $rowIN['WEIGHTAGE']; ?>
                                                    </span>
                                                </td>
                                                <td style="width: 10%;text-align:center ">
                                                    <?php echo $rowIN['TARGET']; ?>
                                                </td>
                                                <td style="width: 10%;text-align:center ">
                                                    <?php echo $rowIN['ELIGIBILITY_FACTOR']; ?>
                                                </td>
                                                <td style="width: 20%;">
                                                    <?php echo $rowIN['REMARKS']; ?>
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
                    <tfoot>
                        <tr>
                            <!-- <td  class="text-right">
                             

                            </td> -->
                            <td colspan="2" class="text-center">
                                <strong>
                                    Total Weightage :
                                </strong> <strong style="text-decoration-line: underline;text-decoration-style: double;" id="sum">0</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>



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
                                <h4 class="title shadow-none bg-light rounded">Line Manager</h4>
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

                                <h4 class="title shadow-none bg-light rounded"> Head Of Department </h4>
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

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="kraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><i class='bx bxs-message-square-add'></i> KRA Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="exampleInputEmail1">KRA Name:</label>
                            <input required="" style="padding:5px !important" name="kra_name" placeholder="Enter KRA Name"
                                class="form-control cust-control" type='text'>
                        </div>
                        <div class="col-12">
                            <label for="exampleInputEmail1">Select PMS Title:</label>
                            <select required="" name="pms_title_id" class="form-control cust-control">
                                <option value="" selected><-Select PMS -></option>

                                <?php

                                $strSQL = oci_parse($objConnect, "select ID,PMS_NAME from HR_PMS_LIST where is_active=1");
                                oci_execute($strSQL);
                                while ($row = oci_fetch_assoc($strSQL)) {
                                    ?>

                                    <option value="<?php echo $row['ID']; ?>" selected>
                                        <?php echo $row['PMS_NAME']; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>
<script>
    calc_total();
    function calc_total() {
        var sum = 0;
        $(".WEIGHTAGE").each(function () {
            sum += parseFloat($(this).text());
        });
        $('#sum').text(sum);
    }
</script>