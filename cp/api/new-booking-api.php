<?php 
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	$bookingId       = time();
	$sql = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO bsi_bookings (booking_time, agent_id, pickup_datetime, dropoff_datetime, client_id, is_block, payment_success, block_name,pick_loc,drop_loc) values( NOW(),".$_POST["agent_id"].",'". $_POST['sv_mcheckindate']."', '".$_POST['sv_mcheckindate']."', '0', 1, 1, '".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['block_name'])."','". $bsiCore->getlocname($_SESSION['sv_pickup'])."','". $bsiCore->getlocname($_SESSION['sv_dropoff'])."')");	

	mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_res_data values(".$bookingId.", ".$bsiCore->ClearInput($_POST['choose']).")");
	exit;
?>	