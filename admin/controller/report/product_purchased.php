<?php
class ControllerReportProductPurchased extends Controller {
	public function index() {
		$this->load->language('report/product_purchased');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('report/product');

		$data['products'] = array();

		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		//AMBERU
		//invoice button
		$data['invoice'] = $this->url->link('report/product_purchased/invoice', 'token=' . $this->session->data['token'], 'SSL');
		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		//old
		//$product_total = $this->model_report_product->getTotalPurchased($filter_data);
		$product_total = $this->model_report_product->amberuGetTotalPurchasedSeparatelyByOptions($filter_data);
		
		//old
		//$results = $this->model_report_product->getPurchased($filter_data);
		$results = $this->model_report_product->amberuGetPurchasedSeparatelyByOptions($filter_data);

		//old
			/*
			foreach ($results as $result) {
				$data['products'][] = array(
					'name'       => $result['name'],
					'model'      => $result['model'],
					'quantity'   => $result['quantity'],
					'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
				);
			}
			*/
		
		foreach ($results as $result) {
			// fields:	SELECT op.order_id, op.product_id, op.name, op.model, op.quantity, op.price, (op.total + op.tax) AS total
			$data['products'][] = array(
				//'order_id'   => $result['order_id'],
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model'],
				'quantity'   => $result['quantity'],
				//'price'      => $result['price'],
				'total'      => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'options'	 => $result['options'],
			);
		}
		//END

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_all_status'] = $this->language->get('text_all_status');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_total'] = $this->language->get('column_total');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_order_status_id'] = $filter_order_status_id;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/product_purchased.tpl', $data));
	}

	//AMBERU
	public function invoice() {
		//language
		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$this->load->language('sale/order');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');

		$this->load->language('amberu/multiprice');
		$data['title'] = $this->language->get('amberu_text_invoice');
		$data['amberu_text_filters'] = $this->language->get('amberu_text_filters');
		$data['amberu_text_quantity_shortened'] = $this->language->get('amberu_text_quantity_shortened');
		$data['amberu_text_sku'] = $this->language->get('amberu_text_sku');
		$data['amberu_text_price'] = $this->language->get('amberu_text_price');
		$data['amberu_text_number'] = $this->language->get('amberu_text_number');
		$data['amberu_text_products_quantity'] = $this->language->get('amberu_text_products_quantity');
		$data['amberu_text_product_quantity_after'] = $this->language->get('amberu_text_product_quantity_after');

		$this->load->language('report/product_purchased');
		$data['text_all_status'] = $this->language->get('text_all_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_status'] = $this->language->get('entry_status');

		$this->load->model('localisation/order_status');
		$order_statuses = $this->model_localisation_order_status->getOrderStatuses();
		//assign order_statuses to key-id-array
		$data['order_statuses'] = array();
		foreach($order_statuses as $order_status) {
			$data['order_statuses'][$order_status['order_status_id']] = $order_status;
		}


		//filter
		if (isset($this->request->post['filter_date_start'])) {
			$filter_date_start = $this->request->post['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->post['filter_date_end'])) {
			$filter_date_end = $this->request->post['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->post['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->post['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}


		$data['products'] = array();

		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_order_status_id' => $filter_order_status_id,
		);
		$data['filter_data'] = $filter_data;
		//get products
		$data['products_total_quantity'] = 0;
		$data['products_total_total'] = 0;
		$this->load->model('report/product');
		$results = $this->model_report_product->amberuGetPurchasedSeparatelyByOptions($filter_data);
		foreach ($results as $result) {
			$data['products_total_quantity'] += $result['quantity'];
			$data['products_total_total'] += $result['total'];
			// fields:	SELECT op.order_id, op.product_id, op.name, op.model, op.quantity, op.price, (op.total + op.tax) AS total
			$data['products'][] = array(
				//'order_id'   => $result['order_id'],
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model'],
				'quantity'   => $result['quantity'],
				//'price'      => $result['price'],
				'total'      => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'options'	 => $result['options'],
			);
		}
		$data['products_total_total'] = $this->currency->format($data['products_total_total'], $this->config->get('config_currency'));
		$this->response->setOutput($this->load->view('report/product_purchased_invoice.tpl', $data));
	}
}