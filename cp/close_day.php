<?php 
include("access.php");
include("header.php"); 	
include("../includes/conf.class.php");
?>
<style>

.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active {
	background: #F8F7F6 url('images/ui-bg_fine-grain_10_f8f7f6_60x60.png') 50% 50% repeat;
}

/* begin: jQuery UI Datepicker moving pixels fix */
table.ui-datepicker-calendar {border-collapse: separate;}
.ui-datepicker-calendar td {border: 1px solid transparent;}
/* end: jQuery UI Datepicker moving pixels fix */

/* begin: jQuery UI Datepicker emphasis on selected dates */
.ui-datepicker .ui-datepicker-calendar .ui-state-highlight a {
	background: #743620 none;
	color: white;
}
/* end: jQuery UI Datepicker emphasis on selected dates */


/* begin: jQuery UI Datepicker hide datepicker helper */
#ui-datepicker-div {display:none;}
/* end: jQuery UI Datepicker hide datepicker helper */
</style>
<!-- loads jquery and jquery ui -->
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>
 <script type="text/javascript" src="../js/dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>
<!-- script type="text/javascript" src="js/jquery.ui.datepicker-es.js"></script -->	
<!-- loads mdp -->
<script type="text/javascript" src="js/jquery-ui.multidatespicker.js"></script>

<!-- mdp demo code -->
<script type="text/javascript">
<!--	
$(function() {
		// Version //
	$('#custom-date-format').multiDatesPicker({
		dateFormat: "yy-mm-dd",
		numberOfMonths:[3,4],
		altField: '#textselectdate',
		<?php
		if($bsiCore->getcloseDate()){
			echo 'addDates: ['.$bsiCore->getcloseDate().'],';
		}
		?>		
		minDate:0
	});
	$('#saveDate').click(function(){
	 var querystr='actioncode=2&selectdates='+$('#textselectdate').val();
	 	$.post("admin_ajax_processor.php", querystr, function(data){
		 	if(data.errorcode == 0){
				alert('<?php echo mysqli_real_escape_string($GLOBALS["___mysqli_ston"], SUCCESSFULLY_CLOSED_ALERT);?>');
			}
		 }, "json");
	 });
});
// -->
</script>

		<!-- loads some utilities (not needed for your developments) -->
		<link rel="stylesheet" type="text/css" href="css/pepper-ginder-custom.css">
		
<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?php echo CLOSE_DATE_SETTING_TEXT;?></span>
<input type="button" value="<?php echo CLICK_TEXT_TO_SAVE_SELECT_DATE;?>" id="saveDate" style="background: #EFEFEF; float:right"/>
      <hr />
  <div id="custom-date-format"  class="box" align="center"></div>
  <input type="hidden" id="textselectdate" >
  
</div>

		<!-- loads some utilities (not needed for your developments) -->
<?php include("footer.php"); ?>
