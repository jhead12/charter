<?php
require_once("../class/class.admin.php");
	$fn = new Admin();
	$fn->RequireLogin();
	if(isset($_POST['btnupdate'])){
		$query="update mail_settings set email='".$fn->ReplaceSql($_POST['email'])."', new_inquiry='".$fn->ReplaceSql($_POST['new_inquiry'])."', quote_inquiry='".$fn->ReplaceSql($_POST['quote_inquiry'])."'";
		$fn->UpdateQuery($query);
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = "Thank You messages has been updated sucsessfully";
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
<h1>Manage Thank you <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
</div>
<?php require_once("message.php");?>
<?php 
	if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
		$query="select * from mail_settings";
		$data = $fn->SelectQuery($query);
		$_POST['email'] = (isset($_POST['email'])) ? $_POST['email'] : $data[0]['email'];
		$_POST['new_inquiry'] = (isset($_POST['new_inquiry'])) ? $_POST['new_inquiry'] : $data[0]['new_inquiry'];
		$_POST['quote_inquiry'] = (isset($_POST['quote_inquiry'])) ? $_POST['quote_inquiry'] : $data[0]['quote_inquiry'];?>
<form name="form1" id="form1" method="post" onsubmit="return validate(document.forms['form1']);">
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
    <tr>
    	<td><label for="email" id="err_email">Your Email for Receiving Emails :</label> <span class="error">*</span></td>
	    <td><input type="text" name="email" title="Email for Receiving Emails" class="R" id="email" value="<?php echo $_POST['email'];?>" size="60"/></td>
    </tr>
    <tr>
    	<td><label for="new_inquiry" id="err_new_inquiry">Thank You Message for New Inquiry :</label> <span class="error">*</span></td>
	    <td><textarea name="new_inquiry" title="Thank You Message for New Inquiry" class="R" id="new_inquiry" rows="5" cols="130"><?php echo $_POST['new_inquiry'];?></textarea></td>
    </tr>
    <tr>
		<td><label for="quote_inquiry" id="err_quote_inquiry">Thank You Message for Newsletter Signup :</label> <span class="error">*</span></td>
        <td valign="top">
            <textarea id="quote_inquiry" name="quote_inquiry" class="R" title="Thank You Message for Newsletter Signup" rows="5" cols="130"><?php echo $_POST['quote_inquiry'];?></textarea>	
        </td>
    </tr>
    <tr>
        <td colspan="2">
        	<?php if($_REQUEST['action']=="edit"){?>
            <input type="hidden" name="m_title" value="<?php echo $data[0]['m_title'];?>" />
            <input type="submit" name="btnupdate" value="Update" class="button" />
            <?php }else{?>
            <input type="submit" name="btnsave" value="Add" class="button" />
            <?php }?>
            <input type="button" onclick="location.href='<?php echo $_SESSION['CURRENT_URL'];?>'" class="button" value="Back" />
        </td>
    </tr>
</table>
</form>
<?php }else{ $fn->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="10" class="tbl">
    <tr>
        <th width="25%">Your Email for Receiving Emails</th>
        <th width="30%">Thank You Message for New Inquiry</th>
    	<th width="35%">Thank You Message for Newsletter Signup</th>
	    <th width="10%">Action</th>
    </tr> 
    <?php 
    	$query="select * from mail_settings order by email";
		if($data = $fn->SelectQuery($query)){
			foreach ($data as $row){ ?>
    <tr>
        <td><?php echo $row['email'];?></td>
        <td><?php echo $row['new_inquiry'];?></td>
    	<td><?php echo $row['quote_inquiry'];?></td>
    	<td>
        	<a class="edit" href="?action=edit&m_title=<?php echo $row['m_title'];?>"></a>
        </td>
    </tr>
	    <?php } }?>
    </table>
<?php }?>
<?php include_once("footer.php");?>
</body>
</html>