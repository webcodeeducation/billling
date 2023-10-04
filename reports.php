<?php 
session_start();
include('header.php');
include 'Invoice.php';
include 'Ledger.php';
$companyNameError = false;
$invoice = new Invoice();
$ledger = new Ledger();
$invoice->checkLoggedIn();
$categoryList = $invoice->getCategoryustomerList();
if(isset($_GET['category']) && !empty($_GET['category'])) {
$category = $_GET['category'];
  $invoiceList = $invoice->getInvoiceListByCategory($category);
  $success = true;

}else{
  $invoiceList = $invoice->getInvoiceList();
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container-fluid dashboard">
 
  <div class="row">

    
  <div class="col-sm-12 col-md-12 col-lg-12">
    <a href="reports.php" class="btn btn-primary">Show All</a>
<div id="toolbar">
  <form>
    <select class="form-control" name="category" onchange="this.form.submit()">
      <option value="0">Select All</option>
      <?php
              foreach($categoryList as $catValue)
              {
                echo '
                <option value="'.$catValue["id"].'">'.$catValue["category_name"].'</option>';
              }
               ?>
    </select>
  </form>
</div>

<?php 
    
     if(empty($invoiceList)){
      echo '<div class="alert alert-danger" role="alert">No Transactions Yet!</div>'; 
    }
    else {  
    ?>

<table id="table" 
       data-toggle="table"
       data-search="true"
       data-filter-control="true" 
       data-show-export="true"
       data-click-to-select="true"
       data-toolbar="#toolbar"
       class="table table-responsive">
  <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Bill Date</th>
            <th>Category</th>
            <th>Customer Name</th>
            <th>Invoice Total</th>
            <th>Amount Due </th>
            <th>Print</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
  <tbody>
    <?php   
        foreach($invoiceList as $invoiceDetails){
          $customerDetails = $ledger -> getCustomer($invoiceDetails['customer_id']);
          $invoiceDate = $invoiceDetails['order_date'];
          //$invoiceDate = $invoiceDetails['order_date'];
          //$date = $invoice -> NepaliDate($invoiceDate, $nepali_date);
          
            echo '
              <tr>
                <td>'.$invoiceDetails["order_id"].'</td>
                <td>'.$invoiceDate.'</td>
                <td>'.$invoiceDetails["category_name"].'</td>
                <td>'.$customerDetails["customer_name"].'</td>
                <td>'.$invoiceDetails["order_total_after_tax"].'</td>
                <td>'.$invoiceDetails["order_total_amount_due"].'</td>
                <td><a href="print_invoice.php?invoice_id='.$invoiceDetails["order_id"].'" title="Print Invoice" target="_blank"><span class="glyphicon glyphicon-print"></span></a></td>
                <td><a href="edit_invoice.php?update_id='.$invoiceDetails["order_id"].'"  title="Edit Invoice"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="#" id="'.$invoiceDetails["order_id"].'" class="deleteInvoice"  title="Delete Invoice"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
        }
      }
        ?>
  </tbody>
</table>
  </div>
  </div>
</div>

<?php include('footer.php');?>