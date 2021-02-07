<?php 
include("access.php");
if(isset($_POST['block'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	$bookingId       = time();
	$sql = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO bsi_bookings (booking_id,booking_time, pickup_datetime, dropoff_datetime, client_id, is_block, payment_success, block_name,pick_loc,drop_loc) values(".$bookingId.", NOW(),'". $_SESSION['sv_mcheckindate']."', '".$_SESSION['sv_mcheckoutdate']."', '0', 1, 1, '".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['block_name'])."','". $bsiCore->getlocname($_SESSION['sv_pickup'])."','". $bsiCore->getlocname($_SESSION['sv_dropoff'])."')");	
	mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_res_data values(".$bookingId.", ".$bsiCore->ClearInput($_POST['choose']).")");
	header("location:car-blocking.php");
	exit;
}
include("header.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
if(isset($_POST['submit'])){
	include ('../includes/search.class.php');
	$bsisearch = new bsiSearch();
}
?>
<link rel="stylesheet" type="text/css" href="../css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
 <script type="text/javascript" src="../js/dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>

<?php include("footer.php"); ?>
