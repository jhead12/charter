<?php require_once("../class/class.functions.php"); $fn = new Functions();
if($_POST['archive_id']!=''){ $where=" where archive_id='".$_POST['archive_id']."'";}
$archive = $fn->SelectQuery("select * from archives {$where}");
$archive=$archive[0];
?>
<div class="content experience">
   <div class="stage media">
        <img src="<?php echo WEBSITE_URL;?>archives/<?php echo $archive['archive_image']?>" alt="<?php echo $row['archive_title']?>" height="874" width="1555">
    </div>
    <div class="col first">
      <div class="main">
        <h2 class="h1"><?php echo $archive['archive_title'];?></h2>
        <p class="text"><?php echo $fn->MakeHTML($archive['archive_desc']);?></p>
      </div>
    </div>
    <div class="col">
      <div class="main">
      	<?php /*?>onclick="senddata('archive-gallery','archive_id=<?php echo $archive['archive_id']?>','archive-gallery');"<?php */?>
        <a class="teaser"> <img src="<?php echo WEBSITE_URL;?>archives/<?php echo $archive['gallery_image']?>" alt="<?php echo $archive['archive_title'];?>" height="357" width="635"></a>
      </div>
    </div>
    <div class="logo">Blur Leather</div>
    <span class="close" onclick="boxclose('archive-detail','archive-list');">Close</span>
</div>