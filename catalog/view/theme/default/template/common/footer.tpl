<footer>
  <div class="container">
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-3 amberu-div">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <a href="<?php echo $information['href']; ?>"><li><?php echo $information['title']; ?></li></a>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
	  <div class="col-sm-3 amberu-div">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          <a href="<?php echo $account; ?>"><li><?php echo $text_account; ?></li></a>
          <a href="<?php echo $order; ?>"><li><?php echo $text_order; ?></li></a>
          <!--//AMBERU
		  <a href="<?php //echo $wishlist; ?>"><li><?php //echo $text_wishlist; ?></li></a>
          <a href="<?php //echo $newsletter; ?>"><li><?php //echo $text_newsletter; ?></li></a>
		  -->
        </ul>
      </div>
      <div class="col-sm-3 amberu-div">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          <a href="<?php echo $contact; ?>"><li><?php echo $text_contact; ?></li></a>
          <!--//AMBERU
		  <a href="<?php //echo $return; ?>"><li><?php //echo $text_return; ?></li></a>
          <a href="<?php //echo $sitemap; ?>"><li><?php //echo $text_sitemap; ?></li></a>
		  -->
        </ul>
      </div>
      <div class="col-sm-3 amberu-div">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <!--//AMBERU
		  <a href="<?php //echo $manufacturer; ?>"><li><?php //echo $text_manufacturer; ?></li></a>
          <a href="<?php //echo $voucher; ?>"><li><?php //echo $text_voucher; ?></li></a>
          <a href="<?php //echo $affiliate; ?>"><li><?php //echo $text_affiliate; ?></li></a>
          <a href="<?php //echo $special; ?>"><li><?php //echo $text_special; ?></li></a>
		  -->
		  <a href="<?php echo $sitemap; ?>"><li><?php echo $text_sitemap; ?></li></a>
		  <!--//END-->
        </ul>
      </div>
    </div>
    <hr>
    <p id="amberu-footer-powered"><?php echo $powered; ?></p> 
	
	<div style="font-weight:lighter;"><img src="http://seosolution.ua/sslogo.png" style="margin-bottom:9px;!important"> Продвижение интернет магазина от <a href="https://seosolution.ua/" rel="nofollow">https://seosolution.ua/</a>.</div>
	
  </div>
</footer>

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//--> 

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->

</body></html>