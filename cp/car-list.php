<?php 
include("access.php");
if(isset($_GET['delid'])){
	include("../includes/db.conn.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->carDelete(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['delid']));
	header("location:car-list.php");
	exit;
}
include("header.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
?>
<script type="text/javascript">
function deletecarmas(delid){
	var approval = confirm('<?php echo mysqli_real_escape_string($GLOBALS["___mysqli_ston"], DO_YOU_WANT_TO_DELETE_THIS_CAR_AND_REMEMBER_CORRESPONDING_OF_ITS_BOOKING_WILL_ALSO_BE_DELETED);?>');
	if(approval){
		window.location = 'car-list.php?delid='+delid;	
	}
}
</script>
<div id="container-inside"> <span style="font-size:16px; font-weight:bold"><?php echo CAR_LIST;?></span>
  <input type="button" value="<?php echo CAR_LIST_ADD_NEW_CAR;?>" onClick="window.location.href='add_edit_car.php?cid=0'" style="background: #EFEFEF; float:right"/>
  <hr />
  <table class="display datatable" border="0">
    <thead>
      <tr>
        <th><?php echo SN;?>.</th>
        <th><?php echo CAR_TYPE;?></th>
        <th><?php echo CAR_VENDOR;?></th>
        <th><?php echo CAR_MODEL;?></th>
        <th><?php echo TOTAL_CAR;?></th>
        <th><?php echo FUEL_TYPE;?></th>
        <th><?php echo STATUS;?></th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php echo $bsiAdminMain->getAllCardetailsRow();?>
    </tbody>
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
