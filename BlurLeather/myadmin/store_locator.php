<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
$_SESSION['IMG_LARGE']['W'] = 1075;
$_SESSION['IMG_LARGE']['H'] = 210;
$_SESSION['IMG_THUMB']['W'] = 110;
$_SESSION['IMG_THUMB']['H'] = 50;
if($_REQUEST['action']=="delete"){
	$query="delete from stores where store_id='".$_REQUEST['store_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Store has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	$query="update stores set country_id='".$obj->ReplaceSql($_POST['country_id'])."', store_name='".$obj->ReplaceSql($_POST['store_name'])."', store_address='".$obj->ReplaceSql($_POST['store_address'])."', store_timing='".$obj->ReplaceSql($_POST['store_timing'])."', phone_no='".$obj->ReplaceSql($_POST['phone_no'])."', longitude='".$obj->ReplaceSql($_POST['longitude'])."', latitude='".$obj->ReplaceSql($_POST['latitude'])."' where store_id='".$obj->ReplaceSql($_POST['store_id'])."'";
	$obj->UpdateQuery($query);
	if($_FILES['store_image']['name']!=''){
		$photo = array("name"=>$_FILES['store_image']['name'],"tmp_name"=>$_FILES['store_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"stores","store_image","store_id",$_POST['store_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Store has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into stores set country_id='".$obj->ReplaceSql($_POST['country_id'])."', store_name='".$obj->ReplaceSql($_POST['store_name'])."', store_address='".$obj->ReplaceSql($_POST['store_address'])."', store_timing='".$obj->ReplaceSql($_POST['store_timing'])."', phone_no='".$obj->ReplaceSql($_POST['phone_no'])."', longitude='".$obj->ReplaceSql($_POST['longitude'])."', latitude='".$obj->ReplaceSql($_POST['latitude'])."'";
	$store_id=$obj->InsertQuery($query);
	$obj->UpdateQuery("update stores set orderid = ".$store_id." where store_id = ".$store_id);
	if($_FILES['store_image']['name']!=''){
		$photo = array("name"=>$_FILES['store_image']['name'],"tmp_name"=>$_FILES['store_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"stores","store_image","store_id",$store_id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H'],true);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Store has been added successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update stores set orderid = ".($index + 1)." where store_id = ".$id);
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
<div class="full"><h1>Manage Stores
<?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
	<li><a href="?action=display" <?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?" <?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Store</a></li>
    <li><a href="?action=add" <?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['store_id'])){
        $query = "select * from stores where store_id='".$_REQUEST['store_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<form method="post" enctype="multipart/form-data" name="frm_stores" id="frm_stores" onsubmit="return validate(document.forms['frm_stores']);" >
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Store Locator</th>
	</tr>
    <tr>
        <td width="20%"><label id="err_country_id" for="country_id">Select Country : </label><span class="error">*</span></td>
        <td>
            <select id="country_id" name="country_id" class="R" title="Country">
                <option value="">------Select Country------</option>
                <?php if($country_cmb = $obj->SelectQuery("select * from country order by orderid")){?><?php foreach ($country_cmb as $country) { ?><option <?php echo ($data[0]['country_id']==$country['country_id'])?'selected="selected"':'';?> value="<?php echo $country['country_id']?>"><?php echo ucfirst($country['country_title']);?></option><?php }} ?>
            </select> 
        </td>
    </tr>
    <tr>
    	<td width="25%"><label id="err_store_name">Store Name : </label> <span class="error">*</span></td>
        <td><input type="text" title="Store Name" class="R" name="store_name" id="store_name" value="<?php echo (isset($data[0])) ? $data[0]['store_name'] : $_POST['store_name'];?>" size="40"/>
        </td>
	</tr>
     <tr>
			<td><label for="store_address" id="err_store_address">Store Address</label></td>
            <td>
                <textarea id="store_address" name="store_address" rows="4" cols="80" title="Store Address"><?php echo (isset($data[0])) ? $data[0]['store_address'] : $_POST['store_address'];?></textarea>	
            </td>
        </tr>
    <tr>
    	<td><label for="store_image" id="err_store_image">Featured Image : </label> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) </td>
        <td><div class="full"><input type="file" name="store_image" id="store_image" class="isImg" title="Featured Image"/></div>
            <?php if($obj->ImageExists("stores",$data[0]['store_image'])){?>
            <div class="full paddtop10"><img src="../stores/th_<?php echo $data[0]['store_image'];?>"/></div>
			<?php }?>
		</td>
	</tr>
   
        <tr>
			<td><label for="store_timing" id="err_store_timing">Store Timing</label></td>
            <td>
                <textarea id="store_timing" name="store_timing" rows="4" cols="80" title="Store Timing"><?php echo (isset($data[0])) ? $data[0]['store_timing'] : $_POST['store_timing'];?></textarea>	
            </td>
        </tr>
      <tr>
    	<td width="25%"><label id="err_phone_no">Phone No : </label> <span class="error"></span></td>
        <td><input type="text" title="Store Name" class=""  name="phone_no" id="phone_no" value="<?php echo (isset($data[0])) ? $data[0]['phone_no'] : $_POST['phone_no'];?>" size="40"/>
        </td>
	</tr>   
    <tr>
    	<td width="25%"><label id="err_longitude">Longitude : </label> <span class="error"></span></td>
        <td><input type="text" title="Longitude" class=""  name="longitude" id="longitude" value="<?php echo (isset($data[0])) ? $data[0]['longitude'] : $_POST['longitude'];?>" size="40"/>
        </td>
	</tr>   
    <tr>
    	<td width="25%"><label id="err_latitude">Latitude : </label> <span class="error"></span></td>
        <td><input type="text" title="Latitude" class=""  name="latitude" id="latitude" value="<?php echo (isset($data[0])) ? $data[0]['latitude'] : $_POST['latitude'];?>" size="40"/>
        </td>
	</tr>   
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="store_id" value="<?php echo $_REQUEST['store_id']?>" />
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
		$query = "select * from stores order by orderid asc";
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
			echo '<li title="'.$item['store_id'].'">'.$item['store_name'].'</li>';
			$order[] = $item['store_id'];
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
        <th colspan="10">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="10" class="paging">
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
        if($alpha!=''){$where .= " and (s.store_name like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (s.store_name like '%".$keyword."%' or s.store_address like '%".$keyword."%' or s.store_timing like '%".$keyword."%' or s.longitude like '%".$keyword."%' or s.latitude like '%".$keyword."%')";}
        $query="select * from stores as s inner join country as c on s.country_id=c.country_id where 1=1 $where order by s.orderid asc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="5%">Sr. No</th>
    	<th width="10%">Featured Image</th>
        <th width="10%">Country</th>
        <th width="10%">Store Name</th>
        <th width="10%">Store Address</th>
        <th width="15%">Store Timing</th>
        <th width="10%">Phone</th>
        <th width="10%">Longitude</th>
        <th width="10%">Latitude</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td>
        <?php if($obj->ImageExists("stores",$row['store_image'])){?>
        	<img src="../stores/th_<?php echo $row['store_image'];?>"/>
        <?php }else{?>
        No Image
		<?php } ?>
        </td>
        <td><?php echo $row['country_title'];?></td>
        <td><?php echo $row['store_name'];?></td>
        <td><div class="content"><?php echo $row['store_address'];?></div></td>
        <td><div class="content"><?php echo $row['store_timing'];?></div></td>
        <td><?php echo $row['phone_no'];?></td>
        <td><?php echo $row['longitude'];?></td>
        <td><?php echo $row['latitude'];?></td>
        <td>
        	<a href="?action=edit&store_id=<?php echo $row['store_id'];?>" class="edit" title="Edit"></a>
            <a href="?action=delete&store_id=<?php echo $row['store_id'];?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="10" class="paging"><?php echo $pager->DisplayAllPaging("keyword=".$keyword."&alpha=".$alpha);?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="10" class="txtcenter">No Store Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>