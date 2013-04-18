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
	if($obj->ValueExists("products","sub_category_id",$_REQUEST['sub_category_id'])==true){
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Sub Category Could not be deleted! Already used in another forms";	
	}else{
		$query="delete from sub_category where sub_category_id='".$_REQUEST['sub_category_id']."'";
		$obj->UpdateQuery($query);
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Sub Category has been deleted successfully!";
	}
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	if($obj->PreCategoryValueExists("sub_category","sub_category_title",$obj->ReplaceSql($_POST['sub_category_title']),"sub_category_id",$obj->ReplaceSql($_POST['sub_category_id']),$obj->ReplaceSql($_POST['pre_category_id']))==false){
	$query="update sub_category set sub_category_title='".$obj->ReplaceSql($_POST['sub_category_title'])."', pre_category_id='".$obj->ReplaceSql($_POST['pre_category_id'])."', category_id='".$obj->ReplaceSql($_POST['category_id'])."' where sub_category_id='".$obj->ReplaceSql($_POST['sub_category_id'])."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Sub Category has been updated successfully!";
	$obj->ReturnReferer();
	} else {
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Sub Category Already Exists";
	}
}
if(isset($_POST['btnsave'])){
	if($obj->PreCategoryValueExists("sub_category","sub_category_title",$obj->ReplaceSql($_POST['sub_category_title']),"","",$obj->ReplaceSql($_POST['pre_category_id']))==false){	
	$query="insert into sub_category set sub_category_title='".$obj->ReplaceSql($_POST['sub_category_title'])."', pre_category_id='".$obj->ReplaceSql($_POST['pre_category_id'])."',  category_id='".$obj->ReplaceSql($_POST['category_id'])."'";
	$obj->InsertQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Sub Category has been added successfully!";
	$obj->ReturnReferer();
	} else {
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Sub Category Already Exists";
	}
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update sub_category set orderid = ".($index + 1)." where sub_category_id = ".$id);
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
<div class="full"><h1>Manage <?php echo $obj->GetValue("pre_category","pre_category_title","pre_category_id=".$_REQUEST['pre_category_id']);?> Section Sub Category<?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
	<li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&action=display"<?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Sub Category</a></li>
    <li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['sub_category_id'])){
        $query = "select * from sub_category where sub_category_id='".$_REQUEST['sub_category_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<form method="post" enctype="multipart/form-data" name="sub_category" id="sub_category" onsubmit="return validate(document.forms['sub_category']);" >
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Sub Sub Category</th>
	</tr>
    <tr>
        <td width="20%"><label id="err_category_id" for="category_id">Select Category : </label><span class="error">*</span></td>
        <td>
            <select id="category_id" name="category_id" class="R" title="Category">
                <option value="">------Select Category------</option>
                <?php if($category_cmb = $obj->SelectQuery("select * from category where pre_category_id='".$_REQUEST['pre_category_id']."' order by orderid")){?><?php foreach ($category_cmb as $category) { ?><option <?php echo ($data[0]['category_id']==$category['category_id'])?'selected="selected"':'';?> value="<?php echo $category['category_id']?>"><?php echo ucfirst($category['category_title']);?></option><?php }} ?>
            </select> 
        </td>
    </tr>
    <tr>
    	<td width="20%"><label id="err_sub_category_title">Sub Category Title : </label> <span class="error">*</span></td>
        <td><input type="text" title="Sub Catgeory Title" class="R"  name="sub_category_title" id="sub_category_title" value="<?php echo (isset($data[0])) ? $data[0]['sub_category_title'] : $_POST['sub_category_title'];?>" size="40"/>
        </td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="sub_category_id" value="<?php echo $_REQUEST['sub_category_id']?>" />
            <input type="submit" name="btnupdate" value="Update" class="button" />
            <?php }else{?>
            <input type="submit" name="btnsave" value="Save" class="button" />
            <?php }?>
            <input type="hidden" name="pre_category_id" value="<?php echo $_REQUEST['pre_category_id']?>" />
            <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" />
        </td>
	</tr>
</table>
</form>
<?php }elseif($_REQUEST['action']=="display"){
		if($_REQUEST['category_id']!=""){ $where=" and category_id='".$_REQUEST['category_id']."'";}
		$query = "select * from sub_category where pre_category_id='".$_REQUEST['pre_category_id']."' {$where} order by orderid asc";
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
        	<select name="category_id" onchange="window.location='?action=display&category_id='+this.value+'&pre_category_id=<?php echo $_REQUEST['pre_category_id'];?>';">
                    <option value="">------Select Category------</option>
                <?php if($category_cmb = $obj->SelectQuery("select * from category where pre_category_id='".$_REQUEST['pre_category_id']."' order by orderid")){?><?php foreach ($category_cmb as $category) { ?><option <?php echo ($_REQUEST['category_id']==$category['category_id'])?'selected="selected"':'';?> value="<?php echo $category['category_id']?>"><?php echo ucfirst($category['category_title']);?></option><?php }} ?>
                </select>
        </td>
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
			echo '<li title="'.$item['sub_category_id'].'">'.$item['sub_category_title'].'</li>';
			$order[] = $item['sub_category_id'];
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
            <input type="hidden" name="pre_category_id" value="<?php echo $_REQUEST['pre_category_id']?>" />
            <input type="hidden" name="category_id" value="<?php echo $_REQUEST['category_id']?>" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>?pre_category_id=<?php echo $_REQUEST['pre_category_id'];?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="5" class="paging">
         Search By Alphabets: 
        <?php for($i=65;$i<=90;$i++){ 
        if($_REQUEST['alpha']==chr($i)){?>
        <?php echo "<b>" . chr($i) ."</b>"?>
        <?php } else { ?>	
        <a href="?alpha=<?php echo chr($i)?>&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>" title="[<?php echo chr($i)?>]"><?php echo chr($i)?></a>
        <?php }}?>
        </td>
	</tr>      
    <?php 
        $keyword = $obj->ReplaceSql($_REQUEST['keyword']);
        $alpha = $obj->ReplaceSql($_REQUEST['alpha']);
        $where = '';
		if($alpha!=''){$where .= " and (s.sub_category_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (s.sub_category_title like '".$keyword."%' or s.sub_category_title like '% ".$keyword."%')";}
        $query="select * from sub_category as s inner join category as c on s.category_id=c.category_id where s.pre_category_id='".$_REQUEST['pre_category_id']."' $where order by s.orderid asc";
		$pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="40%">Category Title</th>
        <th width="40%">Sub Category Title</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
        <td><?php echo $row['category_title'];?></td>
        <td><?php echo $row['sub_category_title'];?></td>
        <td>
        	<a href="?action=edit&sub_category_id=<?php echo $row['sub_category_id']?>&pre_category_id=<?php echo $row['pre_category_id'];?>" class="edit" title="Edit"></a>
            <a href="?action=delete&sub_category_id=<?php echo $row['sub_category_id']?>&pre_category_id=<?php echo $row['pre_category_id'];?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="4" class="paging"><?php echo $pager->DisplayAllPaging("pre_category_id=".$_GET['pre_category_id']."&keyword=".$keyword."&alpha=".$alpha);?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="4" class="txtcenter">No Sub Category Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>