<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=='delete'){
	$query="delete from newsletter_emails where newsletter_id='".$obj->ReplaceSql($_REQUEST['id'])."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Newsletter has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php"); ?>
</head>
<body>
<div class="full"><h1>Newsletter Emails <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<?php require_once("message.php");?>
<?php $obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <tr>
	    <th width="10%">S No</th>
        <th width="15%">Name</th>
        <th width="15%">Phone</th>
        <th width="15%">Email</th>
        <th width="10%">Delete</th>
    </tr> 
    <?php 
    	$query="select * from newsletter_emails order by newsletter_id desc";
		$pager = new Pagination($query,$_REQUEST['page'],20,5);
		if($data = $pager->Paging()){
			$i = $pager->GetSNo();
			foreach ($data as $row){ ?>
            <tr>
                <td><?php echo $i++;?></td> 
                <td><?php echo $row['newsletter_email'];?></td>
                <td><?php echo $row['newsletter_phone'];?></td>
                <td><?php echo $row['newsletter_email'];?></td>
                <td>
                    <a class="delete" onclick="return confirm('Are you sure to delete?');" href="?action=delete&id=<?php echo $row['newsletter_id'];?>"></a>
                </td>
            </tr>
	    <?php } ?>
         <tr>
            <td colspan="5" class="paging"><?php echo $pager->DisplayAllPaging();?></td>
        </tr>
       <?php } else{ ?> 
       		<tr>
            	<td colspan="5" class="red">
            		No newsletter found
            	</td>
            </tr>
       <?php } ?>
    </table>
<?php include_once("footer.php");?>
</body>
</html>