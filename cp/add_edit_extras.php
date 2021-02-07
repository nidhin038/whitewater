<?php 
include("access.php");
if(isset($_POST['submitextrasdetails'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->addeditExtras();
	header("location:extras.php");
}
include("header.php"); 
include("../includes/admin.class.php");
include("../includes/conf.class.php");
if(isset($_GET['extra_id'])){ 
	
	if($_GET['extra_id'] != 0){
		$getextrasrow=$bsiAdminMain->geteditableextrasRowValue(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['extra_id']));	
	}else{
		$getextrasrow=NULL;
	}
	
}
?>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside"> <span style="font-size:16px; font-weight:bold"><?php echo EXTRA_ITEM;?></span>
  <input type="button" value="<?php echo EXTRAS_BACK;?>" onClick="window.location.href='admin-home.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand;"/>
  <hr style="margin-top:10px;"/>
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
    <table cellpadding="5" cellspacing="2" border="0">
      <input type="hidden" name="extra_id" value="<?php echo mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['extra_id']);?>"/>
      <tr>
        <td><strong><?php echo EXTRA_ITEM;?>:</strong></td>
        <td><input type="text" name="car_extras" value="<?php echo $getextrasrow['car_extras'];?>" id="car_extras" class="required" style="width:200px;" /></td>
      </tr>
      <tr>
        <td><strong><?php echo ADD_PRICE_AND_DAY;?>:</strong></td>
        <td><input type="text" name="price" value="<?php echo $getextrasrow['price'];?>" id="price" class="required number" style="width:70px;" />
          &nbsp;
          <?php echo $bsiCore->config['conf_currency_code'];?></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="<?php echo EXTRAS_SUBMIT;?>" name="submitextrasdetails" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>
      </tr>
    </table>
  </form>
</div>
<script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();	
     });
         
</script> 
<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?>
