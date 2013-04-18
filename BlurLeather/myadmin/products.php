<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=="delete"){	
	if($obj->ValueExists("order_product","productid",$_REQUEST['product_id'])==false){
		$query="delete from products where product_id='".$_REQUEST['product_id']."'";
		$obj->UpdateQuery($query);
		$query="delete from product_gallery where product_id='".$_REQUEST['product_id']."'";
		$obj->UpdateQuery($query);
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Product has been deleted successfully!";
	}else{
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Product Could not be deleted! Already used in Orders";	
	}
	$obj->ReturnReferer();
	exit();
}	
if(isset($_POST['btnupdate'])){	
	$product_id = $obj->ReplaceSql($_POST['product_id']);
	$query="update products set pre_category_id='".$obj->ReplaceSql($_GET['pre_category_id'])."', category_id='".$obj->ReplaceSql($_POST['category_id'])."', sub_category_id='".$obj->ReplaceSql($_POST['sub_category_id'])."', product_title='".$obj->ReplaceSql($_POST['product_title'])."', product_price='".$obj->ReplaceSql($_POST['product_price'])."', product_description='".$obj->ReplaceSql($_POST['product_description'])."', delivery='".$obj->ReplaceSql($_POST['delivery'])."', return_policy='".$obj->ReplaceSql($_POST['return_policy'])."' where product_id='".$product_id."'";
	$obj->UpdateQuery($query);
	if($_FILES['featured_image']['name']!=''){
		$photo = array("name"=>$_FILES['featured_image']['name'],"tmp_name"=>$_FILES['featured_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"products","featured_image","product_id",$product_id,212,325);
	}	
	if($_POST['del_color_ids']!=''){
		foreach(explode(",",$_POST['del_color_ids']) as $delids){
			if($delids!=""){
				$query="delete from product_color where color_id='".$delids."'";
				$obj->UpdateQuery($query);
				$query="delete from product_gallery where color_id='".$delids."'";
				$obj->UpdateQuery($query);
			}
		}
	}
	if(isset($_POST['index_id'])){
		foreach ($_POST['index_id'] as $index_id){
			if($_POST['color_id_'.$index_id]=='0'){
				$query="insert into product_color set product_id='".$product_id."', family_id='".$_POST['family_id_'.$index_id]."', color_title='".$_POST['color_title_'.$index_id]."', color_code='".$obj->ReplaceSql($_POST['color_code_'.$index_id])."', size='".$obj->ReplaceSql($_POST['size_'.$index_id])."'";
				$cid = $obj->InsertQuery($query);
				$obj->MultipleProductImages("tmp_products",$index_id,$product_id,$cid);
			}else{
				$query="update product_color set family_id='".$_POST['family_id_'.$index_id]."', color_title='".$_POST['color_title_'.$index_id]."', color_code='".$obj->ReplaceSql($_POST['color_code_'.$index_id])."', size='".$obj->ReplaceSql($_POST['size_'.$index_id])."' where color_id='".$_POST['color_id_'.$index_id]."'";
				$obj->UpdateQuery($query);
				$obj->MultipleProductImages("tmp_products",$index_id,$product_id,$_POST['color_id_'.$index_id]);
			}
		}
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Product has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into products set pre_category_id='".$obj->ReplaceSql($_GET['pre_category_id'])."', category_id='".$obj->ReplaceSql($_POST['category_id'])."', sub_category_id='".$obj->ReplaceSql($_POST['sub_category_id'])."', product_title='".$obj->ReplaceSql($_POST['product_title'])."', product_price='".$obj->ReplaceSql($_POST['product_price'])."', product_description='".$obj->ReplaceSql($_POST['product_description'])."', delivery='".$obj->ReplaceSql($_POST['delivery'])."', return_policy='".$obj->ReplaceSql($_POST['return_policy'])."'";
	$product_id=$obj->InsertQuery($query);
	$obj->UpdateQuery("update products set orderid = ".$product_id." where product_id = ".$product_id);
	if($_FILES['featured_image']['name']!=''){
		$photo = array("name"=>$_FILES['featured_image']['name'],"tmp_name"=>$_FILES['featured_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"products","featured_image","product_id",$product_id,212,325);
	}
	$query="delete from product_color where product_id='".$product_id."'";
	$obj->UpdateQuery($query);
	$query="delete from product_gallery where product_id='".$product_id."'";
	$obj->UpdateQuery($query);
	if(isset($_POST['index_id'])){
		foreach ($_POST['index_id'] as $index_id){
			$query="insert into product_color set product_id='".$product_id."', family_id='".$_POST['family_id_'.$index_id]."', color_title='".$_POST['color_title_'.$index_id]."', color_code='".$obj->ReplaceSql($_POST['color_code_'.$index_id])."', size='".$obj->ReplaceSql($_POST['size_'.$index_id])."'";
			$cid = $obj->InsertQuery($query);
			$obj->MultipleProductImages("tmp_products",$index_id,$product_id,$cid);
		}
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Product has been added successfully!";
	$obj->ReturnReferer();	
}
if(isset($_POST['do_submit'])){
	$ids = explode(',',$_POST['sort_order']);
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$obj->UpdateQuery("update products set orderid = ".($index + 1)." where product_id = ".$id);
		}
	}
	if($_POST['byajax']) { die(); } else { $message = 'Sortation has been saved.'; }
}
if($_REQUEST['action']!="add" && $_REQUEST['action']!="edit"){
if(count($_SESSION['tmp_products'])>0){foreach($_SESSION['tmp_products'] as $rows){foreach($rows as $k => $v){if(file_exists(UPLOAD_PATH_ORG."tmp_products/".$k)){@unlink(UPLOAD_PATH_ORG."tmp_products/".$k);@unlink(UPLOAD_PATH_ORG."tmp_products/th_".$k);}}}}
unset($_SESSION['tmp_products']);}
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
<?php } else{?>
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
<div class="full">
<h1>Manage <?php echo $obj->GetValue("pre_category","pre_category_title","pre_category_id=".$_REQUEST['pre_category_id']);?> Products <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";}elseif($_REQUEST['action']=="add"){ echo "[Add]";} elseif($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
</div>
<ul class="tabs">
	<li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&action=display" <?php echo $_GET['action']=='display' ? ' class="current"': '';?>>Display Order</a></li>
    <li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
    <li><a href="?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>Product List</a></li>
</ul>
<?php if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
	if($_REQUEST['action']=="edit" && isset($_REQUEST['product_id'])){
		$query = "select * from products where product_id='".$_REQUEST['product_id']."'";
		$data = $obj->SelectQuery($query);
		$_POST['product_title'] = $_POST['product_title'] !="" ?  $_POST['product_title'] : $data[0]['product_title'];
		$_POST['product_price'] = $_POST['product_price'] !="" ?  $_POST['product_price'] : $data[0]['product_price'];
		$_POST['product_description'] = $_POST['product_description'] !="" ?  $_POST['product_description'] : $data[0]['product_description'];
		$_POST['delivery'] = $_POST['delivery'] !="" ?  $_POST['delivery'] : $data[0]['delivery'];
		$_POST['return_policy'] = $_POST['return_policy'] !="" ?  $_POST['return_policy'] : $data[0]['return_policy'];
		$_POST['category_id'] = $_POST['category_id'] !="" ?  $_POST['category_id'] : $data[0]['category_id'];
		$_POST['sub_category_id'] = $_POST['sub_category_id'] !="" ?  $_POST['sub_category_id'] : $data[0]['sub_category_id'];
		$cust = $obj->SelectQuery("Select * from product_color where product_id='".$data[0]['product_id']."'");
	}
	$color_family=$obj->SelectQuery("select * from color_family");?>
<script language="javascript">
	var introw = <?php echo ($cust) ? count($cust) : 0;?>;
	function addnewrowint(){
		var str = '<div class="rows">'+
	   '<div class="cols5"><input type="hidden" name="index_id[]" value="'+ introw +'" /><input type="hidden" name="color_id_'+ introw +'" value="0" /><a href="javascript:;" class="delete" onclick="if(confirm(\'Are you sure to delete Menu?\')){$(this).parent().parent().remove();}"></a></div>'+
	   '<div class="cols15"><select name="family_id_'+introw+'"><option value="">-Family-</option><?php if($color_family){foreach($color_family as $family){?><option value="<?php echo $family['family_id']?>"><?php echo $family['family_title']?></option><?php }} ?></select></div>'+
	   '<div class="cols15"><input type="text" title="Color" class="R" name="color_title_'+ introw +'" /></div>'+ 
	   '<div class="cols15"><input type="text" style="width:60px" title="Color Code" class="R color" name="color_code_'+ introw +'" /></div>'+	
	   '<div class="cols25"><input type="text" title="Sizes" class="R" name="size_'+ introw +'" /></div>'+	
	   '<div class="cols20"><div class="upload" id="upload'+ introw +'"></div></div>'+
	'<div class="full"><ul class="files" id="files'+ introw +'"></ul></div></div>';
		$('#colorgrid').append(str);
		createUploader(introw);
		color_picker();
		introw++;
	}
</script>    
<script type="text/javascript">
function color_picker(){
	$(".color").miniColors({
		letterCase: 'uppercase',
		change: function(hex, rgb) {}
	});
}
function createUploader(index){
	var uploader = new qq.FileUploader({
		element: document.getElementById('upload'+index),
		listElement: document.getElementById('files'+index),
		action: '../products-upload.php?page=tmp_products&index='+index
	});
}
$(document).ready(function(e) {
   color_picker();
   <?php if($cust){$i=0;foreach($cust as $c){echo "createUploader('".($i++)."');";}}?>
});
</script>
<form method="post" enctype="multipart/form-data" action="products.php?pre_category_id=<?php echo $_GET['pre_category_id']?>" name="brandform" id="brandform" onsubmit="return validate(document.forms['brandform']);">
	<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
        <tr>
            <th colspan="2"><?php echo (isset($data)) ? "Edit" : "Add" ;?> Product</th>
        </tr>
        <tr>
            <td width="25%"><label id="err_product_title">Product Title : </label><span class="error">*</span></td>
            <td><input type="text" size="40" title="Product Title" maxlength="50" class="R" name="product_title" id="product_title" value="<?php echo $_POST['product_title'];?>"/>
            </td>
        </tr>
        <tr>
        	<td> <label id="err_category_id" for="category_id">Select Category :</label> <span class="error">*</span></td>
        	<td><select id="category_id" name="category_id" class="R" title="Category" onchange="senddata('combos','type=sub_category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id='+this.value,'sub_category_id');"></select>
				<script>senddata('combos','type=category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&sel=<?php echo $data[0]['category_id'];?>','category_id');</script>
       		</td>
        </tr>
        <tr>
        	<td> <label id="err_sub_category_id" for="sub_category_id">Select Sub Category :</label> <span class="error"></span></td>
        	<td><select id="sub_category_id" name="sub_category_id" class="" title="Sub Category"></select>
				<script>senddata('combos','type=sub_category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id=<?php echo $data[0]['category_id']?>&sel=<?php echo $data[0]['sub_category_id'];?>','sub_category_id');</script>
       		</td>
        </tr>
        <tr>
    		<td><label for="featured_image" id="err_featured_image">Featured Image : </label><?php if($data[0]['featured_image']==''){?><span class="error">*</span><?php }?> (W 212 x H 325)</td>
            <td><div class="full"><input type="file" name="featured_image" id="featured_image" class="<?php if($data[0]['featured_image']==''){echo "R"; }?>isImg" title="Featured Image"/></div>
                <?php if($data[0]['featured_image']!=''){?><div class="full"><img src="<?php echo WEBSITE_URL."products/".$data[0]['featured_image'];?>" height="100" class="pic" /></div><?php }?>
            </td>
        </tr>
        <tr>
            <td><label id="err_product_price">Product Price : </label><span class="error">*</span></td>
            <td><input type="text" size="40" title="Product Price" class="RisNo" onkeypress="return numbersonly(this,event);" name="product_price" id="product_price" value="<?php echo $_POST['product_price'];?>" /></td>
        </tr>
        <tr>
    	<td><label for="color_section">Color Options : </label></td>
    	<td colspan="3">                            
            <div class="full grid fullform" id="colorgrid">
                <input type="hidden" id="del_color_ids" name="del_color_ids" value="" />
                <div class="rowshdr">
                    <div class="cols5"><a title="Add Color" class="add" href="javascript:;" onclick="addnewrowint();"></a></div>
                    <div class="cols15"><label>Color Family</label></div>
                    <div class="cols15"><label>Color</label></div>	
                    <div class="cols10"><label>Color Code</label></div>
                    <div class="cols30"><label>Sizes (sep by commas)</label></div>	
                    <div class="cols20"><label>Images (Min 1000 x 1500 Portrait)</label></div>
                </div>
                <?php if($cust){ $i=0; foreach($cust as $rows){?>
                <div class="rows">
                	<div class="cols5"><input type="hidden" name="color_id_<?php echo $i ?>" value="<?php echo $rows['color_id']?>" /><input type="hidden" name="index_id[]" value="<?php echo $i?>" /><a href="javascript:;" class="delete" onclick="if(confirm(\'Are you sure to delete Menu?\')){$(this).parent().parent().remove(); $('#del_color_ids').val($('#del_color_ids').val() + '<?php echo $rows['color_id'];?>,');}"></a></div>
                    <div class="cols15">
                    	<select title="Color Family" class="R" name="family_id_<?php echo $i;?>" >
						<?php if($color_family){foreach($color_family as $family){?>
                                <option value="<?php echo $family['family_id']?>" <?php echo $rows['family_id']==$family['family_id'] ? 'selected="selected"':''?>><?php echo $family['family_title']?></option>
                        <?php }} ?>
                        </select>
                    </div>
                    <div class="cols15"><input type="text" title="Color" class="R" name="color_title_<?php echo $i;?>" value="<?php echo $rows['color_title'];?>" /></div>
                    <div class="cols15"><input type="text" style="width:60px" title="Color Code" class="R color" name="color_code_<?php echo $i?>" value="<?php echo $rows['color_code'];?>" /></div>
                    <div class="cols25"><input type="text" title="Sizes" class="R" name="size_<?php echo $i?>" value="<?php echo $rows['size'];?>" /></div>
                    <div class="cols20"><div class="upload" id="upload<?php echo $i?>"></div></div>
                	<div class="full"><ul class="files" id="files<?php echo $i?>">
                    <?php if($result=$obj->SelectQuery("select * from product_gallery where product_id='".$data[0]['product_id']."' and color_id='".$rows['color_id']."'")){foreach($result as $item) { echo '<li class="success"><img src="'.WEBSITE_URL.'product_gallery/'.$item['product_id'].'/'.$item['color_id'].'/th_'.$item['img'].'" width="81" /><br><a href="javascript:;" onclick="if(confirm(\'Are you sure to delete Image\')){senddata(\'product-delete\',\'from=db&id='.$item['gallery_id'].'&subid='.$item['color_id'].'\',\'\');$(this).parent().remove();}">Delete</a></li>';}}?>
                    </ul></div>
              	</div>
                <?php $i++; }}?>
            </div>  
        </td>
    </tr>
    	<tr>
			<td><label for="product_description" id="err_product_description">Product Description</label></td>
            <td>
                <textarea id="product_description" name="product_description" rows="4" cols="80" title="Product Description"><?php echo $_POST['product_description'];?></textarea>	
            </td>
        </tr>
        <tr>
			<td><label for="delivery" id="err_delivery">Delivery</label></td>
            <td>
                <textarea id="delivery" name="delivery" rows="4" cols="80" title="Delivery"><?php echo $_POST['delivery'];?></textarea>	
            </td>
        </tr>
        <tr>
			<td><label for="return_policy" id="err_return_policy">Return Policy</label></td>
            <td>
                <textarea id="return_policy" name="return_policy" rows="4" cols="80" title="Return Policy"><?php echo $_POST['return_policy'];?></textarea>	
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <?php if($_REQUEST['action']=="edit"){?>
                <input type="hidden" name="product_id" value="<?php echo $_REQUEST['product_id']?>" />
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
		if($_REQUEST['category_id']!=""){ $where=" and category_id='".$_REQUEST['category_id']."'";}
		$query = "select * from products where pre_category_id='".$_REQUEST['pre_category_id']."' {$where} order by orderid asc";
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
    	<td><select id="category_id" name="category_id" class="R" title="Category" onchange="window.location.href='?action=display&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id='+this.value"><option value="">--Select Category--</option></select>
				<script>senddata('combos','type=category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&sel=<?php echo $_REQUEST['category_id'];?>','category_id');</script>
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
			echo '<li title="'.$item['product_id'].'">'.$item['product_title'].'</li>';
			$order[] = $item['product_id'];
		}?>	
    </ul>
	<input type="hidden" name="sort_order" id="sort_order" value="<?php echo implode(',',$order); ?>" />
    <div class="clear full">
	<input type="submit" name="do_submit" value="Submit Sortation" class="button" />
    </div>
	</form>
	</div>
	<?php } else{ ?>
    	<div class="full red">No product found</div>
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
                <select id="category_id" name="category_id" class="R" title="Category" onchange="senddata('combos','type=sub_category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id='+this.value,'sub_category_id');"></select>
				<script>senddata('combos','type=category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&sel=<?php echo $_REQUEST['category_id'];?>','category_id');</script>
                <select id="sub_category_id" name="sub_category_id" class="" title="Sub Category"></select>
				<script>senddata('combos','type=sub_category&pre_category_id=<?php echo $_REQUEST['pre_category_id']?>&category_id=<?php echo $_REQUEST['category_id']?>&sel=<?php echo $_REQUEST['sub_category_id'];?>','sub_category_id');</script>
                <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
                <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
                <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>?pre_category_id=<?php echo $_REQUEST['pre_category_id']?>';" />
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
        <th width="15%">Product Title</th>
        <th width="15%">Category</th>
        <th width="10%">Image</th>
        <th width="10%">Product Price</th>
        <th width="35%">Details</th>
        <th width="10%">Action</th>
    </tr> 
<?php $keyword = $obj->ReplaceSql($_REQUEST['keyword']);
	$alpha = $obj->ReplaceSql($_REQUEST['alpha']);
	$alpha = $obj->ReplaceSql($_REQUEST['alpha']);
	$category_id = $obj->ReplaceSql($_REQUEST['category_id']);
	$sub_category_id = $obj->ReplaceSql($_REQUEST['sub_category_id']);
	$where = '';
	if($keyword!=''){ $where .= " and (p.product_title like '%".$keyword."%')";}
	if($alpha!=''){	$where .= " and (p.product_title like '".$alpha."%')";}
	if($category_id!=''){	$where .= " and p.category_id='".$category_id."'";}	
	if($sub_category_id!=''){	$where .= " and p.sub_category_id='".$sub_category_id."'";}	
	$query="select p.*,c.category_title from products as p left outer join category as c on p.category_id=c.category_id where p.pre_category_id='".$_REQUEST['pre_category_id']."' $where order by p.orderid asc";
	$pager = new Pagination($query,$_REQUEST['page'],20,5);
	if($data = $pager->Paging()){
		$i = $pager->GetSNo();
		foreach ($data as $row){ ?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row['product_title'];?></td>
            <td><?php echo $row['category_title'];?></td>
           	<td><?php echo $obj->ImageExists("products",$row['featured_image'],100);?></td>
            <td><?php echo $row['product_price'];?></td>
            <td><div class="content"><?php echo $row['product_description'];?></div></td>
			<td>
				<a class="edit" href="?pre_category_id=<?php echo $_GET['pre_category_id'];?>&action=edit&product_id=<?php echo $row['product_id'];?>"></a>
				<a class="delete" href="?pre_category_id=<?php echo $_GET['pre_category_id'];?>&action=delete&product_id=<?php echo $row['product_id'];?>" onclick="return confirm('Are you sure you want to delete?');"></a>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="7" class="paging"><?php echo $pager->DisplayAllPaging("pre_category_id=".$_GET['pre_category_id']."&keyword=".$keyword."&alpha=".$alpha."&category_id=".$category_id."&sub_category_id=".$sub_category_id);?></td>
		</tr>
	<?php } else { ?>
		<tr>
			<td colspan="7" class="error">No Product Found!</td>
		</tr>
	<?php } ?>   
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>