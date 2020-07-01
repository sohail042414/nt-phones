<?php
class ModelServiceRepairRate extends Model {
	public function addRepairRate($data) {

		foreach($data['prices'] as $issue_id => $price){
			$this->db->query("INSERT INTO " . DB_PREFIX . "repair_rate SET product_id = " . (int)$data['product_id'] . "
			, issue_id = " . (int)$issue_id." , price =".(int)$price." ;");
		}

		return true;
	}

	public function editRepairRate($data) {	

		$this->db->query("DELETE FROM " . DB_PREFIX . "repair_rate WHERE product_id =" . (int)$data['product_id']);

		foreach($data['prices'] as $issue_id => $price){
			$this->db->query("INSERT INTO " . DB_PREFIX . "repair_rate SET product_id = " . (int)$data['product_id'] . "
			, issue_id = " . (int)$issue_id." , price =".(int)$price." ;");
		}
		return true;
	}




	public function deleteRepairRate($repair_rate_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "repair_rate WHERE repair_rate_id = '" . (int)$repair_rate_id . "'");
	}

	public function getRepairRate($repair_rate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "repair_rate  WHERE repair_rate_id = '" . (int)$repair_rate_id . "'");

		return $query->row;
	}


	public function getProductRates($product_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "repair_rate where product_id =".(int)$product_id;

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getRepairRates($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "repair_rate ";

		$query = $this->db->query($sql);

		return $query->rows;
	}


	public function getTotalRepairRates($data = array()) {
		$sql = "SELECT COUNT(DISTINCT i.repair_rate_id) AS total FROM " . DB_PREFIX . "repair_rate i ";

		/*
		if (!empty($data['filter_title'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && $data['filter_quantity'] !== '') {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		*/

		$query = $this->db->query($sql);

		return $query->row['total'];
	}


}
