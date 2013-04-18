<!DOCTYPE html>
<html class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title><?php echo COMPANY_NAME;?> | Signin</title>
<?php include_once("inc.head.php");?>
</head>
<body class="cmnco">
<div id="container" class="js_controller" data-controller="CheckoutController">
  <div id="header">
    <h1> <a href="#" id="logo" title="Blur Leather">Blur Leather</a> </h1>
  </div>
  <div class="content customer">
    <div class="checkout">
      <div class="head">
        <h2 class="h1">Checkout</h2>
        <p class="service">Customer Service 0800 157 7811 (10am – 6pm Mon – Fri)<br>
          <a href="#" data-href="/customer-service-7-day-free-return-policy">Return Policy</a> | <a href="#" data-href="/terms-conditions">Terms and Conditions</a> | <a href="/contact/amq-contact-us">Contact us</a> </p>
        <div class="payment">
          <h6 class="h5">Security Provided By</h6>
          <script type="text/javascript" src="signin_files/getseal"></script><a href="javascript:vrsn_splash()" tabindex="-1"><img name="seal" src="signin_files/getseal.gif" oncontextmenu="return false;" alt="" border="true"></a> </div>
      </div>
      <p class="msg">We offer a free return or exchange service if you 
        change your mind or need a different size; just submit a return request 
        within 7 days of receiving your order.</p>
      <ol id="steps">
        <li class="step completed" id="signin">
          <h3 class="h2">sign in</h3>
        </li>
        <li class="step active js_sc" id="addresses">
          <h3 class="h2">Shipping &amp; Billing</h3>
          <p>If shipping to a  work address, please include the company name. Required fields are marked with a * </p>
          <form method="post" id="addressesform" class="js_checkoutStep" action="/Sites-AM_GB-Site/en_GB/MVC-Dispatch">
            <input name="path" value="/commoncheckout/submitaddresses" type="hidden">
            <fieldset id="shipping">
              <div class="formrow">
                <label for="a.Address.salutation" class="">Title*</label>
                <select name="a.Address.salutation.shipping" class="required " data-required="This field is required">
                  <option selected="selected" value="">---</option>
                  <option value="mr">Mr</option>
                  <option value="ms">Ms</option>
                  <option value="miss">Miss</option>
                  <option value="mrs">Mrs</option>
                </select>
              </div>
              <div class="formrow">
                <label for="a.Address.firstName" class="">First Name*</label>
                <input name="a.Address.firstName.shipping" class="required " data-required="This field is required" type="text">
              </div>
              <div class="formrow">
                <label for="a.Address.lastName" class="">Last Name*</label>
                <input name="a.Address.lastName.shipping" class="required " data-required="This field is required" type="text">
              </div>
              <div class="formrow">
                <label for="a.Address.countryCode" class="">Country*</label>
                <select name="a.Address.countryCode.shipping" value="gb" class="required " data-required="This field is required">
                  <option selected="selected" value="GB">United Kingdom</option>
                </select>
              </div>
              <div class="formrow">
                <label for="a.Address.companyName" class="">Company</label>
                <input name="a.Address.companyName.shipping" class=" " type="text">
              </div>
              <div class="formrow">
                <label for="a.Address.address1" class="">Address Line 1*</label>
                <input name="a.Address.address1.shipping" class="required " data-required="This field is required" type="text">
              </div>
              <div class="formrow">
                <label for="a.Address.address2" class="">Address Line 2</label>
                <input name="a.Address.address2.shipping" class=" " type="text">
              </div>
              <div class="formrow">
                <label for="a.Address.city" class="">City*</label>
                <input name="a.Address.city.shipping" class="required " data-required="This field is required" type="text">
              </div>
              <div class="formrow">
                <label for="a.Address.county" class="">County / Province</label>
                <input name="a.Address.county.shipping" class=" " type="text">
              </div>
              <div class="formrow">
                <label for="a.Address.postalCode" class="">Postcode*</label>
                <input name="a.Address.postalCode.shipping" class="required js_postalcode" data-href="/commoncheckout/getshipmethods" data-required="This field is required" type="text">
              </div>
              <div class="formrow">
                <label for="a.Address.phone" class="">Telephone*</label>
                <input name="a.Address.phone.shipping" class="required phone middle" data-required="This field is required" data-phone="Please enter a valid phone number" type="tel">
              </div>
              <div class="formrow">
                <label for="a.Basket.customerEmail" class="">Email Address*</label>
                <input name="a.Basket.customerEmail" class="required email comparecheckoutemails " data-required="This field is required" data-email="Please enter a valid email address" type="text">
              </div>
              <div class="formrow">
                <label for="a.Basket.emailrepeat" class="">Confirm Email*</label>
                <input name="a.Basket.emailrepeat" class="required email comparecheckoutemails nopaste" data-required="This field is required" data-email="Please enter a valid email address" type="text">
              </div>
              <div class="formrow">
                <label>
                  <input id="gift" name="purchaseAsGift" type="checkbox">
                  This is a gift</label>
                <!-- AMQ Specific -->
                <div class="text">
                  <p>Include a personal message and ship with a gift receipt.</p>
                  <textarea rows="5" id="giftmsg" name="giftMessage" style="display:none"></textarea>
                </div>
              </div>
            </fieldset>
            <fieldset id="billing">
              <h4 class="h2">Billing address</h4>
              <p>Please ensure that your billing address matches the 
                address held by your card issuer. We can only accept credit cards 
                registered to a UK address.</p>
              <div class="options">
                <div class="formrow chooser">
                  <label>
                    <input name="billing" value="same" checked="checked" type="radio">
                    Use Shipping Address As Billing Address</label>
                </div>
                <div class="formrow chooser">
                  <label>
                    <input name="billing" value="different" type="radio">
                    Enter Separate Billing Address</label>
                </div>
              </div>
              <div id="billingAddress" style="display:none">
                <div class="formrow">
                  <label for="a.Address.salutation" class="">Title*</label>
                  <select name="a.Address.salutation.billing" class="required " data-required="This field is required">
                    <option selected="selected" value="">---</option>
                    <option value="mr">Mr</option>
                    <option value="ms">Ms</option>
                    <option value="miss">Miss</option>
                    <option value="mrs">Mrs</option>
                  </select>
                </div>
                <div class="formrow">
                  <label for="a.Address.firstName" class="">First Name*</label>
                  <input name="a.Address.firstName.billing" class="required " data-required="This field is required" type="text">
                </div>
                <div class="formrow">
                  <label for="a.Address.lastName" class="">Last Name*</label>
                  <input name="a.Address.lastName.billing" class="required " data-required="This field is required" type="text">
                </div>
                <div class="formrow">
                  <label for="a.Address.countryCode" class="">Country*</label>
                  <select name="a.Address.countryCode.billing" value="gb" class="required " data-required="This field is required">
                    <option selected="selected" value="GB">United Kingdom</option>
                  </select>
                </div>
                <div class="formrow">
                  <label for="a.Address.companyName" class="">Company</label>
                  <input name="a.Address.companyName.billing" class=" " type="text">
                </div>
                <div class="formrow">
                  <label for="a.Address.address1" class="">Address Line 1*</label>
                  <input name="a.Address.address1.billing" class="required " data-required="This field is required" type="text">
                </div>
                <div class="formrow">
                  <label for="a.Address.address2" class="">Address Line 2</label>
                  <input name="a.Address.address2.billing" class=" " type="text">
                </div>
                <div class="formrow">
                  <label for="a.Address.city" class="">City*</label>
                  <input name="a.Address.city.billing" class="required " data-required="This field is required" type="text">
                </div>
                <div class="formrow">
                  <label for="a.Address.county" class="">County / Province</label>
                  <input name="a.Address.county.billing" class=" " type="text">
                </div>
                <div class="formrow">
                  <label for="a.Address.postalCode" class="">Postcode*</label>
                  <input name="a.Address.postalCode.billing" class="required js_postalcode" data-href="/commoncheckout/getshipmethods" data-required="This field is required" type="text">
                </div>
              </div>
            </fieldset>
            <fieldset id="shippingoptions">
              <h4 class="h2">Shipping options</h4>
              <p>If you have any questions regarding the shipping options you might want to consider reading our 
              <a href="#" data-href="/customer-service-delivery-terms">delivery terms</a>.</p>
              <p>Orders are processed and delivered Monday–Friday. Orders processed after 3pm will ship the following day.</p>
              <div id="billingAddress">
                <div class="formrow">
                  <label for="">delivery method</label>
                  <div class="text">
                    <select name="shippingmethod" data-url="/commoncheckout/updateshippingmethod">
                      <option value="TNT_GB_STANDARD" selected="selected">1-2 Day delivery (£7.50)</option>
                      <option value="TNT_GB_NEXTDAY">Next Working Day (£10.00)</option>
                    </select>
                  </div>
                </div>
              </div>
            </fieldset>
            <div class="buttonbar"> <a class="button secondary" href="/checkoutcart">Back to Basket</a>
              <input class="button primary js_scc" value="Continue to Payment" type="submit">
            </div>
          </form>
          <iframe src="signin_files/ReportingPipes-Checkout.htm" style="display:none;"></iframe>
        </li>
        <li class="step" id="payment">
          <h3 class="h2">Pay &amp; Confirm</h3>
        </li>
      </ol>
      <div id="extra">
        <div class="" id="minibasket">
          <h3 class="h2">Order Summary <a href="/checkoutcart">Edit</a></h3>
          <ul id="miniproducts">
            <li> <a href="/formal-wear/smart-trousers/Feather-Print-Wool-Trouser/804918901,en_GB,pd.html"><img src="signin_files/299513_QX605_1072_A_81x81.jpg" alt="Feather Print Wool Trouser" data-format="81x81" data-viewtype="A" height="81" width="81"></a>
              <h6>Feather Print Wool Trouser</h6>
              <p>299513 QX605 1072</p>
              <p>50</p>
              <p class="price">£635.00</p>
            </li>
            <li> <a href="/mens-accessories/ties/Raven-Silk-Tie/804879709,en_GB,pd.html"><img src="signin_files/302990_4002E_1068_A_81x81.jpg" alt="Raven Silk Tie" data-format="81x81" data-viewtype="A" height="81" width="81"></a>
              <h6>Raven Silk Tie</h6>
              <p>302990 4002E 1068</p>
              <p>U</p>
              <p class="price">£130.00</p>
            </li>
          </ul>
          <dl class="calc">
            <dt>sub totals</dt>
            <dd>£765.00</dd>
            <dt>sales taxes</dt>
            <dd class="js_taxval">--</dd>
            <dt>Shipping</dt>
            <dd class="js_shipval">£7.50</dd>
          </dl>
          <dl class="calc total">
            <dt>Total</dt>
            <dd class="js_totalval">£772.50</dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="payment">
      <h6 class="h5 cards">We Accept The Following Cards</h6>
    </div>
  </div>
  <?php include_once("inc.footer.php");?>
  <div id="shim"></div>
</div>
</body>
</html>