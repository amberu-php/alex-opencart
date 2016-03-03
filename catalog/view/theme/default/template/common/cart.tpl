
<div id="cart" class="btn-group btn-block">
  <img id="amberu-cart-bag-img" src="image/amberu/bag.png" data-toggle="dropdown" 
	onmouseover="amberuCartBagImgOver()" onmouseout="amberuCartBagImgOut()"
	onclick="amberuCartBagImgClick()"
  />
  <button 
	id="amberu-cart-button" type="button" 
	data-toggle="dropdown" data-loading-text="<?php echo $text_loading; ?>" 
	class="btn btn-inverse btn-block btn-lg dropdown-toggle"
	onmouseover="amberuCartBagImgOver()" onmouseout="amberuCartBagImgOut()"
	onclick="amberuCartBagImgClick()"
  >
		<!--<i class="fa fa-shopping-cart"></i> -->
		<div id="cart-total" >
			<?php 
				//$amberu_buffer = preg_replace('/\s*-\s*/', "<br/>", $text_items);
				//$amberu_buffer = preg_replace('/(\d+)\s+/', '${1}<br/>', $amberu_buffer);
				echo $text_items;
			?>
		</div>
		<div id="cart-total-tablet" >
			<?php
				$amberu_buffer = preg_replace('/<br\s*\/>/', " ", $text_items);
				echo $amberu_buffer;
			?>
		</div>
  </button>
  <ul class="dropdown-menu pull-right">
    <?php if ($products || $vouchers) { ?>
    <li id="amberu-cart-product-list">
	  <div id="amberu-cart-pricelist-info">
	    Ценовая категория корзины:<br/>
		<?php if ($amberu_cart['order_limit'] > 0) { ?>
		заказ от <span class = "amberu-pricelist-limit-amount"><?php echo $amberu_cart['order_limit_text']; ?></span>
	    <?php } else { ?>
				<span class = "amberu-pricelist-limit-amount">Розница</span>
		<?php } ?>
	  </div>
      <table class="table table-striped">
        <?php foreach ($products as $product) { ?>
        <tr>
          <td class="text-center"><?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
            <?php } ?></td>
          <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <?php if ($product['option']) { ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
            <?php } ?>
            <?php } ?>
            <?php if ($product['recurring']) { ?>
            <br />
            - <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
            <?php } ?></td>
          <td class="text-right">x <?php echo $product['quantity']; ?></td>
          <td class="text-right"><?php echo $product['total']; ?></td>
          <td class="text-center">
			<button type="button" onclick="cart.remove('<?php echo $product['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs">
				<!--<i class="fa fa-times"></i>-->
				<img src="image/amberu/icons/close_b.png"/>
			</button>
		  </td>
        </tr>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <tr>
          <td class="text-center"></td>
          <td class="text-left"><?php echo $voucher['description']; ?></td>
          <td class="text-right">x&nbsp;1</td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
          <td class="text-center text-danger"><button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
        </tr>
        <?php } ?>
      </table>
    </li>
    <li id="amberu-cart-status-control">
	  <div>
        <table class="table table-bordered">
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td class="text-right amberu-td"><strong><?php echo $total['title'],":"; ?></strong></td>
            <td class="amberu-td"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
		<?php echo $amberu_cart_pricelist_select_view; ?>
        <p class="text-center">
			<a class="btn btn-primary" href="<?php echo $cart; ?>"><strong><i class="fa fa-shopping-cart"></i> <?php echo $text_cart; ?></strong></a>&nbsp;&nbsp;&nbsp;
			<a class="btn btn-primary<?php echo $amberu_checkout_available ? '' : ' disabled'; ?>" href="<?php echo $checkout; ?>"><strong><i class="fa fa-share"></i> <?php echo $text_checkout; ?></strong></a>
		</p>
      </div>
    </li>
    <?php } else { ?>
    <li>
      <p class="text-center"><?php echo $text_empty; ?></p>
    </li>
    <?php } ?>
  </ul>
</div>
