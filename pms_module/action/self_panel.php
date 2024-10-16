<?php
session_start();
require_once('../../inc/config.php');
require_once('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath = $_SESSION['basePath'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'kpi_achivement') {

    $editId = $_POST['editId'];
    $ACHIVEMENT = $_POST['achivement'];
    // $ACHIVEMENT_COMMENTS = $_POST['ACHIVEMENT_COMMENTS'];
    $achievementComments = str_replace("'", "''", $_POST['ACHIVEMENT_COMMENTS']); // Escape single quotes
    $achievementComments = trim($achievementComments); // Remove extra whitespace

    $strSQL = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET  ACHIVEMENT='$ACHIVEMENT', ACHIVEMENT_COMMENTS ='$ACHIVEMENT_COMMENTS' WHERE ID='$editId'");
    if (oci_execute($strSQL)) {
        $message = [
            'text' => 'KPI Achivement Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_list.php'</script>";
    } else {
        $e = oci_error($strSQL);
        $message = [
            'text' => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_list.php'</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'kra_edit') {

    $editId = $_POST['editId'];
    // $v_kra_name = $_POST['kra_name'];
    $v_kra_name = trim(str_replace("'", "''", $_POST['kra_name']));
    $HR_PMS_LIST_ID = $_POST['pms_title_id'];
    $query = "UPDATE  HR_PMS_KRA_LIST SET KRA_NAME = '$v_kra_name', HR_PMS_LIST_ID = '$HR_PMS_LIST_ID' , UPDATED_DATE = SYSDATE WHERE ID='$editId'";
    $strSQL = oci_parse($objConnect, $query);

    if (oci_execute($strSQL)) {
        $message = [
            'text' => 'KRA is Edited successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kra_edit.php?id=$editId'</script>";
    } else {

        $e = oci_error($strSQL);
        $message = [
            'text' => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_kra_edit.php?id=$editId'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'com_update') {

    $editId = $_POST['editId'];
    $SELF_REMARKS = trim(str_replace("'", "''", $_POST['SELF_REMARKS']));
    $query = "UPDATE  HR_PMS_EMP SET SELF_REMARKS = '$SELF_REMARKS' WHERE ID='$editId'";
    $strSQL = oci_parse($objConnect, $query);

    if (oci_execute($strSQL)) {
        $message = [
            'text' => 'Self Comment updated Successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_list_self.php'</script>";
    } else {

        $e = oci_error($strSQL);
        $message = [
            'text' => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_list_self.php'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'kra_update') {

    $editId = $_POST['editId'];
    $key = $_POST['key'];
    // $v_kra_name = $_POST['kra_name'];
    $v_kra_name = trim(str_replace("'", "''", $_POST['kra_name']));
    $HR_PMS_LIST_ID = $_POST['pms_title_id'];
    $query = "UPDATE  HR_PMS_KRA_LIST SET KRA_NAME = '$v_kra_name', HR_PMS_LIST_ID = '$HR_PMS_LIST_ID' , UPDATED_DATE = SYSDATE WHERE ID='$editId'";
    $strSQL = oci_parse($objConnect, $query);

    if (oci_execute($strSQL)) {
        $message = [
            'text' => 'KRA is Edited successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_dtls.php?key=$key'</script>";
    } else {

        $e = oci_error($strSQL);
        $message = [
            'text' => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_dtls.php?key=$key'</script>";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'SUBMIT_PMS_DATA') {

    $pmsID = trim($_POST["pms_id"]);
    $updateSQL = @oci_parse(
        $objConnect,
        "UPDATE HR_PMS_EMP SET  SELF_SUBMITTED_STATUS = 1, SELF_SUBMITTED_DATE = SYSDATE , LINE_MANAGER_1_STATUS = null WHERE ID = '$pmsID' AND IS_ACTIVE=1"
    );

    // Execute the query
    if (@oci_execute($updateSQL)) {

        $response = [
            'status'  => true,
            'message' => 'PMS Submited Succesfully!'
        ];
        print_r(json_encode($response));
    } else {
        $e        = @oci_error($strSQL);
        $response = [
            'status'  => true,
            'message' => htmlentities($e['message'], ENT_QUOTES)
        ];
        print_r( json_encode($response));
    }
    // echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_list_self.php'</script>";

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'ajaxcom_edit') {
    $editId = $_POST['editId'];
    $query = "SELECT ID,SELF_REMARKS FROM HR_PMS_EMP WHERE ID = $editId";
    $strSQL = oci_parse($objConnect, $query);

    if (oci_execute($strSQL)) {
        $data = oci_fetch_assoc($strSQL);

        echo '<input type="hidden" name="editId" value="' . $editId . '"><div class="row">
            <div class="col-12">
                <textarea  name="SELF_REMARKS" placeholder="Enter your comment" rows="3" 
                class="form-control" type="text">'.  $data['SELF_REMARKS'] .'</textarea>
            </div>';
    } else {
        echo 'Something went wrong!';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'ajaxkra_edit') {
    $editId = $_POST['editId'];
    $query = "SELECT ID, KRA_NAME, HR_PMS_LIST_ID FROM HR_PMS_KRA_LIST WHERE ID = $editId";
    $strSQL = oci_parse($objConnect, $query);

    if (oci_execute($strSQL)) {
        $data = oci_fetch_assoc($strSQL);

        echo '<input type="hidden" name="editId" value="' . $editId . '"><div class="row">
            <div class="col-sm-6">
                <label for="exampleInputEmail1">KRA Name:</label>
                <input required="" value="' . $data['KRA_NAME'] . '" style="padding:5px !important" name="kra_name" placeholder="Enter KRA Name" class="form-control cust-control" type="text">
            </div>
            <div class="col-sm-4">
                <label for="exampleInputEmail1">Select PMS Title:</label>
                <select required="" name="pms_title_id" class="form-control cust-control">
                    <option value=""><-Select PMS -></option>';

        $strSQL = oci_parse($objConnect, "SELECT ID, PMS_NAME from HR_PMS_LIST where is_active=1");
        oci_execute($strSQL);

        while ($row = oci_fetch_assoc($strSQL)) {
            echo '<option value="' . $row['ID'] . '" ' . ($data['HR_PMS_LIST_ID'] == $row['ID'] ? 'selected' : '') . '>' . $row['PMS_NAME'] . '</option>';
        }

        echo '</select>
                </div>
            </div>';
    } else {
        echo 'Something went wrong!';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'ajaxkpi_edit') {
    $v_ACHIEVEMENT_LOCK_STATUS = 0;
    $editID = $_REQUEST['editID'];
    $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
    $query = "SELECT KPI_NAME, HR_KRA_LIST_ID, ACHIEVEMENT_LOCK_STATUS, WEIGHTAGE, REMARKS, TARGET, ELIGIBILITY_FACTOR, ACHIVEMENT, (SELECT SELF_SUBMITTED_STATUS FROM HR_PMS_EMP WHERE IS_ACTIVE=1 AND EMP_ID='$emp_session_id' AND HR_PMS_LIST_ID=(SELECT HR_PMS_LIST_ID FROM HR_PMS_KRA_LIST WHERE ID=HR_KRA_LIST_ID)) SUBMITTED_STATUS FROM HR_PMS_KPI_LIST WHERE ID=$editID";
    $strSQL = oci_parse($objConnect, $query);

    if (oci_execute($strSQL)) {
        $row = oci_fetch_assoc($strSQL);
        $kra_id = $row['HR_KRA_LIST_ID'];
        $v_ACHIEVEMENT_LOCK_STATUS = $row['ACHIEVEMENT_LOCK_STATUS'];

        echo '<div class="row">
        <input type="hidden" name="editId" value="' . $editID . '">
        <input type="hidden" name="v_ACHIEVEMENT_LOCK_STATUS" value="' . $v_ACHIEVEMENT_LOCK_STATUS . '">
            <div class="col-12 ">
                <label for="exampleInputEmail1">KPI Name:</label>
                <textarea class="form-control " rows="2" id="comment" name="kpi_name">' . $row["KPI_NAME"] . '</textarea>
            </div>
            <div class="col-3 mt-3">
                <label for="exampleInputEmail1">Select KRA Title:</label>
                <select required name="kra_id" class="form-control cust-control">
                    <option hidden value="">--</option>';

        $strSQL = oci_parse($objConnect, "SELECT ID, KRA_NAME FROM HR_PMS_KRA_LIST WHERE IS_ACTIVE=1 AND CREATED_BY='$emp_session_id' ORDER BY ID");
        oci_execute($strSQL);
        while ($row1 = oci_fetch_assoc($strSQL)) {
            echo '<option value="' . $row1['ID'] . '" ' . ($kra_id == $row1['ID'] ? 'selected' : '') . '>' . $row1['KRA_NAME'] . '</option>';
        }

        echo '</select>
            </div>
            <div class="col-3 mt-3">
                <label for="exampleInputEmail1">Select Weightage(%):</label>
                <select required name="weightage" class="form-control cust-control">
                    <option value="' . $row['WEIGHTAGE'] . '">' . $row['WEIGHTAGE'] . '</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class="col-3 mt-3">
                <label for="exampleInputEmail1">Select Target(%):</label>
                <input required readonly class="form-control cust-control" type="number" name="target" value="' . $row['TARGET'] . '" />
            </div>
            <div class="col-3 mt-3">
                <label for="exampleInputEmail1">Eligibility Factor:</label>
                <select required="" name="eli_factor" class="form-control cust-control">
                        <option selected value="' . $row['ELIGIBILITY_FACTOR'] . '">
                            ' . $row['ELIGIBILITY_FACTOR'] . '
                        </option>
                        <option value="60">60 (%)</option>
                        <option value="70">70 (%)</option>
                        <option value="80">80 (%)</option>
                        <option value="90">90 (%)</option>
                        <option value="100">100 (%)</option>
                    </select>
            </div>
            <div class="col-12 mt-3">
                <label for="comment">Comment:</label>
                <textarea class="form-control "  rows="2" id="comment" name="ramarks">' . $row["REMARKS"] . '</textarea>
            </div>
        </div>';
    } else {
        echo 'Something went wrong!';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'kpi_update') {

    $key = $_POST['key'];
    $editId = $_POST['editId'];
    $v_kpi_name = trim(str_replace("'", "''", $_POST['kpi_name']));
    $v_kra_id = $_POST['kra_id'];
    $v_weightage = $_POST['weightage'];
    $v_target = $_POST['target'];
    $v_eli_factor = $_POST['eli_factor'];
    $v_ramarks = trim(str_replace("'", "''", $_POST['ramarks'])); // Escape single quotes
    $v_achivement = isset($_POST['achivement']) ? $_POST['achivement'] : '';
    $v_ACHIEVEMENT_LOCK_STATUS = isset($_POST['v_ACHIEVEMENT_LOCK_STATUS']) ? $_POST['v_ACHIEVEMENT_LOCK_STATUS'] : '';
    if ($v_ACHIEVEMENT_LOCK_STATUS == 1) {
        $strSQL = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET ACHIVEMENT='$v_achivement' WHERE ID='$editId'");
    } else {
        $strSQL = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET 
                                           KPI_NAME='$v_kpi_name',
                                           HR_KRA_LIST_ID='$v_kra_id',
                                           WEIGHTAGE='$v_weightage',
                                           TARGET='$v_target',
                                           REMARKS='$v_ramarks',
                                           ELIGIBILITY_FACTOR='$v_eli_factor',
                                           UPDATED_DATE=SYSDATE 
                                           WHERE ID='$editId'");
    }


    if (oci_execute($strSQL)) {
        $message = [
            'text' => 'KPI is Edited successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_dtls.php?key=$key'</script>";

    } else {

        $e = oci_error($strSQL);
        $message = [
            'text' => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_dtls.php?key=$key'</script>";

    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'kpi_edit') {

    $editId = $_POST['editId'];
    $v_kpi_name = trim(str_replace("'", "''", $_POST['kpi_name']));
    $v_kra_id = $_POST['kra_id'];
    $v_weightage = $_POST['weightage'];
    $v_target = $_POST['target'];
    $v_eli_factor = $_POST['eli_factor'];
    // $v_ramarks = $_POST['ramarks'];
    $v_ramarks = trim(str_replace("'", "''", $_POST['ramarks'])); // Escape single quotes
    
    $v_achivement = isset($_POST['achivement']) ? $_POST['achivement'] : '';
    $v_ACHIEVEMENT_LOCK_STATUS = isset($_POST['v_ACHIEVEMENT_LOCK_STATUS']) ? $_POST['v_ACHIEVEMENT_LOCK_STATUS'] : '';
    if ($v_ACHIEVEMENT_LOCK_STATUS == 1) {
        $strSQL = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET ACHIVEMENT='$v_achivement' WHERE ID='$editId'");
    } else {
        $strSQL = oci_parse($objConnect, "UPDATE HR_PMS_KPI_LIST SET 
                                           KPI_NAME='$v_kpi_name',
                                           HR_KRA_LIST_ID='$v_kra_id',
                                           WEIGHTAGE='$v_weightage',
                                           TARGET='$v_target',
                                           REMARKS='$v_ramarks',
                                           ELIGIBILITY_FACTOR='$v_eli_factor',
                                           UPDATED_DATE=SYSDATE 
                                           WHERE ID='$editId'");
    }


    if (oci_execute($strSQL)) {
        $message = [
            'text' => 'KPI is Edited successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script>  window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_list_edit.php?id=$editId'</script>";
    } else {

        $e = oci_error($strSQL);
        $message = [
            'text' => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '$basePath/pms_module/view/self_panel/pms_kpi_list_edit.php?id=$editId'</script>";
    }
}