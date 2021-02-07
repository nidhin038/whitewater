<?php 
include("access.php");
if((isset($_GET['action'])) && ($_GET['action'] == "unblock")){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	$booking_id  = $bsiCore->ClearInput($_GET['bid']);
	mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_bookings where booking_id=".$booking_id."");
	header("location:car-blocking.php");
	exit;
}
include("header.php");
include("../includes/admin.class.php"); 
include("../includes/conf.class.php");
?>

<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?php echo CAR_BLOCK_LIST;?></span>
    <input type="button" value="<?php echo CLICK_HERE_TO_BLOCK_CAR;?>" onClick="window.location.href='block_car.php'" style="background: #EFEFEF; float:right;"/>
<hr />
  <table class="display datatable" border="0">
    <thead>
      <tr>
        <th><?php echo CAR_BLOCKING_DESCRIPTION_AND_NAME;?></th>
        <th><?php echo CAR_BLOCKING_CAR_TYPE;?></th>
        <th><?php echo CAR_BLOCKING_CAR_VENDOR;?></th>
        <th><?php echo CAR_BLOCKING_MODEL;?></th>
        <th><?php echo CAR_BLOCKING_DATE_RANGE;?></th>
        <th><?php echo PICK_UP_LOCATION_TEXT;?></th>
        <th><?php echo DROP_OFF_LOCATION_TEXT;?></th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <?php echo $bsiAdminMain->getCarBlockDetails();?>
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
