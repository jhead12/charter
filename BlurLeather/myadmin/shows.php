<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
$_SESSION['IMG_LARGE']['W'] = 586;
$_SESSION['IMG_LARGE']['H'] = 240;
$_SESSION['IMG_THUMB']['W'] = 133;
$_SESSION['IMG_THUMB']['H'] = 133;
if($_REQUEST['action']=="delete"){
	$query="delete from shows where show_id='".$_REQUEST['show_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Show has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if($_REQUEST['action']=="imgdelete"){	
	$query="update shows set show_image='' where show_id='".$_REQUEST['show_id']."'";
	$obj->UpdateQuery($query);
	$obj->DeleteImage("shows",$_REQUEST['file'],true);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Shows image has been deleted successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnupdate'])){		
	if(!$obj->CheckShows($_POST['show_status'])){
		$query="update shows set show_title='".$obj->ReplaceSql($_POST['show_title'])."', punchline='".$obj->ReplaceSql($_POST['punchline'])."',show_venue='".$obj->ReplaceSql($_POST['show_venue'])."',show_price='".$obj->ReplaceSql($_POST['show_price'])."', show_status='".$obj->ReplaceSql($_POST['show_status'])."', show_desc='".$obj->ReplaceSql($_POST['show_desc'])."' where show_id='".$obj->ReplaceSql($_POST['show_id'])."'";
		$obj->UpdateQuery($query);
		if($_FILES['show_image']['name']!=''){
			$photo = array("name"=>$_FILES['show_image']['name'],"tmp_name"=>$_FILES['show_image']['tmp_name']);
			$obj->UploadImageFix($photo,"shows","show_image","show_id",$_POST['show_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
		}
		if($_POST['day_del_id']!="")
		{
			$obj->UpdateQuery("delete from show_days where day_id in (".substr($_POST['day_del_id'], 0, -1).")");
		}
		if(count($_POST['show_day_date'])>0){
			for($i=0;$i<count($_POST['show_day_date']);$i++){
				if($_POST['show_day_date'][$i]!=""){
					if($_POST['day_id'][$i]!=""){
						$query="update show_days set show_day_date='".$obj->ReplaceSql($_POST['show_day_date'][$i])."' where show_id='".$_POST['show_id']."' and day_id='".$_POST['day_id'][$i]."'";
						$obj->UpdateQuery($query);	
					}else{
						$query="insert into show_days set show_id='".$_POST['show_id']."', show_day_date='".$obj->ReplaceSql($_POST['show_day_date'][$i])."'";
						$obj->InsertQuery($query);	
					}
				}
			}
		}
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Show has been updated successfully!";
		$obj->ReturnReferer();
	}else {
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Show Status Current already assigned!";
		header("Location:shows.php?action=edit&show_id=".$_REQUEST['show_id']);
	}
}
if(isset($_POST['btnsave'])){
	$query="insert into shows set show_title='".$obj->ReplaceSql($_POST['show_title'])."', punchline='".$obj->ReplaceSql($_POST['punchline'])."', show_venue='".$obj->ReplaceSql($_POST['show_venue'])."', show_price='".$obj->ReplaceSql($_POST['show_price'])."', show_status='".$obj->ReplaceSql($_POST['show_status'])."', show_desc='".$obj->ReplaceSql($_POST['show_desc'])."'";
	$show_id=$obj->InsertQuery($query);
	if($_FILES['show_image']['name']!=''){
		$photo = array("name"=>$_FILES['show_image']['name'],"tmp_name"=>$_FILES['show_image']['tmp_name']);
		$obj->UploadImageFix($photo,"shows","show_image","show_id",$show_id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	if(count($_POST['show_day_date'])>0){
			for($i=0;$i<count($_POST['show_day_date']);$i++){
				$query="insert into show_days set show_id='".$show_id."', show_day_date='".$obj->ReplaceSql($_POST['show_day_date'][$i])."'";
				$obj->InsertQuery($query);	
			}
		}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Show has been added successfully!";
	$obj->ReturnReferer();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
<script type="text/javascript" src="js/jacs.js"></script>
</head>
<body>
<?php require_once("message.php");?>
<div class="full"><h1>Manage Shows <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
    <li><a href="?"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Shows</a></li>
    <li><a href="?action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['show_id'])){
        $query = "select * from shows where show_id='".$_REQUEST['show_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<script type="text/javascript" language="javascript"> var textareas = 'show_desc';</script>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript">
	var f=1;
function add_day(){
	$('#day_grid').append('<div class="rows"><div class="cols15"><a href="javascript:;" title="Delete" class="delete_btn" onclick="$(this).parent().parent().remove();"></a></div><div class="cols30"><input type="text" name="show_day_date[]" id="show_day_date'+f+'" onfocus="JACS.show(this,event)" readonly="readonly" class="R" title="Shows Date"/></div><div class="cols40">&nbsp;</div></div>');
	f++;
}
</script>    
<form method="post" enctype="multipart/form-data" name="prodform" id="prodform" onsubmit="return validate(document.forms['prodform']);">
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Shows</th>
	</tr>
    <tr>
    	<td width="20%"><label id="err_show_title">Show Title : </label> <span class="error">*</span></td>
        <td><input type="text" size="30" title="Show Title" class="R"  name="show_title" id="show_title" value="<?php echo (isset($data[0])) ? $data[0]['show_title'] : $_POST['show_title'] ;?>"/>
        </td>
	</tr>
    <tr>
    	<td><label id="err_punchline">Punch line : </label> <span class="error">&nbsp;</span></td>
        <td><input type="text" size="30" title="Punch line " class=""  name="punchline" id="punchline" value="<?php echo (isset($data[0])) ? $data[0]['punchline'] : $_POST['punchline'] ;?>"/>
        </td>
	</tr>
    <tr>
    	<td><label id="err_show_venue">Show Venue : </label> <span class="error">*</span></td>
        <td><input type="text" size="30" title="Show Venue" class="R"  name="show_venue" id="show_venue" value="<?php echo (isset($data[0])) ? $data[0]['show_venue'] : $_POST['show_venue'] ;?>"/>
        </td>
	</tr>
     <tr>
    	<td><label id="err_show_price">Show Price (USD) : </label> <span class="error">*</span></td>
        <td><input type="text" size="30" title="Show Price" class="RisNo" name="show_price" id="show_price" value="<?php echo (isset($data[0])) ? $data[0]['show_price'] : $_POST['show_price'] ;?>"/>
        </td>
	</tr>
    <tr>
    	<td><label for="show_image" id="err_show_image">Featured Image : </label> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) </td>
        <td colspan="3"><div class="full"><input type="file" name="show_image" id="show_image" class="isImg" title="Show Image"/></div>
            <?php if($data[0]['show_image']!=''){?><div class="full"><img src="../shows/<?php echo $data[0]['show_image'];?>" height="100" class="pic" /></div><?php }?>
             <?php if($obj->ImageExists("shows",$data[0]['show_image'])){?>
             	<div class="rows">
                	<img src="../shows/th_<?php echo $data[0]['show_image'];?>" />
                </div>
                <div class="rows">
                        <a href="../crop.php?dir=shows&file=<?php echo $data[0]['show_image'];?>&rw=133&rh=133&width=900&height=550&iframe=true" class="prettybox">Crop Image</a>
                    <a href="?action=imgdelete&file=<?php echo $data[0]['show_image'];?>&show_id=<?php echo $data[0]['show_id'];?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
                </div>
            <?php } ?>
		</td>
	</tr>
    <tr>
    	<th colspan="2">Show Schedule Dates</th>
    </tr>
    <tr>
    	<td><label for="day_grid">Show's Schedule : </label></td>
    	<td>                            
          <div class="full" id="day_grid">
            <div class="rowshdr">
                <input type="hidden" name="day_del_id" id="day_del_id"/>
                <div class="cols15"><input type="button" class="button" value="Add Date" onclick="add_day()" /></div>
                <div class="cols30">Show's Date<span class="error">*</span></div>
                <div class="cols40"></div>
            </div>
            <?php if($_REQUEST['action']=="edit"){
            if($file_result=$obj->SelectQuery("select * from show_days where show_id='".$data[0]['show_id']."' order by day_id")){
                foreach($file_result as $item) { ?>
                    <div class="rows">
                        <div class="cols15">
                            <input type="hidden" name="day_id[]" id="day_id<?php echo $item['day_id'];?>" value="<?php echo $item['day_id'];?>"/>
                            <a href="javascript:;" title="Delete" class="delete_btn" onclick="if(confirm('Are you sure you want to delete File?')){$(this).parent().parent().remove(); $('#day_del_id').val($('#day_del_id').val() + '<?php echo $item['day_id'];?>,');}"></a>
                        </div>
                        <div class="cols30">
                        <input type="text" name="show_day_date[]" readonly="readonly" onfocus="JACS.show(this,event)" id="show_day_dateE<?php echo $item['day_id'];?>" class="R" value="<?php echo $item['show_day_date'];?>"/>
                        </div>
                        <div class="cols40"> 
                           
                        </div>
                     </div>
            <?php } } }?>
        </div>
        </td>
    </tr>
    <tr>
        <td><label for="show_status" id="err_show_status">Show's Status :</label><span class="error">*</span></td>
        <td><select name="show_status" id="show_status" title="Show's Status" class="R">
        		<option value="">---Select Status---</option>
                <option value="Current" <?php echo ($data[0]['show_status']=='Current') ? 'selected="selected"' : ''?>>Current</option>
                <option value="Past" <?php echo ($data[0]['show_status']=='Past') ? 'selected="selected"' : ''?>>Past</option>
        	</select>
       </td>
    </tr>
     <tr>
    	<td><label id="err_show_desc">Description : </label></td>
        <td>
        	<div class="rows">
        	<div class="cols100">
            	<div id="paths"></div>
            </div>
            <div class="cols100">
        <a class="prettybox" href="uploadimg.php?type=shows&width=350&height=100&iframe=true">Upload Image</a> (Upload image to insert in Text editor) e.g. Image size should be [Width x Height] [600 x 600]
        	</div>
        </div>
        <div class="rows">
        <textarea title="Description" rows="4" cols="80" name="show_desc" id="show_desc"><?php echo (isset($data[0])) ? $data[0]['show_desc'] : $_POST['show_desc'] ;?></textarea>
        </div>
        </td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="show_id" value="<?php echo $_REQUEST['show_id']?>" />
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
    <tr>
        <th colspan="8">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="8" class="paging">
        <?php for($i=65;$i<=90;$i++){ 
        if($_REQUEST['alpha']==chr($i)){?>
        <?php echo "<b>" . chr($i) ."</b>"?>
        <?php } else { ?>	
        <a href="?alpha=<?php echo chr($i)?>" title="[<?php echo chr($i)?>]"><?php echo chr($i)?></a>
        <?php }}?>
        </td>
	</tr>      
    <?php 
        $keyword = $obj->ReplaceSql($_REQUEST['keyword']);
        $alpha = $obj->ReplaceSql($_REQUEST['alpha']);
        $where = '';
        if($alpha!=''){$where .= " and (show_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (show_title like '".$keyword."%' or show_title like '% ".$keyword."%' or punchline like '".$keyword."%' or punchline like '% ".$keyword."%' or show_venue like '".$keyword."%' or show_venue like '% ".$keyword."%' or show_status like '".$keyword."%' or show_status like '% ".$keyword."%')";}
        $query="select * from shows where 1=1 $where order by show_id desc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="10%">Show Image</th>
        <th width="10%">Show Title</th>
        <th width="10%">Show Status</th>
        <th width="10%">Show Venue</th>
        <th width="10%">Show Price</th>
        <th width="30%">Description</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td><img src="../shows/<?php echo $row['show_image'];?>" class="pic" width="100" />
        	<?php if($row['show_image']!=""){?>
            <div class="full">
            	<div class="cols60">
        			<a href="../crop.php?dir=shows&file=<?php echo $row['show_image'];?>&rw=133&rh=133&width=900&height=550&iframe=true" class="prettybox">Crop Image</a>
            	</div>
                <div class="cols40">
                <a href="?action=imgdelete&file=<?php echo $row['show_image'];?>&show_id=<?php echo $row['show_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
                </div>
            </div>
            <?php } ?>
        </td>
        <td><?php echo $row['show_title'];?></td>
        <td><?php echo $row['show_status'];?></td>
        <td><?php echo $row['show_venue'];?></td>
        <td><?php echo $row['show_price'];?></td>
        <td><div class="content"><?php echo $row['show_desc'];?></div></td>
        <td>
        	<a href="?action=edit&show_id=<?php echo $row['show_id'] ?>" class="edit" title="Edit"></a>
            <a href="?action=delete&show_id=<?php echo $row['show_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete">		</a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="8" class="paging"><?php echo $pager->DisplayAllPaging();?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="8" class="txtcenter">No Show Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>