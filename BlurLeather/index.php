<?php require_once("class/class.functions.php"); require_once("class/class.youtube.php"); 
$fn = new Functions();$fn->CurrentUrl();
	if(isset($_REQUEST['signout'])){
		$fn->SignOut();	
	}
	$Y = new YouTube();
?>
<!DOCTYPE html>
<html class="js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<?php include_once("inc.head.php");?>
<title><?php echo COMPANY_NAME;?> | Home</title>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");
  	$sliders = $fn->SelectQuery("select * from home_banners order by orderid");
  ?>
  <div class="content home visual">
    <div class="promoslideshow js_slideshow" data-timer="3500">
    <?php if($sliders){ $i=1;?> 
    		<?php foreach($sliders as $slider){?>
	      		<div class="item <?php echo $i==1?'active':'';?>" id="abc<?php echo $i;?>">
                <?php if( $slider['tag'] == 'V'){?> 
                <?php echo $Y->VideoFromUrl($slider['banner_video_url']);?>
                <?php }else{?>
                <a href="<?php echo $slider['page_url']?>"><img class="scale" src="home_banners/<?php echo $slider['banner_image']?>" alt="<?php echo $slider['banner_title']?>" height="1080" width="1920"/></a>
                <?php }?>
                </div>
    	  <?php $i++; } ?>
      <?php } ?>
      <ul class="contentpager">
        <li>Previous</li>
        <li>Next</li>
      </ul>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
  <div class="promodrawer js_promodrawer">
    <h6><span class="js_scroll">MORE BLUR LEATHER</span> </h6>
    <ul class="promos promo4">
    	<?php if($sliders){?> 
    		<?php foreach($sliders as $slider){?>
	  			<li style="background-image: url(home_banners/th_<?php echo $slider['banner_image']?>);"> <a href="<?php echo $slider['page_url']?>"></a> </li>    		
    	  <?php } ?>
      <?php } ?>
    </ul>
  </div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>