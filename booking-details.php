<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: booking-failure.php?error_code=9');
}
include("includes/details.class.php");
$bsiBooking = new bsiBookingDetails();
$bsiBooking->generateBookingDetails();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php echo $bsiCore->config['conf_portal_name'];?>
</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();
    });        
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#btn_exisitng_cust').click(function() {
	    $('#exist_wait').html("<img src='images/ajax-loader.gif' border='0'>")
		var querystr = 'actioncode=1&existing_email='+$('#email_addr_existing').val();
		$.post("ajax_processor.php", querystr, function(data){ 						 
			if(data.errorcode == 0){
				$('#title').html(data.title)
				$('#fname').val(data.first_name)
				$('#lname').val(data.surname)
				$('#str_addr').val(data.street_addr)
				$('#city').val(data.city)
				$('#state').val(data.province)
				$('#zipcode').val(data.zip)
				$('#country').val(data.country)
				$('#phone').val(data.phone)
				$('#fax').val(data.fax)
				$('#email').val(data.email)
				$('#exist_wait').html("")
			}else { 
				alert(data.strmsg);
				$('#fname').val('')
				$('#lname').val('')
				$('#str_addr').val('')
				$('#city').val('')
				$('#state').val('')
				$('#zipcode').val('')
				$('#country').val('')
				$('#phone').val('')
				$('#fax').val('')
				$('#email').val('')
				$('#exist_wait').html("")
			}	
		}, "json");
	});
});
function myPopup2(){
		var width = 730;
		var height = 650;
		var left = (screen.width - width)/2;
		var top = (screen.height - height)/2;
		var url='terms-and-services.php';
		var params = 'width='+width+', height='+height;
		params += ', top='+top+', left='+left;
		params += ', directories=no';
		params += ', location=no';
		params += ', menubar=no';
		params += ', resizable=no';
		params += ', scrollbars=yes';
		params += ', status=no';
		params += ', toolbar=no';
		newwin=window.open(url,'Chat', params);
		if (window.focus) {newwin.focus()}
		return false;
}
</script>
</head>
<body>
<div id="content" align="center">
  <h1>
    <?php echo $bsiCore->config['conf_portal_name'];?>
  </h1>
  <div id="wrapper" style="width:600px !important;">
    <h2 align="left" style="padding-left:5px;"><?php echo RENTAL_DETAILS_TEXT;?></h2>
    <hr color="#e1dada"  style="margin-top:3px;"/>
    <table cellpadding="4" cellspacing="1" border="0" width="100%" bgcolor="#FFFFFF" style="font-size:13px;">
      <tr>
        <td bgcolor="#f2f2f2" align="left" colspan="2"><strong><?php echo PICKUP_LOCATION;?></strong></td>
        <td bgcolor="#f2f2f2" align="left" colspan="2"><strong><?php echo DROPOFF_LOCATION;?></strong></td>
      </tr>
      <tr>
        <td bgcolor="#ffffff" align="left" colspan="2"><?php echo $bsiCore->getlocname($_SESSION['sv_pickup']);?></td>
        <td bgcolor="#ffffff" align="left" colspan="2"><?php echo $bsiCore->getlocname($_SESSION['sv_dropoff']);?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2" align="left" colspan="1"><strong><?php echo PICKUP_DATE_TEXT;?> &amp; <?php echo TIME_TEXT;?></strong></td>
        <td bgcolor="#f2f2f2" align="left" colspan="1"><strong><?php echo DROPOFF_DATE;?> &amp; <?php echo TIME_TEXT;?></strong></td>
        <td bgcolor="#f2f2f2" align="left" colspan="2"></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" align="left" colspan="1"><?php echo $_SESSION['sv_checkindate'];?>
          &nbsp;&nbsp;
          <?php echo date('g:i A', $bsiBooking->strtotimeCheckInDate);?></td>
        <td bgcolor="#FFFFFF" align="left" colspan="1"><?=$_SESSION['sv_checkoutdate']?>
          &nbsp;&nbsp;
          <?php echo date('g:i A',$bsiBooking->strtotimeCheckOutDate);?></td>
        <td bgcolor="#FFFFFF" align="center" colspan="2"><strong><?php echo $_SESSION['textshowduration'];?></strong></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2" align="left"><strong><?php echo CARTYPE_TEXT;?></strong></td>
        <td bgcolor="#f2f2f2" align="left"><strong><?php echo CAR_VENDOR_TEXT;?></strong></td>
        <td bgcolor="#f2f2f2" align="left"><strong><?php echo CAR_MODEL_TEXT;?></strong></td>
        <td bgcolor="#f2f2f2" align="right" style="padding-right:5px;"><strong><?php echo GROSS_TOTAL_TEXT;?></strong></td>
      </tr>
      <?php
	  foreach ($bsiBooking->carid12 as $value) {
	  ?>
      <tr>
        <td bgcolor="#FFFFFF" align="left"><?php echo $bsiCore->getCarType($bsiBooking->bookingDetails[$value]['cardetails']['car_type_id']);?></td>
        <td bgcolor="#FFFFFF" align="left"><?php echo $bsiCore->getCarVendor($bsiBooking->bookingDetails[$value]['cardetails']['car_vendor_id']);?></td>
        <td bgcolor="#FFFFFF" align="left"><?php echo $bsiBooking->bookingDetails[$value]['cardetails']['car_model'];?></td>
        <td bgcolor="#FFFFFF" align="right" style="padding-right:5px;"><?php echo $bsiCore->config['conf_currency_symbol'].number_format($bsiBooking->carPrices['grosstotal'][$value], 2);?></td>
      </tr> 
      <?php
	  }
	  
	  if(!empty($bsiBooking->listExtraService)){
		  echo '<tr>
				    <td bgcolor="#f2f2f2" align="left" colspan="4"><strong>'.RENTAL_OPTIONS_TEXT.'</strong></td>
			    </tr>';
		  $i=1;
			foreach($bsiBooking->listExtraService as $value){ 
				//$row = mysql_fetch_assoc(mysql_query("select * from bsi_car_extras where id=".$value));
				
					echo '<tr >
							<td bgcolor="#FFFFFF" align="left" colspan="3">'.$value['description'].' ( '.$bsiCore->config['conf_currency_symbol'].number_format($value['price'], 2).' x '.$_SESSION['sv_nightcount']. DAYS_TEXT.' )</td>
							<td bgcolor="#FFFFFF" align="right" style="padding-right:5px;">'.$bsiCore->config['conf_currency_symbol'].number_format($value['totalprice'], 2).'</td>
						  </tr>';	
			
					 
			}	
	  }
	  ?>
      <tr>
        <td bgcolor="#f2f2f2" align="right" colspan="3"><strong><?php echo SUB_TOTAL_TEXT;?></strong></td>
        <td bgcolor="#f2f2f2" align="right" style="padding-right:5px;"><strong>
          <?php echo $bsiCore->config['conf_currency_symbol'].$bsiBooking->carPrices['subtotal'];?>
          </strong></td>
      </tr>
      <?php if($bsiBooking->carPrices['discountPercent'] > 0 && $bsiBooking->carPrices['discountPercent'] < 100){?>
      <tr>
        <td bgcolor="#f2f2f2" align="right" colspan="3" style="color:#F00;"><strong><?php echo FLAT_DISCOUNT_TEXT;?> (<?php echo $bsiBooking->carPrices['discountPercent'];?>%)</strong></td>
        <td bgcolor="#f2f2f2" align="right" style="padding-right:5px; color:#F00;"><strong>-
          <?php echo $bsiCore->config['conf_currency_symbol'].$bsiBooking->carPrices['discountCalculated'];?>
          </strong></td>
      </tr>
      <?php } ?>
      <?php
	  if($bsiCore->config['conf_tax_amount'] > 0){
		?>
      <tr>
        <td bgcolor="#FFFFFF" align="right" colspan="3"><strong><?php echo TAX;?> &amp; <?php echo FEES;?>(
          <?php echo number_format($bsiCore->config['conf_tax_amount'], 2);?>%)</strong></td>
        <td bgcolor="#FFFFFF" align="right" style="padding-right:5px;"><?php echo $bsiCore->config['conf_currency_symbol'].$bsiBooking->carPrices['totaltax'];?></td>
      </tr>
      <?php  
	  }
	  ?>
      <tr>
        <td bgcolor="#f2f2f2" align="right" colspan="3"><strong><?php echo GRAND_TOTAL_TEXT;?></strong></td>
        <td bgcolor="#f2f2f2" align="right" style="padding-right:5px;"><strong>
          <?php echo $bsiCore->config['conf_currency_symbol'].$bsiBooking->carPrices['grandtotal'];?>
          </strong></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" align="right" colspan="3"><strong><?php echo PREPAID_AMOUNT_TEXT;?>(
          <?php echo $bsiBooking->carPrices['advancepercentage'];?>%)</strong></td>
        <td bgcolor="#FFFFFF" align="right" style="padding-right:5px;"><strong>
          <?php echo $bsiCore->config['conf_currency_symbol'].$bsiBooking->carPrices['advanceamount'];?>
          </strong></td>
      </tr>
    </table>
  </div>
  <br />
  <br />
  <div id="wrapper" style="width:600px !important;">
    <h2 align="left" style="padding-left:5px;"><?php echo CUSTOMER_DETAILS_TEXT;?></h2>
    <hr color="#e1dada"  style="margin-top:3px;"/>
    <br />
    <h3 align="left" style="padding-left:5px;  color:#999;"><?php echo EXISTING_CUSTOMER_TEXT;?>?</h3>
    <table cellpadding="4" cellspacing="0" align="left" style="text-align:left;">
      <tr>
        <td width="160px"><strong><?php echo EMAIL_ADDRESS_TEXT;?>:</strong></td>
        <td><input type="text" name="email_addr_existing" id="email_addr_existing"   /></td>
      </tr>
      <tr>
        <td></td>
        <td><button id="btn_exisitng_cust" type="submit" style="float:left;"><?php echo FETCH_DETAILS;?></button></td>
      </tr>
      <tr>
        <td id="exist_wait" ></td>
      </tr>
    </table>
    <br />
    <br />
    <br />
    <br />
    <h1 align="left"><?php echo OR_TEXT;?></h1>
    <h3 align="left" style="padding-left:5px; color:#999;"><?php echo NEW_CUSTOMER;?>?</h3>
    <form method="post" action="booking-process.php" id="form1" class="signupform">
      <input type="hidden" name="allowlang" id="allowlang" value="no" />
      <table cellpadding="4" cellspacing="0" width="100%" border="0" style="text-align:left;">
        <tr>
          <td width="120px"><strong><?php echo TITLE;?>:</strong></td>
          <td id="title"><select name="title" class="textbox3" style="width:60px;">
              <option value="Mr."><?php echo MR;?>.</option>
              <option value="Ms."><?php echo MS;?>.</option>
              <option value="Mrs."><?php echo MRS;?>.</option>
              <option value="Miss."><?php echo MISS;?>.</option>
              <option value="Dr."><?php echo DR;?>.</option>
              <option value="Prof."><?php echo PROF;?>.</option>
            </select></td>
        </tr>
        <tr>
          <td><strong><?php echo FIRST_NAME_TEXT;?>:</strong></td>
          <td><input type="text" name="fname" id="fname"  class="required" /></td>
        </tr>
        <tr>
          <td><strong><?php echo LAST_NAME_TEXT;?>:</strong></td>
          <td><input type="text" name="lname" id="lname"  class="required" /></td>
        </tr>
        <tr>
          <td><strong><?php echo ADDRESS_TEXT;?>:</strong></td>
          <td><input type="text" name="str_addr" id="str_addr"  class="required" /></td>
        </tr>
        <tr>
          <td><strong><?php echo CITY_TEXT;?>:</strong></td>
          <td><input type="text" name="city"  id="city" class="required" /></td>
        </tr>
        <tr>
          <td><strong><?php echo STATE_TEXT;?>:</strong></td>
          <td><input type="text" name="state"  id="state" class="required" /></td>
        </tr>
        <tr>
          <td><strong><?php echo POSTAL_CODE_TEXT;?>:</strong></td>
          <td><input type="text" name="zipcode"  id="zipcode" class="required" /></td>
        </tr>
        <tr>
          <td><strong><?php echo COUNTRY_TEXT;?>:</strong></td>
          <td><input type="text" name="country"  id="country" class="required" /></td>
        </tr>
        <tr>
          <td><strong><?php echo PHONE_TEXT;?>:</strong></td>
          <td><input type="text" name="phone"  id="phone" class="required" /></td>
        </tr>
        <tr>
          <td><strong><?php echo FAX_TEXT;?>:</strong></td>
          <td><input type="text" name="fax"  id="fax" /></td>
        </tr>
        <tr>
          <td><strong><?php echo EMAIL_TEXT;?>:</strong></td>
          <td><input type="text" name="email"  id="email" class="required email" /></td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo PAYMENT_BY;?>:</strong></td>
          <td><?php
				$paymentGatewayDetails = $bsiCore->loadPaymentGateways();				
				foreach($paymentGatewayDetails as $key => $value){ 	
					echo '<input type="radio" name="payment_type" id="payment_type_'.$key.'" value="'.$key.'" class="required" />'.$value['name'].'<br />';
				}
				?>
            <label class="error" generated="true" for="payment_type" style="display:none;"><?php echo FIELD_REQUIRED_TEXT;?>.</label></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="checkbox" name="tos" id="tos" value="" style="width:15px !important"  class="required"/>
            &nbsp;
            <?php echo I_AGREE_WITH_THE_TEXT;?> <a href="javascript: ;" onclick="javascript:myPopup2();"> <?php echo TERMS_AND_CONDITIONS;?>.</a></td>
        </tr>
        <tr>
          <td height="50"></td>
          <td><button id="registerButton" type="submit" style="float:left;"><?php echo CONFIRM;?> &amp; <?php echo CHECKOUT;?></button></td>
        </tr>
      </table>
    </form>
  </div>
</div>
</body>
</html>