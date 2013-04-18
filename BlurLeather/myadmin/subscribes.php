<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=='delete'){
	$query="delete from subscribes where subscribe_id='".$obj->ReplaceSql($_REQUEST['subscribe_id'])."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Subscribe Info has been deleted successfully!";
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
<div class="full"><h1>Subscribed Members Info <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<?php require_once("message.php");?>
<?php $obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
	    <tr>
        <th colspan="7">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
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
	    <th width="10%">S. No</th>
        <th width="15%">First Name</th>
        <th width="15%">Surname</th>
        <th width="15%">Email</th>
        <th width="15%">Country</th>
        <th width="15%">Section</th>
        <th width="10%">Delete</th>
    </tr> 
    <?php 
        $keyword = $obj->ReplaceSql($_REQUEST['keyword']);
        $alpha = $obj->ReplaceSql($_REQUEST['alpha']);
        $where = '';
        if($alpha!=''){$where .= " and (s.first_name like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (s.first_name like '%".$keyword."%' or s.surname like '%".$keyword."%' or s.email like '%".$keyword."%' or c.country_title like '%".$keyword."%')";}
    	$query="select * from subscribes as s inner join country as c on s.country_id=c.country_id where 1=1 {$where} order by s.subscribe_id desc";
		$pager = new Pagination($query,$_REQUEST['page'],20,5);
		if($data = $pager->Paging()){
			$i = $pager->GetSNo();
			foreach ($data as $row){ ?>
            <tr>
                <td><?php echo $i++;?></td> 
                <td><?php echo $row['saluation'];?> <?php echo $row['first_name'];?></td>
                <td><?php echo $row['surname'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['country_title'];?></td>
                <td><?php echo $row['womenswear']!=""?$row['womenswear']:'';?> <?php echo $row['menswear']!=""?$row['menswear']:'';?></td>
                <td>
                    <a class="delete" onclick="return confirm('Are you sure to delete?');" href="?action=delete&subscribe_id=<?php echo $row['subscribe_id'];?>"></a>
                </td>
            </tr>
	    <?php } ?>
         <tr>
            <td colspan="7" class="paging"><?php echo $pager->DisplayAllPaging("keyword=".$keyword."&alpha=".$alpha);?></td>
        </tr>
       <?php } else{ ?> 
       		<tr>
            	<td colspan="7" class="red">
            		No subscription found
            	</td>
            </tr>
       <?php } ?>
    </table>
<?php include_once("footer.php");?>
</body>
</html>