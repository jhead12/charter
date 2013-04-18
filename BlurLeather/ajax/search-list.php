<?php require_once("../class/class.functions.php"); $fn = new Functions();
	$q=$fn->ReplaceSql($_POST['q']);
	$where .= $fn->ReplaceSql($_POST['pre_category_id'])!='' ? " and (product_title like '%".$q."%' or product_description like '%".$q."%')":'';
	$where .= $fn->ReplaceSql($_POST['pre_category_id'])!='' ? " and pre_category_id='".$fn->ReplaceSql($_POST['pre_category_id'])."'":'';
	$query="select * from products where 1=1 {$where} order by product_id asc";
	$products = $fn->SelectQuery($query);
?>
<div class="content flexmain search">
    <div class="sidebar">
      <div class="filters"> <span class="disabled">Clear all filters</span>
        <div class="open">
          <h6 class="js_filter">Category</h6>
          <ol class="filter">
            <li <?php echo $_POST['pre_category_id']=='2' ? ' class="selected"':'';?> onclick="senddata('search-list','pre_category_id=2&q=<?php echo $_POST['q'];?>','search-list');">Womenswear</li>
            <li <?php echo $_POST['pre_category_id']=='3' ? ' class="selected"':'';?> onclick="senddata('search-list','pre_category_id=3&q=<?php echo $_POST['q'];?>','search-list');">Menswear</li>
            <li <?php echo $_POST['pre_category_id']=='4' ? ' class="selected"':'';?> onclick="senddata('search-list','pre_category_id=4&q=<?php echo $_POST['q'];?>','search-list');">Scarf Boutique</li>
            <li <?php echo $_POST['pre_category_id']=='5' ? ' class="selected"':'';?> onclick="senddata('search-list','pre_category_id=5&q=<?php echo $_POST['q'];?>','search-list');">Sale</li>
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
      <div class="more"> We also found <?php if($products){echo count($products);}else{ echo '0';}?> <a href="<?php echo $_SERVER['PHP_SELF'];?>">LB</a> products matching your search </div>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
