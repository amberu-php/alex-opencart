<?php
class ModelAmberuMultiprice extends Model {
	public function getPricelists() {
		//language
		$this->load->language('amberu/multiprice');
		$amberu_text_order_limit = $this->language->get('amberu_text_order_limit');
		$amberu_text_retail = $this->language->get('amberu_text_retail');
		//data
		$customer_group_id = $this->customer->getGroupId();
		$this->load->model('setting/setting');
		$amberu_setting_config = $this->model_setting_setting->getSetting('config');
		$amberu_pricelists = $amberu_setting_config['config_amberu_pricelists'];
		$result = array();
		foreach ($amberu_pricelists as $amberu_key => $amberu_pricelist) {
			if(($amberu_pricelist['customer_group_id'] == -1) || ($amberu_pricelist['customer_group_id'] == $customer_group_id)) {	
				if ($amberu_pricelist['order_limit'] > 0) {
					$amberu_pricelist['order_limit'] = $this->currency->format($amberu_pricelist['order_limit'], $this->currency->getCode(), 1, true);
					$amberu_pricelists[$amberu_key]['order_limit_value_text'] = $amberu_pricelist['order_limit'];
					$amberu_pricelist['order_limit'] = sprintf($amberu_text_order_limit, $amberu_pricelist['order_limit']);
					$amberu_pricelists[$amberu_key]['order_limit_text'] = $amberu_pricelist['order_limit'];
				}
				else {
					$amberu_pricelist['order_limit'] = $this->currency->format($amberu_pricelist['order_limit'], $this->currency->getCode(), 1, true);
					$amberu_pricelists[$amberu_key]['order_limit_value_text'] = $amberu_pricelist['order_limit'];
					$amberu_pricelists[$amberu_key]['order_limit_text'] = $amberu_text_retail;
				}
				$result[$amberu_key] = $amberu_pricelists[$amberu_key];
			}
		}
		return $result;
	}
}