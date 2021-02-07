<?php
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
class BookingProcess
{
	private $checkInDate		= '';
	private $checkOutDate		= '';
	private $checkintime         = '';
	private $checkouttime        = '';	
	private $strtotimeCheckInDate = 0;	
	private $strtotimeCheckOutDate = 0;
	private $noOfNights			= 0;
	private $mysqlCheckInDate	= '';
	private $mysqlCheckOutDate	= '';	
	private $clientdata			= array();		
	private $expTime			= 0;	
	private $carid12			= 0;	
	private $extrasArr          = array();	
	private $pricedata			= array();
	private $taxAmount 			= 0.00;
	private $taxPercent			= 0.00;
	private $grandTotalAmount 	= 0.00;	
	private $currencySymbol		= '';
	private $depositenabled		= false;
	
	public $clientId			= 0;
	public $clientName			= '';
	public $clientEmail			= '';
	public $bookingId			= 0;
	public $paymentGatewayCode	= '';		
	public $totalPaymentAmount 	= 0.00;	
	public $invoiceHtml			= '';
	
	function __construct() {				
		$this->setMyRequestParams();
		$this->removeSessionVariables();
		//$this->checkAvailability();
		$this->saveClientData();
		$this->saveBookingData(); 
		$this->createInvoice();
	}
	
	private function setMyRequestParams(){ 
		global $bsiCore;	
		$this->setMyParamValue($this->checkInDate, 'SESSION', 'sv_checkindate', NULL, true); 
		$this->setMyParamValue($this->checkOutDate, 'SESSION', 'sv_checkoutdate', NULL, true);
		$this->setMyParamValue($this->checkintime, 'SESSION', 'sv_checkintime', NULL, true);
		$this->setMyParamValue($this->checkouttime, 'SESSION', 'sv_checkouttime', NULL, true);
		$this->setMyParamValue($this->strtotimeCheckInDate, 'SESSION', 'sv_strtotimeCheckInDate', NULL, true);
		$this->setMyParamValue($this->strtotimeCheckOutDate, 'SESSION', 'sv_strtotimeCheckOutDate', NULL, true);
		$this->setMyParamValue($this->noOfNights, 'SESSION', 'sv_nightcount', 0, true);
		$this->setMyParamValue($this->mysqlCheckInDate, 'SESSION', 'sv_mcheckindate', NULL, true);
		$this->setMyParamValue($this->mysqlCheckOutDate, 'SESSION', 'sv_mcheckoutdate', NULL, true);
		$this->setMyParamValue($this->reservationdata, 'SESSION', 'dvars_details', NULL, true);						
		$this->setMyParamValue($this->pricedata, 'SESSION', 'dvars_roomprices', NULL, true);
		$this->setMyParamValue($this->carid12, 'SESSION', 'carid12', NULL, true);	
						
		$this->setMyParamValue($this->clientdata['title'], 'POST', 'title', true); 
		$this->setMyParamValue($this->clientdata['fname'], 'POST', 'fname', '', true);
		$this->setMyParamValue($this->clientdata['lname'], 'POST', 'lname', '', true);
		$this->setMyParamValue($this->clientdata['address'], 'POST', 'str_addr', '', true);
		$this->setMyParamValue($this->clientdata['city'], 'POST', 'city', '', true);
		$this->setMyParamValue($this->clientdata['state'], 'POST', 'state', '', true);
		$this->setMyParamValue($this->clientdata['zipcode'], 'POST', 'zipcode', '', true);
		$this->setMyParamValue($this->clientdata['country'], 'POST', 'country', '', true);
		$this->setMyParamValue($this->clientdata['phone'], 'POST', 'phone', '', true);
		$this->setMyParamValue($this->clientdata['fax'], 'POST', 'fax', '', false); //optionlal
		$this->setMyParamValue($this->clientdata['email'], 'POST', 'email', '', true);
		$this->setMyParamValue($this->clientdata['clientip'], 'SERVER', 'REMOTE_ADDR', '', false);					
		$this->setMyParamValue($this->paymentGatewayCode, 'POST', 'payment_type','', true);
		
		$this->bookingId		  = time();		
		$this->expTime 			  = intval($bsiCore->config['conf_booking_exptime']);	
		$this->currencySymbol 	  = $bsiCore->config['conf_currency_symbol'];
		$this->taxPercent 		  = $bsiCore->config['conf_tax_amount'];
		
		$this->clientName 		  = $this->clientdata['title']." ".$this->clientdata['fname']." ". $this->clientdata['lname'];
		$this->clientEmail		  = $this->clientdata['email'];
		
		$this->taxAmount 		  = $this->pricedata['totaltax'];
		$this->grandTotalAmount   = $this->pricedata['grandtotal'];
		$this->totalPaymentAmount = $this->pricedata['advanceamount'];
	}
	
	private function setMyParamValue(&$membervariable, $vartype, $param, $defaultvalue, $required = false){
		global $bsiCore;
		switch($vartype){
			case "POST": 
				if($required){if(!isset($_POST[$param])){$this->invalidRequest(9);} 
					else{$membervariable = $bsiCore->ClearInput($_POST[$param]);}}
				else{if(isset($_POST[$param])){$membervariable = $bsiCore->ClearInput($_POST[$param]);} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "GET":
				if($required){if(!isset($_GET[$param])){$this->invalidRequest(9);} 
					else{$membervariable = $bsiCore->ClearInput($_GET[$param]);}}
				else{if(isset($_GET[$param])){$membervariable = $bsiCore->ClearInput($_GET[$param]);} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "SESSION":
				if($required){if(!isset($_SESSION[$param])){$this->invalidRequest(9);} 
					else{$membervariable = $_SESSION[$param];}}
				else{if(isset($_SESSION[$param])){$membervariable = $_SESSION[$param];} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "REQUEST":
				if($required){if(!isset($_REQUEST[$param])){$this->invalidRequest(9);}
					else{$membervariable = $bsiCore->ClearInput($_REQUEST[$param]);}}
				else{if(isset($_REQUEST[$param])){$membervariable = $bsiCore->ClearInput($_REQUEST[$param]);}
					else{$membervariable = $defaultvalue;}}				
				break;
			case "SERVER":
				if($required){if(!isset($_SERVER[$param])){$this->invalidRequest(9);}
					else{$membervariable = $_SERVER[$param];}}
				else{if(isset($_SERVER[$param])){$membervariable = $_SERVER[$param];}
					else{$membervariable = $defaultvalue;}}				
				break;			
		}		
	}	
	
	private function invalidRequest($errocode = 9){		
		header('Location: booking-failure.php?error_code='.$errocode.'');
		die;
	}
	
	private function removeSessionVariables(){
		if(isset($_SESSION['sv_checkindate'])) unset($_SESSION['sv_checkindate']);
		if(isset($_SESSION['sv_checkoutdate'])) unset($_SESSION['sv_checkoutdate']);
		if(isset($_SESSION['sv_mcheckindate'])) unset($_SESSION['sv_mcheckindate']);
		if(isset($_SESSION['sv_mcheckoutdate'])) unset($_SESSION['sv_mcheckoutdate']);	
		if(isset($_SESSION['sv_nightcount'])) unset($_SESSION['sv_nightcount']);
		if(isset($_SESSION['sv_checkintime'])) unset($_SESSION['sv_checkintime']);
		if(isset($_SESSION['sv_checkouttime'])) unset($_SESSION['sv_checkouttime']);	
		if(isset($_SESSION['sv_strtotimeCheckInDate'])) unset($_SESSION['sv_strtotimeCheckInDate']);
		if(isset($_SESSION['sv_strtotimeCheckOutDate'])) unset($_SESSION['sv_strtotimeCheckOutDate']);
		if(isset($_SESSION['svars_details'])) unset($_SESSION['svars_details']);
		if(isset($_SESSION['dvars_details'])) unset($_SESSION['dvars_details']);
		if(isset($_SESSION['depositPercent'])) unset($_SESSION['depositPercent']);	
		if(isset($_SESSION['dvars_roomprices'])) unset($_SESSION['dvars_roomprices']);
	}
	 
	/* Check Immediate Booking Status For Concurrent Access */
	private function checkAvailability(){
		global $bsiCore;
		
		foreach ($_SESSION['carid12'] as $value) {
		$sql="select * from (select bcm.*, IFNULL(t1.booked_cars,0) as booked_cars from bsi_car_master bcm LEFT JOIN (select brd.car_id, count(*) as booked_cars from bsi_res_data brd, bsi_bookings bb WHERE brd.booking_id=bb.booking_id and bb.is_deleted = FALSE AND (('".$this->mysqlCheckInDate." ".$this->checkInTime."' BETWEEN pickup_datetime AND ADDTIME(dropoff_datetime, '".$bsiCore->config['conf_interval_between_rent']."')) 
		OR 
		('".$this->mysqlCheckOutDate." ".$this->checkOutTime."' BETWEEN pickup_datetime AND ADDTIME(dropoff_datetime, '".$bsiCore->config['conf_interval_between_rent']."')) 
		OR 
		(pickup_datetime BETWEEN '".$this->mysqlCheckInDate." ".$this->checkInTime."' AND '".$this->mysqlCheckOutDate." ".$this->checkOutTime."')
		OR 
		(ADDTIME(dropoff_datetime, '".$bsiCore->config['conf_interval_between_rent']."') BETWEEN '".$this->mysqlCheckInDate." ".$this->checkInTime."' AND '".$this->mysqlCheckOutDate." ".$this->checkOutTime."')) group by brd.car_id) as t1 on bcm.car_id=t1.car_id ) as p1 where total_car > booked_cars and car_id=".$value." order by price_per_day";	
		$sql = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
			
		if(mysqli_num_rows($sql)==0){	
			((mysqli_free_result($sql) || (is_object($sql) && (get_class($sql) == "mysqli_result"))) ? true : false);
			$this->invalidRequest(13);
			die;
		}
		((mysqli_free_result($sql) || (is_object($sql) && (get_class($sql) == "mysqli_result"))) ? true : false);
		}
	}
	
	private function saveClientData(){
		$sql1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT client_id FROM bsi_clients WHERE email = '".$this->clientdata['email']."'");
		if(mysqli_num_rows($sql1) > 0){
			$clientrow = mysqli_fetch_assoc($sql1);
			$this->clientId = $clientrow["client_id"];	
			$sql2 = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE bsi_clients SET first_name = '".$this->clientdata['fname']."', surname = '".$this->clientdata['lname']."', title = '".$this->clientdata['title']."', street_addr = '".$this->clientdata['address']."', city = '".$this->clientdata['city']."' , province = '".$this->clientdata['state']."', zip = '".$this->clientdata['zipcode']."', country = '".$this->clientdata['country']."', phone = '".$this->clientdata['phone']."', fax = '".$this->clientdata['fax']."', ip = '".$this->clientdata['clientip']."' WHERE client_id = ".$this->clientId);				
		}else{
			$sql2 = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO bsi_clients (first_name, surname, title, street_addr, city, province, zip, country, phone, fax, email, ip) values('".$this->clientdata['fname']."', '".$this->clientdata['lname']."', '".$this->clientdata['title']."', '".$this->clientdata['address']."', '".$this->clientdata['city']."' , '".$this->clientdata['state']."', '".$this->clientdata['zipcode']."', '".$this->clientdata['country']."', '".$this->clientdata['phone']."', '".$this->clientdata['fax']."', '".$this->clientdata['email']."', '".$this->clientdata['clientip']."')");
			$this->clientId = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);			
		}
		((mysqli_free_result($sql1) || (is_object($sql1) && (get_class($sql1) == "mysqli_result"))) ? true : false);		
	}
	
	private function saveBookingData(){
		global $bsiCore;
		$sql = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO bsi_bookings (booking_id, booking_time, pickup_datetime, dropoff_datetime, client_id, total_cost, payment_amount, payment_type,pick_loc,drop_loc) values(".$this->bookingId.", NOW(), '".$this->mysqlCheckInDate." ".$this->checkintime."', '".$this->mysqlCheckOutDate." ".$this->checkouttime."', ".$this->clientId.", ".$this->grandTotalAmount.", ".$this->totalPaymentAmount.", '".$this->paymentGatewayCode."','". $bsiCore->getlocname($_SESSION['sv_pickup'])."','". $bsiCore->getlocname($_SESSION['sv_dropoff'])."')");
		foreach ($_SESSION['carid12'] as $value) {
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_res_data values(".$this->bookingId.", ".$value.")");
		}
	}	
	
	private function createInvoice(){
		global $bsiCore;
		$this->invoiceHtml = '<table style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; width:700px; border:none;" cellpadding="5" cellspacing="1"><tbody><tr><td align="left" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;" colspan="4">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], RENTAL_DETAILS_TEXT).'</td></tr>
		<tr>
        <td bgcolor="#f2f2f2" align="left" colspan="2"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], PICKUP_LOCATION).'</strong></td>
        <td bgcolor="#f2f2f2" align="left" colspan="2"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], DROPOFF_LOCATION).'</strong></td>
      </tr>
      <tr>
        <td bgcolor="#ffffff" align="left" colspan="2">'.$bsiCore->getlocname($_SESSION['sv_pickup']).'</td>
        <td bgcolor="#ffffff" align="left" colspan="2">'.$bsiCore->getlocname($_SESSION['sv_dropoff']).'</td>
      </tr>
		<tr>
        <td bgcolor="#f2f2f2" align="left" colspan="1"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], PICKUP_DATE_TEXT).' &amp; '.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], TIME_TEXT).'</strong></td>
        <td bgcolor="#f2f2f2" align="left" colspan="1"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], DROPOFF_DATE).' &amp; '.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], TIME_TEXT).'</strong></td>
        <td bgcolor="#f2f2f2" align="left" colspan="2"></td>
      </tr>
	  <tr>
        <td bgcolor="#FFFFFF" align="left" colspan="1">'.$this->checkInDate.'
          &nbsp;&nbsp;
          '.date('g:i A', $this->strtotimeCheckInDate).'</td>
        <td bgcolor="#FFFFFF" align="left" colspan="1">'.$this->checkOutDate.'
          &nbsp;&nbsp;
          '.date('g:i A',$this->strtotimeCheckOutDate).'</td>
        <td bgcolor="#FFFFFF" align="center" colspan="2"><strong>'.$_SESSION['textshowduration'].'</strong></td>
      </tr>
	 <tr>
        <td bgcolor="#f2f2f2" align="left"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], CARTYPE_TEXT).'</strong></td>
        <td bgcolor="#f2f2f2" align="center"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], CAR_VENDOR_TEXT).'</strong></td>
        <td bgcolor="#f2f2f2" align="center"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], CAR_MODEL_TEXT).'</strong></td>
        <td bgcolor="#f2f2f2" align="right" style="padding-right:5px;"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], GROSS_TOTAL_TEXT).'</strong></td>
      </tr>';
	  foreach ($_SESSION['carid12'] as $value) {
		 
	  $this->invoiceHtml.= '<tr>
        <td bgcolor="#FFFFFF" align="left">'.$bsiCore->getCarType($this->reservationdata[$value]['cardetails']['car_type_id']).'</td>
        <td bgcolor="#FFFFFF" align="center">'.$bsiCore->getCarVendor($this->reservationdata[$value]['cardetails']['car_vendor_id']).'</td>
        <td bgcolor="#FFFFFF" align="center">'.$this->reservationdata[$value]['cardetails']['car_model'].'</td>
        <td bgcolor="#FFFFFF" align="right" style="padding-right:5px;">'.$bsiCore->config['conf_currency_symbol'].number_format($this->pricedata['grosstotal'][$value], 2).'</td>
      </tr>';		
	  }
		if(!empty($_SESSION['listExtraService'])){
		  $this->invoiceHtml.= '<tr>
				    <td bgcolor="#f2f2f2" align="left" colspan="4"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], RENTAL_OPTIONS_TEXT).'</strong></td>
			    </tr>';
		  $i=1;
			foreach($_SESSION['listExtraService'] as $key => $value){ 
				
				$this->invoiceHtml.= '<tr >
							<td bgcolor="#FFFFFF" align="left" colspan="3">'.$value['description'].' ( '.$bsiCore->config['conf_currency_symbol'].number_format($value['price'], 2).' x '.$this->noOfNights.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], DAYS_TEXT).' )</td>
							<td bgcolor="#FFFFFF" align="right" style="padding-right:5px;">'.$bsiCore->config['conf_currency_symbol'].number_format($value['totalprice'], 2).'</td>
						  </tr>';		 
			}	
	  }
					
		$this->invoiceHtml.= '<tr><td colspan="3" align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], SUB_TOTAL_TEXT).'</td><td align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.$this->currencySymbol.number_format($this->pricedata['subtotal'], 2 , '.', ',').'</td></tr>';
		
		if($this->pricedata['discountPercent'] > 0 && $this->pricedata['discountPercent'] < 100){
			$this->invoiceHtml .= '<tr>
        		<td bgcolor="#f2f2f2" align="right" colspan="3" style="color:#F00;"><strong>'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], FLAT_DISCOUNT_TEXT).' ('.$this->pricedata['discountPercent'].'%)</strong></td>
        		<td bgcolor="#f2f2f2" align="right" style="padding-right:5px; color:#F00;"><strong>-
          		'.$bsiCore->config['conf_currency_symbol'].$this->pricedata['discountCalculated'].'</strong></td>
      		</tr>';	
		}
					
		if($this->taxPercent > 0 && $this->taxPercent < 100){ 	
		$this->invoiceHtml.= '<tr><td colspan="3" align="right" style="background:#ffffff;">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], TAX).'('.number_format($this->taxPercent, 2 , '.', '').'%)</td><td align="right" style="background:#ffffff;">(+) '.$this->currencySymbol.number_format($this->taxAmount, 2 , '.', ',').'</td></tr><tr><td colspan="3" align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], GRAND_TOTAL_TEXT).'</td><td align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.$this->currencySymbol.number_format($this->grandTotalAmount, 2 , '.', ',').'</td></tr>';
		}
		if($this->pricedata['advancepercentage'] > 0){
			$this->invoiceHtml.= '<tr><td colspan="3" align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], PREPAID_AMOUNT_TEXT).'(<span style="font-size: 10px;">'.number_format($this->pricedata['advancepercentage'], 2 , '.', '').'% '.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], OF_GRAND_TOTAL_TEXT).'</span>)</td><td align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.$this->currencySymbol.number_format($this->totalPaymentAmount, 2 , '.', ',').'</td></tr>';
		} 
		$this->invoiceHtml.= '</tbody></table>';
		
		if($this->paymentGatewayCode == "poa"){
			$payoptions = $bsiCore->paymentGatewayName("poa");		
			$this->invoiceHtml.= '<br /><table  style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; width:700px; border:none;" cellpadding="4" cellspacing="1"><tr><td align="left" colspan="2" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], PAYMENT_DETAILS_TEXT).'</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps;background:#ffffff;">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], PAYMENT_OPTION_TEXT).'</td><td align="left" style="background:#ffffff;">'.$payoptions.'</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps; background:#ffffff;">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], TRANSACTION_ID_TEXT).'</td><td align="left" style="background:#ffffff;">'.mysqli_real_escape_string($GLOBALS["___mysqli_ston"], NA_TEXT).'</td></tr></table>';					
		}
		//echo $this->invoiceHtml;
		//die;
		/* insert the invoice data in bsi_invoice table */
		$insertInvoiceSQL = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO bsi_invoice(booking_id, client_name, client_email, invoice) values(".$this->bookingId.", '".$this->clientName."', '".$this->clientdata['email']."', '".$this->invoiceHtml."')");	
	}
}
?>