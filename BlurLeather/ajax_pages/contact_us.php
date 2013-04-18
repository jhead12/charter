<?php require_once("../class/class.functions.php");
	$fn = new Functions();
if(isset($_POST['btn_submit'])){
		$fn->InsertQuery("insert into contacts set your_name='".$fn->ReplaceSql($_POST['your_name'])."',enquiry_type='".$fn->ReplaceSql($_POST['enquiry_type'])."', your_email='".$fn->ReplaceSql($_POST['your_email'])."', country='".$fn->ReplaceSql($_POST['country'])."', telephone='".$fn->ReplaceSql($_POST['telephone'])."', message='".$fn->ReplaceSql($_POST['message'])."'");
		$body="<div style='font-family:Arial; font-size:12px;'>
		<p><h3>Enquiry your_email from <a href='".WEBSITE_URL."'>".COMPANY_NAME."</a><h3></p>
		<table cellpadding='5' cellspacing='0' border='0' width='500px' style='border:1px solid #1C1C1E; font-family:Arial; font-size:12px; background:#ffffff'>
		<tr><td bgcolor='#1C1C1E' width='100%'><a href='".WEBSITE_URL."'><img src='".WEBSITE_URL."/images/blur-logo.png' width='72' height='29'/></a></td></tr>		<tr><td>
			<table border='0' cellpadding='10' cellspacing='0' width='100%' style='font-size:12px; text-align:left' align='left'>
				<tr>	
					<td width='30%' style='text-align:left;' valign='top'>
						<b>Enquiry Type : </b>
					</td>
					<td width='70%' valign='top'>".$fn->ReplaceSql($_POST['enquiry_type'])."</td>
				</tr>
				<tr>
					<td width='30%' style='text-align:left;' valign='top'>
						<b>First Name : </b>
					</td>
					<td width='70%' valign='top'>".$fn->ReplaceSql($_POST['your_name'])."</td>
				</tr>
				<tr>		
					<td width='30%' style='text-align:left;' valign='top'>
						<b>Your Email : </b>
					</td>
					<td width='70%' valign='top'>".$fn->ReplaceSql($_POST['your_email'])."</td>
				</tr>
				<tr>		
					<td width='30%' style='text-align:left;' valign='top'>
						<b>Telephone : </b>
					</td>
					<td width='70%' valign='top'>".$fn->ReplaceSql($_POST['telephone'])."</td>
				</tr>
				<tr>		
					<td width='30%' style='text-align:left;' valign='top'>
						<b>Country : </b>
					</td>
					<td width='70%' valign='top'>".$fn->ReplaceSql($_POST['country'])."</td>
				</tr>
				
				<tr>		
					<td width='30%' style='text-align:left;' valign='top'>
						<b>message : </b>
					</td>
					<td width='70%' valign='top'>".$fn->ReplaceSql($_POST['message'])."</td>
				</tr>
			</table>
		</td></tr>
		</table>
		<p>Enjoy!<br />The ".COMPANY_NAME." Team</p></div>";		
		$fn->SendEmail($fn->GetValue("mail_settings","email",""),COMPANY_MAIL,COMPANY_NAME,$body,"Enquiry email from ".COMPANY_NAME,"","");
		$_SESSION['ERRORTYPE'] = "success";
		$_SESSION['ERRORMSG'] = $fn->GetValue("mail_settings","new_inquiry","");
		header("Location:contact_us.php");
	}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("../includes/inc.header-scripts-ajax.php");?>
</head>
<body>
<?php include_once("../message.php");?>
<div class="full contact_section">
  <div class="left_section"> 
  	<div class="full">
      <h2 class="text_capital">Contact us</h2>
    </div>
    <div class="full paddtop10"> 
    	<?php if($content = $fn->SelectQuery("select * from content_table where content_title='contact'"))
				echo $fn->MakeHTML($content[0]['content_desc']);
		?>
    </div>
	</div>
  <div class="right_section">
    <form action="" method="post" name="frmcontact" id="frmcontact" onsubmit="return validate(document.forms['frmcontact']);">
      <div class="full paddtop10"> Required fields are marked with a * </div>
      <div class="full paddtop10">
        <div class="col40">
          <label for="enquiry_type">Choose enquiry type*</label>
        </div>
        <div class="col60">
          <select class="R" title="Enquiry Type" name="enquiry_type" id="enquiry_type">
              <option value="">--</option>
            <option value="Order information enquiry">Order information enquiry</option>
            <option value="Product information enquiry">Product information enquiry</option>
            <option value="Technical help enquiry">Technical help enquiry</option>
            <option value="Newsletter subscription enquiry">Newsletter subscription enquiry</option>
            <option value="Suggestion/Feedback">Suggestion/Feedback</option>
            <option value="Other enquiry">Other enquiry</option>
        </select>
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="your_name">Your Name*</label>
        </div>
        <div class="col60">
          <input name="your_name" type="text" id="your_name" title="Your Name" class="R" size="20"/>
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="your_email">Your email*</label>
        </div>
        <div class="col60">
          <input name="your_email" id="your_email" class="RisEmail" type="text" title="Your Email"/>
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="telephone">Telephone*</label>
        </div>
        <div class="col60">
          <input name="telephone" id="telephone" class="R" type="text" title="Telephone"/>
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="country">Choose your country*</label>
        </div>
        <div class="col60">
          <?php if($countryrs = $fn->SelectQuery("select * from country")){?>
            <select id="country" name="country" class="R" title="Country">
              <option value="">--</option>
              <?php foreach($countryrs as $country){?>
                  <option value="<?php echo $country['country_title'];?>"><?php echo $country['country_title'];?></option>
              <?php } ?>
            </select>
        <?php } ?>
        </div>
      </div>
      <div class="full">
        <div class="col40">
          <label for="message">Your Message*</label>
        </div>
        <div class="col60">
          <textarea cols="34" rows="6" name="message" id="message" title="Message" class="R"></textarea>
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