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
	$query="delete from philosophy where philosophy_id='".$_REQUEST['philosophy_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Philosophy has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	$query="update philosophy set person_name='".$obj->ReplaceSql($_POST['person_name'])."', philosophy_intro='".$obj->ReplaceSql($_POST['philosophy_intro'])."', philosophy_desc='".$obj->ReplaceSql($_POST['philosophy_desc'])."' where philosophy_id='".$obj->ReplaceSql($_POST['philosophy_id'])."'";
	$obj->UpdateQuery($query);
	if($_FILES['philosophy_image']['name']!=''){
		$photo = array("name"=>$_FILES['philosophy_image']['name'],"tmp_name"=>$_FILES['philosophy_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"philosophy","philosophy_image","philosophy_id",$_POST['philosophy_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Philosophy has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into philosophy set person_name='".$obj->ReplaceSql($_POST['person_name'])."', philosophy_intro='".$obj->ReplaceSql($_POST['philosophy_intro'])."', philosophy_desc='".$obj->ReplaceSql($_POST['philosophy_desc'])."'";
	$philosophy_id=$obj->InsertQuery($query);
	$obj->UpdateQuery("update philosophy set orderid = ".$philosophy_id." where philosophy_id = ".$philosophy_id);
	if($_FILES['philosophy_image']['name']!=''){
		$photo = array("name"=>$_FILES['philosophy_image']['name'],"tmp_name"=>$_FILES['philosophy_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"philosophy","philosophy_image","philosophy_id",$philosophy_id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Philosophy has been added successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update philosophy set orderid = ".($index + 1)." where philosophy_id = ".$id);
		}
	}
	if($_POST['byajax']) { die(); } else { $message = 'Sortation has been saved.'; }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
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
<div class="full"><h1>Manage Philosophy
<?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
	<li><a href="?action=display" <?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?" <?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Philosophy</a></li>
    <li><a href="?action=add" <?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['philosophy_id'])){
        $query = "select * from philosophy where philosophy_id='".$_REQUEST['philosophy_id']."' order by orderid";
        $data = $obj->SelectQuery($query); 
    }?>
<form method="post" enctype="multipart/form-data" name="philosophy" id="philosophy" onsubmit="return validate(document.forms['philosophy']);" >
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Philosophy</th>
	</tr>
    <tr>
    	<td width="25%"><label id="err_person_name">Person Name : </label> <span class="error">*</span></td>
        <td><input type="text" title="Person Name" class="R"  name="person_name" id="person_name" value="<?php echo (isset($data[0])) ? $data[0]['person_name'] : $_POST['person_name'];?>" size="40"/>
        </td>
	</tr>
    <tr>
    	<td><label for="philosophy_image" id="err_philosophy_image">Philosophy Image : </label> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) </td>
        <td><div class="full"><input type="file" name="philosophy_image" id="philosophy_image" class="isImg" title="Philosophy Image"/></div>
            <?php if($obj->ImageExists("philosophy",$data[0]['philosophy_image'])){?>
            <div class="full paddtop10"><img src="../philosophy/th_<?php echo $data[0]['philosophy_image'];?>"/></div>
			<?php }?>
		</td>
	</tr>
    <tr>
			<td><label for="philosophy_intro" id="err_philosophy_intro">Philosophy Introduction</label></td>
            <td>
                <textarea id="philosophy_intro" name="philosophy_intro" rows="4" cols="80" title="Philosophy Introduction"><?php echo (isset($data[0])) ? $data[0]['philosophy_intro'] : $_POST['philosophy_intro'];?></textarea>	
            </td>
        </tr>
        <tr>
			<td><label for="philosophy_desc" id="err_philosophy_desc">Philosophy Description</label></td>
            <td>
                <textarea id="philosophy_desc" name="philosophy_desc" rows="4" cols="80" title="Philosophy Description"><?php echo (isset($data[0])) ? $data[0]['philosophy_desc'] : $_POST['philosophy_desc'];?></textarea>	
            </td>
        </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="philosophy_id" value="<?php echo $_REQUEST['philosophy_id']?>" />
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
		$query = "select * from philosophy order by orderid asc";
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
			echo '<li title="'.$item['philosophy_id'].'">'.$item['person_name'].'</li>';
			$order[] = $item['philosophy_id'];
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
        <th colspan="6">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="6" class="paging">
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
        if($alpha!=''){$where .= " and (person_name like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (person_name like '%".$keyword."%' or philosophy_intro like '%".$keyword."%' or philosophy_desc like '%".$keyword."%')";}
        $query="select * from philosophy where 1=1 $where order by orderid asc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="15%">Philosophy Image</th>
        <th width="15%">Person Name</th>
        <th width="25%">Philosophy Intro</th>
        <th width="25%">Philosophy Description</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td>
        <?php if($obj->ImageExists("philosophy",$row['philosophy_image'])){?>
        	<img src="../philosophy/th_<?php echo $row['philosophy_image'];?>"/>
        <?php }else{?>
        No Image
		<?php } ?>
        </td>
        <td><?php echo $row['person_name'];?></td>
        <td><div class="content"><?php echo $row['philosophy_intro'];?></div></td>
        <td><div class="content"><?php echo $row['philosophy_desc'];?></div></td>
        <td>
        	<a href="?action=edit&philosophy_id=<?php echo $row['philosophy_id'];?>" class="edit" title="Edit"></a>
            <a href="?action=delete&philosophy_id=<?php echo $row['philosophy_id'];?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="6" class="paging"><?php echo $pager->DisplayAllPaging("keyword=".$keyword."&alpha=".$alpha);?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="6" class="txtcenter">No Philosophy Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>