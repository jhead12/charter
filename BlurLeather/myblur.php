<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?> | My Blur</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div id="mymcqueendrawer" class="content">
    <h2 class="h5"> <span class="">My Blur</span> (<span class="js_mmcq_count"><?php echo count($_SESSION['WISHLIST_PRODUCTS']);?></span>) <a style="color:#FFF" href="ajax_pages/share_email.php" rel="superbox[iframe][930x550]">Share Email</a></h2>
      <ul id="wishlist"></ul>
    <div class="logo">Blur Leather</div>
  </div>
  <div id="pro-detail"></div>
  <?php include_once("inc.footer.php");?>
  <script>
  	senddata('wishlist','type=wishlist','wishlist')
  </script>
</div>
</body>
</html>