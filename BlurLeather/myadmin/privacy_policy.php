<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=="delete"){
	$query="delete from privacy_policy where privacy_id='".$_REQUEST['privacy_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Privacy Policy has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	$query="update privacy_policy set privacy_title='".$obj->ReplaceSql($_POST['privacy_title'])."', privacy_content='".$obj->ReplaceSql($_POST['privacy_content'])."' where privacy_id='".$obj->ReplaceSql($_POST['privacy_id'])."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Privacy Policy has been updated successfully!";
	$obj->ReturnReferer();
}
if(isset($_POST['btnsave'])){
	$query="insert into privacy_policy set privacy_title='".$obj->ReplaceSql($_POST['privacy_title'])."', privacy_content='".$obj->ReplaceSql($_POST['privacy_content'])."'";
	$obj->InsertQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Privacy Policy has been added successfully!";
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
<div class="full"><h1>Manage Privacy Policy<?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
    <li><a href="?"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Privacy Policy</a></li>
    <li><a href="?action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['privacy_id'])){
        $query = "select * from privacy_policy where privacy_id='".$_REQUEST['privacy_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<form method="post" enctype="multipart/form-data" name="category" id="category" onsubmit="return validate(document.forms['category']);" >
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Privacy Policy</th>
	</tr>
    <tr>
    	<td width="20%"><label id="err_privacy_title">Privacy Policy Title : </label> <span class="error">*</span></td>
        <td><input type="text" title="Privacy Policy Title" class="R"  name="privacy_title" id="privacy_title" value="<?php echo (isset($data[0])) ? $data[0]['privacy_title'] : $_POST['privacy_title'];?>" size="40"/>
        </td>
	</tr>
     <tr>
    	<td><label id="err_privacy_content">Privacy Content : </label></td>
        <td><textarea id="privacy_content" name="privacy_content" rows="5" cols="80" class="R" title="Privacy Policy Content"><?php echo (isset($data[0])) ? $data[0]['privacy_content'] : $_POST['privacy_content'];?></textarea></td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="privacy_id" value="<?php echo $_REQUEST['privacy_id']?>" />
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
        if($alpha!=''){$where .= " and (privacy_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (privacy_title like '%".$keyword."%' or privacy_content like '%".$keyword."%')";}
        $query="select * from privacy_policy where 1=1 $where order by privacy_id desc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
        <th width="20%">Privacy Policy Title</th>
        <th width="60%">Privacy Policy Content</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
        <td><?php echo $row['privacy_title'];?></td>
        <td><div class="content"><?php echo $row['privacy_content'];?></div></td>
        <td>
        	<a href="?action=edit&privacy_id=<?php echo $row['privacy_id'] ?>" class="edit" title="Edit"></a>
            <a href="?action=delete&privacy_id=<?php echo $row['privacy_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="4" class="paging"><?php echo $pager->DisplayAllPaging("keyword=".$keyword."&alpha=".$alpha);?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="4" class="red txtcenter">No Privacy Policy Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>