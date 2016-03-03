<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />

<!--//AMBERU-->
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<link href="view/javascript/amberu/jquery.tablesorter/themes/amberu/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/amberu/jquery.tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="all" />
</head>
<body>
<!--//AMBERU-->
<div class="container" id="amberu-order-invoice-container">
  <div id="amberu-top">
    <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="amberu-main-logo-img" class="img-responsive" />
    <h1><?php echo $name; ?></h1>
  </div>
  <?php foreach ($orders as $order) { ?>
  <div class="amberu-order-container" style="page-break-after: always;">
    <div class="amberu-container-left">
	<div class="amberu-header">
	  <div class="amberu-store-details">
		<table class="table table-bordered">
		  <thead>
			  <tr>
				<td><strong><?php echo $order['store_name']; ?></strong></td>
				<td><b><?php echo $text_telephone; ?></b></td>
				<?php if ($order['store_fax']) { ?>
				<td><b><?php echo $text_fax; ?></b></td>
				<?php } ?>
				<td><b><?php echo $text_email; ?></b></td>
				<td><b><?php echo $text_website; ?></b></td>			
			  </tr>
		  </thead>
		  <tbody>
			  <tr>
				<td><?php echo $order['store_address']; ?></td>
				<td><?php echo $order['store_telephone']; ?></td>
				<?php if ($order['store_fax']) { ?>
				<td> <?php echo $order['store_fax']; ?></td>
				<?php } ?>
				<td><?php echo $order['store_email']; ?></td>
				<td><a href="<?php echo $order['store_url']; ?>"><?php echo $order['store_url']; ?></a></td>
			  </tr>
		  </tbody>
		</table>
	  </div>
    </div>
	<h3><?php echo $text_invoice; ?> №<?php echo $order['order_id']; ?></h3>
	<div class="amberu-multiprice-container">
		<span class="amberu-table-header">
		<?php echo $amberu_text_pricelist_number . ' - ' . $order['amberu_order_limit_text']; ?>
		</span>
	</div>
    <table class="table table-bordered tablesorter amberu-products-table">
      <thead>
        <tr>
		  <th><b><?php echo $amberu_text_number; ?></b></th>
          <th data-sorter="text"><b><?php echo $column_model; ?></b></th>
		  <th data-sorter="text"><b><?php echo $column_product; ?></b></th>
          <th data-sorter="text"><b><?php echo $amberu_text_quantity_shortened; ?></b></th>
          <th data-sorter="text"><b><?php echo $amberu_text_price; ?></b></th>
          <th data-sorter="text"><b><?php echo $column_total; ?></b></th>
        </tr>
      </thead>
	  <tfoot>
	    <tr>
          <td class="text-right" colspan="3"><b><?php echo $amberu_text_products_quantity; ?></b></td>
          <td class="text-right"><?php echo $order['amberu_products_quantity'] . ' ' . $amberu_text_product_quantity_after; ?></td>
        </tr>
        <?php foreach ($order['voucher'] as $voucher) { ?>
        <tr>
          <td><?php echo $voucher['description']; ?></td>
          <td></td>
          <td class="text-right">1</td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($order['total'] as $total) { ?>
        <tr>
          <td class="text-right" colspan="5"><b><?php echo $total['title']; ?></b></td>
          <td class="text-right"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
	  </tfoot>
      <tbody>
	    <?php $amberu_product_count = 0; ?>
        <?php foreach ($order['product'] as $product) { ?>
        <tr>
          <td><?php echo ++$amberu_product_count; ?></td>
		  <td><?php echo $product['model']; ?></td>
		  <td><?php echo $product['name']; ?>
            <?php foreach ($product['option'] as $option) { ?>
            <!--<br />
            &nbsp;<small> - <?php //echo $option['name']; ?>: <?php //echo $option['value']; ?></small>
			-->
			<small> - <?php echo $option['value']; ?></small>
            <?php } ?></td>
          <td class="text-right"><?php echo $product['quantity'] . ' ' . $amberu_text_product_quantity_after; ?></td>
          <td class="text-right"><?php echo $product['price']; ?></td>
          <td class="text-right"><?php echo $product['total']; ?></td>
        </tr>
        <?php } ?>
		
      </tbody>
    </table>

	</div>
	<div class="amberu-container-right">
    <table class="table table-bordered">
      <thead>
        <tr>
          <td colspan="2"><?php echo $text_order_detail; ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
		  <tr>
            <td><b><?php echo $text_date_added; ?></b></td>
		    <td><?php echo $order['date_added']; ?></td>
		  </tr>
		  <?php if ($order['invoice_no']) { ?>
		  <tr>
            <td><b><?php echo $text_invoice_no; ?></b></td>
		    <td><?php echo $order['invoice_no']; ?></td>
		  </tr>
		  <?php } ?>
		  <tr>
            <td><b><?php echo $text_order_id; ?></b></td>
		    <td><?php echo $order['order_id']; ?><br /></td>
		  </tr>
		  <tr>
            <td><b><?php echo $text_payment_method; ?></b></td>
		    <td><?php echo $order['payment_method']; ?><br /></td>
		  </tr>
		  <?php if ($order['shipping_method']) { ?>
		  <tr>
            <td><b><?php echo $text_shipping_method; ?></b></td>
		    <td><?php echo $order['shipping_method']; ?></td>
		  </tr>
		  <?php } ?>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td colspan="2"><b><?php echo $amberu_text_ship_to; ?></b></td>
        </tr>
		<!--
		<tr>
          <td style="width: 50%;"><b><?php //echo $text_to; ?></b></td>
          <td style="width: 50%;"><b><?php /*echo $text_ship_to;*/ //echo $amberu_text_ship_to; ?></b></td>
        </tr>
		-->
      </thead>
      <tbody>
        <tr>
		  <tr>
            <td><b><?php echo $text_customer; ?></b></td>
		    <td><?php echo $order['amberu_customer_name']; ?></td>
		  </tr>
		  <tr>
            <td><b><?php echo $text_telephone; ?></b></td>
		    <td><?php echo $order['telephone']; ?></td>
		  </tr>
		  <tr>
            <td><b><?php echo $text_email; ?></b></td>
		    <td><?php echo $order['email']; ?></td>
		  </tr>
		  <tr>
            <td><b><?php echo $text_country; ?></b></td>
		    <td><?php echo $order['amberu_shipping_country']; ?></td>
		  </tr>
		  <tr>
            <td><b><?php echo $text_city; ?></b></td>
		    <td><?php echo $order['amberu_shipping_city']; ?></td>
		  </tr>
		  <tr>
            <td><b><?php echo $text_zone; ?></b></td>
		    <td><?php echo $order['amberu_shipping_zone']; ?></td>
		  </tr>
		  <?php if ($order['amberu_shipping_address_2']) { ?>
		  <tr>
            <td><b><?php echo $text_postcode; ?></b></td>
		    <td><?php echo $order['amberu_shipping_postcode']; ?></td>
		  </tr>
		  <?php } ?>
		  <tr>
            <td><b><?php echo $text_address_1; ?></b></td>
		    <td><?php echo $order['amberu_shipping_address_1']; ?></td>
		  </tr>
		  <?php if ($order['amberu_shipping_address_2']) { ?>
		  <tr>
            <td><b><?php echo $text_address_2; ?></b></td>
		    <td><?php echo $order['amberu_shipping_address_2']; ?></td>
		  </tr>
		  <?php } ?>
		</tr>
		<!--
		<tr>
           <td><address>
            <?php //echo $order['payment_address']; ?>
            </address></td>
          <td>
            <?php //echo $order['shipping_address']; ?>
		  </td>
        </tr>
		-->
      </tbody>
    </table>
	<?php if ($order['comment']) { ?>
	<table class="table table-bordered">
		<thead>
		<tr>
			<td><b><?php echo $column_comment; ?></b></td>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td><?php echo $order['comment']; ?></td>
		</tr>
		</tbody>
	</table>
	<?php } ?>
	</div>
  </div>
  <?php } ?>
</div>

<!--//AMBERU-->
<script  type="text/javascript">
	$(document).ready(function() { 
        $(".amberu-products-table").tablesorter({ 
			// pass the headers argument and assing a object 
			headers: { 
				// assign the secound column (we start counting zero) 
				0: {
					// disable it by setting the property sorter to false 
					sorter: false 
				},
			}
		});
		$(".amberu-products-table").on("sortEnd", function(e) {
			$(e.delegateTarget).find("tbody tr").each(function( index, element ) {
				element.children[0].innerHTML = index + 1;
			});
		});
    });
</script>
<!--//END AMBERU-->
</body>
</html>