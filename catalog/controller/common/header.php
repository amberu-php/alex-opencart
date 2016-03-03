<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$data['icon'] = '';
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');
		
		//AMBERU
		$data['amberu_currency_symbol_left'] = $this->currency->getSymbolLeft();
		$data['amberu_currency_symbol_right'] = $this->currency->getSymbolRight();
		
		$data['amberu_customer_group_id'] = $this->customer->getGroupId();
		
		$data['text_amberu_my_cart'] = $this->language->get('text_amberu_my_cart');
		$data['text_amberu_contacts'] = $this->language->get('text_amberu_contacts');
		
		//setting config
		$this->load->model('setting/setting');
		$amberu_setting_config = $this->model_setting_setting->getSetting('config');
		
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
		
		//amberu_pricelist_array
		$amberu_pricelists = $amberu_setting_config['config_amberu_pricelists'];
		//unset unavailable pricelists to user
		$amberu_keys_for_unset = array();
		foreach($amberu_pricelists as $amberu_key => $amberu_pricelist) { 
			if (($amberu_pricelist['customer_group_id'] != -1) && ($amberu_pricelist['customer_group_id'] != $data['amberu_customer_group_id'])) {
				$amberu_keys_for_unset[] = $amberu_key;
			}
		}
		foreach($amberu_keys_for_unset as $amberu_key) {
			unset($amberu_pricelists[$amberu_key]);
		}
		$data['amberu_pricelists'] = $amberu_pricelists;
		//END
		
		$data['text_home'] = $this->language->get('text_home');
		$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->customer->isLogged();
		//amberu
		if ($data['logged']) {
			$data['customer_first_name'] = $this->customer->getFirstName();
			if (mb_strlen($data['customer_first_name'],'UTF-8') > 25)
				$data['customer_first_name'] = mb_substr($data['customer_first_name'], 0, 22,'UTF-8') . '...';	
		}
		else {
			$data['customer_first_name'] = '';
		}
		
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}
								
				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id']),
					//amberu
						'amberu_multiprice' => $category['amberu_multiprice'] ? $category['amberu_multiprice'] : 0,
						//'amberu_pricelists' => $amberu_pricelists_array ? $amberu_pricelists_array : ''
						//'amberu_active_pricelist' => isset($_SESSION['amberu_pricelists'][$category['category_id']]) ? $_SESSION['amberu_pricelists'][$category['category_id']] : 0
					//end
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}