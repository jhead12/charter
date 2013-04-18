<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<?php include_once("inc.head.php");?>
<title><?php echo COMPANY_NAME;?> | Philosophy</title>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div class="content flexmain dark">
    <div class="sidebar">
      <ul class="categorynav">
        <li><a href="biography.php">Biography</a></li>
        <li class="active"><a style="color:#FFF" href="philosophy.php">Our Philosphy</a></li>
        <li><a href="archives.php">Archives</a></li>
      </ul>
    </div>
    <div class="main">
      <?php if($philosophyrs = $fn->SelectQuery("select * from philosophy order by philosophy_id")){
			foreach($philosophyrs as $philosophy){?>
      <a href="javascript:;" onClick="senddata('philosophy-detail','philosophy_id=<?php echo $philosophy['philosophy_id']?>','philosophy-detail');" class="teaser"> <img src="philosophy/<?php echo $philosophy['philosophy_image']?>" alt="<?php echo $philosophy['person_name']?>" height="481" width="1075">
      <h2 class="h1"><?php echo $philosophy['person_name']?></h2>
      <span>VIEW PHILOSPHY</span> </a>
      <?php }}?>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
  <div id="philosophy-detail"></div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>