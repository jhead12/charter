<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=='delete'){
	$query="delete from contacts where contact_id='".$obj->ReplaceSql($_REQUEST['contact_id'])."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Contact Info has been deleted successfully!";
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
<div class="full"><h1>Contacts Info <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<?php require_once("message.php");?>
<?php $obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
	    <tr>
        <th colspan="8">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="8" class="paging">
        <?php for($i=65;$i<=90;$i++){ 
        if($_REQUEST['alpha']==chr($i)){?>
        <?php echo "<b>" . chr($i) ."</b>"?>
        <?php } else { ?>	
        <a href="?alpha=<?php echo chr($i)?>" title="[<?php echo chr($i)?>]"><?php echo chr($i)?></a>
        <?php }}?>
        </td>
	</tr>      
    <tr>
	    <th width="10%">S. No</th>
        <th width="10%">Enquiry Type</th>
        <th width="10%">Name</th>
        <th width="10%">Email</th>
        <th width="10%">Telephone</th>
        <th width="10%">Country</th>
        <th width="20%">Message</th>
        <th width="10%">Delete</th>
    </tr> 
    <?php 
        $keyword = $obj->ReplaceSql($_REQUEST['keyword']);
        $alpha = $obj->ReplaceSql($_REQUEST['alpha']);
        $where = '';
        if($alpha!=''){$where .= " and (your_name like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (your_name like '%".$keyword."%' or your_email like '%".$keyword."%' or country like '%".$keyword."%' or telephone like '%".$keyword."%' or message like '%".$keyword."%')";}
    	$query="select * from contacts where 1=1 {$where} order by contact_id desc";
		$pager = new Pagination($query,$_REQUEST['page'],20,5);
		if($data = $pager->Paging()){
			$i = $pager->GetSNo();
			foreach ($data as $row){ ?>
            <tr>
                <td><?php echo $i++;?></td> 
                <td><?php echo $row['enquiry_type'];?></td>
                <td><?php echo $row['your_name'];?></td>
                <td><?php echo $row['your_email'];?></td>
                <td><?php echo $row['telephone'];?></td>
                <td><?php echo $row['country'];?></td>
                <td><?php echo $row['message'];?></td>
                <td>
                    <a class="delete" onclick="return confirm('Are you sure to delete?');" href="?action=delete&contact_id=<?php echo $row['contact_id'];?>"></a>
                </td>
            </tr>
	    <?php } ?>
         <tr>
            <td colspan="8" class="paging"><?php echo $pager->DisplayAllPaging("alpha=".$alpha."&keyword=".$keyword);?></td>
        </tr>
       <?php } else{ ?> 
       		<tr>
            	<td colspan="8" class="red">
            		No contact found
            	</td>
            </tr>
       <?php } ?>
    </table>
<?php include_once("footer.php");?>
</body>
</html>