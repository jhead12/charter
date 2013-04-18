<?php require_once("../class/class.functions.php"); $fn = new Functions();?>script|g|
<div class="content experience">
   <div class="stage media">
		<div id="slider">
        <ul>
		<li>
		<?php  $i=0;
		if($banners = $fn->SelectQuery("select * from archive_images where archive_id='".$_POST['archive_id']."'")){foreach ($banners as $imgs){?>
        <a><img src="archive_images/archive_images_<?php echo $imgs['archive_id'];?>/<?php echo $imgs['archive_image'];?>" alt="" width="200px" /></a>
        <?php $i++; if($i%3==0) echo '</li><li>';}}?>
        </li>
        </ul>
      </div>
    </div>
    <div class="logo">Blur Leather</div>
    <span class="close" onclick="boxclose('archive-gallery','archive-detail');">Close</span>
</div>|g|arch();