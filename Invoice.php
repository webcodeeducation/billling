<?php
class Invoice{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "kunalbilling";   
	private $invoiceUserTable = 'invoice_user';	
    private $invoiceOrderTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
	private $productTable = 'items';
	private $settingTable = 'settings';
	private $categoryTable = 'categories';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}

	private function getField($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data = mysqli_fetch_object($result);            
		return $data;
	}

	private function getSingleData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
	
		$data = mysqli_fetch_assoc($result);
		return $data;
	}


	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function getUserProfile($id){
		$sqlQuery = "SELECT * FROM ".$this->invoiceUserTable." WHERE id='".$id."' LIMIT 1";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$data = mysqli_fetch_assoc($result);
		return $data;
	}
	public function loginUsers($email, $password){
		$sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile 
			FROM ".$this->invoiceUserTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	
	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}		
	public function saveInvoice($POST) {
	//print_r($POST);
	$taxRate = $POST['cgst'] * $POST['sgst'];	
		$sqlInsert = "
			INSERT INTO ".$this->invoiceOrderTable."(user_id, category_id,customer_id,order_date,bill_no, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, note) 
			VALUES ('".$POST['userId']."', '".$POST['categoryId']."','".$POST['customerId']."','".$POST['billdate']."','".$POST['billno']."','".$POST['subTotal']."', '".$POST['totalAftertax']."', '".$taxRate."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['amountDue']."', '".$POST['notes']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productName']); $i++) {
			echo $sqlInsertItem = "
			INSERT INTO ".$this->invoiceOrderItemTable."(order_id,item_name, order_item_hsn, order_item_quantity, order_item_price, order_item_final_amount) 
			VALUES ('".$lastInsertId."', '".$POST['productName'][$i]."', '".$POST['hsn'][$i]."','".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
	}	
	public function updateInvoice($POST) {
		//print_r($POST);
		if($POST['invoiceId']) {	
			$sqlInsert = "
				UPDATE ".$this->invoiceOrderTable." 
				SET  order_date='".$POST['billdate']."',bill_no='".$POST['billno']."',order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', cgst = '".$POST['cgst']."',sgst = '".$POST['sgst']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."' 
				WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['invoiceId']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
		}		
		
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name,order_item_hsn, order_item_quantity, order_item_price, order_item_final_amount) 
				VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['order_item_hsn'][$i]."','".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);			
		}       	
	}	

	public function updateDueAmount($amount, $invoiceId) {
		$sqlInsert = "
		UPDATE ".$this->invoiceOrderTable." 
		SET  order_total_amount_due = '".$amount."'
		WHERE user_id = '".$_SESSION['userid']."' AND order_id = '".$invoiceId."'";		
	mysqli_query($this->dbConnect, $sqlInsert);	
	}

	public function validateInvoice($invoice_id, $customerId) {
		$sqlQuery = "
		SELECT * FROM ".$this->invoiceOrderTable." 
		WHERE user_id = '".$_SESSION['userid']."'
		AND order_id='".$invoice_id."'
		AND customer_id='".$customerId."'";
		$count = $this->getNumRows($sqlQuery);
		if($count) {
			return true;
		}
		return false;
	}

	public function getInvoiceList(){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." join categories on ".$this->invoiceOrderTable.".category_id=categories.id 
			WHERE ".$this->invoiceOrderTable.".user_id = '".$_SESSION['userid']."'
			ORDER BY ".$this->invoiceOrderTable.".order_date ASC";
		return  $this->getData($sqlQuery);
	}
	public function getInvoiceListByCustomer($customerId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND customer_id = '$customerId'
			ORDER BY order_date ASC";
		return  $this->getData($sqlQuery);
	}
	public function getInvoiceListByCategory($categoryId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." join categories on ".$this->invoiceOrderTable.".category_id=categories.id 
			WHERE ".$this->invoiceOrderTable.".category_id = '".$categoryId."'
			ORDER BY ".$this->invoiceOrderTable.".order_date ASC";
		return  $this->getData($sqlQuery);
	}	
	public function getInvoice($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND order_id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	
	public function getInvoiceItems($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);	
	}
	public function deleteInvoiceItems($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}
	public function deleteInvoice($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoiceId);	
		return 1;
	}

	public function getTotalDue($invoiceId) {
		$sqlQuery = "
		SELECT order_total_amount_due FROM ".$this->invoiceOrderTable."
		WHERE order_id = '".$invoiceId."'";
		$result = $this->getSingleData($sqlQuery);
		return $result['order_total_amount_due'];
	}

	public function insertItems($POST) {
		for ($i = 0; $i < count($POST['productName']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->productTable."( user_id, item_name, item_price) 
			VALUES ('".$POST['userId']."', '".$POST['productName'][$i]."',  '".$POST['price'][$i]."')";			
			$result = mysqli_query($this->dbConnect, $sqlInsertItem);
		}      
	}

	public function getItemDetails($itemId) {
		$sqlQuery = "
		SELECT * FROM ".$this->productTable."
		WHERE item_number = '".$itemId."'";
		return  $this->getField($sqlQuery);
	}

	public function getAllItems() {
		$sqlQuery = "
		SELECT * FROM ".$this->productTable."
		WHERE user_id = '".$_SESSION['userid']."'";
		return  $this->getData($sqlQuery);
	}

	public function NepaliDate($engDate, $nepDateObj){
		
		$date = array();
		$invoiceYear = date("Y", strtotime($engDate));
		$invoiceMonth = date("m", strtotime($engDate));
		$invoiceDay = date("d", strtotime($engDate));

		$date_ne = $nepDateObj->get_nepali_date($invoiceYear, $invoiceMonth, $invoiceDay);
		$year = $date_ne['y'];
		($date_ne['m'] < 10) ? $month = 0 . $date_ne['m'] : $month = $date_ne['m'];
		($date_ne['d'] < 10) ? $day = 0 . $date_ne['d'] : $day = $date_ne['d'];
		$date['y'] = $date_ne['y'];
		$date['m'] = $date_ne['m'];
		$date['d'] = $date_ne['d'];
		return $date;
	}
	public function getMasterSettings(){
		$sqlQuery = "SELECT * FROM ".$this->settingTable;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		return mysqli_fetch_assoc($result);
	}
		private function getNumSettings($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
		public function saveSetings($data){
		//print_r($data);
		$id = $data['id'];
		$cgst = $data['cgst'];
		$sgst = $data['sgst'];
		$gstno = $data['gstno'];
		$bank = $data['bank_name'];
		$bank_place = $data['bank_place'];
		$accno = $data['accno'];
		$phone = $data['phone'];
		$ifsc = $data['ifsc'];
		$address = $data['address'];
		$email = $data['email'];
		$check = 'select * from settings';
		$count = $this->getNumSettings($check);
		//print_r($count);
		if($count > 0){
			$sqlUpdateItem = "
			update ".$this->settingTable." set cgst='".$cgst."', sgst='".$sgst."', gstno='".$gstno."', bank_name='".$bank."', bank_place='".$bank_place."', acc_no='".$accno."', phone='".$phone."',ifsc='".$ifsc."', address='".$address."', email='".$email."' where id=".$id;
			$result = mysqli_query($this->dbConnect, $sqlUpdateItem);
		}else{
			$sqlInsertItem = "
			INSERT INTO ".$this->settingTable."( cgst, sgst, gstno, bank_name, bank_place, acc_no, phone,ifsc, address,email) 
			VALUES ('".$cgst."', '".$sgst."',  '".$gstno."','".$gstno."','".$bank."','".$bank_place."','".$accno."','".$phone."','".$ifsc."','".$address."','".$email."')";			
			$result = mysqli_query($this->dbConnect, $sqlInsertItem);
		}
	}
	public function saveProfile($data){
		//print_r($data);
		//die();
		$id = $data['userid'];
		$email = $data['email'];
		$password = $data['password'];
		$first_name = $data['first_name'];
		$last_name = $data['last_name'];
		$mobile = $data['mobile'];
		$address = $data['address'];
		$check = 'select * from ' . $this->invoiceUserTable;
		$count = $this->getNumSettings($check);
		if($count > 0){
			$sqlInsertItem = "
			update ".$this->invoiceUserTable." set email='".$email."', password='".$password."', first_name='".$first_name."', last_name='".$last_name."', mobile='".$mobile."', address='".$address."' where id=".$id;
			$result = mysqli_query($this->dbConnect, $sqlInsertItem);
		}else{
			$sqlInsertItem = "
			INSERT INTO ".$this->invoiceUserTable."( email, password, first_name, last_name, mobile, address)
			VALUES ('".$email."', '".$password."',  '".$first_name."','".$last_name."','".$mobile."','".$addresss."')";
			$result = mysqli_query($this->dbConnect, $sqlInsertItem);
		}
	}
	public function getCategoryustomerList(){
		$sqlQuery = "SELECT * FROM ".$this->categoryTable;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		return $result;
	}
		public function insertCategories($POST) {
			//print_r($POST);
		for ($i = 0; $i < count($POST['categoryName']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->categoryTable."(category_name) 
			VALUES ('".$POST['categoryName'][$i]."')";
			$result = mysqli_query($this->dbConnect, $sqlInsertItem);
		}      
	}
}
?>