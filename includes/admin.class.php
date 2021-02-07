<?php
$bsiAdminMain = new bsiAdminCore;
class bsiAdminCore{ 
	public function carFeaturesAddEdit($fid){
		global $bsiCore;
		$feature_id = $bsiCore->ClearInput($fid);
		$car_feature = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['features_title']);
		if($fid != 0){
			  mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_car_features set features_title='".$car_feature."' where id=".$feature_id);
		}else{
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_features(features_title)values('".$car_feature."')");
		}
	}
	
	public function carLocationAddEdit($lid){
		global $bsiCore;
		$loc_id = $bsiCore->ClearInput($lid);
		$location_title = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['location_title']);
		if($loc_id != 0){
			mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_all_location set location_title='".$location_title."' where loc_id=".$loc_id);
		}else{
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_all_location(location_title)values('".$location_title."')");
		}
	}
	public function geteditFeaturesRowValue($f_id){
		global $bsiCore;
		$featuresrow=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_features where id=".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $f_id)));
		return $featuresrow;
		
	}
	
	public function geteditLocationRowValue($lid){
		global $bsiCore;
		$locationrow=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_all_location where loc_id=".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $lid)));
		return $locationrow;
		
	}
	
	public function FeaturesrowDelete($del_fid){
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_selected_features where features_id=".$del_fid);
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_car_features where id=".$del_fid);
	}
	
	public function LocationrowDelete($del_lid){
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_all_location where loc_id=".$del_lid);
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_car_location where loc_id=".$del_lid);
	}
	
	public function getAllVendorsRow(){
		 $vendorhtml='';
		 $resultqry=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_vendor");
		 if(mysqli_num_rows($resultqry)){
			 while($row = mysqli_fetch_assoc($resultqry)){
				 $vendorhtml.='<tr><td>'.$row['vendor_title'].'</td><td align="right"><a href="add_edit_vendor.php?vid='.$row['id'].'">'.CAR_VENDOR_EDIT.'</a> || <a href="javascript:;" onclick="javascript:deletevendor(\''.$row['id'].'\')">'.CAR_VENDOR_DELETE.'</a></td></tr>';	 
			 }
		 }
		 return  $vendorhtml;
	}
	
public function carTypesAddEdit($fid){
	global $bsiCore;
	$title_id = $bsiCore->ClearInput($fid);
	$car_title = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['type_title']);
	if($fid != 0){
	    mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_car_type set type_title='".$car_title."' where id=".$title_id);
	}else{
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_type(type_title)values('".$car_title."')");
	}
	
	
}
public function geteditTypesRowValue($t_id){
	global $bsiCore;
	$typesrow=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_type where id=".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $t_id)));
	return $typesrow;
	
}
public function TyperowDelete($del_tid){
	$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master where car_type_id=".$del_tid);
	if(mysqli_num_rows($result)){
		while($row = mysqli_fetch_assoc($result)){
			$this->carDelete($row['car_id']);
		}
	}//die;
	mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_car_type where id=".$del_tid);
}

public function VendorsrowDelete($del_tid){
	$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master where car_vendor_id=".$del_tid);
	if(mysqli_num_rows($result)){
		while($row = mysqli_fetch_assoc($result)){
			$this->carDelete($row['car_id']);
		}
	}//die;
	mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_car_vendor where id=".$del_tid);
}
public function carVendorsAddEdit($fid){
	global $bsiCore;
	  $vendor_id = $bsiCore->ClearInput($fid);
	 $vendor_title = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['vendor_title']);
	
	if($fid != 0){
	      mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_car_vendor set vendor_title='".$vendor_title."' where id=".$vendor_id);
	}else{
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_vendor(vendor_title)values('".$vendor_title."')");
	}
	
	
}
public function geteditVendorssRowValue($t_id){
	global $bsiCore;
	$typesrow=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_vendor where id=".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $t_id)));
	return $typesrow;
	
}
public function geteditCarRowValue($f_id){
	global $bsiCore;
	$carrow=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master where car_id=".$f_id));
	return $carrow;
	
}
public function carAddEdit($cid){
	global $bsiCore;	
	
		$cid = $bsiCore->ClearInput($cid);
		$car_type = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['car_type']);
		$car_vendor = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['car_vendor']);
		$car_model = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['car_model']);
		$car_mileage = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['car_mileage']);
		$fuel_type = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['fuel_type']);
		$status = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['status']);
		$total_car = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['total_car']);
		$pickup = $_POST['pickup'];
		$dropoff = $_POST['dropoff'];
			if($status == 'on'){
				$status=1;
			}else{
				$status=0;
			}
	if($cid != 0){
				$enable_thumbnails	= 1 ; // set 0 to disable thumbnail creation
				$max_image_size		= 1118387 ; // max image size in bytes, default 1MB
				$upload_dir			= "../gallery/"; // default script location, use relative or absolute path
				$img_type = "";
				
				
				if(isset($_POST['deleteimg'])){
					$check=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master where  car_id=".$cid));
					if($check['car_img'] !=""){
						unlink("../gallery/".$check['car_img']);
						unlink("../gallery/thumb_".$check['car_img']);
						mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_car_master set car_img='' where car_id=".$cid);
					}
					
				}
             
			if( $_FILES['car_img']['error']==0 && preg_match("#^image/#i", $_FILES['car_img']['type']) && $_FILES['car_img']['size'] < $max_image_size ){
				$img_type = ($_FILES['car_img']['type'] == "image/jpeg") ? ".jpg" : $img_type ;
				$img_type = ($_FILES['car_img']['type'] == "image/gif") ? ".gif" : $img_type ;
				$img_type = ($_FILES['car_img']['type'] == "image/png") ? ".png" : $img_type ;
                $img_rname = time().'_'.$_FILES['car_img']['name'];
				$img_path = $upload_dir.$img_rname;
				$check2 = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master where car_id=".$cid));
				if($check2['car_img'] != ""){
					unlink("../gallery/".$check2['car_img']);
					unlink("../gallery/thumb_".$check2['car_img']);
				}
				copy( $_FILES['car_img']['tmp_name'], $img_path ); 
				if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,230,110);
				 mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_car_master set car_img='".$img_rname."' where car_id=".$cid);
				
	      }
		mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_car_master set car_type_id='".$car_type."',car_vendor_id ='".$car_vendor."',car_model='".$car_model."',total_car='".$total_car."',mileage='".$car_mileage."', fuel_type='".$fuel_type."', status='".$status."' where car_id=".$cid);
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_selected_features where car_id=".$cid);
			foreach($_POST['feature'] as $val){
			  	mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_selected_features(car_id,features_id)values('".$cid."','".$val."')");
			}
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_car_location where car_id=".$cid);
		foreach($pickup as $val){
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_location values($cid, $val, 1)");
			
		}
		
		foreach($dropoff as $val){
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_location values($cid, $val, 2)");
		}
		
	}else{
		//$imgname='';
		$enable_thumbnails	= 1 ; // set 0 to disable thumbnail creation
		$max_image_size		= 1838777 ; // max image size in bytes, default 1MB
		$upload_dir			= "../gallery/"; // default script location, use relative or absolute path
		
		//echo $_FILES['car_img']['size'];die;
			$img_type = "";
		
			if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES['car_img']['type']) && $_FILES['car_img']['size'] < $max_image_size ){
				$img_type = ($_FILES['car_img']['type'] == "image/jpeg") ? ".jpg" : $img_type ;
				$img_type = ($_FILES['car_img']['type'] == "image/gif") ? ".gif" : $img_type ;
				$img_type = ($_FILES['car_img']['type'] == "image/png") ? ".png" : $img_type ;
				$img_rname = time().'_'.$_FILES['car_img']['name'];
				$img_path = $upload_dir.$img_rname;
				copy( $_FILES['car_img']['tmp_name'], $img_path ); 
				if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,230,110);
				
			}
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_master(car_type_id,car_vendor_id,car_model, total_car, mileage, fuel_type, car_img, status)values('".$car_type."','".$car_vendor."','".$car_model."', ".$total_car.", '".$car_mileage."', '".$fuel_type."', '".$img_rname."', '".$status."')");
		$car_id=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_priceplan(`car_id`,`start_date`,`end_date`, price_type, `mon`,`tue`, wed, thu, fri, sat, sun)values('".$car_id."','1900-01-01','1900-01-01','1','0.00','0.00','0.00','0.00','0.00','0.00','0.00')");
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_priceplan(`car_id`,`start_date`,`end_date`, price_type, `mon`,`tue`, wed, thu, fri, sat, sun)values('".$car_id."','1900-01-01','1900-01-01','2','0.00','0.00','0.00','0.00','0.00','0.00','0.00')");
		foreach($_POST['feature'] as $val){
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_selected_features(car_id,features_id)values('".$car_id."','".$val."')");
			
		}
		foreach($pickup as $val){
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_location values($car_id, $val, 1)");
		}
		
		foreach($dropoff as $val){
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_location values($car_id, $val, 2)");
		}
		
	}
	
	
}
private function make_thumbnails($updir, $img, $w, $h){
		    
			$thumbnail_width	= $w;
			$thumbnail_height	= $h;
			$thumb_preword		= "thumb_";
		
			$arr_image_details	= GetImageSize("$updir"."$img");
			$original_width		= $arr_image_details[0];
			$original_height	= $arr_image_details[1];
		
			if( $original_width > $original_height ){
				$new_width	= $thumbnail_width;
				$new_height	= intval($original_height*$new_width/$original_width);
			} else {
				$new_height	= $thumbnail_height;
				$new_width	= intval($original_width*$new_height/$original_height);
			}
		
			$dest_x = intval(($thumbnail_width - $new_width) / 2);
			$dest_y = intval(($thumbnail_height - $new_height) / 2);
		
		
		
			if($arr_image_details[2]==1) { $imgt = "ImageGIF"; $imgcreatefrom = "ImageCreateFromGIF";  }
			if($arr_image_details[2]==2) { $imgt = "ImageJPEG"; $imgcreatefrom = "ImageCreateFromJPEG";  }
			if($arr_image_details[2]==3) { $imgt = "ImagePNG"; $imgcreatefrom = "ImageCreateFromPNG";  }
		
		
			if( $imgt ) { 
				$old_image	= $imgcreatefrom("$updir"."$img");
				$new_image	= imagecreatetruecolor($thumbnail_width, $thumbnail_height);
				imageCopyResized($new_image,$old_image,0, 0,0,0,$w,$h,$original_width,$original_height);
				$imgt($new_image,"$updir"."$thumb_preword"."$img");
			}
		
		}
				  
		  public function global_setting(){
			global $bsiCore;
			$global_selects=array();
	
			//date format start
			$dt_format_array = array("mm/dd/yy" => "MM/DD/YYYY", "dd/mm/yy" => "DD/MM/YYYY", "mm-dd-yy" => "MM-DD-YYYY", "dd-mm-yy" => "DD-MM-YYYY", "mm.dd.yy" => "MM.DD.YYYY", "dd.mm.yy" => "DD.MM.YYYY", "yy-mm-dd" => "YYYY-MM-DD");
			$select_dt_format = "";
			foreach($dt_format_array as $key => $value){
				if($key == $bsiCore->config['conf_dateformat']){
					$select_dt_format .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
				}else{
					$select_dt_format .= '<option value="'.$key.'" >'.$value.'</option>';
				}
			}
			$global_selects['select_dt_format'] = $select_dt_format;
			//date format end
		
			$room_lock = array('200' => '2 Minute',
							   '500' => '5 Minute',
							   '1000' => '10 Minute',
							   '2000' => '20 Minute',
							   '3000' => '30 Minute');
				
			$select_room_lock="";
			foreach($room_lock as $key => $value) {
				if($key == $bsiCore->config['conf_booking_exptime']){
					$select_room_lock.='<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
				}else{
					$select_room_lock.='<option value="' . $key . '">' . $value . '</option>' . "\n";
				}
			}
			$global_selects['select_room_lock'] = $select_room_lock;
	
			//timezone_start
			$zonelist = array('Kwajalein' => '(GMT-12:00) International Date Line West',
							  'Pacific/Midway' => '(GMT-11:00) Midway Island',
							  'Pacific/Samoa' => '(GMT-11:00) Samoa',
							  'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
							  'America/Anchorage' => '(GMT-09:00) Alaska',
							  'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
							  'America/Tijuana' => '(GMT-08:00) Tijuana, Baja California',
							  'America/Denver' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
							  'America/Chihuahua' => '(GMT-07:00) Chihuahua',
							  'America/Mazatlan' => '(GMT-07:00) Mazatlan',
							  'America/Phoenix' => '(GMT-07:00) Arizona',
							  'America/Regina' => '(GMT-06:00) Saskatchewan',
							  'America/Tegucigalpa' => '(GMT-06:00) Central America',
							  'America/Chicago' => '(GMT-06:00) Central Time (US &amp; Canada)',
							  'America/Mexico_City' => '(GMT-06:00) Mexico City',
							  'America/Monterrey' => '(GMT-06:00) Monterrey',
							  'America/New_York' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
							  'America/Bogota' => '(GMT-05:00) Bogota',
							  'America/Lima' => '(GMT-05:00) Lima',
							  'America/Rio_Branco' => '(GMT-05:00) Rio Branco',
							  'America/Indiana/Indianapolis' => '(GMT-05:00) Indiana (East)',
							  'America/Caracas' => '(GMT-04:30) Caracas',
							  'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
							  'America/Manaus' => '(GMT-04:00) Manaus',
							  'America/Santiago' => '(GMT-04:00) Santiago',
							  'America/La_Paz' => '(GMT-04:00) La Paz',
							  'America/St_Johns' => '(GMT-03:30) Newfoundland',
							  'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
							  'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
							  'America/Godthab' => '(GMT-03:00) Greenland',
							  'America/Montevideo' => '(GMT-03:00) Montevideo',
							  'Atlantic/South_Georgia' => '(GMT-02:00) Mid-Atlantic',
							  'Atlantic/Azores' => '(GMT-01:00) Azores',
							  'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
							  'Europe/Dublin' => '(GMT) Dublin',
							  'Europe/Lisbon' => '(GMT) Lisbon',
							  'Europe/London' => '(GMT) London',
							  'Africa/Monrovia' => '(GMT) Monrovia',
							  'Atlantic/Reykjavik' => '(GMT) Reykjavik',
							  'Africa/Casablanca' => '(GMT) Casablanca',
							  'Europe/Belgrade' => '(GMT+01:00) Belgrade',
							  'Europe/Bratislava' => '(GMT+01:00) Bratislava',
							  'Europe/Budapest' => '(GMT+01:00) Budapest',
							  'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
							  'Europe/Prague' => '(GMT+01:00) Prague',
							  'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
							  'Europe/Skopje' => '(GMT+01:00) Skopje',
							  'Europe/Warsaw' => '(GMT+01:00) Warsaw',
							  'Europe/Zagreb' => '(GMT+01:00) Zagreb',
							  'Europe/Brussels' => '(GMT+01:00) Brussels',
							  'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
							  'Europe/Madrid' => '(GMT+01:00) Madrid',
							  'Europe/Paris' => '(GMT+01:00) Paris',
							  'Africa/Algiers' => '(GMT+01:00) West Central Africa',
							  'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
							  'Europe/Berlin' => '(GMT+01:00) Berlin',
							  'Europe/Rome' => '(GMT+01:00) Rome',
							  'Europe/Stockholm' => '(GMT+01:00) Stockholm',
							  'Europe/Vienna' => '(GMT+01:00) Vienna',
							  'Europe/Minsk' => '(GMT+02:00) Minsk',
							  'Africa/Cairo' => '(GMT+02:00) Cairo',
							  'Europe/Helsinki' => '(GMT+02:00) Helsinki',
							  'Europe/Riga' => '(GMT+02:00) Riga',
							  'Europe/Sofia' => '(GMT+02:00) Sofia',
							  'Europe/Tallinn' => '(GMT+02:00) Tallinn',
							  'Europe/Vilnius' => '(GMT+02:00) Vilnius',
							  'Europe/Athens' => '(GMT+02:00) Athens',
							  'Europe/Bucharest' => '(GMT+02:00) Bucharest',
							  'Europe/Istanbul' => '(GMT+02:00) Istanbul',
							  'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
							  'Asia/Amman' => '(GMT+02:00) Amman',
							  'Asia/Beirut' => '(GMT+02:00) Beirut',
							  'Africa/Windhoek' => '(GMT+02:00) Windhoek',
							  'Africa/Harare' => '(GMT+02:00) Harare',
							  'Asia/Kuwait' => '(GMT+03:00) Kuwait',
							  'Asia/Riyadh' => '(GMT+03:00) Riyadh',
							  'Asia/Baghdad' => '(GMT+03:00) Baghdad',
							  'Africa/Nairobi' => '(GMT+03:00) Nairobi',
							  'Asia/Tbilisi' => '(GMT+03:00) Tbilisi',
							  'Europe/Moscow' => '(GMT+03:00) Moscow',
							  'Europe/Volgograd' => '(GMT+03:00) Volgograd',
							  'Asia/Tehran' => '(GMT+03:30) Tehran',
							  'Asia/Muscat' => '(GMT+04:00) Muscat',
							  'Asia/Baku' => '(GMT+04:00) Baku',
							  'Asia/Yerevan' => '(GMT+04:00) Yerevan',
							  'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
							  'Asia/Karachi' => '(GMT+05:00) Karachi',
							  'Asia/Tashkent' => '(GMT+05:00) Tashkent',
							  'Asia/Calcutta' => '(GMT+05:30) Calcutta',
							  'Asia/Colombo' => '(GMT+05:30) Sri Jayawardenepura',
							  'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
							  'Asia/Dhaka' => '(GMT+06:00) Dhaka',
							  'Asia/Almaty' => '(GMT+06:00) Almaty',
							  'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
							  'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
							  'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
							  'Asia/Bangkok' => '(GMT+07:00) Bangkok',
							  'Asia/Jakarta' => '(GMT+07:00) Jakarta',
							  'Asia/Brunei' => '(GMT+08:00) Beijing',
							  'Asia/Chongqing' => '(GMT+08:00) Chongqing',
							  'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
							  'Asia/Urumqi' => '(GMT+08:00) Urumqi',
							  'Asia/Irkutsk' => '(GMT+08:00) Irkutsk',
							  'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
							  'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
							  'Asia/Singapore' => '(GMT+08:00) Singapore',
							  'Asia/Taipei' => '(GMT+08:00) Taipei',
							  'Australia/Perth' => '(GMT+08:00) Perth',
							  'Asia/Seoul' => '(GMT+09:00) Seoul',
							  'Asia/Tokyo' => '(GMT+09:00) Tokyo',
							  'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
							  'Australia/Darwin' => '(GMT+09:30) Darwin',
							  'Australia/Adelaide' => '(GMT+09:30) Adelaide',
							  'Australia/Canberra' => '(GMT+10:00) Canberra',
							  'Australia/Melbourne' => '(GMT+10:00) Melbourne',
							  'Australia/Sydney' => '(GMT+10:00) Sydney',
							  'Australia/Brisbane' => '(GMT+10:00) Brisbane',
							  'Australia/Hobart' => '(GMT+10:00) Hobart',
							  'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
							  'Pacific/Guam' => '(GMT+10:00) Guam',
							  'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
							  'Asia/Magadan' => '(GMT+11:00) Magadan',
							  'Pacific/Fiji' => '(GMT+12:00) Fiji',
							  'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
							  'Pacific/Auckland' => '(GMT+12:00) Auckland',
							  'Pacific/Tongatapu' => '(GMT+13:00) Nukualofa');
				
			$select_timezone="";
			foreach($zonelist as $key => $value) {
				if($key == $bsiCore->config['conf_portal_timezone']){
					$select_timezone.='		<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
				}else{
					$select_timezone.='		<option value="' . $key . '">' . $value . '</option>' . "\n";
				}
			}
			$global_selects['select_timezone']=$select_timezone;
			
			//car block inteval
			
			$carblocklist = array(
							  '00:29:59' => '30 Minutes',
							  '00:59:59' => '1 Hour',
							  '01:59:59' => '2 Hours',
							  '02:59:59' => '3 Hours',
							  '03:59:59' => '4 Hours',
							  '04:59:59' => '5 Hours',
							  '05:59:59' => '6 Hours',
							  '06:59:59' => '7 Hours',
							  '07:59:59' => '8 Hours',
							  '08:59:59' => '9 Hours',
							  '09:59:59' => '10 Hours',
							  '10:59:59' => '11 Hours',
							  '11:59:59' => '12 Hours',
							  '12:59:59' => '13 Hours',
							  '13:59:59' => '14 Hours',
							  '14:59:59' => '15 Hours',
							  '15:59:59' => '16 Hours',
							  '16:59:59' => '17 Hours',
							  '17:59:59' => '18 Hours',
							  '18:59:59' => '19 Hours',
							  '19:59:59' => '20 Hours',
							  '20:59:59' => '21 Hours',
							  '23:59:59' => '22 Hours',
							  '22:59:59' => '23 Hours',
							  '23:59:59' => '24 Hours'
							  );
				
			$select_list="";
			foreach($carblocklist as $key => $value) {
				if($key == $bsiCore->config['conf_interval_between_rent']){
					$select_list.='		<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
				}else{
					$select_list.='		<option value="' . $key . '">' . $value . '</option>' . "\n";
				}
			}
			$global_selects['select_blockinterval']=$select_list;
			
			$select_conf_booking_start="";
			for($i20=0; $i20 <= 30; $i20++){
				if($i20 == $bsiCore->config['conf_booking_start'])
				$select_conf_booking_start.='<option value="'.$i20.'" selected="selected">'.$i20.' Day(s)</option>';
				else
				$select_conf_booking_start.='<option value="'.$i20.'">'.$i20.' Day(s)</option>';
			}
			$global_selects['select_conf_booking_start']=$select_conf_booking_start;
		 
			 if($bsiCore->config['conf_booking_turn_off']==0){
				 $select_booking_turn  ='<option value="0" selected="selected">Turn On</option>' . "\n";
				 $select_booking_turn .='<option value="1">Turn Off</option>' . "\n";
			 }else{
				 $select_booking_turn  ='<option value="1" selected="selected">Turn Off</option>' . "\n";
				 $select_booking_turn .='<option value="0">Turn On</option>' . "\n";
			 }
			 $global_selects['select_booking_turn']=$select_booking_turn;
		 
			 $select_min_booking="";
			 for($k=1; $k<11; $k++){
				if($bsiCore->config['conf_min_night_booking']==$k){
					$select_min_booking.='		<option value="' . $k . '" selected="selected">' . $k . '</option>' . "\n";
				}else{
					$select_min_booking.='		<option value="' . $k . '">' . $k . '</option>' . "\n";
				}
			 }
			$global_selects['select_min_booking'] = $select_min_booking;
			return $global_selects;
		}
		
		public function global_setting_post(){
			global $bsiCore;
			$this->configure_update('conf_portal_name', $bsiCore->ClearInput($_POST['conf_portal_name']));
			$this->configure_update('conf_portal_streetaddr', $bsiCore->ClearInput($_POST['conf_portal_streetaddr']));
			$this->configure_update('conf_portal_city', $bsiCore->ClearInput($_POST['conf_portal_city']));
			$this->configure_update('conf_portal_state', $bsiCore->ClearInput($_POST['conf_portal_state']));
			$this->configure_update('conf_portal_country', $bsiCore->ClearInput($_POST['conf_portal_country']));
			$this->configure_update('conf_portal_zipcode', $bsiCore->ClearInput($_POST['conf_portal_zipcode']));
			$this->configure_update('conf_portal_phone', $bsiCore->ClearInput($_POST['conf_portal_phone']));
			$this->configure_update('conf_portal_fax', $bsiCore->ClearInput($_POST['conf_portal_fax']));
			$this->configure_update('conf_portal_email', $bsiCore->ClearInput($_POST['conf_portal_email'])); 	
			$this->configure_update('conf_currency_symbol',  htmlentities(mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['conf_currency_symbol']),ENT_COMPAT,'utf-8'));
			$this->configure_update('conf_currency_code', $bsiCore->ClearInput($_POST['conf_currency_code']));
			$this->configure_update('conf_mesurment_unit', $bsiCore->ClearInput($_POST['conf_mesurment_unit']));
			$this->configure_update('conf_tax_amount', $bsiCore->ClearInput($_POST['conf_tax_amount']));
			$this->configure_update('conf_dateformat', $bsiCore->ClearInput($_POST['conf_dateformat']));
			$this->configure_update('conf_booking_exptime', $bsiCore->ClearInput($_POST['conf_booking_exptime']));
			$this->configure_update('conf_portal_timezone', $bsiCore->ClearInput($_POST['conf_portal_timezone']));
			$this->configure_update('conf_booking_turn_off', $bsiCore->ClearInput($_POST['select_booking_turn']));
			$this->configure_update('conf_min_night_booking', $bsiCore->ClearInput($_POST['conf_min_night_booking']));
			$this->configure_update('conf_server_os', $bsiCore->ClearInput($_POST['conf_server_os']));
			$this->configure_update('conf_notification_email', $bsiCore->ClearInput($_POST['conf_notification_email']));
			
			$this->configure_update('conf_interval_between_rent', $bsiCore->ClearInput($_POST['conf_interval_between_rent']));
			$this->configure_update('conf_booking_start', $bsiCore->ClearInput($_POST['conf_booking_start']));
		}
	
	
		private function configure_update($key, $value){
			mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_configure set conf_value='".$value."' where conf_key='".$key."'");
		}
		
		public function generateOption($val=0){
			$htmlOption = '';
			$arr = array(0 => "No", 1 => "Yes");
			foreach($arr as $key => $value){
				if($val == $key){
					$htmlOption .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
				}else{
					$htmlOption .= '<option value="'.$key.'">'.$value.'</option>';	
				}
			}
			return $htmlOption;
		}
		
		public function payment_gateway(){
			$gateway_value=array();
			$pp_row  = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_payment_gateway where gateway_code='pp'"));
			$poa_row = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_payment_gateway where gateway_code='poa'"));
			$gateway_value['pp_enabled'] = $pp_row['enabled'];
			$gateway_value['pp_gateway_name'] =$pp_row['gateway_name'];
			$gateway_value['pp_account'] = $pp_row['account'];
			$gateway_value['poa_enabled']=$poa_row['enabled'];
			$gateway_value['poa_gateway_name']=$poa_row['gateway_name'];		
			return $gateway_value;
		}
		
		public function payment_gateway_post(){
			global $bsiCore;
			$pp = ((isset($_POST['pp'])) ? 1 : 0);
			$pp_title  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['pp_title']);
			$paypal_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['paypal_id']);
			$poa = ((isset($_POST['poa'])) ? 1 : 0);
			$poa_title = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['poa_title']);		
			mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_payment_gateway set gateway_name='$pp_title', account='$paypal_id', enabled=$pp where gateway_code='pp'");
			mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_payment_gateway set gateway_name='$poa_title',  enabled=$poa where gateway_code='poa'");
		}
		
		public function updateEmailContent(){	
		   global $bsiCore;
		   $emailsub=$bsiCore->ClearInput($_POST['email_sub']);
		   $emailcon=$bsiCore->ClearInput($_POST['email_con']);
		   $mailid=$bsiCore->ClearInput($_POST['c_update']);
		   mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_email_contents set email_subject='".$emailsub."',email_text='".$emailcon."' where id='".$mailid."'");	
		}
		
		public function getEmailContents(){
			global $bsiCore;
			$dropList='<option value="0" selected="selected">---- '.EMAIL_CONTENTS_SELECT_EMAIL_TYPE.' ----</option>';
			$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_email_contents");
			while($rowemailinfo=mysqli_fetch_assoc($sql)){
				$dropList.='<option value="'.$rowemailinfo['id'].'">'.$rowemailinfo['email_name'].'</option>';
			}
			return $dropList;
		}
		
		public function showAllFeatures($cid=0){
			$str = '';
			$html = '<table width="100%"><tr>';
			$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_features order by features_title");
			if(mysqli_num_rows($result)){
				$i = 0;			
				while($row = mysqli_fetch_assoc($result)){
					$resultfea = mysqli_query($GLOBALS["___mysqli_ston"], "select features_id from bsi_selected_features where car_id=".$cid." and features_id=".$row['id']);
					if(mysqli_num_rows($resultfea)){
						$rowfea = mysqli_fetch_assoc($resultfea);
							if($rowfea['features_id'] == $row['id']){
								$str='checked="checked"';
								$html .= '<td><input type="checkbox" '.$str.' name="feature[]" value="'.$row['id'].'" '.$str.' /><span> '.$row['features_title'].'</span></td>';
							}
					}else{
						$str='';
						$html .= '<td><input type="checkbox" '.$str.' name="feature[]" value="'.$row['id'].'" '.$str.' /><span> '.$row['features_title'].'</span></td>';
					}
					
					$i++;
					if($i == 2){
						$html .= '</tr><tr>';
						$i = 0;
					}	
				  }
			}
			$html .= '</tr></table>';
			return $html;
		}
		
	public function geteditDepositRowValue($depo_id){
				global $bsiCore;
				$depositrow=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_deposit_duration where id=".$depo_id));
				return $depositrow;
	     }
		 
	public function addeditDeposit(){
		     global $bsiCore;
			 $depo_id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['depo_id']);
			 $day_from=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['day_from']);
			 $day_to=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['day_to']);
			 $deposit_percent=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['deposit_percent']);
			 if($depo_id != 0){
				  $_SESSION['msg']='<font color="#006600">'.UPDATE_SUCCESS_TEXT.'</font>';
				 mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_deposit_duration set day_from='".$day_from."',day_to='".$day_to."',deposit_percent='".$deposit_percent."' where id=".$depo_id);
				 header("location:deposit-duration.php");
				 
			 }else{
				 $dayfromvaluecheck=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_deposit_duration where ('".$day_from."' between day_from and day_to or '".$day_to."' between day_from and day_to)");
				 if(mysqli_num_rows($dayfromvaluecheck)){
					 $_SESSION['msg']='<font color="#FF0000">'.DAY_FROM_AND_DAY_TO_EXISTS_TEXT.'</font>';
					 header("location:deposit-duration.php");
					 
				 }else{
					 $_SESSION['msg']='<font color="#006600">'.INSERT_SUCCESS_TEXT.'</font>';
					 mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_deposit_duration(day_from,day_to,deposit_percent)values('".$day_from."','".$day_to."','".$deposit_percent."')");
					 header("location:deposit-duration.php");
					 
				 }
				 
			 }
		
	}
	
	public function depositDelete($del_tid){
		      global $bsiCore;
			  mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_deposit_duration where id=".$bsiCore->ClearInput($del_tid));
          }
		  
		  public function geteditDiscountRowValue($discou_id){
				global $bsiCore;
				$discountrow=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_discount_duration where id=".$discou_id));
				return $discountrow;
	     }
      
	  public function addeditDiscount(){
		     global $bsiCore;
			 $disco_id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['disco_id']);
			 $day_from=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['day_from']);
			 $day_to=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['day_to']);
			 $discount_percent=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['discount_percent']);
			 if($disco_id != 0){
				  $_SESSION['msg1']='<font color="#006600">'.UPDATE_SUCCESS_TEXT.'</font>';
				 mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_discount_duration set day_from='".$day_from."',day_to='".$day_to."',discount_percent='".$discount_percent."' where id=".$disco_id);
				 header("location:discount-duration.php");
				 
			 }else{
				 $dayfromvaluecheck=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_discount_duration where ('".$day_from."' between day_from and day_to or '".$day_to."' between day_from and day_to)");
				 if(mysqli_num_rows($dayfromvaluecheck)){
					 $_SESSION['msg1']='<font color="#FF0000">'.DAY_FROM_AND_DAY_TO_EXISTS_TEXT.'</font>';
					 header("location:discount-duration.php");
					 
				 }else{
					 $_SESSION['msg1']='<font color="#006600">'.INSERT_SUCCESS_TEXT.'</font>';
					 mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_discount_duration(day_from,day_to,discount_percent)values('".$day_from."','".$day_to."','".$discount_percent."')");
					 header("location:discount-duration.php");
					 
				 }
				 
			 }
		
	}
	
	public function discountDelete($del_tid){
		      global $bsiCore;




			  mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_discount_duration where id=".$bsiCore->ClearInput($del_tid));
          }
		  
	  public function geteditableextrasRowValue($extra_id){
			global $bsiCore;
			$extrarow=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_extras where id=".$extra_id));
			return $extrarow;
	 }
	 
	  public function addeditExtras(){
		     global $bsiCore;
			 $extra_id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['extra_id']);
			 $car_extras=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['car_extras']);
			 $price=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['price']);
			 if($extra_id != 0){
				 mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_car_extras set car_extras='".$car_extras."',price='".$price."' where id=".$extra_id);
				 
			 }else{
				
					 mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_car_extras(car_extras,price)values('".$car_extras."','".$price."')");
			 }
	   }
	   
	   public function extrasDelete($del_tid){
		      global $bsiCore;
			  mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_car_extras where id=".$bsiCore->ClearInput($del_tid));
          }
		  
 	public function getCarBlockDetails(){
		global $bsiCore;
		
		$getHtml='<tbody>';
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT bb.booking_id,bb.pick_loc,bb.drop_loc, brd.car_id, bb.block_name, DATE_FORMAT(bb.pickup_datetime, '".$bsiCore->userDateFormat." %r') AS StartDate, DATE_FORMAT(bb.dropoff_datetime, '".$bsiCore->userDateFormat." %r') AS EndDate from bsi_bookings bb, bsi_res_data brd where bb.booking_id=brd.booking_id and bb.is_block=1");
			if(mysqli_num_rows($result)){
				while($row=mysqli_fetch_assoc($result)){
					$getcarmaster = $bsiCore->getCarMaster($row['car_id']);
					$getcartype   = $bsiCore->getCarType($getcarmaster['car_type_id']);
					$getcarvendor = $bsiCore->getCarVendor($getcarmaster['car_vendor_id']);				
					$getHtml.='<tr><td align="left">'.$row['block_name'].'</td><td>'.$getcartype.'</td><td>'.$getcarvendor.'</td><td>'.$getcarmaster['car_model'].'</td><td>'.$row['StartDate']." ".TO_TEXT." ".$row['EndDate'].'</td><td>'.$row['pick_loc'].'</td><td>'.$row['drop_loc'].'</td><td align="right"><a href="'.$_SERVER['PHP_SELF'].'?action=unblock&bid='.$row['booking_id'].'">'.CAR_BLOCKING_UN_BLOCK.'</a></td></tr>';
				}
			}
		$getHtml .= '<tbody>';
		return $getHtml;
	}
	
	public function getBookingInfo($info , $clientid=0, $condition=""){
		global $bsiCore;
		switch($info){
			case 1:
			$sql = "SELECT booking_id, DATE_FORMAT(pickup_datetime, '".$bsiCore->userDateFormat." %r') AS start_date, DATE_FORMAT(dropoff_datetime, '".$bsiCore->userDateFormat." %r') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat." %r') AS booking_time, payment_type, client_id  FROM bsi_bookings where payment_success=true and NOW() <= dropoff_datetime and is_deleted=false  and is_block=false  ".$condition." ";
			break;
		
			case 2:
			$sql = "SELECT booking_id, DATE_FORMAT(pickup_datetime, '".$bsiCore->userDateFormat." %r') AS start_date, DATE_FORMAT(dropoff_datetime, '".$bsiCore->userDateFormat." %r') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat." %r') AS booking_time, payment_type, client_id, is_deleted  FROM bsi_bookings where payment_success=true and (NOW() > dropoff_datetime OR is_deleted=true)  and is_block=false  ".$condition."";
			break;
			
			case 3:
			$sql = "SELECT booking_id, DATE_FORMAT(pickup_datetime, '".$bsiCore->userDateFormat." %r') AS start_date, DATE_FORMAT(dropoff_datetime, '".$bsiCore->userDateFormat." %r') AS end_date, dropoff_datetime as checkout, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat." %r') AS booking_time, payment_type, is_deleted, is_block  FROM bsi_bookings where payment_success=true and client_id=".$clientid." order by pickup_datetime";
			break;
		
		}
		return $sql;
	 }
	 
	 public function getBookingDetailsHtml($type=0,$query){
		global $bsiCore;
		$clientArr = array();
		if($type == 1){
			$html = '<thead>
						  <tr>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_BOOKING_ID.'</th>
							<th width="15%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_NAME.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_PICK_UP_DATE_TIME.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_DROP_OFF_DATE_TIME.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_AMOUNT.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_BOOKING_DATE.'</th>
							<th width="30%" nowrap>&nbsp;</th>
						   </tr>
					  </thead>
					  <tbody>';
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
			while($row = mysqli_fetch_assoc($result)){
				$clientArr = $this->getClientInfo($row['client_id']);
				$html .= '<tr>
							<td width="10%" nowrap>'.$row['booking_id'].'</td>
							<td width="15%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
							<td width="10%" nowrap>'.$row['start_date'].'</td>
							<td width="10%" nowrap>'.$row['end_date'].'</td>
							<td width="10%" nowrap>'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
							<td width="10%" nowrap>'.$row['booking_time'].'</td>
							<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap">
								<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'">'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_VIEW_DETAILS.'</a> | 
								<a href="javascript:;" onClick="javascript:myPopup2(\''.$row['booking_id'].'\');">'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_PRINT_VOUCHER.'</a> |  
								<a href="javascript:;" onClick="return cancel(\''.$row['booking_id'].'\');">'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_CANCEL.'</a>
							</td>
						  </tr>';
			}
		}
		if($type == 2){
			$html = '<thead>
						  <th width="10%" nowrap><strong>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_BOOKING_ID.'</strong></th>
						  <th width="15%" nowrap><strong>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_NAME.'</strong></th>
						  <th width="10%" nowrap><strong>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_PICK_UP_DATE_TIME.'</strong></th>
						  <th width="10%" nowrap><strong>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_DROP_OFF_DATE_TIME.'</strong></th>
						  <th width="10%" nowrap><strong>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_AMOUNT.'</strong></th>
						  <th width="10%" nowrap><strong>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_BOOKING_DATE.'</strong></th>
						  <th width="30%" nowrap>&nbsp;</th>
					  </thead>
					  <tbody>';
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
			if(mysqli_num_rows($result)){
				while($row = mysqli_fetch_assoc($result)){
					$clientArr = $this->getClientInfo($row['client_id']);
					$html .= '<tr>
								<td width="10%" nowrap>'.$row['booking_id'].'</td>
								<td width="15%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
								<td width="10%" nowrap>'.$row['start_date'].'</td>
								<td width="10%" nowrap>'.$row['end_date'].'</td>
								<td width="10%" nowrap>'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
								<td width="10%" nowrap>'.$row['booking_time'].'</td>
								<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap">
									<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'">'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_VIEW_DETAILS.'</a> | 
									<a href="javascript:;" onclick="myPopup2(\''.$row['booking_id'].'\');">'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_PRINT_VOUCHER.'</a> |  
									<a href="javascript:;" onclick="return deleteBooking(\''.$row['booking_id'].'\');">'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_DELETE.'</a>
								</td>
							  </tr>';
				}
			}
		}
		$html .= '</tbody>'; 
		return $html;
	 }
	 
	 public function getClientInfo($client_id){
		$row=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_clients where client_id=".$client_id));
		return $row;
	 }
	 
	 public function paymentDetails($gateway, $bookingid){
		global $bsiCore;
		$paymentgateway = $this->getPayment_Gateway($gateway);
		$invoice = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_invoice where booking_id=".$bookingid)); 
		return $invoice['invoice'];
	}
	
	public function getPayment_Gateway($pg){
		$row = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select gateway_name from bsi_payment_gateway where gateway_code='".$pg."'"));	
		return $row['gateway_name'];
	}
	
	public function booking_cencel_delete($type){
		global $bsiCore;
		global $bsiMail;
		switch($type){
			case 1:
				$bsiMail = new bsiMail();
				$is_cancel = mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_bookings set is_deleted=true where booking_id=".$bsiCore->ClearInput($_GET['cancel']));
				if($is_cancel){
					$cust_details = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_invoice where booking_id=".$bsiCore->ClearInput($_GET['cancel'])));
					$email_details    = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_email_contents where id=2"));
					$cancel_emailBody = "Dear ".$cust_details['client_name']."<br>";
					$cancel_emailBody .= html_entity_decode($email_details['email_text'])."<br>";
					$cancel_emailBody .= "<b>Your Booking Details:</b><br>".$cust_details['invoice']."<br>";
					$cancel_emailBody .= "<b>Regards</b><br>".$bsiCore->config['conf_hotel_name']."<BR>".$bsiCore->config['conf_hotel_phone']."<br>";
					$bsiMail->sendEMail($cust_details['client_email'], $email_details['email_subject'], $cancel_emailBody);
				}
			break;
			
			case 2:
				mysqli_query($GLOBALS["___mysqli_ston"], "delete from  bsi_bookings where booking_id=".$bsiCore->ClearInput($_REQUEST['delete']));
				mysqli_query($GLOBALS["___mysqli_ston"], "delete from  bsi_invoice where booking_id=".$bsiCore->ClearInput($_REQUEST['delete']));
			break;
		
		}	
	}
	
	public function getCustomerHtml(){
		$html = '';
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_clients where existing_client=true");
		while($row = mysqli_fetch_assoc($result)){
			$html .= '<tr><td width="20%" nowrap="nowrap">'.$row['title']." ".$row['first_name']." ".$row['surname'].'</td><td width="30%">'.$row['street_addr'].",".$row['city'].",".$row['country']." - ".$row['zip'].'</td><td width="10%">'.$row['phone'].'</td><td width="25%">'.$row['email'].'</td><td width="15%" align="right" nowrap="nowrap"><a href="customerbooking.php?client='.base64_encode($row['client_id']).'">'.VIEW_BOOKINGS.'</a>&nbsp;&nbsp;<a href="customerlookupEdit.php?update='.base64_encode($row['client_id']).'">'.CUSTOMER_LOOKUP_EDIT.'</a></td></tr>';
		}
		return $html;
	}
	
	public function fetchClientBookingDetails($clientid){
		global $bsiCore;
		$html = '<tbody>';
		$arr['clientName'] = '';
	  	$result = $this->getBookingInfo(3, $clientid);
		$res = mysqli_query($GLOBALS["___mysqli_ston"], $result);
		$curTime = time();
		$client_info = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_clients where client_id=".$clientid));
      	while($row =  mysqli_fetch_assoc($res)){
			$dropoffTime = strtotime($row['checkout']);
			if($dropoffTime >= $curTime && $row['is_deleted'] == 0 && $row['is_block'] == 0){
				$status = '<font color="#00CC00"><b>'.CUSTOMERBOOKING_ACTIVE.'</b></font>';	
				$action = '<a href="javascript:;" onClick="return cancel(\''.$row['booking_id'].'\');">'.CANCEL_BOOKING.'</a>';
				$type   = 1;
			}elseif($dropoffTime < $curTime && $row['is_deleted'] == 0 && $row['is_block'] == 0){
				$status = '<font color="#0033FF"><b>'.DEPARTED.'</b></font>';	
				$action = '<a href="javascript:;" onclick="javascript:booking_delete('.$row['booking_id'].');" class="bodytext">'.DELETE_FOREVER.'</a>';
				$type   = 2;
			}else{
				$status = '<font color="#FF0000"><b>'.CANCELLED.'</b></font>';
				$type   = 2;
				$action = '<a href="javascript:;" onclick="javascript:booking_delete('.$row['booking_id'].');" class="bodytext">'.DELETE_FOREVER.'</a>';
			}
			  $html .= '<tr class="gradeX">
				<td align="right">'.$row['booking_id'].'</td>
				<td align="left" nowrap="nowrap">'.$row['start_date'].'</td>
				<td align="left" nowrap="nowrap">'.$row['end_date'].'</td>
				<td align="left">'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
				<td align="left" nowrap="nowrap">'.$row['booking_time'].'</td>
				<td align="left">'.$status.'</td>
				<td align="right" nowrap="nowrap"><a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'"" class="bodytext">'.CUSTOMERBOOKING_VIEW_DETAILS.'</a>&nbsp;&nbsp;<a  href="javascript:;" onclick="javascript:myPopup2('.$row['booking_id'].');" class="bodytext">'.PRINT_VOUCHER.'</a>&nbsp;&nbsp;'.$action.'</td>
			  </tr>';
       }
	   $html .= '</tbody>';	
	   $arr['html'] = $html;
	   $arr['clientName'] = $client_info['title']." ". $client_info['first_name']." ".$client_info['surname'];
	   return $arr;
	}
	
	public function getCustomerLookup($cid){
		global $bsiCore;
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_clients where client_id=".$bsiCore->ClearInput($cid));
		$customerarray=mysqli_fetch_assoc($result);
		return $customerarray;
	}
	
	public function getTitle($title){
		$html  = '<select name="titled" id="titled">';
		$titleArray =array("Mr" => "Mr.", "Mrs" => "Mrs.", "Ms" => "Ms.", "Dr" => "Dr.", "Miss" => "Miss.", "Prof" => "Prof.");
		foreach($titleArray as $key => $value){
			if($title == $key){
				$html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
			}else{
				$html .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		$html .= '</select>'; 
		return $html; 
	}
	
	public function updateCustomerLookup(){
		$title = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['titled']);
		$fname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['fname']);
		$sname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['sname']);
		$sadd = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['sadd']);
		$city = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['city']);
		$province = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['province']);
		$zip = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['zip']);
		$country = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['country']);
		$phone = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['phone']);
		$fax = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['fax']);
		$email = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['email']);
		$cid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cid']);
		mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_clients set first_name='".$fname."',surname='".$sname."',title='".$title."',street_addr='".$sadd."',city='".$city."',province='".$province."',zip='".$zip."',country='".$country."',phone='".$phone."',fax='".$fax."',email='".$email."' where client_id=".$cid);	
		$_SESSION['httpRefferer'] = $_POST['httpreffer'];
	}
	
	public function changePassword(){
		global $bsiCore;
		$oldpass = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['old_pass']);
		$newpass = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['new_pass']);  
		$adminid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['cpuidBSI']);
		$result  = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_admin where pass=\"" . md5($oldpass) . "\" and id=".$adminid);
		if(@mysqli_num_rows($result)){
			mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_admin set pass='".md5($newpass)."' where id=".$adminid);
			$_SESSION['chngmsg'] = 'Password changed successfuly';
		}else{
			$_SESSION['chngmsg'] = 'Password do not matched.';
		}	

	}
	
	public function getAllTypesRow(){
		$typeshtml='';
		$resultqry=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_type");
		if(mysqli_num_rows($resultqry)){
			while($row = mysqli_fetch_assoc($resultqry)){
				$typeshtml.='<tr><td>'.$row['type_title'].'</td><td align="right"><a href="add_edit_type.php?tid='.$row['id'].'">'.CAR_TYPES_EDIT.'</a> || <a href="javascript:;" onclick="javascript:deletecartpe(\''.$row['id'].'\')">'.CAR_TYPES_DELETE.'</a></td></tr>';	 
			}
		}
		return  $typeshtml;
	}
	
	public function getAllFeaturesRow(){
		$featureshtml='';
		$resultqry = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_features");
		if(mysqli_num_rows($resultqry)){
			while($row = mysqli_fetch_assoc($resultqry)){
				$featureshtml.='<tr><td>'.$row['features_title'].'</td><td align="right"><a href="add_edit_feature.php?fid='.$row['id'].'">'.CAR_FEATURS_EDIT.'</a> || <a href="javascript:;" onclick="javascript:deletecarfaci(\''.$row['id'].'\')">'.CAR_FEATURS_DELETE.'</a></td></tr>';	 
			}
		}
		return  $featureshtml;
	}
	
	public function getAllLocationRow(){
		$featureshtml='';
		$resultqry = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_all_location");
		if(mysqli_num_rows($resultqry)){
			while($row = mysqli_fetch_assoc($resultqry)){

				$featureshtml.='<tr><td>'.$row['location_title'].'</td><td align="right"><a href="location_add_edit.php?lid='.$row['loc_id'].'">'.EDIT_TEXT.'</a> || <a href="javascript:;" onclick="javascript:deleteloc(\''.$row['loc_id'].'\')">'.DELETE_TEXT.'</a></td></tr>';	 
			}
		}
		return  $featureshtml;
	}
	
	public function getAllCardetailsRow(){
		global $bsiCore;
		 $carlist='';
		 $resultqry=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master");
		 if(mysqli_num_rows($resultqry)){
			 $status='';
		 	 while($row = mysqli_fetch_assoc($resultqry)){
			     if($row['status'] == 1){
				 	$status=ENABLED;
			 	 }else{
				 	$status=DISABLED; 
			 	 }
			     $getcartype=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_type where id=".$row['car_type_id']));
			     $getvendor=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_vendor where id=".$row['car_vendor_id']));
			     $carlist.='<tr><td>'.$row['car_id'].'</td><td>'.$getcartype['type_title'].'</td><td>'.$getvendor['vendor_title'].'</td><td>'.$row['car_model'].'</td><td>'.$row['total_car'].'</td><td>'.$row['fuel_type'].'</td><td>'.$status.'</td><td align="right"><a href="add_edit_car.php?cid='.$row['car_id'].'">'.CAR_LIST_EDIT.'</a> || <a href="javascript:;" onclick="javascript:deletecarmas(\''.$row['car_id'].'\')">'.CAR_LIST_DELETE.'</a></td></tr>';
			 }
		 }
		 return  $carlist;
	}
	
	public function carDelete($del_tid){
		$check = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master where car_id=".$del_tid));
		if($check['car_img'] !=""){
			unlink("../gallery/".$check['car_img']);
			unlink("../gallery/thumb_".$check['car_img']);
		}
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_res_data where car_id=".$check['car_id']);
		if(mysqli_num_rows($result)){
			while($row = mysqli_fetch_assoc($result)){
				mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_bookings where booking_id=".$row['booking_id']);
			}
		}
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_res_data where car_id=".$check['car_id']);
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_car_master where car_id=".$del_tid);
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_car_priceplan where car_id=".$del_tid);
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_selected_features where car_id=".$del_tid);
	}
	
	
	
	public function priceCalculation(){
		//date format start
		global $bsiCore;
			$price_array = array("1" => PRICE_CALCULATION_DAILY, "2" => PRICE_CALCULATION_HOURLY, "3" => DAILY_AND_HOURLY_COMBINED);
			$select_priceplan= "";
			foreach($price_array as $key => $value){
				if($key == $bsiCore->config['conf_price_calculation_type']){
					$select_priceplan .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
				}else{
					$select_priceplan .= '<option value="'.$key.'" >'.$value.'</option>';
				}
			}
			return $select_priceplan;
	}
	
	public function priceCalculationSave(){
		//date format start
		global $bsiCore;
		$this->configure_update('conf_price_calculation_type', $bsiCore->ClearInput($_POST['pp_setting']));
		
	}
	
	public function getPickupLocation($car_id=0){
		$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_all_location order by location_title");
		$selectPickup="";
		while($row=mysqli_fetch_assoc($sql)){
			$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_location where car_id=".$car_id." and loc_type=1 and loc_id=".$row['loc_id']);
			if(mysqli_num_rows($sql2))
			$selectPickup.='<option value="'.$row['loc_id'].'" selected="selected">'.$row['location_title'].'</option>';
			else
			$selectPickup.='<option value="'.$row['loc_id'].'" >'.$row['location_title'].'</option>';
		}
		return $selectPickup;
	}
	
	public function getDropoffLocation($car_id=0){
		$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_all_location order by location_title");
		$selectDropoff="";
		while($row=mysqli_fetch_assoc($sql)){
			$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_location where car_id=".$car_id." and loc_type=2 and loc_id=".$row['loc_id']);
			if(mysqli_num_rows($sql2))
			$selectDropoff.='<option value="'.$row['loc_id'].'" selected="selected">'.$row['location_title'].'</option>';
			else
			$selectDropoff.='<option value="'.$row['loc_id'].'" >'.$row['location_title'].'</option>';
		}
		return $selectDropoff;
	}
	
	public function showPricecontrol(){
		 global $bsiCore;
		 $pricecontrollist='';
		 $result=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date,price_control FROM bsi_price_control"); 
		 if(mysqli_num_rows($result)){
			 while($row=mysqli_fetch_assoc($result)){
				  $pricecontrollist.='<tr><td align="left">'.$row['start_date'].'</td><td align="left">'.$row['end_date'].'</td><td align="left">'.$row['price_control'].'</td></tr>';
				 
			 }
			 
		 }
		 return  $pricecontrollist;
			
		}
		
		public function homewidget($type){
			global $bsiCore;
			if($type==1){
				$sql = "SELECT booking_id, DATE_FORMAT(pickup_datetime, '".$bsiCore->userDateFormat." %r') AS start_date, DATE_FORMAT(dropoff_datetime, '".$bsiCore->userDateFormat." %r') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat." %r') AS booking_time, payment_type, client_id  FROM bsi_bookings where payment_success=true and is_block=false and DATE_FORMAT(booking_time, '%Y-%m-%d')=CURDATE()";
			}else if($type==2){
				$sql = "SELECT booking_id, DATE_FORMAT(pickup_datetime, '".$bsiCore->userDateFormat." %r') AS start_date, DATE_FORMAT(dropoff_datetime, '".$bsiCore->userDateFormat." %r') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat." %r') AS booking_time, payment_type, client_id  FROM bsi_bookings where payment_success=true and is_block=false and DATE_FORMAT(pickup_datetime, '%Y-%m-%d')=CURDATE()";
			}else if($type==3){
				$sql = "SELECT booking_id, DATE_FORMAT(pickup_datetime, '".$bsiCore->userDateFormat." %r') AS start_date, DATE_FORMAT(dropoff_datetime, '".$bsiCore->userDateFormat." %r') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat." %r') AS booking_time, payment_type, client_id  FROM bsi_bookings where payment_success=true and is_block=false  and DATE_FORMAT(dropoff_datetime, '%Y-%m-%d')=CURDATE()";
			}
			
			$html = '<thead>
						  <tr>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_BOOKING_ID.'</th>
							<th width="15%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_NAME.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_PICK_UP_DATE_TIME.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_DROP_OFF_DATE_TIME.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_AMOUNT.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_BOOKING_DATE.'</th>
							<th width="30%" nowrap>&nbsp;</th>
						   </tr>
					  </thead>
					  <tbody>';
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
			while($row = mysqli_fetch_assoc($result)){
				$clientArr = $this->getClientInfo($row['client_id']);
				$html .= '<tr>
							<td width="10%" nowrap>'.$row['booking_id'].'</td>
							<td width="15%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
							<td width="10%" nowrap>'.$row['start_date'].'</td>
							<td width="10%" nowrap>'.$row['end_date'].'</td>
							<td width="10%" nowrap>'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
							<td width="10%" nowrap>'.$row['booking_time'].'</td>
							<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap">
								<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type=1">'.VIEW_ACTIVE_OR_ARCHIEVE_BOOKINGS_VIEW_DETAILS.'</a>  
								
							</td>
						  </tr>';
				}
		
		 return $html;	
		}
		
		public function generateLanguageListHtml(){
		$clhtml	= '<tbody>';
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_language");
		while($row = mysqli_fetch_assoc($result)){
			$dflt=($row['lang_default'])? 'Yes':'No';
			$clhtml .= '<tr>
						  <td >'.$row['lang_title'].'</td>
						  <td >'.$row['lang_code'].'</td>
						  <td >'.$row['lang_file'].'</td>
						  <td >'.$dflt.'</td>
						  <td class="center"  align="right"><a href="add_edit_language.php?id='.$row['id'].'">'.LANGAUGE_LIST_EDIT.'</a> | <a href="manage_langauge.php?delid='.$row['id'].'" >'.LANGAUGE_LIST_DELETE.'</a></td>
						</tr>';
		}
		$clhtml .= '</tbody>';
		return $clhtml;
	}
	
		public function delete_lang(){
		global $bsiCore;
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from bsi_language where id=".$bsiCore->ClearInput($_GET['delid']));	
	}
	
		public function add_edit_language(){
		global $bsiCore;
		$id = $bsiCore->ClearInput($_POST['addedit']);
		$lang_title = $bsiCore->ClearInput($_POST['lang_title']);
		$lang_code = $bsiCore->ClearInput($_POST['lang_code']);
		$lang_file = $bsiCore->ClearInput($_POST['lang_file']);
		$lang_default = (isset($_POST['lang_default']))? 1:0;
		
		$sql4=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_language where lang_default=1 and id=".$id);
		if(mysqli_num_rows($sql4))
		$lang_default=1;
		
		if($lang_default==1)
		mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_language set lang_default=0");
		
		if($id){
			mysqli_query($GLOBALS["___mysqli_ston"], "update bsi_language set lang_title='$lang_title', lang_code='$lang_code', lang_file='$lang_file', lang_default=$lang_default where id=".$id);
		}else{
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into `bsi_language` (`lang_title`, `lang_code`, `lang_file`, `lang_default`) values ('$lang_title', '$lang_code', '$lang_file', '$lang_default')");
		
		}
		
	}
	
	public function getCarcombo($carid=0){	
	         global $bsiCore;	
			$carhtml='<option value="">----- Please Select Car -----</option>';
			$car_res=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_master");
			if(mysqli_num_rows($car_res)){
				while($row44=mysqli_fetch_assoc($car_res)){
					$carvendor=mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_vendor where id='".$row44['car_vendor_id']."'"));
					if($carid == $row44['car_id']){
						$carhtml.='<option value='.$row44['car_id'].' selected="selected">  '.$carvendor['vendor_title'].' '.$row44['car_model'].'</option>';
					}else{
						$carhtml.='<option value='.$row44['car_id'].'> '.$carvendor['vendor_title'].' '.$row44['car_model'].'</option>';
					}
				}
			}
			return $carhtml;
	}
	
	public function add_edit_priceplan()
	{
		global $bsiCore;
		$car_price = $bsiCore->ClearInput($_POST['car_price']);
		$car_id = $bsiCore->ClearInput($_POST['car_id']);
		$pp_id = $bsiCore->ClearInput($_POST['pp_id']);
		$start_date = isset($_POST['start_date'])?$bsiCore->getMySqlDate($bsiCore->ClearInput($_POST['start_date'])):'1900-01-01';
		$end_date = isset($_POST['end_date'])?$bsiCore->getMySqlDate($bsiCore->ClearInput($_POST['end_date'])):'1900-01-01';
		if($car_price != 0){			       				
				$exist=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where (('".$start_date."' between start_date and end_date) or ('".$end_date."' between start_date and end_date) or (start_date between '".$start_date."' and '".$end_date."') or (end_date between '".$start_date."' and '".$end_date."'))  and  car_id='".$car_id."' and pp_id not in (".$pp_id.")");
				if(!mysqli_num_rows($exist)){
					$exp_ppidarr=explode(",",$pp_id);
					$priceplanArray = $_POST['priceplan'];
			 $priceplanKey = array_keys($priceplanArray);
				   for($i=0;$i<count($priceplanKey);$i++){
						$priceplanValue = array_values($priceplanArray[$priceplanKey[$i]]);
						mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `bsi_car_priceplan` SET `start_date`='".$start_date."', `end_date`='".$end_date."',`price_type`='".$priceplanKey[$i]."',`sun`='".$priceplanValue[0]."',`mon`='".$priceplanValue[1]."',`tue`='".$priceplanValue[2]."',`wed`='".$priceplanValue[3]."',`thu`='".$priceplanValue[4]."',`fri`='".$priceplanValue[5]."',`sat`='".$priceplanValue[6]."' WHERE  pp_id= ".$exp_ppidarr[$i]);
				
								 }
				
				}else{
					$_SESSION['date_err']=8989;
				}
		
			
		}else{
			$exist=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_car_priceplan where (('".$start_date."' between start_date and end_date) or ('".$end_date."' between start_date and end_date) or (start_date between '".$start_date."' and '".$end_date."') or (end_date between '".$start_date."' and '".$end_date."'))  and  car_id='".$car_id."'");
			if(!mysqli_num_rows($exist)){
				 $priceplanArray = $_POST['priceplan'];
			 $priceplanKey = array_keys($priceplanArray);
				   for($i=0;$i<count($priceplanKey);$i++){
				$priceplanValue = array_values($priceplanArray[$priceplanKey[$i]]);
				 mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `bsi_car_priceplan` (`car_id`, `price_type`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_price`) VALUES ('".$car_id."', '".$priceplanKey[$i]."', '".$start_date."', '".$end_date."', '".$priceplanValue[0]."', '".$priceplanValue[1]."', '".$priceplanValue[2]."', '".$priceplanValue[3]."', '".$priceplanValue[4]."', '".$priceplanValue[5]."', '".$priceplanValue[6]."', '0');");
				
			 }
			 
			}else{
				$_SESSION['date_err']=8989;
			}
		}
	}
	
	public function price_del($deldetail){
		$detailrow=explode("|",$deldetail);
		mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM `bsi_car_priceplan` WHERE car_id='".$detailrow[0]."' and start_date='".$detailrow[1]."' and end_date='".$detailrow[2]."'");
			header("location: priceplan_list.php?cid= ".$detailrow[0]);

	}
}
?>