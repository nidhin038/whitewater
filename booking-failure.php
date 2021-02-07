<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
$errorCode = $bsiCore->ClearInput($_REQUEST["error_code"]);
$erroMessage = array(); 
/*define('BOOKING_FAILURE_ERROR_9', 'Direct access to this page is restricted.');
define('BOOKING_FAILURE_ERROR_13', 'Somebody else already acquire  the reservation lock on car specified by you. Reservation lock will be automatically released after few minutes on booking completion or failure by the other person. Please modify your search criteria and try again.');
define('BOOKING_FAILURE_ERROR_22', 'Undefined payment method selected. Please contact administrator.');
define('BOOKING_FAILURE_ERROR_25', 'Failed to send email notification. Please contact technical support.');*/
$erroMsg[9] = BOOKING_FAILURE_ERROR_9;
$erroMsg[13] = BOOKING_FAILURE_ERROR_13;
$erroMsg[22] = BOOKING_FAILURE_ERROR_22;
$erroMsg[25] = BOOKING_FAILURE_ERROR_25;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $bsiCore->config['conf_portal_name'];?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
</head>
<body>
<div id="content" align="center">
  <h1><?php echo $bsiCore->config['conf_portal_name'];?></h1>
   <div id="wrapper" style="width:400px !important; height:200px;">
   <h2 align="left" style="padding-left:5px;"><?php echo BOOKING_FAILURE;?></h2>
    <hr color="#e1dada"  style="margin-top:3px;"/><br /><br />
    <span style="color: #D00;"><?php echo $erroMsg[$errorCode];?></span>
  </div>
</div>
</body>
</html>