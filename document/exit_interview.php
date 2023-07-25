<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exit Interview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <style>
        .btn {
            background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
            border: none;
            color: #fff !important;
            padding: 10px 10px;
            cursor: pointer;
            font-size: 20px;
        }

        input[type="radio"] {
            appearance: none;
            border: 1px solid #d3d3d3;
            width: 30px;
            height: 30px;
            content: none;
            outline: none;
            margin: 0;
        }

        input[type="radio"]:checked {
            appearance: none;
            outline: none;
            padding: 0;
            content: none;
            border: none;
        }

        input[type="radio"]:checked::before {
            position: absolute;
            color: green !important;
            content: "\00A0\2713\00A0" !important;
            border: 1px solid #d3d3d3;
            font-weight: bolder;
            font-size: 21px;
        }

        label {
            font-weight: 600;
        }

        #main {
            /* A4 size */
            width: 21cm;
            height: 29.7cm;

            margin: 0 auto;
            padding-top: 10px;
        }

        table.bordered {
            border-collapse: collapse;
            width: 100%;
        }

        table.bordered,
        table.bordered th,
        table.bordered td {
            border: 1px solid #ccc;
        }

        fieldset {
            font-size: 12pt !important;
        }


        /* Print only one page */
        @media print {
            #main {
                width: 21cm;
                height: 29.7cm;
                /* margin: 0 auto; */
                padding-top: 10px;
            }
            #hidden{
                display: none;
            }
            table.bordered {
                border-collapse: collapse;
                width: 100%;
            }

            table.bordered,
            table.bordered th,
            table.bordered td {
                border: 1px solid #ccc;
            }

            fieldset {
                font-size: 9pt !important;
            }

            @page {
                size: A4;
                /* margin: 0; */
            }

            body {
                /* margin: 0; */
            }
        }
    </style>

</head>

<body>

    <?php
    $emp_session_id             = $_SESSION['HR']['emp_id_hr'];
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    $basePath =  $baseUrl . '/rHRT';
    date_default_timezone_set("Asia/Dhaka");
    require_once('../inc/config.php');
    require_once('../inc/connoracle.php');
    $errors = array();

    $emp_id        = ($_GET['id']) ?? ($_POST['emp_id']);
    $rml_id        = ($_GET['rml_id']) ?? ($_POST['rml_id']);

    if (!isset($emp_id) || empty($emp_id)) {
        $errors[] = 'Clearence ID is required.';
    }
    if (!isset($rml_id) || empty($rml_id)) {
        $errors[] = 'Employee RML ID is required.';
    }

    if (count($errors) > 0) {
        echo '<div class="alert alert-danger">';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        die();
    }


    $clearanceSQL  = oci_parse($objConnect, "SELECT A.RESIGNATION_DATE FROM  EMP_CLEARENCE A WHERE A.ID='$emp_id'");
    oci_execute($clearanceSQL);
    $clearanceEmpData = oci_fetch_assoc($clearanceSQL);

    $strSQL  = oci_parse(
        $objConnect,
        "SELECT RML_ID,
            EMP_NAME,
            MOBILE_NO,
            DEPT_NAME,
            IEMI_NO,
            LINE_MANAGER_RML_ID,
            LINE_MANAGER_MOBILE,
            DEPT_HEAD_RML_ID,
            DEPT_HEAD_MOBILE_NO,
            BRANCH_NAME,
            DESIGNATION,
            BLOOD,
            MAIL,
            DOJ,
            DOC,
            GENDER,
            R_CONCERN
        FROM RML_HR_APPS_USER 
        WHERE RML_ID='$rml_id'"
    );

    oci_execute($strSQL);
    $emp_info = oci_fetch_assoc($strSQL);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Defining variables
        $remarks = $_POST['remarks'] ?? null;
        $all_reason = [];
        for ($i = 1; $i <= 15; $i++) {
            array_push($all_reason, $_POST["reason_" . $i]);
        }
        $YES_NO_STATUS = implode(',', $all_reason);
        $strSQL = oci_parse(
            $objConnect,
            "INSERT INTO EXIT_CLEARENCE_FORM (
                    EMP_CLEARENCE_ID,
                    EXIT_EMP_ID,
                    YES_NO_STATUS,
                    ANY_OTHERS_REMARKS,
                    FEEDBACK_1,
                    FEEDBACK_2,
                    FEEDBACK_3,
                    FEEDBACK_4,
                    FEEDBACK_5,
                    FEEDBACK_6,
                    CLOSE_STATUS,
                    CREATED_DATE,
                    CREATED_BY)
                VALUES (
                    '$emp_id',
                    '$rml_id',
                    '$YES_NO_STATUS',
                    '$remarks',
                    '$_POST[feedback_1]',
                    '$_POST[feedback_2]',
                    '$_POST[feedback_3]',
                    '$_POST[feedback_4]',
                    '$_POST[feedback_5]',
                    '$_POST[feedback_6]',
                    '1',
                    SYSDATE,
                    '$emp_session_id')"
        );
        // print_r(oci_execute($strSQL));
        if (@oci_execute($strSQL)) {
            $message = [
                'text'   => 'Submit Successfully.',
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/document/exit_interview.php?id=$emp_id&rml_id=$rml_id");
        } else {
            $e = oci_error($strSQL);
            $error = preg_split("/\@@@@/", @$error)[1];
            $message = [
                'text'   => $error,
                'status' => 'fasle',
            ];
            $_SESSION['noti_message'] = $message;
            header("location:" . $basePath . "/document/exit_interview.php?id=$emp_id&rml_id=$rml_id");
        }
    }


    ?>

    <div style="text-align: right;" id="hidden">
        <button onclick="window.print()" class="btn"><i class="fa fa-download"></i> Download</button>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="emp_id" value="<?php echo $emp_id ?>">
        <input type="hidden" name="rml_id" value="<?php echo $rml_id ?>">
        <div id="main">
            <img style="width: 100%;" src="../images/exit_header.jpg" alt="">

            <fieldset style="margin: 10px 0; border-radius: 10px; ">
                <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                    <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                        <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                    </svg>

                    <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section I</h3>

                    <h4 style="background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px; text-align: center;">
                        <i>EMPLOYEE DETAILS</i>
                    </h4>
                </legend>


                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Employee Name
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" value="<?php echo $emp_info['EMP_NAME'] ?>" readonly style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Employee ID
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" readonly value="<?php echo $emp_info['RML_ID'] ?>" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Designation
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" readonly value="<?php echo $emp_info['DESIGNATION'] ?>" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Department
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" readonly value="<?php echo $emp_info['DEPT_NAME'] ?>" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Work Location
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" readonly value="<?php echo $emp_info['BRANCH_NAME'] ?>" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Date of Joining
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" readonly value="<?php echo $emp_info['DOJ'] ?>" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>
                    <?php
                    $exprience  = 0;
                    if ($clearanceEmpData['RESIGNATION_DATE']) {
                        $startDate = DateTime::createFromFormat('d-M-Y', $emp_info['DOJ']);
                        $endDate = DateTime::createFromFormat('d-M-Y', $clearanceEmpData['RESIGNATION_DATE']);
                        // Calculate the difference
                        $exprienceCal = $startDate->diff($endDate);
                        $years = $exprienceCal->y;
                        $months = $exprienceCal->m;
                        $days = $exprienceCal->d;
                        $exprience = $years . "/years" . " - " . $months . "/months" . " - " . $days . "/days";
                    }
                    ?>
                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Date of Resignation
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" readonly value="<?php echo $clearanceEmpData['RESIGNATION_DATE'] ? $clearanceEmpData['RESIGNATION_DATE'] : ' ' ?>" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Total Experience
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" value="<?php echo $exprience ?>" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>

                </table>


            </fieldset>
            <?php
            $exit_interviewData = [];
            $exit_interviewData = oci_parse($objConnect, "SELECT * FROM EXIT_CLEARENCE_FORM WHERE EXIT_EMP_ID ='$rml_id' AND EMP_CLEARENCE_ID ='$emp_id'");
            oci_execute($exit_interviewData);
            $exit_interviewData = oci_fetch_assoc($exit_interviewData);
                    // print_r(($exit_interviewData) );
                    // die();
            ?>
            <?php

            if (!empty($exit_interviewData) ) {
                // $exit_interviewData['YES_NO_STATUS'] = "no,no,no,no,no,no,no,no,no,no,no,no,no,no,no";
                $reason = explode(',', $exit_interviewData['YES_NO_STATUS']);

                echo '<fieldset style="margin-top: 10px; border-radius: 10px;">
                    <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                        <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                            <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                        </svg>
    
                        <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section II</h3>
    
                        <h4 style="background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px;text-align: center;">
                            <i>REASONS FOR EXIT</i>
                        </h4>
                    </legend>
    
    
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="2" style="background-color: #c7c7c7; text-align: center;">
                                <strong>What is the reason for your exit from the organiztion?</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Compensation - salary has not kept pace with the market ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                <input type="radio" name="reason_1" ' . ($reason[0] == 'yes' ? "checked" : null) . ' value="yes">
                                Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[0] == 'no' ? "checked" : null) . '  name="reason_1" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Getting better compensation offers ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[1] == 'yes' ? "checked" : null) . ' name="reason_2" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[1] == 'no' ? "checked" : null) . ' name="reason_2" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Lack of career growth/ progression for years ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[2] == 'yes' ? "checked" : null) . ' name="reason_3" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[2] == 'no' ? "checked" : null) . ' name="reason_3" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Superseded by juniors/ colleagues ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[3] == 'yes' ? "checked" : null) . ' name="reason_4" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[3] == 'no' ? "checked" : null) . ' name="reason_4" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Boss is unlikely to be promoted / retired in near future ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[4] == 'yes' ? "checked" : null) . ' name="reason_5" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[4] == 'no' ? "checked" : null) . ' name="reason_5" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Stagnation in the job ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[5] == 'yes' ? "checked" : null) . ' name="reason_6" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[5] == 'no' ? "checked" : null) . ' name="reason_6" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Job Content-getting better job profile with more responsibilities ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[6] == 'yes' ? "checked" : null) . ' name="reason_7" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[6] == 'no' ? "checked" : null) . ' name="reason_7" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Ideas/suggestions are not appreciated ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio"  ' . ($reason[7] == 'yes' ? "checked" : null) . ' name="reason_8" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[7] == 'no' ? "checked" : null) . ' name="reason_8" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        No respect for "professional" in the Organization ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[8] == 'yes' ? "checked" : null) . ' name="reason_9" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[8] == 'no' ? "checked" : null) . ' name="reason_9" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Lack of freedom ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[9] == 'yes' ? "checked" : null) . ' name="reason_10" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[9] == 'no' ? "checked" : null) . ' name="reason_10" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Company not growing / going down ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio"' . ($reason[10] == 'yes' ? "checked" : null) . ' name="reason_11" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[10] == 'no' ? "checked" : null) . ' name="reason_11" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Would like to move close to my home town/ place of residence ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[11] == 'yes' ? "checked" : null) . ' name="reason_12" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[11] == 'no' ? "checked" : null) . ' name="reason_12" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Pursuing higher studies ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[12] == 'yes' ? "checked" : null) . ' name="reason_13" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[12] == 'no' ? "checked" : null) . ' name="reason_13" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Going abroad ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[13] == 'yes' ? "checked" : null) . ' name="reason_14" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[13] == 'no' ? "checked" : null) . ' name="reason_14" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 60%">
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Family Reasons ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" ' . ($reason[14] == 'yes' ? "checked" : null) . ' name="reason_15" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" ' . ($reason[14] == 'no' ? "checked" : null) . ' name="reason_15" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Please state any other reason for separation from the Organization (if any)
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <input type="text" value="' . $exit_interviewData['ANY_OTHERS_REMARKS'] . '" id="name" name="remarks" style="border: none; outline: none; width: 100%;">
                            </td>
                        </tr>
    
    
                    </table>
                </fieldset>
                
                <div style="page-break-after: always"></div>
                <fieldset style="margin: 10px 0; border-radius: 10px; ">
                <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                    <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                        <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                    </svg>

                    <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section III</h3>

                    <h4 style="background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px; text-align: center;">
                        <i>FEEDBACK</i>
                    </h4>
                </legend>


                <table style="width: 100%;">
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    1. What did you like most about the Organization?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_1" id="" cols="10" rows="5">'.$exit_interviewData['FEEDBACK_1'].'</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    2. What did you like the least about the Organization?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_2" id="" cols="10" rows="5">'.$exit_interviewData['FEEDBACK_2'].'</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    3. What do you think to be the most important thing that should be done in order to make the Organization a better place to work for?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_3" id="" cols="10" rows="5">'.$exit_interviewData['FEEDBACK_3'].'</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    4. What change would you desire, in order to impact your decision about leaving?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_4" id="" cols="10" rows="5">'.$exit_interviewData['FEEDBACK_4'].'</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    5. If given an opportunity, would you like to join the Organization again?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_5" id="" cols="10" rows="5">'.$exit_interviewData['FEEDBACK_5'].'</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    6. Will you recommend your friends/family/ acquaintances for a job in the Organization?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_6" id="" cols="10" rows="5">'.$exit_interviewData['FEEDBACK_6'].'</textarea>
                        </td>
                    </tr>



                </table>


            </fieldset>
                
                ';
            } else {
                echo ' <fieldset style="margin-top: 10px; border-radius: 10px;">
                    <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                        <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                            <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                        </svg>
    
                        <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section II</h3>
    
                        <h4 style="background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px;text-align: center;">
                            <i>REASONS FOR EXIT</i>
                        </h4>
                    </legend>
    
    
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="2" style="background-color: #c7c7c7; text-align: center;">
                                <strong>What is the reason for your exit from the organiztion?</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Compensation - salary has not kept pace with the market ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_1" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_1" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Getting better compensation offers ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_2" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_2" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Lack of career growth/ progression for years ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_3" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_3" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Superseded by juniors/ colleagues ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_4" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_4" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Boss is unlikely to be promoted / retired in near future ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_5" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_5" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Stagnation in the job ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_6" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_6" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Job Content-getting better job profile with more responsibilities ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_7" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_7" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Ideas/suggestions are not appreciated ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_8" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_8" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        No respect for "professional" in the Organization ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_9" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_9" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Lack of freedom ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_10" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_10" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Company not growing / going down ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_11" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_11" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Would like to move close to my home town/ place of residence ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_12" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_12" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Pursuing higher studies ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_13" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_13" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Going abroad ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_14" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_14" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 60%">
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Family Reasons ?
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <label>
                                    <input type="radio" name="reason_15" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" checked name="reason_15" value="no">
                                    No
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                    <label for="">
                                        Please state any other reason for separation from the Organization (if any)
                                    </label>
                                    <span>:</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #ddd; overflow: hidden;">
                                <input type="text" id="name" name="remarks" style="border: none; outline: none; width: 100%;">
                            </td>
                        </tr>
    
    
                    </table>
                </fieldset>
                <div style="page-break-after: always"></div>
                <fieldset style="margin: 10px 0; border-radius: 10px; ">
                <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                    <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                        <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                    </svg>

                    <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section III</h3>

                    <h4 style="background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px; text-align: center;">
                        <i>FEEDBACK</i>
                    </h4>
                </legend>


                <table style="width: 100%;">
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    1. What did you like most about the Organization?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_1" id="" cols="10" rows="5"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    2. What did you like the least about the Organization?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_2" id="" cols="10" rows="5"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    3. What do you think to be the most important thing that should be done in order to make the Organization a better place to work for?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_3" id="" cols="10" rows="5"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    4. What change would you desire, in order to impact your decision about leaving?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_4" id="" cols="10" rows="5"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    5. If given an opportunity, would you like to join the Organization again?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_5" id="" cols="10" rows="5"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    6. Will you recommend your friends/family/ acquaintances for a job in the Organization?
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <textarea style="width: 100%;border: none;outline: none;" name="feedback_6" id="" cols="10" rows="5"></textarea>
                        </td>
                    </tr>



                </table>


            </fieldset>
                ';
            }

            ?>
            <!-- <fieldset style="margin-top: 10px; border-radius: 10px;">
                <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                    <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                        <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                    </svg>

                    <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section II</h3>

                    <h4 style="background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px;text-align: center;">
                        <i>REASONS FOR EXIT</i>
                    </h4>
                </legend>


                <table style="width: 100%;">
                    <tr>
                        <td colspan="2" style="background-color: #c7c7c7; text-align: center;">
                            <strong>What is the reason for your exit from the organiztion?</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Compensation - salary has not kept pace with the market ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_1" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_1" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Getting better compensation offers ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_2" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_2" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Lack of career growth/ progression for years ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_3" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_3" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Superseded by juniors/ colleagues ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_4" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_4" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Boss is unlikely to be promoted / retired in near future ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_5" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_5" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Stagnation in the job ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_6" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_6" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Job Content-getting better job profile with more responsibilities ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_7" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_7" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Ideas/suggestions are not appreciated ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_8" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_8" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    No respect for "professional" in the Organization ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_9" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_9" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Lack of freedom ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_10" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_10" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Company not growing / going down ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_11" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_11" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Would like to move close to my home town/ place of residence ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_12" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_12" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Pursuing higher studies ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_13" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_13" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Going abroad ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_14" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_14" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 60%">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Family Reasons ?
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <label>
                                <input type="radio" name="reason_15" value="yes">
                                Yes
                            </label>
                            <label>
                                <input type="radio" checked name="reason_15" value="no">
                                No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Please state any other reason for separation from the Organization (if any)
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" id="name" name="remarks" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>


                </table>
            </fieldset> -->





            <fieldset style="margin: 10px 0; border-radius: 10px; ">
                <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                    <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                        <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                    </svg>

                    <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section IV</h3>

                    <h4 style="background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px; text-align: center;">
                        <i> SIGNATURE</i>
                    </h4>
                </legend>
                <div style="margin-top: 10px; display: flex; width: 100%;">
                    <div style="width: 50%; text-align: center;">
                        <input type="text" value="<?php echo $emp_info['RML_ID'] ?>" readonly style="min-width: 100px; border: none; border-bottom: 1px dashed #333;text-align:center ">
                        <p style="margin: 0;">
                            Employee
                        </p>
                    </div>
                    <div style="width: 50%; text-align: center;">
                        <input type="text" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; text-align:center ">
                        <p style="margin: 0;">
                            HR
                        </p>
                    </div>
                </div>
            </fieldset>
            <?php if (empty($exit_interviewData))
                echo ' <div style="text-align: right;margin:10px" id="hidden">
                <button type="submit" class="btn"><i class="fa fa-download"></i> Submit & Print</button>
            </div>';

            ?>



        </div>

    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <?php
    if (!empty($_SESSION['noti_message'])) {
        if ($_SESSION['noti_message']['status'] == 'false') {
            echo "<script>toastr.warning('{$_SESSION['noti_message']['text']}');</script>";
        }
        if ($_SESSION['noti_message']['status'] == 'true') {
            echo "<script>toastr.success('{$_SESSION['noti_message']['text']}');</script>";
        }
        unset($_SESSION['noti_message']);
    }
    ?>

</body>

</html>