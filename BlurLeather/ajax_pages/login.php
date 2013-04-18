<?php require_once("../class/class.functions.php"); 
	$fn = new Functions();
	if($_SESSION['USERLOGIN']){
		echo "<script language='javascript'>window.parent.location='".$url."';window.parent.superclose();</script>";
		exit(0);
	}
	if(isset($_POST['btn_submit'])){
		if(!$fn->ValueExists('members','email',$_POST['email'])){
			$fn->SignUp($_POST);
			$url = $_SESSION['CURRENTURL'];
			unset($_SESSION['CURRENTURL']);
			if($url==''){$url="index.php";}
			echo "<script language='javascript'>window.parent.location='".$url."';window.parent.superclose();</script>";
			exit(0);
			//header("Location:login.php");
		}else{
			$_SESSION['ERRORTYPE'] = "error";
			$_SESSION['ERRORMSG'] = "Email already exists in our database!";
		}
	}
	if(isset($_POST['btn_login'])){
		if($fn->Login($_POST['login_email'],$_POST['login_password'])){
			unset($_SESSION['ERRORTYPE']);
			unset($_SESSION['ERRORMSG']);
			$url = $_SESSION['CURRENTURL'];
			unset($_SESSION['CURRENTURL']);
			if($url==''){$url="index.php";}
			echo "<script language='javascript'>window.parent.location='".$url."';window.parent.superclose();</script>";
			exit(0);
			//header("Location:login.php");
		} else {
			$_SESSION['ERRORTYPE'] = "error";
			$_SESSION['ERRORMSG'] = "Invalid Email or Password!";
			header("Location:login.php");
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
<div class="full login_section">
      <div class="left_section">
        <div class="full">
            <h2 class="text_capital">Login</h2>
            <p>Please login to access the exclusive features of your Blur Leather shop account.</p>
        </div>
        <form action="" method="post" name="frmlogin" id="frmlogin" onsubmit="return validate(document.forms['frmlogin']);">
          <div class="full">
            Required fields are marked with a *
          </div>
          <div class="full paddtop10">
          	<div class="col40">
            	<label for="login_email">Email Address*</label>
            </div>
            <div class="col60">
            	<input type="text" name="login_email"  id="login_email" title="Login Email" class="RisEmail" size="20"/>
            </div>
          </div>
          <div class="full">
              <div class="col40"><label for="login_password">Password*</label></div>
              <div class="col60">
                <input type="password" name="login_password" id="login_password" title="Login Password" class="R" size="20"/>
              </div>
           </div>
           <div class="full">
           	<div class="col40"></div>
            <div class="col60">
           		<a href="forgot_password.php">Forgot your password?</a>
            </div>
           </div>
          <div class="full txtright margintop50">
            <input value="Login" type="submit" name="btn_login" id="btn_login">
          </div>
        </form>
      </div>
      <div class="right_section">
      	<div class="full">
            <h2 class="text_capital">Create an account</h2>
            <div class="full paddtop10">
            	Create an account to:
            </div>
            <div class="full paddtop10">
            <ul>
                <li>Store your details for faster checkout</li>
                <li>View your order history</li>
                <li>Track your order</li>
                <li><b>LATHER BLUR:</b> save and share your favourite content &amp; products</li>
            </ul>
            </div>
        </div>
         <form action="" method="post" name="frmsignup" id="frmsignup" onsubmit="return validate(document.forms['frmsignup']);">
          <div class="full paddtop10">
              Required fields are marked with a *
          </div>
          <div class="full paddtop10">
            <div class="col40">
            <label for="first_name" class="">First Name*</label>
            </div>
            <div class="col60">
            	<input name="first_name" type="text" id="first_name" title="First Name" class="R" size="20"/>
            </div>
          </div>
          <div class="full">
          	<div class="col40">
            	<label for="surname">Surname*</label>
            </div>
            <div class="col60">
            	<input name="surname" class="R" type="text" id="surname" title="Surname">
            </div>
          </div>
          <div class="full">
          	<div class="col40">
            <label for="email">Email Address*</label>
            </div>
            <div class="col60">
            <input name="email" id="email" class="RisEmail" type="text" title="Email Address">
            </div>
          </div>
          <div class="full">
          	<div class="col40">
            <label for="password">Password*</label>
            </div>
            <div class="col60">
            <input name="password" id="password" class="R" type="password" title="Password">
            </div>
          </div>
          <div class="full">
          	<div class="col40">
            <label for="confirm_password">Confirm Password*</label>
            </div>
            <div class="col60">
            <input name="confirm_password" id="confirm_password" title="Confirm Password" type="password" class="R CM-password-CM">
            </div>
          </div>
          <div class="full paddtop20">
            I am interested in the following collections and agree that my data may be processed in accordance with the <a target="_parent" href="<?php echo WEBSITE_URL;?>privacy_policy.php">Privacy Policy</a>:
          </div>
          <div class="full paddtop20">
          	<div class="col30 paddtop10"><img src="../images/logo_login.png" /></div>
            <div class="col69">
           		<div class="full">
          			<label>
                    <input name="womenswear" value="Womenswear" type="checkbox">
                    WOMENSWEAR
                  </label>      
                </div> 
                <div class="full">
          			<label>
                <input name="menswear" value="Menswear" type="checkbox">
                MENSWEAR
              </label>      
                </div>
            </div>
      		</div>
          <div class="full txtright margintop30">
            <input value="Create Account" type="submit" name="btn_submit" id="btn_submit">
          </div>
        </form>
      </div>
</div>
<?php include("../includes/inc.footer_unset.php");?>
</body>
</html>