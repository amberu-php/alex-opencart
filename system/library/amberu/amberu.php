<?php
//$_GET amberu_pricelist_number
function amberuSetSessionPricelist($amberu_pricelists_array, $amberu_customer_group_id) {
	if (isset($_GET['amberu_pricelist_number'])) {
		//$this->load->model('setting/setting');
		//$amberu_setting_config = $this->model_setting_setting->getSetting('config');
		//$amberu_pricelists_array = $amberu_setting_config['config_amberu_pricelists'];
		//$amberu_customer_group_id = $this->customer->getGroupId();
		if (($_GET['amberu_pricelist_number'] > count($amberu_pricelists_array)) || ($_GET['amberu_pricelist_number'] < 1)) {
			$_SESSION['amberu_pricelists']['pricelist_number'] = 1;
		}
		elseif ($amberu_customer_group_id != $amberu_pricelists_array[$_GET['amberu_pricelist_number']]['customer_group_id']) {
			if ($amberu_pricelists_array[$_GET['amberu_pricelist_number']]['customer_group_id'] == -1)
				$_SESSION['amberu_pricelists']['pricelist_number'] = $_GET['amberu_pricelist_number'];
			else
				$_SESSION['amberu_pricelists']['pricelist_number'] = 1;
		}
		else {
			$_SESSION['amberu_pricelists']['pricelist_number'] = $_GET['amberu_pricelist_number'];
		}
	}
	//check if isset. if false set pricelist_number = 1;
	else {
		$_SESSION['amberu_pricelists']['pricelist_number'] = isset($_SESSION['amberu_pricelists']['pricelist_number']) ? $_SESSION['amberu_pricelists']['pricelist_number'] : 1;
	}
}

function amberuSetSessionCart($amberu_pricelists_array, $amberu_customer_group_id) {
	if (isset($_GET['amberu_cart_p_n'])) {
		if (($_GET['amberu_cart_p_n'] > count($amberu_pricelists_array)) || ($_GET['amberu_cart_p_n'] < 1)) {
			$_SESSION['amberu_cart']['pricelist_number'] = null;
		}
		elseif ($amberu_customer_group_id != $amberu_pricelists_array[$_GET['amberu_cart_p_n']]['customer_group_id']) {
			if ($amberu_pricelists_array[$_GET['amberu_cart_p_n']]['customer_group_id'] == -1)
				$_SESSION['amberu_cart']['pricelist_number'] = $_GET['amberu_cart_p_n'];
			else
				$_SESSION['amberu_cart']['pricelist_number'] = null;
		}
		else {
			$_SESSION['amberu_cart']['pricelist_number'] = $_GET['amberu_cart_p_n'];
		}
	}
	//check if isset. if false set amberu_cart pricelist_number = null;
	else {
		$_SESSION['amberu_cart']['pricelist_number'] = isset($_SESSION['amberu_cart']['pricelist_number']) ? $_SESSION['amberu_cart']['pricelist_number'] : null;
	}
}

//make_comparer - to compare multidimensional arrays. LINK : http://stackoverflow.com/questions/96759/how-do-i-sort-a-multidimensional-array-in-php/16788610#16788610
function make_comparer() {
    // Normalize criteria up front so that the comparer finds everything tidy
    $criteria = func_get_args();
    foreach ($criteria as $index => $criterion) {
        $criteria[$index] = is_array($criterion)
            ? array_pad($criterion, 3, null)
            : array($criterion, SORT_ASC, null);
    }

    return function($first, $second) use (&$criteria) {
        foreach ($criteria as $criterion) {
            // How will we compare this round?
            list($column, $sortOrder, $projection) = $criterion;
            $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

            // If a projection was defined project the values now
            if ($projection) {
                $lhs = call_user_func($projection, $first[$column]);
                $rhs = call_user_func($projection, $second[$column]);
            }
            else {
                $lhs = $first[$column];
                $rhs = $second[$column];
            }

            // Do the actual comparison; do not return if equal
            if ($lhs < $rhs) {
                return -1 * $sortOrder;
            }
            else if ($lhs > $rhs) {
                return 1 * $sortOrder;
            }
        }

        return 0; // tiebreakers exhausted, so $first == $second
    };
}
//return correct substr for unucode(cyrillic)
//NOTE: seems like substr($str, $s, $l, 'UTF-8') do the same well
function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
?>