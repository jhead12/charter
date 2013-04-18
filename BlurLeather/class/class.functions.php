<?php
require_once("constants.php");
require_once("class.mydb.php");
require_once("class.ImageResize.php");
require_once("class.currency.php");
class Functions extends DBClass{
	var $curRate;
	function __construct(){
		DBClass::__construct();
		if(!isset($_SESSION['CURRENCY'])){
			$_SESSION['CURRENCY'] = 'USD';
		}
		$CUR = new JOJO_Currency_webservicex();
		if("USD"==$_SESSION['CURRENCY']){
			$this->curRate = 1;
		}else{
			$this->curRate = $CUR->getRate("USD",$_SESSION['CURRENCY'],false);
		}
	}
	function AllCurrencyToUSD($amt){
		$CUR = new JOJO_Currency_webservicex();
		return	($amt * $CUR->getRate($_SESSION['CURRENCY'],"USD",false));
	}
	function GetRateAmt($amt){
		return sprintf("%.2f",($amt * $this->curRate));
	}
	function GetDisplayRate($amt){
		return $_SESSION['CURRENCY'] ." ".sprintf("%.2f",$this->GetRateAmt($amt));
	}
	function CSVReplaceSql($str){
		$str = str_replace('"','&quot;',$str);
		$str = str_replace("\n","",$str);
		return $str;
	}
	function ReplaceSql($str){
		$str = trim(stripslashes($str));
		$str = str_replace("\\","",$str);
		$str = str_replace("'","\'",$str);
		return $str;
	}
	function ImgReplace($str){
		$str = trim(stripslashes($str));
		$str = str_replace("\\","",$str);
		$str = str_replace("'","\'",$str);
		$str = str_replace("#","-",$str);
		$str = str_replace(" ","-",$str);
		$str = str_replace("+","-",$str);
		return $str;
	}
	function MakeHTML($str){
		$str = str_replace("\n","<br>",$str);
		return $str;
	}
	function ShowEditorImage($str){
		$str = str_replace("..//","",$str);
		$str = str_replace("../","",$str);
		return $str;	
	}
	function HTMLSql($str){
		$str = trim(stripslashes($str));
		$str = str_replace("\\","",$str);
		$str = str_replace("'","\'",$str);
		$str = str_replace("<","&lt;",$str);
		$str = str_replace(">","&gt;",$str);
		return $str;
	}
	function Decrypt($string) {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr(ENCRYPT_KEY, ($i % strlen(ENCRYPT_KEY))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}
		return $result;
    }
    function Encrypt($string) {
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr(ENCRYPT_KEY, ($i % strlen(ENCRYPT_KEY))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
		return base64_encode($result);
    }
	
	function ValidateLogin(){
		return $_SESSION['USERLOGIN'];
	}
	function CurrentUrl(){
		$_SESSION['CURRENTURL']="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	function ReturnReferer(){
		$url = $_SESSION['CURRENTURL'];
		unset($_SESSION['CURRENTURL']);
		if($url==''){$url="index.php";}
		header("Location:".$url);
	}
	function SetLoginUrl(){
		$_SESSION['LOGINURL']="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	function ReqLogin(){
		if(!$_SESSION['USERLOGIN']){
			$this->CurrentUrl();
			header("Location:index.php");
		}
	}
	function AlreadyLogin(){
		if($_SESSION['USERLOGIN']){
			header("Location:index.php");
		}
	}
	function SendEmail($emailto,$emailfrom,$namefrom,$body,$subject,$CC="",$BCC = ""){
		if(SEND_MAIL){
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
			$headers .= 'From: '.$namefrom.'<'.$emailfrom.'>' . "\r\n";
			if($CC!=""){
				$headers .= 'Cc: '.$CC.'' . "\r\n";
			}
			if($BCC!=""){
				$headers .= 'Bcc: '.$BCC.'' . "\r\n";
			}
			@mail($emailto,$subject,$body,$headers);			
		}else{
			echo $body;
		}
	}
	function ImageExists($dir,$img){
		if($dir!='' && $img!=''){
			if(file_exists(UPLOAD_PATH_ORG.$dir."/".$img)===TRUE){
				return true;
			}
		}
		return false;
	}
	function RandomCode($characters){
		$possible = 'abcdefghjklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXY';
		$code = '';
		$i = 0;
		while ($i < $characters){
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}
	function SignUp($post){
		if($post['surname']=="" && $post['password']==""){
			$post['password']=$this->RandomCode(8);
			$post['surname']=$post['last_name'];
		}
 		$query="insert into members set first_name='".$this->ReplaceSql($post['first_name'])."',surname='".$this->ReplaceSql($post['surname'])."', email='".$this->ReplaceSql($post['email'])."',womenswear='".$this->ReplaceSql($post['womenswear'])."',menswear='".$this->ReplaceSql($post['menswear'])."', password='".$this->Encrypt($post['password'])."'";
		$this->InsertQuery($query);
		$this->Login($this->ReplaceSql($post['email']),$post['password']);
		$body="<div style='font-family:Arial; font-size:12px;'>
		<p><h3>Registration email from <a href='".WEBSITE_URL."'>".COMPANY_NAME."</a></h3></p>
		<table cellpadding='5' cellspacing='0' border='0' width='500px' style='border:1px solid #1C1C1E; font-family:Arial; font-size:12px; background:#ffffff'>
		<tr><td bgcolor='#1C1C1E' width='100%'><a href='".WEBSITE_URL."'><img src='".WEBSITE_URL."/images/blur-logo.png' width='72' height='29'/></a></td></tr>		<tr><td>
			<table border='0' cellpadding='10' cellspacing='0' width='100%' style='font-size:12px; text-align:left' align='left'>
				<tr>
					<td width='30%' style='text-align:right;' valign='top'>
						<b>First Name : </b>
					</td>
					<td width='70%' valign='top'>".$this->ReplaceSql($post['first_name'])."</td>
				</tr>
				<tr>	
					<td width='30%' style='text-align:right;' valign='top'>
 						<b>Surname : </b>
					</td>
					<td width='70%' valign='top'>".$this->ReplaceSql($post['surname'])."</td>
				</tr>
				<tr>		
					<td width='30%' style='text-align:right;' valign='top'>
						<b>Email : </b>
					</td>
					<td width='70%' valign='top'>".$this->ReplaceSql($post['email'])."</td>
				</tr>
				<tr>		
					<td width='30%' style='text-align:right;' valign='top'>
						<b>Password : </b>
					</td>
					<td width='70%' valign='top'>".$this->ReplaceSql($post['password'])."</td>
				</tr>
				<tr>		
					<td width='30%' style='text-align:right;' valign='top'>
						<b>Section : </b>
					</td>
					<td width='70%' valign='top'>".$post['womenwear']." ".$post['menwear']."</td>
				</tr>
			</table>
		</td></tr>
		</table>
		<p>Enjoy!<br />The ".COMPANY_NAME." Team</p></div>";
		$this->SendEmail($this->ReplaceSql($post['email']).",".$this->GetValue("mail_settings","email",""),COMPANY_MAIL,COMPANY_NAME,$body,"New registration email from ".COMPANY_NAME,"","");
	}
	function Login($email,$password){
		$query="select * from members where email='".$this->ReplaceSql($email)."' and password='".$this->Encrypt($password)."' and status='1'";
		if($data = $this->SelectQuery($query)){
			$_SESSION['USERLOGIN']=1;
			$_SESSION['USERID']=$data[0]['member_id'];
			$_SESSION['USERNAME']=$data[0]['first_name']." ".$data[0]['last_name'];
			$_SESSION['EMAIL']=$data[0]['email'];
			$_SESSION['FIRST_NAME']=$data[0]['first_name'];
			$_SESSION['SURNAME']=$data[0]['surname'];
			$_SESSION['LOGINTIME'] = time();
			return true;
		}
		return false;
	}
	function SignOut(){
		unset($_SESSION['USERLOGIN']);
		unset($_SESSION['CART_PRODUCTS']);
		unset($_SESSION['CART_CHARGES']);
		unset($_SESSION['USERID']);
		unset($_SESSION['USERNAME']);
		unset($_SESSION['EMAIL']);
		unset($_SESSION['LOGINTIME']);			
		unset($_SESSION['SURNAME']);
		header("Location:index.php");
	}
	function ForgotPassword($email){
		$query="select email, password from members where email='".$this->ReplaceSql($email)."'";
		if($data = $this->SelectQuery($query)){
			$body="<div style='font-family:Arial; font-size:12px;'>
		<p><h3>Below your login access on <a href='".WEBSITE_URL."'>".COMPANY_NAME."</a></h3></p>
		<table cellpadding='5' cellspacing='0' border='0' width='500px' style='border:1px solid #1C1C1E; font-family:Arial; font-size:12px; background:#ffffff'>
		<tr><td bgcolor='#1C1C1E' width='100%'><a href='".WEBSITE_URL."'><img src='".WEBSITE_URL."/images/blur-logo.png' width='72' height='29'/></a></td></tr>		<tr><td>
			<table border='0' cellpadding='10' cellspacing='0' width='100%' style='font-size:12px; text-align:left' align='left'>
				<tr>
					<td><b>Email : <b></td><td>".$data[0]['email']."</td>
				</tr>
				<tr>
					<td><b>Password : <b></td><td>".$this->Decrypt($data[0]['password'])."</td>
				</tr>
			</table>
		</td></tr>
		</table>	
			<p>Enjoy!<br />The ".COMPANY_NAME." Team</p></div>";
			//echo $body;
			$this->SendEmail($this->ReplaceSql($email),COMPANY_MAIL,COMPANY_NAME,$body,"Forgot Password Email from ".COMPANY_NAME,"","");
			return true;
		}
		return false;		
	}
	function ChangePassword($post){
		$query="select member_id from members where password='".$this->Encrypt($post['old_password'])."' and member_id='".$_SESSION['USERID']."'";
		if($data = $this->SelectQuery($query)){
			$this->UpdateQuery("update members set password='".$this->Encrypt($post['new_password'])."' where member_id='".$_SESSION['USERID']."'");
			return true;
		}
		return false;
	}	
	function ShowTitle($str,$cnt){
		$str=strip_tags(trim($str));
		if($cnt<strlen($str)){
			return substr($str,0,$cnt);
		}else{
			return $str;
		}
	}
	function ShowImage($dir,$img){
		if($img!=''){
			if($dir!=''){$dir .="/";}
			if(file_exists(UPLOAD_PATH_ORG . $dir.$img)===TRUE){
				return UPLOAD_URL_ORG . $dir.$img;
			}else{
				return UPLOAD_URL_ORG . $dir."/nopic.jpg";
			}
		}else{
			return UPLOAD_URL_ORG . $dir."/nopic.jpg";
		}
	}	
	function OrderPurchaseMail($oid=0){
		$template = '<div style="font-size:9pt; font-family:Arial;color:#000000; width:800px;">#BODY##LINK#<p>Enjoy!<br />The '.COMPANY_NAME.' Team</p></div>';	
		$body="
		<p><h3>Placed Order information email from <a href='".WEBSITE_URL."'>".COMPANY_NAME."</a></h3></p>
		<table cellpadding='5' cellspacing='0' border='0' width='700' style='border:1px solid #1C1C1E; font-family:Arial; font-size:12px; background:#ffffff'>
		<tr><td bgcolor='#1C1C1E' width='100%'><a href='".WEBSITE_URL."'><img src='".WEBSITE_URL."images/blur-logo.png' width='72' height='29'/></a></td></tr>		<tr><td>";
		$query = "select o.*,mp.*, m.email as user_email from order_form as o inner join members as m on m.member_id=o.member_id left outer join members_payment as mp on o.orderid=mp.order_id where 1=1 ".($oid!='0' ? " and o.orderid='".$oid."'":"");
		if($orders = $this->SelectQuery($query)){ 
			foreach($orders as $order){
				$body.= '<h2 style="border-bottom:1px solid #855444">Order Info</h2>
				<table width="100%" style="font-size:9pt; font-family:Arial;color:#000000;">
					<tr><th width="150" align="left">Order No</th><td align="left">'.$order['orderid'].'</td>
					<th width="150" align="left">Order + Shipment Amount</th><td align="left">'.$order['currency'].' '.''.$order['paidamount'].' + '.$order['shipamount'].' = '.($order['shipamount']+$order['paidamount']).'</td></tr>
					<tr><th width="150" align="left">Full Name</th><td align="left">'.$order['first_name'].' '.$order['last_name'].'</td>
					<th align="left">Date</th><td>'.date("d/m/Y",strtotime($order['orderdate'])).'</td></tr>
					<tr><th align="left">Order Status</th><td align="left">';
						if($order['orderstatus']=="Y") $body.="Completed";
						if($order['orderstatus']=="P") $body.="Pending";
						if($order['orderstatus']=="C") $body.="Canceled";
						if($order['orderstatus']=="S") $body.="Shipped";
				$body.='</td>
					<th align="left">Payment Status</th><td align="left">'.($order['paymentstatus']=="Y" ? "Paid":"Pending").'</td></tr></table>';
					
				$products = $this->SelectQuery("select o.*, p.* from order_product as o inner join products as p on o.productid = p.product_id where o.orderid='".$order['orderid']."'");
				if($products){$i=0;$amt=0;
				$body.='<h2 style="border-bottom:1px solid #855444">Shipping Info</h2>
				<table width="100%" style="font-size:9pt; font-family:Arial;color:#000000;">
					<tr><th width="150" align="left">Name </th><td>'.$order['first_name'].' '.$order['last_name'].'</td>
						<th width="150" align="left">Address 1 </th><td>'.$order['address1'].'</td>
					</tr>
					<tr><th width="150" align="left">Address 1 </th><td>'.$order['address1'].'</td>
						<th width="150" align="left">Country </th><td>'.$order['country'].'</td>
					</tr>
					<tr><th width="150" align="left">Province </th><td>'.$order['province'].'</td>
						<th width="150" align="left">City </th><td>'.$order['city'].'</td>
					</tr>
					<tr><th width="150" align="left">Email </th><td>'.$order['email'].'</td>
						<th width="150" align="left">Telephone </th><td>'.$order['telephone'].'</td>
					</tr>
					<tr><th width="150" align="left">Post Code </th><td>'.$order['post_code'].'</td>
						<th width="150" align="left">Country </th><td>'.$order['country'].'</td>
					</tr>
				</table>
				<h2 style="border-bottom:1px solid #855444">Authorized Payment Info</h2>
				<table width="100%" style="font-size:9pt; font-family:Arial;color:#000000;">
					<tr>
						<th align="left"><b>Success Message </b></th><td>'.$order['success_message'].'</td>
						<th align="left"><b>Response Text </b></th><td>'.$order['response_text'].'</td>
					</tr>	
					<tr>
						<th align="left"><b>Transaction Id </b></th><td>'.$order['transaction_id'].'</td>
						<th align="left"><b>Payment For </b></th><td>'.$order['payment_for'].'</td>
					</tr>
					<tr>
						<th align="left"><b>Transaction Amount </b></th><td>'.$order['transaction_amount'].'</td>
						<th align="left"><b>The payment method </b></th><td>'.$order['payment_method'].'</td>
					</tr>
					<tr>	
						<th align="left"><b>Transaction Type </b></th><td>'.$order['transaction_type'].'</td>
						<th align="left"><b>Card Code Response </b></th><td>'.$order['card_code_response'].'</td>
					</tr>
					<tr>	
						<th align="left"><b>Account Number </b></th><td>'.$order['account_number'].'</td>
						<th align="left"><b>Card Type </b></th><td>'.$order['card_type'].'</td>
					</tr>
					<tr>
					<th align="left"><b>Authorization Code </b></th><td>'.$order['authorization_code'].'</td>
					</tr>
				</table><h2 style="border-bottom:1px solid #855444">Product Info</h2>
				<table width="100%" style="font-size:9pt; font-family:Arial;color:#000000;"><tr><th width="10%" align="left">S No.</th><th width="40%" align="left">Product</th><th width="10%" align="left">Image</th><th width="10%" align="right">Price</th><th width="10%" align="right">Qty</th><th width="10%" align="right">Amount</th></tr>';
					foreach($products as $pro){
						$body.='<tr><td width="10%">'. ++$i.'</td>
						<td width="20%">'.$pro['product_title'].'</td>
						<td width="10%"><img src="'.WEBSITE_URL.'products/'.$pro['featured_image'].'" width="50" /></td>
						<td width="10%" align="right">'.$order['currency'].sprintf("%.2f",$pro['product_price']).'</td>
						<td width="10%" align="right">'.$pro['quantity'].'</td>
						<td width="10%" align="right">'.$order['currency'].sprintf("%.2f",($pro['quantity'] * $pro['product_price'])).'</td>
						</tr>';
						$amt += ($pro['quantity'] * $pro['price']);
					 }
					$body.='<tr><th colspan="5" width="90%" align="right"><strong>Sub Total : </strong>&nbsp;</th>
					<th width="10%" align="right"><strong>'.$order['currency'].sprintf("%.2f",$amt).'</strong></th></tr>
					<tr><th colspan="5" width="90%" align="right"><strong>Shipment : </strong>&nbsp;</th>
					<th width="10%" align="right"><strong>'.$order['currency'].sprintf("%.2f",$order['shipamount']).'</strong></th></tr>
					<tr><th colspan="5" width="90%" align="right"><strong>Total : </strong>&nbsp;</th>
					<th width="10%" align="right"><strong>'.$order['currency'].sprintf("%.2f",($amt+$order['shipamount'])).'</strong></th></tr>
					</table>';
				}
			$body.='</td></tr>
			</table>';
				$template = str_replace("#BODY#",$body,$template);
				$cmail = str_replace("#LINK#","<p>For more info for this Order <a href='".WEBSITE_URL."my_orders.php'>Click here</a></p>",$template);
				$amail = str_replace("#LINK#","",$template);
				if($order['user_email']!=""){
					$this->SendEmail($order['user_email'],COMPANY_MAIL,COMPANY_NAME,$cmail,COMPANY_NAME." Order ","","");
				}else{
					$this->SendEmail($order['email'],COMPANY_MAIL,COMPANY_NAME,$cmail,COMPANY_NAME." Order ","","");
				}
				$this->SendEmail($this->GetValue("mail_settings","email",""),COMPANY_MAIL,COMPANY_NAME,$amail,COMPANY_NAME." Order","","");
			}			
		}
	}
	function MakeLink($pre,$cat='',$sub=''){
		$url = '';
		if($cat!='')
			$url .= '-'.$cat;
		if($sub!='')
			$url .= '-'.$sub;
		switch($pre){
			case '2':
				return WEBSITE_URL."womenswears".$url.".php";
			case '3':
				return WEBSITE_URL."menswears".$url.".php";
			case '4':
				return WEBSITE_URL."scraf-boutiques".$url.".php";
			case '5':
				return WEBSITE_URL."sales".$url.".php";
		}
	}
	
	function GetRatio($W1,$H1,$reqW,$reqH){
		$r1 = $W1 / $H1;
        $r2 = $reqW / $reqH;
        if(($H1 > $reqH) && ($W1 > $reqW)){
            if ($r1 > $r2){
                $imgW1 = $reqW;
                $iW1 = $W1 - $reqW;
                $iW1 = ($iW1 / $W1) * 100;
                $iH1 = ($H1 / 100) * $iW1;
                $imgH1 = $H1 - $iH1;
			}elseif ($r1 < $r2){
				$imgH1 = $reqH;
                $iH1 = $H1 - $reqH;
                $iH1 = ($iH1 / $H1) * 100;
                $iW1 = ($W1 / 100) * $iH1;
                $imgW1 = $W1 - $iW1;
			}else{
				$imgH1 = $reqH;
                $imgW1 = $reqW;
			}
		}elseif (($H1 <= $reqH) && ($W1 > $reqW)){
			$imgW1 = $reqW;
			$iW1 = $W1 - $reqW;
			$iW1 = ($iW1 / $W1) * 100;
			$iH1 = ($H1 / 100) * $iW1;
			$imgH1 = $H1 - $iH1;
		}elseif(($H1 > $reqH) && ($W1 <= $reqW)){
			$imgH1 = $reqH;
			$iH1 = $H1 - $reqH;
			$iH1 = ($iH1 / $H1) * 100;
			$iW1 = ($W1 / 100) * $iH1;
			$imgW1 = $W1 - $iW1;
		}elseif(($H1 <= $reqH)&&($W1 <= $reqW)){
			$imgH1 = $H1;
			$imgW1 = $W1;
		}
		$arr = array($imgW1,$imgH1);
		return $arr;
   }
	
}
?>