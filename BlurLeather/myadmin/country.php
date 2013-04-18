<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=="delete"){
	$query="delete from country where country_id='".$_REQUEST['country_id']."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Country has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
if(isset($_POST['btnupdate'])){
	if($obj->ValueExists("country","country_title",$obj->ReplaceSql($_POST['country_title']),"country_id",$obj->ReplaceSql($_POST['country_id']))==false){
	$query="update country set country_title='".$obj->ReplaceSql($_POST['country_title'])."',country_code='".$obj->ReplaceSql($_POST['country_code'])."', country_symbol='".$obj->ReplaceSql($_POST['country_symbol'])."' where country_id='".$obj->ReplaceSql($_POST['country_id'])."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Country has been updated successfully!";
	$obj->ReturnReferer();
	} else {
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Country Already Exists";
	}
}
if(isset($_POST['btnsave'])){
	if($obj->ValueExists("country","country_title",$obj->ReplaceSql($_POST['country_title']))==false){	
	$query="insert into country set country_title='".$obj->ReplaceSql($_POST['country_title'])."',country_code='".$obj->ReplaceSql($_POST['country_code'])."',  country_symbol='".$obj->ReplaceSql($_POST['country_symbol'])."'";
	$country_id=$obj->InsertQuery($query);
	$obj->UpdateQuery("update country set orderid = ".$country_id." where country_id = ".$country_id);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Country has been added successfully!";
	$obj->ReturnReferer();
	} else {
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Country Already Exists";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
</head>
<body>
<?php require_once("message.php");?>
<div class="full"><h1>Manage Country <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1></div>
<ul class="tabs">
    <li><a href="?"<?php echo $_GET['action']!='add' ? ' class="current"': '';?>>List of Country</a></li>
    <li><a href="?action=add"<?php echo $_GET['action']=='add' ? ' class="current"': '';?>>Add New</a></li>
</ul>
<?php 
    if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
    if($_REQUEST['action']=="edit" && isset($_REQUEST['country_id'])){
        $query = "select * from country where country_id='".$_REQUEST['country_id']."'";
        $data = $obj->SelectQuery($query); 
    }?>
<form method="post" enctype="multipart/form-data" name="country" id="country" onsubmit="return validate(document.forms['country']);" >
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
	<tr>
    	<th colspan="2">Create Sub Country</th>
	</tr>
     <tr>
    	<td width="20%"><label id="err_country_title">Country Title : </label> <span class="error">*</span></td>
        <td><input type="text" title="Country Title" class="R"  name="country_title" id="country_title" value="<?php echo (isset($data[0])) ? $data[0]['country_title'] : $_POST['country_title'];?>" size="40"/>
        </td>
	</tr>
    <tr>
        <td width="20%"><label id="err_country_symbol" for="country_symbol">Country Symbol : </label><span class="error">*</span></td>
        <td>
           <input type="text" title="Country Symbol" class="R"  name="country_symbol" id="country_symbol" value="<?php echo (isset($data[0])) ? $data[0]['country_symbol'] : $_POST['country_symbol'];?>" size="40"/>
        </td>
    </tr>
   <tr>
        <td width="20%"><label id="err_country_code" for="country_code">Country Code : </label><span class="error">*</span></td>
        <td>
           <input type="text" title="Country Code" class="R"  name="country_code" id="country_code" value="<?php echo (isset($data[0])) ? $data[0]['country_code'] : $_POST['country_code'];?>" size="40"/>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td class="txtcenter">
            <?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="country_id" value="<?php echo $_REQUEST['country_id']?>" />
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
        <th colspan="6">
        <form> 
			keywords: 
            <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
            <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
            <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
		 </form>
        </th>
    </tr>
    <tr>
        <td colspan="6" class="paging">
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
		if($alpha!=''){$where .= " and (country_title like '".$alpha."%')";}
        if($keyword!=''){$where .= " and (country_title like '%".$keyword."%')";}
        $query="select * from country where 1=1 $where order by country_title";
		$pager = new Pagination($query,$_REQUEST['page'],20,5);
        if($data = $pager->Paging()){$i = $pager->GetSNo();?>
	<tr>
    	<th width="10%">Sr. No</th>
    	<th width="30%">Country Title</th>
        <th width="20%">Country Symbol</th>
        <th width="30%">Country Code</th>
        <th width="10%">Action</th>
    </tr>
    <?php foreach ($data as $row){?>
	<tr>
    	<td><?php echo $i++;?></td> 
        <td><?php echo $row['country_title'];?></td>
        <td><?php echo $row['country_symbol'];?></td>
        <td><?php echo $row['country_code'];?></td>
        <td>
        	<a href="?action=edit&country_id=<?php echo $row['country_id']?>" class="edit" title="Edit"></a>
            <a href="?action=delete&country_id=<?php echo $row['country_id']?>" onclick="return confirm('Are you sure to delete?')" class="delete" title="Delete"></a>
		</td>            
	</tr>
        <?php } ?>
		<tr><td colspan="5" class="paging"><?php echo $pager->DisplayAllPaging("alpha=".$alpha."&keyword=".$keyword);?></td></tr>
    <?php } else { ?>
    	<tr><td colspan="5" class="txtcenter">No Country Found!</td></tr>
    <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>