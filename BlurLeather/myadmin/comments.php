<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
	$obj = new Admin();
	$obj->RequireLogin();
if($_REQUEST['action']=="delete"){
	$delquery="delete from comments where comment_id='".$_REQUEST['comment_id']."'";
	$obj->UpdateQuery($delquery);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Comment has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}	
if($_REQUEST['action']=="disapproved"){
	$obj->UpdateQuery("update comments set approved='0' where comment_id='".$_REQUEST['comment_id']."'");
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Comment has been Deactivated successfully";
	$obj->ReturnReferer();
}
if($_REQUEST['action']=="approved"){
	$obj->UpdateQuery("update comments set approved='1' where comment_id='".$_REQUEST['comment_id']."'");
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Comment has been Activated successfully";
	$obj->ReturnReferer();
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php"); ?>
<title>Admin Panel</title>
</head>
<body>
<?php include_once("message.php"); ?>
<h1>Manage Comments <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
    <?php $obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <tr>
    	<td colspan="10">
        	<form>
                <input type="text" name="keyword" id="keyword" value="Search Full Name, Email" onfocus="if(this.value==this.defaultValue){this.value='';}" size="60"/>
                <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Full Name, Email'){$('#keyword').val('');}" />
                <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
            </form>
        </td>
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
    <tr>
    	<th>Sr. No.</th>
    	<th>Full Name</th>
        <th>Email</th>
        <th>Comment</th>
        <th>Approved</th>
        <th>Delete</th>
  	</tr>
    <?php
		$keyword = $obj->ReplaceSql($_REQUEST['keyword']);
		$alpha = $obj->ReplaceSql($_REQUEST['alpha']);
		$where = '';
		if($keyword!=''){
			$where .= " and (username like '".$keyword."%' or username like '% ".$keyword."%' or first_name like '".$keyword."%' or first_name like '".$keyword."%' or last_name like '".$keyword."%' or last_name like '".$keyword."%')";
		}
		if($alpha!=''){
			$where .= " and (full_name like '".$alpha."%')";
		}
    	$query="select * from comments where 1=1 $where order by comment_id desc";
		$pager = new Pagination($query,$_REQUEST['page'],20,5);
		if($data = $pager->Paging()){
			$i = $pager->GetSNo();
			foreach ($data as $row){ ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row['full_name'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['comment'];?></td>
                <td>
                	<?php if($row['approved']=='0'){?>
                    	<a href="?action=approved&comment_id=<?php echo $row['comment_id'];?>" class="deactive" title="Approved"></a>
					<?php } else { ?>
                        <a href="?action=disapproved&comment_id=<?php echo $row['comment_id'];?>" class="active" title="Disapproved"></a>
                    <?php } ?>
                </td>  
                <td>
                	<a href="?action=delete&comment_id=<?php echo $row['comment_id'] ?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
                </td>              
            </tr>
	    <?php } ?>
    <tr>
    	<td colspan="6" class="paging"><?php echo $pager->DisplayAllPaging();?></td>
    </tr>
    <?php }else{?>
    <tr>
    	<td colspan="10" class="red">No Comment found</td>
    </tr>
    <?php } ?>
    </table>
<?php include_once("footer.php");?>
</body>
</html>