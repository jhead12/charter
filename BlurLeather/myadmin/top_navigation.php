<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=="deactive"){
	$obj->UpdateQuery("update pre_category set status='0' where pre_category_id='".$_REQUEST['pre_category_id']."'");
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Navigation has been Deactivated successfully";
	$obj->ReturnReferer();
}
if($_REQUEST['action']=="active"){
	$obj->UpdateQuery("update pre_category set status='1' where pre_category_id='".$_REQUEST['pre_category_id']."'");
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Navigation has been Activated successfully";
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
<div class="full"><h1>Manage Top Navigation <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
    <li><a href="?" <?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Navigation</a></li>
</ul>
<?php if($_REQUEST['action']==""){
	$obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
    <?php 
        $query="select * from pre_category where pre_category_id!='1' order by pre_category_id asc";
        $pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
        <th width="40%">Navigation Title</th>
        <th width="20">Display Status</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td>
        <td><?php echo $row['pre_category_title'];?></td>
        <td><?php echo $row['status']=='1'?'Approved':'Not Approved';?></td>
        <td>
        	<?php if($row['status']=='0'){?>
                    <a href="?action=active&pre_category_id=<?php echo $row['pre_category_id'];?>" class="deactive" title="Active"></a>
                <?php } else { ?>
                    <a href="?action=deactive&pre_category_id=<?php echo $row['pre_category_id'];?>" class="active" title="Deactive"></a>
                <?php } ?>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="4" class="paging"><?php echo $pager->DisplayAllPaging("pre_categpory_id=".$_REQUEST['pre_categpory_id']."&alpha=".$alpha."&keyword=".$keyword);?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="4" class="txtcenter">No Navigation Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>