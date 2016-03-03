<?php
class ControllerAmberuAjaxMultiprice extends Controller {
	public function index() {
		//product required fields // has to be first because json array has to be empty before finding required fields 
		$json = array();
		$this->load->language('checkout/cart');

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);
		

		if ($product_info) {
			if (isset($this->request->post['quantity'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}
			if (!$json) {	
				$json['success'] = true;
			}
			else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}
		//pricelists numbers
		$json['pricelist_number'] = 
			(isset($_SESSION['amberu_pricelists']['pricelist_number'])) ? $_SESSION['amberu_pricelists']['pricelist_number'] : 1;
		$json['cart_pricelist_number'] = 
			(isset($_SESSION['amberu_cart']['pricelist_number'])) ? $_SESSION['amberu_cart']['pricelist_number'] : 0;
		//$amberu_cart_count = $this->cart->countProducts();
		$customer_first_name = $this->customer->getFirstName() ? $this->customer->getFirstName() : 'Гость';
		//amberu_pricelist_array
		$this->load->model('setting/setting');
		$amberu_setting_config = $this->model_setting_setting->getSetting('config');
		$amberu_pricelists = $amberu_setting_config['config_amberu_pricelists'];
		$currency_symbols = array(
			'left' => $this->currency->getSymbolLeft(),
			'right' => $this->currency->getSymbolRight()
		);
		
		//if product isn't multiprice
		if (!$product_info['amberu_multiprice']) {
			//if product not_multiprice then assign pricelist_number according to cart pricelist_number
			//if cart_pricelist_number == 0/null - not a big deal, script will pass product to product add function
			$json['pricelist_number'] = $json['cart_pricelist_number'];
		}
		
		if ($json['cart_pricelist_number'] > 0) {
			$amberu_order_limits_text['cart_pricelist'] =  ($amberu_pricelists[$json['cart_pricelist_number']]['order_limit'] > 0) ? 'заказ от ' . $currency_symbols['left'] . $amberu_pricelists[$json['cart_pricelist_number']]['order_limit'] . $currency_symbols['right'] : 'Розница';
			$amberu_order_limits_text['pricelist'] =  ($amberu_pricelists[$json['pricelist_number']]['order_limit'] > 0) ? 'заказ от ' . $currency_symbols['left'] . $amberu_pricelists[$json['pricelist_number']]['order_limit'] . $currency_symbols['right'] : 'Розница';
			$this->load->language('amberu/multiprice');
			$amberu_content = $this->language->get('amberu_text_product_add_dialog');
			$json['content'] = sprintf($amberu_content, $customer_first_name, $amberu_order_limits_text['cart_pricelist'], $amberu_order_limits_text['pricelist']);
		}
		else {
			$json['content'] = '';
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>