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
        $error = 'Overflow. Your total weightage value must equal to 100.Please check your weaightage sum';
        // echo '<div class="alert alert-danger">';
        // echo $error;
        // echo '</div>';
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
            // echo 'KPI is created successfully.';
            $message                  = [
                'text'   => 'KPI is created successfully.',
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;

        }
        else {
            $lastError = error_get_last();
            $error     = $lastError ? "" . $lastError["message"] . "" : "";
            // if (strpos($error, 'ATTN_DATE_PK') !== false) {
            //     echo 'Contact With IT.';

            // }
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
                <div class="card-body row justify-content-center">
                    <!-- <div class="col-sm-3">
                        <label for="exampleInputEmail1">Select KRA:</label>
                        <select required="" name="kra_id" class="form-control text-center cust-control">
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


                            $strSQL = oci_parse($objConnect, $query);
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {

                                ?>
                                <option value="<?php echo $row['ID']; ?>">
                                    <?php echo $row['KRA_NAME']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div> -->

                    <div class="col-sm-3">
                        <label class="form-label" for="kra_id">Select KRA Option <span class="text-danger">*</span></label>
                        <select required="" name="kra_id" class="form-control text-center cust-control" id='kra_id'>
                            <option selected value=""><- selecte KRA -></option>

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


                            $strSQL = oci_parse($objConnect, $query);
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {

                                ?>
                                <option value="<?php echo $row['ID']; ?>">
                                    <?php echo $row['KRA_NAME']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="weightage">Remain Weightage <span class="text-danger">*</span> <strong class="text-info">(
                                <?php echo 100 - $v_previous_weightage ?>%)
                            </strong> </label>
                        <select required="" name="weightage" class="form-control text-center cust-control" id='weightage'>
                            <option selected hidden value=""><- selecte Weightage -></option>

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
                            type='text' />
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
                    <!-- <div class="col-md-12"></div> -->
                    <div class="col-sm-6 mt-2">
                        <label class="form-label" for="basic-default-fullname">KPI Name <span class="text-danger">*</span></label>
                        <input required="" class="form-control cust-control" type='text' name="kpi_name" />

                    </div>
                    <div class="col-sm-6 mt-2">
                        <label class="form-label" for="basic-default-fullname">Any Comment ?</label>
                        <input class="form-control" type='text' name="ramarks" />
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
                <table class="table  table-bordered " border="1" cellspacing="0" cellpadding="0">
                    <thead class="table-dark">
                        <tr class="text-center">

                            <th class="text-center">Sl.</th>
                            <th scope="col">Key Result Areas<br>KRA</th>
                            <th scope="col">Key Performance indicators<br>KPI</th>
                            <th scope="col">Weightage(%)<br>(Range of 5-30)</th>
                            <th scope="col">Target</th>
                            <th scope="col">Eligibility Factor</th>
                            <th scope="col">Comment</th>
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
                                                <td >
                                                    <?php echo $slNumber . '. ' . $rowIN['KPI_NAME']; ?>
                                                    <hr>
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
                                                <td  class="align-middle">
                                                    <?php echo $rowIN['WEIGHTAGE']; ?>
                                                    <hr>
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

                                                <td  class="align-middle">
                                                    <?php echo $rowIN['TARGET']; ?>
                                                    <hr>
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
                                        $strSQLInner = oci_parse($objConnect, "select ELIGIBILITY_FACTOR from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            ?>
                                            <tr>

                                                <td  class="align-middle">
                                                    <?php echo $rowIN['ELIGIBILITY_FACTOR']; ?>
                                                    <hr>
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
                                        $strSQLInner = oci_parse($objConnect, "SELECT REMARKS from HR_PMS_KPI_LIST where HR_KRA_LIST_ID=$table_ID ORDER BY ID");
                                        oci_execute($strSQLInner);
                                        while ($rowIN = oci_fetch_assoc($strSQLInner)) {
                                            $slNumberR++;
                                            ?>
                                            <tr>
                                                <td >
                                                    <?php echo $rowIN['REMARKS']; ?>
                                                    <hr>
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




<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>