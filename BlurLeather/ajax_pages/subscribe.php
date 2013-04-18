<?php require_once("../class/class.functions.php"); 
	$fn = new Functions();
	if(isset($_POST['btn_submit'])){
		if(!$fn->ValueExists("subscribes","email",$fn->ReplaceSql($_POST["email"]))){
			$fn->InsertQuery("insert into subscribes set salutation='".$fn->ReplaceSql($_POST['salutation'])."', first_name='".$fn->ReplaceSql($_POST['first_name'])."',surname='".$fn->ReplaceSql($_POST['surname'])."', email='".$fn->ReplaceSql($_POST['email'])."', country_id='".$fn->ReplaceSql($_POST['country_id'])."', womenswear='".$fn->ReplaceSql($_POST['womenswear'])."', menswear='".$fn->ReplaceSql($_POST['menswear'])."'");
			$_SESSION['ERRORTYPE'] = "success";
			$_SESSION['ERRORMSG'] = $fn->GetValue("mail_settings","quote_inquiry","");
			header("Location:subscribe.php");
		}else{
			$_SESSION['ERRORTYPE'] = "error";
			$_SESSION['ERRORMSG'] = "Your email has been subscribed already!";
		}
	}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("../includes/inc.header-scripts-ajax.php");?>
</head>
<body>
<?php include_once("../message.php");?>
<div class="full subscribe_section">
  <div class="left_section"> <img src="../images/subscribe.png" /> </div>
  <div class="right_section">
    <div class="full">
      <h2 class="text_capital">subscribe</h2>
      <div class="full paddtop10"> Sign up for Blur Leather updates to receive information about future events and special projects. Please be assured that Blur Leather will not share your email address with third parties. View our Privacy Policy to find out how we will process your personal data. </div>
    </div>
    <form action="" method="post" name="frmsubscribe" id="frmsubscribe" onsubmit="return validate(document.forms['frmsubscribe']);">
      <div class="full paddtop10"> Required fields are marked with a * </div>
      <div class="full">
        <div class="col40">
          <label for="title">Title*</label>
        </div>
        <div class="col60">
          <select name="salutation" id="salutation" class="R" title="Title">
            <option value="">--</option>
            <option value="MR">MR</option>
            <option value="MS">MS</option>
            <option value="MISS">MISS</option>
            <option value="MRS">MRS</option>
          </select>
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="first_name" class="">First Name*</label>
        </div>
        <div class="col60">
          <input name="first_name" type="text" id="first_name" title="First Name" class="R" size="20"/>
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="surname">Surname*</label>
        </div>
        <div class="col60">
          <input name="surname" class="R" type="text" id="surname" title="Surname">
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="email">Your Email*</label>
        </div>
        <div class="col60">
          <input name="email" id="email" class="RisEmail" type="text" title="Your Email">
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="confirm_email">Confirm Email*</label>
        </div>
        <div class="col60">
          <input name="confirm_email" id="confirm_email" class="RisEmail CM-email-CM" type="text" title="Confirm Email">
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="country">Country*</label>
        </div>
        <div class="col60">
         <select id="country_id" name="country_id" class="R" title="Country">
                <option value="">--</option>
                <?php if($country_cmb = $fn->SelectQuery("select * from country order by orderid")){?><?php foreach ($country_cmb as $country) { ?><option <?php echo ($data[0]['country_id']==$country['country_id'])?'selected="selected"':'';?> value="<?php echo $country['country_id']?>"><?php echo ucfirst($country['country_title']);?></option><?php }} ?>
            </select> 
        </div>
      </div>
      <div class="full">
        <div class="full">
          <div class="col40">&nbsp;</div>
          <div class="col60 paddtop20">
            <div class="full"> I am interested in the following collections and agree that my data may be processed in accordance with the <a href="">Privacy Policy</a>: </div>
            <div class="full">
              <div class="col40 paddtop10"><img src="../images/logo_login.png" /></div>
              <div class="col60">
                <div class="full">
          			<label>
                    <input name="womenswear" value="Womenswear" type="checkbox">
                    WOMENSWEAR
                  </label>      
                </div> 
                <div class="full">
          			<label>
                <input name="menswear" value="Menswear" type="checkbox">
                MENSWEAR
              </label>      
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="full txtright margintop20">
      	<input value="Submit" type="submit" name="btn_submit" id="btn_submit">
      </div>
    </form>
  </div>
</div>
<?php include("../includes/inc.footer_unset.php");?>
</body>
</html>