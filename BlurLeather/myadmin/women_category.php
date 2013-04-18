<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
$_SESSION['IMG_LARGE']['W'] = 159;
$_SESSION['IMG_LARGE']['H'] = 113;
$_SESSION['IMG_THUMB']['W'] = 0;
$_SESSION['IMG_THUMB']['H'] = 0;
if($_REQUEST['action']=="delete"){
	if($obj->ValueExists("women_sub_category","category_id",$_REQUEST['category_id'])==true){
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Category Could not be deleted! Already used in another forms";	
	}else{
		$query="delete from women_category where category_id='".$_REQUEST['category_id']."'";
		$obj->UpdateQuery($query);
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Category has been deleted successfully!";
	}
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	if($obj->ValueExists("women_category","category_title",$obj->ReplaceSql($_POST['category_title']),"category_id",$obj->ReplaceSql($_POST['category_id']))==false){
	$query="update women_category set category_title='".$obj->ReplaceSql($_POST['category_title'])."', category_image_approved='".$obj->ReplaceSql($_POST['category_image_approved'])."' where category_id='".$obj->ReplaceSql($_POST['category_id'])."'";
	$obj->UpdateQuery($query);
	if($_FILES['category_image']['name']!=''){
		$photo = array("name"=>$_FILES['category_image']['name'],"tmp_name"=>$_FILES['category_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"women_category","category_image","category_id",$_POST['category_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H']);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Category has been updated successfully!";
	$obj->ReturnReferer();
	} else {
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Category Already Exists";
	}
}
if(isset($_POST['btnsave'])){
	if($obj->ValueExists("women_category","category_title",$obj->ReplaceSql($_POST['category_title']))==false){	
	$query="insert into women_category set category_title='".$obj->ReplaceSql($_POST['category_title'])."', category_image_approved='".$obj->ReplaceSql($_POST['category_image_approved'])."'";
	$category_id=$obj->InsertQuery($query);
	$obj->UpdateQuery("update women_category set orderid = ".$category_id." where category_id = ".$category_id);
	if($_FILES['category_image']['name']!=''){
		$photo = array("name"=>$_FILES['category_image']['name'],"tmp_name"=>$_FILES['category_image']['tmp_name']);
		$obj->UploadImageFix($photo,"women_category","category_image","category_id",$category_id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H']);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Category has been added successfully!";
	$obj->ReturnReferer();
	} else {
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Category Already Exists";
	}
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update women_category set orderid = ".($index + 1)." where category_id = ".$id);
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
<div class="full"><h1>Manage Women Category<?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
	<li><a href="?action=display"<?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Category</a></li>
    <li><a href="?action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['category_id'])){
        $query = "select * from women_category where category_id='".$_REQUEST['category_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<form method="post" enctype="multipart/form-data" name="category" id="category" onsubmit="return validate(document.forms['category']);" >
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Category</th>
	</tr>
    <tr>
    	<td width="20%"><label id="err_category_title">Category Title : </label> <span class="error">*</span></td>
        <td><input type="text" title="Catgeory Title" class="R"  name="category_title" id="category_title" value="<?php echo (isset($data[0])) ? $data[0]['category_title'] : $_POST['category_title'];?>" size="40"/>
        </td>
	</tr>
    <tr>
    	<td><label for="category_image" id="err_category_image">Category Image : </label> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) </td>
        <td><div class="full"><input type="file" name="category_image" id="category_image" class="isImag" title="Catgory Image"/></div>
            <?php if($obj->ImageExists("women_category",$data[0]['category_image'])){?>
            <div class="full paddtop10"><img src="../women_category/<?php echo $data[0]['category_image'];?>" height="113" width="159" /></div>
			<?php }?>
		</td>
	</tr>
     <tr>
    	<td><label id="err_category_image_approved">Show Image In Navigation : </label></td>
        <td><input type="checkbox" title="Image Approve" value="1" name="category_image_approved" id="category_image_approved" <?php echo $data[0]['category_image_approved']=='1'?'checked="checked"':'';?>/> Select</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="category_id" value="<?php echo $_REQUEST['category_id']?>" />
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
		$query = "select * from women_category order by orderid asc";
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
			echo '<li title="'.$item['category_id'].'">'.$item['category_title'].'</li>';
			$order[] = $item['category_id'];
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
        if($alpha!=''){$where .= " and (category_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (category_title like '".$keyword."%' or category_title like '% ".$keyword."%')";}
        $query="select * from women_category where 1=1 $where order by orderid asc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="10%">Category Image</th>
        <th width="25%">Category Title</th>
        <th width="45">Show Approved Image in Navigation</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td>
        <?php if($obj->ImageExists("women_category",$row['category_image'])){?>
        	<img src="../women_category/<?php echo $row['category_image'];?>" height="113" width="159"/>
        <?php }else{?>
        No Image
		<?php } ?>
        </td>
        <td><?php echo $row['category_title'];?></td>
        <td><?php echo $row['category_image_approved']=='1'?'Approved':'No Approved';?></td>
        <td>
        	<a href="?action=edit&category_id=<?php echo $row['category_id'] ?>" class="edit" title="Edit"></a>
            <a href="?action=delete&category_id=<?php echo $row['category_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="5" class="paging"><?php echo $pager->DisplayAllPaging();?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="5" class="txtcenter">No Category Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>