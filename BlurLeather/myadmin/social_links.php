<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if(isset($_POST['btnupdate'])){	
	$query="update social_links set facebook_link='".$obj->ReplaceSql($_POST['facebook_link'])."', twitter_link='".$obj->ReplaceSql($_POST['twitter_link'])."', youtube_link='".$obj->ReplaceSql($_POST['youtube_link'])."' where social_link_id='".$obj->ReplaceSql($_POST['social_link_id'])."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Social links has been updated successfully!";
	$obj->ReturnReferer();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
<title>Admin Panel</title>
<?php include_once("inc.head.php"); ?>
</head>
<body>
<div class="full">
  <h1>Manage Social Website Links
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
      <th colspan="2"><?php echo (isset($data)) ? "Edit" : "Add" ;?> Social Links</th>
    </tr>
    <tr>
      <td width="25%"><label id="err_facebook_link" for="facebook_link">Facebook URL : </label>
        <span class="error"> </span></td>
      <td><input type="text" size="30" title="Facebook URL" class="isURL" name="facebook_link" id="facebook_link" value="<?php echo (isset($data)) ? $data[0]['facebook_link'] : '' ;?>"/>
        (http://www.facebook.com/blur.com) </td>
    </tr>
    <tr>
      <td width="25%"><label id="err_twitter_link" for="twitter_link">Twitter URL : </label>
        <span class="error"> </span></td>
      <td><input type="text" size="30" title="Twitter URL" class="isURL" name="twitter_link" id="twitter_link" value="<?php echo (isset($data)) ? $data[0]['twitter_link'] : '' ;?>"/>
        (http://www.twitter.com/blur.com) </td>
    </tr>
    <tr>
      <td width="25%"><label id="err_youtube_link" for="youtube_link">Youtube URL : </label>
        <span class="error"> </span></td>
      <td><input type="text" size="30" title="Youtube URL" class="isURL" name="youtube_link" id="youtube_link" value="<?php echo (isset($data)) ? $data[0]['youtube_link'] : '' ;?>"/>
        (http://www.youtube.com/blur.com) </td>
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
    <th width="20%">Facebook Link</th>
    <th width="20%">Twitter Link</th>
    <th width="20%">Youtube Link</th>
    <th width="10%">Edit</th>
  </tr>
  <?php 
    	$query="select * from social_links";
		if($data = $obj->SelectQuery($query)){
		foreach ($data as $row){ ?>
  <tr>
    <td><?php echo $row['facebook_link'];?></td>
    <td><?php echo $row['twitter_link'];?></td>
    <td><?php echo $row['youtube_link'];?></td>
    <td><a class="edit" href="?action=edit&social_link_id=<?php echo $row['social_link_id'];?>"></a></td>
  </tr>
  <?php } ?>
  <?php } else { ?>
  <tr>
    <td colspan="4" class="error">No Social Link Found!</td>
  </tr>
  <?php } ?>
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>