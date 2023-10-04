<?php 
session_start();
error_reporting(0);
include('header.php');
include 'Invoice.php';
include 'ledger.php';
$success = false;
$error= '';
$invoice = new Invoice();
$ledger = new Ledger();
$invoice->checkLoggedIn();
if(isset($_POST['setting_btn'])) {
  $invoice -> saveSetings($_POST);
  $success = true;
header("Location: mastersetting.php");
}else if(!isset($_POST['setting_btn'])) {
$settings = $invoice->getMasterSettings();
//print_r($settings);
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
  <div><a class="btn btn-warning back_btn" href="javascript:history.go(-1)">&#8592 Go Back</a></div>
  <?php
    if($success) {
      echo '<div class="alert alert-success" role="alert">Settings Saved Successfully!</div>'; 
    }
    if(!empty($error)) {
      echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    }
  ?>
  <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
    <input type="hidden" name="id" value="<?=$settings['id']?>">
    <div class="load-animate animated fadeInUp">
      <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
          <h2 class="title">Insert New Items</h2> 
        </div>            
      </div></br></br>
      <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>CGST</label>
          <input type="text" name="cgst" value="<?=$settings['cgst']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>SGST</label>
          <input type="text" name="sgst" value="<?=$settings['sgst']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>GST No</label>
          <input type="text" name="gstno" value="<?=$settings['gstno']?>" class="form-control">
        </div>
      </div>
      </div>
      <div class="row">
        
      <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
          <div class="form-group">
          <label>Bank Name</label>
          <input type="text" name="bank_name" value="<?=$settings['bank_name']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
          <div class="form-group">
          <label>Bank Place</label>
          <input type="text" name="bank_place" value="<?=$settings['bank_place']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
          <div class="form-group">
          <label>A/C No</label>
          <input type="text" name="accno" value="<?=$settings['acc_no']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
          <div class="form-group">
          <label>Phone</label>
          <input type="text" name="phone" value="<?=$settings['phone']?>" class="form-control">
        </div>
      </div>
      </div>
      <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>IFSC Code:</label>
          <input type="text" name="ifsc" value="<?=$settings['ifsc']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>Address</label>
          <input type="text" name="address" value="<?=$settings['address']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" value="<?=$settings['email']?>" class="form-control">
        </div>
      </div>
      </div>
      
      <div class="clearfix"></div>  
      <div class="form-group center">
            <input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
            <input data-loading-text="Saving Items..." type="submit" name="setting_btn" value="Save Setting" class="btn btn-primary submit_btn receipt-save-btn">            
          </div>          
    </div>
  </form>     
</div>
</div>  
<?php include('footer.php');?>