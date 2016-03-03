<!--AMBERU-->

	<div class="amberu-multiprice-container">
	  <div class="amberu-multiprice-inner-container amberu-pricelist-limit-container">
		<?php echo $amberu_text_pricelist_current; ?> - <?php //echo $amberu_text_pre_order_limit; ?> <span class="amberu-pricelist-limit-amount"><?php echo $amberu_pricelists[$amberu_pricelist_number]['order_limit_text'] ?></span>
	  </div>
	  <div class="amberu-multiprice-inner-container amberu-pricelist-select-container">
		<span class="amberu-multiprice-caption"><?php echo $amberu_text_pricelist_select; ?>: </span>
		<select class="form-control select-amberu-pricelist-number" onchange="amberuSelectPricelistChange(this.value)">
		<?php foreach ($amberu_pricelists as $amberu_key => $amberu_pricelist) { ?>
		  <option value="<?php echo 'amberu_pricelist_number=' . $amberu_key ?>" 
		  <?php echo ($amberu_pricelist_number == $amberu_key) ? 'selected="selected"' : ''; ?>>
			<?php echo $amberu_pricelists[$amberu_key]['order_limit_text']; ?>
		  </option>	  
		<?php } ?>
		</select>
	  </div>
	</div>
