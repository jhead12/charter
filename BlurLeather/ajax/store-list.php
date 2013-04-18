<?php require_once("../class/class.functions.php"); $fn = new Functions();
if($_POST['country_id']!=''){ $where=" where country_id='".$_POST['country_id']."'";}
$storers = $fn->SelectQuery("select * from stores {$where} order by store_id asc");
?>
<div class="content flexmain stores js_storefilter">
      <div class="sidebar">
        <h6 class="h3">Country</h6>
         <?php if($countryrs = $fn->SelectQuery("select * from country where country_id in (select country_id from stores)")){?>
        <select id="country_id" name="country_id" onChange="senddata('store-list','country_id='+this.value,'store-list');">
          <option value="">Select Country</option>
          <?php foreach($countryrs as $country){?>
              <option value="<?php echo $country['country_id'];?>" <?php echo $_POST['country_id']==$country['country_id']?'selected="selected"':'';?>><?php echo $country['country_title'];?></option>
          <?php } ?>
        </select>
        <?php } ?>
      </div>
      <div class="main">
        <ul id="stores" class="storelist js_pagelist">
             <?php if($storers){foreach($storers as $store){?> 
            <li>
              <a href="javascript:;" onClick="senddata('store-detail','country_id=<?php echo $_POST['country_id']?>&store_id=<?php echo $store['store_id']?>','store-detail');" class="teaser">
                <?php if($fn->ImageExists("stores",$store['store_image'])){?>
                    <img src="stores/<?php echo $store['store_image']?>" alt="<?php echo $store['store_name']?>" height="210" width="1075">
                  <?php } ?>
                
                <h2 class="h1"><?php echo $store['store_name']?></h2>
                <span>View Details</span>
              </a>
            </li>
          <?php } }?>
        </ul>
      </div>
      <div class="logo">Blur Leather</div>
    </div>