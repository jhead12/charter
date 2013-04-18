<?php require_once("class/class.functions.php"); 
	require_once("class/class.pagination.php");
	$fn = new Functions();
	$fn->ReqLogin();
	if(isset($_POST['submit_btn'])){
		if($fn->ChangePassword($_POST)){
			$_SESSION['ERRORTYPE'] = "success";
			$_SESSION['ERRORMSG'] = "Password has been changed successfully";
			header("Location:change_password.php");
		} else {
			$_SESSION['ERRORTYPE'] = "error";
			$_SESSION['ERRORMSG'] = "Invalid Old Password!";
			header("Location:change_password.php");
		}
	}
?>
<!DOCTYPE html>
<html class="js flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?>| Change Password</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized" style="">
<div id="container">
  <?php include_once("inc.header.php");?>
 	<div id="products-list">
  <div class="content fixmain customer">
    <div class="checkout">
      <h2 class="h1">Change Password</h2>
      <p class="service"></p>
      <div>
      <ol id="steps">
        <li class="step active" id="signin">
          <div class="left">
            <form action="" method="post" name="frm_signup" id="frm_signup" onsubmit="return validate(document.forms['frm_signup']);">
              <div class="formrow">
                <label for="old_password">Old Password*</label>
                <input type="password" name="old_password" id="old_password" class="R" title="Old Password"/>
              </div>
              <div class="formrow">
                <label for="new_password">New Password*</label>
                <input type="password" name="new_password" id="new_password" class="R" title="New Password"/>
              </div>
              <div class="buttonbar">
                <input type="submit" class="button primary" name="submit_btn" id="submit_btn" value="Submit" />
              </div>
            </form>
          </div>
        </li>
      </ol>		
      </div>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
    <div id="pro-detail"></div>
  </div>  
 <script type="text/javascript" src="js/jquery.ajax_page.js"></script> 
<script type="text/javascript" src="js/validation.js"></script> 
<?php include_once("message.php");?>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>