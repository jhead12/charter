<?php require_once("../class/class.functions.php"); 
	$fn = new Functions();
	if($_SESSION['USERLOGIN']){
		echo "<script language='javascript'>window.parent.location='".$url."';window.parent.superclose();</script>";
		exit(0);
	}
	if(isset($_POST['btn_password'])){
		if($fn->ForgotPassword($_POST['forgot_email'])){
			$_SESSION['ERRORTYPE'] = "success";
			$_SESSION['ERRORMSG'] = "Password has been on your email account!";
			header("Location:login.php");
		}else{
			$_SESSION['ERRORTYPE'] = "error";
			$_SESSION['ERRORMSG'] = "Email not found in our database!";
			header("Location:forgot_password.php");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("../includes/inc.header-scripts-ajax.php");?>
</head>
<body>
<?php include_once("../message.php");?>
<div class="full password_section">
      <h2 class="text_capital">Forgot your password?</h2>
      <div class="full paddtop20"> Please enter your Email address. We will send you a new password.</div>
    <form action="" method="post" name="frmpassword" id="frmpassword" onsubmit="return validate(document.forms['frmpassword']);">
      <div class="full paddtop20"> Required fields are marked with a * </div>
      <div class="full paddtop20">
        <div class="col40">
          <label for="email">Email Address*</label>
        </div>
        <div class="col60">
          <input name="forgot_email" id="forgot_email" class="RisEmail" type="text" title="Email">
        </div>
      </div>
      <div class="full txtright margintop20">
        <input value="Reset Password" type="submit" name="btn_password" id="btn_password">
      </div>
    </form>
</div>
<?php include("../includes/inc.footer_unset.php");?>
</body>
</html>