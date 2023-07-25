<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exit Interview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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


    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    $basePath =  $baseUrl . '/rHRT';

    date_default_timezone_set("Asia/Dhaka");
    require_once('../inc/config.php');
    require_once('../inc/connoracle.php');
    $errors = array();
    $_GET['id'] = 203;
    $_GET['rml_id'] = 'RML-00601';
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $errors[] = 'Clearence ID is required.';
    }
    if (!isset($_GET['rml_id']) || empty($_GET['rml_id'])) {
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
    $emp_id        = ($_GET['id']);
    $rml_id        = ($_GET['rml_id']);

    $clearanceSQL  = oci_parse($objConnect, "SELECT A.RESIGNATION_DATE FROM  EMP_CLEARENCE A WHERE A.ID='$emp_id'");
    oci_execute($clearanceSQL);
    $clearanceEmpData = oci_fetch_assoc($clearanceSQL);

    // print_r($clearanceEmpData);


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
    // print_r($emp_info);


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Defining variables
        $name = $email = $level = $review = "";
        echo 'sdasdas';

        // $name = test_input($_POST["name"]);
        // $email = test_input($_POST["email"]);
        // $review = test_input($_POST["review"]);
        // $level = test_input($_POST["level"]);
    }

    ?>

    <div style="text-align: right;" id="hidden">
        <button onclick="window.print()" class="btn"><i class="fa fa-download"></i> Download</button>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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
                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Date of Seperation / Resignation
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
                                    Total Experience (incluing years of service in Amishee)
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" value="" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>

                </table>


            </fieldset>

            <fieldset style="margin-top: 10px; border-radius: 10px;">
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
                            <input type="text" id="name" style="border: none; outline: none; width: 100%;">
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
            <fieldset style="margin: 10px 0; border-radius: 10px; ">
                <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                    <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                        <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                    </svg>

                    <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section IV</h3>

                    <h4 style="background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px; text-align: center;">
                        <i>DETAILS OF NEW EMPLOYER</i>
                    </h4>
                </legend>


                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Name of the Employer
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>


                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Designation Offered
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Location
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Percentage Increase in the CTC
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 200px;">
                            <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                                <label for="">
                                    Any other Remarks
                                </label>
                                <span>:</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; overflow: hidden;">
                            <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                        </td>
                    </tr>

                </table>


            </fieldset>

            <fieldset style="margin: 10px 0; border-radius: 10px; ">
                <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                    <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                        <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                    </svg>

                    <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section V</h3>

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
            <div style="text-align: right;margin:10px" id="hidden">
                <button type="submit" class="btn"><i class="fa fa-download"></i> Submit & Print</button>
            </div>
        </div>

    </form>
</body>

</html>