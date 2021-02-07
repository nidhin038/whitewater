<?php
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
**/
class bsiBookingDetails
{
	public $checkindate = 0;			
	public $checkoutdate = 0;	
	public $checkintime = '';
	public $checkouttime = '';	
	public $strtotimeCheckInDate = 0;	
	public $strtotimeCheckOutDate = 0;
	public $mcheckindate = '';
	public $mcheckoutdate = '';
	public $nightcount = 0;
	public $carid12;
	public $bookingDetails = array();
	public $carPrices = array();
	public $depositPercent	= 0;
	public $discountPercent = 0;
	public $pricePerDay = 0;
	public $extrasArr = array();
	public $listExtraService = array();
	
	function __construct() {	
		$this->setRequestParams();
		$this->getDurationDiscount();
	}		
	
	private function setRequestParams() {	
		/**
		 * Global Ref: conf.class.php
		 **/
		global $bsiCore;	
		$this->setMyParamValue($this->checkindate, 'SESSION', 'sv_checkindate', NULL, true);		
		$this->setMyParamValue($this->checkoutdate, 'SESSION', 'sv_checkoutdate', NULL, true);
		$this->setMyParamValue($this->checkintime, 'SESSION', 'sv_checkintime', NULL, true);
		$this->setMyParamValue($this->checkouttime, 'SESSION', 'sv_checkouttime', NULL, true);
		$this->setMyParamValue($this->strtotimeCheckInDate, 'SESSION', 'sv_strtotimeCheckInDate', NULL, true);
		$this->setMyParamValue($this->strtotimeCheckOutDate, 'SESSION', 'sv_strtotimeCheckOutDate', NULL, true);		
		$this->setMyParamValue($this->mcheckindate, 'SESSION', 'sv_mcheckindate', NULL, true);
		$this->setMyParamValue($this->mcheckoutdate, 'SESSION', 'sv_mcheckoutdate', NULL, true);
		$this->setMyParamValue($this->nightcount, 'SESSION', 'sv_nightcount', NULL, true);
		$this->setMyParamValue($this->bookingDetails, 'SESSION', 'svars_details', NULL, true);
		$this->setMyParamValue($this->depositPercent, 'SESSION', 'depositPercent', NULL, true);
		$this->setMyParamValue($this->carid12, 'SESSION', 'carid12', NULL, true);
		$this->setMyParamValue($this->extrasArr, 'POST_SPECIAL', 'carExtras', NULL, true);		
		if($this->extrasArr)$this->extrasArr = array_filter($this->extrasArr);		
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
			case "POST_SPECIAL":
				if($required){if(!isset($_POST[$param])){}
					else{$membervariable = $_POST[$param];}}
				else{if(isset($_POST[$param])){$membervariable = $_POST[$param];}
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
	
	private function getDurationDiscount(){
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `bsi_discount_duration` where ".$this->nightcount." between day_from and day_to");
		if(mysqli_num_rows($result)){
			$row = mysqli_fetch_assoc($result);	
			$this->discountPercent = $row['discount_percent'];
		}
	}	
	private function getExrtaServices(){		
		$extidlist = implode(",", array_keys($this->extrasArr));
		$sql = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM bsi_car_extras  WHERE id IN(".$extidlist.")");
		
		while($currentrow = mysqli_fetch_assoc($sql)){	
			$temptotalfees = 0.00;
			$tempdescription = "";
			$temptotalfees = number_format(($currentrow["price"] * $this->extrasArr[$currentrow["id"]] * $_SESSION['sv_nightcount']), 2, '.', '');
			$tempdescription = $currentrow["car_extras"]." x <b>".$this->extrasArr[$currentrow["id"]]."</b>";					
			array_push($this->listExtraService, array('extraid'=>$currentrow["id"],'description'=>$tempdescription, 'price'=>$currentrow["price"], 'totalprice'=>$temptotalfees));
				
			$this->carPrices['totalextraprices'] = $this->carPrices['totalextraprices'] + $temptotalfees;					
		}
		$_SESSION['listExtraService']=$this->listExtraService;		
		((mysqli_free_result($sql) || (is_object($sql) && (get_class($sql) == "mysqli_result"))) ? true : false);	
	}
	
	public function generateBookingDetails() {
		global $bsiCore;
		$result = array();
		$dvroomidsonly = "";		
		$this->carPrices['subtotal']   = 0.00;	
		$this->carPrices['totaltax']   = 0.00;			
		$this->carPrices['grandtotal'] = 0.00;
		$this->carPrices['discountCalculated'] = 0.00;
		$this->carPrices['totalextraprices'] = 0.00;
		
		$car_price_array=$_SESSION['car_price_array'];
		
		foreach ($this->carid12 as $value) {
		
		$this->carPrices['grosstotal'][$value] = $car_price_array[$this->bookingDetails[$value]['cardetails']['car_id']];		
		$this->carPrices['subtotal']+= $this->carPrices['grosstotal'][$value];
		}
		
		
		
		if(count($this->extrasArr) > 0){
			$this->getExrtaServices();
			$this->carPrices['subtotal'] = $this->carPrices['subtotal'] + $this->carPrices['totalextraprices'];			
		}
		
		
		
		
		/* -------------------------------- calculate pricing ------------------------------------ */
		if($this->discountPercent > 0 && $this->discountPercent < 100){
			$this->carPrices['discountPercent']	= $this->discountPercent;
			$this->carPrices['discountCalculated'] = ($this->carPrices['subtotal'] * $this->discountPercent)/100;
		}else{
			$this->carPrices['discountPercent']=0;
		}
											
		if($bsiCore->config['conf_tax_amount'] > 0){ 
			$this->carPrices['totaltax'] = (($this->carPrices['subtotal']-$this->carPrices['discountCalculated'] ) * $bsiCore->config['conf_tax_amount'])/100;
			$this->carPrices['grandtotal'] =( $this->carPrices['subtotal']-$this->carPrices['discountCalculated']) + $this->carPrices['totaltax'];	
		}	
				
		if($this->depositPercent > 0){
			$this->carPrices['advancepercentage'] = $this->depositPercent;			
			$this->carPrices['advanceamount'] = ($this->carPrices['grandtotal'] * $this->carPrices['advancepercentage'])/100;
		}
		
		//format currencies round upto 2 decimal places		
		$this->carPrices['subtotal'] = number_format($this->carPrices['subtotal'], 2 , '.', '');	
		$this->carPrices['totaltax'] = number_format($this->carPrices['totaltax'], 2 , '.', '');			
		$this->carPrices['grandtotal'] = number_format($this->carPrices['grandtotal'], 2 , '.', '');
		$this->carPrices['advancepercentage'] = number_format($this->carPrices['advancepercentage'], 2 , '.', '');
		$this->carPrices['advanceamount'] = number_format($this->carPrices['advanceamount'], 2 , '.', '');
		$this->carPrices['discountCalculated'] = number_format($this->carPrices['discountCalculated'], 2 , '.', '');
		if(isset($_SESSION['dvars_roomprices'])) unset($_SESSION['dvars_roomprices']);
			$_SESSION['dvars_roomprices'] = $this->carPrices;
		
		if(isset($_SESSION['dvars_details'])) unset($_SESSION['dvars_details']);
			$_SESSION['dvars_details'] = $this->bookingDetails;
		
	}	
}
?>