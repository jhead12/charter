<!DOCTYPE html>
<html class="js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<?php include_once("inc.head.php");?>
<style type="text/css" id="js_sizer_styles"></style>
<style type="text/css" id="js_slideshow_styles"></style>
<style type="text/css" id="js_scarves_styles"></style>
<title>Blur Leather</title>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div class="content landing visual">
    <div class="promoslideshow js_slideshow" data-timer="3500">
      <div class="item active"><a href="#"> <img class="scale " src="slider/img1.jpg" alt="img1" height="1080" width="1920">
      <span>
      <h3>Demo Title One</h3>
      <h1>Collections One</h1>
      </span>
      </a></div>
      <div class="item"> <a href="#"> <img class="scale " src="slider/thumb2.jpg" alt="thumb2" height="1080" width="1920">
      <span>
      <h3>Demo Title Second</h3>
      <h1>Collections Second</h1>
      </span></a> </div>
      <div class="item"> <a href="#"> <img class="scale " src="slider/thumb3.jpg" alt="thumb3" height="1080" width="1920">
      <span>
      <h3>Demo Title Third</h3>
      <h1>Collections Third</h1>
      </span></a> </div>
      <div class="item"> <a href="#"> <img class="scale " src="slider/thumb3.jpg" alt="thumb3" height="1080" width="1920">
      <span>
      <h3>Demo Title Four</h3>
      <h1>Collections Four</h1>
      </span></a> </div>
      <div class="item dark"> <a href="#"> <img class="scale " src="slider/thumb4.jpg" alt="thumb4" height="1080" width="1920">
      <span>
      <h3>Demo Title Five</h3>
      <h1>Collections Five</h1>
      </span> </a> </div>
      <ul class="categorynav">
        <li> <a href="javascript:;" onClick="senddata('cat-list','','cat-list');">SHOP THE LOOK</a> </li>
        <li> <a href="javascript:;" onClick="senddata('cat-list','','cat-list');">JACKETS</a> </li>
        <li> <a href="javascript:;" onClick="senddata('cat-list','','cat-list');">TOPS</a></li>
        <li> <a href="javascript:;" onClick="senddata('cat-list','','cat-list');">SHOES</a></li>
        <li> <a href="javascript:;" onClick="senddata('cat-list','','cat-list');">NEW ARRIVALS</a></li>
      </ul>
      <ul class="contentpager">
        <li>Previous</li>
        <li>Next</li>
      </ul>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
  <div class="promodrawer js_promodrawer">
    <h6><span class="js_scroll">MORE BLUR LEATHER</span> </h6>
    <ul class="promos promo5">
      <li style="background-image: url(slider/thumb1.jpg);"> <a href="#"><div class="bar">View The Film, Shop The Collection</div></a> </li>
      <li style="background-image: url(slider/thumb2.jpg);"> <a href="#"><div class="bar">View The Film, Shop The Collection</div></a> </li>
      <li style="background-image: url(slider/thumb3.jpg);"> <a href="#"><div class="bar">View The Film, Shop The Collection</div></a> </li>
      <li style="background-image: url(slider/thumb4.jpg);"> <a href="#"><div class="bar">View The Film, Shop The Collection</div></a> </li>
      <li style="background-image: url(slider/thumb4.jpg);"> <a href="#"><div class="bar">View The Film, Shop The Collection</div></a> </li>
    </ul>
  </div>
  
  <div id="cat-list"></div>
  <div id="pro-detail"></div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>