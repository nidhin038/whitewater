<?php
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
class bsiSearch
{
	public $checkInDate       = '';
    public $checkOutDate      = '';	
	public $checkInTime       = '';
    public $checkOutTime      = '';	
	public $mysqlCheckInDate  = '';
    public $mysqlCheckOutDate = '';
	public $strtotimeCheckInDate  = '';
    public $strtotimeCheckOutDate = '';
	public $noofRoom          = 0;
	public $nightCount        = 0;
	public $hourCount        = 0;
	public $price	          = 0;
	public $priceArr          = array();
	public $type              = "";
	public $carid             = 0;
	public $fullDateRange;
	public $searchCode        = "SUCCESS";
	const SEARCH_CODE         = "SUCCESS";
	public $tillequal		  = 0;

	

	function __construct() {				
		$this->setRequestParams();
		$this->getNightCount();
		$this->checkSearchEngine();	
		if($this->searchCode == self::SEARCH_CODE){
			$this->fullDateRange = $this->getDateRangeArray($this->mysqlCheckInDate, $this->mysqlCheckOutDate);
			$this->setMySessionVars();
		}	
	}

	private function setRequestParams() {		
		global $bsiCore;
		$tmpVar = isset($_POST['car_type'])? $_POST['car_type'] : NULL; 
		$this->setMyParamValue($this->type, $bsiCore->ClearInput($tmpVar), NULL, true); 
	    $tmpVar = isset($_POST['pickup'])? $_POST['pickup'] : NULL;
		$this->setMyParamValue($this->checkInDate, mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $tmpVar), NULL, true);
		$tmpVar = isset($_POST['dropoff'])? $_POST['dropoff'] : NULL; 
		$this->setMyParamValue($this->checkOutDate, mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $tmpVar), NULL, true);
		$tmpVar = isset($_POST['pickUpTime'])? $_POST['pickUpTime'] : NULL;
		$this->setMyParamValue($this->checkInTime, mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $tmpVar), NULL, true);
		$tmpVar = isset($_POST['dropoffTime'])? $_POST['dropoffTime'] : NULL; 
		$this->setMyParamValue($this->checkOutTime, mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $tmpVar), NULL, true); 			 			
		$this->mysqlCheckInDate  = $bsiCore->getMySqlDate($this->checkInDate);   	  
		$this->mysqlCheckOutDate = $bsiCore->getMySqlDate($this->checkOutDate);	
		
		$this->strtotimeCheckInDate  = $this->mysqlCheckInDate." ".$this->checkInTime;
		$this->strtotimeCheckInDate  = strtotime($this->strtotimeCheckInDate);
		$this->strtotimeCheckOutDate = $this->mysqlCheckOutDate." ".$this->checkOutTime;
		$this->strtotimeCheckOutDate = strtotime($this->strtotimeCheckOutDate);
	}

	

	private function setMyParamValue(&$membervariable, $paramvalue, $defaultvalue, $required = false){
		if($required){if(!isset($paramvalue)){$this->invalidRequest();}}
		if(isset($paramvalue)){ $membervariable = $paramvalue;}else{$membervariable = $defaultvalue;}
	}

	private function setMySessionVars(){
		if(isset($_SESSION['sv_checkindate']))   unset($_SESSION['sv_checkindate']);
		if(isset($_SESSION['sv_checkoutdate']))  unset($_SESSION['sv_checkoutdate']);
		if(isset($_SESSION['sv_checkintime']))   unset($_SESSION['sv_checkintime']);
		if(isset($_SESSION['sv_checkouttime']))  unset($_SESSION['sv_checkouttime']);
		if(isset($_SESSION['sv_strtotimeCheckInDate']))   unset($_SESSION['sv_strtotimeCheckInDate']);
		if(isset($_SESSION['sv_strtotimeCheckOutDate']))  unset($_SESSION['sv_strtotimeCheckOutDate']);
		if(isset($_SESSION['sv_mcheckindate']))  unset($_SESSION['sv_mcheckindate']);
		if(isset($_SESSION['sv_mcheckoutdate'])) unset($_SESSION['sv_mcheckoutdate']);
		if(isset($_SESSION['sv_nightcount']))    unset($_SESSION['sv_nightcount']);
		if(isset($_SESSION['sv_hourcount']))    unset($_SESSION['sv_hourcount']);
		if(isset($_SESSION['sv_tillequal']))    unset($_SESSION['sv_tillequal']);
		if(isset($_SESSION['car_type']))         unset($_SESSION['car_type']);
		if(isset($_SESSION['svars_details']))    unset($_SESSION['svars_details']);
	    $_SESSION['sv_checkindate']   = $this->checkInDate;
		$_SESSION['sv_checkoutdate']  = $this->checkOutDate;
		$_SESSION['sv_checkintime']   = $this->checkInTime;
		$_SESSION['sv_checkouttime']  = $this->checkOutTime;
		$_SESSION['sv_strtotimeCheckInDate']   = $this->strtotimeCheckInDate;
		$_SESSION['sv_strtotimeCheckOutDate']  = $this->strtotimeCheckOutDate;
		$_SESSION['sv_mcheckindate']  = $this->mysqlCheckInDate;
		$_SESSION['sv_mcheckoutdate'] = $this->mysqlCheckOutDate;
		$_SESSION['sv_nightcount']    = $this->nightCount;	
		$_SESSION['sv_hourcount']    = $this->hourCount;	
		$_SESSION['sv_tillequal']    = $this->tillequal;
		$_SESSION['car_type']         = $this->type;	
		$_SESSION['svars_details']    = array();
	}

	
	private function invalidRequest(){
		header('Location: booking-failure.php?error_code=9');
		die;
	}

	private function getNightCount() {		
		$mins = ($this->strtotimeCheckOutDate - $this->strtotimeCheckInDate) / 60;
		$this->nightCount = ceil($mins/1440);
		$this->hourCount = $mins/60;
		if($mins%1440)
		$this->tillequal= "&asymp;";
		else
		$this->tillequal= "=";
	}


	private function getDateRangeArray($startDate, $endDate, $nightAdjustment = true) {	
		$date_arr = array(); 
		$day_array=array(); 
		$total_array=array();
	    $time_from = mktime(1,0,0,substr($startDate,5,2), substr($startDate,8,2),substr($startDate,0,4));
		$time_to = mktime(1,0,0,substr($endDate,5,2), substr($endDate,8,2),substr($endDate,0,4));		
		if ($time_to >= $time_from) { 
			if($nightAdjustment){
				while ($time_from < $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, date('D',$time_from));
					$time_from+= 86400; // add 24 hours
				}
			}else{
				while($time_from <= $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, $time_from);
					$time_from+= 86400; // add 24 hours
				}
			}			
		}  
		array_push($total_array, $date_arr);
		array_push($total_array, $day_array);
		return $total_array;		
	}


	private function checkSearchEngine(){
		global $bsiCore;
		if(intval($bsiCore->config['conf_booking_turn_off']) > 0){
			$this->searchCode = "SEARCH_ENGINE_TURN_OFF";
			return 0;
		}

		$diffrow  = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DATEDIFF('".$this->mysqlCheckOutDate."', '".$this->mysqlCheckInDate."') AS INOUTDIFF"));
		$dateDiff = intval($diffrow['INOUTDIFF']);
		if($dateDiff < 0){
			$this->searchCode = "OUT_BEFORE_IN";
			return 0;
		}else if($dateDiff < intval($bsiCore->config['conf_min_night_booking'])){
			$this->searchCode = "NOT_MINNIMUM_NIGHT";
			return 0;
		}

		$userInputDate = strtotime($this->mysqlCheckInDate);
		$hotelDateTime = strtotime(date("Y-m-d"));
		$timezonediff =  ($userInputDate - $hotelDateTime);
		if($timezonediff < 0){
			$this->searchCode = "TIME_ZONE_MISMATCH";
			return 0;
		}		
	}
		
	public function getAvailableCar(){
		global $bsiCore;		
		$currency_symbol = $bsiCore->config['conf_currency_symbol'];		
	
		$room_count         = 0;
		$total_price_amount = 0;
		
		$addquery = '';
				
		if($this->type != ""){
			$addquery .= '  bcm.car_type_id='.$this->type.' and  ';
		}else{
			$addquery .= '';
		}
		
		
		
		$searchsql="select * from (select bcm.*, IFNULL(t1.booked_cars,0) as booked_cars from bsi_car_master bcm LEFT JOIN (select brd.car_id, count(*) as booked_cars from bsi_res_data brd, bsi_bookings bb WHERE brd.booking_id=bb.booking_id and bb.is_deleted = FALSE AND (('".$this->mysqlCheckInDate." ".$this->checkInTime."' BETWEEN pickup_datetime AND ADDTIME(dropoff_datetime, '".$bsiCore->config['conf_interval_between_rent']."')) 
		OR 
		('".$this->mysqlCheckOutDate." ".$this->checkOutTime."' BETWEEN pickup_datetime AND ADDTIME(dropoff_datetime, '".$bsiCore->config['conf_interval_between_rent']."')) 
		OR 
		(pickup_datetime BETWEEN '".$this->mysqlCheckInDate." ".$this->checkInTime."' AND '".$this->mysqlCheckOutDate." ".$this->checkOutTime."')
		OR 
		(ADDTIME(dropoff_datetime, '".$bsiCore->config['conf_interval_between_rent']."') BETWEEN '".$this->mysqlCheckInDate." ".$this->checkInTime."' AND '".$this->mysqlCheckOutDate." ".$this->checkOutTime."')) group by brd.car_id) as t1  on bcm.car_id=t1.car_id ) as p1 where total_car > booked_cars  order by price_per_day";
		//echo $searchsql;
		//die;				   
		$sql = mysqli_query($GLOBALS["___mysqli_ston"], $searchsql);
		$tmpctr = 0;
		while($currentrow = mysqli_fetch_assoc($sql)){ 
			$searchresult[$currentrow['car_id']] = array('cardetails'=>$currentrow);
			$tmpctr++;
		}
		((mysqli_free_result($sql) || (is_object($sql) && (get_class($sql) == "mysqli_result"))) ? true : false);
		if($tmpctr > 0) $_SESSION['svars_details']= $searchresult;
		unset($searchresult);
		
		return array('roomcnt' => $tmpctr); 
		
	}
	
}
?>