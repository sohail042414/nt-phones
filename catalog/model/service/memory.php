<?php
class ModelServiceMemory extends Model {


	public function getMemory($memory_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "memory  WHERE memory_id = '" . (int)$memory_id . "'");

		return $query->row;
	}

	public function getMemories($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "memory ";

		$query = $this->db->query($sql);

		return $query->rows;
	}


}
