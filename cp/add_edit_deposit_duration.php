<?php 
include("access.php");
if(isset($_POST['submitdepositdetails'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->addeditDeposit();
	header("location:deposit-duration.php");
}
include("header.php"); 
include("../includes/admin.class.php");
include("../includes/conf.class.php");
if(isset($_GET['depoid'])){
	
	if($_GET['depoid'] != 0){
		$getdepositrow=$bsiAdminMain->geteditDepositRowValue(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['depoid']));	
	}else{
		$getdepositrow=NULL;
	}
	
}
?>      
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo PREPAID_AMOUNT_ADD_AND_EDIT;?></span>
        <input type="button" value="<?php echo DEPOSITE_DURATION_BACK;?>" onClick="window.location.href='deposit-duration.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand;"/><hr style="margin-top:10px;"/>
           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
          <input type="hidden" name="depo_id" value="<?php echo $_GET['depoid'];?>"/>
            <tr>
              <td><strong><?php echo DEPOSIT_DAY_FROM;?>:</strong></td>
              <td><input type="text" name="day_from" value="<?php echo $getdepositrow['day_from'];?>" id="day_from" class="required digits" style="width:70px;" /></td>
            </tr>
            <tr>
              <td><strong><?php echo DEPOSIT_DAY_TO;?>:</strong></td>
              <td><input type="text" name="day_to" value="<?php echo $getdepositrow['day_to'];?>" id="day_to" class="required digits" style="width:70px;" /></td>
            </tr>
            <tr>
              <td><strong><?php echo DEPOSIT;?>:</strong></td>
              <td><input type="text" name="deposit_percent" value="<?php echo $getdepositrow['deposit_percent'];?>" id="deposit_percent" class="required number" style="width:70px;" />&nbsp;%</td>
            </tr>
            <tr><td></td><td><input type="submit" value="<?php echo DEPOSITE_DURATION_SUBMIT;?>" name="submitdepositdetails" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
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