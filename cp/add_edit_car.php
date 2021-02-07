<?php 
include("access.php");
if(isset($_POST['submitcardetails'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->carAddEdit(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['car_id']));
	header("location:car-list.php");
}
include("header.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
if(isset($_GET['cid'])){
$car_id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['cid']);	
	if($_GET['cid'] != 0){
		$getcardetailsrow = $bsiAdminMain->geteditCarRowValue(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['cid']));
		$gettypecom = $bsiCore->getCartypeCombo($getcardetailsrow['car_type_id']);
		$vendercom = $bsiCore->getCarvendorCombo($getcardetailsrow['car_vendor_id']);
		$getfeatures = $bsiAdminMain->showAllFeatures(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['cid']));
		
	}else{
		$getcardetailsrow = NULL;
		$gettypecom = $bsiCore->getCartypeCombo();
		$vendercom = $bsiCore->getCarvendorCombo();
		$getfeatures = $bsiAdminMain->showAllFeatures();
	}
	
}
?>      
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo CAR_ADD_AND_EDIT;?></span>
        <input type="button" value="<?php echo ADD_EDIT_BACK;?>" onClick="window.location.href='car-list.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand;"/>
         <hr style="margin-top:10px;"/>
           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form1" enctype="multipart/form-data">
          <table cellpadding="5" cellspacing="2" border="0">
          <input type="hidden" name="car_id" value="<?php echo $_GET['cid'];?>"/>
            <tr>
              <td><strong><?php echo SELECT_CAR_TYPE_ID;?>:</strong></td>
              <td><?php echo $gettypecom;?></td>
            </tr>
             <tr>
              <td><strong><?php echo SELECT_CAR_VENDOR_ID;?>:</strong></td>
              <td><?php echo $vendercom;?></td>
            </tr>
             <tr>
              <td><strong><?php echo ADD_EDIT_CAR_MODEL;?>:</strong></td>
              <td><input type="text" name="car_model" value="<?php echo $getcardetailsrow['car_model'];?>" id="car_model" class="required" style="width:170px;" /></td>
            </tr>
            <tr>
              <td><strong><?php echo ADD_EDIT_TOTAL_CAR;?>:</strong></td>
              <td><input type="text" name="total_car" value="<?php echo $getcardetailsrow['total_car'];?>" id="total_car" class="required" style="width:50px;" /></td>
            </tr>
            <tr>
            <td valign="top"><strong><?php echo PICK_UP_LOCATION_TEXT;?>:</strong></td>
            <td>
            <select multiple="multiple" name="pickup[]" style="width:200px" class="required">
              <?php echo $bsiAdminMain->getPickupLocation($car_id); ?>
            </select>
            </td>
            </tr>
            <tr>
            <td valign="top"><strong><?php echo DROP_OFF_LOCATION_TEXT;?>:</strong></td>
            <td>
            <select multiple="multiple" name="dropoff[]" style="width:200px" class="required">
              <?php echo $bsiAdminMain->getDropoffLocation($car_id); ?>
            </select>
            </td>
            </tr>
             <tr>
              <td><strong><?php echo FUEL_TYPE;?>:</strong></td>
              <td><input type="text" name="fuel_type" value="<?php echo $getcardetailsrow['fuel_type'];?>" id="fuel_type" class="required" style="width:170px;" />&nbsp;&nbsp;<?php echo EXAMPLE_PETROL_GAS;?>.</td>
            </tr>
            <tr>
              <td><strong><?php echo CAR_MILEAGE_AND_DAY;?>:</strong></td>
              <td><input type="text" name="car_mileage" value="<?php echo $getcardetailsrow['mileage'];?>" id="car_mileage" class="number" style="width:50px;" />&nbsp;<b><?php echo $bsiCore->config['conf_mesurment_unit'];?></b>&nbsp;&nbsp;<font color="#330099">(<?php echo LEAVE_BLANK_FOR_UNLIMITED;?>)</font></td>
            </tr>
             <tr>
              <td><strong><?php echo CAR_IMAGE;?>:</strong></td>
              <td><input type="file" name="car_img" id="car_img"/>
              <?php if($getcardetailsrow['car_img'] != ""){?>
          <span>&nbsp;&nbsp;&nbsp;&nbsp;<a rel="collection" href="../gallery/<?=$getcardetailsrow['car_img']?>" target="_blank"><strong><?php echo VIEW_IMAGE_CAR;?></strong></a>&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="navy sky"><?php echo DELETE_IMAGE;?></font></strong><input type="checkbox" name="deleteimg"/></span><?php }else{ echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>".NO_IMAGE."</b>";} ?>
              </td>
            </tr>
            
            <tr>
                <td valign="top"><strong><?php echo CAR_FEATURES;?>:</strong>
                 </td><td><?php echo $getfeatures;?></td>
                </tr>
                
            <?php
			if($getcardetailsrow['status'] == 1){
			?>
             <tr>
              <td><strong><?php echo ADD_EDIT_STATUS;?>:</strong></td>
              <td><input type="checkbox" id="status" name="status" checked="checked"/></td>
            </tr>
            <?php
			}else{
			?>
            <tr>
              <td><strong><?php echo ADD_EDIT_STATUS;?>:</strong></td>
              <td><input type="checkbox" id="status" name="status"/></td>
            </tr>
            <?php
			}
			?>
            <tr><td></td><td><input type="submit" value="<?php echo ADD_EDIT_CAR_SUBMIT;?>" name="submitcardetails" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
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