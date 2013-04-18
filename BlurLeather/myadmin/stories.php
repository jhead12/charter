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
	$query="delete from our_stories where story_id='".$_REQUEST['story_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Our Story has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if($_REQUEST['action']=="imgdelete"){	
	$query="update our_stories set story_image='' where story_id='".$_REQUEST['story_id']."'";
	$obj->UpdateQuery($query);
	$obj->DeleteImage("our_stories",$_REQUEST['file'],true);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Story image has been deleted successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnupdate'])){
	$query="update our_stories set story_title='".$obj->ReplaceSql($_POST['story_title'])."', story_desc='".$obj->ReplaceSql($_POST['story_desc'])."' where story_id='".$obj->ReplaceSql($_POST['story_id'])."'";
	$obj->UpdateQuery($query);
	if($_FILES['story_image']['name']!=''){
		$photo = array("name"=>$_FILES['story_image']['name'],"tmp_name"=>$_FILES['story_image']['tmp_name']);
		$obj->UploadImageFix($photo,"our_stories","story_image","story_id",$_POST['story_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Our Story has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into our_stories set story_title='".$obj->ReplaceSql($_POST['story_title'])."', story_desc='".$obj->ReplaceSql($_POST['story_desc'])."'";
	$story_id=$obj->InsertQuery($query);
	if($_FILES['story_image']['name']!=''){
		$photo = array("name"=>$_FILES['story_image']['name'],"tmp_name"=>$_FILES['story_image']['tmp_name']);
		$obj->UploadImageFix($photo,"our_stories","story_image","story_id",$story_id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Our Story has been added successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update our_stories set orderid = ".($index + 1)." where story_id = ".$id);
		}
	}
	if($_POST['byajax']) { die(); } else { $message = 'Sortation has been saved.'; }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
<?php if($_REQUEST['action']=="display"){?>
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
<?php } ?>
</head>
<body>
<?php require_once("message.php");?>
<div class="full"><h1>Manage Our Stories <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
    <li><a href="?action=display"<?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Our Stories</a></li>
    <li><a href="?action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['story_id'])){
        $query = "select * from our_stories where story_id='".$_REQUEST['story_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<script type="text/javascript" language="javascript"> var textareas = 'story_desc';</script>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<form method="post" enctype="multipart/form-data" name="prodform" id="prodform" onsubmit="return validate(document.forms['prodform']);">
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Our Story</th>
	</tr>
    <tr>
    	<td width="20%"><label id="err_story_title">Story Title : </label> <span class="error">*</span></td>
        <td><input type="text" title="Story Title" class="R"  name="story_title" id="story_title" value="<?php echo (isset($data[0])) ? $data[0]['story_title'] : $_POST['story_title'] ;?>"/>
        </td>
	</tr>
   
    <tr>
    	<td><label for="story_image" id="err_story_image">Story Image : </label> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) </td>
        <td ><div class="full"><input type="file" name="story_image" id="story_image" class="isImg" title="Story Image"/></div>
            <?php if($data[0]['story_image']!=''){?><div class="full"><img src="../our_stories/<?php echo $data[0]['story_image'];?>" height="100" class="pic" /></div><?php }?>
            <?php if($obj->ImageExists("our_stories",$data[0]['story_image'])){?>
            	<div class="rows">
                	<img src="../our_stories/th_<?php echo $data[0]['story_image'];?>" />
                </div>
                <div class="rows">
                        <a href="../crop.php?dir=our_stories&file=<?php echo $data[0]['story_image'];?>&rw=133&rh=133&width=900&height=550&iframe=true" class="prettybox">Crop Image</a>
                    <a href="?action=imgdelete&file=<?php echo $data[0]['story_image'];?>&story_id=<?php echo $data[0]['story_id'];?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
                </div>
            <?php } ?>
		</td>
	</tr>
     <tr>
    	<td><label id="err_story_desc">Description : </label></td>
        <td>
         <div class="rows">
        	<div class="cols100">
            	<div id="paths"></div>
            </div>
            <div class="cols100">
        <a class="prettybox" href="uploadimg.php?type=our_stories&width=350&height=100&iframe=true">Upload Image</a> (Upload image to insert in Text editor) e.g. Image size should be [Width x Height] [600 x 600]
        	</div>
        </div>
        <div class="rows">
        <textarea title="Description" rows="4" cols="80" name="story_desc" id="story_desc"><?php echo (isset($data[0])) ? $data[0]['story_desc'] : $_POST['story_desc'] ;?></textarea>
        </div>
        </td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="story_id" value="<?php echo $_REQUEST['story_id']?>" />
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
		$query = "select * from our_stories order by orderid asc";
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
			echo '<li title="'.$item['story_id'].'">'.$item['story_title'].'</li>';
			$order[] = $item['story_id'];
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
        <th colspan="5">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="5" class="paging">
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
        if($alpha!=''){$where .= " and (story_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (story_title like '".$keyword."%' or story_title like '% ".$keyword."%' or story_desc like '".$keyword."%' or story_desc like '% ".$keyword."%')";}
        $query="select * from our_stories where 1=1 $where order by orderid asc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="15%">Story Image</th>
        <th width="15%">Story Title</th>
        <th width="50%">Description</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td><img src="../our_stories/<?php echo $row['story_image'];?>" class="pic" width="100" />
        	<?php if($row['story_image']!=""){?>
            <div class="full">
            	<div class="cols60">
        			<a href="../crop.php?dir=our_stories&file=<?php echo $row['story_image'];?>&rw=133&rh=133&width=900&height=550&iframe=true" class="prettybox">Crop Image</a>
            	</div>
                <div class="cols40">
                <a href="?action=imgdelete&file=<?php echo $row['story_image'];?>&story_id=<?php echo $row['story_id']?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
                </div>
            </div>
            <?php } ?>
        </td>
        <td><?php echo $row['story_title'];?></td>
        <td><div class="content"><?php echo $row['story_desc'];?></div></td>
        <td>
        	<a href="?action=edit&story_id=<?php echo $row['story_id'] ?>" class="edit" title="Edit"></a>
            <a href="?action=delete&story_id=<?php echo $row['story_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete">		</a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="5" class="paging"><?php echo $pager->DisplayAllPaging();?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="5" class="txtcenter">No Story Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>