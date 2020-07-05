<?php
class ModelServicegrade extends Model {
	public function addGrade($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "grade SET title = '" . $this->db->escape($data['title']) . "',description = '" . $this->db->escape($data['description'])."'");
		
		$product_id = $this->db->getLastId();

		return $product_id;
	}

	public function editGrade($grade_id, $data) {	
		$this->db->query("UPDATE " . DB_PREFIX . "grade SET title = '" . $this->db->escape($data['title']) . "',description = '" . $this->db->escape($data['description'])."' WHERE grade_id = '" . (int)$grade_id . "'");
	}


	public function deleteGrade($grade_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "grade WHERE grade_id = '" . (int)$grade_id . "'");
	}

	public function getGrade($grade_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "grade  WHERE grade_id = '" . (int)$grade_id . "'");

		return $query->row;
	}

	public function getGrades($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "grade ";

		$query = $this->db->query($sql);

		return $query->rows;
	}


	public function getTotalGrades($data = array()) {
		$sql = "SELECT COUNT(DISTINCT g.grade_id) AS total FROM " . DB_PREFIX . "grade g ";

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
