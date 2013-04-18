<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title><?php echo COMPANY_NAME;?> | Cart</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized" style="">
<div id="container">
  <?php include_once("inc.header.php");?>
 	<div id="products-list">
  <div class="content fixmain customer">
    <div class="checkout">
      <h2 class="h1">Your Shopping Bag</h2>
      <p class="service">Customer Service 0800 157 7811 (10am – 6pm Mon – Fri) &nbsp;|&nbsp; <a href="ajax_pages/content.php?ctitle=returnpolicy" rel="superbox[iframe][930x550]">Return Policy</a> | <a href="ajax_pages/content.php?ctitle=terms" rel="superbox[iframe][930x550]">Terms and Conditions</a> | <a href="ajax_pages/contact_us.php" rel="superbox[iframe][930x550]">Contact us</a> </p>
      <p class="msg">We offer a free return or exchange service if you 
        change your mind or need a different size; just submit a return request 
        within 7 days of receiving your order.</p>
      <div id="basket"></div>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
    <div id="pro-detail"></div>
  </div>  
  <?php include_once("inc.footer.php");?>
  <script type="text/javascript">senddata('cart','type=cart','basket');</script>
</div>
</body>
</html>