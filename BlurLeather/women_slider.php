<?php require_once("class/class.functions.php"); $fn = new Functions();?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>Blur Leather Womenswear slider</title>
<?php include_once("inc.head.php");?>
<style type="text/css" id="js_sizer_styles"></style>
<style type="text/css" id="js_slideshow_styles"></style>
<style type="text/css" id="js_scarves_styles"></style>
</head>
<body class="resized" style="">
<div id="container">
<?php include_once("inc.header.php");
	$sliders = $fn->SelectQuery("select * from banners where pre_category_id='2' order by orderid");
?>
<div class="content visual landing" data-stacktype="categorylanding">
  <div class="promoslideshow js_slideshow">
  	<?php if($sliders){ $i=1;?> 
    		<?php foreach($sliders as $slider){?>
      <div class="item <?php echo $i==1?'active':'';?>">
          <a href="javascript:;" onClick="senddata('womenswear','','womenswear-list');" class="js_stack">
            <img class="scale" src="banners/<?php echo $slider['banner_image']?>" alt="" height="1080" width="1920">
          </a>
          <a href="javascript:;" onClick="senddata('womenswear','','womenswear-list');" class="entry js_stack">
            <h2 class="h3"><?php echo $slider['banner_title']?></h2>
            <h3 class="h0"><?php echo $slider['banner_sub_title']?></h3>
          </a>
      </div>
		<?php } ?>
      <?php } ?>
      <ul class="categorynav">
		<?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=2 order by orderid")){foreach($cats as $cat){?>    
        <li<?php echo $_GET['cat']==$cat['category_id']? ' class="active"':''?>> <a href="javascript:;" onClick="senddata('womenswear','','womenswear-list');"><?php echo $cat['category_title'];?></a></li>
      <?php }}?>
	</ul>
    
    <ul class="contentpager">
      <li>Previous Product</li>
      <li>Next Product</li>
    </ul>
  </div>
  <div class="logo">Blur Leather</div>
</div>
  <div class="promodrawer js_promodrawer">
    <h6><span class="js_scroll">Show All</span></h6>
    <ul class="promos">
      	<?php if($sliders){?> 
    		<?php foreach($sliders as $slider){?>
        <li style="background-image:url(banners/th_<?php echo $slider['banner_image']?>);">
          <a href="/womenswear/dresses/AAB,en_GB,sc.html" class="js_stack">
            <div class="bar"><?php echo $slider['banner_title']?></div>
          </a>
        </li>
        <?php }}?>
    </ul>
  </div>
<div id="womenswear-list"></div>
<div id="pro-detail"></div>
 <?php include_once("inc.footer.php");?>
</div>
</body></html>