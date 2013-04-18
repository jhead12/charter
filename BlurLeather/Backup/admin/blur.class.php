<?php
if(file_exists("C:/websites/blur/lib/application/config.php"))
    require_once('C:/websites/blur/lib/application/config.php');
else
    require_once('/home/content/b/l/u/blurleather/html/lib/application/config.php');
require_once(INCLUDE_PATH.'/database.php');
require_once(INCLUDE_PATH.'/paging.php');
class blur
{
    var $smarty;
    var $basePath  = '';
    var $baseUrl  = '';
    var $fieldClass  = '';
    var $labelClass  = '';
    var $personal = TRUE;

    var $error_message  = '';
    var $verify = array();
    var $doit = 0;
    var $onload = '';
    var $memberId, $id;

    var $action = 'home';

    var $result;

    function blur() {
        db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);
        $this->smartySetup();
        $this->basePath = BASE_PATH;
        $this->baseUrl = BASE_URL;
        $this->labelClass = "formlabel";
        $this->fieldClass = "formfield";
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("imageUrl", IMAGE_URL);
        $this->smarty->assign("productUrl", PRODUCT_URL);

        if(!empty($_GET['result'])) {
            $this->smarty->assign('result', htmlentities($_GET['result']));
            $this->result = urlencode($_GET['result']);
        }

        $this->id = $this->getRequestIntParam("id");
        $catId = $this->getRequestIntParam("catId");

        $categories = $this->getAllCategories();
        $selCategoryID = 0;
        if(count($categories) > 0 && empty($catId)) {
            $selCategoryID = $categories[0]["category_id"];
        }
        else {
        	$selCategoryID = $catId;
        }

        $productTypes = $this->getAllProductTypes($selCategoryID);
        $this->smarty->assign("categories", $categories);
        $this->smarty->assign("productTypes", $productTypes);

        if(empty($this->id) && count($productTypes) > 0) $this->id = $productTypes[0]["product_type_id"];
        $curProductType = $this->getProductType($this->id);
        $this->smarty->assign("curProductType", $curProductType);

        $allowAction = array("product", "home", "product_thumb", "product_detail");
        if(!empty($_GET['page'])) $action = strtolower($_GET["page"]);
        else $action = "home";

        if(in_array($action, $allowAction)) {
            $this->$action();
        }
        else {
            $this->home();
        }
    }

    function getAllCategories() {
        $res  = db_query("SELECT * FROM category ORDER BY category_id");
        return db_fetch_array($res);
    }

    function getAllProductTypes($catId = 0) {
        $catId = intval($catId);
        $res = db_query("SELECT a.*, b.category_name FROM product_type a LEFT JOIN category b ON a.category_id=b.category_id WHERE a.category_id=CASE WHEN $catId=0 THEN a.category_id ELSE $catId END ORDER BY a.category_id, product_type_id");
        return db_fetch_array($res);
    }

    function getProductType($typeId) {
        $typeId = intval($typeId);
        $res = db_query("SELECT a.*, b.category_name FROM product_type a LEFT JOIN category b ON a.category_id=b.category_id WHERE a.product_type_id=$typeId");
        $productType = db_fetch_row($res);
        return $productType;
    }

    function getRequestIntParam($par) {
        if(!empty($_GET[$par]))
            $par = intval($_GET[$par]);
        else
            $par = 0;
        return $par;
    }

    function getRequestStringParam($par) {
        if(!empty($_GET[$par]))
            $par = $_GET[$par];
        else
            $par = "";
        return $par;
    }

    function smartySetup() {
        require_once(BASE_PATH.'/lib/Smarty-2.6.13/libs/Smarty.class.php');
        $this->smarty = new Smarty();
        $this->smarty->template_dir = BASE_PATH.'/lib/templates/';
        $this->smarty->compile_dir  = BASE_PATH.'/lib/smarty/templates_c/';
        $this->smarty->config_dir   = BASE_PATH.'/lib/smarty/configs/';
        $this->smarty->cache_dir    = BASE_PATH.'/lib/smarty/cache/';
        $this->smarty->caching=FALSE;
        $this->smarty->cache_lifetime=0;
    }

    function doRedirect($page) {
		/*$page = preg_replace("!index.php\?page=([a-z|_]+)!is", "$1.php", $page);
		$page = str_replace(".php&amp;", ".php?", $page);
		$page = str_replace(".php&", ".php?", $page);*/
		header("Location: ".$this->baseUrl."$page");
		exit;
    }

    function renderFile($fileName = '') {
		$content = $this->smarty->fetch($fileName);
		/*$content = preg_replace("!".$this->baseUrl."/index\.php\?page=([a-z|_]+)&amp;article_id=([0-9]+)!is", $this->baseUrl."/$1-a$2.oto", $content);
		$content = preg_replace("!".$this->baseUrl."/index\.php\?page=([a-z|_]+)&amp;car_id=([0-9]+)!is", $this->baseUrl."/$1-c$2.oto", $content);
		$content = preg_replace("!".$this->baseUrl."/index\.php\?page=([a-z|_]+)&amp;cat=([0-9]+)!is", $this->baseUrl."/$1-c$2.php", $content);
		$content = preg_replace("!".$this->baseUrl."/index\.php\?page=([a-z|_]+)&amp;id=([0-9]+)!is", $this->baseUrl."/$1-$2.php", $content);
		$content = preg_replace("!".$this->baseUrl."/index\.php\?page=([a-z|_]+)!is", $this->baseUrl."/$1.php", $content);
		$content = str_replace(".php&amp;", ".php?", $content);
		$content = str_replace(".php&", ".php?", $content);
		$content = preg_replace("!".$this->baseUrl."/editcar-c([0-9]+).oto\?(.*?)!is", $this->baseUrl."/index.php?page=editcar&amp;car_id=$1&amp;$2", $content);*/
		echo $content;
    }

    function getProducts($params) {
    	$sql = "SELECT a.*,b.product_type as name, b.category_id, c.category_name FROM product a
            LEFT JOIN product_type b ON b.product_type_id=a.product_type_id
            LEFT JOIN category c ON c.category_id=b.category_id
    	WHERE a.product_type_id={$params["product_type_id"]}
    	ORDER BY a.product_id DESC ";
    	$sql .= " LIMIT ".$params['start_rec'].", ".$params['page_size'];
    	$res = db_query($sql);

        $sqlCount = "SELECT COUNT(a.product_id) FROM product a
            LEFT JOIN product_type b ON b.product_type_id=a.product_type_id
            LEFT JOIN category c ON c.category_id=b.category_id
        WHERE a.product_type_id={$params["product_type_id"]}";

        $result = db_query($sqlCount);
    	$params['record_count'] = db_fetch_one($result);

        return db_fetch_array($res);
    }

    function home() {
        $this->renderFile("header.tpl");
        $this->renderFile("footer.tpl");
    }

    function product() {
    	$params["product_type_id"] = $this->id;
        $params['start_rec'] = $this->getRequestIntParam('startRec');
        if(!empty($_REQUEST['pageSize']))
            $params['page_size'] = intval($_REQUEST['pageSize']);
        if(empty($params['page_size']) || $params['page_size'] <= 0) $params['page_size'] = 7;
        $this->smarty->assign('pageSize', $params['page_size']);
        $this->smarty->assign('startRec', $params['start_rec']);
        $products = $this->getProducts(&$params);
        $this->smarty->assign("products", $products);
        if(count($products) > 0) {
        	$this->smarty->assign("product", $products[0]);
        	$prevProduct = $this->getPrevProduct($products[0]["product_id"]);
	        $nextProduct = $this->getNextProduct($products[0]["product_id"]);
	        if(!empty($prevProduct))
	        	$this->smarty->assign("prevProduct", $prevProduct);
	        if(!empty($nextProduct))
	        	$this->smarty->assign("nextProduct", $nextProduct);
        }
        getPagingString(BASE_URL."/product.php?page=product_thumb&amp;id={$params["product_type_id"]}&amp;pageSize=".$params['page_size'], $params['start_rec'], $params['page_size'], PAGING_NUMBER_COUNT, $params['record_count'], $this->smarty);
    	$this->renderFile("header.tpl");
    	$this->renderFile("product.tpl");
    	$this->renderFile("footer.tpl");
    }

    function product_thumb() {
    	$params["product_type_id"] = $this->id;
    	$params['start_rec'] = $this->getRequestIntParam('startRec');
        if(!empty($_REQUEST['pageSize']))
            $params['page_size'] = intval($_REQUEST['pageSize']);
        if(empty($params['page_size']) || $params['page_size'] <= 0) $params['page_size'] = 7;
        $this->smarty->assign('pageSize', $params['page_size']);
        $this->smarty->assign('startRec', $params['start_rec']);
        $products = $this->getProducts(&$params);
        $this->smarty->assign("products", $products);
        getPagingString(BASE_URL."/product.php?page=product_thumb&amp;id={$params["product_type_id"]}&amp;pageSize=".$params['page_size'], $params['start_rec'], $params['page_size'], PAGING_NUMBER_COUNT, $params['record_count'], $this->smarty);
    	$this->renderFile("product_thumb.tpl");
    }

    function getNextProduct($productId) {
    	$productId = intval($productId);
    	$res = db_query("SELECT *, DATE_FORMAT(crdate, '%Y-%m-%d %H:%i:%s') AS ddate FROM product WHERE product_id=$productId");
    	$curProduct = db_fetch_row($res);
    	$res = db_query("SELECT * FROM product WHERE product_type_id=".$curProduct["product_type_id"]." AND product_id < {$curProduct["product_id"]} ORDER BY product_id DESC LIMIT 0, 1");
    	return db_fetch_row($res);
    }

    function getPrevProduct($productId) {
    	$productId = intval($productId);
    	$res = db_query("SELECT * FROM product WHERE product_id=$productId");
    	$curProduct = db_fetch_row($res);
    	$res = db_query("SELECT * FROM product WHERE product_type_id=".$curProduct["product_type_id"]." AND product_id > {$curProduct["product_id"]}  ORDER BY product_id ASC LIMIT 0, 1"); /*DATEDIFF('".$curProduct["ddate"]."', crdate) <= 0*/
    	return db_fetch_row($res);
    }

    function getProduct($productId) {
    	$productId = intval($productId);
    	$sql = "SELECT a.*,b.product_type as name, b.category_id, c.category_name FROM product a
            LEFT JOIN product_type b ON b.product_type_id=a.product_type_id
            LEFT JOIN category c ON c.category_id=b.category_id
    	WHERE a.product_id=$productId
    	";
        $res = db_query($sql);
        return db_fetch_row($res);
    }

    function product_detail () {
    	$params["product_type_id"] = $this->id;
    	$productId = $this->getRequestIntParam("product_id");
    	$product = $this->getProduct($productId);
        $this->smarty->assign("product", $product);
        $prevProduct = $this->getPrevProduct($productId);
        $nextProduct = $this->getNextProduct($productId);
        if(!empty($prevProduct))
        	$this->smarty->assign("prevProduct", $prevProduct);
        if(!empty($nextProduct))
        	$this->smarty->assign("nextProduct", $nextProduct);
    	$this->renderFile("product.tpl");
    }
}
?>