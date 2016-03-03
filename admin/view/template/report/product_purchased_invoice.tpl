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
<style type="text/css">
    #amberu-order-invoice-container {
        margin-top: 10px;
    }
    #amberu-filters-container * {
        display: inline-block;
        border-right: 1px solid #000;
        padding: 0px 5px;
    }
    #amberu-filters-container *:first-child,  #amberu-filters-container *:last-child {
        border: none;
    }
</style>
<div class="container" id="amberu-order-invoice-container">
    <h3><?php echo $title; ?></h3>
    <div id="amberu-filters-container">
    <?php
        echo "<h5>" . $amberu_text_filters . " => </h5>";
        echo (!empty($filter_data['filter_date_start'])) ? "<h5>" . $entry_date_start . ": " . $filter_data['filter_date_start'] . "</h5>" : "";
        echo (!empty($filter_data['filter_date_end'])) ? "<h5>" . $entry_date_end . ": " . $filter_data['filter_date_end'] . "</h5>" : "";
        echo  "<h5>" . $entry_status . ": "
            . ($filter_data['filter_order_status_id'] > 0 ?
                $order_statuses[$filter_data['filter_order_status_id']]['name'] : $text_all_status)
            . "</h5>";
    ?>
    </div>

	<table class="table table-bordered tablesorter amberu-products-table">
		<thead>
		<tr>
			<th><b><?php echo $amberu_text_number; ?></b></th>
			<th data-sorter="text"><b><?php echo $column_model; ?></b></th>
			<th data-sorter="text"><b><?php echo $column_product; ?></b></th>
			<th data-sorter="text"><b><?php echo $amberu_text_quantity_shortened; ?></b></th>
			<th data-sorter="text"><b><?php echo $column_total; ?></b></th>
		</tr>
		</thead>
        <tfoot>
          <tr>
            <td class="text-right" colspan="3"><b><?php echo $amberu_text_products_quantity; ?></b></td>
            <td class="text-right" colspan="1"><?php echo $products_total_quantity . ' ' . $amberu_text_product_quantity_after; ?></td>
            <td class="text-right"><?php echo $products_total_total; ?></td>
          </tr>
        </tfoot>
		<tbody>
		<?php $amberu_product_count = 0; ?>
		<?php foreach ($products as $product) { ?>
			<tr>
				<td><?php echo ++$amberu_product_count; ?></td>
				<td><?php echo $product['model']; ?></td>
				<td><?php echo $product['name']; ?>
					<?php foreach ($product['options'] as $option) { ?>
						<small> - <?php echo $option['value']; ?></small>
					<?php } ?>
				</td>
				<td class="text-right"><?php echo $product['quantity'] . ' ' . $amberu_text_product_quantity_after; ?></td>
				<td class="text-right"><?php echo $product['total']; ?></td>
			</tr>
		<?php } ?>

		</tbody>
	</table>
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