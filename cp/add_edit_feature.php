<?php 
include("access.php");
if(isset($_POST['submitFeatures'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->carFeaturesAddEdit(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['features_id']));
	header("location:car-features.php");
}
include("header.php"); 
include("../includes/admin.class.php");
if(isset($_GET['fid'])){
	
	if($_GET['fid'] != 0){
		$getfeaturesrow=$bsiAdminMain->geteditFeaturesRowValue($_GET['fid']);
		
	}else{
		$getfeaturesrow=NULL;
	}
	
}
?>      
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo FEATURE_ADD_AND_EDIT;?></span>
        <input type="button" value="<?php echo ADD_EDIT_FEATURE_BACK;?>" onClick="window.location.href='car-features.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand; "/>
        <hr style="margin-top:10px;"/>
           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
          <input type="hidden" name="features_id" value="<?php echo $_GET['fid'];?>"/>
            <tr>
              <td><strong><?php echo FEATURES_TITLE;?>:</strong></td>
              <td><input type="text" name="features_title" value="<?php echo $getfeaturesrow['features_title'];?>" id="features_title" class="required" style="width:200px;" /></td>
            </tr>
            <tr><td></td><td><input type="submit" value="<?php echo ADD_EDIT_FEATURE_SUBMIT;?>" name="submitFeatures" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
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