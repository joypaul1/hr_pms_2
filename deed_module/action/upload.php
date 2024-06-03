<?php
session_start();
require_once ('../../inc/connoracle.php');
$emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];
$basePath       = $_SESSION['basePath'];

if (isset($_GET["ref_code"]) && $_GET["invoice_number"]) {
    $ref_code   = trim($_GET["ref_code"]);
    $invoice_id = trim($_GET["invoice_number"]);
    $deedSQL    = @oci_parse(
        $objConnect,
        "SELECT
            CUSTOMER_NAME,
            DELIVERY_DATE,
            PARTY_ADDRESS,
            SALES_AMOUNT,
            DP,
            LEASE_AMOUNT,
            INSTALLMENT_AMOUNT,
            REF_CODE,
            PRODUCT_CODE_NAME,
            CHASSIS_NO,
            ENG_NO,
            BRAND
        FROM
            LEASE_ALL_INFO_ERP
        WHERE
            PAMTMODE ='CRT' AND
            DOCNUMBR = '$invoice_id' AND
            REF_CODE = '$ref_code'"
    );
    @oci_execute($deedSQL);
    $singleProduct = @oci_fetch_assoc($deedSQL);

    $buyerSQL = @oci_parse(
        $objConnect,
        "SELECT
            INVOICE_DATE,
            FATHERS_NAME,
            FIRST_GUARANTOR,
            FIRST_GUARANTOR_FATHER,
            FIRST_GUARANTOR_ADDRESS,
            SECOND_GUARANTOR,
            SECOND_GUARANTOR_SO_DO,
            SECOND_GUARANTOR_ADDRESS,
            GETGRASEPERIOD(INVOICE_NO, POSIBLE_INST_START_DATE) AS GRACE_PERIOD,
            NO_OF_INSTALLMENT,
            POSIBLE_INST_START_DATE
        FROM
            buyers_all_info_data
        WHERE
            INVOICE_NO = '$invoice_id' AND
            REFNUMBR = '$ref_code'"
    );
    @oci_execute($buyerSQL);
    $buyerSQL = @oci_fetch_assoc($buyerSQL);

    $html ='
    <span id="deedhtml">
    <div class="form-group">
        <label for="customer_name">Customer Name</label>
        <input type="text" class="form-control" onkeypress="return false;" style="background-color: #d9dee3;" name="customer_name" value="' . htmlspecialchars(isset($singleProduct["CUSTOMER_NAME"]) ? $singleProduct["CUSTOMER_NAME"] : '', ENT_QUOTES) . '" id="customer_name" autocomplete="off" required placeholder="EX:5,00,000.00">
    </div>
    <div class="form-group">
        <label for="customer_address">Customer Address</label>
        <input type="text" class="form-control" onkeypress="return false;" style="background-color: #d9dee3;" name="customer_address" value="' . htmlspecialchars(isset($singleProduct["PARTY_ADDRESS"]) ? $singleProduct["PARTY_ADDRESS"] : '', ENT_QUOTES) . '" autocomplete="off" id="customer_address" required placeholder="EX:5,00,000.00">
    </div>
    <div class="form-group">
        <label for="cheque_number">Number of Cheque</label>
        <input type="text" class="form-control" name="number_of_cheque" autocomplete="off" id="cheque_number" required placeholder="Cheque Number">
    </div>
    <div class="form-group">
        <label for="cheque_number">Delivery Date <span data-bs-toggle="tooltip" title="Invoice Delivery Date"><i class="bx bxs-info-circle" style="color: #03c3ec;"></i></span></label>
        <input type="text" onkeypress="return false;" style="background-color: #d9dee3;" required placeholder="dd-mm-yyyy" class="form-control" value="' . (isset($buyerSQL["INVOICE_DATE"]) ? date('d-m-Y', strtotime($singleProduct["DELIVERY_DATE"])) : '') . '" autocomplete="off" name="date" id="date">
    </div>
    <div class="form-group">
        <label for="c_f_name">Customer Father\'s Name</label>
        <input type="text" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" value="' . htmlspecialchars(isset($buyerSQL["FATHERS_NAME"]) ? $buyerSQL["FATHERS_NAME"] : '', ENT_QUOTES) . '" name="c_f_name" id="c_f_name" autocomplete="off" required placeholder="Customer father\'s Name">
    </div>
    <div class="form-group">
        <label for="g_name_1">Guarantor/Dealer Name (1)</label>
        <input type="text" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" name="g_name_1" value="' . htmlspecialchars(isset($buyerSQL["FIRST_GUARANTOR"]) ? $buyerSQL["FIRST_GUARANTOR"] : '', ENT_QUOTES) . '" id="g_name_1" autocomplete="off" required placeholder="Guarantor/Dealer Name">
    </div>
    <div class="form-group">
        <label for="g_f_name_1">Guarantor Father\'s Name (1)</label>
        <input type="text" class="form-control" onkeypress="return false;" style="background-color: #d9dee3;" value="' . htmlspecialchars(isset($buyerSQL["FIRST_GUARANTOR_FATHER"]) ? $buyerSQL["FIRST_GUARANTOR_FATHER"] : '', ENT_QUOTES) . '" name="g_f_name_1" id="g_f_name_1" autocomplete="off" required placeholder="Guarantor/Dealer Father\'s Name">
    </div>
    <div class="form-group">
        <label for="g_add_1">Guarantor Address (1)</label>
        <input type="text" class="form-control" onkeypress="return false;" style="background-color: #d9dee3;" value="' . htmlspecialchars(isset($buyerSQL["FIRST_GUARANTOR_ADDRESS"]) ? $buyerSQL["FIRST_GUARANTOR_ADDRESS"] : '', ENT_QUOTES) . '" name="g_add_1" id="g_add_1" autocomplete="off" required placeholder="Guarantor/Dealer Address">
    </div>
    <div class="form-group">
        <label for="g_name_2">Guarantor/Dealer Name (2)</label>
        <input type="text" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" name="g_name_2" value="' . htmlspecialchars(isset($buyerSQL["SECOND_GUARANTOR"]) ? $buyerSQL["SECOND_GUARANTOR"] : '', ENT_QUOTES) . '" id="g_name_2" autocomplete="off" placeholder="Guarantor/Dealer Name">
    </div>
    <div class="form-group">
        <label for="g_f_name_2">Guarantor/Dealer Father\'s Name (2)</label>
        <input type="text" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" value="' . htmlspecialchars(isset($buyerSQL["SECOND_GUARANTOR_SO_DO"]) ? $buyerSQL["SECOND_GUARANTOR_SO_DO"] : '', ENT_QUOTES) . '" name="g_f_name_2" id="g_f_name_2" autocomplete="off" required placeholder="Guarantor/Dealer Father\'s Name">
    </div>
    <div class="form-group">
        <label for="g_add_2">Guarantor/Dealer Address (2)</label>
        <input type="text" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" value="' . htmlspecialchars(isset($buyerSQL["SECOND_GUARANTOR_ADDRESS"]) ? $buyerSQL["SECOND_GUARANTOR_ADDRESS"] : '', ENT_QUOTES) . '" name="g_add_2" id="g_add_2" autocomplete="off" required placeholder="Guarantor/Dealer Address">
    </div>
  
    <div class="form-group">
        <label for="sales_amount"> Sales Amount</label>
        <input type="text" autocomplete="off" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" name="sales_amount" value="' . htmlspecialchars(isset($singleProduct["SALES_AMOUNT"]) ? number_format($singleProduct["SALES_AMOUNT"], 2) : ' ', ENT_QUOTES) . '" id="sales_amount" required placeholder="EX:10,00,000.00">
    </div>
    <div class="form-group">
        <label for="down_payment"> Down Payment /PU</label>
        <input type="text" autocomplete="off" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" name="down_payment" value="' . htmlspecialchars(isset($singleProduct["DP"]) ? number_format($singleProduct["DP"], 2) : ' ', ENT_QUOTES) . '" id="down_payment" required placeholder="EX:5,00,000.00">
    </div>
    <div class="form-group">
        <label for="lease_amount"> Lease Amount /PU</label>
        <input type="text" autocomplete="off" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" name="lease_amount" value="' . htmlspecialchars(isset($singleProduct["LEASE_AMOUNT"]) ? number_format($singleProduct["LEASE_AMOUNT"], 2) : ' ', ENT_QUOTES) . '" id="lease_amount" required placeholder="EX:5,00,000.00">
    </div>
    <div class="form-group">
        <label for="grace_period"> Grace Period</label>
        <input type="text" autocomplete="off" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" name="grace_period" value="' . htmlspecialchars(isset($buyerSQL["GRACE_PERIOD"]) ? $buyerSQL["GRACE_PERIOD"] : '', ENT_QUOTES) . '" id="grace_period" required placeholder="EX:1/2/3">
    </div>
    <div class="form-group">
        <label for="installment_amount"> Installment Amount /PU</label>
        <input type="text" autocomplete="off" onkeypress="return false;" style="background-color: #d9dee3;" class="form-control" value="' . htmlspecialchars(isset($singleProduct["INSTALLMENT_AMOUNT"]) ? $singleProduct["INSTALLMENT_AMOUNT"] : '', ENT_QUOTES) . '" name="installment_amount" id="installment_amount" required placeholder="EX:5,00,000.00">
    </div>
    <div class="form-group">
        <label for="emi_number"> EMI Number(Count of EMI)</label>
        <input type="text" autocomplete="off" onkeypress="return false;" style="background-color: #d9dee3;" value="' . htmlspecialchars(isset($buyerSQL["NO_OF_INSTALLMENT"]) ? $buyerSQL["NO_OF_INSTALLMENT"] : '', ENT_QUOTES) . '" class="form-control" name="emi_number" required id="emi_number" placeholder="EX:3/4/5">
    </div>
    <div class="form-group">
        <label for="emi_start_date"> EMI Start Date</label>
        <input type="text" autocomplete="off" onkeypress="return false;" style="background-color: #d9dee3;" value="' . htmlspecialchars(isset($buyerSQL["POSIBLE_INST_START_DATE"]) ? date('d-m-Y', strtotime($buyerSQL["POSIBLE_INST_START_DATE"])) : '', ENT_QUOTES) . '" placeholder="dd-mm-yyyy" class="form-control" required name="emi_start_date" id="emi_start_date">
    </div></span>';
    echo json_encode((trim($html)));
}
?>