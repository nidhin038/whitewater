<?php 
include("access.php");
if(isset($_REQUEST['delete'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");	
	$bsiAdminMain->booking_cencel_delete(2);
	header("location:view_active_or_archieve_bookings.php?book_type=".$_GET['book_type']);
	exit;
}
if(isset($_REQUEST['cancel'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");	
	include("../includes/admin.class.php");
	include("../includes/mail.class.php");	
	$bsiAdminMain->booking_cencel_delete(1); 
	header("location:view_active_or_archieve_bookings.php?book_type=".$_GET['book_type']);
	exit;
}
include("header.php"); 
include("../includes/conf.class.php");	
include("../includes/admin.class.php");
if(isset($_GET['book_type'])){
	$book_type = $bsiCore->ClearInput($_GET['book_type']);
	
}else{
	$book_type = $bsiCore->ClearInput($_POST['book_type']);
	$_SESSION['book_type'] = $book_type;
	$_SESSION['fromDate']=$bsiCore->ClearInput($_POST['fromDate']);
	$_SESSION['toDate']=$bsiCore->ClearInput($_POST['toDate']);
	$_SESSION['shortby']=$bsiCore->ClearInput($_POST['shortby']);
}
if($_SESSION['fromDate'] !="" and $_SESSION['toDate'] != ""){
$condition=" and (DATE_FORMAT(".$_SESSION['shortby'].", '%Y-%m-%d') between '".$bsiCore->getMySqlDate($_SESSION['fromDate'])."' and '".$bsiCore->getMySqlDate($_SESSION['toDate'])."')";
$shortbyarr=array("booking_time"=>"Booking Date", "pickup_datetime"=>"Pick-up Date", "dropoff_datetime"=>"Drop-off Date");
$text_cond="( ".$_SESSION['fromDate']."  To ".$_SESSION['toDate']."  By ".$shortbyarr[$_SESSION['shortby']]." )";
}else{
$condition="";
$text_cond="";
}

$query = $bsiAdminMain->getBookingInfo($book_type, $clientid=0, $condition);

$html  = $bsiAdminMain->getBookingDetailsHtml($book_type, $query);
$title_hr = array(1=>ACTIVE_BOOKING_LIST_TEXT, 2=>BOOKING_HISTORY_LIST_TEXT);
?>   
<script type="text/javascript">
	function cancel(bid){
		var answer = confirm ('<?php echo ARE_YOU_SURE_WANT_TO_CANCEL_BOOKING;?>');
		if (answer)
			window.location="<?php echo $_SERVER['PHP_SELF'];?>?cancel="+bid+"&book_type="+<?php echo $book_type;?>;
	}
	
	function deleteBooking(bid){
		var answer = confirm ('<?php echo DELETE_BOOKING_ALERT;?>');
		if (answer)
			window.location="<?php echo $_SERVER['PHP_SELF'];?>?delete="+bid+"&book_type="+<?php echo $book_type;?>;
	}
		
	function myPopup2(booking_id){
		var width = 730;
		var height = 650;
		var left = (screen.width - width)/2;
		var top = (screen.height - height)/2;
		var url='print_invoice.php?bid='+booking_id;
		var params = 'width='+width+', height='+height;
		params += ', top='+top+', left='+left;
		params += ', directories=no';
		params += ', location=no';
		params += ', menubar=no';
		params += ', resizable=no';
		params += ', scrollbars=yes';
		params += ', status=no';
		params += ', toolbar=no';
		newwin=window.open(url,'Chat', params);
		if (window.focus) {newwin.focus()}
		return false;
   }
</script> 
      <div id="container-inside">
      <span style="font-size:16px; font-weight:bold"><?php echo $title_hr[$book_type];?>  <?php echo $text_cond;?></span>
      <input type="submit" value="<?php echo VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_BACK;?>" style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right" onClick="javascript:window.location.href='booking-list.php'"/>
      <hr />
        <table class="display datatable" border="0">
         <?php echo $html;?>
        </table>
      </div>
 <script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script>
 <script>
 $(document).ready(function() {
	 	var oTable = $('.datatable').dataTable( {
				"bJQueryUI": true,
				"sScrollX": "",
				"bSortClasses": false,
				"aaSorting": [[0,'desc']],
				"bAutoWidth": true,
				"bInfo": true,
				"sScrollY": "100%",	
				"sScrollX": "100%",
				"bScrollCollapse": true,
				"sPaginationType": "full_numbers",
				"bRetrieve": true,
				"oLanguage": {
								"sSearch": "<?php echo DT_SEARCH;?>:",
								"sInfo": "<?php echo DT_SINFO1;?> _START_ <?php echo DT_SINFO2;?> _END_ <?php echo DT_SINFO3;?> _TOTAL_ <?php echo DT_SINFO4;?>",
								"sInfoEmpty": "<?php echo DT_INFOEMPTY;?>",
								"sZeroRecords": "<?php echo DT_ZERORECORD;?>",
								"sInfoFiltered": "(<?php echo DT_FILTER1;?> _MAX_ <?php echo DT_FILTER2;?>)",
								"sEmptyTable": "<?php echo DT_EMPTYTABLE;?>",
								"sLengthMenu": "<?php echo DT_LMENU;?> _MENU_ <?php echo DT_SINFO4;?>",
								"oPaginate": {
												"sFirst":    "<?php echo DT_FIRST;?>",
												"sPrevious": "<?php echo DT_PREV;?>",
												"sNext":     "<?php echo DT_NEXT;?>",
												"sLast":     "<?php echo DT_LAST;?>"
											  }
							 }
	} );
} );
</script> 
<script type="text/javascript" src="js/bsi_datatables.js"></script>
<link href="css/data.table.css" rel="stylesheet" type="text/css" />
<link href="css/jqueryui.css" rel="stylesheet" type="text/css" />
<?php include("footer.php"); ?> 