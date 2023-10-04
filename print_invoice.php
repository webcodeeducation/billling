<?php
session_start();
include 'ledger.php';
include 'Invoice.php';
require("nepali-date.php");
$ledger = new Ledger();
$invoice = new Invoice();
//$nepali_date = new nepali_date();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);
	$customerDetails = $ledger->getCustomer($invoiceValues['customer_id']);
	$settings = $invoice->getMasterSettings();
}
$invoiceDate = $invoiceValues['order_date'];
//$date = $invoice -> NepaliDate($invoiceDate, $nepali_date);
$date = $invoiceDate;

$bank_address = "Bank Name: ". $settings['bank_name']."<br/>Place: ". $settings['address']."<br/>A/c No. :". $settings['acc_no']."<br/>IFSC Code: " . $settings['ifsc'];


$output = ob_get_clean();

$billno = $invoiceValues['bill_no'] ; //date('dmY') . '/' . rand(5,1000);
$invoiceFileName_txt= 'invoice-'.$billno;

$output = '';
$n=1;
$output .= '<html>
	<head>
	<style>
.page-break {
page-break-before: always;
}
table {
  border-collapse: collapse;
  page-break-inside: avoid;
  width: 100%;
}
</style>
</head>';
$output .= '<body><span style="margin-bottom:100px;"></span><br/>';



$output .= '
<div style="page-break-inside:avoid;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width="25%" align="center" style=""><img src="./images/Soil_health_logo.png" width="100px" widt></td>
	<td width="50%" align="left" style=""><span style="font-size:50pt;font-style:normal;width:340px;letter-spacing: 10px;"><u><b>KUNAL
	</b></u></span><br><span style="font-size:50pt;margin-left:5px;"><u>Associate</u></span><br><span style=""><b>M: '.$settings['phone'].'</b>,&nbsp;&nbsp;<b>'.$settings['email'].'</b></span></td>
	<td width="25%"><p style="font-size:8pt;"><u>GSTIN : '.$settings['gstno'].'</u><br/><u>State : Haryana</u><br/><u>S.Code : 06</u><br/><u>Dated : '.$invoiceValues['order_date'].'</u><br/><u>Bill No : '.$billno.'</u></p></td>
	</tr>	
<tr>
	<td colspan="3" align="center" style="font-size:18px;color:white;border-top-left-radius: 10px;" bgcolor="black" color="white"><b>Kalal Majra, Near Hanuman Mandir, Thanesar, Kuruksehtra</b></td>
	</tr>
	<tr>
	<td colspan="3">
	<table width="100%" cellpadding="5" cellspacing="0" style="margin-top:10px;margin-bottom:10px;">
	<tr>
	<td width="100%">
	Name:<b><u>'.$customerDetails['customer_name'].' </u></b><br />
	Address : <u>'.$customerDetails['customer_address'].'</u><br />
	State : <u>Haryana</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;State Code: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>GSTIN No:<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br/>
	Contact No. : '.$customerDetails['customer_number'].'<br />
	</td>
	</tr>
	</table>
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">Sr No.</th>
	<th align="center" width="10%" colspan="2">Description of Goods</th>
	<th align="left">HSN</th>
	<th align="left">Qty.</th>
	<th align="left">Rate</th>
	<th align="left"><small>Rs.</small>Amount<small> P.</small></th> 
	</tr>';
$count = 0;   
foreach($invoiceItems as $invoiceItem){
	$count++;
	$output .= '
	<tr>
	<td align="left">'.$count.'</td>
	<td align="left" colspan="2">'.$invoiceItem["item_name"].'</td>
	<td align="left">'.$invoiceItem["order_item_hsn"].'</td>
	<td align="left">'.$invoiceItem["order_item_quantity"].'</td>
	<td align="left">'.$invoiceItem["order_item_price"].'</td>
	<td align="left">'.$invoiceItem["order_item_final_amount"].'</td>   
	</tr>';
	$n++;
}
$cgst = 
$output .= '
	<tr>
	<td colspan="3" width="40%"><b>'.$bank_address.'</b></td>
	<td colspan="4">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
	<td align="right" colspan="5"><b>Sub Total:</b></td>
	<td align="left"><b>'.$invoiceValues['order_total_before_tax'].'</b></td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>CGST '.$settings['cgst'].'%</b>:</td>
	<td align="left">'.($settings['cgst']/100)*$invoiceValues['order_total_before_tax'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>SGST '.$settings['sgst'].'%</b>:</td>
	<td align="left">'.($settings['sgst']/100)*$invoiceValues['order_total_before_tax'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>IGST :</b></td>
	<td align="left">0.00</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Tax Amount: </td>
	<td align="left">'.$invoiceValues['order_total_tax'].'</td>
	</tr>
	
	
	
	<tr>
	<td align="right" colspan="5"><b>Grand Total:</b></td>
	<td align="left" id="totalAmount">'.$invoiceValues['order_total_amount_due'].'</td>
	</tr>
	</table>	
	</td></tr>
	<tr><td colspan="7">
	<!--div class="left_part" style="float:left;">
	<p>Goods once sold will not be taken back.</p>
	<p>All dispute are subject to Kuruksehtra juristiction</p>
	<p>E. & O.E.</p></div-->
	<div class="right_part" style="margin-left:420px;margin-top:80px;float:left;" align="right">
	<b>Signature</b>
	<img src="images/final_kunal.png" width="250" style="margin-top:20;margin-left:-150px;z-index: 99;"/>
	</div>
	</td></tr>';

$output .= '
	</table>
	</td>
	</tr>
	</table>
	<script src="./js/numberToWord.js"></script>
</body>
</html>';
// create pdf of invoice	
$invoiceFileName = 'Invoice-'.$invoiceValues['order_id'] .'-'. $billno .'.pdf';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>   
