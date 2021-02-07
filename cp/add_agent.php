<?php 
include("access.php");
if(isset($_POST['block'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	$bookingId       = time();

}
include("header.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
if(isset($_POST['submit'])){
	include ('../includes/search.class.php');
	$bsisearch = new bsiSearch();
	
	
}
$agentId = "";
if(isset($_GET["agent_id"])){
	$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM bsi_agents WHERE id=".$_GET["agent_id"]);
	$agentDetails = mysqli_fetch_array($result);
  $agentId = $_GET["agent_id"];
}

?>

<link rel="stylesheet" type="text/css" href="../css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
 <script type="text/javascript" src="../js/dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>
<!--starting-->
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <div id="container-inside">
         <span style="font-size:16px; font-weight:bold"><?php echo AGENT_ADD_AND_EDIT;?></span>
        <input type="button" value="<?php echo ADD_EDIT_BACK;?>" onClick="window.location.href='customer-lookup.php'" style="background: #EFEFEF; float:right; cursor:pointer; cursor:hand;"/>
         <hr style="margin-top:10px;"/>
           <form action="" method="post" id="add-agent-form" >
          <table cellpadding="5" cellspacing="2" border="0">
         <!-- <input type="hidden" name="car_id" value="<?php echo $_GET['cid'];?>"/> -->
            <tr>
              <td><strong><?php echo AGENT_CODE;?>:</strong></td>
              <td><input type="text" name="agent_code" id="agcode" class="required" value="<?php if(isset($agentDetails['agent_code'])){ echo $agentDetails['agent_code']; } ?>" style="width:170px;" /></td>
            </tr>
			<tr>
              <td><strong><?php echo AGENT_NAME;?>:</strong></td>
              <td><input type="text" name="agent_name"  id="agname" class="required" style="width:170px;" value="<?php if(isset($agentDetails['agent_name'])){ echo $agentDetails['agent_name']; } ?>" /></td>
			  
            </tr>
			<tr>
              <td><strong><?php echo ADDRESS;?>:</strong></td>
              <td>
			  <textarea name="address" id="address" class="required" style="width:200px;" ><?php if(isset($agentDetails['address'])){ echo $agentDetails['address']; } ?></textarea>
			  </td>
            </tr>
			<tr>
              <td><strong><?php echo AGENT_PLACE;?>:</strong></td>
              <td><input type="text" name="agent_Place" id="agplace" class="required" style="width:170px;" value="<?php if(isset($agentDetails['place'])){ echo $agentDetails['place']; } ?>" /></td>
            </tr>
            <tr>
              <td><strong><?php echo EMAIL_ID;?>:</strong></td>
              <td><input type="email" name="emailid" id="email_id" class="not" style="width:170px;" value="<?php if(isset($agentDetails['email'])){ echo $agentDetails['email']; } ?>" /></td>
            </tr>
			<tr>
              <td><strong><?php echo PHONE_NUMBER;?>:</strong></td>
              <td><input type="text" name="phno" id="ph_no" class="number_format" style="width:170px;" value="<?php if(isset($agentDetails['phone'])){ echo $agentDetails['phone']; } ?>"/></td>
            </tr>
             <tr>
              <td><strong><?php echo GST_NO;?>:</strong></td>
              <td><input type="text" name="gstno" id="gst_no" class="required" style="width:170px;" value="<?php if(isset($agentDetails['gst'])){ echo $agentDetails['gst']; } ?>" /></td>
            </tr>
			<tr>
              <td><strong><?php echo PAN_NO;?>:</strong></td>
              <td><input type="text" name="panno" id="pan_no" class="required" style="width:170px;" value="<?php if(isset($agentDetails['pan'])){ echo $agentDetails['pan']; } ?>" /></td>
            </tr>
            <tr><td>  
            <input type="checkbox" id="agt_op" name="Op" value="<?php if(isset($agentDetails['outside party'])){ echo $agentDetails['1']; }  ?>" />
            <label for="op">Outside Party</label><br></td>
          </tr>
          <tr><td>
            <input type="checkbox" id="agt_op" name="agent" value="<?php if(isset($agentDetails['agent'])){ echo $agentDetails['1']; } else echo $agentDetails['0'];   ?>" />
            <label for="agent">Agent</label><br></td>
          </tr>
			<tr>
              <td><strong><?php echo OPENING_BALANCE;?>:</strong></td>
              <td><input type="text" name="opbal" id="op_bal" class="required" style="width:170px;"  /></td>
            </tr>
			<tr>
              <td><strong><?php echo CURRENT_BALANCE;?>:</strong></td>
              <td><input type="text" name="cbal" id="c_bal" class="required" style="width:170px;"  /></td>
			</tr>
            <tr><td>
              <input type="hidden" name="agent_id" value="<?php echo $agentId; ?>">
              <input type="button" value="<?php echo ADD_AGENT_SUBMIT;?>" onclick="saveAgent(<?php echo $agentId; ?>);" name="submitagentdetails" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
            </table>
            </form>
        </div > 
<?php include("footer.php"); ?>

<script>
function saveAgent(agentId){

	var addAgentFormData = $("#add-agent-form").serialize();
  console.log(addAgentFormData)
	var url = "api/add-agent-api.php";
	$.post(url,addAgentFormData, function(data, status){
		if(data=="success"){
			alert("Saved successfully");
			window.location.href = "customer-lookup.php";
		}else{
			alert("Saving failed. Please try again.")
		}
  });
}
</script>
