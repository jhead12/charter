<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();
	$storers = $fn->SelectQuery("select * from stores order by store_id asc");
?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB"><head>
<title><?php echo COMPANY_NAME;?> | Store Locator</title>
<?php include_once("inc.head.php");?>
 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyAYKtw_DCMtILmMVYCQpPgQTOz8idHyMe0" type="text/javascript"></script>
<script language="'Javascript'" type='text/javascript'>
	var map = null;
	var geocoder = null;

	function load(l1,l2,address) {
		if (GBrowserIsCompatible()) {
			var point;
			var map = new GMap2(document.getElementById("map"));

			map.addControl(new GOverviewMapControl());
			map.enableDoubleClickZoom();
			map.enableScrollWheelZoom();
			map.addControl(new GMapTypeControl());
			map.addControl(new GSmallMapControl());
			point = new GLatLng(l1,l2);

			var marker = new GMarker(point);
			map.setCenter(point, 15);
			map.addOverlay(marker);
			//map.setMapType(G_SATELLITE_MAP);
			GEvent.addListener(marker, "mouseover", function() { marker.openInfoWindowHtml(address); });
			marker.openInfoWindowHtml(address);
		}
	}
</script>    
</head>
<body class="resized" style="">
<div id="container">
<?php include_once("inc.header.php");?>
<div id="store-list">
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
</div>
<div id="store-detail"></div>
<?php include_once("inc.footer.php");?>
</div>
</body>
</html>