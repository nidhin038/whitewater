<?php
session_start();
include("../includes/db.conn.php");
include("../includes/conf.class.php");
$action = $bsiCore->ClearInput($_POST['loginform']);
if(isset($_REQUEST['lang'])){
$_SESSION['language1']=$_REQUEST['lang'];
}
switch($action){
	case 1: if(isset($_POST['password']) && isset($_POST['username'])){
				$username = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['username']);
				$password = $_POST['password'];
				$result   = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_admin where pass='".md5($password)."' and  username='".$username."'");
				if(mysqli_num_rows($result)){
					$row = mysqli_fetch_assoc($result);
					$_SESSION['cppassBSI']     = $row['pass'];
					$_SESSION['cpusernameBSI'] = $row['username'];
					$_SESSION['cpuidBSI']      = $row['id']; 
					$_SESSION['cpaccessidBSI'] = $row['access_id']; 
					mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_admin set last_login=CURRENT_TIMESTAMP where id=".$row['id']);
					header("location:admin-home.php");
					exit;
				}else{
					$_SESSION['msglog']="username or password is incorrect"; 
					header("location:index.php");
					exit;
				}
			}
	break;
	
	case 2: if(isset($_POST['emailid'])){
				$emailid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['emailid']);
				$result  = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_admin where email='".$emailid."'");
				if(mysqli_num_rows($result)){
					include("../includes/mail.class.php");
					$bsiMail       = new bsimail();
					$temp_password = substr(uniqid(), -6, 6);
					$row           = mysqli_fetch_assoc($result);
					
					mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_admin set pass='".md5($temp_password)."' where id=".$row['id']);
					$subject =  "Hotel Admin Panel : Your password has been reset";
                    $body    =  "Hi,<br><br>" .
								"Your new login information is: <br><br>" .
								"Username: " . $row['username'] . "<br>" .
								"Password: " . $temp_password . "<br><br>" ."Thanking You.";
					$bsiMail->sendEMail($emailid, $subject, $body);			
					$_SESSION['msg'] = "RESET";
					header("location:index.php");
					exit;
				}else{
					$_SESSION['msg'] = "Email id does not exists.";
					header("location:index.php");
					exit;
				}
			}
	break;
}
?>