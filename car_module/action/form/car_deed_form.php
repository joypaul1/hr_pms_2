<?php
session_start();
require_once('../../../inc/config.php');
require_once('../../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR']['emp_id_hr'];
$basePath =  $_SESSION['basePath'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"])  == 'searchData') {

    $deedSQL  = oci_parse($objConnect, "select * from LEASE_ALL_INFO_ERP
    where DOCNUMBR='XTA00030'");
    oci_execute($deedSQL);
    $deedSQLData = oci_fetch_assoc($deedSQL);
    // print('<pre>');
    // print_r($deedSQLData);
    // print('</pre>');
}

if (($_GET["deedPrintData"])) {

    $INVOICE_NO = trim($_GET['deedPrintData']['invoice_number']);
    $INVOICE_DATE = date('d/m/Y', strtotime(trim($_GET['deedPrintData']['date'])));
    $NUMBER_OF_CHECK = trim($_GET['deedPrintData']['number_of_cheque']);
    $BRAND = trim($_GET['deedPrintData']['product_brand']);
    $PRODUCT_CODE_NAME = trim($_GET['deedPrintData']['product_model']);
    // lease_amount
    $SALES_AMOUNT = str_replace(',', '', trim($_GET['deedPrintData']['sales_amount']));
    $DP = str_replace(',', '', trim($_GET['deedPrintData']['down_payment']));
    $LEASE_AMOUNT = str_replace(',', '', trim($_GET['deedPrintData']['lease_amount']));
    $INSTALLMENT_AMOUNT = str_replace(',', '', trim($_GET['deedPrintData']['installment_amount']));
    $NO_OF_INSTALLMENT = str_replace(',', '', trim($_GET['deedPrintData']['emi_number']));

    $GRACE_PERIOD = str_replace(',', '', trim($_GET['deedPrintData']['grace_period']));
    $POSIBLE_INST_START_DATE = date('d/m/Y', strtotime(trim($_GET['deedPrintData']['emi_start_date'])));


    $CUSTOMER_NAME = trim($_GET['deedPrintData']['customer_name']);
    $CUST_FATHERS_NAME = trim($_GET['deedPrintData']['c_f_name']);
    $CUST_ADDRESS = trim($_GET['deedPrintData']['customer_address']);

    $FIRST_GUARANTOR = trim($_GET['deedPrintData']['g_name_1']);
    $FIRST_GUARANTOR_FATHER = trim($_GET['deedPrintData']['g_f_name_1']);
    $FIRST_GUARANTOR_ADDRESS = trim($_GET['deedPrintData']['g_add_1']);

    $SECOND_GUARANTOR = trim($_GET['deedPrintData']['g_name_2']);
    $SECOND_GUARANTOR_SO_DO = trim($_GET['deedPrintData']['g_f_name_2']);
    $SECOND_GUARANTOR_ADDRESS = trim($_GET['deedPrintData']['g_add_2']);
    // $ENTRY_DATE = SYSDATE;


    //multiple data 
    $REF_NUMBER = ($_GET['deedPrintData']['reference_id']);
    $ENG_NO = ($_GET['deedPrintData']['product_engine_no']);
    $CHASSIS_NO = ($_GET['deedPrintData']['product_chassis_no']);
    //

    $inserted_Id = [];
    try {
        foreach ($REF_NUMBER as $key => $refValue) {
            $deedSQL  = oci_parse($objConnect, "INSERT INTO DEED_INFO (
                INVOICE_NO, INVOICE_DATE, 
                REF_NUMBER, CHASSIS_NO, ENG_NO, 
                SALES_AMOUNT, DP,LEASE_AMOUNT, NUMBER_OF_CHECK, 
                BRAND, PRODUCT_CODE_NAME, INSTALLMENT_AMOUNT, 
                NO_OF_INSTALLMENT, GRACE_PERIOD, POSIBLE_INST_START_DATE, 
                CUSTOMER_NAME, CUST_FATHERS_NAME, CUST_ADDRESS, 
                FIRST_GUARANTOR, FIRST_GUARANTOR_FATHER, FIRST_GUARANTOR_ADDRESS, 
                SECOND_GUARANTOR, SECOND_GUARANTOR_SO_DO, SECOND_GUARANTOR_ADDRESS, 
                ENTRY_DATE, ENTRY_BY ) 
                VALUES ('$INVOICE_NO',
                    TO_DATE('$INVOICE_DATE', 'DD/MM/YYYY'),
                    '$REF_NUMBER[$key]',
                    '$CHASSIS_NO[$key]',
                    '$ENG_NO[$key]',
                    '$SALES_AMOUNT',
                    '$DP',
                    '$LEASE_AMOUNT',
                    '$NUMBER_OF_CHECK',
                    '$BRAND',
                    '$PRODUCT_CODE_NAME',
                    '$INSTALLMENT_AMOUNT',
                    '$NO_OF_INSTALLMENT',
                    '$GRACE_PERIOD',
                    TO_DATE('$POSIBLE_INST_START_DATE', 'DD/MM/YYYY'),
                    '$CUSTOMER_NAME',
                    '$CUST_FATHERS_NAME',
                    '$CUST_ADDRESS',
                    '$FIRST_GUARANTOR',
                    '$FIRST_GUARANTOR_FATHER',
                    '$FIRST_GUARANTOR_ADDRESS',
                    '$SECOND_GUARANTOR',
                    '$SECOND_GUARANTOR_SO_DO',
                    '$SECOND_GUARANTOR_ADDRESS',
                    SYSDATE,
                    '$emp_session_id')RETURNING ID INTO :inserted_id");
            // Bind the parameter for the inserted ID
            oci_bind_by_name($deedSQL, ':inserted_id', $insertedId, 10); // Assuming the ID column is of type NUMBER(10)

                
            if (oci_execute($deedSQL)) {
                // Insertion was successful for this iteration
                oci_commit($objConnect); // Commit the transaction
                array_push($inserted_Id,$insertedId);
                // echo json_encode($inserted_Id); 
            } else {
                $response['status'] = false;
                $response['message'] = 'Error inserting data.';
                echo json_encode($response);
                exit();
            }
        }
        // ?inserted_id=
        $inserted_Id = implode(',', $inserted_Id);
        $response['status']  = true;
        $response['link']  = $basePath.'/car_module/view/car_deed_print_form.php?inserted_id='.$inserted_Id;
        $response['message'] = 'Data Inserted Successfully ...';
        echo json_encode($response);
        exit();
    } catch (\Exception $ex) {
        $response['status']  = false; //
        $response['message'] = $ex->getMessage();
        echo json_encode($response);
        exit();
    }
}
