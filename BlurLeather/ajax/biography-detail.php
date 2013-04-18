<?php require_once("../class/class.functions.php"); $fn = new Functions();
if($_POST['biography_id']!=''){ $where=" where biography_id='".$_POST['biography_id']."'";}
$biography = $fn->SelectQuery("select * from biography {$where}");
$biography=$biography[0];
?>
<div class="content experience">
    <div class="col first">
      <div class="main">
        <h2 class="h1"><?php echo $biography['person_name'];?></h2>
        <p class="intro"><?php echo $fn->MakeHTML($biography['biography_intro']);?></p>
      </div>
    </div>
    <div class="col">
      <div class="main">
        <p class="text"><?php echo $fn->MakeHTML($biography['biography_desc']);?></p>
      </div>
    </div>
    <div class="logo">Blur Leather</div>
    <span class="close" onclick="boxclose('biography-detail','container');">Close</span>
</div>