<?php
include ("access.php");
if(isset($_GET['pln_del']))
{
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->price_del(base64_decode($_GET['pln_del']));
}
include("header.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
?>

<script>
	$(document).ready(function(){
		 $('#c1').change(function() { 
			getPriceplan();
		 });
		 if($('#c1').val() > 0){
			 getPriceplan();
		 }
		 function getPriceplan(){
			 if($('#c1').val() != 0){
				var querystr = 'actioncode=3&c1='+$('#c1').val();
				$.post("admin_ajax_processor.php", querystr, function(data){					 
					if(data.errorcode == 0){ 
					
						$('#getpriceplanHtml').html(data.strmsg)
					}else{
						$('#getpriceplanHtml').html('<tr><td colspan="12">No available Data found!</td></tr>')
					}
					
				}, "json");
			}
			if($('#c1').val() == 0){
				$('#getpriceplanHtml').html('<tr><td colspan="12">Please Select A car first!</td></tr>')
			}
		 }
	});
function priceplandelete(rid){
	var ans=confirm('Do you want to delete the selected plan');
	if(ans){
		window.location='<?=$_SERVER['PHP_SELF']?>?pln_del='+rid;
		return true;
		
	}else{
		return false;
		
	}
	
}
</script>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?php echo PRICE_PLAN_TITLE; ?></span>
<input type="button" value="<?PHP echo PRICEPLAN_BTN_TITLE; ?>" onClick="window.location.href='add_edit_priceplan.php?car_id=0'" style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right; " />
<hr style="margin-top:10px;" />
    <table width="100%"><tr><td width="80%" align="left"><?php if(isset($_SESSION['date_err'])){ echo '<font color="#FF0000">'.PRICEPLAN_ERROR.'</font>'; 
	unset($_SESSION['date_err']);}?></td><td align="right"></td></tr></table>
  
    <table cellpadding="5" cellspacing="0" border="0" width="100%">
      <thead>
        <tr>
          <th nowrap="nowrap" width="15%" align="left"><?php echo PRICEPLAN_SELECT_CAR; ?> :</th>
          <th  colspan="11" align="left">
            <select name="car_id" id="c1">
             <?php if(isset($_GET['cid'])){echo $bsiAdminMain->getCarcombo(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['cid']));}else{echo $bsiAdminMain->getCarcombo(); } ?>                      
          </select></th>
                            
        </tr>
        <tr><th colspan="12"><hr /></th></tr>
      </thead>
      <tbody id="getpriceplanHtml">
     <tr><td colspan="12"> <?php echo PRICEPLAN_MSG_CAR_SELECT; ?></td></tr>
      </tbody>
    </table>
</div>
<script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();
		
     });
         
</script> 
<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?>
