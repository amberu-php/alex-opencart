<?php
class ControllerAmberuPricelistSelect extends Controller {
	public function index() {
		//language
		$this->load->language('amberu/multiprice');
		$data['amberu_text_pricelist_select'] = $this->language->get('amberu_text_pricelist_select');
		$data['amberu_text_pricelist_current'] = $this->language->get('amberu_text_pricelist_current');
		//$data['amberu_text_pre_order_limit'] = $this->language->get('amberu_text_pre_order_limit');
		//data
		$data['amberu_pricelist_number'] = $this->session->data['amberu_pricelists']['pricelist_number'];
		$this->load->model('amberu/multiprice');
		$data['amberu_pricelists'] = $this->model_amberu_multiprice->getPricelists();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/amberu/pricelist_select.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/amberu/pricelist_select.tpl', $data);
		} else {
			return $this->load->view('default/template/amberu/pricelist_select.tpl', $data);
		}
	}
}
?>