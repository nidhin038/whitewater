<?php
$bsiCore = new bsiCarCore;

class bsiCarCore{
	public $config = array();
	public $userDateFormat = "";		
	
	function __construct(){		
		$this->getBSIConfig();
		$this->getUserDateFormat();		
	}	
	
	private function getBSIConfig(){
		$sql = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT conf_id, IFNULL(conf_key, false) AS conf_key, IFNULL(conf_value,false) AS conf_value FROM bsi_configure");
		while($currentRow = mysqli_fetch_assoc($sql)){
			if($currentRow["conf_key"]){
				if($currentRow["conf_value"]){
					$this->config[trim($currentRow["conf_key"])] = trim($currentRow["conf_value"]);
				}else{
					$this->config[trim($currentRow["conf_key"])] = false;
				}
			}
		}
		((mysqli_free_result($sql) || (is_object($sql) && (get_class($sql) == "mysqli_result"))) ? true : false);	
	}
	
	private function getUserDateFormat(){		
		$dtformatter = array('dd'=>'%d', 'mm'=>'%m', 'yyyy'=>'%Y', 'yy'=>'%Y');		
		$dtformat = preg_split("@[/.-]@", $this->config['conf_dateformat']);
		$dtseparator = ($dtformat[0] === 'yyyy')? substr($this->config['conf_dateformat'], 4, 1) : substr($this->config['conf_dateformat'], 2, 1);
		$this->userDateFormat = $dtformatter[$dtformat[0]].$dtseparator.$dtformatter[$dtformat[1]].$dtseparator.$dtformatter[$dtformat[2]];	
	}	
	
	public function getMySqlDate($date){
		if($date == "") return "";
		$dateformatter = preg_split("@[/.-]@", $this->config['conf_dateformat']);
		$date_part = preg_split("@[/.-]@", $date);		
		$date_array = array();		
		for($i=0; $i<3; $i++) {
			$date_array[$dateformatter[$i]] = $date_part[$i];
		}
		return $date_array['yy']."-".$date_array['mm']."-".$date_array['dd'];
	}	
	
	public function ClearInput($dirty){
         $dirty = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $dirty);
         return $dirty;
    }
	
	public function getCartypeCombo($cartypeid=0){
		$cartypehtml='<select name="car_type" id="car_type"><option value="0">---'.ADD_EDIT_CAR_SELECT.'---</option>';
		$getcartype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_type");
		while($carrow=mysqli_fetch_assoc($getcartype)){
			if($carrow['id'] == $cartypeid){
				$cartypehtml.='<option value="'.$carrow['id'].'" selected="selected">'.$carrow['type_title'].'</option>';
				
			}else{
				
				$cartypehtml.='<option value="'.$carrow['id'].'">'.$carrow['type_title'].'</option>';
			}
		}
		$cartypehtml.='</select>';
		return $cartypehtml;
	 }
	 
	 public function getCarvendorCombo($carvendorid=0){
		$carvendorhtml='<select name="car_vendor" id="car_vendor"><option value="0">---'.ADD_EDIT_SELECT.'---</option>';
		$getcarvendor=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_vendor");
		while($carrow=mysqli_fetch_assoc($getcarvendor)){
			if($carrow['id'] == $carvendorid){
				$carvendorhtml.='<option value="'.$carrow['id'].'" selected="selected">'.$carrow['vendor_title'].'</option>';
				
			}else{
				
				$carvendorhtml.='<option value="'.$carrow['id'].'">'.$carrow['vendor_title'].'</option>';
			}
		}
		$carvendorhtml.='</select>';
		return $carvendorhtml;
	 }
	 
	 public function getAllDepositDurationRow(){
		global $bsiCore;
		  $depositlist='';
		 $resultqry=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_deposit_duration");
		 if(mysqli_num_rows($resultqry)){ 
		 while($row = mysqli_fetch_assoc($resultqry)){
			 $depositlist.='<tr><td>'.$row['day_from'].' days</td><td>'.$row['day_to'].' days</td><td>'.$row['deposit_percent'].'%</td><td align="right"><a href="add_edit_deposit_duration.php?depoid='.$row['id'].'">'.DEPOSIT_DURATION_EDIT.'</a> || <a href="deposit-duration.php?delid='.$row['id'].'">'.DEPOSIT_DURATION_DELETE.'</a></td></tr>';
			 
			 
		 }
		 }
		 return  $depositlist;
	}
	
	 public function getAllDiscountDurationRow(){
		global $bsiCore;
		  $discountlist='';
		 $resultqry=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_discount_duration");
		 if(mysqli_num_rows($resultqry)){ 
		 while($row = mysqli_fetch_assoc($resultqry)){
			 $discountlist.='<tr><td>'.$row['day_from'].' days</td><td>'.$row['day_to'].' days</td><td>'.$row['discount_percent'].'%</td><td align="right"><a href="add_edit_discount_duration.php?disco_id='.$row['id'].'">'.DISCOUNT_EDIT.'</a> || <a href="discount-duration.php?delid='.$row['id'].'">'.DISCOUNT_DELETE.'</a></td></tr>';
			 
			 
		 }
		 }
		 return  $discountlist;
	}
	
	public function getAllExtrasRow(){
		global $bsiCore;
		$carextralist='';
		$resultqry=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_extras");
		if(mysqli_num_rows($resultqry)){ 
			while($row = mysqli_fetch_assoc($resultqry)){
				$carextralist.='<tr><td>'.$row['car_extras'].'</td><td>'.$bsiCore->config['conf_currency_symbol']."".$row['price'].'</td><td align="right"><a href="add_edit_extras.php?extra_id='.$row['id'].'">'.CAR_EXTRAS_EDIT.'</a> || <a href="car-extras.php?delid='.$row['id'].'">'.CAR_EXTRAS_DELETE.'</a></td></tr>';
			}
		}
		return  $carextralist;
	}
	
	public function getCartypeCombobox(){
		$cartypehtml = '<select name="car_type" id="car_type" style="width:auto !important"><option value="">---- All Types ----</option>';
		$getcartype = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_type");
		while($carrow = mysqli_fetch_assoc($getcartype)){
			$cartypehtml .= '<option value="'.$carrow['id'].'">'.$carrow['type_title'].'</option>';
		}
		$cartypehtml.='</select>';
		return $cartypehtml;
	 }
	 
	 public function getCarMaster($id){
		 $row = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master where car_id=".$id));
		 return $row;
	 }
	 
	 public function getCarType($id){
		 $row = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select type_title from bsi_car_type where id=".$id));
		 return $row['type_title'];
	 }
	 
	 public function getCarVendor($id){
		 $row = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select vendor_title from bsi_car_vendor where id=".$id));
		 return $row['vendor_title'];
	 }
	 
	 public function getDepositpercent($day){
		 $result = mysqli_query($GLOBALS["___mysqli_ston"], "select deposit_percent from bsi_deposit_duration where ".$day." between day_from and day_to");
		 if(mysqli_num_rows($result)){
		 	$row = mysqli_fetch_assoc($result);
			return $row['deposit_percent'];
		 }else{
			return 100; 
		 }
		 
	 }
	 
	 public function getSelectedFeatures($id){
		
		$html = '<td valign="top" align="left" >				
         			<ul style="list-style:square; padding-left:0px;">';
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "select bcf.features_title from bsi_selected_features as bsf, bsi_car_features as bcf where bsf.car_id=".$id." and bcf.id=bsf.features_id");
		$num = mysqli_num_rows($result);
		$loop = floor($num/2);
		if($num%2 == 0){
			$loop = $loop;		
		}else{
			$loop = $loop+1;	
		}
		if($num){
			$i = 0;
			while($row = mysqli_fetch_assoc($result)){
				$html .= '<li>'.$row['features_title'].'</li>';
				$i++;
				if($loop == $i){
					$html .= '</ul>
						</td>
						<td valign="top">
							<ul style="list-style:square; padding-left:0px;">';	
					$i = 0;
				}
			}
			$html .= '</ul>
						</td>';
		}
		return $html; 
	 }
	 
	 public function generateCarExtras(){
		$html = '';
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_extras");
		if(mysqli_num_rows($result)){
			while($row = mysqli_fetch_assoc($result)){ 
				$html .= '<tr>
							
							<td align="left"><strong>'.$row['car_extras'].'</strong></td>
							<td align="right"> '.$this->config['conf_currency_symbol'].number_format($row['price'], 2)."</td><td align='left'> ".$this->config['conf_currency_code'].' '.RENTAL_PER_DAY.' </td><td><strong> </strong></td>
							<td  align="left">
							<select name="carExtras['.$row['id'].']" style="width:auto;"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>
							
							</td>
						  </tr>';
			}
		}
		return $html;
	 }
	 
	 public function loadPaymentGateways() {			
		$paymentGateways = array();
		$sql = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM bsi_payment_gateway where enabled=true");
		while($currentRow = mysqli_fetch_assoc($sql)){	
			$paymentGateways[$currentRow["gateway_code"]] = array('name'=>$currentRow["gateway_name"], 'account'=>$currentRow["account"]);	 
		}
		((mysqli_free_result($sql) || (is_object($sql) && (get_class($sql) == "mysqli_result"))) ? true : false);
		return $paymentGateways;
	}
	
	public function clearExpiredBookings(){		
		$sql = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT booking_id FROM bsi_bookings WHERE payment_success = false AND ((NOW() - booking_time) > ".intval($this->config['conf_booking_exptime'])." )");
		while($currentRow = mysqli_fetch_assoc($sql)){			
			mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM bsi_invoice WHERE booking_id = '".$currentRow["booking_id"]."'");	
			mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM bsi_bookings WHERE booking_id = '".$currentRow["booking_id"]."'");			
		}
		((mysqli_free_result($sql) || (is_object($sql) && (get_class($sql) == "mysqli_result"))) ? true : false);

	}
	
	public function day_hour($hours){
		$combined=array();
		$combined['day']=floor($hours/24);
		$combined['hour']=($hours -(24*$combined['day']));
		return $combined;
	}
	
	public function paymentGatewayName($gcode){
		$row=mysqli_fetch_row(mysqli_query($GLOBALS["___mysqli_ston"], "select gateway_name from bsi_payment_gateway where gateway_code='".$gcode."'"));
		return $row[0];
	}
	

	
	public function getDroppickLocation(){
		$selectDropoff='';
		$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_all_location order by location_title");
		while($row=mysqli_fetch_assoc($sql)){
			$selectDropoff.='<option value="'.$row['loc_id'].'" >'.$row['location_title'].'</option>';
		}
		return $selectDropoff;
	}
	
	public function getcloseDate(){
		
		$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_close_date");
		$daterange="";
		while($row=mysqli_fetch_assoc($sql)){
			$daterange.="'".$row['closedt']."',";
		}
		$daterange=substr($daterange, 0, -1);
		return $daterange;
	}
	
	public function getlocname($loc_id){		
		$row=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_all_location where loc_id=".$loc_id));		
		return $row['location_title'];
	}
}
?>