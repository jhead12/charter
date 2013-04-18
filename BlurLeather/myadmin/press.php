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
	$query="delete from press where press_id='".$_REQUEST['press_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Press has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	$query="update press set press_title='".$obj->ReplaceSql($_POST['press_title'])."', press_date='".$obj->ReplaceSql($_POST['press_date'])."', press_desc='".$obj->ReplaceSql($_POST['press_desc'])."' where press_id='".$obj->ReplaceSql($_POST['press_id'])."'";
	$obj->UpdateQuery($query);
	if($_FILES['press_image']['name']!=''){
		$photo = array("name"=>$_FILES['press_image']['name'],"tmp_name"=>$_FILES['press_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"press","press_image","press_id",$_POST['press_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Press has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into press set press_title='".$obj->ReplaceSql($_POST['press_title'])."', press_date='".$obj->ReplaceSql($_POST['press_date'])."', press_desc='".$obj->ReplaceSql($_POST['press_desc'])."'";
	$press_id=$obj->InsertQuery($query);
	$obj->UpdateQuery("update press set orderid = ".$press_id." where press_id = ".$press_id);
	if($_FILES['press_image']['name']!=''){
		$photo = array("name"=>$_FILES['press_image']['name'],"tmp_name"=>$_FILES['press_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"press","press_image","press_id",$press_id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Press has been added successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update press set orderid = ".($index + 1)." where press_id = ".$id);
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
<script type="text/javascript" src="js/jacs.js"></script>
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
<div class="full"><h1>Manage Press
<?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
	<li><a href="?action=display" <?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?" <?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Press</a></li>
    <li><a href="?action=add" <?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['press_id'])){
        $query = "select * from press where press_id='".$_REQUEST['press_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<form method="post" enctype="multipart/form-data" name="press" id="press" onsubmit="return validate(document.forms['press']);" >
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Press</th>
	</tr>
    <tr>
    	<td width="25%"><label id="err_press_title">Press Title : </label> <span class="error">*</span></td>
        <td><input type="text" title="Press Title" class="R"  name="press_title" id="press_title" value="<?php echo (isset($data[0])) ? $data[0]['press_title'] : $_POST['press_title'];?>" size="40"/>
        </td>
	</tr>
    <tr>
    	<td><label for="press_image" id="err_press_image">Press Image : </label> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) </td>
        <td><div class="full"><input type="file" name="press_image" id="press_image" class="isImg" title="Press Image"/></div>
            <?php if($obj->ImageExists("press",$data[0]['press_image'])){?>
            <div class="full paddtop10"><img src="../press/th_<?php echo $data[0]['press_image'];?>"/></div>
			<?php }?>
		</td>
	</tr>
    
        <tr>
			<td><label for="press_desc" id="err_press_desc">Press Description</label></td>
            <td>
                <textarea id="press_desc" name="press_desc" rows="4" cols="80" title="Press Description"><?php echo (isset($data[0])) ? $data[0]['press_desc'] : $_POST['press_desc'];?></textarea>	
            </td>
        </tr>
        <tr>
			<td><label for="press_date" id="err_press_date">Press Date</label></td>
            <td>
                <input type="text" id="press_date" name="press_date" title="Press Date" value="<?php echo (isset($data[0])) ? $data[0]['press_date'] : $_POST['press_date'];?>" readonly="readonly"  onfocus="JACS.show(this,event)"/>	
            </td>
        </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="press_id" value="<?php echo $_REQUEST['press_id']?>" />
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
		$query = "select * from press order by orderid asc";
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
			echo '<li title="'.$item['press_id'].'">'.$item['press_title'].'</li>';
			$order[] = $item['press_id'];
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
        if($alpha!=''){$where .= " and (press_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (press_title like '%".$keyword."%' or press_desc like '%".$keyword."%')";}
        $query="select * from press where 1=1 $where order by orderid asc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="15%">Press Image</th>
        <th width="15%">Press Title</th>
        <th width="15%">Press Date</th>
        <th width="35%">Press Description</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td>
        <?php if($obj->ImageExists("press",$row['press_image'])){?>
        	<img src="../press/th_<?php echo $row['press_image'];?>"/>
        <?php }else{?>
        No Image
		<?php } ?>
        </td>
        <td><?php echo $row['press_title'];?></td>
        <td><?php echo $row['press_date'];?></td>
        <td><div class="content"><?php echo $row['press_desc'];?></div></td>
        <td>
        	<a href="?action=edit&press_id=<?php echo $row['press_id'];?>" class="edit" title="Edit"></a>
            <a href="?action=delete&press_id=<?php echo $row['press_id'];?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="6" class="paging"><?php echo $pager->DisplayAllPaging();?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="6" class="txtcenter">No Press Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>