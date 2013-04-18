<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if(isset($_POST['btnsave'])){
	if($obj->GetValue("adminusers","userpass","userpass='".$obj->Encrypt($_POST['old_password'])."'")){
		$query="update adminusers set userpass='".$obj->Encrypt($_POST['new_password'])."' where userpass='".$obj->Encrypt($_POST['old_password'])."'";
		$obj->UpdateQuery($query);
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Password Changed successfully!";
		$obj->ReturnReferer();
	} else {
		$_SESSION['ERRORTYPE'] = "error";
		$_SESSION['ERRORMSG'] = "Wrong Password!";
	}
}
$obj->SetCurrentUrl();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<?php include_once("inc.head.php"); ?>
</head>
<body>
<div class="full">
	<h1>Change Password</h1>
</div>
<?php require_once("message.php");?>
<form method="post" enctype="multipart/form-data" name="artcatform" id="artcatform" onsubmit="return validate(document.forms['artcatform']);">
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">	    
    <tr>
        <th colspan="2">Change Your Password</th>
    </tr>
    <tr>
        <td width="250px"><label id="err_old_password">Old Password : </label><span class="error">*</span></td>
        <td><input type="password" size="30" title="Old Password" class="R" name="old_password" id="old_password"/>
        </td>
    </tr>
    <tr>
        <td width="250px"><label id="err_new_password">New Password : </label><span class="error">*</span></td>
        <td><input type="password" size="30" title="New Password" class="R" name="new_password" id="new_password"/>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <input type="submit" name="btnsave" value="Submit" class="button" />
        </td>
    </tr>
</table>
</form>
<?php include "footer.php";?>   
<?php include_once("footer.php");?>
</body>
</html>