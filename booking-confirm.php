<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
$succMsg[26] = BOOKING_SUCCESS_MSG_26;
session_destroy();
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
   <h2 align="left" style="padding-left:5px;"><?php echo BOKIING_COMPLETED;?></h2>
    <hr color="#e1dada"  style="margin-top:3px;"/><br /><br />
    <h4><?php echo THANK_YOU;?>!</h4><br /><?php echo YOUR_BOOKING_CONFIRMED;?>. <?php echo INVOICE_SENT_IN_YOUR_EMAIL_ADDRESS;?>.
  </div>
</div>
</body>
</html>