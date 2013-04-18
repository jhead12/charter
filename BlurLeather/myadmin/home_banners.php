<?php require_once("../class/class.admin.php");
	require_once("../class/class.ImageResize.php");
	require_once("../class/class.youtube.php");
	$obj = new Admin();
	$obj->RequireLogin();
	$image = new ImageResize();
	$Y = new YouTube();
	$date=date("Y-m-d H:i:s");
	if(isset($_POST['btnupdate']) || isset($_POST['btnsave'])){
		if(isset($_POST['btnsave'])){
			$query="insert into home_banners set banner_title='".$obj->ReplaceSql($_POST['banner_title'])."', tag='".$obj->ReplaceSql($_POST['tag'])."', banner_sub_title='".$obj->ReplaceSql($_POST['banner_sub_title'])."', banner_video_url='".$obj->ReplaceSql($_POST['banner_video_url'])."', page_url='".$obj->ReplaceSql($_POST['page_url'])."'";
			$banner_id = $obj->InsertQuery($query);
			$obj->UpdateQuery("update home_banners set orderid = ".$banner_id." where banner_id = ".$banner_id);
			$_SESSION['ERRORTYPE'] = "success";
			$_SESSION['ERRORMSG'] = "Home Banner added sucsessfully";
		}
		if(isset($_POST['btnupdate'])){
			$query="update home_banners set banner_title='".$obj->ReplaceSql($_POST['banner_title'])."', tag='".$obj->ReplaceSql($_POST['tag'])."', banner_sub_title='".$obj->ReplaceSql($_POST['banner_sub_title'])."', banner_video_url='".$obj->ReplaceSql($_POST['banner_video_url'])."',page_url='".$obj->ReplaceSql($_POST['page_url'])."' where banner_id='".$_POST['banner_id']."'";
			$obj->UpdateQuery($query);
			$banner_id = $_POST['banner_id'];
			$_SESSION['ERRORTYPE'] = "success";
			$_SESSION['ERRORMSG'] = "Home Banner updated sucsessfully";
		}
		if($_FILES['_img']['name']!=""){
			$obj->FixedUploadImage($_FILES['_img'],"home_banners","banner_image","banner_id",$banner_id,1980,1080,339,215,true);
		}
		$obj->ReturnReferer();
	}
	if(isset($_POST['do_submit']))  {
  		$ids = explode(',',$_POST['sort_order']);
	  	foreach($ids as $index=>$id) {
    		$id = (int) $id;
    		if($id != '') {
    	  		$obj->UpdateQuery("update home_banners set orderid = ".($index + 1)." WHERE banner_id = ".$id);
    		}
  		}
  		if($_POST['byajax']) { die(); } else { $message = 'Sortation has been saved.'; }
	}
	if($_REQUEST['T']=='D'){
		$data = $obj->SelectQuery("select banner_image from home_banners where banner_id='".$_REQUEST['banner_id']."'");
		@unlink("../home_banners/".$data[0]['banner_image']);
		@unlink("../home_banners/th_".$data[0]['banner_image']);
		$query="delete from home_banners where banner_id='".$_REQUEST['banner_id']."'";
		$obj->UpdateQuery($query);
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Home Banner deleted sucsessfully";
		$obj->ReturnReferer();
		exit();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php"); ?>
<style type="text/css">
.clear{ clear:both; width:100%; float:left;}
#sortable-list	{ padding:0; margin:0px; width:100%;}
#sortable-list li{ padding:5px; color:#000; cursor:move; list-style:none; float:left; background:#ddd; margin:5px; border:1px solid #999; }
#message-box{ background:#fffea1; border:2px solid #fc0; padding:4px 8px; margin:0 0 14px 0; width:500px; }
</style>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
	function deleteconfirm(val){
		if (confirm('Are you want to delete?')){
			window.location='?T=D&banner_id='+val;
		}
	}
	/* when the DOM is ready */
	jQuery(document).ready(function() {
		
		$('#tag').change(function(e) {
			$('#banner_video_url,#_img').attr('class','').attr('disabled',true);
            if($(this).val()=='I'){
				$('#_img').attr('disabled',false);
			}else if($(this).val()=='V'){
				$('#banner_video_url').attr('disabled',false);
			}
        });
		
		
		$('#banner_video_url,#_img').attr('class','').attr('disabled',true);
		if($('#tag').val()=='I'){
			$('#_img').attr('disabled',false);
		}else if($('#tag').val()=='V'){
			$('#banner_video_url').attr('disabled',false);
		}
		
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
<div class="full">
<h1>Manage Home Banners <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
</div>
<?php require_once("message.php");?>
	<?php if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
			if($_REQUEST['action']=="edit" && isset($_REQUEST['banner_id'])){
				$query = "select * from home_banners where banner_id='".$_REQUEST['banner_id']."'";
				$data = $obj->SelectQuery($query);}?>
        <form method="post" enctype="multipart/form-data" name="topform" id="topform" onsubmit="return validate(document.forms['topform']);">
            <table width="100%" cellspacing="1" cellpadding="3" class="tbl">	
            <tr>
            	<th colspan="2"><?php echo (isset($data)) ? "Edit" : "Add" ;?> Banner Image</th>
            </tr>
            <tr>
				<td width="25%"><label for="banner_title" id="err_banner_title">Banner Title :</label></td>
                <td><input type="text" size="40" name="banner_title" id="banner_title" title="Banner Title" class="" value="<?php echo $data[0]['banner_title'];?>" />
                </td>
			</tr>
            <tr>
				<td width="25%"><label for="banner_sub_title" id="err_banner_sub_title">Banner Sub Title :</label></td>
                <td><input type="text" size="40" name="banner_sub_title" id="banner_sub_title" title="Banner Sub Title" class="" value="<?php echo $data[0]['banner_sub_title'];?>" />
                </td>
			</tr>
            <tr>
				<td width="25%"><label for="tag" id="err_tag">Banner Type :</label></td>
                <td><select name="tag" id="tag" title="Banner Type" class="R">
                	<option value="">-Select Any-</option>
                    <option value="I"<?php echo $data[0]['tag']=='I' ? ' selected="selected"':'';?>>Image</option>
                    <option value="V"<?php echo $data[0]['tag']=='V' ? ' selected="selected"':'';?>>Video</option>
                </select>
                </td>
			</tr>
            
            <tr>
				<td width="25%"><label for="banner_video_url" id="err_banner_video_url">Banner Video URL :</label></td>
                <td><input type="text" size="40" name="banner_video_url" id="banner_video_url" title="Banner Video URL" class="" value="<?php echo $data[0]['banner_video_url'];?>" /> 	e.g. http://www.youtube.com/watch?v=nO8uijKTurg
                </td>
			</tr>
            <tr>
				<td width="25%"><label for="page_url" id="err_page_url">Page URL :</label></td>
                <td><input type="text" size="40" name="page_url" id="page_url" title="Page URL" class="" value="<?php echo $data[0]['page_url'];?>" /> 	e.g. http://www.leatherblur.com/pagename.php
                </td>
			</tr>
            <tr>
				<td><label for="_img" id="err__img">Banner Image :</label> <?php if($data[0]['banner_image']==''){?> <span class="red">*</span> <?php } ?>(Width x Height, 1980 x 1080)</td>
                <td>
                	<input type="file" name="_img" id="_img" title="Image" class="<?php echo $data[0]['banner_image']=='' ? 'R':'';?>isImg" />
                    <?php if($obj->ImageExists("home_banners",$data[0]['banner_image'])){?>
                    <div class="full paddtop10"><img src="../home_banners/th_<?php echo $data[0]['banner_image'];?>" /></div>
					<?php }?>
                </td>
			</tr>
			<tr>
            	<td>&nbsp;</td>
                <td>
                	<?php if($_REQUEST['action']=="edit"){?>
                    <input type="hidden" name="banner_id" value="<?php echo $_REQUEST['banner_id']?>" />
                	<input type="submit" name="btnupdate" value="Update" class="button" />
                    <?php }else{?>
                    <input type="submit" name="btnsave" value="Add" class="button" />
                    <?php }?>
                    <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" />
               	</td>
            </tr>
            </table>
       	</form>
    <?php }else{ $obj->SetCurrentUrl();
		$query = "select * from home_banners order by orderid asc";
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
    	<td><input type="button" onclick="window.location='?action=add';" value="Add New Image" class="button" /></td>
    </tr>
    <tr>
    	<td>
<?php if($result){?>
	<div id="content-left">
	<div id="message-box"> <?php echo $message; ?> Waiting for sortation submission...</div>
	<form id="dd-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<p>
		<input type="checkbox" value="1" name="autoSubmit" id="autoSubmit" <?php if($_POST['autoSubmit']) { echo 'checked="checked"'; } ?> />
		<label for="autoSubmit">Automatically submit on drop event</label>
	</p>
	<ul id="sortable-list">
	<?php $order = array();
		foreach($result as $item) {
			echo '<li title="'.$item['banner_id'].'"><a href="javascript:deleteconfirm(\''.$item['banner_id'].'\');" title="Delete" class="delete"></a>&nbsp;<a href="?action=edit&banner_id='.$item['banner_id'].'" title="Edit" class="edit"></a><br /><br /><img src="'.($item['tag']=='I' ? '../home_banners/th_'.$item['banner_image']:$Y->getYoutubeImgurl($item['banner_video_url'])).'" height="90" /></li>';
			$order[] = $item['banner_id'];
		}?>	
    </ul>
	<input type="hidden" name="sort_order" id="sort_order" value="<?php echo implode(',',$order); ?>" />
    <div class="clear">
	<input type="submit" name="do_submit" value="Submit Sortation" class="button" />
    </div>
	</form>
	</div>
	<?php } ?>
<?php } ?>
		</td>
    </tr> 
    </table>
<?php include_once("footer.php");?>
</body>
</html>