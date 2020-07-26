<?php
class ModelServicegrade extends Model {

	public function getGrade($grade_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "grade  WHERE grade_id = '" . (int)$grade_id . "'");

		return $query->row;
	}

	public function getGrades($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "grade ";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
