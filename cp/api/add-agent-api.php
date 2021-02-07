<?php
include("../../includes/db.conn.php");
if(isset($_POST["action"])){
	if($_POST["action"]  == "delete"){
		mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM `bsi_agents` WHERE id=".$_POST["agentId"]);
	}
}else{ 
	if($_POST["agent_id"] != ""){
	mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `bsi_agents` SET `agent_code`='".$_POST['agent_code']."',
	`agent_name`='".$_POST['agent_name']."',`address`='".$_POST['address']."',`place`='".$_POST['agent_Place']."',`email`='".$_POST['emailid']."',`phone`='".$_POST['phno']."',
	`gst`='".$_POST['gstno']."',`pan`='".$_POST['panno']."',`agent`='".$_POST['agent']."',`outside party`='".$_POST['op']."' WHERE id=".$_POST["agent_id"]);

	}else{ 
		mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `bsi_agents`(`agent_code`, `agent_name`, `address`, `place`, `email`, `phone`, `gst`, `pan`,`agent`,`outside party`) 
		VALUES ('".$_POST['agent_code']."','".$_POST['agent_name']."',
		'".$_POST['address']."','".$_POST['agent_Place']."','".$_POST['emailid']."',
		'".$_POST['phno']."','".$_POST['gstno']."','".$_POST['panno']."','".$_POST['agent']."','".$_POST['op']."')");
	}
}

if(mysqli_affected_rows($GLOBALS["___mysqli_ston"]) > 0){
	echo "success";
}else{
	echo "failed";
}
?>