<?php require_once("../class/class.functions.php"); 
	$fn = new Functions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("../includes/inc.header-scripts-ajax.php");?>
</head>
<body>
<div class="countries">
    <h2 class="text_capital">Select Your Region</h2>
    <p>To shop online, select your location from one of the following countries.</p>
    	<?php if($data = $fn->SelectQuery("select * from country where country_code!='' order by country_title")){?>
     	<ul>
			<?php foreach($data as $row){?>
            <?php /*?><li><a href="javascript:;" onclick="senddata('currency','type=country&currency=<?php echo $row['country_code'];?>&country_id=<?php echo $row['country_id'];?>&country_title=<?php echo $row['country_title'];?>','')"><?php echo $row['country_title']." ".$row['country_symbol']?></a></li><?php */?>
            <li><a href="javascript:;"><?php echo $row['country_title']." ".$row['country_symbol']?></a></li>
            <?php } ?>      
          </ul>
        <?php } ?>
  </div>
</body>
</html>