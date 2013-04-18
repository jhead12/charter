<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if(isset($_POST['btnupdate'])){
	$query="update private_sessions set session_price='".$obj->ReplaceSql($_POST['session_price'])."' where session_id='".$obj->ReplaceSql($_POST['session_id'])."'";
	$obj->UpdateQuery($query);
	if($_POST['date_del_id']!="")
	{
		$obj->UpdateQuery("delete from session_days where day_id in (".substr($_POST['date_del_id'], 0, -1).")");
	}
	if(count($_POST['session_day'])>0){
		for($i=0;$i<count($_POST['session_day']);$i++){
			if($_POST['session_day'][$i]!=""){
				if($_POST['day_id'][$i]!=""){
					$query="update session_days set session_day='".date("Y-m-d",strtotime($_POST['session_day'][$i]))."', day_from_time='".$obj->ReplaceSql($_POST['day_from_time'][$i])."', day_to_time='".$obj->ReplaceSql($_POST['day_to_time'][$i])."' where session_id='".$_POST['session_id']."' and day_id='".$_POST['day_id'][$i]."'";
					$obj->UpdateQuery($query);	
				}else{
					$query="insert into session_days set session_id='".$_POST['session_id']."', session_day='".date("Y-m-d",strtotime($_POST['session_day'][$i]))."', day_from_time='".$obj->ReplaceSql($_POST['day_from_time'][$i])."', day_to_time='".$obj->ReplaceSql($_POST['day_to_time'][$i])."'";
					$obj->InsertQuery($query);	
				}
			}
		}
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Private Session has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into private_sessions set session_price='".$obj->ReplaceSql($_POST['session_price'])."', punchline='".$obj->ReplaceSql($_POST['punchline'])."', session_desc='".$obj->ReplaceSql($_POST['session_desc'])."'";
	$session_id=$obj->InsertQuery($query);
	if(count($_POST['session_day'])>0){
			for($i=0;$i<count($_POST['session_day']);$i++){
				$query="insert into session_days set session_id='".$session_id."', session_day='".date("Y-m-d",strtotime($_POST['session_day'][$i]))."', day_from_time='".$obj->ReplaceSql($_POST['day_from_time'][$i])."', day_to_time='".$obj->ReplaceSql($_POST['day_to_time'][$i])."'";
				$obj->InsertQuery($query);	
			}
		}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Private Session has been added successfully!";
	$obj->ReturnReferer();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
<script type="text/javascript" src="js/jacs.js"></script>
<link rel="stylesheet" href="../jquery-ui-timepicker-0.3.1/include/jquery-ui-1.8.14.custom.css" type="text/css" />
<link rel="stylesheet" href="../jquery-ui-timepicker-0.3.1/jquery.ui.timepicker.css?v=0.3.1" type="text/css" />
<script type="text/javascript" src="../jquery-ui-timepicker-0.3.1/include/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="../jquery-ui-timepicker-0.3.1/jquery.ui.timepicker.js?v=0.3.1"></script>
<script type="text/javascript" src="<?php echo WEBSITE_URL;?>/calander/js/jquery-ui-1.8.20.custom.min.js"></script>
<link type="text/css" href="<?php echo WEBSITE_URL;?>/calander/css/ui-lightness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
</head>
<body>
<?php require_once("message.php");?>
<div class="full"><h1>Manage Private Session <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['session_id'])){
        $query = "select * from private_sessions where session_id='".$_REQUEST['session_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
    
<script language="javascript">
	var f=1;
function add_date(){
	$('#date_grid').append('<div class="rows"><div class="cols15"><a href="javascript:;" title="Delete" class="delete_btn" onclick="$(this).parent().parent().remove();"></a></div><div class="cols30"><input type="text" name="session_day[]" id="session_day'+f+'" rel="session_day" readonly="readonly" class="R" title="Class Date"/></div><div class="cols20"><input type="text" name="day_from_time[]" id="day_from_time'+f+'" readonly="readonly" class="R" rel="day_from_time" title="Class From Time" rel=""/></div><div class="cols20"><input type="text" name="day_to_time[]" id="day_to_time'+f+'" readonly="readonly" rel="day_to_time" class="R" title="Class To Time"/></div></div>');
	f++;
	dtload();
}
function dtload(){
	$("[rel=session_day]").datepicker({minDate: '0'});	
	//$("[rel=session_day]").change(function() {
	//	$("[rel=session_day]").datepicker("option", "dateFormat", "yy-mm-dd");
	//});
    $('[rel=day_from_time]').timepicker({
        showLeadingZero: false,
        //onHourShow: tpStartOnHourShowCallback,
       // onMinuteShow: tpStartOnMinuteShowCallback
    });
    $('[rel=day_to_time]').timepicker({
        showLeadingZero: false,
        //onHourShow: tpEndOnHourShowCallback,
        //onMinuteShow: tpEndOnMinuteShowCallback
    });
}
</script> 
<script language="javascript" type="text/javascript">
 $(document).ready(function() {
	dtload();
});
/*
function tpStartOnHourShowCallback(hour) {
    var tpEndHour = $('[rel=day_to_time]').timepicker('getHour');
    // all valid if no end time selected
    if ($('[rel=day_to_time]').val() == '') { return true; }
    // Check if proposed hour is prior or equal to selected end time hour
    if (hour <= tpEndHour) { return true; }
    // if hour did not match, it can not be selected
    return false;
}
function tpStartOnMinuteShowCallback(hour, minute) {
    var tpEndHour = $('[rel=day_to_time]').timepicker('getHour');
    var tpEndMinute = $('[rel=day_to_time]').timepicker('getMinute');
    // all valid if no end time selected
    if ($('[rel=day_to_time]').val() == '') { return true; }
    // Check if proposed hour is prior to selected end time hour
    if (hour < tpEndHour) { return true; }
    // Check if proposed hour is equal to selected end time hour and minutes is prior
    if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
    // if minute did not match, it can not be selected
    return false;
}

function tpEndOnHourShowCallback(hour) {
    var tpStartHour = $('[rel=day_from_time]').timepicker('getHour');
    // all valid if no start time selected
    if ($('[rel=day_from_time]').val() == '') { return true; }
    // Check if proposed hour is after or equal to selected start time hour
    if (hour >= tpStartHour) { return true; }
    // if hour did not match, it can not be selected
    return false;
}
function tpEndOnMinuteShowCallback(hour, minute) {
    var tpStartHour = $('[rel=day_from_time]').timepicker('getHour');
    var tpStartMinute = $('[rel=day_from_time]').timepicker('getMinute');
    // all valid if no start time selected
    if ($('[rel=day_from_time]').val() == '') { return true; }
    // Check if proposed hour is after selected start time hour
    if (hour > tpStartHour) { return true; }
    // Check if proposed hour is equal to selected start time hour and minutes is after
    if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
    // if minute did not match, it can not be selected
    return false;
}
*/
</script>   
<form method="post" enctype="multipart/form-data" name="prodform" id="prodform" onsubmit="return validate(document.forms['prodform']);">
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Private Session</th>
	</tr>
    <tr>
    	<td width="20%"><label id="err_session_price">Private Session Price : </label> <span class="error">*</span></td>
        <td><input type="text" size="30" title="Private Session Price" class="RisNo" onkeypress="return numbersonly(this,event)"  name="session_price" id="session_price" value="<?php echo (isset($data[0])) ? $data[0]['session_price'] : $_POST['session_price'] ;?>"/> (Hourly Price Rate)
        </td>
	</tr>
    <tr>
    	<th colspan="2">Private Session Schedule</th>
    </tr>
    <tr>
    	<td><label for="date_grid">Private Session Timings : </label></td>
    	<td>                            
          <div class="full" id="date_grid">
            <div class="rowshdr">
                <input type="hidden" name="date_del_id" id="date_del_id"/>
                <div class="cols15"><input type="button" class="button" value="Add Date" onclick="add_date()" /></div>
                <div class="cols30">Schedule Date<span class="error">*</span></div>
                <div class="cols20">Session Time From<span class="error">*</span></div>
                <div class="cols20">Session Time To<span class="error">*</span></div>
            </div>
            <?php if($_REQUEST['action']=="edit"){
            if($result=$obj->SelectQuery("select * from session_days where session_id='".$data[0]['session_id']."' order by day_id")){
                foreach($result as $item) { ?>
                    <div class="rows">
                        <div class="cols15">
                            <input type="hidden" name="day_id[]" id="day_id<?php echo $item['day_id'];?>" value="<?php echo $item['day_id'];?>"/>
                            <a href="javascript:;" title="Delete" class="delete_btn" onclick="if(confirm('Are you sure you want to delete day?')){$(this).parent().parent().remove(); $('#date_del_id').val($('#date_del_id').val() + '<?php echo $item['day_id'];?>,');}"></a>
                        </div>
                        <div class="cols30">
                        	<input type="text" name="session_day[]" readonly="readonly" rel="session_day" id="session_dayE<?php echo $item['day_id'];?>" class="R" value="<?php echo date("m/d/Y",strtotime($item['session_day']));?>"/>
                        </div>
                        <div class="cols20"> 
                         <input type="text" name="day_from_time[]" rel="day_from_time" readonly="readonly" id="day_from_timeE<?php echo $item['day_id'];?>" class="R" value="<?php echo $item['day_from_time'];?>"/>  
                        </div>
                        <div class="cols20"> 
                         <input type="text" name="day_to_time[]" rel="day_to_time" readonly="readonly" id="day_to_timeE<?php echo $item['day_id'];?>" class="R" value="<?php echo $item['day_to_time'];?>"/>  
                        </div>
                     </div>
            <?php } } } ?>
        </div>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="session_id" value="<?php echo $_REQUEST['session_id']?>" />
            <input type="submit" name="btnupdate" value="Update" class="button" />
            <?php }else{?>
            <input type="submit" name="btnsave" value="Save" class="button" />
            <?php }?>
            <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" />
        </td>
	</tr>
</table>
</form>
<?php }else{$obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
    <?php 
        $query="select * from private_sessions order by session_id desc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="20%">Sr. No</th>
    	<th width="60%">Hourly Rate</th>
        <th width="20%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
        <td><?php echo $row['session_price'];?></td>
        <td>
        	<a href="?action=edit&session_id=<?php echo $row['session_id'];?>" class="edit" title="Edit"></a>
		</td>            
	</tr>
        <?php } ?>
    <?php } else { ?>
    	<tr><td colspan="3" class="txtcenter">No Private session Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>