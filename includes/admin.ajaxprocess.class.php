<?php
class adminAjaxProcessor
{
	public $errorMsg;
	public function sendErrorMsg(){		
		$this->errorMsg = "unknown error";	
		echo json_encode(array("errorcode"=>99,"strmsg"=>$this->errorMsg));
	}	
	
	public function getbsiEmailcontent(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$getArray = array();
		$choiceid = $bsiCore->ClearInput($_POST['choiceid']);
		$result = mysqli_query($GLOBALS["___mysqli_ston"], "select * from bsi_email_contents where id=".$choiceid);
		if(mysqli_num_rows($result)){
			$getEmailcontentlist=mysqli_fetch_assoc($result);
			echo json_encode(array("errorcode"=>$errorcode, "viewcontent"=>$getEmailcontentlist['email_subject'], "viewcontent1"=>$choiceid, "viewcontent2"=>$getEmailcontentlist['email_text']));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no  result found ";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function saveCloseDate(){
		//global $bsiCore;
		$errorcode = 0;
		$selectdates=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['selectdates']);
		mysqli_query($GLOBALS["___mysqli_ston"], "TRUNCATE bsi_close_date");
		if($selectdates){
		$selectdates_array=explode(',',$selectdates);		
		foreach($selectdates_array as $key=>$value){
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into bsi_close_date values('".$value."')");			
		}
		}
		echo json_encode(array("errorcode"=>$errorcode));
	}
	
	
	
	public function generate_price_add_edit()
	{
		$errorcode = 0;
		$cars = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `bsi_priceplan` WHERE `car_id` ='".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['c1']) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""))."' AND `is_default` =1");
				$car = mysqli_fetch_array($cars);
				if(mysqli_num_rows($cars)){
		$phtml = '
		<table cellpadding="3" cellspacing="0" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;" width="750px;">
				<tr>
					<td width="85px" style="padding-left:5px;"><strong>Price Type</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>Price / Day</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>Price / Hour </strong></td>
				</tr>
				<tr>
					<td width="85px" style="padding-left:5px;"><strong></strong></td>
					<td width="80px" style="padding-left:10px;"><strong><input type="text" name="pd" value="'.$car['price_daily'].'"></strong></td>
					<td width="80px" style="padding-left:10px;"><strong><input type="text" value="'.$car['price_hourly'].'" name="ph"></strong></td>
				</tr>
				<tr>
				<td width="85px" style="padding-left:5px;"><strong></strong></td>
				<td width="80px" style="padding-left:10px;"><strong><input type="submit" name="submit"></td>
				</tr>
				<tr><td colspan="8"><hr/></td></tr>
		
		';
		echo json_encode(array("errorcode"=>0,"strmsg"=>$phtml));	
		}
		else
		{
			$errorcode = 1;
			//$strmsg = "Sorry! no  result found ";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>"Sorry! no  result found"));
		}
				
	}
	
	
	//****************************************************************************************************************
	
		public function generatePriceplanList(){
		global $bsiCore;
		$errorcode	= 0;
		$strmsg	= "";
		$pphtml='';
		$carid =  ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['c1']) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$daterange = mysqli_query($GLOBALS["___mysqli_ston"], "select start_date, end_date, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date1, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date1, default_price from bsi_car_priceplan where car_id='".$carid."' group by start_date, end_date, default_price");
		
		  if(mysqli_num_rows($daterange)){
			while($row_daterange = mysqli_fetch_assoc($daterange)){
				$query = mysqli_query($GLOBALS["___mysqli_ston"], "select  * from bsi_car_priceplan where start_date='".$row_daterange['start_date']."' and end_date='".$row_daterange['end_date']."' and car_id='".$carid."'");
				  
				  if($row_daterange['default_price']==1){  				
				  $pphtml.='<tr class=odd style="background:#ffffff;">
    <td align="left" colspan="12"><b><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif" size="2">'.PP_REGULAR.'</font></b></td></tr>
	<tr class=odd bgcolor="#f7f1f1">
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.PP_CAPACITY.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.SUN.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.MON.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.TUE.'</font></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.WED.'</font></td>    
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.THU.'</font></td>  
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.FRI.'</font></td> 
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.SAT.'</font></b></td>
									<td align="left" width="90px" colspan="2"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></b></td>
								</tr>';		
					$daletetd=mysqli_num_rows($query);	
					$i1=$daletetd;	
					//$ppid2='';		
					  while($row_pp=mysqli_fetch_assoc($query)){
						  if($row_pp['price_type']==1)
						  $ptypetitle=PRICE_AND_DAY;
						  elseif($row_pp['price_type']==2)
						  $ptypetitle=PRICE_AND_HOUR;
						  //$ppid2.=$row_pp['pp_id'].",";
						  if($bsiCore->config['conf_price_calculation_type']=='1' && $row_pp['price_type']==1){
						   $pphtml.='<tr class=odd  bgcolor="#E8E8E8">
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$ptypetitle.'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</font></td>    
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</font></td>  
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</font></td> 
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</font></td>';
							
								 $pphtml.='<td  width="90px" style="padding-left:10px;" align="center"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="add_edit_priceplan.php?car_id='.$carid.'&start_dt='.$row_daterange['start_date'].'&end_dt='.$row_daterange['end_date'].'" >Edit</a></font></b></td>';
								 $pphtml.='</tr>';
							
						  }elseif($bsiCore->config['conf_price_calculation_type']=='2' && $row_pp['price_type']==2){
							   $pphtml.='<tr class=odd  bgcolor="#E8E8E8">
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$ptypetitle.'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</font></td>    
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</font></td>  
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</font></td> 
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</font></td>';
								
								 $pphtml.='<td  width="90px" style="padding-left:10px;" align="center"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="add_edit_priceplan.php?car_id='.$carid.'&start_dt='.$row_daterange['start_date'].'&end_dt='.$row_daterange['end_date'].'" >Edit</a></font></b></td>';
								 $pphtml.='</tr>';
								
						    }elseif($bsiCore->config['conf_price_calculation_type']=='3'){
							   $pphtml.='<tr class=odd  bgcolor="#E8E8E8">
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$ptypetitle.'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</font></td>    
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</font></td>  
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</font></td> 
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</font></td>';
								if($daletetd==$i1){	
								 $pphtml.='<td rowspan="'.$daletetd.'" width="90px" style="padding-left:10px;" align="center"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="add_edit_priceplan.php?car_id='.$carid.'&start_dt='.$row_daterange['start_date'].'&end_dt='.$row_daterange['end_date'].'" >Edit</a></font></b></td>';
								 $pphtml.='</tr>';
								}
							  
						  }
								
					  
						$i1--;
						}	
				  }else{
					  $pphtml.='<tr class=odd style="background:#ffffff;">
    <td align="left"  colspan="12"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="2">Date Range : '.$row_daterange['start_date1'].'&nbsp; To &nbsp;'.$row_daterange['end_date1'].'</font></b></td></tr><tr class=odd bgcolor="#f7f1f1">
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.PP_CAPACITY.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.SUN.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.MON.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.TUE.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.WED.'</font></b></td>    
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.THU.'</font></b></td>  
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.FRI.'</font></b></td> 
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.SAT.'</font></b></td>
									<td align="left" width="90px" colspan="2"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></b></td>
								</tr>';
								
					  
					$daletetd=mysqli_num_rows($query);		
					$i1=$daletetd;
					//$ppid='';
				      while($row_pp=mysqli_fetch_assoc($query)){
						  
						  if($row_pp['price_type']==1)
						  $ptypetitle=PRICE_AND_DAY;
						  elseif($row_pp['price_type']==2)
						  $ptypetitle=PRICE_AND_HOUR;
						 // $ppid.=$row_pp['pp_id'].",";
						 
						  if($bsiCore->config['conf_price_calculation_type']=='1' && $row_pp['price_type']==1){
						  $pphtml.='<tr class=odd bgcolor="#E8E8E8">
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$ptypetitle.'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</font></td>    
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</font></td>  
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</font></td> 
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</font></td>';
									
									$pln_del=$carid.'|'.$row_pp['start_date'].'|'.$row_pp['end_date'];
									$pln_del=base64_encode($pln_del);
									$pphtml.='<td align="center" width="90px"  style="padding-left:10px;">
									
									<b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="add_edit_priceplan.php?car_id='.$carid.'&start_dt='.$row_pp['start_date'].'&end_dt='.$row_pp['end_date'].'" >Edit</a></font></b>
								&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;
									<b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="javascript:;" onclick="return priceplandelete(\''.$pln_del.'\');">Delete</a></font></b></td>';
								
									
								$pphtml.='</tr>';
							
						  }elseif($bsiCore->config['conf_price_calculation_type']=='2' && $row_pp['price_type']==2){
							   $pphtml.='<tr class=odd bgcolor="#E8E8E8">
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$ptypetitle.'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</font></td>    
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</font></td>  
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</font></td> 
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</font></td>';
								
									$pln_del=$carid.'|'.$row_pp['start_date'].'|'.$row_pp['end_date'];
									$pln_del=base64_encode($pln_del);
									$pphtml.='<td align="center" width="90px"  style="padding-left:10px;">
									
									<b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="add_edit_priceplan.php?car_id='.$carid.'&start_dt='.$row_pp['start_date'].'&end_dt='.$row_pp['end_date'].'" >Edit</a></font></b>
								&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;
									<b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="javascript:;" onclick="return priceplandelete(\''.$pln_del.'\');">Delete</a></font></b></td>';
								
									
								$pphtml.='</tr>';
						   }elseif($bsiCore->config['conf_price_calculation_type']=='3'){
							   $pphtml.='<tr class=odd bgcolor="#E8E8E8">
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$ptypetitle.'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</font></td>    
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</font></td>  
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</font></td> 
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</font></td>';
									if($daletetd==$i1){
									$pln_del=$carid.'|'.$row_pp['start_date'].'|'.$row_pp['end_date'];
									$pln_del=base64_encode($pln_del);
									$pphtml.='<td align="center" width="90px" rowspan="'.$daletetd.'" style="padding-left:10px;">
									
									<b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="add_edit_priceplan.php?car_id='.$carid.'&start_dt='.$row_pp['start_date'].'&end_dt='.$row_pp['end_date'].'" >Edit</a></font></b>
								&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;
									<b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="javascript:;" onclick="return priceplandelete(\''.$pln_del.'\');">Delete</a></font></b></td>';
									}
									
								$pphtml.='</tr>';
						  }
								$i1--;
						}	
				  }
			  
		 	}
		 	echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$pphtml));	
		 }else{
			$errorcode	= 1;
			 $strmsg	= "No  data found !";
			 echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
		 }
	}
	//************************************************************************************************************************************
}
?>