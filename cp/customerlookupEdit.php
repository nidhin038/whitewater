<?php 
include ("access.php"); 
if(isset($_POST['act'])){
	include("../includes/db.conn.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->updateCustomerLookup();
	header("location:customer-lookup.php"); 
	exit;
}

include("header.php");
$update=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], base64_decode($_GET['update']));
if(isset($update)){
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$row   = $bsiAdminMain->getCustomerLookup($update);
	$title = $bsiAdminMain->getTitle($row['title']);
}else{
	header("location:customer-lookup.php");
}
 ?>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside"> <span style="font-size:16px; font-weight:bold"><?php echo CUSTOMER_DETAILS_EDIT_TEXT;?></span>
  <hr />
  <form action="" method="post" id="form1">
    <table cellpadding="5" cellspacing="2" border="0">
      <tr>
        <td><strong><?php echo CUSTOMER_TITLE_TEXT;?>:</strong></td>
        <td><?php echo $title;?></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_FIRST_NAME_TEXT;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $row['first_name'];?>" style="width:200px;" name="fname" id="fname"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_LAST_NAME_TEXT;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $row['surname'];?>" style="width:200px;" name="sname" id="sname"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_STREET_ADDRESS_TEXT;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $row['street_addr'];?>" style="width:250px;" name="sadd" id="sadd"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_CITY_TEXT;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $row['city'];?>"  name="city" id="city"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_PROVINCE_TEXT;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $row['province'];?>"  name="province" id="province"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_ZIP_TEXT;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $row['zip'];?>"  name="zip" id="zip"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_COUNTRY_TEXT;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $row['country'];?>"  name="country" id="country"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_PHONE_TEXT;?>:</strong></td>
        <td><input type="text" class="required" value="<?php echo $row['phone'];?>"  name="phone" id="phone"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_FAX_TEXT;?>:</strong></td>
        <td><input type="text" value="<?php echo $row['fax'];?>"  name="fax" id="fax"/></td>
      </tr>
      <tr>
        <td align="left"><strong><?php echo CUSTOMER_EMAIL_TEXT;?>:</strong></td>
        <td><input type="text" value="<?php echo $row['email'];?>"  name="email" id="email" style="width:250px;" readonly="readonly"/>
          <input type="hidden" name="httpreffer" value="<?php echo $_SERVER['HTTP_REFERER'];?>" /></td>
      </tr>
      <input type="hidden" name="cid" value="<?php echo $row['client_id'];?>">
      <input type="hidden" name="act" value="1">
      <tr>
        <td  width="100px"></td>
        <td align="left"><input type="submit" value="<?php echo SUBMIT_TEXT;?>"  style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>
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
