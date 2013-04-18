<?php require_once("../class/class.functions.php");
	$fn = new Functions();
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("../includes/inc.header-scripts-ajax.php");?>
</head>
<body>
<?php include_once("../message.php");?>
<div class="full content_section">
	<div class="full">
      <h2 class="text_capital">Help</h2>
    </div>
  <div class="left_section"> 
    <?php if($content = $fn->SelectQuery("select * from content_table"))?>
    <div class="full paddtop10"> 
    	<ul class="subnav">
        	<?php foreach($content as $row){?>
            <li <?php echo $_GET['ctitle']==$row['content_title']? 'class="active"':'';?>><a href="?ctitle=<?php echo $row['content_title'];?>"><?php echo $row['page_title'];?></a></li>
            <?php } ?>
    	</ul>
    </div>
</div>
<?php if($content = $fn->SelectQuery("select * from content_table where content_title='".$_GET['ctitle']."'")){?>
  <div class="right_section">
  	<div class="full paddtop10"> 
    	<h3><?php echo $content[0]['page_title']?></h3>
        <div class="content">
        	<p><?php echo $fn->MakeHTML($content[0]['content_desc']);?></p>
        </div>
     </div>   
  </div>
 <?php } ?> 
</div>
</body>
</html>