<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");	
include("includes/ajaxprocess.class.php");	
$ajaxProc = new ajaxProcessor();
//$actionCode = isset($_POST['actioncode']) ? $_POST['actioncode'] : 0;
switch(1){
	case "1": $ajaxProc->getCustomerDetails(); break;
	default:  $ajaxProc->sendErrorMsg();
}
?>