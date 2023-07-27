<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts form</title>
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

        label {
            font-weight: 600;
        }

        #main {
            padding-top: 15px !important;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr th,
        table tr td {
            border: 1px solid black;
        }


        fieldset {
            font-size: 9pt !important;
        }

        /* Print only one page */
        @media print {

            #hidden {
                display: none;
            }

            #main {
                margin: 0 auto;
                padding-left: 3px !important;
                padding-right: 3px !important;
                padding-top: 15px !important;
            }


            table {
                width: 100%;
                border-collapse: collapse;
            }

            table tr th,
            table tr td {
                border: 1px solid black;
            }

            fieldset {
                font-size: 9pt !important;
            }

            @page {
                size: A4 landscape !important;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 20px !important;
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
    $accountclearenceId        = ($_GET['accountclearenceId']) ? ($_GET['accountclearenceId'])  : ' ';
    if (!isset($accountclearenceId) || empty($accountclearenceId)) {
        $errors[] = 'Accounts Clearence ID is required.';
    }
    if (count($errors) > 0) {
        echo '<div class="alert alert-danger" style="color:red">';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        die();
    }
    $clearanceSQL  = oci_parse($objConnect, "SELECT A.* FROM  EMP_CLEARENCE A WHERE A.ID='$emp_id'");
    oci_execute($clearanceSQL);
    $clearanceEmpData = oci_fetch_assoc($clearanceSQL);

    ?>
    <div style="text-align: right;" id="hidden">
        <button onclick="window.print()" class="btn"><i class="fa fa-download"></i> Download</button>
    </div>
    <div id="main">
        <img style="width: 100%;" src="../images/accouts_header.jpg" alt="">
        <div style="margin: 10px 0;">
            <form style="display: flex; justify-content: center;">
                <level>

                    <u>
                        FINANCE & ACCOUNTS CLEARANCE: <b>RML-XXXX</b> Name: <b>XXXXXXX</b>
                    </u>
                </level>

            </form>
        </div>

        <table style="width: 100%;">
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>

            </tr>
            <tr>
                <th>SL</th>
                <th>Details</th>
                <th>Min. months req. for full ownership</th>
                <th>Company Portion </th>
                <th>Employee Portion</th>
                <th>Paid By Company</th>
                <th>Paid By Employee</th>
                <th>Due From Employee</th>
                <th>Due From Emp. (Company+ Employee)</th>
                <th style="width: 5px">Note/Remarks</th>
            </tr>
            <tr style="text-align: center;">
                <td>1</td>
                <td>IOU</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
        </table>




        <!-- <span style="color: #7b7b7b;">
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
        </div> -->
    </div>

</body>

</html>