<?php 
include("access.php");
if(isset($_POST['act_sbmt'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->global_setting_post();
	header("location:global-setting.php");
	exit;
}
include("header.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
$global_setting = $bsiAdminMain->global_setting();	
?>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside"> <span style="font-size:16px; font-weight:bold"><?php echo GLOBAL_SETTING;?></span>
  <hr />
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
    <table cellpadding="5" cellspacing="2" border="0" width="100%">
      <tr>
        <td><strong><?php echo POSTAL_NAME;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $bsiCore->config['conf_portal_name'];?>" size="50" name="conf_portal_name" id="conf_portal_name"/></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_STREET_ADDRESS;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $bsiCore->config['conf_portal_streetaddr'];?>" size="50" name="conf_portal_streetaddr" id="conf_portal_streetaddr"/></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_CITY;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $bsiCore->config['conf_portal_city'];?>" size="30" name="conf_portal_city" id="conf_portal_city"/></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_STATE;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $bsiCore->config['conf_portal_state'];?>" size="30" name="conf_portal_state" id="conf_portal_state"/></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_COUNTRY;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $bsiCore->config['conf_portal_country'];?>" size="30" name="conf_portal_country" id="conf_portal_country"/></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_ZIP_AND_POST_CODE;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $bsiCore->config['conf_portal_zipcode'];?>" size="10" name="conf_portal_zipcode" id="conf_portal_zipcode"/></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_PHONE;?>:</strong></td>
        <td><input type="text"  class="required" value="<?php echo $bsiCore->config['conf_portal_phone'];?>" size="15" name="conf_portal_phone" id="conf_portal_phone"/></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_FAX;?>:</strong></td>
        <td><input type="text"  value="<?php echo $bsiCore->config['conf_portal_fax'];?>" size="15" name="conf_portal_fax" id="conf_portal_fax"/></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_PORTAL_EMAIL;?>:</strong></td>
        <td><input type="text" class="required email" value="<?php echo $bsiCore->config['conf_portal_email'];?>" size="30" name="conf_portal_email" id="email"/></td>
      </tr>
      <tr><td colspan="2"><hr /></td></tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_NOTIFICATION_EMAIL;?>:</strong></td>
        <td valign="middle"><input type="text" name="conf_notification_email" id="conf_notification_email" value="<?php echo $bsiCore->config['conf_notification_email'];?>" class="required email" style="width:250px;" /></td>
      </tr>
      
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_CURRENCY_CODE;?>:</strong></td>
        <td><input type="text" name="conf_currency_code" id="conf_currency_code" value="<?php echo $bsiCore->config['conf_currency_code'];?>"  class="required" style="width:70px;"  /></td>
      </tr>
      
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_CURRENCY_SYMBOL;?>:</strong></td>
        <td><input type="text" name="conf_currency_symbol" id="conf_currency_symbol" value="<?php echo $bsiCore->config['conf_currency_symbol'];?>"  class="required" style="width:70px;"  /></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_MEASUREMENT_UNIT;?>:</strong></td>
        <td><input type="text" name="conf_mesurment_unit" id="conf_mesurment_unit" value="<?php echo $bsiCore->config['conf_mesurment_unit'];?>"  class="required" style="width:70px;"  /></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_BOOKING_ENGINE;?>:</strong></td>
        <td><select name="select_booking_turn" id="select_booking_turn">
            <?php echo $global_setting['select_booking_turn'];?>
          </select></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_PORTAL_TIMEZONE;?>:</strong></td>
        <td><select name="conf_portal_timezone" id="conf_portal_timezone">
            <?php echo $global_setting['select_timezone'];?>
          </select></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_DATE_FORMAT;?></strong></td>
        <td><select name="conf_dateformat" id="conf_dateformat">
            <?php echo $global_setting['select_dt_format'];?>
          </select></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_CAR_BLOCK_TIME;?>:</strong></td>
        <td><select name="conf_booking_exptime" id="conf_booking_exptime">
            <?php echo $global_setting['select_room_lock'];?>
          </select>
          <span style="font-size:10px">&nbsp;&nbsp;<?php echo DURATION_FOR_CUSTOMER_SELECTED_CAR_WILL_BE_LOCK_WHEN_CHECKOUT_REDIRECT_TO_PAYMENT_GATEWAY;?></span></td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_TAXES_AND_FEES;?>:</strong></td>
        <td><input type="text" name="conf_tax_amount" id="conf_tax_amount" size="6" class="required number" value="<?php echo $bsiCore->config['conf_tax_amount'];?>" />
          &nbsp;%</td>
      </tr>
    
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_CAR_BLOCK_INTERVAL;?>:</strong></td>
        <td><select name="conf_interval_between_rent" id="conf_interval_between_rent">
            <?php echo $global_setting['select_blockinterval'];?>
          </select> <span style="font-size:10px">&nbsp;&nbsp;<?php echo DURATION_INTERVAL_BETWEEN_DROPOFF_AND_PICK_UP_OF_CAR;?></span>
          </td>
      </tr>
      <tr>
        <td><strong><?php echo GLOBAL_SETTING_PICK_UP_DATE_SET;?>:</strong></td>
        <td><select name="conf_booking_start" id="conf_booking_start">
            <?php echo $global_setting['select_conf_booking_start'];?>
          </select> <span style="font-size:10px">&nbsp;&nbsp;<?php echo EXAMPLE_SET_TWO_DAYS_SO_PICK_UP_DATE_DATE_WILL_BE_AFTER_TWO_DAYS_FROM_CURRENT_DATE;?></span>
          </td>
      </tr>
        <td><input type="hidden" name="act_sbmt" value="1" /></td>
        <td><input type="submit" value="<?php echo GLOBAL_SETTING_SUBMIT;?>" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>
      </tr>
    </table>
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#form1").validate();
     });  
</script> 
<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?>
