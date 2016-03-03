<?php
class ModelReportProduct extends Model {
	public function getProductsViewed($data = array()) {
		$sql = "SELECT pd.name, p.model, p.viewed FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.viewed > 0 ORDER BY p.viewed DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalProductsViewed() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE viewed > 0");

		return $query->row['total'];
	}

	public function reset() {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = '0'");
	}

	public function getPurchased($data = array()) {
		$sql = "SELECT op.name, op.model, SUM(op.quantity) AS quantity, SUM((op.total + op.tax) * op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " GROUP BY op.model ORDER BY total DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalPurchased($data) {
		$sql = "SELECT COUNT(DISTINCT op.model) AS total FROM `" . DB_PREFIX . "order_product` op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	//amberu
	public function amberuGetSeparatelyByOrderProductId($data = array()) {
		$sql = "" 
			. " SELECT op.product_id, op.order_id, op.order_product_id, op.name, op.model, op.quantity, op.price, (op.total + op.tax) AS total"
			. " FROM " . DB_PREFIX . "order_product AS op"
			. " INNER JOIN `" . DB_PREFIX . "order` AS o ON (op.order_id = o.order_id)"
			//. " WHERE o.order_status_id > '0'"
			//. " ORDER BY op.order_id DESC"
		;
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		//$sql .= " GROUP BY op.model ORDER BY total DESC";
		$sql .=  " ORDER BY op.name ASC, op.order_product_id ASC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	private function amberuCookOptionStringForComparing($str = "") {
		$str = trim($str);
		$trailing_white_spaces_pattern = "/\s\s+/im";
		$str = preg_replace ( $trailing_white_spaces_pattern, " " , $str);
		$str = mb_strtolower($str, 'UTF-8');
		return $str;
	} 
	
	private function amberuGetEqualOptionsKey($data, $product) {
		//returns -1 if there is no product with equal options 
		$key = -1;
		
		//if there is no options in $product - finds first with no options in $data and returns it's key, otherwise returns -1
		if(count($product['options']) < 1) {
			foreach($data as $compared_key => $compared_product) {
				if(count($compared_product['options']) < 1) {
					return $compared_key;
				}
			}
			return -1;
		}
		
		foreach($data as $compared_key => $compared_product) {
			$key = $compared_key;
			//check if count of options equal.
			//Actually it's not a good idea, 'cause some options could not refer to a particular feature(size etc.) of product
			//but in particular store it is okay!
			if(count($compared_product['options']) != count($product['options'])) {
				$key = -1;
				continue;
			}
			//temp $product_options. Description is bellow
			$product_options = $product['options'];
			foreach($compared_product['options'] as $compared_option) {
				$option_equal = false;
				foreach($product_options as $product_option_key => $option) {
					//compares option name and value. Because values could be changed by administrator for option_id
					
					//trim, lowerCase etc. 
					$compared_option_name = $this->amberuCookOptionStringForComparing($compared_option['name']);
					$compared_option_value = $this->amberuCookOptionStringForComparing($compared_option['value']);
					$option_name = $this->amberuCookOptionStringForComparing($option['name']);
					$option_value = $this->amberuCookOptionStringForComparing($option['value']);
					
					
					if(($compared_option_name == $option_name) && ($compared_option_value == $option_value)) {
						$option_equal = true;
						//unset this option from temp array $product_options, so it could not be compared once more. Because this option is equal.
						unset($product_options[$product_option_key]);
						break;
					}
				}
				//break if at least one option of product not equal to some option of compared product 
				if(!$option_equal) {
					$key = -1;
					break;
				}
			}
			//break if all options equal
			if ($key > -1) {
				break;
			}
		}
		return $key;
	}
	
	private function amberuJoinProducts($target, $product) {
		$target['quantity'] = (int)$target['quantity'] + (int)$product['quantity'];
		$target['total'] = (float)$target['total'] + (float)$product['total'];
		return $target;
	}

	//prepares $joined_products. Fetches all products from id-key-arrays
	private function amberuFetchJoinedProducts($data) {
		$result = array();
		foreach($data as $id_key_array) {
			foreach($id_key_array as $product) {
				$result []= $product;
			}
		}
		return $result;
	}

	private function amberuJoinProductsByOptions($data) {
		$data = $this->amberuGetSeparatelyByOrderProductId($data);
		//result
		$joined_products = array();
		//model to get options
		$this->load->model('sale/order');
		foreach($data as $orders_product) {
			$options = $this->model_sale_order->getOrderOptions($orders_product['order_id'], $orders_product['order_product_id']);
			//unset all unnecessary fields for $options, that can't be joined
			foreach($options as $key => $option) {
				unset($options[$key]['order_option_id'], $options[$key]['order_id'], $options[$key]['order_product_id']);
			}
			//add options to product array
			$orders_product['options'] = $options;
			//unset all unnecessary fields for $orders_product, that can't be joined
			//price could be changed, so unset
			unset($orders_product['order_id'], $orders_product['order_product_id'], $orders_product['price']);
			//$joined_products is multidimensional array, with key as product_id on first dimension, and separated by options products as elements
			if(!isset($joined_products[$orders_product['product_id']])) {
				$joined_products[$orders_product['product_id']][] = $orders_product;
			} else {
				$equal_options_key = $this->amberuGetEqualOptionsKey($joined_products[$orders_product['product_id']], $orders_product);
				if($equal_options_key > -1) {
					$joined_products[$orders_product['product_id']][$equal_options_key] = 
						$this->amberuJoinProducts($joined_products[$orders_product['product_id']][$equal_options_key], $orders_product);
				} else {
					$joined_products[$orders_product['product_id']][] = $orders_product;
				}
			}
			
		}
		//prepares $joined_products. Fetches all products from id-key-arrays
		return $this->amberuFetchJoinedProducts($joined_products);
	}
	
	public function amberuGetPurchasedSeparatelyByOptions($data = array()) {
		//do not limit in sql, because it makes no sense here. Limit resulted array
		$start = isset($data['start']) ? (int)$data['start'] : 0;
		$limit = isset($data['limit']) ? (int)$data['limit'] : "unlimited";
		unset($data['start'], $data['limit']);
		$result = $this->amberuJoinProductsByOptions($data);
		$result = ($limit === "unlimited") ? $result : array_slice($result, $start, $limit);
		return $result;
	}
	
	public function amberuGetTotalPurchasedSeparatelyByOptions($data) {
		//do not limit, because it makes no sense here. Limit resulted array
		unset($data['start'], $data['limit']);
		$result = $this->amberuJoinProductsByOptions($data);
		$total = count($result);
		return $total;
	}
	
	public function amberuGetTotalPurchasedQuantity($data = array()) {
		$sql = "" 
			. " SELECT SUM(`op`.`quantity`) AS `total_quantity`" 
			. " FROM `" . DB_PREFIX . "order` AS `o` INNER JOIN `" . DB_PREFIX . "order_product` AS `op`" 
			. " ON `o`.`order_id` = `op`.`order_id`"; 
			//. " WHERE `o`.`order_status_id` > 0"; //adds bellow

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}



		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 1;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return  ( $query->row['total_quantity'] < 0 || is_null($query->row['total_quantity']) ) ? 0 : $query->row['total_quantity'];
	}
	//END
}