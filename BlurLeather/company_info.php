<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?> | Company Info</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div class="content flexmain text">
    <div class="sidebar">
      <?php if($infors = $fn->SelectQuery("select * from company_info")){?>
      <h2 class="h3">Company Info</h2>
      <ul class="subnav">
        <?php foreach($infors as $info){?>
        <li <?php echo $info['info_id']==$_REQUEST['info_id']?'class="active"':''?>><a href="?info_id=<?php echo $info['info_id'];?>"><?php echo $info['info_title'];?></a></li>
        <?php }?>
      </ul>
      <?php }?>
    </div>
    <div class="main">
      <?php
	  	if($_REQUEST['info_id']!=""){
			$where=" where info_id='".$_REQUEST['info_id']."'";  
		}else{
			$where=" order by info_id asc limit 0 ,1";  
		}
	   if($info = $fn->SelectQuery("select * from company_info {$where}")){?>
      <div class="text">
        <h2 class="h2"><?php echo $info[0]['info_title'];?></h2>
        <p><?php echo $fn->MakeHTML($info[0]['info_content']);?></p>
      </div>
      <?php } ?>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>