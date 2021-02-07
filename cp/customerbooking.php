<?php
include ("access.php");
if(isset($_REQUEST['delete'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->booking_cencel_delete(2);
	$client = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], base64_encode($_REQUEST['client']));
	header("location:customerbooking.php?client=".$client);
	exit;
}
if(isset($_REQUEST['cancel'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");	
	include("../includes/admin.class.php");
	include("../includes/mail.class.php");	
	$bsiAdminMain->booking_cencel_delete(1); 
	$client = base64_encode($_REQUEST['client']);
	header("location:customerbooking.php?client=".$client);
	exit;
}
if(isset($_GET['client'])){
	include("header.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$client    = base64_decode($_GET['client']);
	$delClient = $client;
	$htmlArr   = $bsiAdminMain->fetchClientBookingDetails($client);
	$html      = $htmlArr['html'];
}else{
	header("location:customerlookup.php");
	exit;
}
?>
<script type="text/javascript">
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
function cancel(bid){
	var answer = confirm ('<?php echo ARE_YOU_SURE_WANT_TO_CANCEL_BOOKING;?>');
	if (answer)
		window.location="<?php echo $_SERVER['PHP_SELF'];?>?cancel="+bid+"&client="+<?php echo $delClient;?>;
}
function booking_delete(delid){
	var answer = confirm ('<?php echo ARE_YOU_SURE_WANT_DELETE_BOOKING_REMEMBER_ONCE_BOOKING_DELETED_IT_WILL_BE_DELETED_FOREVER_FROM_YOUR_DATABASE;?>')
	if (answer)
		window.location="<?php echo $_SERVER['PHP_SELF'];?>?delete="+delid+"&client="+<?php echo $delClient;?>;
	}
</script>

<div id="container-inside"> <span style="font-size:16px; font-weight:bold"><?php echo BOOKING_LIST_OF;?>
  <?php echo $htmlArr['clientName'];?>
  </span>
  <input type="submit" value="<?php echo CUSTOMERBOOKING_BACK;?>" style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right" onClick="javascript:window.location.href='customer-lookup.php'"/>
  <hr />
  <table class="display datatable" border="0">
    <thead>
      <tr>
        <th width="8%" nowrap><?php echo BOOKING_ID;?></th>
        <th width="15%" nowrap="nowrap"><?php echo CUSTOMERBOOKING_PICKUP_DATE_AND_TIME;?></th>
        <th width="15%" nowrap><?php echo CUSTOMERBOOKING_DROP_OFF_DATE_TIME;?></th>
        <th width="10%" nowrap><?php echo CUSTOMERBOOKING_AMOUNT;?></th>
        <th width="15%" nowrap><?php echo CUSTOMERBOOKING_BOOKING_DATE;?></th>
        <th width="8%" nowrap="nowrap"><?php echo CUSTOMERBOOKING_STATUS;?></th>
        <th width="29%">&nbsp;</th>
      </tr>
    </thead>
    <?=$html?>
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
