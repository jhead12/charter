<?php require_once("../class/class.functions.php"); $fn = new Functions();
$gallery = $fn->selectQuery("select * from product_gallery where product_id='".$_POST['product_id']."' and color_id='".$_POST['color_id']."'");
if($fn->ImageExists("product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id'],$gallery[0]['img'])){
	$getwh = getimagesize(UPLOAD_PATH_ORG."product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id']."/".$gallery[0]['img']); 
  	list($w,$h) = $fn->GetRatio($getwh[0],$getwh[1],514,410);
 }
?>script|g|<input type="hidden" name="x1" value="<?php echo (514-$w)/2;?>" id="x1">
    <input type="hidden" name="x2" value="<?php echo $w + ((514-$w)/2)?>" id="x2">
    <input type="hidden" name="y1" value="0" id="y1">
    <input type="hidden" name="y2" value="<?php echo $h?>" id="y2">
    <div class="pdimage js_zoomable js_thumb">
      <div class="pan" id="pan">
       <img id="galimg" src="<?php echo WEBSITE_URL."product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id']."/".$gallery[0]['img']?>" alt="<?php echo WEBSITE_URL."product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id']."/".$gallery[0]['img']?>" />
      </div>
      <ul class="zoomtools">
        <li class="zoomin js_zoom" id="zoomin">Zoom in</li>
        <li class="zoomout js_unzoom" id="zoomout">Zoom out</li>
        <li class="full" onclick="superopen('<?php echo WEBSITE_URL."ajax_pages/pro_gallery_images.php?product_id=".$gallery[0]['product_id']."&color_id=".$gallery[0]['color_id'];?>&image='+$('#galimg').attr('src')+'&width='+($(window).width()-70)+'&height='+($(window).height()-100),$(window).width()-70,$(window).height()-100);">Fullscreen</li>
      </ul>
      <div class="carousel js_carousel">
        <div class="frame">
          <ul class="js_list" id="gallery_images">
            <?php if($gallery){ foreach($gallery as $img){?>
            <li onclick="$('#galimg').attr('src','<?php echo WEBSITE_URL."product_gallery/".$img['product_id']."/".$img['color_id']."/".$img['img']?>');"><img src="<?php echo WEBSITE_URL."product_gallery/".$img['product_id']."/".$img['color_id']."/th_".$img['img']?>" alt="<?php echo WEBSITE_URL."product_gallery/".$img['product_id']."/".$img['color_id']."/th_".$img['img']?>" height="81" width="81"></li>
            <?php }}?>
          </ul>
        </div>
        <span id="prev1" class="prev">Previous</span> 
        <span id="next1" class="next js_next">Next</span>
        </div>
    </div>|g|zoom_fun();
