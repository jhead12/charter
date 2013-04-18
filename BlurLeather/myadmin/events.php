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
	$query="delete from events where event_id='".$_REQUEST['event_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Event has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if($_REQUEST['action']=="imgdelete"){	
	$query="update events set event_image='' where event_id='".$_REQUEST['event_id']."'";
	$obj->UpdateQuery($query);
	$obj->DeleteImage("events",$_REQUEST['file'],true);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Event image has been deleted successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnupdate'])){
	$query="update events set event_title='".$obj->ReplaceSql($_POST['event_title'])."',event_date='".$obj->ReplaceSql($_POST['event_date'])."',event_venue='".$obj->ReplaceSql($_POST['event_venue'])."', event_desc='".$obj->ReplaceSql($_POST['event_desc'])."' where event_id='".$obj->ReplaceSql($_POST['event_id'])."'";
	$obj->UpdateQuery($query);
	if($_FILES['event_image']['name']!=''){
		$photo = array("name"=>$_FILES['event_image']['name'],"tmp_name"=>$_FILES['event_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"events","event_image","event_id",$_POST['event_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	if($_POST['photo_del_id']!=""){
		if($data=$obj->SelectQuery("select photo_path from event_images where photo_id in (".substr($_POST['photo_del_id'], 0, -1).")")){
			foreach($data as $row){
				$obj->DeleteImage("event_images/gallery_".$_POST['event_id'],$row['photo_path'],true);
			}
		}
		$obj->UpdateQuery("delete from event_images where photo_id in (".substr($_POST['photo_del_id'], 0, -1).")");
	}
	if(count($_FILES['photo_path']['name'])>0){
			for($i=0;$i<count($_FILES['photo_path']['name']);$i++){
					if($_POST['photo_id'][$i]!=""){
						$query="update event_images set photo_title='".$obj->ReplaceSql($_POST['photo_title'][$i])."' where event_id='".$_POST['event_id']."' and photo_id='".$_POST['photo_id'][$i]."'";
						$obj->UpdateQuery($query);	
						if($_FILES['photo_path']['name'][$i]!=''){
							$file = array("name"=>$_FILES['photo_path']['name'][$i],"tmp_name"=>$_FILES['photo_path']['tmp_name'][$i]);
							$obj->UploadGalleryImage($file,"event_images","photo_path","photo_id",$_POST['photo_id'][$i],$_POST['event_id'],175,100);
						}
					}else{
						$query="insert into event_images set event_id='".$_POST['event_id']."', photo_title='".$obj->ReplaceSql($_POST['photo_title'][$i])."'";
						$photo_id=$obj->InsertQuery($query);	
						if($_FILES['photo_path']['name'][$i]!=''){
							$file = array("name"=>$_FILES['photo_path']['name'][$i],"tmp_name"=>$_FILES['photo_path']['tmp_name'][$i]);
							$obj->UploadGalleryImage($file,"event_images","photo_path","photo_id",$photo_id,$_POST['event_id'],175,100);	
						}
					}
			}
		}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Event has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into events set event_title='".$obj->ReplaceSql($_POST['event_title'])."',event_date='".$obj->ReplaceSql($_POST['event_date'])."',event_venue='".$obj->ReplaceSql($_POST['event_venue'])."', event_desc='".$obj->ReplaceSql($_POST['event_desc'])."'";
	$event_id=$obj->InsertQuery($query);
	if($_FILES['event_image']['name']!=''){
		$photo = array("name"=>$_FILES['event_image']['name'],"tmp_name"=>$_FILES['event_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"events","event_image","event_id",$event_id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	if(count($_FILES['photo_path']['name'])>0){
		for($i=0;$i<count($_FILES['photo_path']['name']);$i++){
			$query="insert into event_images set event_id='".$event_id."', photo_title='".$obj->ReplaceSql($_POST['photo_title'][$i])."'";
			$photo_id=$obj->InsertQuery($query);	
			if($_FILES['photo_path']['name'][$i]!=''){
				$file = array("name"=>$_FILES['photo_path']['name'][$i],"tmp_name"=>$_FILES['photo_path']['tmp_name'][$i]);
				$obj->UploadGalleryImage($file,"event_images","photo_path","photo_id",$photo_id,$event_id,175,100);	
			}
		}
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Event has been added successfully!";
	$obj->ReturnReferer();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
<script language="javascript">
	var f=1;
function add_event(){
	$('#photo_grid').append('<div class="rows"><div class="cols10"><a href="javascript:;" title="Delete" class="delete_btn" onclick="$(this).parent().parent().remove();"></a></div><div class="cols20"><input type="text" maxlength="20" name="photo_title[]" id="photo_title'+f+'" class="" title="Photo Title"/></div><div class="cols30"><input type="file" name="photo_path[]" id="photo_path'+f+'" class="RisImg" title="Photo Image"/></div><div class="cols40">&nbsp;</div></div>');
	f++;
}
</script>
</head>
<body>
<?php require_once("message.php");?>
<div class="full"><h1>Manage Events <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
    <li><a href="?"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Events</a></li>
    <li><a href="?action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['event_id'])){
        $query = "select * from events where event_id='".$_REQUEST['event_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<script type="text/javascript" src="js/jacs.js"></script>    
<script type="text/javascript" language="javascript"> var textareas = 'event_desc';</script>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<form method="post" enctype="multipart/form-data" name="prodform" id="prodform" onsubmit="return validate(document.forms['prodform']);">
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Events</th>
	</tr>
    <tr>
    	<td width="20%"><label id="err_event_title">Event Title : </label> <span class="error">*</span></td>
        <td><input type="text" size="30" title="Event Title" class="R"  name="event_title" id="event_title" value="<?php echo (isset($data[0])) ? $data[0]['event_title'] : $_POST['event_title'] ;?>"/>
        </td>
	</tr>
    <tr>
        <td><label id="err_event_date">Event Date : </label><span class="error">*</span></td>
        <td><input type="text" size="30" title="Event Date" readonly="readonly" class="R" name="event_date" id="event_date" value="<?php echo (isset($data)) ? $data[0]['event_date'] : '' ;?>" onfocus="JACS.event(this,event)" />
        </td>
    </tr>
     <tr>
    	<td width="20%"><label id="err_event_venue">Event Venue : </label> <span class="error">*</span></td>
        <td><input type="text" size="30" title="Event Venue" class="R"  name="event_venue" id="event_venue" value="<?php echo (isset($data[0])) ? $data[0]['event_venue'] : $_POST['event_venue'] ;?>"/>
        </td>
	</tr>
    <tr>
    	<td><label for="event_image" id="err_event_image">Event Image : </label> <?php echo (isset($data[0])) ? '' : '<span class="error">*</span> ' ;?> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) </td>
        <td colspan="3"><div class="full"><input type="file" name="event_image" id="event_image" class="isImg" title="Event Image"/></div>
            <?php if($data[0]['event_image']!=''){?><div class="full"><img src="../events/<?php echo $data[0]['event_image'];?>" height="100" class="pic" /></div><?php }?>
            <?php if($obj->ImageExists("events",$data[0]['event_image'])){?>
                <div class="rows">
                	<img src="../events/th_<?php echo $data[0]['event_image'];?>" />
                </div>
                <div class="rows">
                        <a href="../crop.php?dir=events&file=<?php echo $data[0]['event_image'];?>&rw=133&rh=133&width=900&height=550&iframe=true" class="prettybox">Crop Image</a>
                    <a href="?action=imgdelete&file=<?php echo $data[0]['event_image'];?>&event_id=<?php echo $data[0]['event_id'];?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
                </div>
            <?php } ?>
		</td>
	</tr>
     <tr>
    	<td><label id="err_event_desc">Description : </label></td>
        <td>
        	<div class="rows">
        	<div class="cols100">
            	<div id="paths"></div>
            </div>
            <div class="cols100">
        <a class="prettybox" href="uploadimg.php?type=events&width=350&height=100&iframe=true">Upload Image</a> (Upload image to insert in Text editor) e.g. Image size should be [Width x Height] [600 x 600]
        	</div>
        </div>
        <div class="rows">
        <textarea title="Description" rows="4" cols="80" name="event_desc" id="event_desc"><?php echo (isset($data[0])) ? $data[0]['event_desc'] : $_POST['event_desc'] ;?></textarea>
        </div>
        </td>
	</tr>
    <tr>
    	<th colspan="2">Photo Gallery</th>
    </tr>
    <tr>
    	<td><label for="photo_grid">Gallery Images : </label></td>
    	<td>                            
              <div class="full" id="photo_grid">
                <div class="rowshdr">
                    <input type="hidden" name="photo_del_id" id="photo_del_id"/>
                    <div class="cols10"><input type="button" class="button" value="Add File" onclick="add_event()" /></div>
                    <div class="cols20">Photo Title<span class="error">&nbsp;</span></div>
                    <div class="cols30">Photo Image<span class="error">*</span></div>
                    <div class="cols40">File size should be 1.5 MB Maximum</div>
                </div>
                <?php if($_REQUEST['action']=="edit"){
                if($file_result=$obj->SelectQuery("Select * from event_images where event_id='".$data[0]['event_id']."' order by photo_id")){
                    foreach($file_result as $item) { ?>
                        <div class="rows">
                            <div class="cols10">
                                <input type="hidden" name="photo_id[]" id="photo_id<?php echo $item['photo_id'];?>" value="<?php echo $item['photo_id'];?>"/>
                                <a href="javascript:;" title="Delete" class="delete_btn" onclick="if(confirm('Are you sure you want to delete IMage?')){$(this).parent().parent().remove(); $('#photo_del_id').val($('#photo_del_id').val() + '<?php echo $item['photo_id'];?>,');}"></a>
                            </div>
                            <div class="cols20">
                                <input type="text" name="photo_title[]" maxlength="300" id="photo_titleE<?php echo $item['photo_id'];?>" value="<?php echo $item['photo_title'];?>" class="" title="Photo Title"/>
                            </div>
                            <div class="cols30">
                            <input type="file" name="photo_path[]" id="photo_pathE<?php echo $item['photo_id'];?>" class="<?php echo ($_REQUEST['action']=="edit") ? "isImg":"RisImg";?>"/>
                            </div>
                            <div class="cols40"> 
                            	<?php if($item['photo_path']!=''){?>
                                <img src="../event_images/gallery_<?php echo $data[0]['event_id']."/".$item['photo_path']?>" width="25"/>
                                <?php }?>
                            </div>
                         </div>
                <?php } } }?>
            </div>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="event_id" value="<?php echo $_REQUEST['event_id']?>" />
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
        <th colspan="7">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="7" class="paging">
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
        if($alpha!=''){$where .= " and (event_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (event_title like '".$keyword."%' or event_title like '% ".$keyword."%' or event_venue like '".$keyword."%' or event_venue like '% ".$keyword."%')";}
        $query="select * from events where 1=1 $where order by event_date desc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="15%">Event Image</th>
        <th width="15%">Event Title</th>
        <th width="10%">Event Date</th>
        <th width="10%">Event Venue</th>
        <th width="50%">Description</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td><img src="../events/<?php echo $row['event_image'];?>" class="pic" width="100" /><br />
        	<?php if($row['event_image']!=""){?>
            <div class="full">
            	<div class="cols60">
        			<a href="../crop.php?dir=events&file=<?php echo $row['event_image'];?>&rw=133&rh=133&width=900&height=550&iframe=true" class="prettybox">Crop Image</a>
            	</div>
                <div class="cols40">
                <a href="?action=imgdelete&file=<?php echo $row['event_image'];?>&event_id=<?php echo $row['event_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
                </div>
            </div>
            <?php } ?>
        </td>
        <td><?php echo $row['event_title'];?></td>
        <td><?php echo  date("m/d/Y",strtotime($row['event_date']));?></td>
        <td><?php echo $row['event_venue'];?></td>
        <td><div class="content"><?php echo $row['event_desc'];?></div></td>
        <td>
        	<a href="?action=edit&event_id=<?php echo $row['event_id'] ?>" class="edit" title="Edit"></a>
            <a href="?action=delete&event_id=<?php echo $row['event_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete">		</a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="7" class="paging"><?php echo $pager->DisplayAllPaging();?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="7" class="txtcenter">No Event Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>