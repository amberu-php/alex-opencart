<?php if ($thumb || $images) { ?>
  
  <!--//AMBERU-->
  <ul class="thumbnails amberu-thumbnail">
	<?php if ($thumb) { ?>
	<li><a class="thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
	<?php } ?>
  </ul>
  <ul class="thumbnails amberu-thumbnails">  
	<?php if ($images) { ?>
	<?php foreach ($images as $image) { ?>
	<li class="image-additional <?php echo 'input-option' . $image['amberu_product_option_id'] . '-value' . $image['amberu_product_option_value_id']; ?>">
	  <a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> 
		<img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
		<div class="amberu-thumbnail-caption"><?php echo $image['amberu_option_value_name']; ?></div>
	  </a>
	  <input class="amberu-full-thumb" type="hidden" value="<?php echo $image['amberu_full_thumb']; ?>">
	  <!--images-preload-->
	  <img style="display: none;" src="<?php echo $image['amberu_full_thumb']; ?>" />
	</li>
	<?php } ?>
	<?php } ?>
  </ul>
  <!--//end-->
  
  <?php if ($options) { ?>
		<hr>
		<h3><?php echo $text_option; ?></h3>
		<?php foreach ($options as $option) { ?>
		<?php if ($option['type'] == 'select') { ?>
		<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
		  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
		  <select id="input-option<?php echo $option['product_option_id']; ?>-duplicate" amberu-duplicate="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
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
		<?php } ?>
	<?php } ?>
  
<?php } else { ?>
	<h3><?php echo $amberu_text_no_images; ?></h3>
<?php } ?>
<script type="text/javascript"><!--
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
$('[amberu-duplicate*="input-option"]').change(function(e) {
	var thumbSelector = $(this).attr('amberu-duplicate') + '-value' + $(this).val();
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
	//set option that has been duplicated
	$("#" + $(this).attr('amberu-duplicate')).val($(this).val());//use val() only if there is an options in select(but we know that there is)
	//$('#id option[value="val1"]').prop('selected', true);
});

//--></script>