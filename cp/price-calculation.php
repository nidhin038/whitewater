<?php 
include("access.php");
if(isset($_POST['submitFeatures'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->priceCalculationSave();
	header("location:price-calculation.php");
}
include("header.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
$pp_setting = $bsiAdminMain->priceCalculation();	
?>      
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo PRICE_CALCULATION_SETUP_OF_CAR;?></span>
       
        <hr/>
           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
          <input type="hidden" name="features_id" value="<?php echo $_GET['fid'];?>"/>
            <tr>
              <td><strong><?php echo PRICE_CALCULATED_BY;?>:</strong></td>
              <td><select name="pp_setting"><?php echo $pp_setting;?></select></td>
            </tr>
            <tr><td></td><td><input type="submit" value="<?php echo SUBMIT_TEXT;?>" name="submitFeatures" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
            </table>
            </form><br /><br />
            <strong><?php echo IMPORTANT_NOTE_FOR_PRICE_SETUP;?>:</strong><br />
            <p><?php echo YOU_MUST_DEFINE_PRICE_OF_DAILY_AND_HOURLY_IN_CAR_ADD_AND_EDIT;?>. <br /><br />
           <strong><?php echo HOW_DIFFERENT_TYPE_OF_PRICE_SETUP_WORK;?>?</strong>
            </p>
            <p><strong><?php echo PRICE_CALCULATION_EXAMPLE;?></strong>:<br /><strong><?php echo PICK_UP_DATE_AND_TIME;?>:</strong> 21/08/2012 9:00 AM <br /> <strong><?php echo DROP_OFF_DATE_AND_TIME;?>:</strong> 23/08/2012 3:00 PM</p>
            <p><strong><?php echo PRICE_CALCULATION_DAILY;?></strong>: <?php echo PRICE_WILL_BE_CALCULATED_OF_THREE_DAYS_AND_APPLY_DAILY_PRICE;?>. </p>
            <p><strong><?php echo PRICE_CALCULATION_HOURLY;?></strong>: <?php echo PRICE_WILL_BE_CALCULATED_OF_HOURS_AND_THAT_APPLY_HOURLY_PRICE;?>. </p>
            <p><strong><?php echo DAILY_AND_HOURLY_COMBINED;?>.</strong>: <?php echo PRICE_WILL_BE_CALCULATED_OF_TWO_DAYS_SIX_HOURS_AND_THAT_APPLY_TWO_DAY_DAILY_PRICE;?>. </p>
            
            
        </div>
        <script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();
		
     });
         
</script>      
<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?> 