<?php echo $header; ?>
<div class="container">
	<!--AMBERU-->
		<input id = "amberu-category-id-hidden" type="hidden" value="<?php echo $amberu_category_id; ?>"/>
  <ul id="amberu-category-breadcrumbs" class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  
  <!--AMBERU-->
  <?php if(isset($amberu_multiprice)) { ?>
	<div class="amberu-multiprice-container">
	  <div class="amberu-pricelist-limit-container amberu-multiprice-inner-container">
		<?php if ($amberu_pricelist_order_limit > 0) { ?>
			Категория цен - заказ от <span class="amberu-pricelist-limit-amount"><?php echo $amberu_pricelist_order_limit ?></span>
		<?php } else { ?>
			Категория цен - <span class="amberu-pricelist-limit-amount"> Розница</span>
		<?php   } ?>
	  </div>
	  <div class="amberu-pricelist-select-container amberu-multiprice-inner-container">
		<span class="amberu-multiprice-caption"><?php echo $amberu_text_pricelist_select; ?>: </span>
		<select class="form-control select-amberu-pricelist-number" onchange="location = this.value;">
		<?php foreach ($amberu_pricelists as $amberu_key => $amberu_pricelist) { ?>
		<?php   if(($amberu_pricelist['customer_group_id'] == -1) || ($amberu_pricelist['customer_group_id'] == $customer_group_id)) { ?>
				  <option value="<?php echo $category_href . '&amberu_pricelist_number=' . $amberu_key ?>" 
				  <?php echo ($amberu_pricelist_number == $amberu_key) ? 'selected="selected"' : ''; ?>>
					<?php echo ($amberu_pricelist['order_limit'] > 0) ? 'заказ от ' . $currency_symbols['left'] . $amberu_pricelist['order_limit'] . $currency_symbols['right'] : 'Розница'; ?>
				  </option>
		<?php 	} ?>		  
		<?php } ?>
		</select>
	  </div>
	</div>
  <?php } ?>
  
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2 style="margin-top: 10px;"><?php echo $heading_title; ?></h2>
      <?php if ($thumb) { ?>
      <div class="row">
        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
      </div>
      <?php } ?>
      <hr style="border-width: 0px;">
      <?php if ($categories) { ?>
      <h3><?php echo $text_refine; ?></h3>
      <?php if (count($categories) <= 5) { ?>
      <div id="amberu-refine-search-container" class="row">
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } else { ?>
      <div id="amberu-refine-search-container" class="row">
        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php if ($products) { ?>
      <!--<p><a href="<?php //echo $compare; ?>" id="compare-total"><?php //echo $text_compare; ?></a></p>-->
      <div id="amberu-category-view-controls" class="row">
        <div id="amberu-category-view-buttons" class="col-md-12">
          <!--<div class="btn-group hidden-xs">-->
		  <div class="hidden-xs">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>">
				<!--<i class="fa fa-th-list"></i>-->
				<?php echo $text_amberu_list; ?>
			</button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>">
				<!--<i class="fa fa-th"></i>-->
				<?php echo $text_amberu_grid; ?>
			</button>
		  </div>
		  <!--//AMBERU
		  <a id="amberu-compare-btn" class="btn btn-default" href="<?php //echo $compare; ?>" id="compare-total"><?php //echo $text_compare; ?></a>
		  -->
        </div>
		<div id="amberu-category-view-selects">
			<div class="col-md-6 text-left amberu-select-container">
			  <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
			  <select id="input-sort" class="form-control" onchange="location = this.value;">
				<?php foreach ($sorts as $sorts) { ?>
				<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
				<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
				<?php } ?>
				<?php } ?>
			  </select>
			</div>
			<div class="col-md-6 text-left amberu-select-container">
			  <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
			  <select id="input-limit" class="form-control" onchange="location = this.value;">
				<?php foreach ($limits as $limits) { ?>
				<?php if ($limits['value'] == $limit) { ?>
				<option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
				<?php } ?>
				<?php } ?>
			  </select>
			</div>
		</div>
      </div>
      <br />
      <div id="amberu-category-products" class="row">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-list col-xs-12">
          <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div>
              <div class="caption">
                <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                <p><?php echo $product['description']; ?></p>
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
                <?php if ($product['price']) { ?>
                <p class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-new amberu-text-danger"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                  <?php } ?>
                  <?php if ($product['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                  <?php } ?>
                </p>
                <?php } ?>
              </div>
              <div class="button-group">
                <button class="amberu-product-add-btn" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');">
					<i class="fa fa-shopping-cart"></i> 
					<span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span>
				</button>
                <!--//AMBERU
				<button class="amberu-product-wishlist-btn" type="button" data-toggle="tooltip" title="<?php //echo $button_wishlist; ?>" onclick="wishlist.add('<?php //echo $product['product_id']; ?>');">
					<i class="fa fa-heart-o"></i> 
					<span class="hidden-xs hidden-sm hidden-md"><?php //echo $button_wishlist; ?></span>
				</button>
                <button class="amberu-product-compare-btn" type="button" data-toggle="tooltip" title="<?php //echo $button_compare; ?>" onclick="compare.add('<?php //echo $product['product_id']; ?>');">
					<i class="fa fa-bar-chart-o"></i> 
					<span class="hidden-xs hidden-sm hidden-md"><?php //echo $button_compare; ?></span>
				</button>
				-->
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>	  
      <?php } ?>
	  <?php if ($description) { ?>
	  <hr>
      <div class="row">
        <div class="col-sm-10"><?php echo $description; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
