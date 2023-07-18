<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Style buttons */
        .btn {
            background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
            border: none;
            color: #fff !important;
            padding: 10px 10px;
            cursor: pointer;
            font-size: 20px;
        }

        /* Darker background on mouse-over */
        .btn:hover {
            background-color: RoyalBlue;
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
            font-size: 9pt !important;
        }

        /* Print only one page */
        @media print {
            #main {
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
                font-size: 9pt !important;
            }

            @page {
                size: A4;
                /* margin: 0; */
            }

            #hidden {
                display: none !important;
            }

            body {
                /* margin: 0; */
            }
        }
    </style>

</head>

<body>
    <?php
    date_default_timezone_set("Asia/Dhaka");
    require_once('../inc/config.php');
    require_once('../inc/connoracle.php');

    // if (!isset($_GET['rml_emp_id']) || empty($_GET['rml_emp_id'])) {
    //     $errors[] = 'Employee ID is required.';
    // }
    $emp_id        = ($_GET['id']);

    ?>
    <div style="text-align: right;" id="hidden">
        <button onclick="window.print()" class="btn"><i class="fa fa-download"></i> Download</button>
    </div>
    <div id="main">
        <img style="width: 100%;" src="../images/header.jpg" alt="">
        <div style="margin: 10px 0;">
            <form style="display: flex; gap: 4px;">
                <level>
                    Date :
                </level>
                <input type="text" value="<?php echo date('d-m-Y h:i A') ?>" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; ">
            </form>
        </div>

        <fieldset style="margin: 10px 0; border-radius: 10px; ">
            <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                    <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                </svg>

                <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section 1</h3>

                <h4 style="text-align:center;background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px;">
                    <i>EMPLOYEE INFORMATION</i>
                </h4>
            </legend>


            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="name">
                                Name
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                RML ID
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Designation
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Department
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Work Location
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Date of Joining
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                DOC
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Resignation Date
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Last Working Day
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Employment Type :
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Reason Of Resignation
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td colspan="3" style="border: 1px solid #ddd; overflow: hidden;">
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

                <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section 2</h3>

                <h4 style="text-align:center;background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px;">
                    <i>DEPARTMENTAL/SUPERVISOR CLEARANCE</i>
                </h4>
            </legend>


            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                All Documents Submit
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                </tr>

                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Any Payment Due/Clear
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
                                Any other (Remarks)
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                </tr>

            </table>

            <div style="margin-top: 10px; display: flex; width: 100%;">

                <div style="width: 50%;">
                    <input type="text" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; ">
                    <div style="display: flex; gap: 4px; margin: 0;">
                        <level>
                            Supervisor Name :
                        </level>
                        <input type="text" style="min-width: 100px; border: none; ">
                    </div>
                    <div style="display: flex; gap: 4px; margin: 0;">
                        <level>
                            Designation :
                        </level>
                        <input type="text" style="min-width: 100px; border: none; ">
                    </div>
                </div>
                <div>
                    <input type="text" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; ">
                    <div style="display: flex; gap: 4px; margin: 0;">
                        <level>
                            HOD Name :
                        </level>
                        <input type="text" style="min-width: 100px; border: none; ">
                    </div>
                    <div style="display: flex; gap: 4px; margin: 0;">
                        <level>
                            Designation :
                        </level>
                        <input type="text" style="min-width: 100px; border: none; ">
                    </div>
                </div>

            </div>

        </fieldset>
        <fieldset style="margin: 10px 0; border-radius: 10px; ">
            <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                    <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                </svg>

                <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section 3</h3>

                <h4 style="text-align:center;background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px;">
                    <i>DEPARTMENT WISE CLEARANCE</i>
                </h4>
            </legend>


            <table class="bordered" style="width: 100%;">
                <tr style="background-color: #eaeaea;text-align:center">
                    <td>
                        Sl No.
                    </td>
                    <td>Department/ Section/Unit</td>
                    <td>Any payment Due/Remarks</td>
                    <td>Signature</td>
                </tr>

                <?php
                $statusDataSQL = oci_parse(
                    $objConnect,
                    "SELECT 
                                    d.ID, d.EMP_CLEARENCE_ID, d.CONCERN_NAME, 
                                    d.DEPARTMENT_ID, d.APPROVAL_STATUS, d.APPROVE_BY, 
                                    d.APPROVE_DATE, h.DEPT_NAME
                                    FROM EMP_CLEARENCE_DTLS d
                                    JOIN RML_HR_DEPARTMENT h ON d.DEPARTMENT_ID = h.ID 
                                    WHERE  d.EMP_CLEARENCE_ID = {$emp_id}"
                );
                $result = oci_execute($statusDataSQL);
                if ($result) {
                    $sl=1;
                    while ($statusRow = oci_fetch_array($statusDataSQL)) {
                        print_r($statusRow );
                        die();
                        echo '<tr>
                                <td style="background-color: #ddd;">
                                    '.($sl++).'
                                </td>
                                </td>
                                <td>
                                ' . $statusRow['DEPT_NAME'] . '
                                </td>
                                <td><input type="text" style="width: 100%; border: none;outline: none;"></td>
                                <td><input type="text" style="width: 100%; border: none;outline: none;">  ' . $statusRow['APPROVE_BY'] . '</td>
                            </tr>';
                    }
                }



                ?>




            </table>

            <div style="margin-top: 5px; display: flex; width: 100%; justify-content: space-between;">

                <div>
                    <input type="text" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; ">
                    <p style="text-align: center; margin: 0;">HR & Admin</p>
                </div>
                <div>
                    <input type="text" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; ">
                    <p style="text-align: center; margin: 0;">Group CFO & CS</p>
                </div>
                <div>
                    <input type="text" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; ">
                    <p style="text-align: center; margin: 0;"></p>
                </div>

            </div>

        </fieldset>

        <fieldset style="margin-top: 10px; border-radius: 10px;">
            <legend style="display: flex; align-items: center; gap: 10px; width: 95%; margin-left: 10px; ">
                <svg style="width: 20px; margin-left: -4px; margin-top: -0.5px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#333">
                    <path fillRule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clipRule="evenodd" />
                </svg>

                <h3 style="min-width:max-content; margin: 0; margin-right: 20px;">Section 4</h3>

                <h4 style="text-align:center;background-color: #333; margin: 0; color: #fff; width: 100%; padding: 5px;">
                    <i>HR SECTION</i>
                </h4>
            </legend>


            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Responsible HR Person
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <input type="text" id="name" style="border: none; outline: none; width: 100%;">
                    </td>
                </tr>

                <tr>
                    <td>
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Handover Check list fill up
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <label>
                            <input type="checkbox" name="handover" value="yes">
                            Yes
                        </label>
                        <label>
                            <input type="checkbox" name="handover" value="no">
                            No
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Properly hand over & take over
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <label>
                            <input type="checkbox" name="handover" value="yes">
                            Yes
                        </label>
                        <label>
                            <input type="checkbox" name="handover" value="no">
                            No
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Noticed as per policy
                            </label>
                            <span>:</span>
                        </div>
                    </td>
                    <td style="border: 1px solid #ddd; overflow: hidden;">
                        <label>
                            <input type="checkbox" name="handover" value="yes">
                            Yes
                        </label>
                        <label>
                            <input type="checkbox" name="handover" value="no">
                            No
                        </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #c7c7c7; text-align: center;">
                        <strong>FINAL SETTLEMENT INFORMATION</strong>
                    </td>
                </tr>

                <tr>
                    <td style="width: 200px;">
                        <div style="display: flex; justify-content: space-between; background-color: #ddd; padding: 4px;">
                            <label for="">
                                Salary Amount
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
                                PF Amount
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
                                Policy and other deduction
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
                                Total final settlement amount
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
                                Date of final settlement
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
        <span style="color: #7b7b7b;">
            NB: Detail final settlement calculation is being attached.
        </span>

        <div style="margin-top: 10px; display: flex; width: 100%;">
            <div style="width: 50%; text-align: center;">
                <input type="text" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; ">
                <p style="margin: 0;">
                    Concern HR
                </p>
            </div>
            <div style="width: 50%; text-align: center;">
                <input type="text" style="min-width: 100px; border: none; border-bottom: 1px dashed #333; ">
                <p style="margin: 0;">
                    HOD HR
                </p>
            </div>
        </div>
    </div>

</body>

</html>