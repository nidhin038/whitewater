<?php
	include("../../includes/db.conn.php");
	$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `bsi_agents` WHERE 1");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$data[] = $row;
	}
	echo json_encode($data);
?>