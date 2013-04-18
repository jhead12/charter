<?php require_once("class/class.functions.php"); 
	$fn = new Functions();
	$fn->CurrentUrl();
	/*if(!isset($_SESSION['PRODUCT_AMOUNT'])){
		header("Location:index.php");
	}*/
	if(isset($_POST['btn_submit'])){
		$post_url = "https://test.authorize.net/gateway/transact.dll";
		$post_values = array(
			"x_login"			=> "78A6dPEKGmFp",
			"x_tran_key"		=> "86a2pjtG2Q5Cu8E8",
			"x_version"			=> "3.1",
			"x_delim_data"		=> "TRUE",
			"x_delim_char"		=> "|",
			"x_relay_response"	=> "FALSE",
			"x_type"			=> "AUTH_CAPTURE",
			"x_method"			=> "CC",
			"x_card_num"		=> $_POST['card_no'],
			"x_card_code"		=> $_POST['card_code'],
			"x_exp_date"		=> $_POST['expiry_date'],
			"x_amount"			=> $_SESSION['CURRENCY']=="USD" ? ($_SESSION['CART_CHARGES']['amount']+$_SESSION['PRODUCT_AMOUNT']) : $fn->AllCurrencyToUSD($_SESSION['CART_CHARGES']['amount']+$_SESSION['PRODUCT_AMOUNT']),
			"x_description"		=> "Blur Leather Products Payment",
			"x_first_name"		=> $_POST['billing_first_name'],
			"x_last_name"		=> $_POST['billing_last_name'],
			"x_address"			=> $_POST['billing_address1'],
			"x_state"			=> $_POST['billing_province'],
			"x_zip"				=> $_POST['billing_post_code']
		);
	$post_string = "";
	foreach( $post_values as $key => $value )
		{ $post_string .= "$key=" . urlencode( $value ) . "&"; }
	$post_string = rtrim( $post_string, "& " );
	$request = curl_init($post_url); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
		$post_response = curl_exec($request); // execute curl post and store results in $post_response
	curl_close ($request); // close curl object
		$_SESSION['RESPONSE'] = explode($post_values["x_delim_char"],$post_response);

	$query = "insert into order_form set salutation='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['salutation'])."', first_name='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['first_name'])."', last_name='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['last_name'])."', country='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['country'])."',company='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['company'])."', address1='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['address1'])."', address2='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['address2'])."', city='".$_SESSION['PAYMENT_ADD']['city']."', province='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['province'])."', post_code='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['post_code'])."',telephone='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['telephone'])."', email='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['email'])."', billing_salutation='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_salutation'])."', billing_first_name='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_first_name'])."', billing_last_name='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_last_name'])."', billing_country='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_country'])."',billing_company='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_company'])."', billing_address1='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_address1'])."', billing_address2='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_address2'])."', billing_city='".$_SESSION['PAYMENT_ADD']['billing_city']."', billing_province='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_province'])."', billing_post_code='".$fn->ReplaceSql($_SESSION['PAYMENT_ADD']['billing_post_code'])."', orderdate='".date("Y-m-d H:i:s")."', orderstatus='P',paymentstatus='N', member_id='".$_SESSION['USERID']."', shipamount='".$_SESSION['CART_CHARGES']['amount']."', paidamount='".$_SESSION['PRODUCT_AMOUNT']."', currency='".$_SESSION['CURRENCY']."'";
			$_SESSION['ORDER_ID']=$fn->InsertQuery($query);		
			if(count($_SESSION['CART_PRODUCTS'])>0){
				foreach ($_SESSION['CART_PRODUCTS'] as $items){
					$query = "insert into order_product set orderid='".$_SESSION['ORDER_ID']."', productid='".$items['productid']."', price='".($items['price'])."',colorid='".($items['colorid'])."',colortitle='".($items['colortitle'])."', quantity='".$items['qty']."', size='".$items['size']."'";
					$fn->UpdateQuery($query);
				}
			}
		  $success_message='';
		  $payment='';
		 if($_SESSION['RESPONSE'][0]==1){ $success_message="Approved"; $payment='Y';  }elseif($_SESSION['RESPONSE'][0]==2){$success_message="Declined"; $payment='N';}elseif($_SESSION['RESPONSE'][0]==3){$success_message= "Error";}elseif($_SESSION['RESPONSE'][0]==4){$success_message="Held for Review";}
		 
		$card_code_response='';
		if($_SESSION['RESPONSE'][38]=='M'){ $card_code_response="Match"; }elseif($_SESSION['RESPONSE'][38]=='N'){ $card_code_response="Not Match";}elseif($_SESSION['RESPONSE'][38]=='P'){ $card_code_response="Not Processed";}elseif($_SESSION['RESPONSE'][38]=='S'){ $card_code_response="Should have been present";}elseif($_SESSION['RESPONSE'][38]=='U'){ $card_code_response="Issuer unable to process request";}
		$fn->UpdateQuery("insert into members_payment set order_id='".$_SESSION['ORDER_ID']."', success_message='".$fn->ReplaceSql($success_message)."',response_text='".$fn->ReplaceSql($_SESSION['RESPONSE'][3])."',authorization_code='".$_SESSION['RESPONSE'][4]."',transaction_id='".$_SESSION['RESPONSE'][6]."',payment_for='".$fn->ReplaceSql($_SESSION['RESPONSE'][8])."', transaction_amount='".$_SESSION['RESPONSE'][9]."',payment_method='".$_SESSION['RESPONSE'][10]."', transaction_type='".$_SESSION['RESPONSE'][11]."', card_code_response='".$card_code_response."', account_number='".$_SESSION['RESPONSE'][50]."', card_type='".$_SESSION['RESPONSE'][51]."'");
		
		$fn->UpdateQuery("update order_form set paymentstatus='".$payment."' where orderid='".$_SESSION['ORDER_ID']."'");
		
		$fn->OrderPurchaseMail($_SESSION['ORDER_ID']);
		unset($_SESSION['ORDER_ID']);
		unset($_SESSION['CART_CHARGES']);
		unset($_SESSION['PRODUCT_AMOUNT']);
		unset($_SESSION['CART_PRODUCTS']);
		unset($_SESSION['PAYMENT_ADD']);
		header("Location:payment.php?done");
	}
?>
<!DOCTYPE html>
<html class="js flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?>| Payment Processing</title>
<?php include_once("inc.head.php");?>
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
        <h2 class="h1"><?php if(isset($_GET['done'])){?>Authorized Payment Response<?php }else{ ?>Payment Checkout Form<?php } ?></h2>
        <p class="service">Customer Service 9999-999-999 (10am – 6pm Mon – Fri) &nbsp;|&nbsp; <a href="ajax_pages/content.php?ctitle=returnpolicy" rel="superbox[iframe][930x550]">Return Policy</a> | <a href="ajax_pages/content.php?ctitle=terms" rel="superbox[iframe][930x550]">Terms and Conditions</a> | <a href="ajax_pages/contact_us.php" rel="superbox[iframe][930x550]">Contact us</a> </p>
      </div>
       <p class="msg"><?php if(isset($_GET['done'])){?>Thanks for placing your order<?php } ?></p>
      <ol id="steps">
        <li class="step active">
        	<?php if(!isset($_GET['done'])){?>
          <h3 class="h2">Payment Information</h3>
          <p>Required fields are marked with a * </p>
          <form action="" method="post" name="frm_signup" id="frm_signup" onsubmit="return validate(document.forms['frm_signup']);">
              <div class="formrow">
                <label for="first_name">First Name*</label>
                <input name="first_name" id="first_name" class="R" title="First Name" type="text" value="<?php echo $_SESSION['PAYMENT_ADD']['billing_first_name']?>"/>
              </div>
              <div class="formrow">
                <label for="last_name">Last Name*</label>
                <input type="text" name="last_name" class="R" title="Last Name" id="last_name" value="<?php echo $_SESSION['PAYMENT_ADD']['billing_last_name']?>"/>
              </div>
              <div class="formrow">
                <label for="address1">Address Line 1*</label>
                <input type="text" name="address1" class="R" title="Address Line 1" id="address1" value="<?php echo $_SESSION['PAYMENT_ADD']['billing_address1']?>" />
              </div>
              <div class="formrow">
                <label for="city">City*</label>
                <input type="text" name="city" class="R" title="City" id="city" value="<?php echo $_SESSION['PAYMENT_ADD']['billing_city']?>"/>
              </div>
              <div class="formrow">
                <label for="province">County / Province</label>
                <input type="text" name="province" title="County / Province" id="province" value="<?php echo $_SESSION['PAYMENT_ADD']['billing_province'];?>"/>
              </div>
              <div class="formrow">
                <label for="post_code">Postcode*</label>
                <input type="text" name="post_code" title="Postcode" id="post_code" class="R" value="<?php echo $_SESSION['PAYMENT_ADD']['billing_post_code']?>"/>
              </div>
              <div class="formrow">
                <label for="card_no">Card No*</label>
                <input type="text" name="card_no" title="Card No" id="card_no" class="RisNo" value="" maxlength="16"/> e.g. xxxxxxxxxxxx0012
              </div>
              <div class="formrow">
                <label for="card_code">Card Code*</label>
                <input type="text" name="card_code" title="Card Code" id="card_code" class="RisNo" maxlength="3" value=""/> e.g. 782
              </div>
              <div class="formrow">
                <label for="expiry_date">Expiry Date*</label>
                <input type="text" name="expiry_date" title="Expiry Date" id="expiry_date" class="R" value="" maxlength="5"/> e.g. 04/15
              </div>
              <div class="formrow">
                <label for="expiry_date">Total Amount</label>
                <?php echo $_SESSION['CURRENCY']." "; printf("%.2f",($_SESSION['CART_CHARGES']['amount']+$_SESSION['PRODUCT_AMOUNT']));?>
              </div>
            <div class="buttonbar">
              <input class="button primary" value="Pay Now" type="submit" name="btn_submit" id="btn_submit">
            </div>
          </form>
          <?php } else{ ?>
              <div class="formrow">
              	Success Message : <?php if($_SESSION['RESPONSE'][0]==1){ echo "Approved"; }elseif($_SESSION['RESPONSE'][0]==2){echo "Declined";}elseif($_SESSION['RESPONSE'][0]==3){echo "Error";}elseif($_SESSION['RESPONSE'][0]==4){echo "Held for Review";}?>
              </div>
              <div class="formrow">
              	Response Text : <?php echo $_SESSION['RESPONSE'][3]?>
              </div>
              <div class="formrow">
              	Authorization Code  : <?php echo $_SESSION['RESPONSE'][4]?>
              </div>
              <div class="formrow">
              	Transaction Id : <?php echo $_SESSION['RESPONSE'][6]?>
              </div>
              <div class="formrow">
              	Payment For  : <?php echo $_SESSION['RESPONSE'][8]?>
              </div>
              <div class="formrow">
              	Transaction Amount : USD <?php echo $_SESSION['RESPONSE'][9]?>
              </div>
              <div class="formrow">
				The payment method  : <?php echo $_SESSION['RESPONSE'][10]?>
              </div>
              <div class="formrow">
				Transaction Type  : <?php echo $_SESSION['RESPONSE'][11]?>
              </div>
              <?php /*?><div class="formrow">
              	Purchase Order Number : <?php echo $_SESSION['RESPONSE'][36]?>
              </div><?php */?>
              <div class="formrow">
              	Card Code Response  : <?php if($_SESSION['RESPONSE'][38]=='M'){ echo "Match"; }elseif($_SESSION['RESPONSE'][38]=='N'){echo "Not Match";}elseif($_SESSION['RESPONSE'][38]=='P'){echo "Not Processed";}elseif($_SESSION['RESPONSE'][38]=='S'){echo "Should have been present";}elseif($_SESSION['RESPONSE'][38]=='U'){echo "Issuer unable to process request";}?>
              </div>
              <div class="formrow">
              	Account Number : <?php echo $_SESSION['RESPONSE'][50]?>
              </div>
              <div class="formrow">
              	Card Type : <?php echo $_SESSION['RESPONSE'][51]?>
              </div>
		 	<?php } ?>
            
        </li>
      </ol>
      <div id="extra">
        <div id="minibasket">
          <p align="center">
          	<img src="images/authorize_verified-merchant.jpg" alt="" align="absmiddle" width="200"/>
          </p>
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
<?php include_once("message.php");
unset($_SESSION['response_array']);
?>
</body>
</html>