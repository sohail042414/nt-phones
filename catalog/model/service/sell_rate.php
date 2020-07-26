<?php
class ModelServiceSellRate extends Model {

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

	public function getMobilePrice($data){

		$sql = "SELECT * FROM " . DB_PREFIX . "sell_rate WHERE product_id =".(int)$data['product_id']." AND  network_id =".(int)$data['network_id']." AND  grade_id =".(int)$data['grade_id']." AND  box =".(int)$data['box'];

		$query = $this->db->query($sql);

		return $query->row;

	}


	public function getRateById($sell_rate_id){

		$sql = "SELECT * FROM " . DB_PREFIX . "sell_rate WHERE sell_rate_id =".(int)$sell_rate_id;

		$query = $this->db->query($sql);

		return $query->row;

	}


}
