<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?> | Privacy Policy</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div class="content flexmain text">
    <div class="sidebar">
      <?php if($privacyrs = $fn->SelectQuery("select * from privacy_policy")){?>
      <h2 class="h3">Privacy policy</h2>
      <ul class="subnav">
        <?php foreach($privacyrs as $privacy){?>
        <li <?php echo $privacy['privacy_id']==$_REQUEST['privacy_id']?'class="active"':''?>><a href="?privacy_id=<?php echo $privacy['privacy_id'];?>"><?php echo $privacy['privacy_title'];?></a></li>
        <?php }?>
      </ul>
      <?php }?>
    </div>
    <div class="main">
      <?php if($_REQUEST['privacy_id']!=""){
				$where=" where privacy_id='".$_REQUEST['privacy_id']."'";  
			}else{
				$where=" order by privacy_id asc limit 0 ,1";  
			}
	  if($privacy = $fn->SelectQuery("select * from privacy_policy {$where}")){?>
      <div class="text">
        <h2 class="h2"><?php echo $privacy[0]['privacy_title'];?></h2>
        <p><?php echo $fn->MakeHTML($privacy[0]['privacy_content']);?></p>
      </div>
      <?php } ?>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>