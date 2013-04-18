<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();
	if(count($_SESSION['CART_PRODUCTS'])==0){
		header("Location:index.php");
	}
	if(isset($_POST['btn_login'])){
		if($fn->Login($_POST['login_email'],$_POST['login_password'])){
			unset($_SESSION['ERRORTYPE']);
			unset($_SESSION['ERRORMSG']);
		} else {
			$_SESSION['ERRORTYPE'] = "error";
			$_SESSION['ERRORMSG'] = "Invalid Email or Password!";	
		}
		header("Location:checkout.php");
		exit(0);
	}
	if(isset($_POST['btn_submit'])){
		$flag=true;
		if(!$_SESSION['USERLOGIN']){
			if(!$fn->ValueExists('members','email',$_POST['email'])){
				$fn->SignUp($_POST);
				$flag=true;
			}else{
				$flag=false;
				$_SESSION['ERRORTYPE'] = "error";
				$_SESSION['ERRORMSG'] = "Email already exists in our database!";
			}
		}
		if($_SESSION['USERLOGIN']){
			if($flag==true){
				$_SESSION['PAYMENT_ADD']=$_POST;
				header("Location:payment.php");
			}
		}
	}
?>
<!DOCTYPE html>
<html class="js flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?>| Checkout</title>
<?php include_once("inc.head.php");?>
<script language="javascript" type="text/javascript">
<!--
function shipping_same(chk){
	if(chk=="same"){
		$('#billing_country').val($('#country option:selected').val());
		$('#billing_salutation').val($('#salutation option:selected').val());
		$('#billing_first_name').val($('#first_name').val());
		$('#billing_last_name').val($('#last_name').val());
		$('#billing_company').val($('#company').val());
		$('#billing_address1').val($('#address1').val());
		$('#billing_address2').val($('#address2').val());
		$('#billing_city').val($('#city').val());
		$('#billing_province').val($('#province').val());
		$('#billing_post_code').val($('#post_code').val());
	}else{
		$('#billing_first_name').val('');
		$('#billing_last_name').val('');
		$('#billing_company').val('');
		$('#billing_address1').val('');
		$('#billing_address2').val('');
		$('#billing_city').val('');
		$('#billing_province').val('');
		$('#billing_post_code').val('');
	}
}

-->
</script>
</head>
<body class="cmnco">
<div id="container">
 <?php if($header_data=$fn->SelectQuery("select * from social_links")){
		$header=$header_data[0];
	}?>
  <div id="header">
    <h1> <a href="index.php" id="logo" title="Blur Leather"><img src="social_links/<?php echo $header['site_logo'];?>" alt="" width="72" height="29" /></a></h1>
  </div>
  <div class="content customer">
    <div class="checkout">
      <div class="head">
        <h2 class="h1">Checkout</h2>
        <p class="service">Customer Service 9999-999-999 (10am – 6pm Mon – Fri) &nbsp;|&nbsp; <a href="ajax_pages/content.php?ctitle=returnpolicy" rel="superbox[iframe][930x550]">Return Policy</a> | <a href="ajax_pages/content.php?ctitle=terms" rel="superbox[iframe][930x550]">Terms and Conditions</a> | <a href="ajax_pages/contact_us.php" rel="superbox[iframe][930x550]">Contact us</a> </p>
      </div>
      <p class="msg">We offer a free return or exchange service if you 
        change your mind or need a different size; just submit a return request 
        within 7 days of receiving your order.</p>
      <ol id="steps">
        <li class="step <?php if(!$_SESSION['USERLOGIN']){ echo 'active';}else{echo 'completed';}?> " id="signin">
          <h3 class="h2">sign in</h3>
          <?php if(!$_SESSION['USERLOGIN']){?>
          <div class="left">
            <h4 class="h3">I already have an account</h4>
            <ul class="enum">
              <li>Sign in to:</li>
              <li>Store your details for faster checkout</li>
              <li>View your order history</li>
              <li>Track your order</li>
              <li>Blur Leather save and share your favourite content &amp; products</li>
            </ul>
            <form action="" method="post" name="frm_login" id="frm_login" onsubmit="return validate(document.forms['frm_login']);">
              <div class="formrow">
                <label for="login_email">Email Address*</label>
                <input type="text" name="login_email" id="login_email" class="RisEmail" title="Login Email"/>
              </div>
              <div class="formrow">
                <label for="login_password">Password*</label>
                <input type="password" name="login_password" id="login_password" class="R" title="Login Password"/>
                <a href="ajax_pages/forgot_password.php" rel="superbox[iframe][930x550]">Forgot your password?</a> 
              </div>
              <div class="buttonbar">
                <input type="submit" class="button primary" name="btn_login" id="btn_login" value="Checkout Securely" />
              </div>
            </form>
          </div>
          <div class="right">
            <h4 class="h3">I am a new customer</h4>
            <p>You can make purchases without having an account by inputting your billing and delivery details. You can create an account later by saving a password.</p>
            <div class="buttonbar">
                <input type="button" class="button primary" value="Signup & Checkout Securely" id="signup_pbtn"/>
            </div>
          </div>
          <?php } else{ ?>
                <li><a>Hi! <?php echo $_SESSION['USERNAME'];?></a></li>
          <?php } ?>
        </li>
        <li class="step active" id="addresses">
          <h3 class="h2">Shipping &amp; Billing</h3>
          <p>If shipping to a  work address, please include the company name. Required fields are marked with a * </p>
          <?php if($_SESSION['USERLOGIN']){
			  		if($rows=$fn->SelectQuery("select * from order_form where member_id='".$_SESSION['USERID']."' order by orderid desc limit 1")) 
					$row=$rows[0];
			  	}
		  ?>
          <form action="" method="post" name="frm_signup" id="frm_signup" onsubmit="return validate(document.forms['frm_signup']);">
              <div class="formrow">
                <label for="salutation">Title*</label>
                <select name="salutation" id="salutation" class="R" title="Title">
                  <option value="">---</option>
                    <option <?php echo $row['salutation']=="Mr" ? 'selected="selected"':'';?> value="Mr">Mr</option>
                    <option <?php echo $row['salutation']=="Ms" ? 'selected="selected"':'';?> value="Ms">Ms</option>
                    <option <?php echo $row['salutation']=="Miss" ? 'selected="selected"':'';?> value="Miss">Miss</option>
                    <option <?php echo $row['salutation']=="Mrs" ? 'selected="selected"':'';?> value="Mrs">Mrs</option>
                </select>
              </div>
              <div class="formrow">
                <label for="first_name">First Name*</label>
                <input name="first_name" id="first_name" class="R" title="First Name" type="text" value="<?php echo $row['first_name']!="" ? $row['first_name'] : $_SESSION['FIRST_NAME']?>"/>
              </div>
              <div class="formrow">
                <label for="last_name">Last Name*</label>
                <input type="text" name="last_name" class="R" title="Last Name" id="last_name" value="<?php echo $row['last_name']!="" ? $row['last_name'] : $_SESSION['SURNAME']?>"/>
              </div>
              <div class="formrow">
                <label for="country">Country*</label>
                <?php if($countryrs = $fn->SelectQuery("select * from country")){?>
                <select id="country" name="country" class="R" title="Country">
                  <option value="">--</option>
                  <?php foreach($countryrs as $country){?>
                  <option <?php echo $country['country_title']=="United States" ? 'selected="selected"':'';?> <?php echo $country['country_title']==$row['country'] ? 'selected="selected"':'';?> value="<?php echo $country['country_title'];?>"><?php echo $country['country_title'];?></option>
                  <?php } ?>
                </select>
                <?php } ?>
              </div>
              <div class="formrow">
                <label for="company">Company</label>
                <input type="text" name="company" id="company" title="Company" value="<?php echo $row['company']?>" />
              </div>
              <div class="formrow">
                <label for="address1">Address Line 1*</label>
                <input type="text" name="address1" class="R" title="Address Line 1" id="address1" value="<?php echo $row['address1']?>" />
              </div>
              <div class="formrow">
                <label for="address2">Address Line 2</label>
                <input type="text" name="address2" id="address2" title="Address Line 2" value="<?php echo $row['address2']?>"/>
              </div>
              <div class="formrow">
                <label for="city">City*</label>
                <input type="text" name="city" class="R" title="City" id="city" value="<?php echo $row['city']?>"/>
              </div>
              <div class="formrow">
                <label for="province">County / Province</label>
                <input type="text" name="province" title="County / Province" id="province" value="<?php echo $row['province']?>"/>
              </div>
              <div class="formrow">
                <label for="post_code">Postcode*</label>
                <input type="text" name="post_code" title="Postcode" id="post_code" class="R" value="<?php echo $row['post_code']?>"/>
              </div>
              <div class="formrow">
                <label for="phone">Telephone*</label>
                <input  type="text" name="telephone" title="Telephone" id="telephone" class="R" value="<?php echo $row['telephone']?>" />
              </div>
              <div class="formrow">
                <label for="email">Email Address*</label>
                <input type="text" name="email" id="email" title="Email Address" class="RisEmail" value="<?php echo $row['email']!="" ? $row['email'] : $_SESSION['EMAIL']?>" />
              </div>
              <div class="formrow">
                <label for="emailrepeat">Confirm Email*</label>
                <input type="text" name="emailrepeat" id="emailrepeat" class="RisEmail CM-email-CM " title="Confirm Email"/>
              </div>
              <h3 class="h2">Billing address</h3>
              <p>Please ensure that your billing address matches the 
                address held by your card issuer. We can only accept credit cards 
                registered to a USA address.</p>
                
              <div class="options">
                <div class="formrow chooser">
                  <label>
                    <input type="radio" name="sd" id="sd1" title="Use Shipping Address As Billing Address" onClick="shipping_same('same');">
                    Use Shipping Address As Billing Address</label>
                </div>
                <div class="formrow chooser">
                  <label>
                    <input checked="checked" name="sd" id="sd2" title="Enter Separate Billing Address" type="radio" onClick="shipping_same('different');">
                    Enter Separate Billing Address</label>
                </div>
              </div>
              
                <div class="formrow">
                  <label for="billing_salutation">Title*</label>
                  <select name="billing_salutation" id="billing_salutation" class="R" title="Billing Title">
                    <option value="">---</option>
                    <option <?php echo $row['billing_salutation']=="Mr" ? 'selected="selected"':'';?> value="Mr">Mr</option>
                    <option <?php echo $row['billing_salutation']=="Ms" ? 'selected="selected"':'';?> value="Ms">Ms</option>
                    <option <?php echo $row['billing_salutation']=="Miss" ? 'selected="selected"':'';?> value="Miss">Miss</option>
                    <option <?php echo $row['billing_salutation']=="Mrs" ? 'selected="selected"':'';?> value="Mrs">Mrs</option>
                  </select>
                </div>
                <div class="formrow">
                  <label for="billing_first_name">First Name*</label>
                  <input type="text" name="billing_first_name" id="billing_first_name" class="R" title="Billing First Name" value="<?php echo $row['billing_first_name']?>"/>
                </div>
                <div class="formrow">
                  <label for="billing_last_name">Last Name*</label>
                  <input type="text" name="billing_last_name" id="billing_last_name" class="R" title="Billing Last Name"  value="<?php echo $row['billing_last_name']?>"/>
                </div>
                <div class="formrow">
                  <label for="billing_country">Country*</label>
                  <?php if($countryrs = $fn->SelectQuery("select * from country")){?>
                  <select id="billing_country" name="billing_country" class="R" title="Billing Country">
                    <option value="">--</option>
                    <?php foreach($countryrs as $country){?>
                    <option <?php echo $country['country_title']=="United States" ? 'selected="selected"':'';?> <?php echo $country['country_title']==$row['billing_country'] ? 'selected="selected"':'';?> value="<?php echo $country['country_title'];?>"><?php echo $country['country_title'];?></option>
                    <?php } ?>
                  </select>
                  <?php } ?>
                </div>
                <div class="formrow">
                  <label for="billing_company">Company</label>
                  <input type="text" name="billing_company" id="billing_company" title="Company" value="<?php echo $row['billing_company']?>"/>
                </div>
                <div class="formrow">
                  <label for="billing_address1">Address Line 1*</label>
                  <input type="text" name="billing_address1" title="Address Line 1" id="billing_address1" class="R" value="<?php echo $row['billing_address1']?>"/>
                </div>
                <div class="formrow">
                  <label for="billing_address2">Address Line 2</label>
                  <input type="text" name="billing_address2" id="billing_address2" title="Address Line 2" value="<?php echo $row['billing_address2']?>"/>
                </div>
                <div class="formrow">
                  <label for="billing_city">City*</label>
                  <input type="text" name="billing_city" title="City" id="billing_city" class="R" value="<?php echo $row['billing_city']?>"/>
                </div>
                <div class="formrow">
                  <label for="billing_province">County / Province</label>
                  <input  type="text" name="billing_province" id="billing_province" title="County / Province" value="<?php echo $row['billing_province']?>"/>
                </div>
                <div class="formrow">
                  <label for="billing_post_code">Postcode*</label>
                  <input type="text" name="billing_post_code" id="billing_post_code" class="R" title="Postcode" value="<?php echo $row['billing_post_code']?>"/>
                </div>
            <fieldset>
              <h4 class="h2">Shipping options</h4>
              <p>If you have any questions regarding the shipping options you might want to consider reading our <a href="ajax_pages/content.php?ctitle=delivery" rel="superbox[iframe][930x550]">delivery terms</a>.</p>
              <p>Orders are processed and delivered Monday–Friday. Orders processed after 3pm will ship the following day.</p>
            </fieldset>
            <div class="buttonbar"> <a class="button secondary" href="cart.php">Back to Basket</a>
              <input class="button primary" value="Continue to Payment" type="submit" name="btn_submit" id="btn_submit">
            </div>
          </form>
          
        </li>
      </ol>
      <div id="extra">
        <div id="minibasket">
          <h3 class="h2">Order Summary <a href="cart.php">Edit</a></h3>
          <ul id="miniproducts">
          <?php foreach($_SESSION['CART_PRODUCTS'] as $items){
			$items['price'] = $fn->GetRateAmt($items['price']);
			$amt += $items['qty'] * $items['price'];?>
            <li> <img src="<?php echo $items['img'];?>" alt="<?php echo $items['title'];?>" height="81" width="81">
            <h6> <a href="javascript:;"><?php echo $items['title'];?></a> </h6>
            <p class="price"><?php echo $fn->GetDisplayRate($items['price']);?></p>
          </li>
          <?php $i++;}?>  
          </ul>
          <dl class="calc">
            <dt>sub totals</dt>
            <dd><?php echo $fn->GetDisplayRate($amt);?></dd>
            <dt>Shipping</dt>
            <dd><?php echo $fn->GetDisplayRate($_SESSION['CART_CHARGES']['amount']);?></dd>
          </dl>
          <dl class="calc total">
            <dt>Total</dt>
            <dd><?php echo $fn->GetDisplayRate($_SESSION['CART_CHARGES']['amount']+$amt);?></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
  <div id="footer" class="prehide">
    <ul id="footernav" class="topnav">
      <li><a href="company_info.php">Company Info</a></li>
      <li><a href="ajax_pages/contact_us.php" rel="superbox[iframe][930x550]">Contact us</a></li>
      <li><a href="privacy_policy.php">Future Product</a></li>
      <li><a href="privacy_policy.php">Privacy policy</a></li>
      <li><a href="sitemap.php">Sitemap</a></li>
    </ul>
    <p class="copy">© 2012 Blur Leather</p>
  </div>
</div>
<script type="text/javascript" src="js/jquery.ajax_page.js"></script> 
<script type="text/javascript" src="js/validation.js"></script> 
<script type="text/javascript" src="lightbox/js/jquery.superbox.js"></script> 
<script type="text/javascript">
	$("document").ready(function() {								
	$("#signup_pbtn").click(function() {
      	$('html, body').animate({
			scrollTop: $("#addresses").offset().top-36
		}, 1000);				   					 
      });  
	});

	$(function(){
		$.superbox.settings = {
			closeTxt: "Close",
			loadTxt: "",
			nextTxt: "Next",
			prevTxt: "Previous"
		};
		$.superbox();
	});
	function superopen(url,w,h){
		var iframe = '<iframe src="'+ url +'" name="" frameborder="0" scrolling="auto" width="'+ w +'" height="'+ h +'"></iframe>';
		$.superbox.open(iframe,{boxWidth:w,boxHeight:h});
	}
</script>
<?php include("includes/inc.footer_unset.php");?>
<?php include_once("message.php");?>
</body>
</html>