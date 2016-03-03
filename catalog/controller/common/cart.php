<?php
class ControllerCommonCart extends Controller {
	public function index() {
		$this->load->language('common/cart');

		//amberu
		//get cart_pricelist_select
		$data['amberu_cart_pricelist_select_view'] = $this->load->controller('amberu/common_cart_pricelist_select');
		//language
		$this->load->language('amberu/multiprice');
		$data['amberu_text_status'] = $this->language->get('amberu_text_status');
		$data['amberu_text_status_ready'] = $this->language->get('amberu_text_status_ready');
		$data['amberu_text_status_after_limit'] = $this->language->get('amberu_text_status_after_limit');
		
		// Totals
		$this->load->model('extension/extension');

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		
		// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}

			$sort_order = array();

			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $total_data);
		}

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_remove'] = $this->language->get('button_remove');

		$this->load->model('tool/image');
		$this->load->model('tool/upload');

		$data['products'] = array();

		foreach ($this->cart->getProducts() as $product) {
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
			} else {
				$image = '';
			}

			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

					if ($upload_info) {
						$value = $upload_info['name'];
					} else {
						$value = '';
					}
				}

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}

			$data['products'][] = array(
				'key'       => $product['key'],
				'thumb'     => $image,
				'name'      => $product['name'],
				'model'     => $product['model'],
				'option'    => $option_data,
				'recurring' => ($product['recurring'] ? $product['recurring']['name'] : ''),
				'quantity'  => $product['quantity'],
				'price'     => $price,
				'total'     => $total,
				'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
			);
		}
		
		//amberu // reset cart_pricelist_number if count($data['products']) == 0(if cart is empty)
		if (count($data['products']) == 0) {
			$_SESSION['amberu_cart']['pricelist_number'] = null;
		}
		
		// Gift Voucher
		$data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}

		$data['totals'] = array();

		//amberu //cut sub-total from $total_data
		foreach ($total_data as $amberu_key => $amberu_buffer) {
			if ($amberu_buffer['code'] == 'sub_total') {
				unset($total_data[$amberu_key]);
			}
		}
		$total_data = array_values($total_data);
		
		$amberu_total = $this->cart->getTotal();
		$amberu_total = $this->currency->format($amberu_total, '', '', false);
		//end
		
		foreach ($total_data as $result) {
			$data['totals'][] = array(
				'title' => $result['title'],
				'text'  => $this->currency->format($result['value']),
			);
		}
		
		//amberu
		//setting config
		$this->load->model('setting/setting');
		$amberu_setting_config = $this->model_setting_setting->getSetting('config');
		
		//checkout available
		$amberu_total = $this->cart->getTotal();
		$amberu_total = $this->currency->format($amberu_total, '', '', false);
		$amberu_cart['pricelist_number'] = isset($_SESSION['amberu_cart']['pricelist_number']) ? $_SESSION['amberu_cart']['pricelist_number'] : null;
		if ($amberu_cart['pricelist_number'] != null) {
			//$this->load->model('setting/setting');
			//$amberu_setting_config = $this->model_setting_setting->getSetting('config');
			$amberu_pricelists_array = $amberu_setting_config['config_amberu_pricelists'];
			$amberu_cart['order_limit'] = $amberu_pricelists_array[$_SESSION['amberu_cart']['pricelist_number']]['order_limit'];
		}
		else {
			$amberu_cart['order_limit'] = 0;
		}
		if ($amberu_total < $amberu_cart['order_limit']) {
			$data['amberu_checkout_available'] = false;
		}
		else {
			$data['amberu_checkout_available'] = true;
		}
		//
		
		$data['currency_symbols'] = array(
			'left' => $this->currency->getSymbolLeft(),
			'right' => $this->currency->getSymbolRight()
		);
		$data['amberu_cart']['pricelist_number'] = isset($_SESSION['amberu_cart']['pricelist_number']) ? $_SESSION['amberu_cart']['pricelist_number'] : null;
		if ($data['amberu_cart']['pricelist_number'] != null) {
			//$this->load->model('setting/setting'); 'coz done above
			//$amberu_setting_config = $this->model_setting_setting->getSetting('config');
			$amberu_pricelists_array = $amberu_setting_config['config_amberu_pricelists'];
			$data['amberu_cart']['order_limit'] = $amberu_pricelists_array[$_SESSION['amberu_cart']['pricelist_number']]['order_limit'];
			$data['amberu_cart']['order_limit_text'] = $data['currency_symbols']['left'] . $data['amberu_cart']['order_limit'] . $data['currency_symbols']['right'];
			if ($data['amberu_cart']['order_limit'] > 0) {
				$data['totals'][] = array(
					'title' => 'Ценовая категория',
					'text'  => 'заказ от ' . $data['amberu_cart']['order_limit_text'],
				);
				if($amberu_total >= $data['amberu_cart']['order_limit']) {
					$data['totals'][] = array(
						'title' => $data['amberu_text_status'],
						'text'  => $data['amberu_text_status_ready'],
					);
				}
				else {
					$data['totals'][] = array(
						'title' => $data['amberu_text_status'],
						'text'  => $data['currency_symbols']['left'] . (number_format($data['amberu_cart']['order_limit'] - $amberu_total, 2, '.', '')) . $data['currency_symbols']['right'] . $data['amberu_text_status_after_limit'],
					);
				}
				
			}
			else {
				$data['totals'][] = array(
					'title' => 'Ценовая категория',
					'text'  => 'Розница',
				);
				$data['totals'][] = array(
					'title' => $data['amberu_text_status'],
					'text'  => $data['amberu_text_status_ready'],
				);
			}
		}
		else {
			$data['amberu_cart']['order_limit'] = 0;
			$data['totals'][] = array(
				'title' => 'Ценовая категория',
				'text'  => 'Розница',
			);
			$data['totals'][] = array(
				'title' => $data['amberu_text_status'],
				'text'  => $data['amberu_text_status_ready'],
			);
		}
		//end

		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/cart.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/cart.tpl', $data);
		} else {
			return $this->load->view('default/template/common/cart.tpl', $data);
		}
	}

	public function info() {
		$this->response->setOutput($this->index());
	}
}