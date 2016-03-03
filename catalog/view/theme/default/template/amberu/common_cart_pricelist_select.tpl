<!--AMBERU-->
<?php if($amberu_cart['multiprice']) { ?>
	<div class="amberu-multiprice-container">
	  <div class="amberu-multiprice-inner-container amberu-pricelist-select-container">
		<span class="amberu-multiprice-caption"><?php echo $amberu_text_select_cart_pricelist; ?>: </span>
		<!--location = this.value;-->
		<select class="form-control select-amberu-cart-pricelist-number" onchange="amberuCartSelectPricelistChange(this.value)" 
			onmouseover="amberuCartSelectPricelistOver()" onmouseout="amberuCartSelectPricelistOut()">
		<?php foreach ($amberu_pricelists as $amberu_key => $amberu_pricelist) { ?>
		<?php   if(($amberu_pricelist['customer_group_id'] == -1) || ($amberu_pricelist['customer_group_id'] == $customer_group_id)) { ?>
				  <option value="<?php echo 'amberu_cart_p_n=' . $amberu_key ?>" 
				  <?php echo ($amberu_cart['pricelist_number'] == $amberu_key) ? 'selected="selected"' : ''; ?>>
					<?php echo ($amberu_pricelist['order_limit'] > 0) ? $amberu_text_pre_order_limit . $currency_symbols['left'] . $amberu_pricelist['order_limit'] . $currency_symbols['right'] : $amberu_text_retail; ?>
				  </option>
		<?php 	} ?>		  
		<?php } ?>
		</select>
	  </div>
	</div>
<script type="text/javascript">
/*
$('#cart ul li .select-amberu-pricelist-number').hover( 
	function() {
		$('#cart ul').css('display', 'block');
		$('#cart').addClass('fake-open');
	}, 
	function() {
		$('#cart ul').css('display', '');
		$('#cart').addClass('open');
		$('#cart').removeClass('fake-open');
	} 
);
$('#cart ul li .select-amberu-pricelist-number').change(
	function () {
		$('#cart ul').html('<div class="amberu-loading">Загрузка...</div>');
	}
);
*/
</script>
<?php } ?>