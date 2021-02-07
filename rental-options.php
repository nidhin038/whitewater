<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: booking-failure.php?error_code=9');
}
$result3 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_extras");
if(!mysqli_num_rows($result3))
header("location: booking-details.php");

$carid = $_POST['car'];
$_SESSION['carid12'] = $carid;


$carHtml="";
$subtotaldeposit=0;
foreach ($carid as $value) {
$carArr = $_SESSION['svars_details'];	
$carArr = $carArr[$value];
//$_SESSION['svars_details'] = $carArr;
$car_price_array=$_SESSION['car_price_array'];


/*$priceperday  = $carArr['cardetails']['price_per_day'];
$priceperhour  = $carArr['cardetails']['price_per_hour'];

if($bsiCore->config['conf_price_calculation_type']==1){
	
	$totalPrice   = $priceperday*$_SESSION['sv_nightcount'];
	$totalDeposit = ($totalPrice*$_SESSION['depositPercent']/100);
	
}elseif($bsiCore->config['conf_price_calculation_type']==2){
	
	$totalPrice   = $priceperhour*$_SESSION['sv_hourcount'];
	$totalDeposit = ($totalPrice*$_SESSION['depositPercent']/100);
	
}elseif($bsiCore->config['conf_price_calculation_type']==3){
	$combined=$bsiCore->day_hour($_SESSION['sv_hourcount']);
	$totalPrice   = ($priceperhour*$combined['hour'])+($priceperday*$combined['day']);
	$totalDeposit = ($totalPrice*$_SESSION['depositPercent']/100);
}*/
$carHtml.='<tr>
        <td align="left"><strong>'.$bsiCore->getCarType($carArr['cardetails']['car_type_id']).'</strong><br />
          <span style="display:inline-block">'.$bsiCore->getCarVendor($carArr['cardetails']['car_vendor_id']).' '.$carArr['cardetails']['car_model'].'</span></td>
        <td align="right">'.$bsiCore->config['conf_currency_symbol'].number_format($car_price_array[$carArr['cardetails']['car_id']], 2).' '.$bsiCore->config['conf_currency_code'].'</td>
        <td width="250"></td>
      </tr>';		
$subtotaldeposit+=$car_price_array[$carArr['cardetails']['car_id']] * $_SESSION['depositPercent']/100;	  
		
}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $bsiCore->config['conf_portal_name'];?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
</head>

<body>
<div id="content" align="center">
  <h1><?php echo $bsiCore->config['conf_portal_name'];?></h1>
  <div id="wrapper" style="width:600px !important;" >
    <h3 align="left" style="padding-left:5px;"><?php echo SELECTED_CAR_TEXT;?> (
      <?php echo $_SESSION['sv_checkindate'];?>
      <?php echo date('g:i A',$_SESSION['sv_strtotimeCheckInDate']);?>
      -
      <?php echo $_SESSION['sv_checkoutdate'];?>
      <?php echo date('g:i A',$_SESSION['sv_strtotimeCheckOutDate']);?>
      
      <?php echo $_SESSION['textshowduration'];?>
      )</h3>
    <hr color="#e1dada"  style="margin-top:3px;"/>
   
    <table cellpadding="4" cellspacing="0" border="0" width="100%" align="left" id="getCarextras">
    <?php echo $carHtml;?>
      <tr>
        <td colspan="2"><hr color="#aaa"  tyle="height:1px !important;"/></td>
        <td width="250"></td>
      </tr>
      <tr>
        <td align="left"><?php echo AMOUNTPREPAID_TEXT;?> (<?php echo $_SESSION['depositPercent'];?>%)</td>
        <td align="right"><?php echo $bsiCore->config['conf_currency_symbol'].number_format($subtotaldeposit, 2)." ".$bsiCore->config['conf_currency_code'];?></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
    </table>
    <h3 align="left" style="padding-left:5px;"><?php echo RENTAL_OPTIONS_TEXT;?></h3>
    <hr color="#e1dada"  style="margin-top:3px;"/>
    <img src="images/Car-GPS.png" align="right" width="200" style="padding-right:10px; padding-top:10px;" />
    <form name="form1" id="form1" method="post" action="booking-details.php">
      <table cellpadding="4" cellspacing="0" border="0" width="64%" align="left">
        <?php echo $bsiCore->generateCarExtras();?>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><button id="btn_room_search" type="submit" ><?php echo CONTINU_TEXT;?>..</button></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table>
    </form>
  </div>
</div>
</body>
</html>