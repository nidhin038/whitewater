<?php 
include("access.php");
if(isset($_POST['submitFeatures'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->carTypesAddEdit(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['type_id']));
	header("location:car-types.php");
}
include("header.php"); 
include("../includes/admin.class.php");
if(isset($_GET['tid'])){
	
	if($_GET['tid'] != 0){
		$gettypesrow=$bsiAdminMain->geteditTypesRowValue(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tid']));
		
	}else{
		$gettypesrow=NULL;
	}
	
}
?>      
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo CAR_TYPE_ADD_EDIT;?></span>
        <input type="button" value="<?php echo ADD_EDIT_TYPE_BACK;?>" onClick="window.location.href='car-types.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand;"/><hr style="margin-top:10px;"/>
           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
          <input type="hidden" name="type_id" value="<?php echo mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tid']);?>"/>
            <tr>
              <td><strong><?php echo TYPE_TITLE;?>:</strong></td>
              <td><input type="text" name="type_title" value="<?php echo $gettypesrow['type_title'];?>" id="type_title" class="required" style="width:200px;" /></td>
            </tr>
            <tr><td></td><td><input type="submit" value="<?php echo ADD_EDIT_TYPE_SUBMIT;?>" name="submitFeatures" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
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