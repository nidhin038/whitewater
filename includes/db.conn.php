<?php
define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "root");
define("MYSQL_PASSWORD", "");
define("MYSQL_DATABASE", "bm");

($GLOBALS["___mysqli_ston"] = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD)) or die ('I cannot connect to the database because 1: ' . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], constant('MYSQL_DATABASE')) or die ('I cannot connect to the database because 2: ' . mysqli_error($GLOBALS["___mysqli_ston"]));
?>