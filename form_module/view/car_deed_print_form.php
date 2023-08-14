
<!DOCTYPE html>
<html>

<head>
    <title>Legal Stamp Paper</title>
    <style>
      
        
        .stamp-paper {
            margin: 0 auto;
            font-family: Arial, sans-serif;
            /* width: 14in; */
            height: 13.2in;
            /* background-color: red; */
        }

        .stamp-space-header {
            height: 0.3in;
            /* background-color: aqua; */
        }

        .stamp-image-header {
            height: 3.9in;
        }
        .stamp-pagenumber{
            text-align: right;
            padding: 0 5px 0 5px;
        }
        .stamp-footer{
            text-align: center;
            padding: 0 5px 0 5px;
        }
        .page-break {
            page-break-before: always;
        }
        @media print {
            @page {
                size: legal;
            }

            body * {
                visibility: hidden;
            }

            .stamp-paper,
            .stamp-paper * {
                visibility: visible;
            }

            .stamp-paper {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>
<?php
require '../../inc/connoracle.php'; 
require '../../vendor/autoload.php';// Load Composer's autoloader
use NumberToWords\NumberToWords;

// Get the current date
$currentDate = new DateTime();

// Format the current date as desired
$formattedCurrentDate = $currentDate->format('j F Y');

// Convert the year to words
$numberToWords = new NumberToWords();
$numberTransformer = $numberToWords->getNumberTransformer('en');
$yearWords = ucwords($numberTransformer->toWords($currentDate->format('Y')));
// echo $yearWords ;

// Define months array
$months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

// Replace the numeric month with its word equivalent
$formattedCurrentDate = str_replace(
    $currentDate->format('F'),
    $months[$currentDate->format('n') - 1], // -1 because array is 0-based
    $formattedCurrentDate
);

// Replace the numeric year with its word equivalent
$formattedCurrentDate = str_replace(
    $currentDate->format('Y'),
    $yearWords . " ",
    $formattedCurrentDate
);




echo $formattedCurrentDate;

$invoice_id = trim($_POST["invoice_number"]);


$deedSQL = oci_parse($objConnect, "SELECT REF_CODE,CUSTOMER_NAME,CUSTOMER_MOBILE_NO  FROM LEASE_ALL_INFO_ERP WHERE DOCNUMBR = :invoice_id");
oci_bind_by_name($deedSQL, ":invoice_id", $invoice_id);
oci_execute($deedSQL);
$deedCusData = oci_fetch_assoc($deedSQL);
print_r($deedCusData);




// && trim($_POST["actionType"])  == 'car_deed'
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        // $invoice_id = trim($_POST["invoice_id"]);
        // print_r($_REQUEST);
        die();
                            
    }
                            
?>
<body>
    <div class="stamp-paper">
        <section class="stamp-space-header">
        </section>
        <section class="stamp-image-header">
        </section>
        <section class="stamp-header" style="display: flex; justify-content: space-between; align-items: center;padding: 5px;text-align:center">
            <p>কফ 7250860</p>
            <h4>AGREEMENT <br>OF HIRE PURCHASE </h4>
            <p></p>
        </section>
        <section class="stamp-body" style="padding: 0 5px 0 5px;">
           <span>THIS AGREEMENT OF HIRE PURCHASE is made on this day the <u style="font-weight: bold;"> <?php echo $formattedCurrentDate ?> of the Christian era. </u></span>
           <p style="text-align: center;font-weight: 600;margin: 3px 0 3px 0px;">BETWEEN</p>
           <span>"RANGS MOTORS LIMITED, a private limited company having its registered office at 117/A (Level-4), Old Airport Road, Bijoy Sharani, Tejgoan, Dhaka, hereinafter referred to as "the OWNERS", (which expression shall where the context so admits mean and include its legal representative, successors and assigns) of the <u style="font-weight: 600;"> FIRST PART</u>".</span>
           <p style="text-align: center;font-weight: 600;margin: 3px 0 3px 0px">AND</p>
           <span> <b><?php echo $deedCusData['CUSTOMER_NAME'] ?>, S/O: <?php echo $deedCusData['CUSTOMER_NAME'] ?>, Add: House/Holding: 01, Vill/Road: 05, Section: 13, Block: B, P/O: Mirpur-1216, Kafrul, Dhaka North City Corporation, Dist: Dhaka.</b> Hereinafter referred to as "the BORROWER", (which expression shall where the context so admits mean and include heirs, legal representatives, executors, successors and assigns) of the <u style="font-weight: 600;">SECOND PART</u>".</span>
           <p style="text-align: center;font-weight: 600;margin: 3px 0 3px 0px">AND</p>
           <span> <b>1) Kazi Md. Shopon, S/O: Lal Mia, & 2) Md. Abdul Wadud, S/O: Late Aman Uddin</b>. Dealer/Guarantor their residential address at <b>1) House/Holding: Tin 3/3, Paik Para Staff Quarter, P/O: Mirpur-1216, Mirpur, Dhaka City Corporation, Dist: Dhaka, & 2) Taiger Sarak Poschim, 38 AD, P/O: Jessore Cantonment-7403, Kotwali, Dist: Jessore.</b> As "the GUARANTOR" (which expression shall where the context so admits mean and include his heirs, legal representatives, executors, successors and assigns) of the <u style="font-weight: 600;">THIRD PART</u>”.</span>
           <span style="display: block; margin-top: 5px;">WHEREAS the First Part (the owner) is an importer and owners of 01 (One) unit/units   
            <span style="display: block; margin-top: 5px;">AND WHEREAS, the Second Part, assured by the Third Part (the Guarantor) as regards timely and regular payments of Installment due as indicated in Schedule B to the full satisfaction of the First Part and the First Part has therefore agreed to sell the same under the terms and conditions set-forth hereto.</span>
            <span style="display: block; margin-top: 5px;">NOW THEREFORE, in consideration of mutual covenants herein set forth, the parties hereto agree as follows:</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE I</p>
            <span style="display: block; margin-top: 5px;">NOW THEREFORE, in consideration of mutual covenants herein set forth, the parties hereto agree as follows:</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE II</p>
            <span style="display: block; margin-top: 5px;">That the Second Part shall pay to the First Part (the Owners) at the time of execution and signing of this Agreement a sum of <b>TK. 300,000.00 (Taka. Three Lac )</b> only <b> Down Payment</b> and thereafter the Second Part will punctually and duly pay to the First Part (Owners) at their address in cash /cheque/pay order/demand draft/telephonic transfer the sums <b>and on the dates</b> mentioned in Schedule "B" <b>annexed</b> hereto, whether previously demanded or not by way of installment payment for the product.</span>

        </section>
        <section class="stamp-pagenumber" >
           <b>  Page-1 </b>
        </section>
        <section class="stamp-footer">
            <b>
                "--"
            </b>
        </section>
        <div class="page-break"></div>


        <section class="stamp-space-header">
        </section>
        <section class="stamp-image-header">
        </section>
        <section class="stamp-header" style="display: flex; justify-content: space-between; align-items: center;padding: 5px;text-align:center">
            <p style="margin: 0;">কফ 7250860</p>
            <p></p>
            <p></p>
        </section>
        
        <section class="stamp-body" style="padding: 0 5px 0 5px;">
           
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE III</p>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That it shall be the responsibility and obligations of the Second Part to construct or build the body of the vehicle or vehicles and illy Facilities of the same at his own costs and expenses and shall make the vehicle or vehicles road worthy in accordance with the specifications, requirements and guide line of the Bangladesh Road Transport Authority (BRTA).</span>
            <span style="display: block; margin-top: 5px;font-size: 13.5px">That the said completely built up vehicle or vehicles, together with any accessories, improvements and additions made thereto by the Second Part (the Borrower), shall remain the absolute property of the First Part (the Owners) until and unless the last installment payments has been paid or cleared by the Second Part and once the last installment payment is paid by the Second Part the First Part shall immediately assigns, transfer and make over all right, title and interest, of the same to the Second Part (the Borrower).</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE IV</p>
            <span style="display: block; margin-top: 5px;font-size: 13.5px">That the Second Part, after fulfilling and complying with the obligations as mentioned in Clause III above, shall complete the process of registration of vehicle or vehicles in the name of the First Part (the Owners) or its nominee including but not limited to any financial institutions or bank and the cost and expenses of such registration process shall be borne by the Second Part</span>
            <span style="display: block; margin-top: 5px;font-size: 13.5px">That the Second Part, in accordance with Clause IV above, shall also procure, acquire or obtain Fitness Certificate and Insurance Policy for the vehicle or vehicles in the name of the First Part (the Owners) or its nominee including but not limited to any financial institutions or bank and that the cost and expenses of procuring, acquiring or obtaining such Fitness Certificate and Insurance Policy shall be borne by the Second Part.</span>
            <span style="display: block; margin-top: 5px;font-size: 13.5px">That it shall be the responsibility and obligations of the Second Part to obtain the necessary route permit for the vehicle or vehicles that has been purchased and as such that the Second Part shall also bear the cost and expenses for obtaining the necessary route permit</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE VI</p>
            <span style="display: block; margin-top: 5px;font-size: 13.5px">That the vehicle shall be comprehensively insured in favor of the First Part (the owners) or any financial institution or Agency nominated by the First Part and costs for maintaining such insurance policy shall be borne by the Second Part (the borrower).</span>
            <span style="display: block; margin-top: 5px;font-size: 13.5px">That the repayment of the borrowed amount with interest shall be due for payment after 30 days of taking delivery of the said Completely Built up VE- 10.75 Deisel Bus and shall be paid by the Second Part (the borrower) in 24 (Twenty Four) equal monthly installments as per repayment schedule as detailed in schedule "B" attached here to which forms part of this agreement. In case of any default in making payment of installment due on the schedule date as per schedule "B" a penal interest @ 20% shall have to be paid on the default amount by the Second Part (the borrower) to the First Part (the owners).</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE VII</p>
            <span style="display: block; margin-top: 5px;font-size: 13.5px">That, in order to securitize the installment payments as specified in Schedule- B, the Second Part, on the date of signing this Hire-Purchase Agreement, shall issue, draw and sign 05 Cheques in favor of the First Part and shall also handed over all the signed Cheques to the First Part in accordance with Section- 6, 16, 20 and 49 of the Negotiable Instrument Act, 1881.</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE IX</p>
            <span style="display: block; margin-top: 5px;font-size: 13.5px">That, if the Second Part fails to make the installment payment/ payments on the schedule date /dates, then the First Part, in order to recover the outstanding debt from the Second Part, will be legally entitled to present the Cheque or Cheques in the bank for encashment and upon presentation if the Cheque or Cheques are being returned by the bank as unpaid due to insufficient fund or for any other legally recognized reasons, then the First Part will be legally entitled to initiate Criminal Proceedings against the Second Part in Court under Section- 138 or 140 of the Negotiable Instrument Act, 1881 and in such an event the Second Part shall be liable for all legal consequences thereof. Besides, the First Part shall also be entitled to initiate Criminal (other than Section- 138) and Civil Cases against the Second Part in order to recover the outstanding debt.</span>

        </section>
        <section class="stamp-pagenumber" >
           <b>  Page-2 </b>
        </section>
        <section class="stamp-footer">
            <b>
                "--"
            </b>
        </section>

        <div class="page-break"></div>
        <section class="stamp-space-header">
        </section>
        <section class="stamp-image-header">
        </section>
        <section class="stamp-header" style="display: flex; justify-content: space-between; align-items: center;padding: 5px;text-align:center">
            <p style="margin: 0;">কফ 7250863</p>
            <p></p>
            <p></p>
        </section>
        
        <section class="stamp-body" style="padding: 0 5px 0 5px;">
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE XI</p>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That Second Part (the Borrower) shall duly perform and observe all terms and conditions contained in this agreement and the covenants on his/her part to be performed and observed and shall in the manner aforesaid pay to the First Part (the owners) installment payments as detailed in schedule "B", which constitutes part of this agreement and shall also pay to the First Part (the owners) all others sums of money which may become payable by the Second Part (the Borrower) under this agreement.</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE XII</p>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That the Third Part (the Guarantor) in consideration of the First Part (the owners) hereby guarantees the due performance by the Second Part (the Borrower) of all the clauses and covenants of the agreement and agrees to pay on demand all money payable or which may become payable to the First Part (the owners) under this Agreement.</span>
           
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE XIII</p>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That the Third Part (the Guarantor) further agrees that any time any indulgence granted to the Second Part (the Borrower) by the First Part (the owners) shall not prejudice the First Part's (the owners) rights against him/her or relieve him/her from his/her guarantee which will be a continuing guarantee so long as the First Part (the owners) has any claim against the Second Part (the Borrower) in respect of this Agreement.</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE XIV</p>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That if there is default on the Second Part in making payments of 03 (Three) installments consecutively as per the repayment schedule as detailed in Schedule "B" below, and after serving sufficient notices upon the Second Part as to the this effect, the First Part (the owners) will then have the exclusive right to re-possess the vehicle or vehicles from the Second Part in the following manner:
               
                <span style="display: flex; justify-content: space-between; align-items: center;">
                   <div></div>
                   <div>
                    <br> (a) By Seizing the vehicle or vehicles from the custody, possession and control of the Second Part.
                    <br>(b) By exhausting and availing specific legal provision as enshrined under the Code of Criminal Procedure, 1898.
                   </div>
                   <div></div>

                </span>
            
            </span>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That the Second Part hereby declare and confirm that it does not have any objections to the method and manner adopted by the First Part in order to re-possess the vehicle, rather, the Second Part covenants not to create any obstructions or hindrances in doing the same by the First Part.</span>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That the Third Part (the Guarantor) hereby undertakes and gives full guarantee to recover the possession of the said vehicle/vehicles from the Second Part (the Borrower) and to handover possession" of the vehicle/vehicles" to the First Part (the owners) or his/her authorized representative at the cost of the Third Part (the Guarantor).</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE XV</p>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That the neglect or delay or indulgence on the part of the First Party (the owner), in enforcing the terms of the agreement and any consideration or forbearance or granting of time to the Second Party (the borrower) by the First Part (the owner) shall not be deemed to be a waiver or any breach of any terms of the agreements or prejudice the rights of the First Part (the owner)</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE XVI</p>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That the Second Part (the Borrower) shall keep the vehicle/vehicles in his custody and control and in good working order and repair and shall be responsible for all risks, damage by fire etc. and shall not remove the vehicle outside the permitted area of operation.</span>
            <p style="text-align: left;font-weight: 600;margin: 3px 0 3px 0px">CLAUSE XVII</p>
            <span style="display: block; margin-top: 5px; font-size: 13.5px;">That the Second Part (the Borrower) undertakes to keep the vehicle/vehicles fully covered by comprehensive insurance policy and valid permit whenever necessary, during the continuance of this agreement and use the vehicle(s) only for the purpose mentioned in the proposal and strictly in accordance with the terms and conditions laid down in the permit, by the Registering Authority in respect of the vehicle/vehicles.</span>
        </section>
        <section class="stamp-pagenumber" >
           <b>  Page-3 </b>
        </section>
        <section class="stamp-footer">
            <b>
                "--"
            </b>
        </section>

    </div>

    <!-- <button onclick="printPage()">Print Preview</button> -->

    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>

</html>