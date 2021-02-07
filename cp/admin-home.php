<?php 
include("access.php");
include("header.php"); 
include("../includes/conf.class.php");	
include("../includes/admin.class.php")
?>      
        <div id="container-inside">
        <span style="font-size:16px; font-weight:bold"><?php echo TODAY_BOOKING_LIST_TEXT;?></span>
     	 <hr />
          <table class="display datatable" border="0">
         <?php echo $bsiAdminMain->homewidget(1);?>
        </table>
         <br />
         
         <span style="font-size:16px; font-weight:bold"><?php echo TODAY_PICKUP_LIST_TEXT;?></span>
      	 <hr />
          <table class="display datatable" border="0">
         <?php echo $bsiAdminMain->homewidget(2);?>
        </table>
         <br />
         
         <span style="font-size:16px; font-weight:bold"><?php echo TODAY_DROPOFF_LIST_TEXT;?></span>
         <hr />
          <table class="display datatable" border="0">
        <?php echo $bsiAdminMain->homewidget(3);?>
        </table>
         <br />
         
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