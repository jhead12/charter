<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();
	$q=$fn->ReplaceSql($_REQUEST['q']);
	if($q!=''){$where.= " and (product_title like '%".$q."%' or product_title like '% ".$q."%' or product_description like '%".$q."%' or product_description like '% ".$q."%')";}
	$products = $fn->SelectQuery("select * from products where 1=1 {$where} order by product_id asc");
?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php echo COMPANY_NAME;?> | Search</title>
<?php include_once("inc.head.php");?>
<body class="resized">
<div id="container">
	<?php include_once("inc.header.php");?>
<div id="search-list">
  <div class="content flexmain search">
    <div class="sidebar">
      <div class="filters"> <span class="disabled">Clear all filters</span>
        <div class="open">
          <h6 class="js_filter">Category</h6>
          <ol class="filter">
            <li onclick="senddata('search-list','pre_category_id=2&q=<?php echo $_GET['q'];?>','search-list');">Womenswear</li>
            <li onclick="senddata('search-list','pre_category_id=3&q=<?php echo $_GET['q'];?>','search-list');">Menswear</li>
            <li onclick="senddata('search-list','pre_category_id=4&q=<?php echo $_GET['q'];?>','search-list');">Scarf Boutique</li>
            <li onclick="senddata('search-list','pre_category_id=5&q=<?php echo $_GET['q'];?>','search-list');">Sale</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="main">
      <h2 class="h1">There is results for ‘<?php echo $q?>’</h2>
      <h3 class="h4">Products (<?php if($products){echo count($products);}else{ echo '0';}?> results)</h3>
      <ul class="products">
      	<?php if($products){foreach($products as $product){?> 
        <li> <a href="javascript:;" onClick="senddata('search-detail','id=<?php echo $product['product_id'];?>&q=<?php echo $q;?>','search-detail');">
        		<img src="products/<?php echo $product['featured_image'];?>" alt="<?php echo $product['product_title']?>" height="325" width="212">
          		<h4><?php echo $product['product_title']?></h4>
          </a> 
        </li>
          <?php } }?>
      </ul>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
</div>  
  <div id="search-detail"></div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>