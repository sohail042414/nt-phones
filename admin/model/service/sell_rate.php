<?php
class ModelServiceSellRate extends Model {
	public function addSellRate($data) {

		// echo '<pre>';
		// print_r($data);
		// exit; 

		foreach($data['prices'] as $grade_id => $price){

			$this->db->query("INSERT INTO " . DB_PREFIX . "sell_rate SET product_id = " . (int)$data['product_id'] . "
			, grade_id = " . (int)$grade_id." , price =".(int)$price.", box=1;");
			
			$price_without_box = $data['prices_without_box'][$grade_id];

			$this->db->query("INSERT INTO " . DB_PREFIX . "sell_rate SET product_id = " . (int)$data['product_id'] . "
			, grade_id = " . (int)$grade_id." , price =".(int)$price_without_box.", box=0 ;");
		}
		return true;
	}

	public function editSellRate($data) {	

		// echo '<pre>';
		// print_r($data);
		// exit; 

		$this->db->query("DELETE FROM " . DB_PREFIX . "sell_rate WHERE product_id =" . (int)$data['product_id']);

		foreach($data['prices'] as $grade_id => $price){

			$this->db->query("INSERT INTO " . DB_PREFIX . "sell_rate SET product_id = " . (int)$data['product_id'] . "
			, grade_id = " . (int)$grade_id." , price =".(int)$price.", box= 1;");
			
			$price_without_box = $data['prices_without_box'][$grade_id];

			$this->db->query("INSERT INTO " . DB_PREFIX . "sell_rate SET product_id = " . (int)$data['product_id'] . "
			, grade_id = " . (int)$grade_id." , price =".(int)$price_without_box." box=0 ;");
		}

		return true;
	}


	public function deleteSellRate($sell_rate_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "sell_rate WHERE sell_rate_id = '" . (int)$sell_rate_id . "'");
	}

	public function getSellRate($sell_rate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sell_rate  WHERE sell_rate_id = '" . (int)$sell_rate_id . "'");

		return $query->row;
	}


	public function getProductRates($product_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "sell_rate where product_id =".(int)$product_id;

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getSellRates($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "sell_rate ";

		$query = $this->db->query($sql);

		return $query->rows;
	}


	public function getTotalSellRates($data = array()) {
		$sql = "SELECT COUNT(DISTINCT product_id) AS total FROM " . DB_PREFIX . "sell_rate ";


		$query = $this->db->query($sql);

		return $query->row['total'];
	}


}
