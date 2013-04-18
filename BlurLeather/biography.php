<?php require_once("class/class.functions.php"); $fn = new Functions();
$fn->CurrentUrl();
?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?> | Biography</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div class="content flexmain dark">
    <div class="sidebar">
      <ul class="categorynav">
        <li class="active"><a style="color:#FFFFFF" href="biography.php">Biography</a></li>
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
  </div>
  <div id="biography-detail"></div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>