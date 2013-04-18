<?php require_once("../class/class.functions.php"); $fn = new Functions();
		require_once("../class/class.pagination.php");
?>
<div class="content flexmain dark">
  <div class="sidebar">
    <ul class="categorynav">
      <li><a href="biography.php">Biography</a></li>
      <li><a href="philosophy.php">Our Philosphy</a></li>
      <li class="active"><a style="color:#FFF" href="archives.php">Archives</a></li>
    </ul>
    <div class="filters"> <span>Clear all filters</span>
      <div class="open">
        <h6 class="js_filter">Collection</h6>
        <ol class="filter collection">
          <li <?php echo $_POST['pre_category_id']=='' ? 'class="selected"':'';?> onclick="senddata('archive-list','archive_year=<?php echo $_POST['archive_year']?>','archive-list');">All</li>
          <li <?php echo $_POST['pre_category_id']=='2' ? ' class="selected"':'';?> onclick="senddata('archive-list','pre_category_id=2&archive_year=<?php echo $_POST['archive_year']?>','archive-list');">Womenswear</li>
          <li <?php echo $_POST['pre_category_id']=='3' ? ' class="selected"':'';?> onclick="senddata('archive-list','pre_category_id=3&archive_year=<?php echo $_POST['archive_year']?>','archive-list');">Menswear</li>
        </ol>
      </div>
      <div>
        <?php if($yearrs = $fn->SelectQuery("select distinct archive_year from archives order by archive_year asc")){?>
        <h6 class="js_filter">Year</h6>
        <ol class="filter">
          <li <?php echo $_POST['archive_year']=='' ? ' class="selected"':'';?> onclick="senddata('archive-list','pre_category_id=<?php echo $_POST['pre_category_id']?>','archive-list');">All</li>
          <?php foreach($yearrs as $year){?>
          <li <?php echo $_POST['archive_year']==$year['archive_year'] ? ' class="selected"':'';?> onclick="senddata('archive-list','pre_category_id=<?php echo $_POST['pre_category_id']?>&archive_year=<?php echo $year['archive_year']?>','archive-list');"><?php echo $year['archive_year'];?></li>
          <?php }?>
        </ol>
        <?php } ?>
      </div>
      <div> </div>
    </div>
  </div>
  <div class="main">
    <?php 
	$where .= $fn->ReplaceSql($_POST['pre_category_id'])!='' ? " and pre_category_id='".$fn->ReplaceSql($_POST['pre_category_id'])."'":'';
	$where .= $fn->ReplaceSql($_POST['archive_year'])!='' ? " and archive_year='".$fn->ReplaceSql($_POST['archive_year'])."'":'';
	$query="select * from archives where 1=1 {$where} order by orderid asc";
	$pager = new Pagination($query,$_POST['page'],5,5);
	if($data = $pager->Paging()){
		$paging=$pager->DisplayAjaxPaging("archive-list","pre_category_id=".$_POST['pre_category_id']."&archive_year=".$_POST['archive_year'],"archive-list");
		if($paging!=""){?>
            <ul class="pager">
                <?php echo $paging;?>          
            </ul>
    <?php } foreach($data as $row){?>
    <a href="javascript:;" onClick="senddata('archive-detail','archive_id=<?php echo $row['archive_id']?>','archive-detail');"  class="teaser"> <img src="<?php echo WEBSITE_URL;?>archives/<?php echo $row['archive_image']?>" alt="<?php echo $row['archive_title']?>" height="481" width="1075">
    <h2 class="h1"><?php echo $row['archive_title']?></h2>
    <span>View the collection</span> </a>
    <?php } 
		if($paging!=""){
	?>
        <ul class="pager">
          <?php echo $paging;?> 
        </ul>
    <?php } } ?>
  </div>
  <div class="logo">Blur Leather</div>
</div>
