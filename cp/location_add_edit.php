<?php 
include("access.php");
if(isset($_POST['submitLocation'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->carLocationAddEdit(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['loc_id']));
	header("location:location_list.php");
}
include("header.php"); 
include("../includes/admin.class.php");
if(isset($_GET['lid'])){
	
	if($_GET['lid'] != 0){	
		$getlocationrow=$bsiAdminMain->geteditLocationRowValue($_GET['lid']);
		
	}else{
		$getlocationrow=NULL;
	}
	
}
?>      
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo LOCATION_ADD_EDIT_TEXT;?></span>
        <input type="button" value="<?php echo BACK_TEXT;?>" onClick="window.location.href='location_list.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand; "/>
        <hr style="margin-top:10px;"/>
           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
          <input type="hidden" name="loc_id" value="<?php echo $_GET['lid'];?>"/>
            <tr>
              <td><strong><?php echo LOCATION_TITLE_TEXT;?>:</strong></td>
              <td><input type="text" name="location_title" value="<?php if(isset($getlocationrow)){echo $getlocationrow['location_title'];}?>" id="location_title" class="required" style="width:300px;" /></td>
            </tr>
            <tr><td></td><td><input type="submit" value="<?php echo SUBMIT_TEXT;?>" name="submitLocation" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
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