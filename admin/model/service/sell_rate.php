<?php
class ModelServiceSellRate extends Model {
	public function addSellRate($data) {


		$this->db->query("DELETE FROM " . DB_PREFIX . "sell_rate WHERE product_id =" . (int)$data['product_id']);


		foreach($data['sell_rate'] as  $record){

			$this->db->query("INSERT INTO " . DB_PREFIX . "sell_rate SET product_id = " . (int)$data['product_id'] . "
			, grade_id = " . (int)$record['grade_id']." , price =".(int)$record['price'].", box=".(int)$record['box'].", memory_id =".(int)$record['memory_id'].", network_id =".(int)$record['network_id']."");
			
		}
		return true;
	}

	public function editSellRate($data) {	


		// echo '<pre>edit';
		// print_r($data);
		// exit; 


		$this->db->query("DELETE FROM " . DB_PREFIX . "sell_rate WHERE product_id =" . (int)$data['product_id']);

		foreach($data['sell_rate'] as  $record){

			$this->db->query("INSERT INTO " . DB_PREFIX . "sell_rate SET product_id = " . (int)$data['product_id'] . "
			, grade_id = " . (int)$record['grade_id']." , price =".(int)$record['price'].", box=".(int)$record['box'].", memory_id =".(int)$record['memory_id'].", network_id =".(int)$record['network_id']."");			
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
