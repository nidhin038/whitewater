<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php echo $bsiCore->config['conf_portal_name'];?>
</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" type="text/css" href="css/custom-theme/jquery-ui-1.8.22.custom.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="js//dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>
<script type="text/javascript">
$(document).ready(function(){
 $.datepicker.setDefaults({ dateFormat: '<?php echo $bsiCore->config['conf_dateformat'];?>' });
var unavailableDates = [<?php echo $bsiCore->getcloseDate(); ?>];
function unavailable(date) {
			ymd = date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + ("0"+date.getDate()).slice(-2);
			day = new Date(ymd).getDay();
			if ($.inArray(ymd, unavailableDates) < 0 ) {
				return [true, "enabled", ""];
			} else {
				return [false,"disabled","we are closed"];
			}
		}
    $("#txtFromDate").datepicker({
        minDate: "+<?php echo $bsiCore->config['conf_booking_start'];?>D",
        maxDate: "+730D",
		beforeShowDay: unavailable,
        numberOfMonths: 2,
        onSelect: function(selected) {
    	var date = $(this).datepicker('getDate');
         if(date){
            date.setDate(date.getDate());
          }
          $("#txtToDate").datepicker("option","minDate", date)
        }
    });
 
    $("#txtToDate").datepicker({ 
        minDate: 0,
		beforeShowDay: unavailable,
        maxDate:"+730D",
        numberOfMonths: 2,
        onSelect: function(selected) {
           $("#txtFromDate").datepicker("option","maxDate", selected)
        }
    });  
 $("#datepickerImage").click(function() { 
    $("#txtFromDate").datepicker("show");
  });
 $("#datepickerImage1").click(function() { 
    $("#txtToDate").datepicker("show");
  });
  
  $('#btn_room_search').click(function() { 		
	  	if($('#pickuploc').val()==0){
	  		alert('<?php echo mysqli_real_escape_string($GLOBALS["___mysqli_ston"], PICKUP_LOCATION_ALERT);?>');
	  		return false;	  	
		}else if($('#dropoffloc').val()==0){
	  		alert('<?php echo mysqli_real_escape_string($GLOBALS["___mysqli_ston"], DROPOFF_LOCATION_ALERT);?>');
	  		return false;
		}else if($('#txtFromDate').val()==""){
	  		alert('<?php echo mysqli_real_escape_string($GLOBALS["___mysqli_ston"], PLEASE_ENTER_CHECK_IN_DATE_ALERT);?>');
	  		return false;
	 	}else if($('#txtToDate').val()==""){
	  		alert('<?php echo mysqli_real_escape_string($GLOBALS["___mysqli_ston"], PLEASE_ENTER_CHECK_OUT_DATE_ALERT);?>');
	  		return false;		
	  	} else {
	  		return true;
	 	}	  
	});	
});
</script>
<script>
function langchange(lng)
{
	window.location.href = '<?=$_SERVER['PHP_SELF']?>?lang=' + lng;
}		
</script>
</head>
<body>
<div id="content" align="center">
<select name="lang" style="width:150px;" onchange="langchange(this.value)"><?=$lang_dd?></select>
 <h1>
<?php echo $bsiCore->config['conf_portal_name'];?>
 </h1>
 <div id="wrapper" style="width:600px !important;" >
  <h2 align="left" style="padding-left:5px;">
<?php echo CAR_RENTAL_RESERVATION_TEXT;?>
</h2>
  <hr color="#e1dada"  style="margin-top:3px;"/>
  <img src="images/car-home1.png" align="right"   />
  <form id="formElem" name="formElem" action="search-result.php" method="post">
   <table cellpadding="0"  cellspacing="7" border="0"  align="left" style="text-align:left;">
   <tr>
     <td><strong><?php echo PICK_UP_LOCATION_TEXT;?>:</strong></td>
     <td><select name="pickuploc" id="pickuploc" class="home-select"><option value="0"  selected="selected">-- Select Pick-up Location --</option><?php echo $bsiCore->getDroppickLocation(); ?></select></td>
    </tr>
    <tr>
     <td><strong><?php echo DROP_OFF_LOCATION_TEXT;?>:</strong></td>
     <td><select name="dropoffloc" id="dropoffloc" class="home-select"><option value="0"  selected="selected">-- Select Drop-off Location --</option><?php echo $bsiCore->getDroppickLocation(); ?></select></td>
    </tr>
   <tr>
     <td><strong><?php echo CAR_TYPE_TEXT;?>:</strong></td>
     <td><?php echo $bsiCore->getCartypeCombobox();?></td>
    </tr>
    <tr>
     <td><strong><?php echo PICK_UP_DATE_TEXT;?>:</strong></td>
     <td><input id="txtFromDate" name="pickup" style="width:68px" type="text" readonly="readonly" AUTOCOMPLETE=OFF />
      <span style="padding-left:0px;"><a id="datepickerImage" href="javascript:;"><img src="images/month.png" height="16px" width="16px" style=" margin-bottom:-4px;" border="0" /></a></span> <select name="pickUpTime"  style="width:90px;">
  <option value="00:00:00">12:00 AM</option>
 <option value="00:30:00">12:30 AM</option>
 <option value="01:00:00">1:00 AM</option>
 <option value="01:30:00">1:30 AM</option>
 <option value="02:00:00">2:00 AM</option>
 <option value="02:30:00">2:30 AM</option>
 <option value="03:00:00">3:00 AM</option>
 <option value="03:30:00">3:30 AM</option>
 <option value="04:00:00">4:00 AM</option>
 <option value="04:30:00">4:30 AM</option>
 <option value="05:00:00">5:00 AM</option>
 <option value="05:30:00">5:30 AM</option>
 <option value="06:00:00">6:00 AM</option>
 <option value="06:30:00">6:30 AM</option>
 <option value="07:00:00">7:00 AM</option>
 <option value="07:30:00">7:30 AM</option>
 <option value="08:00:00">8:00 AM</option>
 <option value="08:30:00">8:30 AM</option>
 <option value="09:00:00" selected="selected">9:00 AM</option>
 <option value="09:30:00">9:30 AM</option>
 <option value="10:00:00">10:00 AM</option>
 <option value="10:30:00">10:30 AM</option>
 <option value="11:00:00">11:00 AM</option>
 <option value="11:30:00">11:30 AM</option>
 <option value="12:00:00">12:00 PM</option>
 <option value="12:30:00">12:30 PM</option>
 <option value="13:00:00">1:00 PM</option>
 <option value="13:30:00">1:30 PM</option>
 <option value="14:00:00">2:00 PM</option>
 <option value="14:30:00">2:30 PM</option>
 <option value="15:00:00">3:00 PM</option>
 <option value="15:30:00">3:30 PM</option>
 <option value="16:00:00">4:00 PM</option>
 <option value="16:30:00">4:30 PM</option>
 <option value="17:00:00">5:00 PM</option>
 <option value="17:30:00">5:30 PM</option>
 <option value="18:00:00">6:00 PM</option>
 <option value="18:30:00">6:30 PM</option>
 <option value="19:00:00">7:00 PM</option>
 <option value="19:30:00">7:30 PM</option>
 <option value="20:00:00">8:00 PM</option>
 <option value="20:30:00">8:30 PM</option>
 <option value="21:00:00">9:00 PM</option>
 <option value="21:30:00">9:30 PM</option>
 <option value="22:00:00">10:00 PM</option>
 <option value="22:30:00">10:30 PM</option>
 <option value="23:00:00">11:00 PM</option>
 <option value="23:30:00">11:30 PM</option>
</select></td>
    </tr>
    <tr>
     <td><strong><?php echo DROP_OFF_DATE_TEXT;?>:</strong></td>
     <td><input id="txtToDate" name="dropoff" style="width:68px" type="text" readonly="readonly" AUTOCOMPLETE=OFF />
      <span style="padding-left:0px;"><a id="datepickerImage1" href="javascript:;"><img src="images/month.png" height="18px" width="18px" style=" margin-bottom:-4px;" border="0" /></a></span>  <select name="dropoffTime"  style="width:90px;">
 <option value="00:00:00">12:00 AM</option>
 <option value="00:30:00">12:30 AM</option>
 <option value="01:00:00">1:00 AM</option>
 <option value="01:30:00">1:30 AM</option>
 <option value="02:00:00">2:00 AM</option>
 <option value="02:30:00">2:30 AM</option>
 <option value="03:00:00">3:00 AM</option>
 <option value="03:30:00">3:30 AM</option>
 <option value="04:00:00">4:00 AM</option>
 <option value="04:30:00">4:30 AM</option>
 <option value="05:00:00">5:00 AM</option>
 <option value="05:30:00">5:30 AM</option>
 <option value="06:00:00">6:00 AM</option>
 <option value="06:30:00">6:30 AM</option>
 <option value="07:00:00">7:00 AM</option>
 <option value="07:30:00">7:30 AM</option>
 <option value="08:00:00">8:00 AM</option>
 <option value="08:30:00">8:30 AM</option>
 <option value="09:00:00" selected="selected">9:00 AM</option>
 <option value="09:30:00">9:30 AM</option>
 <option value="10:00:00">10:00 AM</option>
 <option value="10:30:00">10:30 AM</option>
 <option value="11:00:00">11:00 AM</option>
 <option value="11:30:00">11:30 AM</option>
 <option value="12:00:00">12:00 PM</option>
 <option value="12:30:00">12:30 PM</option>
 <option value="13:00:00">1:00 PM</option>
 <option value="13:30:00">1:30 PM</option>
 <option value="14:00:00">2:00 PM</option>
 <option value="14:30:00">2:30 PM</option>
 <option value="15:00:00">3:00 PM</option>
 <option value="15:30:00">3:30 PM</option>
 <option value="16:00:00">4:00 PM</option>
 <option value="16:30:00">4:30 PM</option>
 <option value="17:00:00">5:00 PM</option>
 <option value="17:30:00">5:30 PM</option>
 <option value="18:00:00">6:00 PM</option>
 <option value="18:30:00">6:30 PM</option>
 <option value="19:00:00">7:00 PM</option>
 <option value="19:30:00">7:30 PM</option>
 <option value="20:00:00">8:00 PM</option>
 <option value="20:30:00">8:30 PM</option>
 <option value="21:00:00">9:00 PM</option>
 <option value="21:30:00">9:30 PM</option>
 <option value="22:00:00">10:00 PM</option>
 <option value="22:30:00">10:30 PM</option>
 <option value="23:00:00">11:00 PM</option>
 <option value="23:30:00">11:30 PM</option>
</select></td>
    </tr>
  
    <tr>
     <td></td>
     <td align="left"><button id="btn_room_search" type="submit" style="float:left"><?php echo SEARCH_TEXT;?></button></td>
    </tr>
   </table>
  </form>
 </div>
</div>
</body>
</html>