<!--AMBERU-->
<?php if($amberu_cart['multiprice']) { ?>
	<div class="amberu-multiprice-container">
	  <div class="amberu-multiprice-inner-container amberu-pricelist-limit-container">
		<?php if ($amberu_cart['order_limit'] > 0) { ?>
			<?php echo $amberu_text_cart_pricelist; ?> - <?php echo $amberu_text_pre_order_limit; ?> <span class="amberu-pricelist-limit-amount"><?php echo $amberu_cart['text_order_limit'] ?></span>
		<?php } else { ?>
			<?php echo $amberu_text_cart_pricelist; ?> - <span class="amberu-pricelist-limit-amount"> <?php echo $amberu_text_retail; ?></span>
		<?php   } ?>
	  </div>
	  <div class="amberu-multiprice-inner-container amberu-pricelist-select-container">
		<span class="amberu-multiprice-caption"><?php echo $amberu_text_select_cart_pricelist; ?>: </span>
		<select class="form-control select-amberu-pricelist-number" onchange="location = this.value;">
		<?php foreach ($amberu_pricelists as $amberu_key => $amberu_pricelist) { ?>
		<?php   if(($amberu_pricelist['customer_group_id'] == -1) || ($amberu_pricelist['customer_group_id'] == $customer_group_id)) { ?>
				  <option value="<?php echo $amberu_current_href . '&amberu_cart_p_n=' . $amberu_key ?>" 
				  <?php echo ($amberu_cart['pricelist_number'] == $amberu_key) ? 'selected="selected"' : ''; ?>>
					<?php echo ($amberu_pricelist['order_limit'] > 0) ? $amberu_text_pre_order_limit . $currency_symbols['left'] . $amberu_pricelist['order_limit'] . $currency_symbols['right'] : $amberu_text_retail; ?>
				  </option>
		<?php 	} ?>		  
		<?php } ?>
		</select>
	  </div>
	</div>
<?php } ?>