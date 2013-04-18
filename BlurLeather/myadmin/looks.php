<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=="delete"){	
		$query="delete from looks where look_id='".$_REQUEST['look_id']."'";
		$obj->UpdateQuery($query);
		$query="delete from look_products where look_id='".$_REQUEST['look_id']."'";
		$obj->UpdateQuery($query);
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Look has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}	
if(isset($_POST['btnupdate'])){	
	$look_id = $obj->ReplaceSql($_POST['look_id']);
	$query="update looks set pre_category_id='".$obj->ReplaceSql($_GET['pre_category_id'])."',look_title='".$obj->ReplaceSql($_POST['look_title'])."' where look_id='".$look_id."'";
	$obj->UpdateQuery($query);
	if($_FILES['featured_image']['name']!=''){
		$photo = array("name"=>$_FILES['featured_image']['name'],"tmp_name"=>$_FILES['featured_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"looks","featured_image","look_id",$look_id,900,1900,212,479,true);
	}	
	if($_POST['del_product_ids']!=''){
		$query="delete from look_products where look_product_id in (".substr($_POST['del_product_ids'], 0, -1).")";
		$obj->UpdateQuery($query);
	}
		for($i=0; $i<count($_POST['category_id']);$i++){
			if($_POST['look_product_id'][$i]!=""){
				$query="update look_products set category_id='".$obj->ReplaceSql($_POST['category_id'][$i])."', sub_category_id='" .$obj->ReplaceSql($_POST['sub_category_id'][$i])."', product_id='" .$obj->ReplaceSql($_POST['product_id'][$i])."', product_size='" .$obj->ReplaceSql($_POST['product_size'][$i])."' where look_product_id='".$obj->ReplaceSql($_POST['look_product_id'][$i])."' and look_id='".$obj->ReplaceSql($_POST['look_id'])."'";
				$obj->InsertQuery($query);
			}else{
				$query="insert into look_products set look_id='".$obj->ReplaceSql($_POST['look_id'])."', category_id='".$obj->ReplaceSql($_POST['category_id'][$i])."', sub_category_id='".$obj->ReplaceSql($_POST['sub_category_id'][$i])."', product_id='" .$obj->ReplaceSql($_POST['product_id'][$i])."', product_size='" .$obj->ReplaceSql($_POST['product_size'][$i])."'";
				$obj->UpdateQuery($query);
			}
		}
	//$obj->MultipleSessionImages("tmp_looks","look_images","look_image","look_id",$_POST['look_id']);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Look has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into looks set pre_category_id='".$obj->ReplaceSql($_GET['pre_category_id'])."',  look_title='".$obj->ReplaceSql($_POST['look_title'])."'";
	$look_id=$obj->InsertQuery($query);
	$obj->UpdateQuery("update looks set orderid = ".$look_id." where look_id = ".$look_id);
	if($_FILES['featured_image']['name']!=''){
		$photo = array("name"=>$_FILES['featured_image']['name'],"tmp_name"=>$_FILES['featured_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"looks","featured_image","look_id",$look_id,900,1900,212,479,true);
	}
	for($i=0; $i<count($_POST['category_id']);$i++){
		$query="insert into look_products set look_id='".$look_id."', category_id='".$obj->ReplaceSql($_POST['category_id'][$i])."', sub_category_id='".$obj->ReplaceSql($_POST['sub_category_id'][$i])."', product_id='".$obj->ReplaceSql($_POST['product_id'][$i])."', product_size='".$obj->ReplaceSql($_POST['product_size'][$i])."'";
		$obj->UpdateQuery($query);
	}
	//$obj->MultipleSessionImages("tmp_looks","look_images","look_image","look_id",$look_id);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Look has been added successfully!";
	$obj->ReturnReferer();	
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update looks set orderid = ".($index + 1)." where look_id = ".$id);
		}
	}
	if($_POST['byajax']) { die(); } else { $message = 'Sortation has been saved.'; }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<?php include_once("inc.head.php"); ?>
<?php if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){?>
<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE_URL;?>myadmin/css/fileuploader.css" />
<script type="text/javascript" src="<?php echo WEBSITE_URL;?>myadmin/js/fileuploader.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.miniColors.js"></script>
<link rel="stylesheet" href="css/jquery.miniColors.css" type="text/css" />
<?php }?>
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
<div class="full">
<h1>Manage <?php echo $obj->GetValue("pre_category","pre_category_title","pre_category_id=".$_REQUEST['pre_category_id']);?> Looks <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";}elseif($_REQUEST['action']=="add"){ echo "[Add]";} elseif($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
</div>
<ul class="tabs">
	<li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&action=display" <?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
    <li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&" <?php echo $_GET['action']=='' ? ' class="current"': '';?>>Look List</a></li>
</ul>
<?php if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
	if($_REQUEST['action']=="edit" && isset($_REQUEST['look_id'])){
		$query = "select * from looks where look_id='".$_REQUEST['look_id']."'";
		$data = $obj->SelectQuery($query);
			$cust = $obj->SelectQuery("Select * from look_products where look_id='".$data[0]['look_id']."'");
		}
		$categoryrs=$obj->SelectQuery("select * from category where pre_category_id='".$_REQUEST['pre_category_id']."'");
		?>
        
<script language="javascript">
	var introw = <?php echo ($cust) ? count($cust) : 0;?>;
	function addnewrowint(){
		var str = '<div class="rows">'+
	   '<div class="cols5"><input type="hidden" name="product_look_id[]" /><a href="javascript:;" class="delete" onclick="if(confirm(\'Are you sure to delete Menu?\')){$(this).parent().parent().remove();}"></a></div>'+
	   '<div class="cols20"><select name="category_id[]" id="category_id_'+introw+'" onchange="senddata(\'combos\',\'type=sub_category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id=\'+this.value,\'sub_category_id_'+introw+'\'); senddata(\'combos\',\'type=products&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id=\'+this.value,\'product_id_'+introw+'\');"><option value="">-Category-</option><?php if($categoryrs){foreach($categoryrs as $category){?><option value="<?php echo $category['category_id']?>"><?php echo $category['category_title']?></option><?php }} ?></select></div>'+ 
	   '<div class="cols20"><select name="sub_category_id[]" id="sub_category_id_'+introw+'" onchange="senddata(\'combos\',\'type=products&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&sub_category_id=\'+this.value,\'product_id_'+introw+'\');"><option value="">-Sub Category-</option></select></div>'+	
	   '<div class="cols25"><select name="product_id[]" id="product_id_'+introw+'"><option value="">-Product-</option></select></div>'+
	   '<div class="cols25"><input type="text" id="product_size_'+introw+'" name="product_size[]" class="R" title="Size" /></div>'+
	'</div>';
		$('#productgrid').append(str);
		introw++;
	}
</script>    
<script type="text/javascript">
function createUploader(){
	var uploader = new qq.FileUploader({
		element: document.getElementById('upload'),
		listElement: document.getElementById('files'),
		action: '../file-upload.php?page=tmp_looks'
	});
}
$(document).ready(function(e) {
   createUploader();
});
</script>

<form method="post" enctype="multipart/form-data" action="looks.php?pre_category_id=<?php echo $_GET['pre_category_id']?>" name="brandform" id="brandform" onsubmit="return validate(document.forms['brandform']);">
	<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
        <tr>
            <th colspan="2"><?php echo (isset($data)) ? "Edit" : "Add" ;?> Look</th>
        </tr>
        <tr>
            <td width="25%"><label id="err_look_title">Look Title : </label><span class="error">*</span></td>
            <td><input type="text" size="40" title="Look Title" maxlength="50" class="R" name="look_title" id="look_title" value="<?php echo $data[0]['look_title'];?>"/>
            </td>
        </tr>
        <tr>
    		<td><label for="featured_image" id="err_featured_image">Featured Image : </label><?php if($data[0]['featured_image']==''){?><span class="error">*</span><?php }?> (W 900 x H 1900)</td>
            <td><div class="full"><input type="file" name="featured_image" id="featured_image" class="<?php if($data[0]['featured_image']==''){echo "R"; }?>isImg" title="Featured Image"/></div>
                <?php if($data[0]['featured_image']!=''){?><div class="full"><img src="<?php echo WEBSITE_URL."looks/th_".$data[0]['featured_image'];?>" height="100" class="pic" /></div><?php }?>
            </td>
        </tr>
        <?php /*?><tr>
    		<td><label for="gallery_image" id="err_gallery_image">Gallery Images : </label></td>
            <td><div class="full">
            	<div id="upload" class="upload"></div>
                <ul id="files" class="files">
                  <?php  if($result=$obj->SelectQuery("select * from look_images where look_id='".$data[0]['look_id']."'")){foreach($result as $item) { echo '<li class="success"><img src="'.WEBSITE_URL.'look_images/look_images_'.$item['look_id'].'/th_'.$item['look_image'].'" width="81" /><br><a href="javascript:;" onclick="if(confirm(\'Are you sure to delete Image\')){senddata(\'file-delete-common\',\'from=db&page=look_images&colum_name=look_image&columid=look_image_id&id='.$item['look_image_id'].'\',\'\');$(this).parent().remove();}">Delete</a></li>';}}?>
               	  <?php if($_SESSION['tmp_looks']!=''){foreach($_SESSION['tmp_looks'] as $k => $v){?><li class="success"><img src="<?php echo WEBSITE_URL."tmp_looks/th_".$k;?>" alt="" height="81" /><br /><a href="javascript:;" onclick="senddata('file-delete','page=<?php echo "tmp_looks";?>&file=<?php echo $k;?>','');$(this).parent().remove();">Delete</a></li><?php } } ?>
                </ul>
            </div></td>
        </tr><?php */?>
        <tr>
    	<td><label for="Products">Product Grouping: </label></td>
    	<td colspan="3">                            
            <div class="full grid fullform" id="productgrid">
                <input type="hidden" id="del_product_ids" name="del_product_ids" value="" />
                <div class="rowshdr">
                    <div class="cols5"><a title="Add Products" class="add" href="javascript:;" onclick="addnewrowint();"></a></div>
                    <div class="cols20"><label>Category</label></div>	
                    <div class="cols20"><label>Sub Category</label></div>
                    <div class="cols25"><label>Products</label></div>
                    <div class="cols30"><label>Sizes (,)</label></div>
                </div>
                <?php if($cust){ $i=0; foreach($cust as $rows){?>
                <div class="rows">
                	<div class="cols5"><input type="hidden" name="look_product_id[]" value="<?php echo $rows['look_product_id']?>" />
                    <a href="javascript:;" class="delete" onclick="if(confirm('Are you sure to delete Products?')){$(this).parent().parent().remove(); $('#del_product_ids').val($('#del_product_ids').val() + '<?php echo $rows['look_product_id'];?>,');}"></a>
                    </div>
                    <div class="cols20"> 
                    	<select id="category_id_<?php echo $i;?>" name="category_id[]" class="R" title="Category" onchange="senddata('combos','type=sub_category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id='+this.value,'sub_category_id_<?php echo $i;?>'); senddata('combos','type=products&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id=<?php echo $rows['category_id']?>','product_id_<?php echo $i;?>');"></select>
				<script>senddata('combos','type=category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&sel=<?php echo $rows['category_id'];?>','category_id_<?php echo $i;?>');</script>
                	</div>
                    <div class="cols20">
                    	<select id="sub_category_id_<?php echo $i;?>" name="sub_category_id[]" class="R" title="Sub Category" onchange="senddata('combos','type=products&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&sub_category_id='+this.value,'product_id_<?php echo $i;?>');"></select>
					<script>senddata('combos','type=sub_category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id=<?php echo $rows['category_id']?>&sel=<?php echo $rows['sub_category_id'];?>','sub_category_id_<?php echo $i;?>');</script>
                    </div>
                    <div class="cols25">
                    <select id="product_id_<?php echo $i;?>" name="product_id[]" class="R" title="Product"></select>
				<script>senddata('combos','type=products&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&sub_category_id=<?php echo $rows['sub_category_id']?>&sel=<?php echo $rows['product_id'];?>','product_id_<?php echo $i;?>');</script>
                	</div>
                    <div class="cols25"><input type="text" id="product_size_<?php echo $i;?>" value="<?php echo $rows['product_size'];?>" name="product_size[]" class="R" title="Size" /></div>
              	</div>
                <?php $i++; }}?>
            </div>  
        </td>
    </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <?php if($_REQUEST['action']=="edit"){?>
                <input type="hidden" name="look_id" value="<?php echo $_REQUEST['look_id']?>" />
                <input type="submit" name="btnupdate" value="Update" class="button" />
                <?php }else{?>
                <input type="submit" name="btnsave" value="Add" class="button" />
                <?php }?>
                <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" />
            </td>
        </tr>
	</table>
</form>
<?php }elseif($_REQUEST['action']=="display"){
		$query = "select * from looks where pre_category_id='".$_REQUEST['pre_category_id']."' order by orderid asc";
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
			echo '<li title="'.$item['look_id'].'">'.$item['look_title'].'</li>';
			$order[] = $item['look_id'];
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
<?php }else{ if($_REQUEST['action']==""){$obj->SetCurrentUrl();}?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <tr>
    	<th colspan="7">
        	<form>
            	Search by keywords: 
                <input type="hidden" name="pre_category_id" value="<?php echo $_GET['pre_category_id'];?>" />
                <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
                <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
                <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>?pre_category_id=<?php echo $_GET['pre_category_id'];?>';" />
            </form>
        </th>
    </tr>
    <tr>
        <td colspan="7" class="paging">
        	Search by Alphabets: 
        	<?php for($i=65;$i<=90;$i++){ 
			if($_REQUEST['alpha']==chr($i)){?>
			<?php echo "<b>" . chr($i) ."</b>"?>
			<?php } else { ?>	
			<a href="?pre_category_id=<?php echo $_GET['pre_category_id'];?>&alpha=<?php echo chr($i)?>" title="[<?php echo chr($i)?>]"><?php echo chr($i)?></a>
			<?php }}?>
        </td>
    </tr>
    <tr>
    	<th width="5%">Sr. No.</th>
        <th width="25%">Look Title</th>
        <th width="25%">Featured Images</th>
        <th width="10%">Action</th>
    </tr> 
<?php $keyword = $obj->ReplaceSql($_REQUEST['keyword']);
	$alpha = $obj->ReplaceSql($_REQUEST['alpha']);
	$where = '';
	if($keyword!=''){ $where .= " and (look_title like '%".$keyword."%')";}
	if($alpha!=''){	$where .= " and (look_title like '".$alpha."%')";}		
	$query="select * from looks where pre_category_id='".$_REQUEST['pre_category_id']."' {$where} order by orderid";
	$pager = new Pagination($query,$_REQUEST['page'],20,5);
	if($data = $pager->Paging()){
		$i = $pager->GetSNo();
		foreach ($data as $row){ ?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row['look_title'];?></td>
           	<td><?php echo $obj->ImageExists("looks","th_".$row['featured_image']);?></td>
			<td>
				<a class="edit" href="?pre_category_id=<?php echo $_GET['pre_category_id'];?>&action=edit&look_id=<?php echo $row['look_id'];?>"></a>
				<a class="delete" href="?pre_category_id=<?php echo $_GET['pre_category_id'];?>&action=delete&look_id=<?php echo $row['look_id'];?>" onclick="return confirm('Are you sure you want to delete?');"></a>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="4" class="paging"><?php echo $pager->DisplayAllPaging("keyword=".$_GET['keyword']."&alpha=".$_GET['alpha']."&pre_category_id=".$_GET['pre_category_id']);?></td>
		</tr>
	<?php } else { ?>
		<tr>
			<td colspan="4" class="error">No Look Found!</td>
		</tr>
	<?php } ?>   
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>