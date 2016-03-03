<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>

<!--<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>-->
<script src="catalog/view/javascript/jquery/jquery-1.11.2.min.js" type="text/javascript"></script>
<!--AMBERU-->
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/amberu/animate/animate.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.min.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/amberu/spin.js/amberu.spin.js.css">
<script type="text/javascript" src="catalog/view/javascript/amberu/spin.js/spin.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/amberu/spin.js/amberu.spin.js"></script>
<script type="text/javascript" src="catalog/view/javascript/amberu/amberu.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600&subset=cyrillic-ext,latin' rel='stylesheet' type='text/css'>

<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">

<!--AMBERU-->
<!--modal dialog-->
<link href="catalog/view/javascript/amberu/amberu.modal.css" rel="stylesheet" type="text/css" />
<!--product modal // easyModal-->
<div class="amberu-easy-modal" id="amberu-easy-modal-product">
	<div class="amberu-easy-modal-inner-wrapper">
	  <div class="amberu-easy-modal-title">
	  </div>
	  <div class="amberu-easy-modal-content">
		<div class="amberu-loading">Загрузка...</div>
	  </div>
	  <div class="amberu-easy-modal-control">
		<a class="amberu-easy-modal-btn-product-page btn btn-modal" value="#amberu-easy-modal-product" title="Страница товара">Страница товара</a>
		<button class="amberu-easy-modal-btn-close btn btn-modal" value="#amberu-easy-modal-product" title="Закрыть">Закрыть</button>
	  </div>
	  <input class="amberu-easy-modal-input-hidden" type="hidden" value="" />
	</div>
</div>

<!--product add modal // easyModal-->
<div class="amberu-easy-modal" id="amberu-easy-modal-product-add">
	<div class="amberu-easy-modal-inner-wrapper">
	  <div class="amberu-easy-modal-title">
	  </div>
	  <div class="amberu-easy-modal-content">
		<div class="amberu-loading">Загрузка...</div>
	  </div>
	  <div class="amberu-easy-modal-control">
		<button class="amberu-easy-modal-btn-product-add btn btn-warning" value="#amberu-easy-modal-product-add" title="Подтвердить">Подтвердить</button>
		<button class="amberu-easy-modal-btn-close btn btn-default" value="#amberu-easy-modal-product-add" title="Отмена">Отмена</button>
	  </div>
	  <input class="amberu-easy-modal-input-hidden" type="hidden" value="" />
	</div>
</div>

<!--pop-pup info modal // amberuModal-->
<div class="amberu-my-modal amberu-my-modal-pop-up-info" id="amberu-my-modal-pop-up-info-default">
	<div class="amberu-my-modal-inner-wrapper">
	  <div class="amberu-my-modal-title">
	  </div>
	  <div class="amberu-my-modal-content">
		<div class="amberu-loading">Загрузка...</div>
	  </div>
	  <div class="amberu-my-modal-control">
		<button class="amberu-my-modal-btn-close btn btn-danger amberu-btn-x" value="#amberu-my-modal-pop-up-info-default" title="Закрыть">X</button>
	  </div>
	  <input class="amberu-my-modal-input-hidden" type="hidden" value="" />
	</div>
</div>

<script type="text/javascript" src="catalog/view/javascript/amberu/jquery.easyModal/jquery.easyModal.js"></script>
<script type="text/javascript" src="catalog/view/javascript/amberu/amberu.modal.js"></script>
<!--END-->

<nav id="top" class="">
  <div class="container">
    <?php //echo $currency; ?>
    <?php //echo $language; ?>
		<div id="amberu-top-contact-container" class="amberu-top-cols amberu-top-cols-links">
			<span>
				<a class="amberu-top-links" href="<?php echo $contact; ?>">
					<!--<i class="fa fa-phone"></i>-->
					<img class="amberu-top-icons-img" src="image/amberu/icons/contact_w.png" />
					<span class="hidden-xs hidden-sm hidden-md amberu-top-links-caption">
						<?php 
							//echo $telephone;
							echo $text_amberu_contacts;
						?>
					</span>
				</a>
			</span>
		</div>
		<!--<div id="top-links" class="amberu-top-cols">!-->
		<div id="amberu-top-account-container" class="amberu-top-cols amberu-top-cols-links">

				<div class="dropdown amberu-dropdown">
					<a class="amberu-top-links" href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown">
						<!--<i class="fa fa-user"></i>-->
						<img class="amberu-top-icons-img" src="image/amberu/icons/account_w.png" />
						<span class="hidden-xs hidden-sm hidden-md amberu-top-links-caption"><?php echo $logged ? $customer_first_name : $text_account; ?></span> 
						<span class="caret"></span>
					</a>
						<ul class="dropdown-menu dropdown-menu-right">
							<?php if ($logged) { ?>
							<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
							<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
							<!--<li><a href="<?php //echo $transaction; ?>"><?php //echo $text_transaction; ?></a></li>
							<li><a href="<?php //echo $download; ?>"><?php //echo $text_download; ?></a></li>-->
							<li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
							<?php } else { ?>
							<li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
							<li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
							<?php } ?>
						</ul>
				</div>
				<div class="dropdown amberu-dropdown">
					<a class="amberu-top-links" href="<?php  ?>" title="<?php echo $text_amberu_my_cart; ?>" class="dropdown-toggle" data-toggle="dropdown">
						<!--<i class="fa fa-user"></i>--> 
						<img class="amberu-top-icons-img" src="image/amberu/icons/purchase_w.png" />
						<span class="hidden-xs hidden-sm hidden-md amberu-top-links-caption"><?php echo $text_amberu_my_cart; ?></span> 
						<span class="caret"></span>
					</a>
					  <ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>">
							<i class="fa fa-shopping-cart"></i> 
							<!--<img class="amberu-top-icons-dropdown-img" src="image/amberu/icons/cart.png"></img>-->
							<span class=""><?php echo $text_shopping_cart; ?></span>
						</a></li>
						<?php //if ($amberu_checkout_available) { ?>
						<li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>">
							<i class="fa fa-check"></i> 					
							<span class=""><?php echo $text_checkout; ?></span>
						</a></li>
						<?php //} ?>
						<!--
						<li><a href="<?php //echo $wishlist; ?>" id="wishlist-total" title="<?php //echo $text_wishlist; ?>">
							<i class="fa fa-heart-o"></i> 
							<span class=""><?php //echo $text_wishlist; ?></span>
						</a></li>
						-->
					  </ul>
				</div>
				

		</div>
		<div id="amberu-search-container" class="col-sm-5 amberu-top-cols"><?php echo $search; ?></div>
		
	
  </div>
</nav>

<header id="amberu-header">
  <div class="container">
    <div class="row amberu-row">
		<div id="amberu-alex-home-caption-container">
			<a id="amberu-alex-home-caption" href="<?php echo $home; ?>">Alex Group</a>
		</div>
    </div>
  </div>
</header>

<?php if ($categories) { ?>
<div id="amberu-menu-container-wrapper">
	<div id="amberu-menu-container" class="container">
		<div id="amberu-main-logo-container">
			<div id="logo">
			  <?php if ($logo) { ?>
			  <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" id="amberu-main-logo-img" class="img-responsive" /></a>
			  <?php } else { ?>
			  <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
			  <?php } ?>
			</div>
		</div>
		
		<nav id="menu" class="navbar">
			<div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_category; ?></span>
			  <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<!--<i class="fa fa-bars"></i>-->
				<img class="amberu-icon-img" src="image/amberu/icons/menu.png"/>
			  </button>
			</div>
			<!--AMBERU-->
			<div id="amberu-menu-categories" class="collapse navbar-collapse navbar-ex1-collapse">
			  <ul class="nav navbar-nav">
				<?php foreach ($categories as $category) { ?>
				<?php if (($category['amberu_multiprice']) && ($amberu_pricelists)) { ?>
						<li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle amberu-menu-first-a" data-toggle="dropdown"><?php echo $category['name']; ?></a>
							<div class="dropdown-menu">
								<div class="dropdown-inner">
									<ul class="list-unstyled">
									<div class="amberu-list-inner-title">Категории цен:</div>
				<?php				$amberu_pricelist_count = 0;//to count array. coz in controller array could changed and key could not be equal to count
									foreach($amberu_pricelists as $amberu_key => $amberu_pricelist) { 
										$amberu_pricelist_count++;
										if (($amberu_pricelist['customer_group_id'] == -1) || ($amberu_pricelist['customer_group_id'] == $amberu_customer_group_id)) { ?>
											<li <?php echo ($_SESSION['amberu_pricelists']['pricelist_number'] == $amberu_key) ? 'class="amberu-active"' : ''; ?>>
												<a href="<?php echo $category['href'],'&amberu_pricelist_number=',$amberu_key; ?>">
				<?php 								if ($amberu_pricelist['order_limit'] > 0) { ?>
														заказ от <?php 
															echo $amberu_currency_symbol_left, number_format($amberu_pricelist['order_limit'], 0, '.', ''), $amberu_currency_symbol_right; 
															/*
															if ($amberu_pricelist_count < count($amberu_pricelists)) {
																echo ' до ' .  $amberu_currency_symbol_left . number_format($amberu_pricelists[$amberu_key+1]['order_limit'], 0, '.', '') . $amberu_currency_symbol_right;
															}
															else {
																echo '';
															}
															*/
														?>
				<?php 								} else { ?>
														Розница
				<?php 								} ?>
												</a>
											</li>
				<?php 					} ?>	
				<?php 				} ?>
									</ul>
								</div>
							</div>
						</li>
				<?php 	//REMEMBER } - close symbol for if block has to be at the same row as else !!!!!!!!!!!!?>
				<?php } elseif ($category['children']) { ?>
				<li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle amberu-menu-first-a" data-toggle="dropdown"><?php echo $category['name']; ?></a>
				  <div class="dropdown-menu">
					<div class="dropdown-inner">
					  <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
					  <ul class="list-unstyled">
						<?php foreach ($children as $child) { ?>
						<li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
						<?php } ?>
					  </ul>
					  <?php } ?>
					</div>
					<a href="<?php echo $category['href']; ?>" class="see-all"><?php echo $text_all; ?> <?php echo $category['name']; ?></a> </div>
				</li>
				<?php } else { ?>
				<li><a class="amberu-menu-first-a" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
				<?php } ?>
				<?php } ?>
			  </ul>
			</div>
		</nav>
		
		<div id="amberu-cart-container" class="col-sm-3">	
			<?php echo $cart; ?>	
		</div>
		
	</div>
</div>
<?php } ?>
