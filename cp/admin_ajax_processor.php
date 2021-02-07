<?php
include("access.php");
include("../includes/db.conn.php");
include("../includes/conf.class.php");
include("language.php");
include("../includes/admin.ajaxprocess.class.php");	 
$adminAjaxProc = new adminAjaxProcessor();
$actionCode = isset($_POST['actioncode']) ? $_POST['actioncode'] : 0;
switch($actionCode){
	case "1": $adminAjaxProc->getbsiEmailcontent(); break;
	case "2": $adminAjaxProc->saveCloseDate(); break;	
	case "3": $adminAjaxProc->generatePriceplanList(); break;
	case "4": $adminAjaxProc->generate_price_add_edit(); break;
	default:  $adminAjaxProc->sendErrorMsg();
}
?>