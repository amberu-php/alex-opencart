<?php
class ControllerDashboardSale extends Controller {
	public function index() {
		$this->load->language('dashboard/sale');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];

		$this->load->model('report/sale');

		$today = $this->model_report_sale->getTotalSales(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))));

		$yesterday = $this->model_report_sale->getTotalSales(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))));

		$difference = $today - $yesterday;

		if ($difference && $today) {
			$data['percentage'] = round(($difference / $today) * 100);
		} else {
			$data['percentage'] = 0;
		}

		//AMBERU
		//language
		$amberu_quantity_abbreviated = $this->language->get('amberu_quantity_abbreviated');
		
		//Get total purchased products quantity
		$this->load->model('report/product');
		
			//with built in method model_report_product->getPurchased()
			/*
			$amberu_purchased_products = $this->model_report_product->getPurchased();//you could not pass parameters
			$amberu_total = 0;
			foreach($amberu_purchased_products as $amberu_purchased_product) {
				$amberu_total += $amberu_purchased_product['quantity'];
			}
			*/
		
		//with amberu method amberuGetTotalPurchasedQuantity()
		$data['total'] = $this->model_report_product->amberuGetTotalPurchasedQuantity();//you could not pass parameters
		$data['total'] .= $amberu_quantity_abbreviated;
		
		//comment out $data['total'] assigned with total sales money amount 
		/*
		$sale_total = $this->model_report_sale->getTotalSales();

		if ($sale_total > 1000000000000) {
			$data['total'] = round($sale_total / 1000000000000, 1) . 'T';
		} elseif ($sale_total > 1000000000) {
			$data['total'] = round($sale_total / 1000000000, 1) . 'B';
		} elseif ($sale_total > 1000000) {
			$data['total'] = round($sale_total / 1000000, 1) . 'M';
		} elseif ($sale_total > 1000) {
			$data['total'] = round($sale_total / 1000, 1) . 'K';
		} else {
			$data['total'] = round($sale_total);
		}
		*/
		//END

		$data['sale'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');

		return $this->load->view('dashboard/sale.tpl', $data);
	}
}
