<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
$_SESSION['IMG_LARGE']['W'] = 586;
$_SESSION['IMG_LARGE']['H'] = 240;
$_SESSION['IMG_THUMB']['W'] = 120;
$_SESSION['IMG_THUMB']['H'] = 60;
if($_REQUEST['action']=="delete"){
	$query="delete from studio_rentals where rental_id='".$_REQUEST['rental_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Studio Rental has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	$query="update studio_rentals set rental_title='".$obj->ReplaceSql($_POST['rental_title'])."', rental_desc='".$obj->ReplaceSql($_POST['rental_desc'])."' where rental_id='".$obj->ReplaceSql($_POST['rental_id'])."'";
	$obj->UpdateQuery($query);
	if($_FILES['rental_image']['name']!=''){
		$photo = array("name"=>$_FILES['rental_image']['name'],"tmp_name"=>$_FILES['rental_image']['tmp_name']);
		$obj->UploadImageFix($photo,"studio_rentals","rental_image","rental_id",$_POST['rental_id'],$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H']);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Studio Rental has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into studio_rentals set rental_title='".$obj->ReplaceSql($_POST['rental_title'])."', rental_desc='".$obj->ReplaceSql($_POST['rental_desc'])."'";
	$id=$obj->InsertQuery($query);
	if($_FILES['rental_image']['name']!=''){
		$photo = array("name"=>$_FILES['rental_image']['name'],"tmp_name"=>$_FILES['rental_image']['tmp_name']);
		$obj->UploadImageFix($photo,"studio_rentals","rental_image","rental_id",$id,$_SESSION['IMG_LARGE']['W'],$_SESSION['IMG_LARGE']['H'],$_SESSION['IMG_THUMB']['W'],$_SESSION['IMG_THUMB']['H']);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Studio Rental has been added successfully!";
	$obj->ReturnReferer();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
</head>
<body>
<?php require_once("message.php");?>
<div class="full"><h1>Manage Studio Rentals <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<?php /*?><ul class="tabs">
    <li><a href="?"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Studio Rentals</a></li>
    <li><a href="?action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul><?php */?>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['rental_id'])){
        $query = "select * from studio_rentals where rental_id='".$_REQUEST['rental_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<script type="text/javascript" src="js/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { 
		new nicEditor().panelInstance('rental_desc');
	});
</script>
<form method="post" enctype="multipart/form-data" name="prodform" id="prodform" onsubmit="return validate(document.forms['prodform']);">
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Studio rentals</th>
	</tr>
    <tr>
    	<td width="20%"><label id="err_rental_title">Rental Title : </label> <span class="error">*</span></td>
        <td><input type="text" title="Rental Title" class="R"  name="rental_title" id="rental_title" value="<?php echo (isset($data[0])) ? $data[0]['rental_title'] : $_POST['rental_title'] ;?>"/>
        </td>
	</tr>
   
    <tr>
    	<td><label for="rental_image" id="err_rental_image">Rental Image : </label> <?php echo (isset($data[0])) ? '' : '<span class="error">*</span> ' ;?> (Width x Height, <?php echo $_SESSION['IMG_LARGE']['W']." x ".$_SESSION['IMG_LARGE']['H'];?>) </td>
        <td colspan="3"><div class="full"><input type="file" name="rental_image" id="rental_image" class="isImag" title="Rental Image"/></div>
            <?php if($data[0]['rental_image']!=''){?><div class="full"><img src="../studio_rentals/th_<?php echo $data[0]['rental_image'];?>" height="100" class="pic" /></div><?php }?>
		</td>
	</tr>
     <tr>
    	<td><label id="err_rental_desc">Description : </label></td>
        <td>
         <div class="rows">
        	<div class="cols100">
            	<div id="paths"></div>
            </div>
            <div class="cols100">
        <a class="prettybox" href="uploadimg.php?type=studio_rentals&width=350&height=100&iframe=true">Upload Image</a> (Upload image to insert in Text editor) e.g. Image size should be [Width x Height] [600 x 600]
        	</div>
        </div>
        <div class="rows">
        <textarea title="Description" rows="4" cols="80" name="rental_desc" id="rental_desc"><?php echo (isset($data[0])) ? $data[0]['rental_desc'] : $_POST['rental_desc'] ;?></textarea>
        </div>
        </td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="rental_id" value="<?php echo $_REQUEST['rental_id']?>" />
            <input type="submit" name="btnupdate" value="Update" class="button" />
            <?php }else{?>
            <input type="submit" name="btnsave" value="Save" class="button" />
            <?php }?>
            <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" />
        </td>
	</tr>
</table>
</form>
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
        if($alpha!=''){$where .= " and (rental_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (rental_title like '".$keyword."%' or rental_title like '% ".$keyword."%')";}
        $query="select * from studio_rentals where 1=1 $where order by rental_id";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="15%">Rental Image</th>
        <th width="15%">Rental Title</th>
        <th width="50%">Description</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
    	<td><img src="../studio_rentals/th_<?php echo $row['rental_image'];?>" class="pic" /></td>
        <td><?php echo $row['rental_title'];?></td>
        <td><div class="content"><?php echo $row['rental_desc'];?></div></td>
        <td>
        	<a href="?action=edit&rental_id=<?php echo $row['rental_id'] ?>" class="edit" title="Edit"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="5" class="paging"><?php echo $pager->DisplayAllPaging();?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="5" class="txtcenter">No Studio Rental Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>