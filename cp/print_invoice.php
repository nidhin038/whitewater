<?php  
include ("access.php");
include("../includes/db.conn.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
include("language.php");
if(isset($_REQUEST['bid'])){
 $r_invoice=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_invoice where booking_id=".$bsiCore->ClearInput($_REQUEST['bid'])));
 $r_booking=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_bookings where booking_id=".$bsiCore->ClearInput($_REQUEST['bid'])));
 $paymentgateway = $bsiAdminMain->getPayment_Gateway($r_booking['payment_type']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Print Booking Invoice</title>
<script type="text/javascript">
window.print()
</script>
</head>
<body>
<div align="center">
<table cellpadding="3"  border="0" width="700">
<tr><td width="400" align="left" valign="top">
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; font-weight:bold;"><?php echo $bsiCore->config['conf_portal_name'];?></span><br />
<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $bsiCore->config['conf_portal_streetaddr'];?></span><br />
<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $bsiCore->config['conf_portal_city'];?></span><br />
<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $bsiCore->config['conf_portal_state']." ". $bsiCore->config['conf_portal_zipcode'];?></span><br />
<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $bsiCore->config['conf_portal_country'];?></span><br />
</td>
<td width="200" align="right" valign="top">
<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><b><?php echo VIEW_PHONE;?>:</b> <?php echo $bsiCore->config['conf_portal_phone'];?></span><br />
<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><b><?php echo VIEW_FAX;?>:</b> <?php echo $bsiCore->config['conf_portal_fax'];?></span><br />
<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><b><?php echo VIEW_EMAIL;?>:</b> <?php echo $bsiCore->config['conf_portal_email'];?></span><br />
</td></tr>
</table><br />
<?php echo $r_invoice['invoice'];?>
</div>
</body>
</html>
