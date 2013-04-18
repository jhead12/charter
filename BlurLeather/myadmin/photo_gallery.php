<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=="delete"){	
	$query="delete from photo_gallery where gallery_id='".$_REQUEST['gallery_id']."'";
	$obj->UpdateQuery($query);
	$query="delete from gallery_images where gallery_id='".$_REQUEST['gallery_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Gallery has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}	
if(isset($_POST['btnupdate'])){	
		$query="update photo_gallery set gallery_title='".$obj->ReplaceSql($_POST['gallery_title'])."', gallery_desc='".$obj->ReplaceSql($_POST['gallery_desc'])."',featured_imagechk='".$obj->ReplaceSql($_POST['featured_imagechk'])."' where gallery_id='".$obj->ReplaceSql($_POST['gallery_id'])."'";
		$obj->UpdateQuery($query);
		if($_FILES['gallery_image']['name']!=''){
			$photo = array("name"=>$_FILES['gallery_image']['name'],"tmp_name"=>$_FILES['gallery_image']['tmp_name']);
			$obj->FixedUploadImage($photo,"photo_gallery","gallery_image","gallery_id",$_POST['gallery_id'],175,100);
		}
		if($_POST['featured_imagechk']=="1"){
			if($_FILES['featured_image']['name']!=''){
				$photo = array("name"=>$_FILES['featured_image']['name'],"tmp_name"=>$_FILES['featured_image']['tmp_name']);
				$obj->FixedUploadImage($photo,"photo_gallery","featured_image","gallery_id",$_POST['gallery_id'],300,398);
			}
		}
		if($_POST['photo_del_id']!=""){
			if($data=$obj->SelectQuery("select photo_path from gallery_images where photo_id in (".substr($_POST['photo_del_id'], 0, -1).")")){
				foreach($data as $row){
					$obj->DeleteImage("gallery_images/gallery_".$_POST['gallery_id'],$row['photo_path'],true);
				}
			}
			$obj->UpdateQuery("delete from gallery_images where photo_id in (".substr($_POST['photo_del_id'], 0, -1).")");
		}
		if(count($_POST['photo_title'])>0){
			for($i=0;$i<count($_POST['photo_title']);$i++){
				if($_POST['photo_title'][$i]!=""){
					if($_POST['photo_id'][$i]!=""){
						$query="update gallery_images set photo_title='".$obj->ReplaceSql($_POST['photo_title'][$i])."' where gallery_id='".$_POST['gallery_id']."' and photo_id='".$_POST['photo_id'][$i]."'";
						$obj->UpdateQuery($query);	
						if($_FILES['photo_path']['name'][$i]!=''){
							$file = array("name"=>$_FILES['photo_path']['name'][$i],"tmp_name"=>$_FILES['photo_path']['tmp_name'][$i]);
							$obj->UploadGalleryImage($file,"gallery_images","photo_path","photo_id",$_POST['photo_id'][$i],$_POST['gallery_id'],175,100);
						}
					}else{
						$query="insert into gallery_images set gallery_id='".$_POST['gallery_id']."', photo_title='".$obj->ReplaceSql($_POST['photo_title'][$i])."'";
						$photo_id=$obj->InsertQuery($query);	
						if($_FILES['photo_path']['name'][$i]!=''){
							$file = array("name"=>$_FILES['photo_path']['name'][$i],"tmp_name"=>$_FILES['photo_path']['tmp_name'][$i]);
							$obj->UploadGalleryImage($file,"gallery_images","photo_path","photo_id",$photo_id,$_POST['gallery_id'],800,800,175,100,true);	
						}
					}
				}
			}
		}
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Gallery has been updated successfully!";
		$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
		$query="insert into photo_gallery set gallery_title='".$obj->ReplaceSql($_POST['gallery_title'])."', gallery_desc='".$obj->ReplaceSql($_POST['gallery_desc'])."',featured_imagechk='".$obj->ReplaceSql($_POST['featured_imagechk'])."'";
		$gallery_id=$obj->InsertQuery($query);
		$obj->UpdateQuery("update photo_gallery set orderid = ".$gallery_id." where gallery_id = ".$gallery_id);
		if($_FILES['gallery_image']['name']!=''){
			$photo = array("name"=>$_FILES['gallery_image']['name'],"tmp_name"=>$_FILES['gallery_image']['tmp_name']);
			$obj->FixedUploadImage($photo,"photo_gallery","gallery_image","gallery_id",$gallery_id,175,100);
		}
		if($_POST['featured_imagechk']=="1"){
			if($_FILES['featured_image']['name']!=''){
				$photo = array("name"=>$_FILES['featured_image']['name'],"tmp_name"=>$_FILES['featured_image']['tmp_name']);
				$obj->FixedUploadImage($photo,"photo_gallery","featured_image","gallery_id",$_POST['gallery_id'],300,398);
			}
		}
		if(count($_POST['photo_title'])>0){
			for($i=0;$i<count($_POST['photo_title']);$i++){
				$query="insert into gallery_images set gallery_id='".$gallery_id."', photo_title='".$obj->ReplaceSql($_POST['photo_title'][$i])."'";
				$photo_id=$obj->InsertQuery($query);	
				if($_FILES['photo_path']['name'][$i]!=''){
					$file = array("name"=>$_FILES['photo_path']['name'][$i],"tmp_name"=>$_FILES['photo_path']['tmp_name'][$i]);
					$obj->UploadGalleryImage($file,"gallery_images","photo_path","photo_id",$photo_id,$gallery_id,175,100);	
				}
			}
		}
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Gallery has been added successfully!";
		$obj->ReturnReferer();
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update photo_gallery set orderid = ".($index + 1)." where gallery_id = ".$id);
		}
	}
	if($_POST['byajax']) { die(); } else { $message = 'Sortation has been saved.'; }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
<script language="javascript">
	var f=1;
function add_gallery(){
	$('#photo_grid').append('<div class="rows"><div class="cols10"><a href="javascript:;" title="Delete" class="delete_btn" onclick="$(this).parent().parent().remove();"></a></div><div class="cols20"><input type="text" maxlength="20" name="photo_title[]" id="photo_title'+f+'" class="R" title="Photo Title"/></div><div class="cols30"><input type="file" name="photo_path[]" id="photo_path'+f+'" class="RisImg" title="Photo Image"/></div><div class="cols40">&nbsp;</div></div>');
	f++;
}
</script>
<script type="text/javascript" src="js/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { 
		new nicEditor().panelInstance('gallery_desc');
	});
</script>
<script type="text/javascript">

function show_chk(chk,id){
	if(chk){
		$('#'+id).slideDown(400);		
	}else{
		$('#'+id).slideUp(400);	
	}
	//$('#bot_total').text('$'+total);
}	
</script>
<style type="text/css">
.clear{ clear:both; width:100%; float:left;}
#sortable-list	{ padding:0; margin:0px; width:100%;}
#sortable-list li{ padding:10px; color:#000; cursor:move; list-style:none; float:left; background:#ddd; margin:5px; border:1px solid #999; font-size:14px;}
#message-box{ background:#fffea1; border:2px solid #fc0; padding:4px 8px; margin:0 0 14px 0; width:500px; }
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		/* grab important elements */
		var sortInput = jQuery('#sort_order');
		var submit = jQuery('#autoSubmit');
		var messageBox = jQuery('#message-box');
		var list = jQuery('#sortable-list');
		/* create requesting function to avoid duplicate code */
		var request = function() {
			jQuery.ajax({
				beforeSend: function() {
					messageBox.text('Updating the sort order in the database.');
				},
				complete: function() {
					messageBox.text('Database has been updated.');
				},
				data: 'sort_order=' + sortInput[0].value + '&ajax=' + submit[0].checked + '&do_submit=1&byajax=1', //need [0]?
				type: 'post',
				url: '<?php echo $_SERVER["REQUEST_URI"]; ?>'
			});
		};
		/* worker function */
		var fnSubmit = function(save) {
			var sortOrder = [];
			list.children('li').each(function(){
				sortOrder.push(jQuery(this).data('id'));
			});
			sortInput.val(sortOrder.join(','));
			if(save) {
				request();
			}
		};
		/* store values */
		list.children('li').each(function() {
			var li = jQuery(this);
			li.data('id',li.attr('title')).attr('title','');
		});
		/* sortables */
		list.sortable({
			opacity: 0.7,
			update: function() {
				fnSubmit(submit[0].checked);
			}
		});
		list.disableSelection();
		/* ajax form submission */
		jQuery('#dd-form').bind('submit',function(e) {
			if(e) e.preventDefault();
			fnSubmit(true);
		});
	});
</script>
</head>
<body>
<?php require_once("message.php");?>
<div class="full"><h1>Manage Gallery <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
	<li><a href="?action=display"<?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
    <li><a href="?"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>Gallery List</a></li>
</ul>
<?php if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
		if($_REQUEST['action']=="edit" && isset($_REQUEST['gallery_id'])){
			$query = "select * from photo_gallery where gallery_id='".$_REQUEST['gallery_id']."'";
			$data = $obj->SelectQuery($query); 
		}?>
<form method="post" enctype="multipart/form-data" name="galleryform" id="galleryform" onsubmit="return validate(document.forms['galleryform']);">
    <table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <tr>
        <td width="25%"><label id="err_featured_image">Featured Image : </label><span class="error">&nbsp;</span></td>
        <td><div class="full">
            	<div class="cols10">
                	<input type="checkbox" onClick="show_chk(this.checked,'f_img_box')" title="Featured" name="featured_imagechk" id="featured_imagechk" value="1" <?php echo $data[0]['featured_imagechk']=='1' ? 'checked="checked"' : '';?> /> Select
                </div>
                <div class="cols80" id="f_img_box" style="display:<?php echo $data[0]['featured_imagechk']=='1' ? 'block' : 'none';?>">
                	<input type="file" name="featured_image" id="featured_image" title="Featured Image" <?php echo $data[0]['featured_imagechk']=='1' ? 'class="RisImg"' : 'class="isImg"';?>/>
                    <?php if($data[0]['featured_image']!=''){?>
                    <br /><br /><img src="../photo_gallery/<?php echo $data[0]['featured_image'];?>" width="40"/>
                    <?php }?>	
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td width="25%"><label id="err_gallery_title">Gallery Title : </label><span class="error">*</span></td>
        <td><input type="text" size="30" title="Gallery Title" class="R" name="gallery_title" id="gallery_title" value="<?php echo (isset($data)) ? $data[0]['gallery_title'] : '' ;?>"/>
        </td>
    </tr>
    <tr>
        <td><label for="gallery_image" id="err_gallery_image">Gallery Image : (Fixed size Width x Height 175 x 100)</label><span class="error"><?php echo ($_REQUEST['action']=="edit") ? "&nbsp;":"*";?></span></td>
        <td><input type="file" name="gallery_image" id="gallery_image" title="Gallery Image" class="<?php echo ($_REQUEST['action']=="edit") ? "isImg":"RisImg";?>"/>
            <?php if($data[0]['gallery_image']!=''){?>
            <br /><br /><img src="../photo_gallery/<?php echo $data[0]['gallery_image'];?>" />
            <?php }?>
        </td>
    </tr>
     <tr>
    	<td><label id="err_gallery_desc">Description : </label></td>
        <td><textarea title="Description" rows="4" cols="80" name="gallery_desc" id="gallery_desc"><?php echo (isset($data[0])) ? $data[0]['gallery_desc'] : $_POST['gallery_desc'] ;?></textarea></td>
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
                    <div class="cols10"><input type="button" class="button" value="Add File" onclick="add_gallery()" /></div>
                    <div class="cols20">Photo Title<span class="error">*</span></div>
                    <div class="cols30">Photo Image<span class="error">*</span></div>
                    <div class="cols40">File size should be 1.5 MB Maximum</div>
                </div>
                <?php if($_REQUEST['action']=="edit"){
                if($file_result=$obj->SelectQuery("Select * from gallery_images where gallery_id='".$data[0]['gallery_id']."' order by photo_id")){
                    foreach($file_result as $item) { ?>
                        <div class="rows">
                            <div class="cols10">
                                <input type="hidden" name="photo_id[]" id="photo_id<?php echo $item['photo_id'];?>" value="<?php echo $item['photo_id'];?>"/>
                                <a href="javascript:;" title="Delete" class="delete_btn" onclick="if(confirm('Are you sure you want to delete Image?')){$(this).parent().parent().remove(); $('#photo_del_id').val($('#photo_del_id').val() + '<?php echo $item['photo_id'];?>,');}"></a>
                            </div>
                            <div class="cols20">
                                <input type="text" name="photo_title[]" maxlength="300" id="photo_titleE<?php echo $item['photo_id'];?>" value="<?php echo $item['photo_title'];?>" class="R" title="Photo Title"/>
                            </div>
                            <div class="cols30">
                            <input type="file" name="photo_path[]" id="photo_pathE<?php echo $item['photo_id'];?>" class="<?php echo ($_REQUEST['action']=="edit") ? "isImg":"RisImg";?>"/>
                            </div>
                            <div class="cols40"> 
                            	<?php if($item['photo_path']!=''){?>
                                <img src="../gallery_images/gallery_<?php echo $data[0]['gallery_id']."/".$item['photo_path']?>" width="25"/>
                                <?php }?>
                            </div>
                         </div>
                <?php } } }?>
            </div>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="gallery_id" value="<?php echo $_REQUEST['gallery_id']?>" />
            <input type="submit" name="btnupdate" value="Update" class="button" />
            <?php }else{?>
            <input type="submit" name="btnsave" value="Add" class="button" />
            <?php }?>
            <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" />
        </td>
    </tr>
    </table>
</form>
</form>
<?php }elseif($_REQUEST['action']=="display"){
		$query = "select * from photo_gallery order by orderid asc";
		$result = $obj->SelectQuery($query);
	?>
<script type="text/javascript">
(function(){
  var bsa = document.createElement('script');
     bsa.type = 'text/javascript';
     bsa.async = true;
     bsa.src = '//s3.buysellads.com/ac/bsa.js';
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
})();
</script>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
	<tr>
    	<th>Display Order</th>
    </tr>
    <tr>
    	<td>
<?php if($result){?>
	<div id="content-left">
	<br /><div id="message-box"> <?php echo $message; ?> Waiting for sortation submission...</div>
	<form id="dd-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<p>
    	<input type="checkbox" value="1" name="autoSubmit" id="autoSubmit" <?php if($_POST['autoSubmit']) { echo 'checked="checked"'; } ?> />
    	<label for="autoSubmit">Automatically submit on drop event</label><br />
	</p>
	<ul id="sortable-list">
	<?php $order = array();
		foreach($result as $item) {
			echo '<li title="'.$item['gallery_id'].'">'.$item['gallery_title'].'</li>';
			$order[] = $item['gallery_id'];
		}?>	
    </ul>
	<input type="hidden" name="sort_order" id="sort_order" value="<?php echo implode(',',$order); ?>" />
    <div class="clear">
	<input type="submit" name="do_submit" value="Submit Sortation" class="button" />
    </div>
	</form>
	</div>
	<?php } ?>
    	</td>
   	</tr>
</table>
<?php }else{$obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
    <tr>
        <th colspan="9">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="9" class="paging">
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
        if($alpha!=''){$where .= " and (gallery_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (gallery_title like '".$keyword."%' or gallery_title like '% ".$keyword."%')";}
        $query="select * from photo_gallery where 1=1 $where order by orderid asc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){ $i = $pager->GetSNo();?>
        <tr>
            <th width="10%">Sr. No.</th>
            <th width="15%">Gallery Title</th>
            <th width="15%">Gallery Image</th>
            <th width="30%">Gallery Description</th>
            <th width="10%">Edit / Delete</th>
        </tr>
    <?php foreach ($data as $row){?>
        <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo $row['gallery_title'];?></td>
            <td><img src="../photo_gallery/<?php echo $row['gallery_image'];?>" width="50"/></td>
            <td><div class="content"><?php echo $row['gallery_desc'];?></div></td>
            <td>
                <a href="?action=edit&gallery_id=<?php echo $row['gallery_id'] ?>" class="edit" title="Edit"></a>
                <a href="?action=delete&gallery_id=<?php echo $row['gallery_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
            </td>            
        </tr>
     <?php } ?>
		<tr><td colspan="9" class="paging"><?php echo $pager->DisplayAllPaging("keyword=".$_GET['keyword']."&alpha=".$_GET['alpha']);?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="9" class="txtcenter">No Gallery Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>