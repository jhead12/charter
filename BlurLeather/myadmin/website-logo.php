<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if(isset($_POST['btnupdate'])){	
	if($_FILES['site_logo']['name']!=''){
		$photo = array("name"=>$_FILES['site_logo']['name'],"tmp_name"=>$_FILES['site_logo']['tmp_name']);
		$obj->FixedUploadImage($photo,"social_links","site_logo","social_link_id",$_POST['social_link_id'],72,29);
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Logo images has been Updated successfully!";
	$obj->ReturnReferer();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin Panel</title>
<?php include_once("inc.head.php"); ?>
</head>
<body>
<div class="full">
  <h1>Manage Logo
    <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?>
    <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?>
    <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?>
  </h1>
</div>
<?php require_once("message.php");?>
<?php if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
		if($_REQUEST['action']=="edit" && isset($_REQUEST['social_link_id'])){
			$query = "select * from social_links where social_link_id='".$_REQUEST['social_link_id']."'";
			$data = $obj->SelectQuery($query);
		}?>
<form method="post" enctype="multipart/form-data" name="brandform" id="brandform" onsubmit="return validate(document.forms['brandform']);">
  <table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <tr>
      <th colspan="2"><?php echo (isset($data)) ? "Edit" : "Add" ;?> Website Logo</th>
    </tr>
    <tr>
      <td><label for="site_logo" id="err_site_logo">Website Logo: </label></td>
      <td><input type="file" name="site_logo" id="site_logo" title="Website Logo" class="isImg"/>
        (Website Logo image W x H, 72 x 29)
        <?php if($data[0]['site_logo']!=''){?>
        <br />
        <br />
        <img src="../social_links/<?php echo $data[0]['site_logo'];?>"/>
        <?php }?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php if($_REQUEST['action']=="edit"){?>
        <input type="hidden" name="social_link_id" value="<?php echo $_REQUEST['social_link_id']?>" />
        <input type="submit" name="btnupdate" value="Update" class="button" />
        <?php }else{?>
        <input type="submit" name="btnsave" value="Add" class="button" />
        <?php }?>
        <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" /></td>
    </tr>
  </table>
</form>
<?php }else{ $obj->SetCurrentUrl();	?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
  <tr>
    <th width="90%">Logo Image</th>
    <th width="10%">Edit</th>
  </tr>
  <?php 
    	$query="select * from social_links";
		if($data = $obj->SelectQuery($query)){
		foreach ($data as $row){ ?>
      <tr>  	
        <td><img src="../social_links/<?php echo $row['site_logo'];?>"/></td>
        <td><a class="edit" href="?action=edit&social_link_id=<?php echo $row['social_link_id'];?>"></a></td>
      </tr>
      <?php } ?>
  <?php } else { ?>
  <tr>
    <td colspan="3" class="error">No Logo Found!</td>
  </tr>
  <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>