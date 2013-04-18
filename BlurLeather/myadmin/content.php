<?php require_once("../class/class.admin.php");
	$fn = new Admin();
	$fn->RequireLogin();
	if(isset($_POST['btnupdate'])){
		$query="update content_table set content_desc='".$fn->ReplaceSql($_POST['content_desc'])."', page_title='".$fn->ReplaceSql($_POST['page_title'])."' where content_title='".$fn->ReplaceSql($_POST['ctitle'])."'";
		$fn->UpdateQuery($query);
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Page content has been updated sucsessfully";
		$fn->ReturnReferer();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php"); ?>
</head>
<body>
<div class="full">
  <h1>Manage Content    <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?>
    <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?>
    <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?>
  </h1>
</div>
<?php require_once("message.php");?>
<?php 
	if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
	if($_REQUEST['action']=="edit"){
		$query="select * from content_table where content_title='".$fn->ReplaceSql($_GET['ctitle'])."'";
		$data = $fn->SelectQuery($query);
		$_POST['content_title'] = (isset($_POST['content_title'])) ? $_POST['content_title'] : $data[0]['content_title'];
		$_POST['page_title'] = (isset($_POST['page_title'])) ? $_POST['page_title'] : $data[0]['page_title'];
		$_POST['content_desc'] = (isset($_POST['content_desc'])) ? $_POST['content_desc'] : $data[0]['content_desc'];
	}?>
<form name="form1" id="form1" method="post" enctype="multipart/form-data" onsubmit="return validate(document.forms['form1']);">
  <table width="100%" cellspacing="1" cellpadding="10" class="tbl">
    <tr>
      <td><label for="page_title" id="err_page_title">Page Title :</label>
        <span class="error">*</span></td>
      <td><input type="text" name="page_title" title="Page Title" class="R" maxlength="50" id="page_title" value="<?php echo $_POST['page_title'];?>" size="60"/>
        e.g. (Title of content and maximum 50 characters)</td>
    </tr>
    <tr>
      <td><label for="content_desc" id="err_content_desc">Content Description :</label>
        <span class="error">*</span></td>
      <td valign="top"><textarea id="content_desc" name="content_desc" rows="5" cols="80" title="Content Description" class="R"><?php echo $_POST['content_desc'];?></textarea></td>
    </tr>
    <tr>
      <td colspan="5"><?php if($_REQUEST['action']=="edit"){?>
        <input type="hidden" name="ctitle" value="<?php echo $data[0]['content_title'];?>" />
        <input type="submit" name="btnupdate" value="Update" class="button" />
        <?php }else{?>
        <input type="submit" name="btnsave" value="Add" class="button" />
        <?php }?>
        <input type="button" onclick="location.href='<?php echo $_SESSION['CURRENT_URL'];?>'" class="button" value="Back" /></td>
    </tr>
  </table>
</form>
<?php }else{ $fn->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
  <tr>
    <th width="20%">Page Title</th>
    <th width="70%">Page Description</th>
    <th width="10%">Action</th>
  </tr>
  <?php  
		
        $keyword = $fn->ReplaceSql($_REQUEST['keyword']);
        $alpha = $fn->ReplaceSql($_REQUEST['alpha']);
        $where = '';
        if($alpha!=''){$where .= " and (page_title like '".$alpha."%')";}
		if($keyword!=''){$where .= " and (page_title like '".$keyword."%' or page_title like '% ".$keyword."%')";}
    	$query="select * from content_table $where order by page_title";
		if($data = $fn->SelectQuery($query)){foreach ($data as $row){ ?>
  <tr>
    <td><?php echo $row['page_title'];?></td>
    <td><?php echo $row['content_desc'];?></td>
    <td><a class="edit" href="?for=<?php echo $row['content_title']?>&action=edit&ctitle=<?php echo $row['content_title'];?>"></a></td>
  </tr>
  <?php } } ?>
</table>
<?php }?>
<?php include_once("footer.php");?>
</body>
</html>