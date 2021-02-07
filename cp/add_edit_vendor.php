<?php 
include("access.php");
if(isset($_POST['submitVendorss'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->carVendorsAddEdit(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['vendors_id']));
	header("location:car-vendors.php");
}
include("header.php"); 
include("../includes/admin.class.php");
if(isset($_GET['vid'])){
	
	if($_GET['vid'] != 0){
		$getvendorrow=$bsiAdminMain->geteditVendorssRowValue(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['vid']));
		
	}else{
		$getvendorrow=NULL;
	}
	
}
?>      
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo VENDOR_ADD_EDIT;?></span>
        <input type="button" value="<?php echo ADD_EDIT_VENDOR_BACK;?>" onClick="window.location.href='car-vendors.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand;"/>
       <hr style="margin-top:10px;"/>
           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
          <input type="hidden" name="vendors_id" value="<?php echo $_GET['vid'];?>"/>
            <tr>
              <td><strong><?php echo ADD_VENDOR_TITLE;?>:</strong></td>
              <td><input type="text" name="vendor_title" value="<?php echo $getvendorrow['vendor_title'];?>" id="vendor_title" class="required" style="width:200px;" /></td>
            </tr>
            <tr><td></td><td><input type="submit" value="<?php echo ADD_EDIT_VENDOR_SUBMIT;?>" name="submitVendorss" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
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