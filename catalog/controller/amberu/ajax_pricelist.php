<?php
class ControllerAmberuAjaxPricelist extends Controller {
	public function index() {
		header("content-type:application/json");
		$result = array();
		$result['pricelist_number'] = 
			(isset($_SESSION['amberu_pricelists']['pricelist_number'])) ? $_SESSION['amberu_pricelists']['pricelist_number'] : -1;
		$result = json_encode($result);
		echo $result;
	}
}
?>