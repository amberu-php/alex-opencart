<?php
class ControllerAmberuCartPricelistSelect extends Controller {
	public function index() {
		$data['amberu_current_href'] = $this->url->link((isset($this->request->get['route'])) ? 'checkout/cart' : 'common/home');
		$this->load->language('amberu/multiprice');
		$data['amberu_text_pre_order_limit'] = $this->language->get('amberu_text_pre_order_limit');
		$data['amberu_text_retail'] = $this->language->get('amberu_text_retail');
		$data['amberu_text_cart_pricelist'] = $this->language->get('amberu_text_cart_pricelist');
		$data['amberu_text_select_cart_pricelist'] = $this->language->get('amberu_text_select_cart_pricelist');
		//amberu_pricelist_array
		$this->load->model('setting/setting');
		$amberu_setting_config = $this->model_setting_setting->getSetting('config');
		$data['amberu_pricelists'] = $amberu_setting_config['config_amberu_pricelists'];
		$data['customer_group_id'] = $this->customer->getGroupId();
		$data['currency_symbols'] = array(
			'left' => $this->currency->getSymbolLeft(),
			'right' => $this->currency->getSymbolRight()
		);
		$data['amberu_cart']['multiprice'] = $_SESSION['amberu_cart']['pricelist_number'];
		$data['amberu_cart']['pricelist_number'] = $_SESSION['amberu_cart']['pricelist_number'];
		if ($data['amberu_cart']['multiprice'] > 0) {
			$data['amberu_cart']['order_limit'] = $data['amberu_pricelists'][$data['amberu_cart']['pricelist_number']]['order_limit'];
			$data['amberu_cart']['text_order_limit'] = 
				$this->currency->format($data['amberu_cart']['order_limit'], $this->currency->getCode(), 1, true);
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/amberu/cart_pricelist_select.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/amberu/cart_pricelist_select.tpl', $data);
		} else {
			return $this->load->view('default/template/amberu/cart_pricelist_select.tpl', $data);
		}
	}
}
?>