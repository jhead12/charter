<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();
unset($_SESSION['ORDER_ID']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?>| Paypal</title>
<?php include_once("inc.head.php");?>
</head>
<body class="cmnco">
<?php include_once("message.php");?>
<div id="container">
  <div id="header">
    <?php if($header_data=$fn->SelectQuery("select * from social_links")){
		$header=$header_data[0];
	}?>
    <h1> <a href="index.php" id="logo" title="Blur Leather"><img src="social_links/<?php echo $header['site_logo'];?>" alt="" width="72" height="19" /></a></h1>
  </div>
  <div class="content customer" style="height:420px;">
    <div class="checkout">
      <div class="head">
        <h2 class="h1">Paypal Payment Processing</h2>
      </div>
      <p class="msg"></p>
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
</body>
</html>