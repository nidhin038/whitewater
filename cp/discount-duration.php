<?php 
include("access.php");
if(isset($_GET['delid'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->discountDelete(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['delid'])); 
	header("location:discount-duration.php");
	
}
include("header.php"); 
include("../includes/conf.class.php");
?> 

 <div id="container-inside">
        <span style="font-size:16px; font-weight:bold"><?php echo DISCOUNT_UPON_DURATION;?> </span>&nbsp;&nbsp;
    <input type="button" value="<?php echo ADD_NEW_DISCOUNT_SCHEMA;?>" onClick="window.location.href='add_edit_discount_duration.php?disco_id=0'" style="background: #EFEFEF; float:right"/>
<hr />

  <table class="display datatable" border="0">
    <thead>
      <tr>
        <th><?php echo DISCOUNT_BOOKING_FROM;?></th>
        <th><?php echo DISCOUNT_BOOKING_TO;?></th>
        <th><?php echo DISCOUNT_OF_TOTAL_AMOUNT;?></th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody><?php echo $bsiCore->getAllDiscountDurationRow();?></tbody>
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