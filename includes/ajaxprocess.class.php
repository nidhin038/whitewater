<?php
class ajaxProcessor
{
	public $errorMsg;
	public function sendErrorMsg(){		
		$this->errorMsg = "unknown error";	
		echo json_encode(array("errorcode"=>99,"strmsg"=>$this->errorMsg));
	}	
	
	public function getCustomerDetails(){
		global $bsiCore;
		$this->errorCode = 0;
		$this->errorMsg = "aaaaaaaaaaaa";	
		$existing_email = $bsiCore->ClearInput($_POST['existing_email']);			
		$client_sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_clients where email='".$existing_email."' limit 1");
		if(mysqli_num_rows($client_sql)){	
			$client_row=mysqli_fetch_assoc($client_sql);		
			$title_array=array("Mr.","Ms.","Mrs.","Miss.","Dr.","Prof.");
			$select_title='<select name="title" class="textbox3">';
			for($p=0; $p<6; $p++){
				if($title_array[$p]==$client_row['title']){
					$select_title.='<option value="'.$title_array[$p].'" selected="selected">'.$title_array[$p].'</option>';
				}else{
					$select_title.='<option value="'.$title_array[$p].'" >'.$title_array[$p].'</option>';
				}
			}
			$select_title.='</select>';
			echo json_encode(array("errorcode"=>$this->errorCode, "title"=>$select_title, "first_name"=>$client_row['first_name'], "surname"=>$client_row['surname'],"street_addr"=>$client_row['street_addr'],"city"=>$client_row['city'],"province"=>$client_row['province'],"zip"=>$client_row['zip'],"country"=>$client_row['country'],"phone"=>$client_row['phone'],"fax"=>$client_row['fax'],"email"=>$client_row['email'] ));							
		}else{
			$this->errorCode = 1;
			$this->errorMsg  = "Details Not Found. Please Sign up";
			echo json_encode(array("errorcode"=>$this->errorCode,"strmsg"=>$this->errorMsg));	
		}
	}
}
?>