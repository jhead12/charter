<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=="deactive"){
	$obj->UpdateQuery("update members set status='0' where member_id='".$_REQUEST['member_id']."'");
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Member has been Deactivated successfully";
	$obj->ReturnReferer();
}
if($_REQUEST['action']=="active"){
	$obj->UpdateQuery("update members set status='1' where member_id='".$_REQUEST['member_id']."'");
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Member has been Activated successfully";
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
<h1>Manage Members <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
<ul class="tabs">
    <li><a href="members.php?status=0">Disabled Members</a></li>
    <li><a href="members.php?status=1" class="current">Enabled Members</a></li>
</ul>
    <?php $obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <tr>
    	<td colspan="7">
        	<form>
                <input type="text" name="keyword" id="keyword" value="Search" onfocus="if(this.value==this.defaultValue){this.value='';}" size="60"/>
                <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search'){$('#keyword').val('');}" />
                <input type="hidden" name="status" value="<?php echo $_REQUEST['status']?>" />
                <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
            </form>
        </td>
    </tr>
    <tr>
    	<td colspan="7" class="paging">
        	Search by alphabets:
			<?php for($i=65;$i<=90;$i++){ 
            if($_REQUEST['alpha']==chr($i)){?>
            <?php echo "<b>" . chr($i) ."</b>"?>
            <?php } else { ?>	
            <a href="?alpha=<?php echo chr($i)?>" title="[<?php echo chr($i)?>]"><?php echo chr($i)?></a>
            <?php }}?> 
        </td>
    </tr>
    <tr>
    	<th width="10%">Sr. No.</th>
        <th width="10%">First Name</th>
    	<th width="10%">Surname</th>
        <th width="10%">Email</th>
        <th width="10%">Password</th>
        <th width="15%">Section</th>
        <th width="10%">Status</th>
  	</tr>
    <?php
		$keyword = $obj->ReplaceSql($_REQUEST['keyword']);
		$alpha = $obj->ReplaceSql($_REQUEST['alpha']);
		$where = '';
		if($keyword!=''){
			$where .= " and (first_name like '%".$keyword."%' or last_name like '%".$keyword."%' or email like '%".$keyword."%')";
		}
		if($alpha!=''){
			$where .= " and (first_name like '".$alpha."%')";
		}
		if($_REQUEST['status']!=""){ $where.= " and status='".$_REQUEST['status']."'";}else{$where.= " and status='1'";}
    	$query="select * from members where 1=1  $where order by first_name";
		$pager = new Pagination($query,$_REQUEST['page'],20,5);
		if($data = $pager->Paging()){
			$i = $pager->GetSNo();
			foreach ($data as $row){ ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row['first_name'];?></td>
                <td><?php echo $row['surname'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['password'];?></td>
                <td><?php echo $row['womenswear']!=""?$row['womenswear']:'';?> <?php echo $row['menswear']!=""?$row['menswear']:'';?></td>
                <td>
                	<?php if($row['status']=='0'){?>
                    	<a href="?action=active&member_id=<?php echo $row['member_id'];?>" class="deactive" title="Active"></a>
					<?php } else { ?>
                        <a href="?action=deactive&member_id=<?php echo $row['member_id'];?>" class="active" title="Deactive"></a>
                    <?php } ?>
                </td>                
            </tr>
	    <?php } ?>
    <tr>
    	<td colspan="7" class="paging"><?php echo $pager->DisplayAllPaging("status=".$_REQUEST['status']."&alpha=".$alpha."&keyword=".$keyword);?></td>
    </tr>
    <?php }else{?>
    <tr>
    	<td colspan="7" class="red">No member found</td>
    </tr>
    <?php } ?>
    </table>
<?php include_once("footer.php");?>
</body>
</html>