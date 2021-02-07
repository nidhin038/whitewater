<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
$row_default_lang=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_language where `lang_default`=true"));
include("languages/".$row_default_lang['lang_file']);
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: booking-failure.php?error_code=9');
}
include("includes/mail.class.php");
include("includes/process.class.php");
$bookprs = new BookingProcess();
switch($bookprs->paymentGatewayCode){	
	case "poa":
		processPayOnArrival();
		break;
		
	case "pp": 		
		processPayPal();
		break;	
		
	default:
		processOther();
}
/* PAY ON ARIVAL: MANUAL PAYMENT */	
function processPayOnArrival(){	
	global $bookprs;
	global $bsiCore;
	$bsiMail = new bsiMail();
	$emailContent = $bsiMail->loadEmailContent();
	$subject    = $emailContent['subject'];
	mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE bsi_bookings SET payment_success=true WHERE booking_id = ".$bookprs->bookingId);
	mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE bsi_clients SET existing_client = 1 WHERE email = '".$bookprs->clientEmail."'");		
			
	$emailBody  = DEAR_TEXT." ".$bookprs->clientName.",<br><br>";
	$emailBody .= $emailContent['body']."<br><br>";
	$emailBody .= $bookprs->invoiceHtml;
	$emailBody .= '<br><br>'.REGARDS_TEXT.',<br>'.$bsiCore->config['conf_portal_name'].'<br>'.$bsiCore->config['conf_portal_phone'];			
	$returnMsg = $bsiMail->sendEMail($bookprs->clientEmail, $subject, $emailBody);
	if ($returnMsg == true) {		
		$notifyEmailSubject = BOOKING_NO_TEXT.".".$bookprs->bookingId." - ".NOTIFICATION_CAR_BOOKING_BY_TEXT." ".$bookprs->clientName;				
		$notifynMsg = $bsiMail->sendEMail($bsiCore->config['conf_portal_email'], $notifyEmailSubject, $bookprs->invoiceHtml);
		header('Location: booking-confirm.php?success_code=26');
		die;
	}else {
		header('Location: booking-failure.php?error_code=25');
		die;
	}	
}
/* PAYPAL PAYMENT */ 
function processPayPal(){
	global $bookprs;
	
	echo "<script language=\"JavaScript\">";
	echo "document.write('<form action=\"paypal.php\" method=\"post\" name=\"formpaypal\">');";
	echo "document.write('<input type=\"hidden\" name=\"amount\"  value=\"".number_format($bookprs->totalPaymentAmount, 2, '.', '')."\">');";
	echo "document.write('<input type=\"hidden\" name=\"invoice\"  value=\"".$bookprs->bookingId."\">');";
	echo "document.write('</form>');";
	echo "setTimeout(\"document.formpaypal.submit()\",500);";
	echo "</script>";	
}
/* OTHER PAYMENT */
function processOther(){
	/* not implemented yet */
	header('Location: booking-failure.php?error_code=22');
	die;
}
?>