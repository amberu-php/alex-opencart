<?php
class ModelShippingAmberuShipping extends Model {
	function getQuote($address) {
		$this->load->language('shipping/amberu_shipping');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('amberu_shipping_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('amberu_shipping_title')) {
			$title = $this->config->get('amberu_shipping_title');
		}
		else {
			$title = $this->language->get('text_title');
		}
		
		if ($this->config->get('amberu_shipping_desc')) {
			$desc = $this->config->get('amberu_shipping_desc');
		}
		else {
			$desc = $this->language->get('text_description');
		}
		
		if (!$this->config->get('amberu_shipping_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		if ($this->cart->getSubTotal() < $this->config->get('amberu_shipping_total')) {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

			$quote_data['amberu_shipping'] = array(
				'code'         => 'amberu_shipping.amberu_shipping',
				'title'        => $title,
				'cost'         => 0.00,
				'tax_class_id' => 0,
				//'text'         => $this->currency->format(0.00)
				'text'         => $desc
			);

			$method_data = array(
				'code'       => 'amberu_shipping',
				'title'      => $title,
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('amberu_shipping_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}