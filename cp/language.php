<?php
$row_default_lang=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_language where `lang_default`=true"));
if(isset($_SESSION['language1']))
$langauge_selcted=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['language1']);
else
$langauge_selcted=$row_default_lang['lang_code'];

$row_visitor_lang=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_language where  lang_code='$langauge_selcted' "));
include("languages/".$row_visitor_lang['lang_file']);
?>