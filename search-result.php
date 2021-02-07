<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/search.class.php");
include("language.php");
$bsiSearch = new bsiSearch();
$bsiCore->clearExpiredBookings();
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if($bsiSearch->nightCount==0 and !$pos2){
	header('Location: booking-failure.php?error_code=9');
}

$availarr = $bsiSearch->getAvailableCar();
$carArr   = $_SESSION['svars_details'];
$depositPercent = number_format($bsiCore->getDepositpercent($bsiSearch->nightCount));
$_SESSION['depositPercent'] = $depositPercent;

if($bsiCore->config['conf_price_calculation_type']==1){
	
	$textshowduration=$bsiSearch->tillequal.' '.$bsiSearch->nightCount.' '.SEARCH_DAYS;
	
}elseif($bsiCore->config['conf_price_calculation_type']==2){
	$textshowduration= ' = '.$bsiSearch->hourCount.' '.SEARCH_HOURS;
	
	
}elseif($bsiCore->config['conf_price_calculation_type']==3){
	$combined=$bsiCore->day_hour($bsiSearch->hourCount);
	$textshowduration=' = '.$combined['day'].' '.SEARCH_DAYS.' '.$combined['hour'].' '.SEARCH_HOURS;
	
}
$_SESSION['textshowduration']=$textshowduration;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> <?php echo $bsiCore->config['conf_portal_name'];?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link type="text/css" href="css/accordion.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script> 
 $(function() {
	// Content Box Accordion Config		
	$( ".content_accordion" ).accordion({
		collapsible: true,
		active:false,
		header: 'span.bar', // this is the element that will be clicked to activate the accordion 
		autoHeight:false,
		icons:false,
		animated: true
	});
	
  $(".content_accordion input").click(function(e) {
        e.stopPropagation();
    }); 
});
</script>
</head>
<body>

<div id="content" align="center"> 
  <h1>  <?php echo $bsiCore->config['conf_portal_name'];?> </h1>
  <div id="wrapper" style="width:600px !important;" > 
    <h2 align="left" style="padding-left:5px;"><?php echo SEARCH_RESULT_TEXT;?> </h2>
    <hr color="#e1dada"  style="margin-top:3px; margin-bottom:3px;"/>
    <h3 align="left" style="padding-left:5px;">
      <?php echo $bsiSearch->checkInDate;?>
      <?php echo date('g:i A',$bsiSearch->strtotimeCheckInDate);?>
      -
      <?php echo $bsiSearch->checkOutDate;?>
      <?php echo date('g:i A',$bsiSearch->strtotimeCheckOutDate);?>
      <span style="color:#63F"><?php echo $textshowduration;?></span>
      </h3>
        <hr color="#e1dada"  style="margin-top:3px;"/>
         
    <table cellpadding="5" border="0" width="100%" style="background:#936; color:#FFF">
      <tr style="height:30px;">
        <th align="left" width="34%" style="padding-left:10px;"><?php echo CAR_CLASS_OR_TYPE_TEXT;?> </th>
        <th  width="25%"><?php echo TOTAL_PRICE_TEXT;?></th>
        <th align="right"  width="31%" style="padding-right:10px;"><?php echo AMOUNT_PREPAID_TEXT;?>( <?php echo $depositPercent;?>% )</th>
        <th width="10%"></th>
      </tr>
    </table>
    <form action="rental-options.php" name="form1" id="form1" method="post" >
    <ul class="content_accordion">
      <?php
	  	$gotSearchResult = false;
		if($availarr['roomcnt'] > 0){
			$gotSearchResult = true;
		}
		
		if(abs($bsiSearch->nightCount) == 0){
			$gotSearchResult = false;	
		}
		$car_price_array=array();
		if($gotSearchResult){
			foreach($carArr as $key => $carVal){
				$price=0;
				
				//$priceperday  = $carVal['cardetails']['price_per_day'];
				//$priceperhour  = $carVal['cardetails']['price_per_hour'];
				if($bsiCore->config['conf_price_calculation_type']==1){
					
					$dayname=$bsiSearch->fullDateRange[1];
					foreach($bsiSearch->fullDateRange[0] as $key7 => $val){
						$res=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where ('".$val."' between start_date and end_date) and car_id='".$key."' and default_price='0' and price_type=1");
						if(mysqli_num_rows($res)){
							$row=mysqli_fetch_assoc($res);
							$price+=$row[strtolower($dayname[$key7])];
						}else{
							$row33=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where car_id='".$key."' and default_price='1' and price_type=1"));
							$price+=$row33[strtolower($dayname[$key7])];
						}
					}
					$totalPrice   = $price;
					$totalDeposit = ($totalPrice*$depositPercent/100);
					
				}elseif($bsiCore->config['conf_price_calculation_type']==2){
					
					$hourbyday=array();
					foreach($bsiSearch->fullDateRange[0] as $val){
						if($val == $bsiSearch->mysqlCheckInDate && $val != $bsiSearch->mysqlCheckOutDate){
							$hourbyday[$val]=((strtotime($bsiSearch->mysqlCheckInDate." 24:00:00") - $bsiSearch->strtotimeCheckInDate) / 60)/60;
							
						}elseif($val == $bsiSearch->mysqlCheckOutDate && $val != $bsiSearch->mysqlCheckInDate){
							$hourbyday[$val]=((strtotime($bsiSearch->mysqlCheckOutDate." ".$bsiSearch->checkOutTime) - strtotime($bsiSearch->mysqlCheckOutDate." 00:00:00")) / 60)/60;
						}elseif($val == $bsiSearch->mysqlCheckInDate && $val == $bsiSearch->mysqlCheckOutDate){
							$hourbyday[$val]=(($bsiSearch->strtotimeCheckOutDate - $bsiSearch->strtotimeCheckInDate) / 60)/60;
						}else{
							$hourbyday[$val]=24;
						}
						
					}
					
				
					foreach($hourbyday as $key1=>$value) {
						
						$res=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where ('".$key1."' between start_date and end_date) and car_id='".$key."' and default_price='0' and price_type=2" );
						
						if(mysqli_num_rows($res)){
							$row=mysqli_fetch_assoc($res);
							$price+=$row[strtolower(date('D', strtotime($key1)))]*$value;
						}else{
							$row33=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where car_id='".$key."' and default_price='1' and price_type=2"));
							//echo  "select * from bsi_car_priceplan where car_id='".$key."' and default_price='1'";
							$price+=$row33[strtolower(date('D', strtotime($key1)))]*$value;
						}
						
					}
					
					
					$totalPrice   = $price;
					$totalDeposit = ($totalPrice*$depositPercent/100);
					
				}elseif($bsiCore->config['conf_price_calculation_type']==3){
					
					$dayname=$bsiSearch->fullDateRange[1];
					$dtcount=count($bsiSearch->fullDateRange[0]);
					$combined=$bsiCore->day_hour($bsiSearch->hourCount);
					
					
					$i7=1;
					
					foreach($bsiSearch->fullDateRange[0] as $key2 => $val){
						$res1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where ('".$val."' between start_date and end_date) and car_id='".$key."' and default_price='0' and  price_type=1");
						$res2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where ('".$val."' between start_date and end_date) and car_id='".$key."' and default_price='0' and  price_type=2");
						if(mysqli_num_rows($res1)){
							 
							$row1=mysqli_fetch_assoc($res1);
							$row2=mysqli_fetch_assoc($res2);
							if($i7==$dtcount &&  $combined['hour'] != 0)
							$price+=$row1[strtolower($dayname[$key2])]*$combined['hour'];
							else
							$price+=$row2[strtolower($dayname[$key2])];
							
						}else{
							//echo "select * from bsi_car_priceplan where car_id='".$key."' and default_price='0'";
							$row33=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where car_id='".$key."' and default_price='1' and  price_type=1"));
							$row34=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where car_id='".$key."' and default_price='1' and  price_type=2"));
							if($i7==$dtcount &&  $combined['hour'] != 0)
							$price+=$row34[strtolower($dayname[$key2])]*$combined['hour'];
							else
							$price+=$row33[strtolower($dayname[$key2])];
						}
						
					$i7++;
					}
					
					
					$totalPrice   = $price;
					$totalDeposit = ($totalPrice*$depositPercent/100);
				}
				
				
				
				
				
	   ?>
      <li><span class="bar" title="<?php echo CLICK_HERE_TO_EXPAND_OR_COLLAPSE_TEXT;?> !!!">
        <table cellpadding="3"  cellspacing="3" border="0" width="100%">
          <tr>
            <td align="left" width="34%" style=" line-height:normal;"><strong>
              <?php echo $bsiCore->getCarType($carVal['cardetails']['car_type_id']);?>
              </strong><br />
              <?php echo $bsiCore->getCarVendor($carVal['cardetails']['car_vendor_id']);?>
              <span style="display:inline-block">
              <?php echo $carVal['cardetails']['car_model'];?>
              </span></td>
            <td  width="25%" align="center"><strong>
              <?php echo $bsiCore->config['conf_currency_symbol'].number_format($totalPrice, 2)." ".$bsiCore->config['conf_currency_code'];?>
              </strong></td>
            <td align="right"  width="31%"><strong>
              <?php echo $bsiCore->config['conf_currency_symbol']?><?=number_format($totalDeposit, 2)?> <?=$bsiCore->config['conf_currency_code'];?>
              </strong>&nbsp;&nbsp;
              </td>
              <td  width="10%" align="center">
              <input type="checkbox" value="<?php echo $carVal['cardetails']['car_id'];?>" name="car[]" class="required" style=" width:auto !important;"  />
              </td>
          </tr>
        </table>
        </span>
        <div class="content" align="left">
        <?php
		$mileagetxt=($carVal['cardetails']['mileage']=="")? UNLIMITED : $carVal['cardetails']['mileage']."km";
		?>
          <table cellpadding="3"  cellspacing="0" border="0" width="100%">
        
            <tr>            
              <?php if($carVal['cardetails']['car_img'] !=""){ ?>
              <td width="240" rowspan="2" valign="top">            
              <img src="gallery/thumb_<?=$carVal['cardetails']['car_img']?>" align="left" />              
              </td>
              <?php } ?>
              <td align="left"><strong><?php echo MILEAGE_TEXT;?>: <?php echo $mileagetxt;?></strong></td><td align="left"><strong><?php echo FUEL_TYPE_TEXT;?>: <?php echo $carVal['cardetails']['fuel_type'];?></strong></td>
              </tr>
              <tr>
              <?php echo $bsiCore->getSelectedFeatures($carVal['cardetails']['car_id']);?>
            </tr>
             
          </table>
          
        </div>
      </li>
     

      <?php
	  
	  $car_price_array[$carVal['cardetails']['car_id']]=$totalPrice;
	  
	 
	  
			}
			 $_SESSION['car_price_array']=$car_price_array;
		?>
         </ul>
       <label class="error" generated="true" for="car[]" style="display:none;"><?php echo SELECT_AT_LEAST_ONE_CAR;?>.</label><br />
    <button id="btn_room_search" type="submit" ><?php echo CONTINUE_TEXT;?>..</button>
    </form>
        <?php
		}else{
			echo '<table cellpadding="4" cellspacing="0" width="100%"><tbody><tr><td style="font-size:13px; color:#F00;" align="center"><br /><br />';
			if($bsiSearch->searchCode == "SEARCH_ENGINE_TURN_OFF"){
				echo SORRY_ONLINE_BOOKING_CURRENTLY_NOT_AVAILABLE_PLEASE_TRY_LATER;				
			}else if($bsiSearch->searchCode == "OUT_BEFORE_IN"){
				echo INVALID_SEARCHING_CRITERIA;				
			}else if($bsiSearch->searchCode == "NOT_MINNIMUM_NIGHT"){
				echo MINIMUM_NUMBER_OF_NIGHT_SHOULD_NOT_BE_LESS_THAN.' '.$bsiCore->config['conf_min_night_booking'].' '. PLEASE_MODIFY_YOUR_SEARCHIN_CRITERIA;
			}else if($bsiSearch->searchCode == "TIME_ZONE_MISMATCH"){
				$tempdate = date("l F j, Y G:i:s T");
				echo 'Booking not possible for check in date: '.$bsiSearch->checkInDate.'. '.PLEASE_MODIFY_YOUR_SEARCH_CRITERIA_ACCORDING_TO_HOTELS_DATE_TIME.' <br>'. HOTELS_CURRENT_DATE_TIME.' '.$tempdate; 
			}else if(abs($bsiSearch->nightCount) == 0){
				echo PICK_UP_DATE_AND_TIME_CANNOT_BE_LESS_THAN_FROM_DROP_OFF_DATE_AND_TIME_PLEASE_SELECT_CORRECT_PICKUP_DATE_TIME.'<br><br><button type="submit" style=" width:100px; font-size:14px;" onclick="window.location.href=\'index.php\'">'.BACK.'</button>';
			}else{
				echo NO_CAR_AVAILABLE_PLEASE_TRY_DIFFERENT_DATE;	
			}
			echo '<br /><br /><br /></td></tr></tbody></table>';
		}
	?>
    
   
    <br />
  </div> 
</div> 
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$().ready(function() {
		$("#form1").validate();
    });        
</script>
</body>
</html>