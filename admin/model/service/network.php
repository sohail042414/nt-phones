<?php
class ModelServiceNetwork extends Model {
	public function addNetwork($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "network SET name = '" . $this->db->escape($data['name']) . "'");
		
		$product_id = $this->db->getLastId();

		return $product_id;
	}

	public function editNetwork($network_id, $data) {	
		$this->db->query("UPDATE " . DB_PREFIX . "network SET name = '" . $this->db->escape($data['name']) . "' WHERE network_id = '" . (int)$network_id . "'");
	}


	public function deleteNetwork($network_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "network WHERE network_id = '" . (int)$network_id . "'");
	}

	public function getNetwork($network_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "network  WHERE network_id = '" . (int)$network_id . "'");

		return $query->row;
	}

	public function getNetworks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "network ";

		$query = $this->db->query($sql);

		return $query->rows;
	}


	public function getTotalNetworks($data = array()) {
		$sql = "SELECT COUNT(DISTINCT g.network_id) AS total FROM " . DB_PREFIX . "network g ";

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
