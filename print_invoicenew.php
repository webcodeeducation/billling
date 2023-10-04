<?php
session_start();
include 'ledger.php';
include 'Invoice.php';
require("nepali-date.php");
$ledger = new Ledger();
$invoice = new Invoice();
$nepali_date = new nepali_date();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);
	$customerDetails = $ledger->getCustomer($invoiceValues['customer_id']);		
}
$invoiceDate = $invoiceValues['order_date'];
$date = $invoice -> NepaliDate($invoiceDate, $nepali_date);

$output = '';



$output .= '

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #tb1 {
            width: 90%;
            border-radius: 20px;
            border-style: solid;
        }


        #kunal {
            font-family: Arial, Helvetica, sans-serif;
            border-bottom-style: solid;
            border-bottom-width: 4px;
            border-right-style: solid;
            font-size: 110px;
            border-right-width: 1px;
        }

        #asso {
            letter-spacing: 10px;

            font-size: 40px;
            ;
            border-right-style: solid;

            border-width: 1px;
        }

        #mob {
            font-size: 30px;
            border-top-style: solid;
            border-top-width: 4px;
            border-right-style: solid;
            border-right-width: 1px;
        }

        .bord {
            border-bottom-style: solid;
            border-bottom-width: 1px;
            padding-left: 7px;
        }


        #addrs {
            width: 90%;
            background-color: black;
            color: white;
            border-radius: 10px;
            text-align: center;
            font-size: 25px;
            font-family: Arial, Helvetica, sans-serif;
            margin-top: 10px;

        }

        #formdiv {
            border: solid;
            width: 90%;
            border-radius: 10px;
            margin-top: 10px;
            padding: 10px;
        }

        #name {
            border: none;
            border-bottom-style: solid;
            width: 700px;
            border-bottom-width: 1px;
        }

        #fadd {
            border: none;
            border-bottom-style: solid;
            width: 750px;
            border-bottom-width: 1px;
        }

        #stc {
            border: none;
            border-bottom-style: solid;
            border-bottom-width: 1px;
        }

        #st {
            border: none;
            border-bottom-style: solid;
            border-bottom-width: 1px;
        }

        #gst {
            border: none;
            border-bottom-style: solid;
            border-bottom-width: 1px;
            width: 25 0px;
        }

        #cont {
            border: none;
            border-bottom-style: solid;
            width: 700px;
            border-bottom-width: 1px;

        }

        #tb2 {
            width: 90%;
            margin-top: 10px;
        }

        .drk {
            text-align: center;
            border-radius: 10px;
            color: white;
            background-color: black;

        }

        .sm {
            border-style: solid;
            height: 400px;
            border-radius: 10px;
        }

        #sm7 {
            width: 20px;

        }

        #tb3 {
    border-style: solid;
    border-radius: 10px;
    padding: 10px;
    margin: 3px;
    width: 47%;
}

        #tab34 {
    border-style: solid;
    border-radius: 10px;
    width: 43%;
    margin: 1px;
    padding: 0px;
}

        .tb3cls{
        font-weight: bold;
        border-bottom-style: solid;
        border-left-style: solid;
        
        
        }
        #sig
        {
            border-style: solid;
            width: 90%;
            border-radius: 10px;
            font-size: 18px;
            margin-top:10px;
        }
      
        #tb3id2,#tb3id6,#tb3id10,#tb3id14,#tb3id18
        {
            
        }

    </style>
    <table id="tb1">
        <tr>
            <th rowspan="3" id="kunal">KUNAL</th>
            <td class="bord">GSTIN : 06EOEPK2745N1ZL</td>
        </tr>
        <tr>

            <td class="bord">State : HARYANA</td>
        </tr>
        <tr>

            <td class="bord">S.Code : 06</td>
        </tr>
        <tr>
            <th rowspan="2" id="asso">ASSOCIATES</th>
            <td class="bord">Dated : </td>
        </tr>
        <tr>

            <td id="bill" rowspan="2">Bill No. : </td>
        </tr>
        <tr>
            <th id="mob">M: 88148-71038</th>

        </tr>
    </table>
    <div id="addrs">
        Kalal Majra, Near Hanuman Mandir, Thanesar, Kurukshetra
    </div>
    <div id="formdiv">
        <form name="form1">
            Name<input id="name" type="text" class="wd"><br>
            Address <input type="text" id="fadd" class="wd"><br>
            State <input id="st" type="text" class="wd">
            State Code <input id="stc" type="text" class="wd">
            GSTIN NO. <input id="gst" class="wd" type="text">
            <br> Contact No<input class="wd" type="text" id="cont">
        </form>
    </div>
    <table id="tb2">
        <tr>
            <td class="drk" id="drk1">Sr.No</td>
            <td class="drk" id="drk2">DESCRIPTION OF GOODS</td>
            <td class="drk" id="drk3">HSN/SAC</td>
            <td class="drk" id="drk4">QTY.</td>
            <td class="drk" id="drk5">RATE</td>
            <td colspan="2" class="drk" id="drk6"> <sub>Rs.</sub> Amount <sub>P.</sub> </td>

        </tr>
        <tr>
            <td class="sm" id="sm1">54</td>
            <td class="sm" id="sm2">436</td>
            <td class="sm" id="sm3">634</td>
            <td class="sm" id="sm4">46</td>
            <td class="sm" id="sm5">464</td>
            <td class="sm" id="sm6">555</td>
            <td class="sm" id="sm7">7777</td>
        </tr>

    </table>
    <div style="display:flex">
        <table id="tb3">

            <tr>
                <td class="bnk" id="bnk1">Bank Name</td>
                <td class="bnk" id="bnk1">: BANK OF BARODA</td>
            </tr>

            <tr>
                <td class="bnk" id="bnk1">Place</td>
                <td class="bnk" id="bnk2">:THANESAR BRANCH, THANESAR-136118</td>
            </tr>
            <tr>
                <td class="bnk" id="bnk3">A/c No.</td>
                <td class="bnk" id="bnk4">: 50720200000194</td>
            </tr>
            <tr>
                <td class="bnk" id="bnk5">IFSC</td>
                <td class="bnk" id="bnk6">: BARBOTHANES</td>
            </tr>

        </table>

        <table id="tab34">
            <tr>
                <td style="border-left-style:none ;" class="tb3cls" id="tb3id1" width="150">Taxable Amount</td>
                <td  class="tb3cls" id="tb3id2"></td>
                <td class="tb3cls" id="tb3id3" width="60"></td>
                <td width="25" class="tb3cls" id="tb3id4"></td>
            </tr>
            <tr>
                <td style="border-left-style:none ;" class="tb3cls" id="tb3id5">CGST</td>
                <td  class="tb3cls" id="tb3id6"></td>
                <td class="tb3cls" id="tb3id7"></td>
                <td class="tb3cls" id="tb3id8"></td>
            </tr>

            <tr>
                <td style="border-left-style:none ;" class="tb3cls" id="tb3id9">SGST</td>
                <td class="tb3cls" id="tb3id10"></td>
                <td class="tb3cls" id="tb3id11"></td>
                <td class="tb3cls" id="tb3id12"></td>
            </tr>
            <tr>
                <td style="border-left-style:none ;" class="tb3cls" id="tb3id13">IGST</td>
                <td class="tb3cls" id="tb3id14">b</td>
                <td class="tb3cls" id="tb3id15">b</td>
                <td class="tb3cls" id="tb3id16">b</td>
            </tr>
            <tr>
                <td style="border-left-style:none ;" class="tb3cls" id="tb3id17" height="20"></td>
                <td class="tb3cls" id="tb3id18"></td>
                <td class="tb3cls" id="tb3id19"></td>
                <td class="tb3cls" id="tb3id20"></td>
            </tr>
            <tr>
                <td style="border-left-style:none ;border-bottom-style:none ;" class="tb3cls" id="tb3id21">Grand Total</td>
                <td style="border-bottom-style:none ;" class="tb3cls" id="tb3id22"></td>
                <td style="border-bottom-style:none ;" class="tb3cls" id="tb3id23"></td>
                <td style="border-bottom-style:none ;" class="tb3cls" id="tb3id24"></td>
            </tr>
        </table>


    </div>

<div id="sig">
<pre >
 
 Goods once sold will not be taken back.  
 All disputes are subject to Kurukshetra jurisdiction. 
 E.& O.E
                                                                            Signature
<pre>

</div>

';

$output .= '
	<script src="./js/numberToWord.js"></script>';

// create pdf of invoice	
$invoiceFileName = 'Invoice-'.$invoiceValues['order_id'].'.pdf';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>   
