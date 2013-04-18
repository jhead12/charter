<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
$_SESSION['IMG_LARGE']['W'] = 1075;
$_SESSION['IMG_LARGE']['H'] = 481;
$_SESSION['IMG_THUMB']['W'] = 110;
$_SESSION['IMG_THUMB']['H'] = 50;
if($_REQUEST['action']=="delete"){
	$query="delete from archives where archive_id='".$_REQUEST['archive_id']."'";
	$obj->UpdateQuery($query);
	$query="delete from archive_images where archive_id='".$_REQUEST['archive_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Archive has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	$query="update  archives set pre_category_id='".$obj->ReplaceSql($_POST['pre_category_id'])."', archive_title='".$obj->ReplaceSql($_POST['archive_title'])."', archive_desc='".$obj->ReplaceSql($_POST['archive_desc'])."', archive_video_url='".$obj->ReplaceSql($_POST['archive_video_url'])."', archive_year='".$obj->ReplaceSql($_POST['archive_year'])."' where archive_id='".$obj->ReplaceSql($_POST['archive_id'])."'";
	$obj->UpdateQuery($query);
	/////////FEATURED IMAGE
	if($_FILES['archive_image']['name']!=''){
		$photo = array("name"=>$_FILES['archive_image']['name'],"tmp_name"=>$_FILES['archive_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"archives","archive_image","archive_id",$_POST['archive_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	/////////GALLERY IMAGE
	if($_FILES['gallery_image']['name']!=''){
		$photo = array("name"=>$_FILES['gallery_image']['name'],"tmp_name"=>$_FILES['gallery_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"archives","gallery_image","archive_id",$_POST['archive_id'],635,357,120,60,true);
	}
	$obj->MultipleSessionImages("tmp_archives","archive_images","archive_image","archive_id",$_POST['archive_id']);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Archive has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into archives set pre_category_id='".$obj->ReplaceSql($_POST['pre_category_id'])."', archive_title='".$obj->ReplaceSql($_POST['archive_title'])."', archive_desc='".$obj->ReplaceSql($_POST['archive_desc'])."', archive_video_url='".$obj->ReplaceSql($_POST['archive_video_url'])."', archive_year='".$obj->ReplaceSql($_POST['archive_year'])."'";
	$archive_id=$obj->InsertQuery($query);
	$obj->UpdateQuery("update archives set orderid = ".$archive_id." where archive_id = ".$archive_id);
	if($_FILES['archive_image']['name']!=''){
		$photo = array("name"=>$_FILES['archive_image']['name'],"tmp_name"=>$_FILES['archive_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"archives","archive_image","archive_id",$archive_id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
		/////////GALLERY IMAGE
	if($_FILES['gallery_image']['name']!=''){
		$photo = array("name"=>$_FILES['gallery_image']['name'],"tmp_name"=>$_FILES['gallery_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"archives","gallery_image","archive_id",$archive_id,635,357,120,60,true);
	}
	$obj->MultipleSessionImages("tmp_archives","archive_images","archive_image","archive_id",$archive_id);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Archive has been added successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update archives set orderid = ".($index + 1)." where archive_id = ".$id);
		}
	}
	if($_POST['byajax']) { die(); } else { $message = 'Sortation has been saved.'; }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_URL;?>myadmin/css/fileuploader.css"/>
<script type="text/javascript" src="<?php echo WEBSITE_URL;?>myadmin/js/fileuploader.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script language="javascript">
function createUploader(){
	var uploader = new qq.FileUploader({
		element: document.getElementById('upload'),
		listElement: document.getElementById('files'),
		action: '../file-upload.php?page=tmp_archives'
	});
}
$(document).ready(function(e) {
   createUploader();
});

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
<div class="full"><h1>Manage Archives
<?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
	<li><a href="?action=display" <?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?" <?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Archive</a></li>
    <li><a href="?action=add" <?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['archive_id'])){
        $query = "select * from archives where archive_id='".$_REQUEST['archive_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<form method="post" enctype="multipart/form-data" name="archive" id="archive" onsubmit="return validate(document.forms['archive']);" >
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Archive</th>
	</tr>
    <tr>
        <td width="25%"><label id="err_pre_category_id" for="pre_category_id">Select Collection : </label><span class="error">*</span></td>
        <td>
            <select id="pre_category_id" name="pre_category_id" class="R" title="Select Collection">
                <option value="">------Select Collection Types------</option>
                <option value="2" <?php echo $data[0]['pre_category_id']=="2" ? 'selected="selected"':'';?>>Womenswear</option>
                <option value="3" <?php echo $data[0]['pre_category_id']=="3" ? 'selected="selected"':'';?>>Menswear</option>
            </select> 
        </td>
    </tr>
    <tr>
    	<td width="25%"><label id="err_archive_title">Archive Title : </label> <span class="error">*</span></td>
        <td><input type="text" title="Archive Title" class="R"  name="archive_title" id="archive_title" value="<?php echo (isset($data[0])) ? $data[0]['archive_title'] : $_POST['archive_title'];?>" size="40"/>
        </td>
	</tr>
    <tr>
    	<td width="25%"><label id="err_archive_year">Archive Year : </label> <span class="error">*</span></td>
        <td><input type="text" title="Archive Year" class="R"  name="archive_year" id="archive_year" value="<?php echo (isset($data[0])) ? $data[0]['archive_year'] : $_POST['archive_year'];?>" size="40"/>
        </td>
	</tr>
    <tr>
    	<td><label for="archive_image" id="err_archive_image">Featured Image : </label> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) 	</td>
        <td><div class="full"><input type="file" name="archive_image" id="archive_image" class="isImg" title="Featured Image"/></div>
            <?php if($obj->ImageExists("archives",$data[0]['archive_image'])){?>
            <div class="full paddtop10"><img src="../archives/th_<?php echo $data[0]['archive_image'];?>"/></div>
			<?php }?>
		</td>
	</tr>
     <tr>
        <td width="25%"><label for="archive_video_url" id="err_archive_video_url">Archive Video URL :</label></td>
        <td><input type="text" size="40" name="archive_video_url" id="archive_video_url" title="Archive Video URL" class="" value="<?php echo $data[0]['archive_video_url'];?>" /> 	e.g. http://www.youtube.com/watch?v=nO8uijKTurg
        </td>
    </tr>
        <tr>
			<td><label for="archive_desc" id="err_archive_desc">Archive Description</label></td>
            <td>
                <textarea id="archive_desc" name="archive_desc" rows="4" cols="80" title="Archive Description"><?php echo (isset($data[0])) ? $data[0]['archive_desc'] : $_POST['archive_desc'];?></textarea>	
            </td>
        </tr>
      <tr>
    	<td><label for="gallery_image" id="err_gallery_image">Gallery Image : </label> (Width 635 x Height 357) </td>
        <td><div class="full"><input type="file" name="gallery_image" id="gallery_image" class="isImg" title="Gallery Image"/></div>
            <?php if($obj->ImageExists("archives",$data[0]['gallery_image'])){?>
            <div class="full paddtop10"><img src="../archives/th_<?php echo $data[0]['gallery_image'];?>"/></div>
			<?php }?>
		</td>
	</tr>
      <tr>
    	<td><label for="additional_img" id="err_additional_img">Additional Images : (200 x 200) </label></td>
        <td>
        	<div class="full">
            	<div id="upload" class="upload"></div>
                <ul id="files" class="files">
                  <?php if($result=$obj->SelectQuery("select * from archive_images where archive_id='".$data[0]['archive_id']."'")){foreach($result as $item) { echo '<li class="success"><img src="'.WEBSITE_URL.'archive_images/archive_images_'.$item['archive_id'].'/th_'.$item['archive_image'].'" /><br><a href="javascript:;" onclick="if(confirm(\'Are you sure to delete Image\')){senddata(\'file-delete-common\',\'from=db&page=archive_images&colum_name=archive_image&columid=archive_image_id&id='.$item['archive_image_id'].'\',\'\');$(this).parent().remove();}">Delete</a></li>';}}?>
               	  <?php if($_SESSION['tmp_archives']!=''){foreach($_SESSION['tmp_archives'] as $k => $v){?><li class="success"><img src="<?php echo WEBSITE_URL."tmp_archives/th_".$k;?>" alt="" height="100" /><br /><a href="javascript:;" onclick="senddata('file-delete-common','page=<?php echo "tmp_archives";?>&file=<?php echo $k;?>','');$(this).parent().remove();">Delete</a></li><?php } }?>
                </ul>
            </div>
		</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="archive_id" value="<?php echo $_REQUEST['archive_id']?>" />
            <input type="submit" name="btnupdate" value="Update" class="button" />
            <?php }else{?>
            <input type="submit" name="btnsave" value="Save" class="button" />
            <?php }?>
            <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" />
        </td>
	</tr>
</table>
</form>
<?php }elseif($_REQUEST['action']=="display"){
		$query = "select * from archives order by orderid asc";
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
			echo '<li title="'.$item['archive_id'].'">'.$item['archive_title'].'</li>';
			$order[] = $item['archive_id'];
		}?>	
    </ul>
	<input type="hidden" name="sort_order" id="sort_order" value="<?php echo implode(',',$order); ?>" />
    <div class="clear full">
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
        Search by alphabets:
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
        if($alpha!=''){$where .= " and (archive_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (archive_title like '%".$keyword."%' or archive_intro like '%".$keyword."%' or archive_desc like '%".$keyword."%')";}
        $query="select * from archives where 1=1 $where order by orderid asc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="15%">Archive Image</th>
        <th width="15%">Archive Title</th>
        <th width="10%">Cloth Type</th>
        <th width="10%">Archive Year</th>
        <th width="10%">Gallery Image</th>
        <th width="25%">Archive Description</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td><?php echo $obj->ImageExists("archives","th_".$row['archive_image']);?></td>
        <td><?php echo $row['archive_title'];?></td>
        <td><?php echo $row['pre_category_id']=='2'?'Womenswear':'Menswear';?></td>
        <td><?php echo $row['archive_year'];?></td>
        <td><?php echo $obj->ImageExists("archives","th_".$row['gallery_image']);?></td>
        <td><div class="content"><?php echo $row['archive_desc'];?></div></td>
        <td>
        	<a href="?action=edit&archive_id=<?php echo $row['archive_id'];?>" class="edit" title="Edit"></a>
            <a href="?action=delete&archive_id=<?php echo $row['archive_id'];?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="8" class="paging"><?php echo $pager->DisplayAllPaging("alpha=".$alpha."&keyword=".$keyword);?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="8" class="txtcenter">No Archive Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>