<?php require_once("class/class.functions.php"); $fn = new Functions();
$fn->CurrentUrl();
?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?> | Experience</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");
  	$sliders = $fn->SelectQuery("select * from home_banners order by orderid desc limit 0 ,1");?>
	<?php if($sliders){?> 
  <div class="content visual dark">
  	<?php foreach($sliders as $slider){?>
	      		<div class="item"> 
                <a href="<?php echo $slider['page_url']?>"> <img class="scale" src="home_banners/<?php echo $slider['banner_image']?>" alt="<?php echo $slider['banner_title']?>" height="1080" width="1920"/> </a>
                <a href="<?php echo $slider['page_url']?>" class="entry">
                <h2 class="h3"><?php echo $slider['banner_title']?></h2>
                <h3 class="h0"><?php echo $slider['banner_sub_title']?></h3>
              </a>
                </div>
    	  <?php $i++; } ?>
  <div class="logo">Blur Leather</div>
</div>
	<?php } ?>
  <div id="experience_list">
  <div class="content flexmain dark">
    <div class="sidebar">
      <ul class="categorynav">
        <li><a href="biography.php">Biography</a></li>
        <li><a href="philosophy.php">Our Philosphy</a></li>
        <li><a href="archives.php">Archives</a></li>
      </ul>
    </div>
    <div class="main">
      <?php if($biographyrs = $fn->SelectQuery("select * from biography order by biography_id")){
			foreach($biographyrs as $biography){?>
      <a href="javascript:;" onClick="senddata('biography-detail','biography_id=<?php echo $biography['biography_id']?>','biography-detail');" class="teaser"> <img src="biography/<?php echo $biography['biography_image']?>" alt="<?php echo $biography['person_name']?>" height="481" width="1075">
      <h2 class="h1"><?php echo $biography['person_name']?></h2>
      <span>VIEW BIOGRAPHY</span> </a>
      <?php }}?>
    </div>
    <div class="logo">Blur Leather</div>
    <span class="close" onclick="boxclose('experience_list','container');">Close</span>
  </div>
  </div>
  <div id="biography-detail"></div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>