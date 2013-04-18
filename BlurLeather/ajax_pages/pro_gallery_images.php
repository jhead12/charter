<?php require_once("../class/class.functions.php"); 
	$fn = new Functions();
	$gallery = $fn->selectQuery("select * from product_gallery where product_id='".$_GET['product_id']."' and color_id='".$_GET['color_id']."'");
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("../includes/inc.header-scripts-ajax.php");?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://raw.github.com/brandonaaron/jquery-mousewheel/master/jquery.mousewheel.js"></script>
<script type="text/javascript" src="../demo/PanZoom/jquery-panzoom.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#pan img#galimg').panZoom({
			'out_x1'    :   $('#x1'),
			'out_y1'    :   $('#y1'),
			'out_x2'    :   $('#x2'),
			'out_y2'    :   $('#y2'),
			'directedit':   true,
			'debug'     :   false
		  });
	});
</script>
<style type="text/css">
img, a { outline:none; border:none}
ul#gallery_images{ list-style:none;height:<?php echo $_GET['height']-50;?>px; overflow:hidden; width:83px; padding:0; margin:0; position:fixed; right:50px; top:0px;}
ul#gallery_images li{width:81px;height:81px; margin-top:5px;border:1px solid #fff;}
ul#gallery_images li:hover, ul#gallery_images li.current{border:1px solid #D7D7D7; cursor:pointer}
.large_box{height:<?php echo $_GET['height']-50;?>px; overflow:hidden;}
.large_pan{height:<?php echo $_GET['height']-50;?>px;width:<?php echo $_GET['width']-50;?>px;}
</style>
</head>
<body>
<?php include_once("../message.php");?>
<div class="full">
  <div class="col100 large_box">
    <div id="pan" class="large_pan">
    	<?php if($_GET['image']!=""){?>
        <img id="galimg" src="<?php echo $_GET['image']?>" alt="" width="<?php echo $_GET['width']-50;?>" align="middle" />	
		<?php } ?>
    	<ul id="gallery_images">
	<?php if($gallery){ foreach($gallery as $img){?>
    <li><a href="?product_id=<?php echo $_GET['product_id'];?>&color_id=<?php echo $_GET['color_id'];?>&image=<?php echo WEBSITE_URL."product_gallery/".$img['product_id']."/".$img['color_id']."/".$img['img']?>&width=<?php echo $_GET['width']-50;?>&height=<?php echo $_GET['height'];?>"><img id="thumb<?php echo $i;?>" src="<?php echo WEBSITE_URL."product_gallery/".$img['product_id']."/".$img['color_id']."/th_".$img['img']?>" alt="" height="81" width="81"></a></li>
    <?php }}?>
  </ul>
    </div>
  </div>
</div>
<?php include("../includes/inc.footer_unset.php");?>
</body>
</html>