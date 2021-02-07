<?php 
include("access.php");
if(isset($_POST['submitdiscountdetails'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->addeditDiscount();
}
include("header.php"); 
include("../includes/admin.class.php");
include("../includes/conf.class.php");
if(isset($_GET['disco_id'])){
	
	if($_GET['disco_id'] != 0){
		$getdiscountrow=$bsiAdminMain->geteditDiscountRowValue(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['disco_id']));	
	}else{
		$getdiscountrow=NULL;
	}
	
}
?>      
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo DISCOUNT_UPON_DURATION_ADD_AND_EDIT;?></span>
        <input type="button" value="<?php echo DISCOUNT_BACK;?>" onClick="window.location.href='discount-duration.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand;"/><hr style="margin-top:10px;"/>
           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
          <input type="hidden" name="disco_id" value="<?php echo $_GET['disco_id'];?>"/>
            <tr>
              <td><strong><?php echo DISCOUNT_DAY_FROM;?>:</strong></td>
              <td><input type="text" name="day_from" value="<?php echo $getdiscountrow['day_from'];?>" id="day_from" class="required digits" style="width:70px;" /></td>
            </tr>
            <tr>
              <td><strong><?php echo DISCOUNT_DAY_TO;?>:</strong></td>
              <td><input type="text" name="day_to" value="<?php echo $getdiscountrow['day_to'];?>" id="day_to" class="required digits" style="width:70px;" /></td>
            </tr>
            <tr>
              <td><strong><?php echo DISCOUNT;?>:</strong></td>
              <td><input type="text" name="discount_percent" value="<?php echo $getdiscountrow['discount_percent'];?>" id="discount_percent" class="required number" style="width:70px;" />&nbsp;%</td>
            </tr>
            <tr><td></td><td><input type="submit" value="<?php echo DISCOUNT_SUBMIT;?>" name="submitdiscountdetails" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
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