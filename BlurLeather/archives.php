<?php require_once("class/class.functions.php"); $fn = new Functions();
	require_once("class/class.pagination.php");
	$fn->CurrentUrl();
?>
<!DOCTYPE html>
<html class="flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<?php include_once("inc.head.php");?>
<title><?php echo COMPANY_NAME;?> | Archives</title>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div id="archive-list">
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
              <li class="selected" onclick="senddata('archive-list','','archive-list');">All</li>
              <li onclick="senddata('archive-list','pre_category_id=2','archive-list');">Womenswear</li>
              <li onclick="senddata('archive-list','pre_category_id=3','archive-list');">Menswear</li>
            </ol>
          </div>
          <div>
            <?php if($yearrs = $fn->SelectQuery("select distinct archive_year from archives order by archive_year asc")){?>
            <h6 class="js_filter">Year</h6>
            <ol class="filter">
              <li class="selected" onclick="senddata('archive-list','','archive-list');">All</li>
              <?php foreach($yearrs as $year){?>
              <li onclick="senddata('archive-list','archive_year=<?php echo $year['archive_year']?>','archive-list');"><?php echo $year['archive_year'];?></li>
              <?php }?>
            </ol>
            <?php } ?>
          </div>
          <div> </div>
        </div>
      </div>
      <div class="main">
        <?php 
            $query="select * from archives order by orderid asc";
            $pager = new Pagination($query,$_REQUEST['page'],5,5);
            if($data = $pager->Paging()){
				$paging=$pager->DisplayAjaxPaging("archive-list","","archive-list");
				if($paging!=""){
				?>
                <ul class="pager">
                	 <?php echo $paging;?>
                </ul>
        <?php } foreach($data as $row){?>
        <a href="javascript:;" onClick="senddata('archive-detail','archive_id=<?php echo $row['archive_id']?>','archive-detail');"  class="teaser"> 
        <img src="<?php echo WEBSITE_URL;?>archives/<?php echo $row['archive_image']?>" alt="<?php echo $row['archive_title']?>" height="481" width="1075">
        <h2 class="h1"><?php echo $row['archive_title']?></h2>
        <span>View the collection</span> </a>
        <?php } 
			if($paging!=""){
		?>
        <ul class="pager">
          <?php echo $paging;?>
        </ul>
        <?php }} ?>
      </div>
      <div class="logo">Blur Leather</div>
    </div>
  </div>
  <div id="archive-detail"></div>
  <div id="archive-gallery"></div>
  <?php include_once("inc.footer.php");?>
  <link href="css/allinone_carousel.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
<script src="js/allinone_carousel.js" type="text/javascript"></script>
  <script type="text/javascript">
	function arch(){
	 $('#allinone_carousel_powerful').allinone_carousel({
			skin: 'powerful',
			width: 960,
			height: 400,
			autoPlay: 3,
			resizeImages:true,
			autoHideNavArrows:false,
			autoHideBottomNav:false,
			//easing:'easeOutBounce',
			numberOfVisibleItems:5,
			elementsHorizontalSpacing:150,
			elementsVerticalSpacing:35,
			verticalAdjustment:60,
			animationTime:0.6,
			showPreviewThumbs:false
		});	 
	}
  </script>
</div>
</body>
</html>