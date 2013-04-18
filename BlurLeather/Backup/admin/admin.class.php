<?php
require_once('blur.class.php');

class admin extends blur{
    var $smarty;
    var $module_id;
    var $basePath;
    var $fieldClass;
    var $labelClass;

    var $adminUrl;

    var $error_message;
    var $verify=array();
    var $doit=0;
    var $onload;

    var $action = 'login';

    var $user, $id;

    function admin() {
        db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);
        $this->smartySetup();
        $this->basePath = BASE_PATH;
        $this->adminUrl = ADMIN_URL;
        $this->labelClass = "formlabel";
        $this->fieldClass = "formfield";
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("adminUrl", ADMIN_URL);
        $this->smarty->assign("productUrl", PRODUCT_URL);

        $this->user = $this->user();
        $this->smarty->assign("user", $this->user);

        if(!empty($_GET['result'])) $this->smarty->assign('result', htmlentities($_GET['result']));

        $allowedAction = array ("login", );
        if(!empty($this->user)) {
            $allowedAction[] = "home";
            $allowedAction[] = "deleteimage";
            $allowedAction[] = "logout";
        }

        $this->id = $this->getRequestIntParam("id");
        $catId = $this->getRequestIntParam("catId");

        if(!empty($this->user)) {
           $adminActions = array("manageproduct", "addproduct", "editproduct", "deleteproduct",);
           $allowedAction = array_merge($allowedAction, $adminActions);

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
	        $this->smarty->assign("product_type_id", $this->id);
	        $curProductType = $this->getProductType($this->id);
	        $this->smarty->assign("curProductType", $curProductType);
        }

        $action = '';
        if(!empty( $_GET['action']))
            $action = $_GET['action'];
        $this->action = $action;
        if(empty($action) && !empty($this->user)) $action = "home";
        $this->smarty->assign('action', $this->action);
        if(!empty($action) && in_array($action, $allowedAction) && !empty($this->user)) {
            $this->$action();
        }
        else if(!empty($this->user)) {
            $this->doRedirect("/index.php?action=manageproduct&id=1&result=Unauthorized%20Access.");
        }
        else {
            $this->login();
        }
    }

    function deleteimage() {
    	$urlBefore = $_SERVER["HTTP_REFERER"];
    	$im = $_GET["im"];
    	$baseim = $im;
    	$baseim = trimText($baseim);
    	$im = explode("c", $im);
    	if(file_exists(PRODUCT_PATH."/".$_GET["im"]))
    		unlink(PRODUCT_PATH."/".$_GET["im"]);
    	$id = intval($im[1]);
    	db_query("UPDATE product SET color".$id."='' WHERE color".$id."='".$baseim."'");
    	header("location:".$urlBefore);
    }

    function logout() {
        $_SESSION['user'] = "";
        $this->doRedirect("/index.php");
    }

    function smartySetup() {
        require_once(BASE_PATH.'/lib/Smarty-2.6.13/libs/Smarty.class.php');
        $this->smarty = new Smarty();
        $this->smarty->template_dir = BASE_PATH.'/lib/templates/admin/';
        $this->smarty->compile_dir  = BASE_PATH.'/lib/smarty/admin/templates_c/';
        $this->smarty->config_dir   = BASE_PATH.'/lib/smarty/admin/configs/';
        $this->smarty->cache_dir    = BASE_PATH.'/lib/smarty/admin/cache/';
        $this->smarty->caching=FALSE;
        $this->smarty->cache_lifetime=0;
    }

    function doRedirect($page) {
        header("Location: ".$this->adminUrl.$page);
        exit;
    }

    function login() {
        $this->smarty->assign("title", "Site Admin Login");
        $this->formLogin_init($values='', 'INSERT');
        $this->loginForm->LoadInputValues($this->loginForm->WasSubmitted("doEntry"));
        $this->loginForm->WasSubmitted("doEntry")? $doEntry=1 : $doEntry=0;

        if ($doEntry) {
            $this->formLogin_check('INSERT');
        }
        else {
            $this->showLogin();
        }
    }

    function showLogin() {
        $this->formLogin_parse();
        $this->smarty->display('login.tpl');
    }

    function formLogin_check() {
        $this->verify=array();
        if(($this->error_message = $this->loginForm->Validate($this->verify))=="") {
            $this->formLogin_process();
        }
        else {
            $this->error_message = htmlentities($this->error_message);
            $this->showLogin();
        }
    }

    function formLogin_process() {
        $values['username'] = trim(strip_tags($this->loginForm->GetInputValue("username")));
        $values['passwd'] = trim(strip_tags($this->loginForm->GetInputValue("passwd")));

        if ($this->checkLogin($values)) {
            $result = 'Login berhasil.';
            $this->doRedirect("/index.php?action=home&result=$result");
        }
        else {
            $this->error_message='Email or password wrong.';
            $this->showLogin();
        }
    }


    function formLogin_parse() {
        $this->smarty->assign_by_ref("form",$this->loginForm);
        $this->smarty->assign("error_message",$this->error_message);
        $this->smarty->assign_by_ref("verify",$this->verify);
        $this->smarty->assign("doit",$this->doit);
        $this->smarty->assign("mark","[Verify]");
        $this->smarty->register_prefilter("smarty_prefilter_form");
        $this->smarty->fetch("form_login.tpl");
        $this->smarty->unregister_prefilter("smarty_prefilter_form");

        Reset($this->verify);
        $this->onload="PageLoad()";
        $this->loginForm->AddFunction(array(
            "Function"=>"PageLoad",
            "Type"=>"focus",
            "Element"=>(count($this->verify) ? Key($this->verify) : "username")
        ));

        $loginFrm = FormCaptureOutput($this->loginForm,array("EndOfLine"=>"\n"));
        $this->smarty->assign("loginForm", $loginFrm);
        $this->smarty->assign("onload",$this->onload);
    }

    function checkLogin($values)
    {
        foreach ($values as $key=>$value) {
            $values[$key]=trimText($value);
        }
        $sql = "SELECT * FROM user WHERE user_name='".$values['username']."' AND passwd='".$values['passwd']."'";
        $result = db_query($sql);
        if ($users = db_fetch_array($result)) {
            if(count($users) == 1 && $users[0]['passwd'] == $values['passwd']) {
                $_SESSION['user'] = $users[0];
                return TRUE;
            }
            else
                return FALSE;
        }
        else {
            return FALSE;
        }
    }

    function formLogin_init($values="") {
    	if (!is_array($values)) {
            $values = array (
                'username'=>'',
                'passwd'=>'',
            );
        }

        require_once($this->basePath."/lib/Smarty-2.6.13/libs/plugins/prefilter.form.php");
        require_once($this->basePath."/lib/application/forms.php");
        $this->loginForm = new form_class;

        $this->loginForm->NAME="loginForm";
        $this->loginForm->ID="loginForm";
        $this->loginForm->METHOD="POST";
        $this->loginForm->ACTION="";
        $this->loginForm->ValidationFunctionName="vloginForm";
        $this->loginForm->debug='OutputDebug';
        $this->loginForm->ResubmitConfirmMessage="Are you sure you want to submit this form again?";
        $this->loginForm->OptionsSeparator="<br>\n";

        $this->loginForm->AddInput(array(
            "TYPE"=>"text",
            "NAME"=>"username",
            "VALUE"=>"{$values['username']}",
            "ID"=>"username",
            "MAXLENGTH"=>200,
            "SIZE"=>35,
            "CLASS"=>"lusername",
            "LabelCLASS"=>$this->labelClass,
            "ValidateAsNotEmpty"=>1,
            "ValidationErrorMessage"=>"Masukkan nama.",
            "LABEL"=>"Username",
            "ACCESSKEY"=>"u"
        ));

        $this->loginForm->AddInput(array(
            "TYPE"=>"password",
            "NAME"=>"passwd",
            "VALUE"=>"",
            "ID"=>"passwd",
            "MAXLENGTH"=>50,
            "SIZE"=>35,
            "CLASS"=> "lusername",
            "LabelCLASS"=>$this->labelClass,
            "ValidateAsNotEmpty"=>1,
            "ValidationErrorMessage"=>"Masukkan password.",
            "LABEL"=>"Password",
            "ACCESSKEY"=>"p"
        ));

        $this->loginForm->AddInput(array(
            "TYPE"=> "submit",
            "VALUE"=> "Login",
            "CLASS"=> "button",
            "NAME"=>"doEntry"
        ));
    }

    function home() {
        $this->doRedirect("/index.php?action=manageproduct&id=$this->id");
    }

    function user() {
        $user = array();
        if(!empty($_SESSION['user']))
            return $_SESSION['user'];
        else
            return $user;
    }

    function checkUploadedFile($errNo, $notEmpty=TRUE) {
        switch ($errNo){
            case 0:
            break;
            case 1: //exceeds upload_max_fileszie ini setting
            case 2: //exceeds max_file_size specified in form
                $this->error_message = "Picture file is too large (maximum allowed is 1 MB).";
                return FALSE;
            break;

            case 3: //file was only partially uploaded
                $this->error_message = "Picture upload was incomplete.";
                return FALSE;
            break;

            case 4:
                if($notEmpty) {
                    $this->error_message = "No picture was uploaded.";
                    return FALSE;
                }
            break;

            case 5: //no php error defined for this code
            break;
            case 6: //temporary upload directory not found
                $this->error_message = "Temporary upload directory could not be found.";
                return FALSE;
            break;
            case 7: //could not write file to disk
                $this->error_message = "Uploaded file could not be written to disk.";
                return FALSE;
            break;

            case 8; //upload stopped based on extension
                $this->error_message = "Invalid uploaded file extension.";
                return FALSE;
            break;
        }
        return $this->error_message;
    }

    function manageproduct() {
        $this->smarty->assign("title", "Manage ".$module["product_type"]);
        $this->renderFile('header.tpl');

        $params["product_type_id"] = $this->id;
        $params['start_rec'] = $this->getRequestIntParam('startRec');
        if(!empty($_REQUEST['pageSize']))
            $params['page_size'] = intval($_REQUEST['pageSize']);
        if(empty($params['page_size']) || $params['page_size'] <= 0) $params['page_size'] = PAGE_COUNT;
        $this->smarty->assign('pageSize', $params['page_size']);
        $this->smarty->assign('startRec', $params['start_rec']);

        $products = $this->getProducts(&$params);
        getPagingString(ADMIN_URL."/index.php?action=manageproduct&amp;id={$params["product_type_id"]}&amp;pageSize=".$params['page_size'], $params['start_rec'], $params['page_size'], PAGING_NUMBER_COUNT, $params['record_count'], $this->smarty);
        $this->smarty->assign('products', $products);
        $this->renderFile('product.tpl');
        $this->renderFile('footer.tpl');
    }

    function addproduct() {
    	$id = $this->getRequestIntParam("id");
    	if(empty($id)) $this->doRedirect("/index.php?page=home");
    	$this->smarty->assign("id", $id);
    	$module = $this->getProductType($id);
    	$this->smarty->assign("module", $module);

        $this->formProduct_init($values='', 'INSERT');
        $this->productForm->LoadInputValues($this->productForm->WasSubmitted("doEntry"));
        $this->productForm->WasSubmitted("doEntry")? $doEntry=1 : $doEntry=0;
        if ($doEntry) {
            $this->formProduct_check('INSERT');
        }
        else {
            $this->showAddProduct();
        }
    }

    function showAddProduct() {
    	$id = $this->getRequestIntParam("id");
    	$module = $this->getProductType($id);
        $this->smarty->assign("siteTree", strtoupper($module["product_type"])." MANAGEMENT ");
        $this->smarty->assign("title", "Manage Product");

        $this->smarty->assign('mode', 'INSERT');

        $this->formProduct_parse();

        $this->smarty->display('header.tpl');
        $this->smarty->assign('entryTitle', 'Add New '.$module["product_type"]);
        $this->smarty->assign('par', array('action'=>'manageproduct', 'title'=>$module["product_type"],));
        $this->smarty->display('newentry.tpl');
        $this->smarty->display('footer.tpl');
    }

    function formProduct_check($mode) {
        $this->verify=array();
        if(($this->error_message=$this->productForm->Validate($this->verify))=="") {
        	$this->formProduct_process($mode);
        }
        else {
            $this->error_message=htmlentities($this->error_message);
            $this->showEditProduct();
        }
    }

    function formProduct_process($mode) {
        $values['product_id'] = trim(strip_tags($this->productForm->GetInputValue("product_id")));
        $values['product_type_id'] = $this->id;
        $values['product_name'] = trim(strip_tags($this->productForm->GetInputValue("product_name")));
        $values['description'] = trim(strip_tags($this->productForm->GetInputValue("description")));
        $values['size'] = $_POST["size"];
        /*$values['small_size'] = in_array(1, $values["size"])?1:0;
        $values['medium_size'] = in_array(2, $values["size"])?1:0;
        $values['large_size'] = in_array(3, $values["size"])?1:0;*/
        $values['large_size'] = 0;
        $values['medium_size'] = 0;
        $values['small_size'] = 0;
        $values['color1'] = trim(strip_tags($this->productForm->GetInputValue("color1")));
        $values['color2'] = trim(strip_tags($this->productForm->GetInputValue("color2")));
        $values['color3'] = trim(strip_tags($this->productForm->GetInputValue("color3")));
        $values['color4'] = trim(strip_tags($this->productForm->GetInputValue("color4")));
        $values['color5'] = trim(strip_tags($this->productForm->GetInputValue("color5")));
        $values['center_image'] = trim($this->productForm->GetInputValue("center_image"));
        $values['large_image'] = trim($this->productForm->GetInputValue("large_image"));

        $values['start_rec'] = trim(strip_tags($this->productForm->GetInputValue("start_rec")));
        $values['page_size'] = trim(strip_tags($this->productForm->GetInputValue("page_size")));

        $ext = "";
        if(!empty( $_FILES['color1']['name'])) {
            $fileName = $_FILES['color1']['name'];
            $temps = explode(".", $fileName);
            $ext = $temps[count($temps)-1];
        }
        $values['extcolor1'] = $ext;
        $ext = "";
        if(!empty( $_FILES['color2']['name'])) {
            $fileName = $_FILES['color2']['name'];
            $temps = explode(".", $fileName);
            $ext = $temps[count($temps)-1];
        }
        $values['extcolor2'] = $ext;
        $ext = "";
        if(!empty( $_FILES['color3']['name'])) {
            $fileName = $_FILES['color3']['name'];
            $temps = explode(".", $fileName);
            $ext = $temps[count($temps)-1];
        }
        $values['extcolor3'] = $ext;
        $ext = "";
        if(!empty( $_FILES['color4']['name'])) {
            $fileName = $_FILES['color4']['name'];
            $temps = explode(".", $fileName);
            $ext = $temps[count($temps)-1];
        }
        $values['extcolor4'] = $ext;
        $ext = "";
        if(!empty( $_FILES['color5']['name'])) {
            $fileName = $_FILES['color5']['name'];
            $temps = explode(".", $fileName);
            $ext = $temps[count($temps)-1];
        }
        $values['extcolor5'] = $ext;
        $ext = "";
        if(!empty( $_FILES['center_image']['name'])) {
            $fileName = $_FILES['center_image']['name'];
            $temps = explode(".", $fileName);
            $ext = $temps[count($temps)-1];
        }
        $values['extcenterimage'] = $ext;
        $ext = "";
        if(!empty( $_FILES['large_image']['name'])) {
            $fileName = $_FILES['large_image']['name'];
            $temps = explode(".", $fileName);
            $ext = $temps[count($temps)-1];
        }
        $values['extlargeimage'] = $ext;

        if ($mode=='INSERT') {
            if($this->error_message=$this->checkUploadedFile($_FILES['color1']['error'], FALSE) != "" || (!empty($values['extcolor1']) && strtolower($values['extcolor1']) != 'jpg' && strtolower($values['extcolor1']) != 'jpeg'  && strtolower($values['extcolor1']) != 'gif' && strtolower($values['extcolor1']) != 'png')) {
                if(!empty($values['extcolor1']) && strtolower($values['extcolor1']) != 'jpg' && strtolower($values['extcolor1']) != 'jpeg'  && strtolower($values['extcolor1']) != 'gif' && strtolower($values['extcolor1']) != 'png')
                    $this->error_message=htmlentities("Color 1 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showAddProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['color2']['error'], FALSE) != "" || (!empty($values['extcolor2']) && strtolower($values['extcolor2']) != 'jpg' && strtolower($values['extcolor2']) != 'jpeg'  && strtolower($values['extcolor2']) != 'gif' && strtolower($values['extcolor2']) != 'png')) {
                if(!empty($values['extcolor2']) && strtolower($values['extcolor2']) != 'jpg' && strtolower($values['extcolor2']) != 'jpeg'  && strtolower($values['extcolor2']) != 'gif' && strtolower($values['extcolor2']) != 'png')
                    $this->error_message=htmlentities("Color 2 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showAddProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['color3']['error'], FALSE) != "" || (!empty($values['extcolor3']) && strtolower($values['extcolor3']) != 'jpg' && strtolower($values['extcolor3']) != 'jpeg'  && strtolower($values['extcolor3']) != 'gif' && strtolower($values['extcolor3']) != 'png')) {
                if(!empty($values['extcolor3']) && strtolower($values['extcolor3']) != 'jpg' && strtolower($values['extcolor3']) != 'jpeg'  && strtolower($values['extcolor3']) != 'gif' && strtolower($values['extcolor3']) != 'png')
                    $this->error_message=htmlentities("Color 3 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showAddProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['color4']['error'], FALSE) != "" || (!empty($values['extcolor4']) && strtolower($values['extcolor4']) != 'jpg' && strtolower($values['extcolor4']) != 'jpeg'  && strtolower($values['extcolor4']) != 'gif' && strtolower($values['extcolor4']) != 'png')) {
                if(!empty($values['extcolor4']) && strtolower($values['extcolor4']) != 'jpg' && strtolower($values['extcolor4']) != 'jpeg'  && strtolower($values['extcolor4']) != 'gif' && strtolower($values['extcolor4']) != 'png')
                    $this->error_message=htmlentities("Color 4 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showAddProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['color5']['error'], FALSE) != "" || (!empty($values['extcolor5']) && strtolower($values['extcolor5']) != 'jpg' && strtolower($values['extcolor5']) != 'jpeg'  && strtolower($values['extcolor5']) != 'gif' && strtolower($values['extcolor5']) != 'png')) {
                if(!empty($values['extcolor5']) && strtolower($values['extcolor5']) != 'jpg' && strtolower($values['extcolor5']) != 'jpeg'  && strtolower($values['extcolor5']) != 'gif' && strtolower($values['extcolor5']) != 'png')
                    $this->error_message=htmlentities("Color 5 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showAddProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['center_image']['error'], FALSE) != "" || (!empty($values['extcenterimage']) && strtolower($values['extcenterimage']) != 'jpg' && strtolower($values['extcenterimage']) != 'jpeg'  && strtolower($values['extcenterimage']) != 'gif' && strtolower($values['extcenterimage']) != 'png')) {
                if(!empty($values['extcenterimage']) && strtolower($values['extcenterimage']) != 'jpg' && strtolower($values['extcenterimage']) != 'jpeg'  && strtolower($values['extcenterimage']) != 'gif' && strtolower($values['extcenterimage']) != 'png')
                    $this->error_message=htmlentities("Center Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showAddProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['large_image']['error'], FALSE) != "" || (!empty($values['extlargeimage']) && strtolower($values['extlargeimage']) != 'jpg' && strtolower($values['extlargeimage']) != 'jpeg'  && strtolower($values['extlargeimage']) != 'gif' && strtolower($values['extlargeimage']) != 'png')) {
                if(!empty($values['extlargeimage']) && strtolower($values['extlargeimage']) != 'jpg' && strtolower($values['extlargeimage']) != 'jpeg'  && strtolower($values['extlargeimage']) != 'gif' && strtolower($values['extlargeimage']) != 'png')
                    $this->error_message=htmlentities("Large Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showAddProduct();
            }
            else if ($this->productId = $this->insertProduct($values)) {
                $result = 'New Product Added Successfully';
                if($_FILES['color1']['error'] != 4) {
	                move_uploaded_file($_FILES['color1']['tmp_name'], PRODUCT_PATH."/".$this->productId."c1.".$values["extcolor1"]);
	                db_query("UPDATE product SET color1='".$this->productId."c1.".$values["extcolor1"]."' WHERE product_id=".$this->productId);
                }
                if($_FILES['color2']['error'] != 4) {
	                move_uploaded_file($_FILES['color2']['tmp_name'], PRODUCT_PATH."/".$this->productId."c2.".$values["extcolor2"]);
	                db_query("UPDATE product SET color2='".$this->productId."c2.".$values["extcolor2"]."' WHERE product_id=".$this->productId);
                }
                if($_FILES['color3']['error'] != 4) {
	                move_uploaded_file($_FILES['color3']['tmp_name'], PRODUCT_PATH."/".$this->productId."c3.".$values["extcolor3"]);
	                db_query("UPDATE product SET color3='".$this->productId."c3.".$values["extcolor3"]."' WHERE product_id=".$this->productId);
                }
                if($_FILES['color4']['error'] != 4) {
	                move_uploaded_file($_FILES['color4']['tmp_name'], PRODUCT_PATH."/".$this->productId."c4.".$values["extcolor4"]);
	                db_query("UPDATE product SET color4='".$this->productId."c4.".$values["extcolor4"]."' WHERE product_id=".$this->productId);
                }
                if($_FILES['color5']['error'] != 4) {
	                move_uploaded_file($_FILES['color5']['tmp_name'], PRODUCT_PATH."/".$this->productId."c5.".$values["extcolor5"]);
	                db_query("UPDATE product SET color5='".$this->productId."c5.".$values["extcolor5"]."' WHERE product_id=".$this->productId);
                }
                if($_FILES['center_image']['error'] != 4) {
	                move_uploaded_file($_FILES['center_image']['tmp_name'], PRODUCT_PATH."/".$this->productId."ci.".$values["extcenterimage"]);
	                db_query("UPDATE product SET center_image='".$this->productId."ci.".$values["extcenterimage"]."' WHERE product_id=".$this->productId);
                }
                if($_FILES['large_image']['error'] != 4) {
	                move_uploaded_file($_FILES['large_image']['tmp_name'], PRODUCT_PATH."/".$this->productId."li.".$values["extlargeimage"]);
	                db_query("UPDATE product SET large_image='".$this->productId."li.".$values["extlargeimage"]."' WHERE product_id=".$this->productId);
                }
                $this->doRedirect("/index.php?action=addproduct&id=$this->id&result=$result");
            }
            else {
                $this->error_message='Insert Failed.';
                $this->showAddProduct();
            }
        }
        else if ($mode=='UPDATE') {
            $res = db_query("SELECT color1 FROM product WHERE product_id=".$values['product_id']);
            $oldColor1 = db_fetch_one($res);
            $res = db_query("SELECT color2 FROM product WHERE product_id=".$values['product_id']);
            $oldColor2 = db_fetch_one($res);
            $res = db_query("SELECT color3 FROM product WHERE product_id=".$values['product_id']);
            $oldColor3 = db_fetch_one($res);
            $res = db_query("SELECT color4 FROM product WHERE product_id=".$values['product_id']);
            $oldColor4 = db_fetch_one($res);
            $res = db_query("SELECT color5 FROM product WHERE product_id=".$values['product_id']);
            $oldColor5 = db_fetch_one($res);
            $res = db_query("SELECT center_image FROM product WHERE product_id=".$values['product_id']);
            $oldcenterimage = db_fetch_one($res);
            $res = db_query("SELECT large_image FROM product WHERE product_id=".$values['product_id']);
            $oldlargeimage = db_fetch_one($res);
            if($this->error_message=$this->checkUploadedFile($_FILES['color1']['error'], FALSE) != "" || (!empty($values['extcolor1']) && strtolower($values['extcolor1']) != 'jpg' && strtolower($values['extcolor1']) != 'jpeg'  && strtolower($values['extcolor1']) != 'gif' && strtolower($values['extcolor1']) != 'png')) {
                if(!empty($values['extcolor1']) && strtolower($values['extcolor1']) != 'jpg' && strtolower($values['extcolor1']) != 'jpeg'  && strtolower($values['extcolor1']) != 'gif' && strtolower($values['extcolor1']) != 'png')
                    $this->error_message=htmlentities("Color 1 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showEditProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['color2']['error'], FALSE) != "" || (!empty($values['extcolor2']) && strtolower($values['extcolor2']) != 'jpg' && strtolower($values['extcolor2']) != 'jpeg'  && strtolower($values['extcolor2']) != 'gif' && strtolower($values['extcolor2']) != 'png')) {
                if(!empty($values['extcolor2']) && strtolower($values['extcolor2']) != 'jpg' && strtolower($values['extcolor2']) != 'jpeg'  && strtolower($values['extcolor2']) != 'gif' && strtolower($values['extcolor2']) != 'png')
                    $this->error_message=htmlentities("Color 2 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showEditProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['color3']['error'], FALSE) != "" || (!empty($values['extcolor3']) && strtolower($values['extcolor3']) != 'jpg' && strtolower($values['extcolor3']) != 'jpeg'  && strtolower($values['extcolor3']) != 'gif' && strtolower($values['extcolor3']) != 'png')) {
                if(!empty($values['extcolor3']) && strtolower($values['extcolor3']) != 'jpg' && strtolower($values['extcolor3']) != 'jpeg'  && strtolower($values['extcolor3']) != 'gif' && strtolower($values['extcolor3']) != 'png')
                    $this->error_message=htmlentities("Color 3 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showEditProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['color4']['error'], FALSE) != "" || (!empty($values['extcolor4']) && strtolower($values['extcolor4']) != 'jpg' && strtolower($values['extcolor4']) != 'jpeg'  && strtolower($values['extcolor4']) != 'gif' && strtolower($values['extcolor4']) != 'png')) {
                if(!empty($values['extcolor4']) && strtolower($values['extcolor4']) != 'jpg' && strtolower($values['extcolor4']) != 'jpeg'  && strtolower($values['extcolor4']) != 'gif' && strtolower($values['extcolor4']) != 'png')
                    $this->error_message=htmlentities("Color 4 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showEditProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['color5']['error'], FALSE) != "" || (!empty($values['extcolor5']) && strtolower($values['extcolor5']) != 'jpg' && strtolower($values['extcolor5']) != 'jpeg'  && strtolower($values['extcolor5']) != 'gif' && strtolower($values['extcolor5']) != 'png')) {
                if(!empty($values['extcolor5']) && strtolower($values['extcolor5']) != 'jpg' && strtolower($values['extcolor5']) != 'jpeg'  && strtolower($values['extcolor5']) != 'gif' && strtolower($values['extcolor5']) != 'png')
                    $this->error_message=htmlentities("Color 5 Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showEditProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['center_image']['error'], FALSE) != "" || (!empty($values['extcenterimage']) && strtolower($values['extcenterimage']) != 'jpg' && strtolower($values['extcenterimage']) != 'jpeg'  && strtolower($values['extcenterimage']) != 'gif' && strtolower($values['extcenterimage']) != 'png')) {
                if(!empty($values['extcenterimage']) && strtolower($values['extcenterimage']) != 'jpg' && strtolower($values['extcenterimage']) != 'jpeg'  && strtolower($values['extcenterimage']) != 'gif' && strtolower($values['extcenterimage']) != 'png')
                    $this->error_message=htmlentities("Center Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showEditProduct();
            }
            else if($this->error_message=$this->checkUploadedFile($_FILES['large_image']['error'], FALSE) != "" || (!empty($values['extlargeimage']) && strtolower($values['extlargeimage']) != 'jpg' && strtolower($values['extlargeimage']) != 'jpeg'  && strtolower($values['extlargeimage']) != 'gif' && strtolower($values['extlargeimage']) != 'png')) {
                if(!empty($values['extlargeimage']) && strtolower($values['extlargeimage']) != 'jpg' && strtolower($values['extlargeimage']) != 'jpeg'  && strtolower($values['extlargeimage']) != 'gif' && strtolower($values['extlargeimage']) != 'png')
                    $this->error_message=htmlentities("Large Image File must be a jpeg, jpg, gif or png files");
                else
                    $this->error_message=htmlentities($this->error_message);
                $this->showEditProduct();
            }
            else if ($this->updateProduct($values)) {
            	$this->productId = $values["product_id"];
                if($_FILES['color1']['error'] != 4) {
                	if(file_exists(PRODUCT_PATH."/".$oldColor1) && !empty($oldColor1))
                        unlink(PRODUCT_PATH."/".$oldColor1);
	                move_uploaded_file($_FILES['color1']['tmp_name'], PRODUCT_PATH."/".$this->productId."c1.".$values["extcolor1"]);
	                db_query("UPDATE product SET color1='".$values["product_id"]."c1.".$values["extcolor1"]."' WHERE product_id=".$values["product_id"]);
                }
                if($_FILES['color2']['error'] != 4) {
                	if(file_exists(PRODUCT_PATH."/".$oldColor2) && !empty($oldColor2))
                        unlink(PRODUCT_PATH."/".$oldColor2);
	                move_uploaded_file($_FILES['color2']['tmp_name'], PRODUCT_PATH."/".$this->productId."c2.".$values["extcolor2"]);
	                db_query("UPDATE product SET color2='".$values["product_id"]."c2.".$values["extcolor2"]."' WHERE product_id=".$values["product_id"]);
                }
                if($_FILES['color3']['error'] != 4) {
                	if(file_exists(PRODUCT_PATH."/".$oldColor3) && !empty($oldColor3))
                        unlink(PRODUCT_PATH."/".$oldColor3);
	                move_uploaded_file($_FILES['color3']['tmp_name'], PRODUCT_PATH."/".$this->productId."c3.".$values["extcolor3"]);
	                db_query("UPDATE product SET color3='".$values["product_id"]."c3.".$values["extcolor3"]."' WHERE product_id=".$values["product_id"]);
                }
                if($_FILES['color4']['error'] != 4) {
                	if(file_exists(PRODUCT_PATH."/".$oldColor4) && !empty($oldColor4))
                        unlink(PRODUCT_PATH."/".$oldColor4);
	                move_uploaded_file($_FILES['color4']['tmp_name'], PRODUCT_PATH."/".$this->productId."c4.".$values["extcolor4"]);
	                db_query("UPDATE product SET color4='".$values["product_id"]."c4.".$values["extcolor4"]."' WHERE product_id=".$values["product_id"]);
                }
                if($_FILES['color5']['error'] != 4) {
                	if(file_exists(PRODUCT_PATH."/".$oldColor5) && !empty($oldColor5))
                        unlink(PRODUCT_PATH."/".$oldColor5);
	                move_uploaded_file($_FILES['color5']['tmp_name'], PRODUCT_PATH."/".$this->productId."c5.".$values["extcolor5"]);
	                db_query("UPDATE product SET color5='".$values["product_id"]."c5.".$values["extcolor5"]."' WHERE product_id=".$values["product_id"]);
                }
                if($_FILES['center_image']['error'] != 4) {
                	if(file_exists(PRODUCT_PATH."/".$oldcenterimage) && !empty($oldcenterimage))
                        unlink(PRODUCT_PATH."/".$oldcenterimage);
	                move_uploaded_file($_FILES['center_image']['tmp_name'], PRODUCT_PATH."/".$this->productId."ci.".$values["extcenterimage"]);
	                db_query("UPDATE product SET center_image='".$values["product_id"]."ci.".$values["extcenterimage"]."' WHERE product_id=".$values["product_id"]);
                }
                if($_FILES['large_image']['error'] != 4) {
                	if(file_exists(PRODUCT_PATH."/".$oldlargeimage) && !empty($oldlargeimage))
                        unlink(PRODUCT_PATH."/".$oldlargeimage);
	                move_uploaded_file($_FILES['large_image']['tmp_name'], PRODUCT_PATH."/".$this->productId."li.".$values["extlargeimage"]);
	                db_query("UPDATE product SET large_image='".$values["product_id"]."li.".$values["extlargeimage"]."' WHERE product_id=".$values["product_id"]);
                }
                $result = urlencode("Product Updated Successfully");
                $this->doRedirect("/index.php?action=manageproduct&id=$this->id&startRec={$values['start_rec']}&pageSize={$values['page_size']}&result=$result");
            }
            else {
                $this->error_message="Update Failed";
                $this->showEditProduct();
            }
        }
    }

    function showEditProduct() {
        $this->smarty->assign("title", "Manage ".$module["product_type"]);

        $this->smarty->assign('mode', 'UPDATE');
        $this->smarty->assign('product_id', $this->productId);
        $this->formProduct_parse();

        $this->smarty->display('header.tpl');
        $this->smarty->assign('entryTitle', 'Edit '.$module["product_type"]);
        $this->smarty->assign('par', array('action'=>'manageproduct', 'title'=>$module["product_type"],));
        $this->smarty->display('newentry.tpl');
        $this->smarty->display('footer.tpl');
    }

    function formProduct_parse() {
        $this->smarty->assign_by_ref("form",$this->productForm);
        $this->smarty->assign("error_message",$this->error_message);
        $this->smarty->assign_by_ref("verify",$this->verify);
        $this->smarty->assign("doit",$this->doit);
        $this->smarty->assign("mark","[Verify]");
        $this->smarty->register_prefilter("smarty_prefilter_form");
        $this->smarty->fetch("form_product.tpl");
        $this->smarty->unregister_prefilter("smarty_prefilter_form");

        Reset($this->verify);
        $this->onload="PageLoad()";
        $this->productForm->AddFunction(array(
            "Function"=>"PageLoad",
            "Type"=>"focus",
            "Element"=>"product_name"
        ));

        $productFrm = FormCaptureOutput($this->productForm,array("EndOfLine"=>"\n"));
        $this->smarty->assign("entryForm", $productFrm);
        $this->smarty->assign("onload",$this->onload);
    }

    function insertProduct($values) {
        foreach ($values as $key=>$value)  {
            $values[$key]=trimText($value);
        }
        $rightnow = getCurrentDate();
        $sql = "INSERT INTO product(product_type_id, size, product_name, description, small_size, medium_size, large_size, crdate)
                VALUES
                ({$values["product_type_id"]}, '{$values["size"]}', '{$values["product_name"]}', '{$values["description"]}', {$values["small_size"]},
                {$values["medium_size"]}, {$values["large_size"]}, '".$rightnow."')";
        $result = db_query($sql);

        if ($result) {
            $productId = db_last_insert_id();
            return($productId);
        }
        else  {
            return(FALSE);
        }
    }

    function updateProduct($values) {
        foreach ($values as $key=>$value) {
            $values[$key]=trimText($value);
        }

        $rightnow = getCurrentDate();
        $sql = "UPDATE product SET product_type_id={$values["product_type_id"]}, product_name='{$values["product_name"]}', size='{$values["size"]}',
        		description='{$values["description"]}', small_size={$values["small_size"]},
                medium_size={$values["medium_size"]}, large_size={$values["large_size"]}, crdate='".$rightnow."'
            WHERE product_id=".$values["product_id"];
        $result = db_query($sql);

        if ($result) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    function formProduct_init($values="", $mode) {
        if (!is_array($values))  {
            $values = array(
                'product_id'=>'',
                'product_type_id'=>'',
                'product_name'=>'',
                'description'=>'',
                'small_size'=>'',
                'medium_size'=>'',
                'large_size'=>'',
                'size'=>'',
                'color1'=>'',
                'color2'=>'',
                'color3'=>'',
                'color4'=>'',
                'color5'=>'',
                'center_image'=>'',
                'large_image'=>'',
                'start_rec'=>0,
                'page_size'=> 0,
            );
        }

        $id = $this->getRequestIntParam("id");
        $module = $this->getProductType($id);

        require_once($this->basePath."/lib/Smarty-2.6.13/libs/plugins/prefilter.form.php");
        require_once($this->basePath."/lib/application/forms.php");
        $this->productForm = new form_class;

        $this->productForm->NAME="productForm";
        $this->productForm->ID="productForm";
        $this->productForm->METHOD="POST";
        $this->productForm->ENCTYPE="multipart/form-data";
        $this->productForm->ACTION="";
        $this->productForm->ValidationFunctionName="ventryForm";
        $this->productForm->debug='OutputDebug';
        $this->productForm->ResubmitConfirmMessage="Are you sure you want to submit this form again?";
        $this->productForm->OptionsSeparator="<br>\n";

        $this->productForm->AddInput(array(
            "TYPE"=>"text",
            "NAME"=>"product_name",
            "VALUE"=>"{$values['product_name']}",
            "ID"=>"product_name",
            "MAXLENGTH"=>1000,
            "SIZE"=>35,
            "CLASS"=>$this->fieldClass,
            "LabelCLASS"=>$this->labelClass,
            "ValidateAsNotEmpty"=>1,
            "ValidationErrorMessage"=>"Please include a product name.",
            "LABEL"=>"Product Name"
        ));

        $this->productForm->AddInput(array(
            "TYPE"=>"textarea",
            "NAME"=>"description",
            "VALUE"=>"{$values['description']}",
            "ID"=>"description",
            "COLS"=>50,
            "ROWS"=>8,
            "CLASS"=>$this->fieldClass,
            "LabelCLASS"=>"styletextarea",
            "LABEL"=>"Description"
        ));

        $this->productForm->AddInput(array(
            "TYPE"=>"text",
            "NAME"=>"size",
            "VALUE"=>"{$values['size']}",
            "ID"=>"size",
            "MAXLENGTH"=>1000,
            "SIZE"=>35,
            "CLASS"=>$this->fieldClass,
            "LabelCLASS"=>$this->labelClass,
            "ValidateAsNotEmpty"=>1,
            "ValidationErrorMessage"=>"Please include a product size.",
            "LABEL"=>"Size"
        ));

        /*$this->productForm->AddInput(array(
	        "TYPE"=>"checkbox",
	        "NAME"=>"size",
	        "ID"=>"small_size",
	        "VALUE"=>"1",
	        "CHECKED"=>$values['small_size'],
	        "MULTIPLE"=>1,
	        "ValidateAsSet"=>1,
	        "ValidateAsSetErrorMessage"=>
	            "It were not specified any types of product size.",
	        "LABEL"=>"<u>S</u>mall",
	        "ACCESSKEY"=>"s",
	        "ReadOnlyMark"=>"[X]"
	    ));

	    $this->productForm->AddInput(array(
	        "TYPE"=>"checkbox",
	        "NAME"=>"size",
	        "ID"=>"medium_size",
	        "VALUE"=>"2",
	        "CHECKED"=>$values['medium_size'],
	        "MULTIPLE"=>1,
	        "ValidateAsSet"=>1,
	        "ValidateAsSetErrorMessage"=>
	            "It were not specified any types of product size.",
	        "LABEL"=>"<u>M</u>edium",
	        "ACCESSKEY"=>"m",
	        "ReadOnlyMark"=>"[X]"
	    ));

	    $this->productForm->AddInput(array(
	        "TYPE"=>"checkbox",
	        "NAME"=>"size",
	        "ID"=>"large_size",
	        "VALUE"=>"3",
	        "CHECKED"=>$values['large_size'],
	        "MULTIPLE"=>1,
	        "ValidateAsSet"=>1,
	        "ValidateAsSetErrorMessage"=>
	            "It were not specified any types of product size.",
	        "LABEL"=>"<u>L</u>arge",
	        "ACCESSKEY"=>"l",
	        "ReadOnlyMark"=>"[X]"
	    ));*/

	    $this->productForm->AddInput(array(
            "TYPE"=>"hidden",
            "NAME"=>"MAX_FILE_SIZE",
            "VALUE"=>5*1024*1024
        ));
        if ($mode == "INSERT") {
        	$this->productForm->AddInput(array(
	            "TYPE"=>"file",
	            "NAME"=>"center_image",
	            "ID"=>"center_image",
	            "ACCEPT"=>"image/jpeg,image/pjpeg",
	            "CLASS"=>$this->fieldClass,
	            "LabelCLASS"=>$this->labelClass,
	            "SIZE"=>50,
	            "ValidateAsNotEmpty"=> 1,
	            "ValidationErrorMessage"=>"Please specify a valid center image file to upload.",
	            "LABEL"=>"Image 1 <br />(best view with width 478 height 380)"
	        ));

	        $this->productForm->AddInput(array(
	            "TYPE"=>"file",
	            "NAME"=>"large_image",
	            "ID"=>"large_image",
	            "ACCEPT"=>"image/jpeg,image/pjpeg",
	            "CLASS"=>$this->fieldClass,
	            "LabelCLASS"=>$this->labelClass,
	            "SIZE"=>50,
	            "ValidateAsNotEmpty"=> 1,
	            "ValidationErrorMessage"=>"Please specify a valid large image file to upload.",
	            "LABEL"=>"Image 2 <br />(best view with width 478 height 380)"
	        ));
        }
        else {
        	$this->productForm->AddInput(array(
	            "TYPE"=>"file",
	            "NAME"=>"center_image",
	            "ID"=>"center_image",
	            "ACCEPT"=>"image/jpeg,image/pjpeg",
	            "CLASS"=>$this->fieldClass,
	            "LabelCLASS"=>$this->labelClass,
	            "SIZE"=>50,
	            "LABEL"=>"Image 1 <br />(best view with width 478 height 380)"
	        ));

	        $this->productForm->AddInput(array(
	            "TYPE"=>"file",
	            "NAME"=>"large_image",
	            "ID"=>"large_image",
	            "ACCEPT"=>"image/jpeg,image/pjpeg",
	            "CLASS"=>$this->fieldClass,
	            "LabelCLASS"=>$this->labelClass,
	            "SIZE"=>50,
	            "LABEL"=>"Image 2 <br />(best view with width 478 height 380)"
	        ));
        }


        $this->productForm->AddInput(array(
            "TYPE"=>"file",
            "NAME"=>"color1",
            "ID"=>"color1",
            "ACCEPT"=>"image/jpeg,image/pjpeg",
            "CLASS"=>$this->fieldClass,
            "LabelCLASS"=>$this->labelClass,
            "SIZE"=>50,
            "LABEL"=>"Available Color 1"
        ));

        $this->productForm->AddInput(array(
            "TYPE"=>"file",
            "NAME"=>"color2",
            "ID"=>"color2",
            "ACCEPT"=>"image/jpeg,image/pjpeg",
            "CLASS"=>$this->fieldClass,
            "LabelCLASS"=>$this->labelClass,
            "SIZE"=>50,
            "LABEL"=>"Available Color 2"
        ));

        $this->productForm->AddInput(array(
            "TYPE"=>"file",
            "NAME"=>"color3",
            "ID"=>"color3",
            "ACCEPT"=>"image/jpeg,image/pjpeg",
            "CLASS"=>$this->fieldClass,
            "LabelCLASS"=>$this->labelClass,
            "SIZE"=>50,
            "LABEL"=>"Available Color 3"
        ));

        $this->productForm->AddInput(array(
            "TYPE"=>"file",
            "NAME"=>"color4",
            "ID"=>"color4",
            "ACCEPT"=>"image/jpeg,image/pjpeg",
            "CLASS"=>$this->fieldClass,
            "LabelCLASS"=>$this->labelClass,
            "SIZE"=>50,
            "LABEL"=>"Available Color 4"
        ));

        $this->productForm->AddInput(array(
            "TYPE"=>"file",
            "NAME"=>"color5",
            "ID"=>"color5",
            "ACCEPT"=>"image/jpeg,image/pjpeg",
            "CLASS"=>$this->fieldClass,
            "LabelCLASS"=>$this->labelClass,
            "SIZE"=>50,
            "LABEL"=>"Available Color 5"
        ));

        if ($mode=="INSERT") {
            $this->productForm->AddInput(array(
            "TYPE"=>"hidden",
            "NAME"=>"action",
            "VALUE"=>"addproduct"
            ));

            $subvalue = "Add New";
        }
        elseif ($mode=='UPDATE')   {
            $this->productForm->AddInput(array(
            "TYPE"=>"hidden",
            "NAME"=>"action",
            "VALUE"=>"editproduct"
            ));
            $subvalue = "Save Changes";
        }

        $this->productForm->AddInput(array(
            "TYPE"=>"hidden",
            "NAME"=>"product_type_id",
            "VALUE"=>$this->id
            ));
        $this->productForm->AddInput(array(
            "TYPE"=>"hidden",
            "NAME"=>"product_id",
            "VALUE"=>"{$values['product_id']}"
            ));
        $this->productForm->AddInput(array(
            "TYPE"=>"hidden",
            "NAME"=>"start_rec",
            "VALUE"=>"{$values['start_rec']}"
            ));
        $this->productForm->AddInput(array(
            "TYPE"=>"hidden",
            "NAME"=>"page_size",
            "VALUE"=>"{$values['page_size']}"
            ));

        $this->productForm->AddInput(array(
            "TYPE"=>"submit",
            "VALUE"=>$subvalue,
            "CLASS"=> "button",
            "NAME"=>"doEntry"
        ));
    }

    function editproduct() {
    	$values = $this->getProduct($_REQUEST['product_id']);
        $values['start_rec'] = intval($_REQUEST['start_rec']);
        $values['page_size'] = intval($_REQUEST['page_size']);
        $this->smarty->assign("startRec", $values["start_rec"]);
        $this->smarty->assign("pageSize", $values["page_size"]);
        $this->smarty->assign("product", $values);

        $this->formProduct_init($values, 'UPDATE');
        $this->productForm->LoadInputValues($this->productForm->WasSubmitted("doEntry"));
        $this->productForm->WasSubmitted("doEntry")? $doEntry=1 : $doEntry=0;

        if ($doEntry) {
            $this->formProduct_check('UPDATE');
        }
        else {
            $this->showEditProduct();
        }
    }

    function deleteproduct() {
        $this->productId = intval($_GET['product_id']);
        $startRec = intval($_GET['start_rec']);
        $pageSize = intval($_GET['page_size']);
        $res = db_query("SELECT * FROM product WHERE product_id=".$this->productId);
        $product = db_fetch_row($res);
        if(file_exists(PRODUCT_PATH."/".$product["color1"]) && !empty($product["color1"]))
            unlink(PRODUCT_PATH."/".$product["color1"]);
        if(file_exists(PRODUCT_PATH."/".$product["color2"]) && !empty($product["color2"]))
            unlink(PRODUCT_PATH."/".$product["color2"]);
        if(file_exists(PRODUCT_PATH."/".$product["color3"]) && !empty($product["color3"]))
            unlink(PRODUCT_PATH."/".$product["color3"]);
        if(file_exists(PRODUCT_PATH."/".$product["color4"]) && !empty($product["color4"]))
            unlink(PRODUCT_PATH."/".$product["color4"]);
        if(file_exists(PRODUCT_PATH."/".$product["color5"]) && !empty($product["color5"]))
            unlink(PRODUCT_PATH."/".$product["color5"]);
        if(file_exists(PRODUCT_PATH."/".$product["center_image"]) && !empty($product["center_image"]))
            unlink(PRODUCT_PATH."/".$product["center_image"]);
        if(file_exists(PRODUCT_PATH."/".$product["large_image"]) && !empty($product["large_image"]))
            unlink(PRODUCT_PATH."/".$product["large_image"]);
        if ($this->sqlDeleteProduct()) {
            $result=urlencode("Product Deleted");
            $this->doRedirect("/index.php?action=manageproduct&id=$this->id&startRec=$startRec&pageSize=$pageSize&result=$result");
        }
        else   {
            $result=urlencode("Product Could Not Be Deleted");
            $this->doRedirect("/index.php?action=manageproduct&id=$this->id&result=$result&startRec=$startRec&pageSize=$pageSize");
        }
    }

    function sqlDeleteProduct() {
    	$sql = "DELETE FROM product WHERE product_id=$this->productId";
    	$result = db_query($sql);
    	if($result)
        	return TRUE;
        else
        	return FALSE;
    }
}
?>
