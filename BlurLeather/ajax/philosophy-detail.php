<?php require_once("../class/class.functions.php"); $fn = new Functions();
if($_POST['philosophy_id']!=''){ $where=" where philosophy_id='".$_POST['philosophy_id']."'";}
$philosophy = $fn->SelectQuery("select * from philosophy {$where}");
$philosophy=$philosophy[0];
?>
<div class="content experience">
    <div class="col first">
      <div class="main">
        <h2 class="h1"><?php echo $philosophy['person_name'];?></h2>
        <p class="intro"><?php echo $fn->MakeHTML($philosophy['philosophy_intro']);?></p>
      </div>
    </div>
    <div class="col">
      <div class="main">
        <p class="text"><?php echo $fn->MakeHTML($philosophy['philosophy_desc']);?></p>
      </div>
    </div>
    <div class="logo">Blur Leather</div>
    <span class="close" onclick="boxclose('philosophy-detail','container');">Close</span>
</div>