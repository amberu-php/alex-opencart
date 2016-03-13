<?php echo $styles_html; ?>
<?php echo $scripts_html; ?>

<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="amberu-modal-product-nav-tabs">
    <li role="presentation" class="active"><a href="#amberu-modal-tabpanel-product" aria-controls="amberu-modal-tabpanel-product" role="tab" data-toggle="tab"><?php echo $amberu_text_product; ?></a></li>
    <li role="presentation"><a href="#amberu-modal-tabpanel-desc" aria-controls="amberu-modal-tabpanel-desc" role="tab" data-toggle="tab"><?php echo $amberu_text_desc; ?></a></li>
    <li role="presentation"><a href="#amberu-modal-tabpanel-images" aria-controls="amberu-modal-tabpanel-images" role="tab" data-toggle="tab"><?php echo $amberu_text_images; ?></a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="amberu-modal-tabpanel-product">
		<div id="amberu-product-main-info">
		  <h1><?php echo $heading_title; ?></h1>
		  <ul id="ul-amberu-price" class="list-unstyled">
			<?php if (!$special) { ?>
			<li>
			  <h2 class="amberu-price price"><?php echo $price; ?></h2>
			</li>
			<?php } else { ?>
			<li><h2 class="price-old"><?php echo $price; ?></h2></li>
			<li>
			  <h2 class="amberu-price amberu-text-danger"><?php echo $special; ?></h2>
			</li>
			<?php } ?>
			<?php if ($tax) { ?>
			<li><?php echo $text_tax; ?> <?php echo $tax; ?></li>
			<?php } ?>
			<?php if ($points) { ?>
			<li><?php echo $text_points; ?> <?php echo $points; ?></li>
			<?php } ?>
			<?php if ($discounts) { ?>
			<li>
			  <hr>
			</li>
			<?php foreach ($discounts as $discount) { ?>
			<li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
			<?php } ?>
			<?php } ?>
		  </ul>
		  <h3><?php echo $product_details; ?></h3>
		  <ul class="list-unstyled">
			<?php if ($manufacturer) { ?>
			<li><?php echo $text_manufacturer; ?> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></li>
			<?php } ?>
			<li><?php echo $text_model; ?> <?php echo $model; ?></li>
			<?php if ($reward) { ?>
			<li><?php echo $text_reward; ?> <?php echo $reward; ?></li>
			<?php } ?>
			<li><?php echo $text_stock; ?> <?php echo $stock; ?></li>
		  </ul>
		</div>
	  <?php if ($price) { ?>
	  <?php } ?>
	  <div id="product">
		<?php if ($options) { ?>
		<hr>
		<h3><?php echo $text_option; ?></h3>
		<?php foreach ($options as $option) { ?>
		<?php if ($option['type'] == 'select') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
		  <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
			<option value=""><?php echo $text_select; ?></option>
			<?php foreach ($option['product_option_value'] as $option_value) { ?>
			<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
			<?php if ($option_value['price']) { ?>
			(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
			<?php } ?>
			</option>
			<?php } ?>
		  </select>
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'radio') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label"><?php echo $option['name']; ?></label>
		  <div id="input-option<?php echo $option['product_option_id']; ?>">
			<?php foreach ($option['product_option_value'] as $option_value) { ?>
			<div class="radio">
			  <label>
				<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
				<?php echo $option_value['name']; ?>
				<?php if ($option_value['price']) { ?>
				(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
				<?php } ?>
			  </label>
			</div>
			<?php } ?>
		  </div>
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'checkbox') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label"><?php echo $option['name']; ?></label>
		  <div id="input-option<?php echo $option['product_option_id']; ?>">
			<?php foreach ($option['product_option_value'] as $option_value) { ?>
			<div class="checkbox">
			  <label>
				<input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
				<?php echo $option_value['name']; ?>
				<?php if ($option_value['price']) { ?>
				(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
				<?php } ?>
			  </label>
			</div>
			<?php } ?>
		  </div>
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'image') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label"><?php echo $option['name']; ?></label>
		  <div id="input-option<?php echo $option['product_option_id']; ?>">
			<?php foreach ($option['product_option_value'] as $option_value) { ?>
			<div class="radio">
			  <label>
				<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
				<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
				<?php if ($option_value['price']) { ?>
				(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
				<?php } ?>
			  </label>
			</div>
			<?php } ?>
		  </div>
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'text') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
		  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'textarea') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
		  <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'file') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label"><?php echo $option['name']; ?></label>
		  <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
		  <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'date') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
		  <div class="input-group date">
			<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
			<span class="input-group-btn">
			<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
			</span></div>
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'datetime') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
		  <div class="input-group datetime">
			<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
			<span class="input-group-btn">
			<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
			</span></div>
		</div>
		<?php } ?>
		<?php if ($option['type'] == 'time') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
		  <div class="input-group time">
			<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
			<span class="input-group-btn">
			<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
			</span></div>
		</div>
		<?php } ?>
		<?php } ?>
		<?php } ?>
		<?php if ($recurrings) { ?>
		<hr>
		<h3><?php echo $text_payment_recurring ?></h3>
		<div class="form-group required">
		  <select name="recurring_id" class="form-control">
			<option value=""><?php echo $text_select; ?></option>
			<?php foreach ($recurrings as $recurring) { ?>
			<option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
			<?php } ?>
		  </select>
		  <div class="help-block" id="recurring-description"></div>
		</div>
		<?php } ?>
		<div class="form-group">
		  <label class="control-label" for="input-quantity"><?php echo $entry_qty; ?></label>
		  <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
		  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
		  <br />
		  <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block"><i class="fa fa-shopping-cart"></i> <?php echo $button_cart; ?></button>
		</div>
		<?php if ($minimum > 1) { ?>
		<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
		<?php } ?>
		<!--//AMBERU-->
		<!--IF FALSE-->
			<?php if (FALSE) { ?>
				<div class="amberu-btn-container">
					<button type="button" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i> <?php echo $button_wishlist; ?></button>
					<button type="button" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-bar-chart"></i> <?php echo $button_compare; ?></button>
				</div>
			<?php } ?>
		
	  </div>
	</div>
    <div role="tabpanel" class="tab-pane fade" id="amberu-modal-tabpanel-desc">
		<div class="amberu-tabpanel-inner"><?php echo $description; ?></div>
		<?php if ($attribute_groups) { ?>
		<div class="amberu-tabpanel-inner">
		  <table class="table table-bordered">
			<?php foreach ($attribute_groups as $attribute_group) { ?>
			<thead>
			  <tr>
				<td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
			  </tr>
			</thead>
			<tbody>
			  <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
			  <tr>
				<td><?php echo $attribute['name']; ?></td>
				<td><?php echo $attribute['text']; ?></td>
			  </tr>
			  <?php } ?>
			</tbody>
			<?php } ?>
		  </table>
		</div>
		<?php } ?>
	</div>
    <div role="tabpanel" class="tab-pane fade" id="amberu-modal-tabpanel-images">
	  
	</div>
  </div>

</div>

<script type="text/javascript"><!--
//AMBERU 
$(document).ready(function () {	
	
	//ajax product_images
	var product_id = <?php echo $product_id; ?>;
	$('.nav-tabs a[href="#amberu-modal-tabpanel-images"]').click(function () {
		var target = $('#amberu-modal-tabpanel-images');
		if ((target.attr('amberu-ajax') !== 'success') && (target.attr('amberu-ajax') !== 'sent')) {
			$.ajax({
				url: 'index.php?route=amberu/product/ajaxGetProductImages&product_id=<?php echo $product_id; ?>',
				//type: 'post',
				//data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
				dataType: 'json',
				beforeSend : function () {
					var spinnerWrapperHtml = '<div id ="amberu-spinner-wrapper" style="position: relative; height: 135px;"></div>';
					target.html(spinnerWrapperHtml);
					amberuSpinner.spinSpinner('#amberu-spinner-wrapper');
					target.attr('amberu-ajax', 'sent');
				},
				complete : function () {
					amberuSpinner.stopSpinner('#amberu-spinner-wrapper');
				},
				success: function(json) {
					amberuSpinner.stopSpinner('#amberu-spinner-wrapper');
					target.html(json['product_images_html']);
					//set duplicate option according to duplicated option
					$('select[amberu-duplicate*="input-option"]').each(function(index, el) {
						var duplicated = $('#' + $(el).attr('amberu-duplicate'));
						$(el).val(duplicated.val());
					});
					//set thumb according to option
					$('select[amberu-duplicate*="input-option"]').trigger('change');
					target.attr('amberu-ajax', 'success');
				},
				error: function(xhr, ajaxOptions, thrownError) {
					amberuSpinner.stopSpinner('#amberu-spinner-wrapper');
					//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					alert('ОШИБКА ПОДКЛЮЧЕНИЯ К СЕРВЕРУ');
					target.attr('amberu-ajax', 'error');
				}
			});
		}
	});
});
//END
//--></script> 

<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			
			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=amberu/ajax_multiprice',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));
						
						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}
				
				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}
				
				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}
			
			if (json['success']) {
				if (!json['cart_pricelist_number']) {
					amberuProductPageConfirmedAdd();
				}
				else {
					if (json['pricelist_number'] != json['cart_pricelist_number']) {
						{
							var modalValues = {
								'product_page' : true
							};
							amberuEasyModal.fill('#amberu-easy-modal-product-add', json['content'], 'Подтверждение действия', modalValues);
							amberuEasyModal.open('#amberu-easy-modal-product-add');
						}
					}
					else {
						amberuProductPageConfirmedAdd();
					}
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			alert('ОШИБКА ПОДКЛЮЧЕНИЯ К СЕРВЕРУ');
		}
	});
});
function amberuProductPageConfirmedAdd() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));
						
						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}
				
				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}
				
				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}
			
			if (json['success']) {
				//$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				
				$('#cart-total').html(json['total']);
				//amberu
				var cartTotalTabletHTML = json['total'].replace(/<br\s*\/>/ig, ' ');
				$('#cart-total-tablet').html(cartTotalTabletHTML);
				
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
				
				$('#cart > ul').load('index.php?route=common/cart/info ul li');
				
				//amberu
				amberuMyModal.fill('#amberu-my-modal-pop-up-info-default', 'Товар "' + json['amberu']['product_name'] + '" успешно добавлен в корзину.');
				amberuMyModal.open('#amberu-my-modal-pop-up-info-default', 4000);
			}
		}
	});
}
//--></script> 
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;
	
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
	
	$('#form-upload input[name=\'file\']').trigger('click');
	
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			
			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();
					
					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}
					
					if (json['success']) {
						alert(json['success']);
						
						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script> 
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
			$('#captcha').attr('src', 'index.php?route=tool/captcha#'+new Date().getTime());
			$('input[name=\'captcha\']').val('');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();
			
			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});

//AMBERU
$(document).ready(function() {
	$('.amberu-thumbnail').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
	$('.amberu-thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
//images-to-options realization
$('[id*="input-option"]').change(function(e) {
	var thumbSelector = $(this).attr('id') + '-value' + $(this).val();
	var popupImage = $('.' + thumbSelector + ' a').attr('href');
	var fullThumb = $('.' + thumbSelector + ' .amberu-full-thumb').attr('value');
	if (fullThumb) {
		$('.amberu-thumbnail li a').attr('href', popupImage);
		//$('.amberu-thumbnail li a img').attr('src', fullThumb);
		var productImage = $('.amberu-thumbnail li a img');
		$(productImage).fadeOut(500, function() {
			$(productImage).attr('src', fullThumb);
			$(productImage).fadeIn(500);
		});
	}
	//set duplicate option
	var duplicate = $("#" + $(this).attr('id') + "-duplicate");
	if (duplicate.length) {
		duplicate.val($(this).val());//use val() only if there is an options in select(but we know that there is)
		//$('#id option[value="val1"]').prop('selected', true);
	}
});

//--></script> 
