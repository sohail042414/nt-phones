<?php
class ModelServiceNetwork extends Model {

	public function getNetwork($network_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "network  WHERE network_id = '" . (int)$network_id . "'");

		return $query->row;
	}

	public function getNetworks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "network ";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
