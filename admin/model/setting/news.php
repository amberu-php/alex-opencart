<?php
class ModelSettingNews extends Model {	
	private function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "marketinsg_news` (
		  `marketinsg_news_id` int(11) NOT NULL AUTO_INCREMENT,
		  `text` text COLLATE utf8_bin NOT NULL,
		  `date_added` datetime NOT NULL,
		  PRIMARY KEY (`marketinsg_news_id`)
		)");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "marketinsg_news_log` (
		  `marketinsg_news_log_id` int(11) NOT NULL AUTO_INCREMENT,
		  `date_checked` datetime NOT NULL,
		  `status` tinyint NOT NULL,
		  PRIMARY KEY (`marketinsg_news_log_id`)
		)");
	}
	
	private function call() {
		$curl = array(
			CURLOPT_POST => 0,
			CURLOPT_HEADER => 0,
			CURLOPT_URL => 'http://www.marketinsg.com/index.php?route=information/news/system&url=' . rawurlencode(HTTP_CATALOG),
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1', 
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0
		);
		
		$ch = curl_init();
		curl_setopt_array($ch, ($curl));
		
		if (!$result = curl_exec($ch)) {
			curl_close($ch);
			
			exit;
		}
		
		curl_close($ch);
		
		$encoding = mb_detect_encoding($result);

		if($encoding == 'UTF-8') {
			$result = preg_replace('/[^(\x20-\x7F)]*/','', $result);    
		} 
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "marketinsg_news WHERE text ='" . $this->db->escape($result) . "'");

		if (!$query->num_rows) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "marketinsg_news");
			$this->db->query("INSERT INTO " . DB_PREFIX . "marketinsg_news SET text ='" . $this->db->escape($result) . "', date_added = NOW()");
		}
		
		$disabled = '[{"title":"<strong>You have been disabled from MarketInSG.com news system<\/strong>"}]';
		
		if (addslashes($result) == addslashes($disabled)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "marketinsg_news_log SET date_checked = NOW(), status = 0");
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "marketinsg_news_log SET date_checked = NOW(), status = 1");
		}
	}
	
	public function getNews() {	
		$this->install();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "marketinsg_news_log ORDER BY marketinsg_news_log_id DESC LIMIT 0,1");
		
		if ($query->num_rows) {
			$last_checked = date('d M Y', strtotime($query->row['date_checked']));
			$today = date('d M Y');
			$status = $query->row['status'];
			
			if ($last_checked == $today) {
				// Don't call
			} else {
				if(!$status) {
					// Don't call
				} else {
					$this->call();
				}
			}
		} else {
			$this->call();
		}
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "marketinsg_news");
		
		return $query->row;
	}
}