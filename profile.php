<?php 
session_start();
error_reporting(0);
include('header.php');
include 'Invoice.php';
include 'ledger.php';
//print_r($_SESSION['userid']);
$id = $_SESSION['userid'];
$success = false;
$error= '';
$invoice = new Invoice();
$ledger = new Ledger();
$invoice->checkLoggedIn();
$profile = $invoice->getUserProfile($id);
//print_r($profile);

if(isset($_POST['setting_btn'])) {
  $invoice->saveProfile($_POST);
  $success = true;
  header("Location: profile.php");

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
  <input type="hidden" name="userid" value="<?=$id?>"> 
    <div class="load-animate animated fadeInUp">
      <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
          <h2 class="title">User Settings</h2> 
        </div>            
      </div></br></br>
      <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" value="<?=$profile['email']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>Password</label>
          <input type="text" name="password" value="<?=$profile['password']?>" class="form-control">
        </div>
      </div>
      </div>
      <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>First Name</label>
          <input type="text" name="first_name" value="<?=$profile['first_name']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>Last Name</label>
          <input type="text" name="last_name" value="<?=$profile['last_name']?>" class="form-control">
        </div>
      </div>
      </div>
      <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>Mobile</label>
          <input type="text" name="mobile" value="<?=$profile['mobile']?>" class="form-control">
        </div>
      </div>
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
          <label>Address</label>
          <input type="text" name="address" value="<?=$profile['address']?>" class="form-control">
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